@extends('admin.index')
@section('content')
    <h1 class="mt-4 mb-5">{{ $title }}</h1>
    <div class="card-body p-auto">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <section class="section">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                @empty($rs->foto)
                                    <img src="{{ url('admin/assets/img/noimage.jpg') }}" class="img-fluid rounded-start"
                                        alt="no image">
                                @else
                                    <img src="{{ asset('/assets/img') }}/{{ $rs->foto }}" class="img-fluid rounded-start"
                                        alt="image failed to load">
                                @endempty
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h2 class="card-title">{{ $rs->nama }}</h2>
                                    <table class="table table-hover">
                                        <tr>
                                            <td class="h6">Kode Nota</td>
                                            <td class="h6">:</td>
                                            <td class="h6">{{ $rs->kode_nota }}</td>
                                        </tr>
                                        <tr>
                                            <td class="h6">Alamat</td>
                                            <td class="h6">:</td>
                                            <td class="h6">{{ $rs->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <td class="h6">No Telpon</td>
                                            <td class="h6">:</td>
                                            <td class="h6">{{ $rs->no_telp }}</td>
                                        </tr>

                                        <tr>
                                            <td class="h6">No. Rekening</td>
                                            <td class="h6">:</td>
                                            <td class="h6">{{ $rs->no_rekening }}</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('toko.edit', $rs->id) }}" class="btn btn-success">
                    <i class="fas fa-edit"></i> Edit
                </a>

            </div>
        </section>
    </div>
@endsection
