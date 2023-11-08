<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Identitas;
use App\Models\Pembelian;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function reportKategori()
    {
        $role = auth()->user()->role;
        $data_kategori = Kategori::all();
        $identitas = Identitas::findOrFail(1);


        return view('reports.kategori.index', [
            'title' => 'Category Report',
            'data_kategori' => $data_kategori,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function reportProduk()
    {
        $role = auth()->user()->role;
        $data_kategori = Kategori::all();
        $data_produk = Produk::all();
        $identitas = Identitas::findOrFail(1);


        return view('reports.produk.index', [
            'title' => 'Product Report',
            'data_kategori' => $data_kategori,
            'data_produk' => $data_produk,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function reportSupplier()
    {
        $role = auth()->user()->role;
        $data_supplier = Supplier::all();
        $identitas = Identitas::findOrFail(1);


        return view('reports.supplier.index', [
            'title' => 'Supplier Report',
            'data_supplier' => $data_supplier,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function reportAdmin()
    {
        $role = auth()->user()->role;
        $data_admin = User::where('role', 'admin')->get();
        $identitas = Identitas::findOrFail(1);

        return view('reports.users.admin.index', [
            'title' => 'Admin Report',
            'data_admin' => $data_admin,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function reportKasir()
    {
        $role = auth()->user()->role;
        $data_kasir = User::where('role', 'kasir')->get();
        $identitas = Identitas::findOrFail(1);

        return view('reports.users.kasir.index', [
            'title' => 'Cashier Report',
            'data_kasir' => $data_kasir,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function reportOwner()
    {
        $role = auth()->user()->role;
        $data_owner = User::where('role', 'owner')->get();
        $identitas = Identitas::findOrFail(1);

        return view('reports.users.owner.index', [
            'title' => 'Owner Report',
            'data_owner' => $data_owner,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function reportPembelian()
    {
        $role = auth()->user()->role;
        $data_pembelian = Pembelian::with(['produk', 'supplier'])->get();
        $data_produk = Produk::all();
        $data_supplier = Supplier::all();
        $identitas = Identitas::findOrFail(1);


        return view('reports.pembelian.index', [
            'title' => 'Purchase Report',
            'data_pembelian' => $data_pembelian,
            'data_produk' => $data_produk,
            'data_supplier' => $data_supplier,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function reportTransaksi()
    {
        $role = auth()->user()->role;
        $data_detail_transaksi = DetailTransaksi::all();
        $data_transaksi = Transaksi::with('user')->get();
        $identitas = Identitas::findOrFail(1);


        return view('reports.transaksi.index', [
            'title' => 'Transaction Report',
            'data_detail_transaksi' => $data_detail_transaksi,
            'data_transaksi' => $data_transaksi,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function reportDetailTransaksi($role, $kodeTransaksi)
    {
        $data_detail_transaksi = DetailTransaksi::where('kode_transaksi', $kodeTransaksi)->with('produk')->get();
        $identitas = Identitas::findOrFail(1);

        return view('reports.detail_transaksi.index', [
            'title' => 'Transaction Detail Report',
            'data_detail_transaksi' => $data_detail_transaksi,
            'kode_transaksi' => $kodeTransaksi,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }
}
