@extends('layout/main')

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
                    <h3>Cashier</h3>
                    <p class="text-subtitle text-muted">
                        Do the transaction here
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href='/{{ $role }}'>Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Cashier
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
                            <h4 class="card-title">Input Product</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" id="barcode-form" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" id="barcode" name="barcode" class="form-control" autofocus>
                                    </div>
                                </form>
                                <form class="form" id="form-keranjang" method="post">
                                    @csrf
                                    <div class="row">
                                        {{-- <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="id_user">Cashier</label>
                                                <input type="text" class="form-control"
                                                    value="{{ auth()->user()->name }}" readonly>
                                            </div>
                                        </div> --}}
                                        <input type="hidden" id="id_user" name="id_user"
                                            value="{{ auth()->user()->id }}">
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
                                            <div id="scanner-container"></div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="kuantitas">Quantity</label>
                                                <input type="number" id="kuantitas" class="form-control" name="kuantitas"
                                                    value="1">
                                                <small id="error-message" class="text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="harga">Price</label>
                                                <input type="text" id="harga" class="form-control" name="harga"
                                                    readonly>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <form method="post" action="{{ route('checkout', $role) }}">
            @csrf
            <div class="row">
                <div class="col-md-7 col-12">
                    <section>
                        <div class="row match-height">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h4 class="card-title">List Items</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table" id="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>Price</th>
                                                            <th class="col-2">Qty</th>
                                                            <th>Subtotal</th>
                                                            <th class="col-1">Cancel</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="list-keranjang">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </section>
                </div>

                <div class="col-md-5 col-12">
                    <section>
                        <div class="row match-height">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h4 class="card-title">Payment</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row" id="form-checkout">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <input type="hidden" id="tanggal_transaksi" class="form-control"
                                                            value="{{ now() }}" name="tanggal_transaksi" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <label for="total_harga">Total price</label>
                                                        <input type="number" id="total-harga" class="form-control"
                                                            name="total_harga" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <label for="id_diskon">Discount</label>
                                                        <select class="choices form-select" id="id_diskon"
                                                            name="id_diskon">
                                                            <option selected disabled value="{{ null }}">No
                                                                discount</option>
                                                            @foreach ($data_diskon as $diskon)
                                                                <option value="{{ $diskon->id }}">
                                                                    {{ $diskon->besar_diskon . '% (' . $diskon->nama_diskon . ')' }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <label for="payment">Payment</label>
                                                        <input type="number" id="payment" class="form-control"
                                                            name="payment" required>
                                                    </div>
                                                </div>



                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <label for="change">Change</label>
                                                        <input type="number" id="change" class="form-control"
                                                            name="change" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" id="checkout-button"
                                                    class="btn btn-primary me-1 mb-1"
                                                    onsubmit="printAndRedirect();">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </section>
                </div>
            </div>
        </form>


        {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}


        <script>
            $(document).ready(function() {
                $('#barcode-form').on('submit', function() {
                    event.preventDefault();
                    const barcode = $('#barcode').val();

                    $.ajax({
                        url: '/cari-produk',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            barcode: barcode
                        },
                        success: function(response) {
                            if (response.message === 'Item added to cart') {
                                const itemKeranjang =
                                    `<tr>
                                        <td>${response.data.nama_produk}</td>
                                        <td>${response.data.harga}</td>
                                        <td class="col-2"> <input type="number" class="form-control cart-quantity-input" name="kuantitas[]" value="1"></td>
                                        <td>${response.data.subtotal}</td>
                                        <td class="col-1">
                                            <button type="button" class="btn btn-sm btn-danger col-12 mb-1 delete-item" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal${response.data.id_produk}" data-product-id="${response.data.id_produk}"><i class="fa-fw select-all fas"></i></button>
                                        </td>
                                    </tr>`;
                                $('#list-keranjang').append(itemKeranjang);

                                $('#barcode').val('');

                                const input_checkout =
                                    `
                            <input type="hidden" name="id_produk[]" value="${response.data.id_produk}">
                            <input type="hidden" name="harga[]" value="${response.data.harga}">
                            <input type="hidden" name="subtotal[]" value="${response.data.subtotal}">
                            <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                            `;
                                $('#form-checkout').append(input_checkout);

                                const total_harga = parseFloat($('#total-harga').val());
                                if (!isNaN(total_harga)) {
                                    const new_total_harga = total_harga + response.data.subtotal;
                                    $('#total-harga').val(new_total_harga);
                                } else {
                                    $('#total-harga').val(response.data.subtotal);
                                }

                                $('#payment_id_produk').val(id_produk);
                                $('#payment_id_user').val(id_user);
                                $('#payment_kuantitas').val(kuantitas);

                                calculateTotalPrice();

                            } else {
                                alert('Product not found.');
                            }
                        },
                        error: function() {
                            alert('Error occurred while searching for the product.');
                        }
                    });
                });

                $('#id_produk').on('change', function() {
                    const id_produk = $(this).val();
                    const produk = @json($data_produk);
                    const harga_produk = produk.find(item => item.id === parseInt(id_produk))
                        ?.harga;

                    if (!isNaN(harga_produk)) {
                        $('#harga').val(harga_produk);
                    } else {
                        $('#harga').val('');
                    }
                });

                $('#form-keranjang').on('submit', function(event) {
                    event.preventDefault();
                    const produk = @json($data_produk);
                    const id_produk = $('#id_produk').val();
                    const kuantitas = $('#kuantitas').val();
                    const harga_produk = parseFloat($('#harga').val());
                    const nama_produk = $('#id_produk option:selected').text();
                    const id_user = $('#id_user').val();
                    const tanggal_transaksi = $('#tanggal_transaksi').val();
                    const kode_produk = produk.find(item => item.id === parseInt(id_produk))
                        ?.kode_produk;

                    if (kuantitas <= 0) {
                        showError('Quantity must be greater than 0');
                        return;
                    }

                    if (kuantitas > {{ $produk->stok }}) {
                        showError('Insufficient stock');
                        return;
                    }

                    const subtotal = harga_produk * kuantitas;

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('tambahKeKeranjang') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_produk: id_produk,
                            kuantitas: kuantitas,
                            total_harga: subtotal,
                            id_user: id_user,
                            tanggal_transaksi: tanggal_transaksi,
                        },
                        success: function(response) {
                            const itemKeranjang =
                                `<tr>
                                    <td>${nama_produk}</td>
                                    <td>${harga_produk}</td>
                                    <td class="col-2"> <input type="number" class="form-control cart-quantity-input" name="kuantitas[]" value="${kuantitas}"></td>
                                    <td>${subtotal}</td>
                                    <td class="col-1">
                                        <button type="button" class="btn btn-sm btn-danger col-12 mb-1 delete-item" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $produk->id }}" data-product-id="{{ $produk->id }}"><i class="fa-fw select-all fas"></i></button>
                                    </td>
                                </tr>`;
                            $('#list-keranjang').append(itemKeranjang);

                            const input_checkout =
                                `
                            <input type="hidden" name="id_produk[]" value="${id_produk}">
                            <input type="hidden" name="harga[]" value="${harga_produk}">
                            <input type="hidden" name="subtotal[]" value="${subtotal}">
                            <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                            `;
                            $('#form-checkout').append(input_checkout);

                            const total_harga = parseFloat($('#total-harga').val());
                            if (!isNaN(total_harga)) {
                                const new_total_harga = total_harga + subtotal;
                                $('#total-harga').val(new_total_harga);
                            } else {
                                $('#total-harga').val(subtotal);
                            }

                            $('#payment_id_produk').val(id_produk);
                            $('#payment_id_user').val(id_user);
                            $('#payment_kuantitas').val(kuantitas);

                            $('#id_produk').val('');
                            $('#kuantitas').val('1');
                            $('#harga').val('');
                        },
                        error: function(xhr, status, error) {
                            console.log("Error: " + error);
                        }
                    });

                    function showError(message) {
                        $('#error-message').text(message).show();
                    }
                });





                // MENGHITUNG CASHBACK
                const subtotalInput = $('#total-harga');
                const paymentInput = $('#payment');
                const changingMoneyInput = $('#change');
                const idDiskonSelect = $('#id_diskon');

                idDiskonSelect.on('change', calculateChange);

                function calculateChange() {
                    const subtotal = parseFloat(subtotalInput.val()) || 0;
                    const payment = parseFloat(paymentInput.val()) || 0;
                    const idDiskon = idDiskonSelect.val();
                    const besarDiskon = findBesarDiskonById(idDiskon);
                    const diskonNominal = (subtotal * besarDiskon) / 100;
                    const subtotalSetelahDiskon = subtotal - diskonNominal;
                    const changingMoney = payment - subtotalSetelahDiskon;

                    changingMoneyInput.val(changingMoney);
                }

                function findBesarDiskonById(idDiskon) {
                    const dataDiskon = @json($data_diskon);
                    const diskon = dataDiskon.find(d => d.id == idDiskon);
                    return diskon ? diskon.besar_diskon :
                        0;
                }
                calculateChange();


                // MENGHAPUS ITEM
                $('#list-keranjang').on('click', '.delete-item', function() {
                    var productId = $(this).data('product-id');

                    $(this).closest('tr').remove();

                    $('input[name="id_produk[]"][value="' + productId + '"]').remove();
                    $('input[name="harga[]"][value="' + productId + '"]').remove();
                    $('input[name="kuantitas[]"][value="' + productId + '"]').remove();
                    $('input[name="subtotal[]"][value="' + productId + '"]').remove();

                    calculateTotalPrice();
                });

                $('#list-keranjang').on('input', 'input[name="kuantitas[]"]', function() {
                    updateSubtotal($(this));
                });



                function updateSubtotal(inputElement) {
                    var parentRow = inputElement.closest('tr');
                    var harga = parseFloat(parentRow.find('td:eq(1)').text());
                    var kuantitas = parseFloat(inputElement.val());
                    var subtotal = harga * kuantitas;
                    parentRow.find('td:eq(3)').text(subtotal);

                    calculateTotalPrice();
                }

                function calculateTotalPrice() {
                    var totalHarga = 0;

                    $('#list-keranjang tr').each(function() {
                        var subtotal = parseFloat($(this).find('td:eq(3)').text());
                        totalHarga += subtotal;
                    });

                    $('#total-harga').val(totalHarga);
                }



                // MENGHITUNG ULANG CASHBACK
                function recalculateChange() {
                    const subtotal = parseFloat($('#total-harga').val()) || 0;
                    const idDiskon = $('#id_diskon').val();
                    const besarDiskon = findBesarDiskonById(idDiskon);
                    const diskonNominal = (subtotal * besarDiskon) / 100;
                    const subtotalSetelahDiskon = subtotal - diskonNominal;
                    const payment = parseFloat($('#payment').val()) || 0;
                    const change = payment - subtotalSetelahDiskon;
                    $('#change').val(change);
                }

                recalculateChange();

                $('#list-keranjang').on('input', '.cart-quantity-input', function() {
                    recalculateChange();
                });

                $('#list-keranjang').on('click', '.delete-item', function() {
                    recalculateChange();
                });

                $('#payment').on('input', function() {
                    recalculateChange();
                });

                function findBesarDiskonById(idDiskon) {
                    const dataDiskon = @json($data_diskon);
                    const diskon = dataDiskon.find(d => d.id == idDiskon);
                    return diskon ? diskon.besar_diskon : 0;
                }

            });
        </script>
    @endsection
