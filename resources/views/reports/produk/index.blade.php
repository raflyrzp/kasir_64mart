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
                    <h3>Products</h3>
                    <p class="text-subtitle text-muted">
                        A list of products
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href='/{{ $role }}'>Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Products
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
                    <h5 class="card-title">Product Table</h5>
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
                                    <th>Product code</th>
                                    <th>Product name</th>
                                    <th>Stock</th>
                                    <th>Selling price</th>
                                    <th>Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_produk as $i => $produk)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $produk->kode_produk }}</td>
                                        <td>{{ $produk->nama_produk }}</td>
                                        <td>{{ $produk->stok }}</td>
                                        <td>Rp. {{ number_format($produk->harga, 0, ',', '.') }},-</td>
                                        <td>
                                            @foreach ($data_kategori as $kategori)
                                                @if ($produk->id_kategori == $kategori->id)
                                                    {{ $kategori->nama_kategori }}
                                                @endif
                                            @endforeach
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
