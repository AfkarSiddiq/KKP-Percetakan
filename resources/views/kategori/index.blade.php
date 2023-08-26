@extends('admin.index')
@section('content')
    <!-- <div class="container-fluid px-4"> -->
    <div class="row">
        <div class="card w-100">
            <div class="card-body p-4">
                <h1 class="mt-4">Daftar Kategori</h1>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success" hidden>
                        <p id="message">{{ $message }}</p>
                        <script>
                            Swal.fire({
                                title: 'Success',
                                text: $('#message').text(),
                                icon: 'Success',
                                confirmButtonText: 'Oke!'
                            })
                        </script>
                    </div>
                @endif
                @if ($message = Session::get('error'))
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
                <a href="{{ route('kategori.create') }}" class="btn btn-primary">Tambah</a>
                <div class="table-responsive">
                    <br>
                    <table class="table table-hover" id="datatablesSimple">
                        <thead align="center">
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody align="center">
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($ar_kategori as $data)
                                <tr>
                                    <td width="5%">{{ $no }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>
                                        <form id="deleteForm" method="POST"
                                            action="{{ route('kategori.destroy', $data->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a class="btn btn-info btn-sm" href="{{ route('kategori.show', $data->id) }}"
                                                title="detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if (Auth::user()->level != 'kasir')
                                                <!-- ubah data -->
                                                <a class="btn btn-warning btn-sm"
                                                    href="{{ route('kategori.edit', $data->id) }}" title="ubah">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endif
                                            <!-- hapus data -->
                                            @if (Auth::user()->level == 'admin')
                                                <button class="btn btn-danger btn-sm show_confirm" title="Hapus"
                                                    name="proses">
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
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) form.submit();
                });
        })
    </script>
    <style>
        #datatablesSimple th {
            text-align: center;
        }

        #datatablesSimple #no {
            width: 10px;
        }
    </style>
@endsection
