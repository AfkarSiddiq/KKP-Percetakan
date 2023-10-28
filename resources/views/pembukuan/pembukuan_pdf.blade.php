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
<h3 align="center">PEMBUKUAN</h3>
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
                <th>Tanggal</th>
                <th>Nama Item</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Pembayaran</th>
            </tr>
        </thead>
        <tbody align="center">
            @php
                $no = 1;
                $prevDate = null;
            @endphp
            @foreach ($ar_pemasukan as $trs)
                {{-- make tgl format to dd/mm/yy year just 2 digit on the last --}}
                @php
                    $trs->tgl = date('d/m/y', strtotime($trs->tgl));
                @endphp
                <tr>
                    {{-- convert numeric to rupiah --}}
                    @php
                        $jumlah = number_format($trs->jumlah, 0, ',', '.');
                        // convert updated_at to tgl without hsi
                        $tgl = explode(' ', $trs->updated_at);
                        $tanggal = $tgl[0];
                        $tanggal = date('d/m/y', strtotime($tanggal));
                        // make first letter of pembayaran to uppercase
                        $trs->pembayaran = ucfirst($trs->pembayaran);
                    @endphp
                    <td>{{ $no }}</td>
                    {{-- if tanggal still same from loop before just use tanggal from first item --}}
                    @if ($prevDate == $tanggal)
                        <td></td>
                    @else
                        <td>{{ $tanggal }}</td>
                    @endif
                    <td>{{ $trs->transaksi->barang->kode }} - {{ $trs->transaksi->barang->nama_barang }}</td>
                    <td>Rp. {{ $jumlah }}</td>
                    <td></td>
                    <td>{{ $trs->pembayaran }}</td>
                    @php
                        $no++;
                        $prefDate = $tanggal;
                    @endphp
            @endforeach
            @foreach ($ar_pengeluaran as $trs)
                {{-- make tgl format to dd/mm/yy year just 2 digit on the last --}}
                @php
                    $trs->tgl = date('d/m/y', strtotime($trs->tgl));
                @endphp
                <tr>
                    {{-- convert numeric to rupiah --}}
                    @php
                        $jumlah = number_format($trs->jumlah, 0, ',', '.');
                        // convert updated_at to tgl without hsi
                        $tgl = explode(' ', $trs->tanggal);
                        $tanggal = $tgl[0];
                        $tanggal = date('d/m/y', strtotime($tanggal));
                        // make first letter of pembayaran to uppercase
                        $trs->pembayaran = ucfirst($trs->pembayaran);
                    @endphp
                    <td>{{ $no }}</td>
                    {{-- if tanggal still same from loop before just use tanggal from first item --}}
                    @if ($tanggal == $prefDate)
                        <td></td>
                    @else
                        <td>{{ $tanggal }}</td>
                    @endif
                    <td>{{ $trs->nama }}</td>
                    <td></td>
                    <td>Rp. {{ $jumlah }}</td>
                    <td>{{ $trs->pembayaran }}</td>
                    @php
                        $no++;
                        $prefDate = $tanggal;
                    @endphp
            @endforeach
            @php
                $total_pemasukan = number_format($total_pemasukan, 0, ',', '.');
                $total_pengeluaran = number_format($total_pengeluaran, 0, ',', '.');
            @endphp
            <tr>
                <td></td>
                <td>Uang Masuk:</td>
                <td></td>
                <td>Rp. {{ $total_pemasukan }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Uang Keluar:</td>
                <td></td>
                <td></td>
                <td>Rp. {{ $total_pengeluaran }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <table style="margin-top: 2em" align="center" cellpadding="4" cellspacing="0" width="100%">
        <tBody style="font-size: 12px">
            <tr>
                <td></td>
                <td><strong>Omset</strong></td>
                <td></td>
                <td></td>
                <th>Rp. {{ $omset }}</th>
            </tr>
            <tr>
                <td></td>
                <td><strong>Uang Laci</strong></td>
                <td></td>
                <td></td>
                <th>Rp. {{ $uang_laci }}</th>
            </tr>
            <tr>
                <td></td>
                <td><strong>Uang Rekening</strong></td>
                <td></td>
                <td></td>
                <th>Rp. {{ $uang_transfer }}</th>
            </tr>
        </tBody>
    </table>
</div>
<script>
    window.print();
</script>
