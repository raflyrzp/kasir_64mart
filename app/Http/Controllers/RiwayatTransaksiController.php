<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Http\Controllers\Controller;

class RiwayatTransaksiController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        $data_detail_transaksi = DetailTransaksi::all();
        $data_transaksi = Transaksi::with('user')->get();
        $identitas = Identitas::findOrFail(1);

        return view('transaksi.riwayat_transaksi.index', [
            'title' => 'Transaction History',
            'data_detail_transaksi' => $data_detail_transaksi,
            'data_transaksi' => $data_transaksi,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function showDetail($kodeTransaksi)
    {
        $data_detail_transaksi = DetailTransaksi::where('kode_transaksi', $kodeTransaksi)->with('produk')->get();
        $role = auth()->user()->role;
        $identitas = Identitas::findOrFail(1);

        return view('transaksi.riwayat_transaksi.detail', [
            'title' => 'Transaction Detail',
            'data_detail_transaksi' => $data_detail_transaksi,
            'kode_transaksi' => $kodeTransaksi,
            'role' => $role,
            'identitas' => $identitas
        ]);
    }
}
