<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use Illuminate\Http\Request;

class MotorAdminController extends Controller
{
    public function index()
    {
        $motors = Motor::orderBy('name')->get();
        return view('admin.motors.index', compact('motors'));
    }

    public function create()
    {
        return view('admin.motors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'slug' => ['nullable','string','max:255'],
            'category' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'price_per_day' => ['required','numeric','min:0'],
            'available' => ['nullable','boolean'],
            'image' => ['nullable','string','max:1024'],
        ]);
        $data['available'] = (bool)($data['available'] ?? true);
        Motor::create($data);
        return redirect()->route('admin.motors.index')->with('success','Unit dibuat.');
    }

    public function edit(Motor $motor)
    {
        return view('admin.motors.edit', compact('motor'));
    }

    public function update(Request $request, Motor $motor)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'slug' => ['nullable','string','max:255'],
            'category' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'price_per_day' => ['required','numeric','min:0'],
            'available' => ['nullable','boolean'],
            'image' => ['nullable','string','max:1024'],
        ]);
        $data['available'] = (bool)($data['available'] ?? false);
        $motor->update($data);
        return redirect()->route('admin.motors.index')->with('success','Unit diperbarui.');
    }

    public function destroy(Motor $motor)
    {
        $motor->delete();
        return back()->with('success','Unit dihapus.');
    }
}


