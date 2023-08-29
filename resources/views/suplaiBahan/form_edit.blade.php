@extends('admin.index')
@section('content')
    <h3>{{ $title }}</h3>
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
                    title: 'Error',
                    text: $('#message').text(),
                    icon: 'Error',
                    confirmButtonText: 'Cool'
                })
            </script>
        </div>
    @endif
    <div class="container px-5 my-5">
        <form method="POST" action="{{ route('suplaibahan.update', $row->id) }}" id="contactForm"
            data-sb-form-api-token="API_TOKEN">
            @csrf
            @method('PUT')
            <div class="form-group from-floating mb-3">
                <label for="bahan">Nama bahan</label>
                <input id="bahan" value="{{ $ar_bahan->nama_bahan }}" name="bahan" class="form-control"
                    value="{{ old('bahan') }}" readonly>
            </div>

            <div class="form-floating mb-3">
                <input min="0" class="form-control" name="jumlah" value="{{ $row->jumlah }}" id="jumlah"
                    type="number" placeholder="jumlah" data-sb-validations="required" />
                <label for="jumlah">Jumlah Masuk</label>
                <div class="invalid-feedback" data-sb-feedback="jumlah:required">jumlah is required.</div>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" name="date" value="{{ $row->tgl }}" id="date" type="date"
                    placeholder="date" data-sb-validations="required" />
                <label for="date">date</label>
                <div class="invalid-feedback" data-sb-feedback="date:required">date is required.</div>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" name="keterangan" value="{{ $row->keterangan }}" id="keterangan" type="text"
                    placeholder="keterangan" data-sb-validations="required" />
                <label for="keterangan">keterangan</label>
                <div class="invalid-feedback" data-sb-feedback="keterangan:required">keterangan is required.</div>
            </div>

            <button class="btn btn-primary" name="proses" value="ubah" id="ubah" type="submit">
                <i class="fas fa-edit"></i> Ubah
            </button>
            <a href="{{ url('/suplaibahan') }}" class="btn btn-info">
                <i class="fas fa-times"></i> Batal
            </a>

        </form>
    </div>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
@endsection
