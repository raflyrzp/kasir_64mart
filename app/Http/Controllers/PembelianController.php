<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Identitas;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePembelianRequest;
use App\Http\Requests\UpdatePembelianRequest;

class PembelianController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        $identitas = Identitas::findOrFail(1);
        $data_pembelian = Pembelian::with(['produk', 'supplier'])->get();
        $data_produk = Produk::all();
        $data_supplier = Supplier::all();

        return view('transaksi.pembelian.index', [
            'title' => 'Purchase',
            'data_pembelian' => $data_pembelian,
            'data_produk' => $data_produk,
            'data_supplier' => $data_supplier,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $role = auth()->user()->role;
        $request->validate([
            'tanggal_pembelian' => 'required',
            'id_produk' => 'required|exists:produk,id',
            'kuantitas' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'id_supplier' => 'required|exists:supplier,id',
            'total_harga' => 'required|numeric',
        ]);

        $kode_pembelian = 'PUR' . Carbon::now()->format('YmdHis');

        $produk = Produk::find($request->id_produk);
        $produk->stok += $request->kuantitas;
        $produk->save();

        Pembelian::create([
            'kode_pembelian' => $kode_pembelian,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'id_produk' => $request->id_produk,
            'kuantitas' => $request->kuantitas,
            'harga' => $request->harga,
            'id_supplier' => $request->id_supplier,
            'total_harga' => $request->total_harga,
        ]);



        return redirect()->route($role . '.pembelian.index')->with('success', 'Successfull Purchasing.');
    }
}
