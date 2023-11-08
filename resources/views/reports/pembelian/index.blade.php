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
                    <h3>Purchase</h3>
                    <p class="text-subtitle text-muted">
                        Page to make or view product purchase history.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href='/{{ $role }}'>Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Purchase
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
                    <h5 class="card-title">Product Purchase History</h5>
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
                                    <th>Purchase code</th>
                                    <th>Purchase date</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total price</th>
                                    <th>Supplier</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_pembelian as $i => $pembelian)
                                    <tr>
                                        <td class="col-1">{{ $i + 1 }}</td>
                                        <td>{{ $pembelian->kode_pembelian }}</td>
                                        <td>{{ $pembelian->tanggal_pembelian }}</td>
                                        <td>{{ $pembelian->produk->nama_produk }}</td>
                                        <td>{{ $pembelian->kuantitas }}</td>
                                        <td>Rp. {{ number_format($pembelian->harga, 0, ',', '.') }},-</td>
                                        <td>Rp. {{ number_format($pembelian->total_harga, 0, ',', '.') }},-</td>
                                        <td>{{ $pembelian->supplier->nama_supplier }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    @endsection
