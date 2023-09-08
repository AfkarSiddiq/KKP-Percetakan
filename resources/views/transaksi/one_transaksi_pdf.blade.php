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
            width: 150px;
            height: 60px;
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

        .rekening {
            text-align: left;
            width: fit-content;
            margin-left: 10px;
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
                    @php
                        $tgl = explode(' ', $ar_transaksi->updated_at);
                        $tanggal = $tgl[0];
                        // make tanggal format is d-m-y
                        $tanggal = date('d/m/Y', strtotime($tanggal));
                        $jam = $tgl[1];
                        // make format nota mmddyy-hhmmss
                        $nota = date('mdy', strtotime($tanggal)) . '/' . date('His', strtotime($jam));
                        // uppercase kodenota
                        $toko->kode_nota = strtoupper($toko->kode_nota);
                    @endphp
                    <table>
                        <tr>
                            <td>Customer</td>
                            <td>:</td>
                            <td>{{ $ar_transaksi->pelanggan->nama }}</td>
                        </tr>
                        <tr>
                            <td>Nota</td>
                            <td>:</td>
                            <td>{{ $toko->kode_nota }}{{ $nota }}</td>
                        </tr>
                        <tr>
                            {{-- make pembayaran value is uppercase on first alphabet --}}
                            @php
                                $ar_transaksi->pembayaran = ucfirst($ar_transaksi->pembayaran);
                            @endphp
                            <td>Pembayaran</td>
                            <td>:</td>
                            <td>{{ $ar_transaksi->pembayaran }}</td>
                        </tr>
                    </table>
                </div>
                <div class="transaction-details">
                    {{-- split and convert time from database date and its time --}}
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
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Keterangan</th>
                    <th>Harga</th>
                    <th>Size</th>
                    <th>Qty</th>
                    <th>Sub Total</th>
                </tr>
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
                    <td>
                        @if (strtolower($ar_transaksi->barang->satuan) == 'pcs')
                            Pcs
                        @else
                            {{ $ar_transaksi->panjang }} M x {{ $ar_transaksi->lebar }} M
                        @endif
                    </td>
                    <td>{{ $ar_transaksi->jumlah }}</td>
                    {{-- covert sub total to fromat rupiah from numeric --}}
                    @php
                        $sub_total = number_format($ar_transaksi->total_harga, 0, ',', '.');
                    @endphp
                    <td>Rp. {{ $sub_total }}</td>
                </tr>
                <!-- Add more rows as needed -->
            </table>

            {{-- covert sisa to format rupih from numeric --}}
            @php
                $sisa = number_format($ar_transaksi->sisa, 0, ',', '.');
            @endphp
            <div class="transaction-table-2">
                @if ($ar_transaksi->status == '1')
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
                <div class="sisa">
                    Sisa: Rp. {{ $sisa }}
                </div>
                <div class="total">
                    Total: Rp. {{ $sub_total }}
                </div>
            </div>
            <hr>
            <div class=" rekening">
                @php
                @endphp
                No. Rekening: {{ $toko->no_rekening }} A.N {{ $toko->nama }}
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
    </div>
    <hr class="dashed">
</body>
<script>
    window.print();
</script>

</html>
