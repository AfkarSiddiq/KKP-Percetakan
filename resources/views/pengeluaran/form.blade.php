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
        <form method="POST" action="{{ route('pengeluaran.store') }}" id="contactForm" data-sb-form-api-token="API_TOKEN">
            @csrf

            <div class="row">
                <div class="form-group form-floating mb-3 col-md">
                    <input class="form-control" name="nama_pengeluaran" value="" id="nama_pengeluaran" type="text"
                        placeholder="Nama Pengeluaran" data-sb-validations="required" />
                    <label for="nama_pengeluaran">Nama Pengeluaran</label>
                    <div class="invalid-feedback" data-sb-feedback="nama_pengeluaran:required">Nama Pengeluaran is required.
                    </div>
                </div>
                <div class="form-group form-floating mb-3 col-md">
                    <input class="form-control" name="date" value="" id="date" type="date"
                        placeholder="date" data-sb-validations="required" />
                    <label for="date">Tanggal Pengeluaran</label>
                    <div class="invalid-feedback" data-sb-feedback="date:required">Tanggal Pengeluaran is required.</div>
                </div>
            </div>


            <div class="row">
                <div class="form-group form-floating mb-3 col-md">
                    <input min="0" class="form-control" name="jumlah" value="" id="jumlah" type="number"
                        placeholder="jumlah" data-sb-validations="required" />
                    <label for="jumlah">Jumlah Pengeluaran</label>
                    <div class="invalid-feedback" data-sb-feedback="jumlah:required">jumlah is required.</div>
                </div>

                <div class="form-group from-floating col-md">
                    <select id="pembayaran" name="pembayaran" class="form-select">
                        <option value="">--Pilih Metode Pembayaran--</option>
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                    </select>
                </div>
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
            <a href="{{ url('/pengeluaran') }}" class="btn btn-info">Batal</a>

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
