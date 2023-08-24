@extends('admin.index')
@section('content')
<!-- <div class="container-fluid px-4"> -->
<div class="row">
    <div class="card w-100">
        <div class="card-body p-4">
            <h1 class="mt-4">Daftar Pelanggan</h1>
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
            <a href="{{ route('pelanggan.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> <span style="font-weight: bold;">Tambah</span></a>
            <div class="table-responsive">
                <br>

                <!-- <div class="table-responsive"> -->
                <table class="table-hover text-nowrap mb-0 align-middle" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>No Handphone</th>
                            <th>Status Member</th>
                            <th>jumlah Pesanan</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        @endphp
                        @foreach ($ar_pelanggan as $data)
                        <tr>
                            <th>{{ $no }}</th>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->alamat }}</td>
                            <td>{{ $data->no_hp }}</td>
                            @if ($data->status_member)
                            <td>Member</td>
                            @else
                            <td>Bukan Member</td>
                            @endif
                            <td>{{$data->jumlah_pesanan}}</td>

                            <td>
                                <form id='deleteForm' method="POST" action="{{ route('pelanggan.destroy', $data->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <a class="btn btn-info btn-sm" href="{{ route('pelanggan.show', $data->id) }}" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a class="btn btn-warning btn-sm" href="{{ route('pelanggan.edit', $data->id) }}" title="Ubah">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if (Auth::user()->level == 'admin')
                                    <!-- hapus data -->
                                    <button class="btn btn-danger btn-sm show_confirm">
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
                <!-- </div> -->
            </div>
        </div>
    </div>
    <!-- </div> -->
</div>
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        console.log('form');
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
@endsection