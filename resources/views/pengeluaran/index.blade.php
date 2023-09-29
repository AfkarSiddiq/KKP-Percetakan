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
                <a href="{{ route('pengeluaran.create') }}" class="btn btn-primary">Tambah</a>
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
                        <select class="col-md ms-1 form-select" name="status" id="status" style="display: none">
                            <option value="">Semua</option>
                        </select>
                    </tr>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pengeluaran</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Pembayaran</th>
                                <th>Penanggung Jawab</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($ar_pengeluaran as $trs)
                                <tr>
                                    <th>{{ $no }}</th>
                                    <td>{{ $trs->nama }}</td>
                                    <td>{{ $trs->tanggal }}</td>
                                    <td>{{ $trs->jumlah }}</td>
                                    <td>{{ $trs->pembayaran }}</td>
                                    <td>{{ $trs->user->name }}</td>
                                    <td>
                                        <form class="d-flex justify-content-around" id='deleteForm' method="POST"
                                            action="{{ route('pengeluaran.destroy', $trs->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a target="_blank" class="btn btn-primary btn-sm"
                                                href="{{ url('/struk', $trs->id) }}" title="Print Struk">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            @if (Auth::user()->level != 'kasir')
                                                <a class="btn btn-warning btn-sm"
                                                    href="{{ route('pengeluaran.edit', $trs->id) }}" title="Ubah">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
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
