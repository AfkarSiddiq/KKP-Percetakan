@extends('admin.index')
@section('content')
    <h3>{{ $title }}</h3>
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
        <form target="_blank" method="GET" action="{{ route('transaksi.pdf.cetak') }}" id="contactForm"
            data-sb-form-api-token="API_TOKEN">
            @csrf

            <div class="row align-items-center">
                <div class="form-group from-floating mb-3 col-md-11">
                    <label for="nama">Nama Pelanggan</label>
                    <select id="nama" name="nama" class="form-select">
                        <option value="">--Pilih Pelanggan--</option>
                        <option value="">Semua</option>
                        @foreach ($ar_pelanggan as $pelanggan)
                            <option value="{{ $pelanggan->id }} | {{ $pelanggan->status_member }}">{{ $pelanggan->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md mt-1">
                    <a class="btn btn-primary" href="{{ route('pelanggan.create') }}"><i class="bi bi-plus"></i></a>
                </div>
            </div>

            <div class="form-group from-floating mb-3">
                <label for="status">Status pembayaran</label>
                <select class="col-md ms-1 form-select" name="status" id="status">
                    <option selected value="">Pilih Status Pembayaran</option>
                    <option value="">Semua</option>
                    <option value="Belum Lunas">Belum Lunas</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Jatuh Tempo">Jatuh Tempo</option>
                </select>
            </div>

            <div class="row align-items-center">
                <div class="form-group form-floating mb-3 col-md">
                    <input class="form-control" name="tgl_mulai" id="tgl_mulai" type="date" placeholder="tgl_mulai"
                        data-sb-validations="required" />
                    <label for="tgl_mulai">Dari Tanggal</label>
                    <div class="invalid-feedback" data-sb-feedback="tgl_mulai:required">Tanggal is required.</div>
                </div>
                <div class="form-group form-floating mb-3 col-md">
                    <input class="form-control" name="tgl_akhir" id="tgl_akhir" type="date" placeholder="tgl_akhir"
                        data-sb-validations="required" />
                    <label for="tgl_akhir">Sampai Tanggal</label>
                    <div class="invalid-feedback" data-sb-feedback="tgl_akhir:required">Tanggal is required.</div>
                </div>
            </div>

            <script>
                // Get the current date
                var currentDate = new Date();

                // Format the date as YYYY-MM-DD
                var formattedDate = currentDate.toISOString().slice(0, 10);

                // Set the value of the date input field
                document.getElementById("tgl_mulai").value = formattedDate;
                document.getElementById("tgl_akhir").value = formattedDate;
            </script>

            <button class="btn btn-primary" name="cetak" value="cetak" id="cetak" type="submit">Cetak</button>

        </form>
    </div>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
@endsection
