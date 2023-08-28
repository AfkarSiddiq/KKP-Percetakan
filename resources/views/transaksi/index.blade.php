@extends('admin.index')
@section('content')
    <!-- <div class="container-fluid px-4"> -->
    <div class="row">
        <div class="card w-100">
            <div class="card-body p-4">
                <h1 class="mt-4">Daftar Transaksi</h1>
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
                <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Tambah</a>
                <div class="container row mt-3 mb-3">
                    <tr>
                        <div class="col-md form-control me-1">
                            <td>Minimum date:</td>
                            <td><input style="border: none" type="text" id="minDate" name="minDate"></td>
                        </div>
                        <div class="col-md form-control ms-1">
                            <td>Maximum date:</td>
                            <td><input style="border: none" type="text" id="maxDate" name="maxDate"></td>
                        </div>
                    </tr>
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
                                <th>Keterangan</th>
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
                                    <td>{{ $trs->kode }} - {{ $trs->barang }}</td>
                                    <td>{{ $trs->pelanggan }}</td>
                                    @if ($trs->status == 1)
                                        <td>Member</td>
                                    @elseif ($trs->status == 0)
                                        <td>Bukan Member</td>
                                    @elseif ($trs->status == 2)
                                        <td>Studio</td>
                                    @endif
                                    <td>{{ $trs->tgl }}</td>
                                    <td>{{ $trs->jumlah }}</td>
                                    <td>{{ $trs->panjang }}</td>
                                    <td>{{ $trs->lebar }}</td>
                                    <td>Rp. {{ $trs->total_harga }}</td>
                                    <td>{{ $trs->keterangan }}</td>
                                    <td>
                                        <form id='deleteForm' method="POST"
                                            action="{{ route('transaksi.destroy', $trs->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a class="btn btn-warning btn-sm"
                                                href="{{ route('transaksi.edit', $trs->id) }}" title="Ubah">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if (Auth::user()->level == 'admin')
                                                <!-- hapus data -->
                                                <button onclick="deleteData(this)" type="button"
                                                    class="btn btn-danger show_confirm btn-sm">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            @endif
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
    <!-- </div> -->
    <script>
        function deleteData(button) {
            var form = button.closest('form'); // Find the parent form element
            if (form) {
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        form.submit(); // Submit the parent form
                    } else {
                        swal('Your data is safe');
                    }
                });
            }
        }
    </script>
@endsection
