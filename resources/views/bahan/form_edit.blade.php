@extends('admin.index')
@section('content')
    <h3>Form Update Bahan</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container px-5 my-5">
        <form method="POST" action="{{ route('bahan.update', $row->id) }}" id="contactForm" data-sb-form-api-token="API_TOKEN">
            @csrf
            @method('PUT')
            <div class="form-floating mb-3">
                <input class="form-control" name="nama_bahan" value="{{ $row->nama_bahan }}" id="nama_bahan" type="text"
                    placeholder="nama_bahan" data-sb-validations="required" />
                <label for="nama_bahan">Nama Bahan</label>
                <div class="invalid-feedback" data-sb-feedback="nama_bahan:required">Nama Bahan is required.</div>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" name="jumlah" value="{{ $row->jumlah }}" id="jumlah" type="text"
                    placeholder="jumlah" data-sb-validations="required" />
                <label for="jumlah">Jumlah </label>
                <div class="invalid-feedback" data-sb-feedback="jumlah:required">Jumlah is required.</div>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" name="satuan" value="{{ $row->satuan }}" id="satuan" type="text"
                    placeholder="satuan" data-sb-validations="required" />
                <label for="satuan">Satuan</label>
                <div class="invalid-feedback" data-sb-feedback="satuan:required">Satuan is required.</div>
            </div>

            <button class="btn btn-primary" name="proses" value="ubah" id="ubah" type="submit">
                <i class="fas fa-edit"></i> Ubah
            </button>
            <a href="{{ url('/bahan') }}" class="btn btn-info">
                <i class="fas fa-times"></i> Batal
            </a>

        </form>
    </div>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
@endsection
