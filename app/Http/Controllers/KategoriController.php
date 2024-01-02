<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Identitas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        $data_kategori = Kategori::all();
        $identitas = Identitas::findOrFail(1);
        $view = ($role === 'admin' || $role === 'kasir') ? 'katalog_produk.kategori.index' : 'blocked';

        return view($view, [
            'title' => 'Categories',
            'data_kategori' => $data_kategori,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function store(Request $request)
    {
        $role = auth()->user()->role;
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route($role . '.kategori.index')->with('success', 'Successfully added a category.');
    }

    public function update(Request $request, $id)
    {
        $role = auth()->user()->role;
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
        ]);

        $kategori = Kategori::find($id);

        if (!$kategori) {
            return redirect()->route($role . '.kategori.index')->with('error', 'Category not found.');
        }

        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return redirect()->route($role . '.kategori.index')->with('success', 'Successfully updated a category.');
    }

    public function destroy($id)
    {
        $role = auth()->user()->role;
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return redirect()->route($role . '.kategori.index')->with('error', 'Category not found.');
        }

        $kategori->delete();

        return redirect()->route($role . '.kategori.index')->with('success', 'Successfully deleted a category.');
    }
}
