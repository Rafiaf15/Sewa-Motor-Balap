<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'phone' => ['nullable','string','max:30'],
            'ktp' => ['nullable','string','max:100'],
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

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('public/avatars');
            $data['avatar'] = Storage::url($path);
        }

        if ($request->hasFile('ktp_photo')) {
            $path = $request->file('ktp_photo')->store('public/kyc');
            $data['ktp_photo'] = Storage::url($path);
        }

        if ($request->hasFile('simc_photo')) {
            $path = $request->file('simc_photo')->store('public/kyc');
            $data['simc_photo'] = Storage::url($path);
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

    private function deleteStorageFileByUrl(string $url): void
    {
        $path = parse_url($url, PHP_URL_PATH) ?? '';
        // Convert /storage/... to public/... for Storage disk
        if (str_starts_with($path, '/storage/')) {
            $storagePath = 'public/' . ltrim(substr($path, strlen('/storage/')), '/');
            Storage::delete($storagePath);
        }
    }
}
