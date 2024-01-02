@extends('layout/main');

@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Transaction Detail</h3>
                    <p class="text-subtitle text-muted">
                        Transaction Detail for transaction code : {{ $kode_transaksi }}
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/{{ $role }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route($role . '.riwayat_transaksi') }}">Transaction history</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Transaction detail
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Transaction Detail for Transaction Code : {{ $kode_transaksi }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive col-6">
                        <table class="table mb-0 table-md">
                            <tbody>
                                <tr>
                                    <td>Transaction date</td>
                                    <td>{{ $data_transaksi->tanggal_transaksi }}</td>
                                </tr>
                                <tr>
                                    <td>Cashier</td>
                                    <td>{{ $data_transaksi->user->name }}</td>
                                </tr>
                                <tr>
                                    <td>Subtotal</td>
                                    <td>Rp. {{ number_format($data_transaksi->subtotal, 0, ',', '.') }},-</td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td>{{ $data_transaksi->diskon }}%</td>
                                </tr>
                                <tr>
                                    <td>Total price</td>
                                    <td>Rp. {{ number_format($data_transaksi->total_harga, 0, ',', '.') }},-</td>
                                </tr>
                                <tr>
                                    <td>Payment</td>
                                    <td>Rp. {{ number_format($data_transaksi->payment, 0, ',', '.') }},-</td>
                                </tr>
                                <tr>
                                    <td>Change</td>
                                    <td>Rp. {{ number_format($data_transaksi->change, 0, ',', '.') }},-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive mt-5">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Discount</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_detail_transaksi as $i => $detail_transaksi)
                                    <tr>
                                        <td class="col-1">{{ $i + 1 }}</td>
                                        <td>{{ $detail_transaksi->produk->nama_produk }}</td>
                                        <td>Rp. {{ number_format($detail_transaksi->harga_produk, 0, ',', '.') }},-</td>
                                        <td>{{ $detail_transaksi->kuantitas }}</td>
                                        <td>Rp. {{ number_format($detail_transaksi->subtotal, 0, ',', '.') }},-</td>
                                        <td>{{ $data_transaksi->diskon }}%</td>
                                        <td>Rp. {{ number_format($detail_transaksi->total_harga, 0, ',', '.') }},-</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    @endsection
