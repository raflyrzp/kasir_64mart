<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Identitas;
use App\Models\Pembelian;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        $identitas = Identitas::findOrFail(1);
        $total_penjualan_produk = DetailTransaksi::sum('kuantitas');
        $monthlyData = [];

        $total_seluruh_pemasukan = 0;
        $total_seluruh_pengeluaran = 0;
        $total_seluruh_keuntungan = 0;
        $produk_menipis = Produk::where('stok', '<', 10)->get();
        $data_kategori = Kategori::all();


        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $transaksiData = Transaksi::whereMonth('tanggal_transaksi', $bulan)
                ->selectRaw('SUM(total_harga) as total_pemasukan')
                ->first();

            $pembelianData = Pembelian::whereMonth('tanggal_pembelian', $bulan)
                ->selectRaw('SUM(total_harga) as total_pengeluaran')
                ->first();

            $total_pemasukan = $transaksiData->total_pemasukan ?? 0;
            $total_pengeluaran = $pembelianData->total_pengeluaran ?? 0;
            $keuntungan = $total_pemasukan - $total_pengeluaran;

            $total_seluruh_pemasukan += $total_pemasukan;
            $total_seluruh_pengeluaran += $total_pengeluaran;
            $total_seluruh_keuntungan += $keuntungan;

            $namaBulan = Carbon::create(0, $bulan, 1)->format('M');

            $monthlyData[] = [
                'bulan' => $namaBulan,
                'total_pemasukan' => $total_pemasukan,
                'total_pengeluaran' => $total_pengeluaran,
                'keuntungan' => $keuntungan,
            ];
        }

        return view('dashboard.' . $role . '.index')
            ->with([
                'title' => 'Dashboard',
                'identitas' => $identitas,
                'monthlyData' => $monthlyData,
                'total_seluruh_pemasukan' => $total_seluruh_pemasukan,
                'total_seluruh_pengeluaran' => $total_seluruh_pengeluaran,
                'total_seluruh_keuntungan' => $total_seluruh_keuntungan,
                'total_penjualan_produk' => $total_penjualan_produk,
                'produk_menipis' => $produk_menipis,
                'data_kategori' => $data_kategori,
                'role' => $role
            ]);


        // if ($role === 'admin') {
        //     return view('dashboard.admin.index')
        //         ->with([
        //             'title' => 'Dashboard',
        //             'identitas' => $identitas,
        //             'monthlyData' => $monthlyData,
        //             'total_seluruh_pemasukan' => $total_seluruh_pemasukan,
        //             'total_seluruh_pengeluaran' => $total_seluruh_pengeluaran,
        //             'total_seluruh_keuntungan' => $total_seluruh_keuntungan,
        //             'total_penjualan_produk' => $total_penjualan_produk,
        //             'produk_menipis' => $produk_menipis,
        //             'data_kategori' => $data_kategori,
        //             'role' => $role
        //         ]);
        // } elseif ($role === 'kasir') {
        //     return view('dashboard.kasir.index')
        //         ->with([
        //             'title' => 'Dashboard',
        //             'identitas' => $identitas,
        //             'monthlyData' => $monthlyData,
        //             'total_seluruh_pemasukan' => $total_seluruh_pemasukan,
        //             'total_seluruh_pengeluaran' => $total_seluruh_pengeluaran,
        //             'total_seluruh_keuntungan' => $total_seluruh_keuntungan,
        //             'total_penjualan_produk' => $total_penjualan_produk,
        //             'produk_menipis' => $produk_menipis,
        //             'data_kategori' => $data_kategori,
        //             'role' => $role
        //         ]);
        // } elseif ($role === 'owner') {
        //     return view('dashboard.owner.index')
        //         ->with([
        //             'title' => 'Dashboard',
        //             'identitas' => $identitas,
        //             'monthlyData' => $monthlyData,
        //             'total_seluruh_pemasukan' => $total_seluruh_pemasukan,
        //             'total_seluruh_pengeluaran' => $total_seluruh_pengeluaran,
        //             'total_seluruh_keuntungan' => $total_seluruh_keuntungan,
        //             'total_penjualan_produk' => $total_penjualan_produk,
        //             'produk_menipis' => $produk_menipis,
        //             'data_kategori' => $data_kategori,
        //             'role' => $role
        //         ]);
        // }
    }
}
