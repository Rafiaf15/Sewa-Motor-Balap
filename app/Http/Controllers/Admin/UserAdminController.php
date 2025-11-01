<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8'],
            'role' => ['required','in:user,admin'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        return redirect()->route('admin.users.index')->with('success','User dibuat.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,' . $user->id],
            'password' => ['nullable','string','min:8'],
            'phone' => ['nullable','string','regex:/^[0-9+\-\s()]+$/','min:10','max:12'],
            'ktp' => ['nullable','string','regex:/^[0-9]+$/','size:16'],
            'address' => ['nullable','string','max:1000'],
            'role' => ['required','in:user,admin'],
        ], [
            'phone.regex' => 'No. Telepon hanya boleh berisi angka, spasi, tanda plus, minus, dan tanda kurung.',
            'ktp.regex' => 'No. KTP hanya boleh berisi angka.',
        ]);

        $update = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'ktp' => $data['ktp'],
            'address' => $data['address'],
            'role' => $data['role'],
        ];
        if (!empty($data['password'])) {
            $update['password'] = Hash::make($data['password']);
        }

        // Validate that required fields are not empty
        if (empty($update['phone'])) {
            return back()->withErrors(['phone' => 'No. Telepon wajib diisi.'])->withInput();
        }
        if (empty($update['ktp'])) {
            return back()->withErrors(['ktp' => 'No. KTP wajib diisi.'])->withInput();
        }
        if (empty($update['address'])) {
            return back()->withErrors(['address' => 'Alamat wajib diisi.'])->withInput();
        }

        $user->update($update);

        return redirect()->route('admin.users.index')->with('success','User diperbarui.');
    }

    public function destroy(User $user)
    {
        // Prevent self-deletion for safety
        if (auth()->id() === $user->id) {
            return back()->with('error','Tidak dapat menghapus akun sendiri.');
        }
        $user->delete();
        return back()->with('success','User dihapus.');
    }

    public function verifyKyc(User $user)
    {
        if (!$user->ktp_photo || !$user->simc_photo) {
            return back()->with('error', 'User belum mengunggah KTP dan/atau SIM C.');
        }
        $user->forceFill(['kyc_verified_at' => now()])->save();
        return back()->with('success', 'KYC pengguna telah diverifikasi.');
    }

    public function revokeKyc(User $user)
    {
        $user->forceFill(['kyc_verified_at' => null])->save();
        return back()->with('success', 'Verifikasi KYC pengguna telah dicabut.');
    }
}


