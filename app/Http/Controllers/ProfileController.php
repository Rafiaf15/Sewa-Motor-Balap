<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        $orders = \App\Models\Order::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
        return view('profile.profile', compact('user','orders'));
    }

    public function editAdmin(Request $request)
    {
        $user = $request->user();
        $orders = \App\Models\Order::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
        return view('admin.profile', compact('user','orders'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        // Sanitize phone and ktp: remove spaces and non-digits
        $phone = preg_replace('/[^0-9]/', '', $request->input('phone', ''));
        $ktp = preg_replace('/[^0-9]/', '', $request->input('ktp', ''));

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'phone' => ['nullable','string'],
            'ktp' => ['nullable','string'],
            'address' => ['nullable','string','max:1000'],
            'avatar' => ['nullable','mimes:jpg,jpeg,png','max:5120'],
            'ktp_photo' => ['nullable','mimes:jpg,jpeg,png','max:5120'],
            'simc_photo' => ['nullable','mimes:jpg,jpeg,png','max:5120'],
        ], [
            'avatar.mimes' => 'Avatar harus berupa JPG/PNG.',
            'avatar.max' => 'Ukuran avatar maksimal 5MB.',
            'ktp_photo.mimes' => 'Foto KTP harus berupa JPG/PNG.',
            'ktp_photo.max' => 'Ukuran foto KTP maksimal 5MB.',
            'simc_photo.mimes' => 'Foto SIM C harus berupa JPG/PNG.',
            'simc_photo.max' => 'Ukuran foto SIM C maksimal 5MB.',
        ]);

        // Validate phone: must be 10-12 digits
        if (!empty($phone)) {
            if (strlen($phone) < 10 || strlen($phone) > 12) {
                return back()->withErrors(['phone' => 'No. telepon harus 10-12 digit angka.'])->withInput();
            }
            $data['phone'] = $phone;
        } else {
            $data['phone'] = $user->phone ?? null;
        }

        // Validate KTP: must be exactly 16 digits
        if (!empty($ktp)) {
            if (strlen($ktp) !== 16) {
                return back()->withErrors(['ktp' => 'No. KTP harus 16 digit angka.'])->withInput();
            }
            $data['ktp'] = $ktp;
        } else {
            $data['ktp'] = $user->ktp ?? null;
        }

        // Address
        $data['address'] = $request->input('address') ?? $user->address ?? null;

        // Ensure upload directories exist
        if (!file_exists(public_path('avatars'))) {
            mkdir(public_path('avatars'), 0755, true);
        }
        if (!file_exists(public_path('kyc'))) {
            mkdir(public_path('kyc'), 0755, true);
        }

        if ($request->hasFile('avatar')) {
            $filename = time() . '_' . uniqid() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('avatars'), $filename);
            $data['avatar'] = 'avatars/' . $filename;
        }

        if ($request->hasFile('ktp_photo')) {
            $filename = time() . '_' . uniqid() . '.' . $request->file('ktp_photo')->getClientOriginalExtension();
            $request->file('ktp_photo')->move(public_path('kyc'), $filename);
            $data['ktp_photo'] = 'kyc/' . $filename;
        }

        if ($request->hasFile('simc_photo')) {
            $filename = time() . '_' . uniqid() . '.' . $request->file('simc_photo')->getClientOriginalExtension();
            $request->file('simc_photo')->move(public_path('kyc'), $filename);
            $data['simc_photo'] = 'kyc/' . $filename;
        }

        $user->fill($data);
        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function deleteKtp(Request $request)
    {
        $user = $request->user();
        if ($user->ktp_photo) {
            $this->deleteStorageFileByUrl($user->ktp_photo);
            $user->ktp_photo = null;
            $user->kyc_verified_at = null; // revoke verification if any doc removed
            $user->save();
        }
        return back()->with('success', 'Foto KTP dihapus.');
    }

    public function deleteSimc(Request $request)
    {
        $user = $request->user();
        if ($user->simc_photo) {
            $this->deleteStorageFileByUrl($user->simc_photo);
            $user->simc_photo = null;
            $user->kyc_verified_at = null;
            $user->save();
        }
        return back()->with('success', 'Foto SIM C dihapus.');
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('profile')->with('success', 'Password berhasil diubah.');
    }

    private function deleteStorageFileByUrl(string $url): void
    {
        // For public path, just delete the file directly
        if (str_starts_with($url, 'avatars/') || str_starts_with($url, 'kyc/')) {
            $filePath = public_path($url);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        } else {
            // Fallback for old storage links
            $path = parse_url($url, PHP_URL_PATH) ?? '';
            // Convert /storage/... to public/... for Storage disk
            if (str_starts_with($path, '/storage/')) {
                $storagePath = 'public/' . ltrim(substr($path, strlen('/storage/')), '/');
                Storage::delete($storagePath);
            }
        }
    }
}
