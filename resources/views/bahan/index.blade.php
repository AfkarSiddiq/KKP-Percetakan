@extends('admin.index')
@section('content')
    <!-- <div class="container-fluid px-4"> -->
    <div class="row">
        <div class="card w-100">
            <div class="card-body p-4">
                <h1 class="mt-4">Data bahan</h1>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success" hidden>
                        <p id='message'>{{ $message }}</p>
                        <script>
                            Swal.fire({
                                title: 'Success',
                                text: $('#message').text(),
                                icon: 'Success',
                                confirmButtonText: 'Oke!'
                            })
                        </script>
                    </div>
                @elseif ($message = Session::get('error'))
                    <div class="alert alert-danger" hidden>
                        <p id="message">{{ $message }}</p>
                        <script>
                            Swal.fire({
                                title: 'Failed',
                                text: $('#message').text(),
                                icon: 'error',
                                confirmButtonText: 'Oke!'
                            })
                        </script>
                    </div>
                @endif
                <br />
                @if (Auth::user()->level != 'kasir')
                    <a href="{{ route('bahan.create') }}" class="btn btn-primary">Tambah</a>
                @endif
                <div class="table-responsive">
                    <br>
                    <table class="table table-hover" id="datatablesSimple">
                        <thead align="center">
                            <tr>
                                <th>No</th>
                                <th>Nama bahan</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Produk</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($ar_bahan as $data)
                                <tr>
                                    <th>{{ $no }}</th>
                                    <td>{{ $data->nama_bahan }}</td>
                                    <td>{{ $data->jumlah }}</td>
                                    <td>{{ $data->satuan }}</td>
                                    <td>
                                        @foreach ($data->barang as $barang)
                                            @if ($loop->iteration <= 2 && $loop->count > 1)
                                                {{ $barang->nama_barang }},
                                            @elseif ($loop->count == 1)
                                                {{ $barang->nama_barang }}
                                            @elseif ($loop->count > 2)
                                                ...
                                            @break
                                        @endif
                                    @endforeach
                                </td>
                                <td align="justify">
                                    <form class="d-flex justify-content-around" id='deleteForm' method="POST"
                                        action="{{ route('bahan.destroy', $data->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <!-- detail data -->
                                        <a class="btn btn-info btn-sm" href="{{ route('bahan.show', $data->id) }}"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <!-- ubah data -->
                                        @if (Auth::user()->level != 'kasir')
                                            <a class="btn btn-warning btn-sm"
                                                href="{{ route('bahan.edit', $data->id) }}" title="ubah">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        @endif
                                        <!-- hapus data -->
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
            </div>
        </div>
    </div>
    <!-- </div> -->
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
