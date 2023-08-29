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
        <form method="POST" action="{{ route('suplaibahan.store') }}" id="contactForm" data-sb-form-api-token="API_TOKEN">
            @csrf
            <div class="form-group from-floating mb-3">
                <label for="bahan">Nama bahan</label>
                <select onchange="updateSatuan()" id="bahan" name="bahan" class="form-control">
                    <option value="">--Pilih bahan--</option>
                    @foreach ($ar_bahan as $bahan)
                        <option value="{{ $bahan->nama_bahan }} | {{ $bahan->id }} | {{ $bahan->satuan }}">
                            {{ $bahan->nama_bahan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="form-group form-floating mb-3 col-md">
                    <input min="0" class="form-control" name="jumlah" value="" id="jumlah" type="number"
                        placeholder="jumlah" data-sb-validations="required" />
                    <label for="jumlah">Jumlah Masuk</label>
                    <div class="invalid-feedback" data-sb-feedback="jumlah:required">jumlah is required.</div>
                </div>
                <div class="form-group form-floating mb-3 col-md-1">
                    <input class="form-control" name="satuan" value="" id="satuan" type="text"
                        placeholder="satuan" data-sb-validations="required" readonly />
                    <div class="invalid-feedback" data-sb-feedback="satuan:required">Satuan is required.</div>
                </div>
            </div>

            <div class="form-group form-floating mb-3">
                <input class="form-control" name="date" value="" id="date" type="date" placeholder="date"
                    data-sb-validations="required" />
                <label for="date">date</label>
                <div class="invalid-feedback" data-sb-feedback="date:required">date is required.</div>
            </div>

            <div class="form-group form-floating mb-3">
                <input class="form-control" name="keterangan" value="" id="keterangan" type="text"
                    placeholder="keterangan" data-sb-validations="required" />
                <label for="keterangan">keterangan</label>
                <div class="invalid-feedback" data-sb-feedback="keterangan:required">keterangan is required.</div>
            </div>

            <script>
                // Get the current date
                var currentDate = new Date();

                // Format the date as YYYY-MM-DD
                var formattedDate = currentDate.toISOString().slice(0, 10);

                // Set the value of the date input field
                document.getElementById("date").value = formattedDate;
            </script>

            <button class="btn btn-primary" name="proses" value="simpan" id="simpan" type="submit">Simpan</button>
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
            <a href="{{ url('/suplaibahan') }}" class="btn btn-info">Batal</a>

        </form>
    </div>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script>
        function updateSatuan() {
            var bahan = document.getElementById("bahan").value;
            var arr = bahan.split(" | ");
            document.getElementById("satuan").value = arr[2];
        }
    </script>
@endsection
