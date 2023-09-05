<style>
    .body>table {
        font-size: 10px;
    }

    .body {
        font-family: sans-serif;
        font-size: 12px;
    }
</style>
<link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}">
<h3 align="center">DAFTAR TRANSAKSI</h3>
<div class="body">
    {{-- format tgl to dd/mm/yy --}}
    @php
        $tgl_mulai = date('d/m/y', strtotime($tgl_mulai));
        $tgl_akhir = date('d/m/y', strtotime($tgl_akhir));
    @endphp
    <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td>{{ $tgl_mulai }}</td>
        <td>-</td>
        <td>{{ $tgl_akhir }}</td>
    </tr>
    <table style="margin-top: 2em" border="1" align="center" cellpadding="4" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Costumer</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Qty</th>
                <th>Size</th>
                <th>Total Harga</th>
                <th>Total Bayar</th>
                <th>Sisa</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody align="center">
            @php
                $no = 1;
                $pemasukan = 0;
                $sisaTotal = 0;
            @endphp
            @foreach ($ar_transaksi as $trs)
                {{-- make tgl format to dd/mm/yy year just 2 digit on the last --}}
                @php
                    $trs->tgl = date('d/m/y', strtotime($trs->tgl));
                @endphp
                <tr>
                    {{-- convert numeric to rupiah --}}
                    @php
                        $total_harga = number_format($trs->total_harga, 0, ',', '.');
                        $total_bayar = number_format($trs->total_bayar, 0, ',', '.');
                        $sisa = number_format($trs->sisa, 0, ',', '.');
                    @endphp
                    <th>{{ $no }}</th>
                    <td>{{ $trs->barang->kode }} - {{ $trs->barang->nama_barang }}</td>
                    <td>{{ $trs->pelanggan->nama }}</td>
                    @if ($trs->pelanggan->status_member == 1)
                        <td>Member</td>
                    @elseif ($trs->pelanggan->status_member == 2)
                        <td>Studio</td>
                    @elseif ($trs->pelanggan->status_member == 0)
                        <td>Bukan Member</td>
                    @endif
                    <td>{{ $trs->tgl }}</td>
                    <td>{{ $trs->jumlah }}</td>
                    <td>{{ $trs->panjang }} x {{ $trs->lebar }}</td>
                    <td>Rp. {{ $total_harga }}</td>
                    <td>Rp. {{ $total_bayar }}</td>
                    <td>Rp. {{ $sisa }}</td>
                    <td>
                        @if ($trs->status == 0)
                            <span class="badge bg-danger">Belum Lunas</span>
                        @elseif ($trs->status == 1)
                            <span class="badge bg-success">Lunas</span>
                        @endif
                    </td>
                </tr>
                @php
                    $no++;
                    $pemasukan += $trs->total_bayar;
                    $sisaTotal += $trs->sisa;
                @endphp
            @endforeach
            <tr>
                <td></td>
                <td><strong>Pemasukan :</strong></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                @php
                    $pemasukan = number_format($pemasukan, 0, ',', '.');
                @endphp
                <td><strong>Rp. {{ $pemasukan }}</strong></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td><strong>Sisa :</strong></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                @php
                    $sisaTotal = number_format($sisaTotal, 0, ',', '.');
                @endphp
                <td></td>
                <td><strong>Rp. {{ $sisaTotal }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>
<script>
    window.print();
</script>
