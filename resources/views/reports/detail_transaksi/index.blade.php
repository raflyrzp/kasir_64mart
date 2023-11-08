@extends('layout/main');

@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="print-header">
        <h1>{{ $identitas->nama_app }}</h1>
        <p>{{ $identitas->alamat }}</p>
    </div>

    <div class="page-heading">
        <div class="page-title no-print">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Transaction</h3>
                    <p class="text-subtitle text-muted">
                        Detail transaction for transaction code : {{ $kode_transaksi }}
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/{{ $role }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('report.transaksi', $role) }}">Transaction history</a>
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
                    <h5 class="card-title">Products for Transaction code : {{ $kode_transaksi }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <button id="print-button" class="btn btn-primary mb-3"><i class="bi bi-printer"></i></button>
                        <button id="save-csv-button" class="btn btn-primary mb-3"><i
                                class="bi bi-filetype-csv"></i></button>
                        <button id="save-excel-button" class="btn btn-primary mb-3"><i
                                class="bi bi-file-earmark-spreadsheet"></i></button>
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    @endsection
