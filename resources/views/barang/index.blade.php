@extends('admin.index')
@section('content')
    <!-- <div class="container-fluid px-4"> -->
    <div class="row">
        <div class="card w-100">
            <div class="card-body p-4">
                <h1 class="mt-4">Daftar Barang</h1>
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
                @if (Auth::user()->level != 'kasir')
                    <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> <span
                            style="font-weight: bold;">Tambah</span></a>
                @endif
                <div class="table-responsive">
                    <br>

                    <!-- <div class="table-responsive"> -->
                    <table class="table-hover text-nowrap mb-0 align-middle" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Harga Member</th>
                                <th>Harga Studio</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($ar_barang as $data)
                                <tr>
                                    <th>{{ $no }}</th>
                                    <td>{{ $data->kode }}</td>
                                    <td>{{ $data->nama_barang }}</td>
                                    <td>{{ $data->satuan }}</td>
                                    <td>Rp. {{ number_format($data->harga, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($data->harga_member, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($data->harga_studio, 0, ',', '.') }}</td>
                                    <td>
                                        <form class="d-flex justify-content-around" id='deleteForm' method="POST"
                                            action="{{ route('barang.destroy', $data->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a class="btn btn-info btn-sm" href="{{ route('barang.show', $data->id) }}"
                                                title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if (Auth::user()->level != 'kasir')
                                                <a class="btn btn-warning btn-sm"
                                                    href="{{ route('barang.edit', $data->id) }}" title="Ubah">
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
                    <!-- </div> -->
                </div>
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
    <!-- <script>
        function tes() {
            console.log('berhasil')
        }
    </script> -->
@endsection
