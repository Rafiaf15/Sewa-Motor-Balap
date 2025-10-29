<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

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

Route::get('/joki', function () {
    $jokis = \App\Models\Joki::all();
    return view('joki.penjoki', compact('jokis'));
})->name('joki.penjoki');

Route::get('/joki/{category}', function ($category) {
    $jokis = \App\Models\Joki::where('category', $category)->get();
    return view('joki.penjoki', compact('jokis', 'category'));
})->where('category', 'pemula|menengah|expert')->name('joki.category');

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
        return view('dashboard');
    })->name('dashboard');

    // Profile routes (edit & update)
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Cart (keranjang) - only for authenticated users
    Route::get('/keranjang', function () {
        return view('pembayaran.keranjang');
    })->name('pembayaran.keranjang');

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

        $qty = $data['qty'] ?? 1;
        $key = $data['type'] . '_' . $data['id'];

        $cart = session()->get('cart', []);

        // Enforce max 2 units of type 'motor' per user
        if ($data['type'] === 'motor') {
            $motorCount = collect($cart)->filter(function ($i) {
                return isset($i['type']) && $i['type'] === 'motor';
            })->count();

            // If adding a new motor (not updating qty on existing key) and user already has 2, block
            if (!isset($cart[$key]) && $motorCount >= 2) {
                return back()->with('error', 'Batas peminjaman: Anda hanya dapat meminjam maksimal 2 unit.');
            }
        }

        if (isset($cart[$key])) {
            $cart[$key]['qty'] = $cart[$key]['qty'] + $qty;
        } else {
            // Get image from database based on type
            $image = '';
            if ($data['type'] === 'motor') {
                $motor = \App\Models\Motor::find($data['id']);
                $image = $motor ? $motor->image : '';
            } elseif ($data['type'] === 'joki') {
                $joki = \App\Models\Joki::find($data['id']);
                $image = $joki ? $joki->image : '';
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

        // If client asked to be redirected to keranjang, do so; otherwise go back
        if (!empty($data['redirect']) && $data['redirect'] === 'keranjang') {
            return redirect()->route('pembayaran.keranjang')->with('success', 'Item ditambahkan ke keranjang.');
        }

        return back()->with('success', 'Item ditambahkan ke keranjang.');
    })->name('cart.add');
    
    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });
});
