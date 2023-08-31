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

        .rekening {
            text-align: left;
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
            <img src="{{ asset('assets/img') }}/{{ $toko->logo }}" alt="Logo" class="logo">
            <div class="store-info">
                <strong style="font-size: 16px">{{ $toko->nama }}</strong>
                <p style="font-size: 12px">{{ $toko->alamt }}</p>
                <p style="font-size: 12px">{{ $toko->no_telp }}</p>
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
                        <td>{{ $pelanggan->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong> Jumlah Hutang </strong></td>
                        <td><strong>:</strong></td>
                        @php
                            $hutangFormat = number_format($hutang, 0, ',', '.');
                        @endphp
                        <td><strong>Rp. {{ $hutangFormat }}</strong></td>
                    </tr>
                    <tr>
                        <td>Dari Tanggal</td>
                        <td>:</td>
                        <td>{{ $tgl_mulai }}</td>
                        <td>-</td>
                        <td>{{ $tgl_akhir }}</td>
                    </tr>
                </table>
            </div>
            <div class="transaction-details">
                {{-- split and convert time from database date and its time --}}
                @php
                    //get datetime now indonesia
                    date_default_timezone_set('Asia/Jakarta');
                    $now = date('Y-m-d H:i:s');
                    $tgl = explode(' ', $now);
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
                    <th>Status</th>
                    <th>Harga</th>
                    <th>Size (P x L)</th>
                    <th>Qty</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through transaction items here -->
                @php
                    $no = 1;
                    $total = 0;
                    $totalBayar = 0;
                @endphp
                @foreach ($ar_transaksi as $transaksi)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $transaksi->barang->kode }} - {{ $transaksi->barang->nama_barang }}</td>
                        @if ($transaksi->status == 1)
                            <td>Lunas</td>
                        @else
                            <td>Belum Lunas</td>
                        @endif
                        {{-- covert harga to fromat rupiah from numeric --}}
                        @php
                            $harga = number_format($transaksi->harga, 0, ',', '.');
                        @endphp
                        <td>Rp. {{ $harga }}</td>
                        <td>{{ $transaksi->panjang }} x {{ $transaksi->lebar }} M</td>
                        <td>{{ $transaksi->jumlah }}</td>
                        {{-- covert sub total to fromat rupiah from numeric --}}
                        @php
                            $sub_total = number_format($transaksi->total_harga, 0, ',', '.');
                        @endphp
                        <td>Rp. {{ $sub_total }}</td>
                    </tr>
                    @php
                        $no++;
                        $total += $transaksi->total_harga;
                        $totalBayar += $transaksi->total_bayar;
                    @endphp
                @endforeach
                <!-- Add more rows as needed -->
            </tbody>
        </table>

        {{-- covert sisa to format rupih from numeric --}}
        @php
            $sisa = number_format($hutang, 0, ',', '.');
            $total = number_format($total, 0, ',', '.');
            $totalBayar = number_format($totalBayar, 0, ',', '.');
        @endphp

        <div class="total-sisa">
            <div class="status-box-3 grid-item">
                <div class="status-box">
                    <div class="status-box-2">
                        @if ($hutang == 0)
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
                <p>Total yang sudah dibayar: Rp. {{ $totalBayar }}</p>
            </div>
            <div class="total grid-item">
                <h4>Total: Rp. {{ $total }}</h4>
            </div>
            <div class="grid-item rekening">
                <p>No. Rekening: {{ $toko->no_rekening }}</p>
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
