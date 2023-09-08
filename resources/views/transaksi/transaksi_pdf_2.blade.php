<!DOCTYPE html>
<html>

<head>
    <title>FAKTUR PENJUALAN</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .body {
            font-size: 12px;
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
            width: 200px;
            height: 80px;
        }

        .store-info {
            text-align: left;
            flex: 1;
            margin-left: 0.5em;
            margin-bottom: 0;
        }

        .title {
            text-align: right;
            margin-left: 2em;
            font-size: 20px;
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

        .transaction-table-2 {
            text-align: center;
            display: flex;
            flex-direction: row;
            margin: 10px;
            align-items: center;
        }

        .transaction-table-2>div {
            width: 100%;
            margin: 10px;
            text-align: center;
            line-height: inherit;
        }

        .transaction-table-2 .sisa,
        .transaction-table-2 .total {
            margin: 10px;
            text-align: right;
            font-weight: bold;
            width: 50%;
        }

        .rekening {
            text-align: left;
            width: fit-content;
            margin-left: 1.5em;
        }

        .transaction-table-2 .lunas {
            width: 100%;
            padding-left: 1.5em;
            padding-right: 1.5em;
            padding-top: 0.5em;
            padding-bottom: 0.5em;
            border: 1px solid #000;
        }

        .transaction-table-2 .lunas-luar {
            border: 1px solid #000;
            padding: 2px;
            width: 20%;
            justify-content: center;
            display: flex;
        }

        .transaction-table th,
        .transaction-table tr,
        .transaction-table td {
            border-block-start: 1px solid #c6c6c6;
            border-block-end: 1px solid #c6c6c6;
            padding: 4px;
            text-align: center
        }

        .signature {
            justify-content: flex-end;
            display: grid;
            grid-template-columns: auto auto auto;
            align-items: flex-start;
        }

        .signature .nama {
            padding-top: 25px;
        }

        .user-signature {
            text-align: center;
            margin-right: 2em
        }

        .dashed {
            border-top: 2px dashed #bbb;
        }

        #nama_toko {
            margin-left: 0;
            margin-right: 0;
            margin-top: 0;
            margin-bottom: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/img') }}/{{ $toko->logo }}" alt="Logo" class="logo">
            <div class="store-info">
                {{-- capital the nama toko --}}
                @php
                    $toko->nama = strtoupper($toko->nama);
                @endphp
                <p id="nama_toko" style="font-size: 20px">{{ $toko->nama }}</p>
                <p style="font-size: 10px; margin:0;">{{ $toko->alamat }}</p>
                <p style="font-size: 11px; margin:0;">{{ $toko->no_telp }}</p>
            </div>
            <div class="title">
                <p>FAKTUR PENJUALAN</p>
            </div>
        </div>
        <hr>

        <div class="body">
            <div class="customer">
                <div class="customer-details">
                    <table>
                        {{-- split and convert time from database date and its time --}}
                        @php
                            //get datetime now indonesia
                            date_default_timezone_set('Asia/Jakarta');
                            $now = date('d/m/Y H:i:s');
                            $tgl = explode(' ', $now);
                            $tanggal = $tgl[0];
                            $jam = $tgl[1];
                            // make format nota mmddyy-hhmmss
                            $nota = date('mdy', strtotime($tanggal)) . '/' . date('His', strtotime($jam));
                            // uppercase kodenota
                            $toko->kode_nota = strtoupper($toko->kode_nota);
                        @endphp
                        <tr>
                            <td>Customer</td>
                            <td>:</td>
                            <td>{{ $pelanggan->nama }}</td>
                        </tr>
                        <tr>
                            <td>Nota</td>
                            <td>:</td>
                            <td>{{ $toko->kode_nota }}{{ $nota }}</td>
                        </tr>
                        <tr>
                            <td><strong> Sisa Hutang </strong></td>
                            <td><strong>:</strong></td>
                            @php
                                $hutangFormat = number_format($hutang, 0, ',', '.');
                            @endphp
                            <td><strong>Rp. {{ $hutangFormat }}</strong></td>
                        </tr>
                    </table>
                </div>
                <div class="transaction-details">
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
                        <tr>
                            {{-- make format tgl_mulai and tgl_akhir is d/m/y --}}
                            @php
                                $tgl_mulai = date('d/m/Y', strtotime($tgl_mulai));
                                $tgl_akhir = date('d/m/Y', strtotime($tgl_akhir));
                            @endphp
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>{{ $tgl_mulai }}</td>
                            <td>-</td>
                            <td>{{ $tgl_akhir }}</td>
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
                        <th>Size</th>
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
                            <td>
                                @if (strtolower($transaksi->barang->satuan) == 'pcs')
                                    Pcs
                                @else
                                    {{ $transaksi->panjang }} M x {{ $transaksi->lebar }} M
                                @endif
                            </td>
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

            <div class="transaction-table-2">
                @if ($hutang == 0)
                    @php
                        $lunas = 'Lunas';
                    @endphp
                @else
                    @php
                        $lunas = 'Belum Lunas';
                    @endphp
                @endif
                <div class="lunas-luar">
                    <div class="lunas">
                        {{ $lunas }}
                    </div>
                </div>
                <div class="sisa ">
                    <p>Sudah dibayar: Rp. {{ $totalBayar }}</p>
                </div>
                <div class="total ">
                    <h4>Total: Rp. {{ $total }}</h4>
                </div>
            </div>
            <hr>
            <div class="user-signature">
                <div class=" rekening">
                    @php
                    @endphp
                    No. Rekening: {{ $toko->no_rekening }} A.N {{ $toko->nama }}
                </div>
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
            <div class="dashed">

            </div>
        </div>
    </div>
</body>
<script>
    window.print();
</script>

</html>
