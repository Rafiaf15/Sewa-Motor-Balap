<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\JokiController;
use App\Http\Controllers\CheckoutController;

Route::view('/', 'dashboard');

// Motor routes
Route::controller(\App\Http\Controllers\MotorController::class)->group(function () {
    Route::get('/motor', 'index')->name('motor.motorbalap');
    Route::get('/motor/search', 'search')->name('motor.search');
    Route::get('/motor/normal/{variant}', 'normalVariant')
        ->where('variant', 'matic|sport|bebek')
        ->name('motor.normal.variant');
    Route::get('/motor/{category}', 'category')
        ->where('category', 'balap|normal')
        ->name('motor.category');
});

Route::controller(JokiController::class)->group(function () {
    Route::get('/joki', 'index')->name('joki.penjoki');
    Route::get('/joki/search', 'search')->name('joki.search');
    Route::get('/joki/{category}', 'category')
        ->where('category', 'pemula|menengah|expert')
        ->name('joki.category');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // User routes
    Route::get('/dashboard', function () {
        if (auth()->user() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // Profile routes (edit & update)
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/kyc/ktp/delete', [\App\Http\Controllers\ProfileController::class, 'deleteKtp'])->name('profile.kyc.ktp.delete');
    Route::post('/profile/kyc/simc/delete', [\App\Http\Controllers\ProfileController::class, 'deleteSimc'])->name('profile.kyc.simc.delete');

    // Cart (keranjang) - only for authenticated users
    Route::get('/keranjang', function () {
        return view('pembayaran.keranjang');
    })->name('pembayaran.keranjang');

    // Cart management
    Route::post('/cart/remove', function (\Illuminate\Http\Request $request) {
        $key = $request->input('key');
        $cart = session()->get('cart', []);
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
            
            // Update DB cart if authenticated
            if (auth()->check()) {
                \App\Models\Cart::updateOrCreate(
                    ['user_id' => auth()->id()],
                    ['data' => $cart]
                );
            }
        }
        return back()->with('success', 'Item dihapus dari keranjang.');
    })->name('cart.remove');
    
    Route::post('/cart/clear', function (\Illuminate\Http\Request $request) {
        session()->forget('cart');
        
        // Clear DB cart if authenticated
        if (auth()->check()) {
            \App\Models\Cart::where('user_id', auth()->id())->delete();
        }
        return back()->with('success', 'Keranjang dikosongkan.');
    })->name('cart.clear');

    // Checkout & Payment (require KYC)
    Route::middleware('kyc')->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('pembayaran.checkout');
        Route::post('/pay', [CheckoutController::class, 'pay'])->name('pembayaran.pay');
        Route::post('/pay/complete', [CheckoutController::class, 'complete'])->name('pembayaran.complete');

        // Add to cart (auth protected so guests will be redirected to login)
        Route::post('/cart/add', function (\Illuminate\Http\Request $request) {
            $data = $request->validate([
                'id' => ['required'],
                'type' => ['required'],
                'name' => ['required'],
                'price' => ['required', 'numeric'],
                'qty' => ['nullable', 'integer', 'min:1'],
                'redirect' => ['nullable', 'string'],
            ]);

            // Check availability from DB to prevent renting unavailable items
            if ($data['type'] === 'motor') {
                $motor = \App\Models\Motor::find($data['id']);
                if (!$motor || !$motor->available) {
                    return back()->with('error', 'Unit motor tidak tersedia untuk disewa.');
                }
            } elseif ($data['type'] === 'joki') {
                $joki = \App\Models\Joki::find($data['id']);
                if (!$joki || !$joki->available) {
                    return back()->with('error', 'Joki tidak tersedia untuk disewa.');
                }
            }

            // Cek active rentals: jika sudah punya 2 motor + 2 joki aktif, block
            if (auth()->check()) {
                $activeMotor = \App\Models\Order::where('user_id', auth()->id())
                    ->where('item_type', 'motor')
                    ->whereIn('status', ['active', 'pending', 'paid'])
                    ->count();
                
                $activeJoki = \App\Models\Order::where('user_id', auth()->id())
                    ->where('item_type', 'joki')
                    ->whereIn('status', ['active', 'pending', 'paid'])
                    ->count();

                if ($data['type'] === 'motor' && $activeMotor >= 2) {
                    return back()->with('error', 'Anda sudah memiliki 2 motor aktif. Selesaikan penyewaan sebelumnya untuk meminjam lagi.');
                }
                
                if ($data['type'] === 'joki' && $activeJoki >= 2) {
                    return back()->with('error', 'Anda sudah memiliki 2 penjoki aktif. Selesaikan penyewaan sebelumnya untuk meminjam lagi.');
                }
            }

            $qty = $data['qty'] ?? 1;
            $key = $data['type'] . '_' . $data['id'];

            $cart = session()->get('cart', []);

            // Enforce max 2 units per type per user di cart
            if ($data['type'] === 'motor' || $data['type'] === 'joki') {
                $typeCount = collect($cart)->filter(function ($i) use ($data) {
                    return isset($i['type']) && $i['type'] === $data['type'];
                })->count();

                // If adding a new item (not updating qty on existing key) and user already has 2, block
                if (!isset($cart[$key]) && $typeCount >= 2) {
                    $typeLabel = $data['type'] === 'motor' ? 'motor' : 'penjoki';
                    return back()->with('error', "Batas peminjaman: Anda hanya dapat meminjam maksimal 2 {$typeLabel}.");
                }
            }

            if (isset($cart[$key])) {
                $cart[$key]['qty'] = $cart[$key]['qty'] + $qty;
            } else {
                // Get image from database based on type
                $image = '';
                if ($data['type'] === 'motor') {
                    $motor = \App\Models\Motor::find($data['id']);
                    $image = $motor ? asset($motor->image) : '';
                } elseif ($data['type'] === 'joki') {
                    $joki = \App\Models\Joki::find($data['id']);
                    $image = $joki ? asset($joki->image ?? $joki->photo) : '';
                }

                $cart[$key] = [
                    'id' => $data['id'],
                    'type' => $data['type'],
                    'name' => $data['name'],
                    'price' => $data['price'],
                    'qty' => $qty,
                    'image' => $image,
                ];
            }

            session()->put('cart', $cart);

            // Persist cart for authenticated users
            if (auth()->check()) {
                \App\Models\Cart::updateOrCreate(
                    ['user_id' => auth()->id()],
                    ['data' => $cart]
                );
            }

            // If client asked to be redirected to keranjang, do so; otherwise go back
            if (!empty($data['redirect']) && $data['redirect'] === 'keranjang') {
                return redirect()->route('pembayaran.keranjang')->with('success', 'Item ditambahkan ke keranjang.');
            }

            return back()->with('success', 'Item ditambahkan ke keranjang.');
        })->name('cart.add');
    });
    
    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', function () {
            $totalMotors = \App\Models\Motor::count();
            $totalJokis = class_exists(\App\Models\Joki::class) ? \App\Models\Joki::count() : 0;
            $activeRentals = \App\Models\Order::whereIn('status', ['paid','active'])->count();
            $totalUsers = \App\Models\User::count();
            return view('admin.dashboard', compact('totalMotors','totalJokis','activeRentals','totalUsers'));
        })->name('admin.dashboard');

        // Admin CRUD
        Route::resource('/admin/categories', \App\Http\Controllers\Admin\CategoryAdminController::class)
            ->names('admin.categories')->except(['show']);
        Route::resource('/admin/motors', \App\Http\Controllers\Admin\MotorAdminController::class)
            ->names('admin.motors')->except(['show']);
        Route::resource('/admin/users', \App\Http\Controllers\Admin\UserAdminController::class)
            ->names('admin.users')->except(['show']);

        // KYC actions
        Route::post('/admin/users/{user}/kyc/verify', [\App\Http\Controllers\Admin\UserAdminController::class, 'verifyKyc'])->name('admin.users.kyc.verify');
        Route::post('/admin/users/{user}/kyc/revoke', [\App\Http\Controllers\Admin\UserAdminController::class, 'revokeKyc'])->name('admin.users.kyc.revoke');

        // Rentals
        Route::get('/admin/rentals/active', [\App\Http\Controllers\Admin\RentalAdminController::class, 'active'])->name('admin.rentals.active');
        Route::post('/admin/rentals/{order}/return', [\App\Http\Controllers\Admin\RentalAdminController::class, 'returnItem'])->name('admin.rentals.return');
        Route::get('/admin/rentals/{user}/history', [\App\Http\Controllers\Admin\RentalAdminController::class, 'history'])->name('admin.rentals.history');
    });
});
