<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>struk 64Mart</title>
    <style>
        body {
            padding: 10px;
            margin: 0px;
            list-style-type: none;
        }

        .header {
            display: flex;
            width: 100%;
            justify-content: center;
            margin: 0 auto;
        }

        .header1 {
            padding: 0px;
            padding-top: 0px;
            margin-top: 1px;
            margin-left: 10px;
            font-size: 25px;

        }

        .header2 {
            padding: 0px;
            padding-top: 0px;
            margin-top: 1px;
            margin-right: 10px;
            font-size: 25px;
        }

        hr {
            border: 1px dashed #000;
            margin-left: 2px;
            margin-top: 5px;
        }

        .subjudul {
            display: flex;
            width: 100%;
            justify-content: space-between;
            margin: 0 auto;
            font-size: 1.2rem;

        }

        .subheader1 {
            padding: 0px;
            padding-top: 0px;
            margin-top: 5px;
            margin-left: 10px;
            list-style-type: none;
        }

        .subheader2 {
            padding: 0px;
            padding-top: 5px;
            margin-top: 1px;
            margin-right: 10px;
        }

        tr,
        th {
            font-size: 10px;
        }

        .table {
            width: 100%;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
        }

        tr,
        td {
            font-size: 1.2rem;
        }

        table {
            border-collapse: collapse;
            width: 100%;

        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        footer {
            font-size: 1.2rem;
            border-collapse: collapse;
            padding: 20px;
            text-align: center;
            margin-top: auto;
        }
    </style>
</head>

<body>
    <div class="header">
        <center>
            <h1>64 Mart</h1>
            <p>Gifted School :, Jl. Jaani Nasir, RT.5/RW.11, Cawang, Kec. Kramat jati, Daerah Khusus Ibukota Jakarta
                13630</p>
        </center>
    </div>
    <hr style="border:1px solid black;">
    <h1>
        <center>STRUK PEMBELIAN</center>
    </h1>

    <div class="subjudul">
        <ul class="subheader1">
            <li>{{ $transaksi->kode_transaksi }}</li>
            <li>{{ $transaksi->tanggal_transaksi }}</li>
        </ul>
        <ul class="subheader2">{{ $transaksi->id_user . '/' . $transaksi->user->name }}</ul>
    </div>
    <hr />
    <div class="table">
        <table class="table1" cellpadding="50">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th style="text-align: end;">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail_transaksi as $detail)
                    <tr>
                        <td>{{ $detail->produk->nama_produk }}</td>
                        <td>{{ $detail->kuantitas }} (pcs)</td>
                        <td style="text-align: end;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="subtotal" colspan="3"><br>
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td class="subtotal" colspan="2">Subtotal</td>
                    <td style="text-align: end;">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="diskon" colspan="2">Diskon</td>
                    <td style="text-align: end;">{{ $transaksi->diskon }}%</td>
                </tr>
                <tr>
                    <td class="total" colspan="2">Total</td>
                    <td style="text-align: end;">Rp
                        {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td class="payment" colspan="2">Pembayaran</td>
                    <td style="text-align: end;">Rp
                        {{ number_format($transaksi->payment, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td class="change" colspan="2">Kembalian</td>
                    <td style="text-align: end;">Rp
                        {{ number_format($transaksi->change, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <br />
    <br />
    <br />
    </div>
    <footer>Terimakasih Sudah Berbelanja :)</footer>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            function printAndRedirect() {
                window.print();

                window.onafterprint = function() {
                    // window.history.back();
                    window.location.href = "{{ route(auth()->user()->role . '.transaksi.index') }}";
                };
            }
            printAndRedirect();
        });
    </script>
</body>

</html>
