<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IdentitasController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\RiwayatTransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Login
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/', [AuthController::class, 'login']);

//Logout
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/blocked', function () {
    return view('blocked');
})->name('blocked');

Route::post('/{role}/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
Route::post('/cari-produk', [TransaksiController::class, 'cariProdukByBarcode'])->name('cari_produk');

// REPORTS
Route::get('/{role}/reports/kategori', [ReportController::class, 'reportKategori'])->name('report.kategori');
Route::get('/{role}/reports/produk', [ReportController::class, 'reportProduk'])->name('report.produk');
Route::get('/{role}/reports/supplier', [ReportController::class, 'reportSupplier'])->name('report.supplier');
Route::get('/{role}/reports/admin', [ReportController::class, 'reportAdmin'])->name('report.admin');
Route::get('/{role}/reports/kasir', [ReportController::class, 'reportKasir'])->name('report.kasir');
Route::get('/{role}/reports/owner', [ReportController::class, 'reportOwner'])->name('report.owner');
Route::get('/{role}/reports/pembelian', [ReportController::class, 'reportPembelian'])->name('report.pembelian');
Route::get('/{role}/reports/transaksi', [ReportController::class, 'reportTransaksi'])->name('report.transaksi');
Route::get('/{role}/reports/detail_transaksi/{kode_transaksi}/detail', [ReportController::class, 'reportDetailTransaksi'])->name('report.detail_transaksi');



Route::middleware(['auth', 'userAkses:admin'])->group(function () {

    // DASHBOARD KASIR
    Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard.admin');

    // KATEGORI
    Route::resource('/admin/kategori', KategoriController::class)->names([
        'index' => 'admin.kategori.index',
        'store' => 'admin.kategori.store',
        'update' => 'admin.kategori.update',
        'destroy' => 'admin.kategori.destroy',
    ]);

    // PRODUK
    Route::resource('/admin/produk', ProdukController::class)->names([
        'index' => 'admin.produk.index',
        'store' => 'admin.produk.store',
        'update' => 'admin.produk.update',
        'destroy' => 'admin.produk.destroy',
    ]);

    // DISKON
    Route::resource('/admin/diskon', DiskonController::class)->names([
        'index' => 'admin.diskon.index',
        'store' => 'admin.diskon.store',
        'update' => 'admin.diskon.update',
        'destroy' => 'admin.diskon.destroy',
    ]);

    // SUPPLIER
    Route::resource('/admin/supplier', SupplierController::class)->names([
        'index' => 'admin.supplier.index',
        'store' => 'admin.supplier.store',
        'update' => 'admin.supplier.update',
        'destroy' => 'admin.supplier.destroy',
    ]);

    // PEMBELIAN
    Route::resource('/admin/pembelian', PembelianController::class)->names([
        'index' => 'admin.pembelian.index',
        'store' => 'admin.pembelian.store',
    ]);

    // IDENTITAS APP
    Route::resource('/admin/identitas', IdentitasController::class)->names([
        'index' => 'admin.identitas.index',
        'update' => 'admin.identitas.update',
    ]);

    // TRANSAKSI
    Route::post('/admin/tambah-ke-keranjang', [TransaksiController::class, 'tambahKeKeranjang'])->name('tambahKeKeranjang');
    // Route::post('/cari-produk', [TransaksiController::class, 'cariProdukByBarcode'])->name('cari_produk');
    Route::get('/admin/transaksi', [TransaksiController::class, 'index'])->name('admin.transaksi.index');

    Route::get('/admin/riwayat_transaksi', [RiwayatTransaksiController::class, 'index'])->name('admin.riwayat_transaksi');
    Route::get('/admin/riwayat_transaksi/{kode_transaksi}/detail', [RiwayatTransaksiController::class, 'showDetail'])->name('admin.detail_transaksi');
    // Route::get('/transaksi/{kode_transaksi}/detail', [TransaksiController::class, 'showDetailTransaksi'])->name('transaksi.detail');

    // USERS
    Route::get('/admin/users/data_admin', [UserController::class, 'adminIndex'])->name('data_admin');
    Route::get('/admin/users/data_kasir', [UserController::class, 'kasirIndex'])->name('data_kasir');
    Route::get('/admin/users/data_owner', [UserController::class, 'ownerIndex'])->name('data_owner');

    Route::delete('/admin/users/data_admin/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::delete('/admin/users/data_owner/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::delete('/admin/users/data_kasir/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::post('/admin/users/data_{role}', [UserController::class, 'store'])->name('users.store')->where('role', 'admin|owner|kasir');
    Route::put('/admin/users/data_admin/{user}', [UserController::class, 'update'])->name('users.update');
    Route::put('/admin/users/data_owner/{user}', [UserController::class, 'update'])->name('users.update');
    Route::put('/admin/users/data_kasir/{user}', [UserController::class, 'update'])->name('users.update');
});


Route::middleware(['auth', 'userAkses:kasir'])->group(function () {
    // DASHBOARD ADMIN
    Route::get('/kasir', [DashboardController::class, 'index'])->name('dashboard.kasir');

    // KATEGORI
    Route::resource('/kasir/kategori', KategoriController::class)->names([
        'index' => 'kasir.kategori.index',
        'store' => 'kasir.kategori.store',
        'update' => 'kasir.kategori.update',
        'destroy' => 'kasir.kategori.destroy',
    ]);

    // PRODUK
    Route::resource('/kasir/produk', ProdukController::class)->names([
        'index' => 'kasir.produk.index',
        'store' => 'kasir.produk.store',
        'update' => 'kasir.produk.update',
        'destroy' => 'kasir.produk.destroy',
    ]);

    // DISKON
    Route::resource('/kasir/diskon', DiskonController::class)->names([
        'index' => 'kasir.diskon.index',
        'store' => 'kasir.diskon.store',
        'update' => 'kasir.diskon.update',
        'destroy' => 'kasir.diskon.destroy',
    ]);

    // SUPPLIER
    Route::resource('/kasir/supplier', SupplierController::class)->names([
        'index' => 'kasir.supplier.index',
        'store' => 'kasir.supplier.store',
        'update' => 'kasir.supplier.update',
        'destroy' => 'kasir.supplier.destroy',
    ]);

    // PEMBELIAN
    Route::resource('/kasir/pembelian', PembelianController::class)->names([
        'index' => 'kasir.pembelian.index',
        'store' => 'kasir.pembelian.store',
    ]);

    // TRANSAKSI
    Route::post('/kasir/tambah-ke-keranjang', [TransaksiController::class, 'tambahKeKeranjang'])->name('tambahKeKeranjang');
    Route::get('/kasir/transaksi', [TransaksiController::class, 'index'])->name('kasir.transaksi.index');

    Route::get('/kasir/riwayat_transaksi', [RiwayatTransaksiController::class, 'index'])->name('kasir.riwayat_transaksi');
    Route::get('/kasir/riwayat_transaksi/{kode_transaksi}/detail', [RiwayatTransaksiController::class, 'showDetail'])->name('kasir.detail_transaksi');
    // Route::get('/transaksi/{kode_transaksi}/detail', [TransaksiController::class, 'showDetailTransaksi'])->name('transaksi.detail');
});

Route::middleware(['auth', 'userAkses:owner'])->group(function () {
    // DASHBOARD OWNER
    Route::get('/owner', [DashboardController::class, 'index'])->name('dashboard.owner');

    // IDENTITAS APP
    Route::resource('/owner/identitas', IdentitasController::class)->names([
        'index' => 'owner.identitas.index',
        'update' => 'owner.identitas.update',
    ]);
});
