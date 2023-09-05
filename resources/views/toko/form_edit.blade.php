@extends('admin.index')
@section('content')
    <h1 class="mt-4">{{ $title }}</h1>
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
        <form method="POST" action="{{ route('toko.update', $row->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-floating mb-3">
                <input class="form-control" name="nama" value="{{ $row->nama }}" id="namaToko" type="text"
                    placeholder="Nama pelanggan" data-sb-validations="required" />
                <label for="namaToko">Nama pelanggan</label>
                <div class="invalid-feedback" data-sb-feedback="namaToko:required">Nama Toko is required.</div>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" name="kode_nota" value="{{ $row->kode_nota }}" id="kode_nota" type="text"
                    placeholder="Kode Nota" data-sb-validations="required" />
                <label for="kode_nota">Kode Nota</label>
                <div class="invalid-feedback" data-sb-feedback="kode_nota:required">Kode Nota is required.</div>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" name="alamat" value="{{ $row->alamat }}" id="alamat" type="text"
                    placeholder="alamat" data-sb-validations="required" />
                <label for="alamat">Alamat</label>
                <div class="invalid-feedback" data-sb-feedback="alamat:required">alamat is required.</div>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" name="no_telp" value="{{ $row->no_telp }}" id="no_telp" type="string"
                    placeholder="No Hp" data-sb-validations="required" />
                <label for="no_telp">No Hp</label>
                <div class="invalid-feedback" data-sb-feedback="no_telp:required">No Telpon is required.</div>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" name="no_rekening" value="{{ $row->no_rekening }}" id="no_rekening"
                    type="string" placeholder="No Hp" data-sb-validations="required" />
                <label for="no_rekening">No Rekening</label>
                <div class="invalid-feedback" data-sb-feedback="no_rekening:required">No Rekening is required.</div>
            </div>

            <!-- UPLOAD FOTO -->
            <div class="form-floating mb-3">
                <input class="form-control" name="foto" value="" id="foto" type="file" placeholder="Foto"
                    accept="image/*" />
                <label for="foto">Masukkan Foto</label>
                <div class="invalid-feedback" data-sb-feedback="foto:required">Foto is required.</div>
            </div>

            <!-- UPLOAD FOTO -->
            <div class="form-floating mb-3">
                <input class="form-control" name="logo" value="" id="logo" type="file" placeholder="Logo"
                    accept="image/*" />
                <label for="logo">Masukkan Logo</label>
                <div class="invalid-feedback" data-sb-feedback="logo:required">Logo is required.</div>
            </div>

            <button class="btn btn-primary" name="proses" value="ubah" id="ubah" type="submit">
                <i class="fas fa-edit"></i> Simpan
            </button>
            <input type="hidden" name="id" value="{{ $row->id }}" />
            <a href="{{ url('/toko') }}" class="btn btn-info">
                <i class="fas fa-times"></i> Batal
            </a>

        </form>
    </div>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
@endsection
