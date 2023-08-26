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
                <select id="barang" name="barang" onchange="updateHarga();checkSatuan()" class="form-control">
                    <option value="">--Pilih Barang--</option>
                    @foreach ($ar_barang as $barang)
                        <option
                            value=" {{ $barang->id }} | {{ $barang->harga }} | {{ $barang->harga_member }} | {{ $barang->harga_studio }} | {{ $barang->satuan }}">
                            {{ $barang->kode }} - {{ $barang->nama_barang }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row align-items-center">
                <div class="form-group from-floating mb-3 col-md-11">
                    <label for="nama">Nama Pelanggan</label>
                    <select id="nama" onchange="updateHarga()" name="nama" class="form-control">
                        <option value="">--Pelanggan--</option>
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

            <div class="form-group form-floating mb-3">
                <input onchange="updateHargaTotal()" class="form-control" name="jumlah" value="" id="jumlah"
                    type="text" placeholder="jumlah" data-sb-validations="required" />
                <label for="jumlah">Jumlah dibeli</label>
                <div class="invalid-feedback" data-sb-feedback="jumlah:required">jumlah is required.</div>
            </div>

            <div class="row align-items-center">
                <div class="form-group form-floating mb-3 col-md">
                    <input class="form-control" name="harga" id="harga" type="text" placeholder="harga" readonly />
                    <label for="harga">Harga</label>
                </div>

                <div class="luas col-md" style="display: none">
                    <div class="row align-items-center">
                        <div class="form-group form-floating mb-3 col-md">
                            <input onchange="updateHargaTotal()" class="form-control" name="panjang" value="1"
                                id="panjang" type="text" placeholder="panjang" />
                            <label for="panjang">Panjang</label>
                            <div class="invalid-feedback" data-sb-feedback="panjang:required">Panjang is required.</div>
                        </div>

                        <div class="col-md-1 mb-3">Meter</div>

                        <div class="form-group form-floating mb-3 col-md">
                            <input onchange="updateHargaTotal()" class="form-control" name="lebar" value="1"
                                id="lebar" type="text" placeholder="lebar" />
                            <label for="lebar">Lebar</label>
                            <div class="invalid-feedback" data-sb-feedback="lebar:required">Lebar is required.</div>
                        </div>

                        <div class="col-md-1 mb-3">Meter</div>
                    </div>
                </div>
            </div>

            <div class="form-group form-floating mb-3">
                <input class="form-control" name="tgl" value="" id="date" type="text" placeholder="date"
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

            <div class="form-group form-floating mb-3">
                <input class="form-control" name="harga_total" id="harga_total" type="text" placeholder="harga_total"
                    readonly />
                <label for="harga_total">Harga Total</label>
            </div>

            <script>
                //function to check satuan barang and display if satuan = meter
                function checkSatuan() {
                    var selectedBarang = document.getElementById("barang").value;
                    var satuan = selectedBarang.split(" | ");
                    var luas = document.getElementsByClassName("luas")[0];
                    if ((satuan[4].toLowerCase()) == "meter") {
                        luas.style.display = "block";
                    } else {
                        luas.style.display = "none";
                    }
                }

                // Function to update harga based on selected barang
                function updateHarga() {
                    var selectedBarang = document.getElementById("barang").value;
                    var hargaField = document.getElementById("harga");
                    var selectedPelanggan = document.getElementById("nama").value;
                    var harga = 0;

                    // If a barang is selected, then update harga with the price of the selected barang
                    if (selectedBarang.length != 0) {
                        var barang = selectedBarang.split(" | ");
                        if (selectedPelanggan.length != 0) {
                            var pelanggan = selectedPelanggan.split(" | ");
                            if (pelanggan[1] == "1") {
                                harga = barang[2];
                            } else if (pelanggan[1] == "2") {
                                harga = barang[3];
                            } else {
                                harga = barang[1];
                            }
                        } else {
                            harga = barang[1];
                        }
                    }

                    // Update the harga field with the retrieved value
                    hargaField.value = harga;
                }

                // Function to round up panjang and lebar
                function roundUp(value) {
                    return Math.ceil(value * 2) / 2;
                }

                // Function to update harga total based on selected barang and jumlah
                function updateHargaTotal() {
                    var selectedBarang = document.getElementById("barang").value;
                    var selectedPelanggan = document.getElementById("nama").value;
                    var jumlah = parseInt(document.getElementById("jumlah").value);
                    var panjang = parseFloat(document.getElementById("panjang").value);
                    var lebar = parseFloat(document.getElementById("lebar").value);
                    var hargaTotalField = document.getElementById("harga_total");

                    var hargaTotal = 0;
                    var luas = 1;

                    if (!isNaN(panjang) && !isNaN(lebar)) {
                        luas = roundUp(panjang) * roundUp(lebar);
                    }

                    if (selectedBarang !== "") {
                        var barang = selectedBarang.split(" | ");
                        if (selectedPelanggan !== "") {
                            var pelanggan = selectedPelanggan.split(" | ");
                            if (pelanggan[1] === "1") {
                                hargaTotal = parseInt(barang[2]) * jumlah * luas;
                            } else if (pelanggan[1] === "2") {
                                hargaTotal = parseInt(barang[3]) * jumlah * luas;
                            } else {
                                hargaTotal = parseInt(barang[1]) * jumlah * luas;
                            }
                        } else {
                            hargaTotal = parseInt(barang[1]) * jumlah * luas;
                        }
                    }

                    // Update the harga total field with the calculated value
                    hargaTotalField.value = hargaTotal;
                }
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
