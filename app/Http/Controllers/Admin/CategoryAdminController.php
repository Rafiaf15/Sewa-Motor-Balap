<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Joki;
use Illuminate\Http\Request;

class CategoryAdminController extends Controller
{
    public function index()
    {
        // Show Joki list in the Categories section as requested
        $jokis = Joki::orderBy('name')->get();
        return view('admin.categories.index', compact('jokis'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'type' => ['required', 'in:motor,joki'],
        ]);

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori dibuat.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
            'type' => ['required', 'in:motor,joki'],
        ]);

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori dihapus.');
    }
}


