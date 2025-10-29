<?php

namespace App\Http\Controllers;

use App\Models\Joki;
use Illuminate\Http\Request;

class JokiController extends Controller
{
    public function index()
    {
        $jokis = Joki::orderBy('name')->get();
        return view('joki.penjoki', compact('jokis'));
    }

    public function category(string $category)
    {
        $jokis = Joki::where('category', $category)
            ->orderBy('name')
            ->get();

        return view('joki.penjoki', compact('jokis', 'category'));
    }

    public function search(Request $request)
    {
        $search = (string) $request->input('search', '');

        $jokis = Joki::when($search !== '', function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%");
                    });
                })
                ->orderBy('name')
                ->get();

        return view('joki.penjoki', [
            'jokis' => $jokis,
            'search' => $search,
        ]);
    }
}


