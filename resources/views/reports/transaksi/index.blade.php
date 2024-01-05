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
                    <h3>Transaction history</h3>
                    <p class="text-subtitle text-muted">
                        A list of Transaction history.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href='/{{ $role }}'>Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Transaction history
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
                    <h5 class="card-title">Transaction Table</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <button id="print-button" class="btn btn-primary mb-3 no-print"><i
                                class="bi bi-printer"></i></button>
                        <button id="save-csv-button" class="btn btn-primary mb-3 no-print"><i
                                class="bi bi-filetype-csv"></i></button>
                        <button id="save-excel-button" class="btn btn-primary mb-3 no-print"><i
                                class="bi bi-file-earmark-spreadsheet"></i></button>

                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Transaction code</th>
                                    <th>Transaction date</th>
                                    <th>Cashier</th>
                                    <th>Total price</th>
                                    {{-- <th>Payment</th>
                                    <th>Disc</th>
                                    <th>Change</th> --}}
                                    <th class="col-2 no-print">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_transaksi as $i => $transaksi)
                                    <tr>
                                        <td class="col-1">{{ $i + 1 }}</td>
                                        <td>{{ $transaksi->kode_transaksi }}</td>
                                        <td>{{ $transaksi->tanggal_transaksi }}</td>
                                        <td>{{ $transaksi->user->name }}</td>
                                        <td>Rp. {{ number_format($transaksi->total_harga, 0, ',', '.') }},-</td>
                                        {{-- <td>Rp. {{ number_format($transaksi->payment, 0, ',', '.') }},-</td>
                                        <td>{{ $transaksi->diskon }}%</td>
                                        <td>Rp. {{ number_format($transaksi->change, 0, ',', '.') }},-</td> --}}
                                        <td class="col-2 no-print">
                                            <a type="button"
                                                href="{{ route('report.detail_transaksi', ['role' => $role, 'kode_transaksi' => $transaksi->kode_transaksi]) }}"
                                                class="btn btn-sm btn-primary col-12 mb-1">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    @endsection
