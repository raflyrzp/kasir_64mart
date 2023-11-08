@extends('layout/main')

@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldArrow---Down-Square"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Income</h6>
                                        <h6 class="font-extrabold mb-0">Rp.
                                            {{ number_format($total_seluruh_pemasukan, 0, ',', '.') }},-</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldArrow---Up-Square"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Outcome</h6>
                                        <h6 class="font-extrabold mb-0">Rp.
                                            {{ number_format($total_seluruh_pengeluaran, 0, ',', '.') }},-</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldActivity"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Profit</h6>
                                        <h6 class="font-extrabold mb-0">
                                            Rp. {{ number_format($total_seluruh_keuntungan, 0, ',', '.') }},-</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldBuy"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Selling</h6>
                                        <h6 class="font-extrabold mb-0">{{ $total_penjualan_produk }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (count($produk_menipis) !== 0)
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Depleted Products</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table" id="table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Product code</th>
                                                    <th>Product name</th>
                                                    <th>Stock</th>
                                                    <th>Price</th>
                                                    <th>Category</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($produk_menipis as $i => $produk)
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $produk->kode_produk }}</td>
                                                        <td>{{ $produk->nama_produk }}</td>
                                                        <td class="text-danger">{{ $produk->stok }}</td>
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
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Profit Graph</h4>
                            </div>
                            <div class="card-body">
                                <div id="bar"></div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>

    {{-- PROFIT GRAPH --}}
    <script>
        const bulanLabels = @json(array_column($monthlyData, 'bulan'));
        const totalPemasukanData = @json(array_column($monthlyData, 'total_pemasukan'));
        const totalPengeluaranData = @json(array_column($monthlyData, 'total_pengeluaran'));
        const keuntunganData = @json(array_column($monthlyData, 'keuntungan'));

        var barOptions = {
            series: [{
                    name: "Income",
                    data: totalPemasukanData,
                    color: '#32CD32',
                },
                {
                    name: "Outcome",
                    data: totalPengeluaranData,
                    color: '#FF0000',
                },
                {
                    name: "Profit",
                    data: keuntunganData,
                    color: '#1E90FF',
                },
            ],
            chart: {
                type: "bar",
                height: 350,
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "55%",
                    endingShape: "rounded",
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                show: true,
                width: 2,
                colors: ["transparent"],
            },
            xaxis: {
                categories: bulanLabels,
            },
            yaxis: {
                title: {
                    text: "Rupiah",
                },
            },
            fill: {
                opacity: 1,
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(val);
                    },
                },
            },
        };

        var bar = new ApexCharts(document.querySelector("#bar"), barOptions);
        bar.render();
    </script>
@endsection
