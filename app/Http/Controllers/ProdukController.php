<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Identitas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ProdukController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        $data_kategori = Kategori::all();
        $data_produk = Produk::all();
        $identitas = Identitas::findOrFail(1);


        return view('katalog_produk.produk.index', [
            'title' => 'Products',
            'data_kategori' => $data_kategori,
            'data_produk' => $data_produk,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function store(Request $request)
    {
        $role = auth()->user()->role;
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric',
            'barcode' => 'nullable'
        ], [
            'nama_produk.required' => 'The product name field is required.',
            'nama_produk.string' => 'The product name must be a string.',
            'nama_produk.max' => 'The product name may not be greater than :max characters.',
            'id_kategori.required' => 'The category field is required.',
            'id_kategori.exists' => 'The selected category is invalid.',
            'harga.required' => 'The price field is required.',
            'harga.numeric' => 'The price must be a number.',
            'harga.min' => 'The price must be at least :min.',
            'stok.required' => 'The stock field is required.',
            'stok.numeric' => 'The stock must be a number.',
        ]);

        $existingProduk = Produk::where('nama_produk', $request->nama_produk)->first();

        if ($existingProduk) {
            $existingProduk->stok += $request->stok;
            $existingProduk->save();
        } else {
            $latestProduk = Produk::orderBy('kode_produk', 'desc')->first();

            if ($latestProduk) {
                $latestProdukNumber = (int)substr($latestProduk->kode_produk, 3);
                $nextProdukNumber = $latestProdukNumber + 1;
                $kodeProduk = 'PRD' . str_pad($nextProdukNumber, 3, '0', STR_PAD_LEFT);
            } else {
                $kodeProduk = 'PRD001';
            }

            Produk::create([
                'kode_produk' => $kodeProduk,
                'nama_produk' => $request->nama_produk,
                'id_kategori' => $request->id_kategori,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'barcode' => $request->barcode,
            ]);
        }

        return redirect()->route($role . '.produk.index')->with('success', 'Successfully added a new product.');
    }


    public function update(Request $request, $id)
    {
        $role = auth()->user()->role;
        $request->validate([
            'nama_produk' => [
                'required',
                'string',
                'max:255',
                Rule::unique('produk', 'nama_produk')->ignore($id),
            ],
            'id_kategori' => 'required|exists:kategori,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric',
            'barcode' => 'nullable'
        ]);

        $produk = Produk::find($id);

        if (!$produk) {
            return redirect()->route($role . '.produk.index')->with('error', 'Product not found.');
        }

        $produk->nama_produk = $request->nama_produk;
        $produk->id_kategori = $request->id_kategori;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;
        $produk->barcode = $request->barcode;
        $produk->save();

        return redirect()->route($role . '.produk.index')->with('success', 'Successfully updated a product.');
    }

    public function destroy($id)
    {
        $role = auth()->user()->role;
        $produk = Produk::find($id);

        if (!$produk) {
            return redirect()->route($role . '.produk.index')->with('error', 'Product not found.');
        }

        $produk->delete();

        return redirect()->route($role . '.produk.index')->with('success', 'Successfully deleted a product.');
    }
}
