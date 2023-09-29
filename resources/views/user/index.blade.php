@extends('admin.index')
@section('content')
    <br><br>
    <!-- <div class="container-fluid px-4"> -->
    <div class="row">
        <div class="card w-100">
            <div class="card-body">
                <h1 class="mt-4">Data User</h1>
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
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger" hidden>
                        <p id="message">{{ $message }}</p>
                        <script>
                            Swal.fire({
                                title: 'Error',
                                text: $('#message').text(),
                                icon: 'Error',
                                confirmButtonText: 'Cool'
                            })
                        </script>
                    </div>
                @endif
                @if (Auth::user()->level == 'admin')
                    <div class="row">
                        <div class="col-md-4 .offsife-md-8">
                            <a href="{{ url('/register') }}"> <button type="button" class="btn btn-success">Daftarkan
                                    akun</button></a>
                        </div>
                    </div>
                @endif
                <br />
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No Hp</th>
                                <th>Level</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($data as $data)
                                <tr>
                                    <th>{{ $no }}</th>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->no_hp }}</td>
                                    <td>{{ $data->level }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ $data->alamat }}</td>
                                    <td>
                                        <form id='deleteForm' method="POST"
                                            action="{{ route('user.destroy', $data->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            @if (Auth::user()->level == 'admin')
                                                <a class="btn btn-warning btn-sm"
                                                    href="{{ route('updatelevel.edit', $data->id) }}" title="Ubah">
                                                    Ubah Level
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
                </div>
            </div>

            <br>
        </div>
    </div>
    <!-- </div> -->
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
