@extends('admin.index')
@section('content')
    <!-- <div class="container-fluid px-4"> -->
    <div class="row">
        <div class="card w-100">
            <div class="card-body p-4">
                <h1 class="mt-4">{{ $title }}</h1>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success" hidden>
                        <p id="message">{{ $message }}</p>
                        <script>
                            Swal.fire({
                                title: 'Success',
                                text: $('#message').text(),
                                icon: 'Success',
                                confirmButtonText: 'Cool'
                            })
                        </script>
                    </div>
                @endif
                <br />
                <a href="{{ route('suplaibahan.create') }}" class="btn btn-primary col-md-1">Tambah</a>
                <div class="table-responsive">
                    <br>
                    <table class="table table-hover" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bahan</th>
                                <th>Jumlah Masuk</th>
                                <th>Tanggal Masuk</th>
                                <th>keterangan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($ar_suplai_bahan as $data)
                                <tr>
                                    <th>{{ $no }}</th>
                                    <td>{{ $data->bahan->nama_bahan }}</td>
                                    <td>{{ $data->jumlah }}</td>
                                    <td>{{ $data->tgl }}</td>
                                    <td>{{ $data->keterangan }}</td>
                                    <td align="justify">
                                        <form id='deleteForm' method="POST"
                                            action="{{ route('suplaibahan.destroy', $data->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            @if (Auth::user()->level != 'kasir')
                                                <a class="btn btn-warning btn-sm"
                                                    href="{{ route('suplaibahan.edit', $data->id) }}" title="ubah">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endif
                                            @if (Auth::user()->level == 'admin')
                                                <button onclick="deleteData(this)" type="button"
                                                    class="btn btn-danger show_confirm btn-sm">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>

                                @php $no++ @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ url('/suplaibahan-pdf') }}" class="btn btn-primary">Cetak PDF</a>
                </div>
                <br>
                <!-- </div> -->
            </div>
        </div>
    </div>
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
