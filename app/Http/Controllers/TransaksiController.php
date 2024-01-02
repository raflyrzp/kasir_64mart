<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Diskon;
use App\Models\Produk;
use App\Models\Identitas;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class TransaksiController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        $data_transaksi = Transaksi::all();
        $data_produk = Produk::all();
        $data_diskon = Diskon::all();
        $identitas = Identitas::findOrFail(1);

        if (count($data_produk) < 1) {
            return redirect()->route($role . '.produk.index')->with('warning', 'Please add a product first before making a transaction!');
        }
        return view('transaksi.index', [
            'title' => 'Cashier',
            'data_transaksi' => $data_transaksi,
            'data_produk' => $data_produk,
            'data_diskon' => $data_diskon,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function cariProdukByBarcode(Request $request)
    {
        $barcode = $request->barcode;
        $produk = Produk::where('barcode', $barcode)->first();

        if (!$produk) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $kuantitas = 1;
        $harga_produk = $produk->harga;
        $subtotal = $kuantitas * $harga_produk;

        $item = [
            'id_produk' => $produk->id,
            'nama_produk' => $produk->nama_produk,
            'kuantitas' => $kuantitas,
            'harga' => $harga_produk,
            'subtotal' => $subtotal,
        ];

        $keranjang = Session::get('keranjang') ?? [];

        if (array_key_exists($produk->barcode, $keranjang)) {
            $keranjang[$produk->barcode]['kuantitas'] += $kuantitas;
        } else {
            $keranjang[$produk->barcode] = $item;
        }

        Session::put('keranjang', $keranjang);

        return response()->json(['message' => 'Item added to cart', 'data' => $item]);
    }


    public function tambahKeKeranjang(Request $request)
    {
        $id_produk = $request->id_produk;
        $kuantitas = $request->kuantitas;

        $produk = Produk::find($id_produk);

        if (!$produk) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if ($kuantitas <= 0) {
            return response()->json(['message' => 'Quantity must be greater than 0'], 400);
        }

        if ($produk->stok < $kuantitas) {
            return response()->json(['message' => 'Insufficient stock'], 400);
        }

        $keranjang = Session::get('keranjang') ?? [];

        if (array_key_exists($id_produk, $keranjang)) {
            $keranjang[$id_produk]['kuantitas'] += $kuantitas;
        } else {
            $keranjang[$id_produk] = [
                'produk' => $produk,
                'kuantitas' => $kuantitas,
            ];
        }

        Session::put('keranjang', $keranjang);

        return response()->json(['message' => 'Item added to cart']);
    }

    public function checkout(Request $request)
    {
        $role = auth()->user()->role;
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'total_harga' => 'required|numeric',
            'payment' => 'required|numeric',
            'id_diskon' => 'numeric|nullable',
            'change' => 'required|numeric',
            'id_produk' => 'required|array',
            'id_produk.*' => 'exists:produk,id',
            'id_user' => 'required|integer',
            'kuantitas' => 'required|array',
        ]);


        $kodeTransaksi = 'TRN' . Carbon::now()->format('YmdHis');

        if ($request->id_diskon !== null) {
            $data_diskon = Diskon::findOrFail($request->id_diskon);
            $diskon = $data_diskon->besar_diskon;
        } else {
            $diskon = 0;
        }

        $transaksi = new Transaksi;
        $transaksi->kode_transaksi = $kodeTransaksi;
        $transaksi->tanggal_transaksi = $request->tanggal_transaksi;
        $transaksi->subtotal = $request->total_harga;
        $transaksi->total_harga = $request->total_harga - ($request->total_harga * $diskon / 100);
        $transaksi->payment = $request->payment;
        $transaksi->diskon = $diskon;
        $transaksi->change = $request->change;
        $transaksi->id_user = $request->id_user;
        $transaksi->metode_pembayaran = 'tunai';

        $transaksi->save();
        $transaksi->load('user');

        foreach ($request->id_produk as $key => $id_produk) {
            $produk = Produk::find($id_produk);
            if ($produk) {
                $produk->stok -= $request->kuantitas[$key];
                $produk->save();
                $subtotal = $request->harga[$key] * $request->kuantitas[$key];
                $detailTransaksi = new DetailTransaksi;
                $detailTransaksi->kode_transaksi = $kodeTransaksi;
                $detailTransaksi->id_produk = $id_produk;
                $detailTransaksi->harga_produk = $request->harga[$key];
                $detailTransaksi->kuantitas = $request->kuantitas[$key];
                $detailTransaksi->subtotal = $request->harga[$key] * $request->kuantitas[$key];
                $detailTransaksi->total_harga = $subtotal - ($subtotal * $diskon / 100);
                $detailTransaksi->save();
            } else {
                return redirect()->route($role . '.transaksi.index')->with('error', 'gagal.');
            }
        }
        $detail_transaksi = DetailTransaksi::where('kode_transaksi', $kodeTransaksi)->with('produk')->get();
        // return redirect()->route($role . '.transaksi.index')->with('success', 'Successfull transaction.');
        return view('transaksi.struk', compact('transaksi', 'detail_transaksi'));
    }
}
