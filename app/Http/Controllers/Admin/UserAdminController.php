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
            'role' => ['required','in:user,admin'],
        ]);

        $update = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
        ];
        if (!empty($data['password'])) {
            $update['password'] = Hash::make($data['password']);
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


