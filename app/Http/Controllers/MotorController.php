<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use Illuminate\Http\Request;

class MotorController extends Controller
{
    public function index()
    {
        $motors = Motor::where('available', true)->get();
        return view('motor.motorbalap', compact('motors'));
    }

    public function category($category)
    {
        $motors = Motor::where('category', $category)
                      ->where('available', true)
                      ->get();
        return view('motor.motorbalap', compact('motors', 'category'));
    }

    public function normalVariant($variant)
    {
        $motors = Motor::where('category', 'normal-' . $variant)
                      ->where('available', true)
                      ->get();
        return view('motor.motorbalap', [
            'motors' => $motors,
            'category' => 'normal',
            'variant' => $variant
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $motors = Motor::where('available', true)
                      ->where(function($query) use ($search) {
                          $query->where('name', 'like', "%{$search}%")
                                ->orWhere('description', 'like', "%{$search}%")
                                ->orWhere('unit_code', 'like', "%{$search}%");
                      })
                      ->get();

        return view('motor.motorbalap', [
            'motors' => $motors,
            'search' => $search
        ]);
    }
}