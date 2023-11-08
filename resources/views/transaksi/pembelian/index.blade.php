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

        @if (session('success'))
            <div class="alert alert-success alert-dismissible show fade">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4 class="card-title">Product Purchase</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="{{ route($role . '.pembelian.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="tanggal_pembelian">Purchase date</label>
                                                <input type="text" id="tanggal_pembelian" class="form-control"
                                                    name="tanggal_pembelian" value="{{ now() }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="id_produk">Product</label>
                                                <select class="choices form-select" id="id_produk" name="id_produk">
                                                    <option selected disabled>Choose</option>
                                                    @foreach ($data_produk as $produk)
                                                        <option value="{{ $produk->id }}"
                                                            data-harga="{{ $produk->harga }}">{{ $produk->nama_produk }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="id_supplier">Supplier</label>
                                                <select class="choices form-select" id="id_supplier" name="id_supplier">
                                                    <option selected disabled>Choose</option>
                                                    @foreach ($data_supplier as $supplier)
                                                        <option value="{{ $supplier->id }}"
                                                            data-harga="{{ $supplier->harga }}">
                                                            {{ $supplier->nama_supplier }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if (count($data_supplier) == 0)
                                                    <small>If there's no Supplier, please add it to the <a
                                                            href="{{ route($role . '.supplier.index') }}">Supplier
                                                            page</a></small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="kuantitas">Quantity</label>
                                                <input type="number" id="kuantitas" class="form-control" name="kuantitas"
                                                    value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="harga">Price</label>
                                                <input type="text" id="harga" class="form-control" name="harga">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="total_harga">Total price</label>
                                                <input type="number" id="total-harga" class="form-control"
                                                    name="total_harga" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Product Purchase History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
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

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <script>
            $(document).ready(function() {
                $('#kuantitas, #id_produk, #harga').on('input', function() {
                    const kuantitas = $('#kuantitas').val();
                    const hargaProduk = $('#harga').val();

                    if ($.isNumeric(kuantitas)) {
                        const totalHarga = kuantitas * hargaProduk;
                        $('#total-harga').val(totalHarga);
                    }
                });

                $(window).on('load', function() {
                    $('#kuantitas').trigger('input');
                });
            });
        </script>
    @endsection
