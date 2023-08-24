@extends('admin.index')
@section('content')
<h3>Form Transaksi</h3>
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
    <form method="POST" action="{{ route('transaksi.store') }}" id="contactForm" data-sb-form-api-token="API_TOKEN">
        @csrf
        <div class="form-group from-floating mb-3">
            <label for="barang">Nama barang</label>
            <select id="barang" name="barang" class="form-control">
                <option value="">--Pilih Barang--</option>
                @foreach($ar_barang as $barang)
                <option value=" {{$barang->id}} | {{$barang->harga}} | {{$barang->harga_member}}">{{$barang -> kode}} - {{$barang->nama_barang}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group from-floating mb-3">
            <label for="nama">Nama Pelanggan</label>
            <select id="nama" name="nama" class="form-control">
                <option value="">--Pelanggan--</option>
                @foreach($ar_pelanggan as $pelanggan)
                <option value="{{$pelanggan->id}} | {{$pelanggan->status_member}}">{{$pelanggan->nama}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group form-floating mb-3">
            <input class="form-control" name="jumlah" value="" id="jumlah" type="text" placeholder="jumlah" data-sb-validations="required" />
            <label for="jumlah">Jumlah dibeli</label>
            <div class="invalid-feedback" data-sb-feedback="jumlah:required">jumlah is required.</div>
        </div>

        <div class="form-group form-floating mb-3">
            <input class="form-control" name="tgl" value="" id="date" type="text" placeholder="date" data-sb-validations="required" />
            <label for="date">date</label>
            <div class="invalid-feedback" data-sb-feedback="date:required">date is required.</div>
        </div>

        <div class="form-group form-floating mb-3">
            <input class="form-control" name="keterangan" value="" id="keterangan" type="text" placeholder="keterangan" data-sb-validations="required" />
            <label for="keterangan">keterangan</label>
            <div class="invalid-feedback" data-sb-feedback="keterangan:required">keterangan is required.</div>
        </div>

        <div class="container mt-4">
            <div>harga</div>
            <form>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="step" value="step1" checked>
                    <label class="form-check-label">Harga Default</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="step" value="step2">
                    <label class="form-check-label">Isi Harga</label>
                </div>
            </form>

            <div id="nameForm">
                <form>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Rp</span>
                        <input type="text" id="nameInput" class="form-control" placeholder="Masukkan Harga" disabled>
                        <span class="input-group-text">.00</span>
                    </div>
                </form>
                <p id="nameDisplay" class="mt-3"></p>
            </div>
        </div>

        <script>
            const nameForm = document.getElementById('nameForm');
            const nameInput = document.getElementById('nameInput');
            const submitName = document.getElementById('simpan');
            const nameDisplay = document.getElementById('nameDisplay');
            const step1Radio = document.querySelector('input[value="step1"]');

            step1Radio.addEventListener('change', function() {
                if (this.checked) {
                    nameForm.style.display = 'none';
                    nameInput.disabled = true;
                    submitName.disabled = true;
                    nameInput.value = ''; // Clear the input
                    nameDisplay.textContent = ''; // Clear the display
                }
            });

            const radioButtons = document.querySelectorAll('input[name="step"]');

            radioButtons.forEach(radioButton => {
                radioButton.addEventListener('change', function() {
                    if (this.value === 'step2') {
                        nameForm.style.display = 'block';
                        nameInput.disabled = false; // Enable the input
                        submitName.disabled = false; // Enable the button
                        nameDisplay.textContent = ''; // Clear previous name
                    } else if (this.value === 'step1') {
                        nameForm.style.display = 'none';
                        nameInput.disabled = true;
                        submitName.disabled = true;
                        nameInput.value = ''; // Clear the input
                        nameDisplay.textContent = ''; // Clear the display
                    }
                });
            });

            submitName.addEventListener('click', function() {
                const enteredName = nameInput.value;
                nameDisplay.textContent = `Hello, ${enteredName}!`;
            });
        </script>
        <script>
            // Get the current date
            var currentDate = new Date();

            // Format the date as YYYY-MM-DD
            var formattedDate = currentDate.toISOString().slice(0, 10);

            // Set the value of the date input field
            document.getElementById("date").value = formattedDate;
        </script>

        <button class="btn btn-primary" name="proses" value="simpan" id="simpan" type="submit">Simpan</button>
        <a href="{{ url('/transaksi') }}" class="btn btn-info">Batal</a>

    </form>
</div>
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
@endsection