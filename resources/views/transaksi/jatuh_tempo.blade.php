@extends('admin.index')
@section('content')
    <!-- <div class="container-fluid px-4"> -->
    <div class="row">
        <div class="card w-100">
            <div class="card-body p-4">
                <h1 class="mt-4">{{ $title }}</h1>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success" hidden>
                        <p id='message'>{{ $message }}</p>
                    </div>
                    <script>
                        Swal.fire({
                            title: 'Success',
                            text: $('#message').text(),
                            icon: 'Success',
                            confirmButtonText: 'Oke!'
                        })
                    </script>
                @endif
                <br />
                <div class="container row mt-3 mb-3">
                    <div style="display: none">
                        <div class="col-md form-control me-1">
                            <td>Minimum date:</td>
                            <td><input style="border: none" type="text" id="minDate" name="minDate"></td>
                        </div>
                        <div class="col-md form-control ms-1">
                            <td>Maximum date:</td>
                            <td><input style="border: none" type="text" id="maxDate" name="maxDate"></td>
                        </div>
                        <select class="col-md ms-1 form-select" name="status" id="status">
                            <option selected value="">Belum Lunas</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md form-control me-1">
                            <td>Tanggal Hari Ini</td>
                            <td>:</td>
                            <td>
                                {{-- tampilkan tanggal hari ini --}}
                                @php
                                    $tgl = date('d/m/Y');
                                @endphp
                                <input style="border: none" type="text" id="tgl" name="tgl"
                                    value="{{ $tgl }}" readonly>
                            </td>
                        </div>
                        <div class="col-md form-control ms-1">
                            <td>Jatuh Tempo</td>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Nama Pelanggan</th>
                                <th>Status Member</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Panjang</th>
                                <th>Lebar</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($ar_transaksi as $trs)
                                <tr>
                                    <th>{{ $no }}</th>
                                    <td>{{ $trs->barang->kode }} - {{ $trs->barang->nama_barang }}</td>
                                    <td>{{ $trs->pelanggan->nama }}</td>
                                    @if ($trs->pelanggan->status_member == 1)
                                        <td>Member</td>
                                    @elseif ($trs->pelanggan->status_member == 0)
                                        <td>Bukan Member</td>
                                    @elseif ($trs->pelanggan->status_member == 2)
                                        <td>Studio</td>
                                    @endif
                                    <td>{{ $trs->tgl }}</td>
                                    <td>{{ $trs->jumlah }}</td>
                                    <td>{{ $trs->panjang }}</td>
                                    <td>{{ $trs->lebar }}</td>
                                    <td>Rp. {{ $trs->total_harga }}</td>
                                    <td>
                                        <span class="badge bg-danger">Jatuh Tempo</span>
                                    </td>
                                    <td>
                                        <form id='deleteForm' method="POST"
                                            action="{{ route('transaksi.destroy', $trs->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a target="_blank" class="btn btn-primary btn-sm"
                                                href="{{ url('/struk', $trs->id) }}" title="Print Struk">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <a class="btn btn-warning btn-sm"
                                                href="{{ route('transaksi.editLunas', $trs->id) }}" title="Pelunasan">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <input type="hidden" name="idx" value="" />
                                        </form>
                                    </td>
                                </tr>
                                @php $no++ @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{ url('/transaksi-pdf') }}" class="btn btn-primary">Cetak PDF</a>
                <!-- <a href="{{ url('/transaksi-excel') }}" class="btn btn-primary">Cetak Excel</a> -->
            </div>
        </div>
    </div>
@endsection
