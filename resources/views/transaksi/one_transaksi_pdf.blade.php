<!DOCTYPE html>
<html>

<head>
    <title>Faktur Penjualan</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .logo {
            width: 100px;
            height: 40px;
        }

        .store-info {
            text-align: left;
            flex: 1;
            margin-left: 2em
        }

        .title {
            text-align: right;
            margin-left: 2em
        }

        .customer {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .customer-details {
            flex: 1;
        }

        .transaction-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .transaction-table th,
        .transaction-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center
        }

        .status-box {
            margin-top: 10px;
            display: inline-block;
        }

        .status-box,
        .status-box-2 {
            border: 2px solid #000;
            padding: 4px;
            display: inline-block;
        }

        .total {
            text-align: right;
        }

        .sisa {
            text-align: right;
        }

        .total-sisa {
            display: grid;
            grid-template-columns: auto auto auto;
            align-items: center;
        }

        .signature {
            justify-content: flex-end;
            display: grid;
            grid-template-columns: auto auto auto;
            align-items: flex-start;
        }

        .signature .nama {
            padding-top: 50px;
        }

        .user-signature {
            text-align: center;
            margin-right: 2em
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo">
            <div class="store-info">
                <strong style="font-size: 16px">Pacific Printing</strong>
                <p style="font-size: 12px">Jl. Prof. Ali Hasyimi No.7, Lamteh, Ulee Kareng, Kota Banda Aceh</p>
                <p style="font-size: 12px">0823 2121 6131</p>
            </div>
            <div class="title">
                <h4>Faktur Penjualan</h4>
            </div>
        </div>
        <hr>

        <div class="customer">
            <div class="customer-details">
                <table>
                    <tr>
                        <td>Nama Pelanggan</td>
                        <td>:</td>
                        <td>{{ $ar_transaksi->pelanggan->nama }}</td>
                    </tr>
                </table>
            </div>
            <div class="transaction-details">
                {{-- split and convert time from database date and its time --}}
                @php
                    $tgl = explode(' ', $ar_transaksi->updated_at);
                    $tanggal = $tgl[0];
                    $jam = $tgl[1];
                @endphp
                <table>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{ $tanggal }}</td>
                    </tr>
                    <tr>
                        <td>Jam</td>
                        <td>:</td>
                        <td>{{ $jam }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <table class="transaction-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Keterangan</th>
                    <th>Harga</th>
                    <th>Size (P x L)</th>
                    <th>Qty</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through transaction items here -->
                <tr>
                    <td>1</td>
                    <td>{{ $ar_transaksi->barang->kode }} - {{ $ar_transaksi->barang->nama_barang }}</td>
                    <td>{{ $ar_transaksi->keterangan }}</td>
                    {{-- covert harga to fromat rupiah from numeric --}}
                    @php
                        $harga = number_format($ar_transaksi->harga, 0, ',', '.');
                    @endphp
                    <td>Rp. {{ $harga }}</td>
                    <td>{{ $ar_transaksi->panjang }} x {{ $ar_transaksi->lebar }} M</td>
                    <td>{{ $ar_transaksi->jumlah }}</td>
                    {{-- covert sub total to fromat rupiah from numeric --}}
                    @php
                        $sub_total = number_format($ar_transaksi->total_harga, 0, ',', '.');
                    @endphp
                    <td>Rp. {{ $sub_total }}</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>

        {{-- covert sisa to format rupih from numeric --}}
        @php
            $sisa = number_format($ar_transaksi->sisa, 0, ',', '.');
        @endphp

        <div class="total-sisa">
            <div class="status-box-3 grid-item">
                <div class="status-box">
                    <div class="status-box-2">
                        @if ($ar_transaksi->status == '1')
                            @php
                                $lunas = 'Lunas';
                            @endphp
                        @else
                            @php
                                $lunas = 'Belum Lunas';
                            @endphp
                        @endif
                        <p>Status: {{ $lunas }}</p>
                    </div>
                </div>
            </div>
            <div class="sisa grid-item">
                <h4>Sisa: Rp. {{ $sisa }}</h4>
            </div>
            <div class="total grid-item">
                <h4>Total: Rp. {{ $sub_total }}</h4>
            </div>
            <div class="grid-item"></div>

        </div>

        <div class="user-signature">
            <div class="signature">
                <div class="grid-item"></div>
                <div class="grid-item"></div>
                <p class="grid-item">Hormat Kami,</p>
                <div class="grid-item"></div>
                <div class="grid-item"></div>
                <div class="grid-item"></div>
                <div class="grid-item"></div>
                <div class="grid-item"></div>
                <!-- Replace with user's name -->
                <p class="grid-item nama">{{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>
</body>
<script>
    window.print();
</script>

</html>
