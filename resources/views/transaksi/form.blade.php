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
                            value=" {{ $barang->id }} | {{ $barang->harga }} | {{ $barang->harga_member }} | {{ $barang->harga_studio }} | {{ $barang->satuan }} | {{ $barang->bahan_id }}">
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
                <input onchange="updateHargaTotal();" class="form-control" name="jumlah" value="" id="jumlah"
                    type="number" placeholder="jumlah" data-sb-validations="required" min="0" />
                <label for="jumlah">Jumlah dibeli</label>
                <div class="invalid-feedback" data-sb-feedback="jumlah:required">jumlah is required.</div>
            </div>

            <div class="row align-items-center">
                <div class="form-group form-floating mb-3 col-md">
                    <input onchange="updateHargaTotal()" class="form-control" name="harga" id="harga" type="number"
                        placeholder="harga" @readonly(true) />
                    <label for="harga">Harga per Satuan</label>
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

            <div class="form-check mb-3">
                <input checked class="form-check-input" type="checkbox" id="useDefaultPrice" onchange="toggleCustomPrice()">
                <label class="form-check-label" for="useDefaultPrice">Gunakan Harga Default</label>
            </div>

            <div class="form-group form-floating mb-3">
                <input class="form-control" name="tgl" value="" id="date" type="date" placeholder="date"
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
                <input class="form-control" name="total_harga" id="total_harga" type="number"
                    placeholder="total_harga" readonly />
                <label for="total_harga">Harga Total</label>
            </div>

            <div class="row align-items-center mb-3">
                <div class="form-group form-floating col-md">
                    <input onchange="updateSisa()" class="form-control" name="total_bayar" id="total_bayar"
                        type="number" placeholder="total_bayar" />
                    <label for="total_bayar">Total Bayar</label>
                </div>
                <div class="form-group form-floating col-md sisa" style="display: block">
                    <input class="form-control" name="sisa" id="sisa" type="number" placeholder="sisa"
                        readonly />
                    <label for="sisa">Sisa</label>
                </div>
                <div class="form-group form-floating col-md kembalian" style="display: block">
                    <input class="form-control" name="kembalian" id="kembalian" type="number" placeholder="kembalian"
                        readonly />
                    <label for="kembalian">Kembalian</label>
                </div>
            </div>

            <script>
                // function to update sisa
                function updateSisa() {
                    var totalHarga = document.getElementById("total_harga").value;
                    var totalBayar = document.getElementById("total_bayar").value;
                    var kembalian = document.getElementById("kembalian");
                    var sisa = document.getElementById("sisa");
                    var displaySisa = document.getElementsByClassName("sisa")[0];
                    var displayKembalian = document.getElementsByClassName("kembalian")[0];
                    var sisaOrKembalian = totalHarga - totalBayar;

                    if (sisaOrKembalian < 0) {
                        displaySisa.style.display = "none";
                        displayKembalian.style.display = "block";
                        kembalian.value = sisaOrKembalian * -1;
                        sisa.value = 0;
                    } else {
                        displaySisa.style.display = "block";
                        displayKembalian.style.display = "none";
                        sisa.value = sisaOrKembalian;
                        kembalian.value = 0;
                    }
                }

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

                // Function to update harga based on selected barang and user's choice
                function updateHarga() {
                    var selectedBarang = document.getElementById("barang").value;
                    var useDefaultPrice = document.getElementById("useDefaultPrice").checked;
                    var hargaField = document.getElementById("harga");
                    var selectedPelanggan = document.getElementById("nama").value;
                    var harga = 0;

                    // If the user chooses to use default price, update harga with the price of the selected barang
                    if (selectedBarang.length != 0) {
                        var barang = selectedBarang.split(" | ");
                        if (selectedPelanggan.length != 0) {
                            var pelanggan = selectedPelanggan.split(" | ");
                            if (useDefaultPrice) {
                                harga = pelanggan[1] === "1" ? barang[2] : pelanggan[1] === "2" ? barang[3] : barang[1];
                            } else {
                                // If not using default price, set harga to empty to let user input
                                harga = 0;
                            }
                        } else {
                            harga = barang[1];
                        }
                    }

                    harga = parseInt(harga);
                    // Update the harga field with the retrieved value
                    hargaField.value = harga;
                    updateHargaTotal();
                }


                // Function to round up panjang and lebar
                function roundUp(value) {
                    return Math.ceil(value * 2) / 2;
                }

                // Function to update harga total based on selected barang and jumlah
                function updateHargaTotal() {
                    var harga = parseInt(document.getElementById("harga").value);
                    var jumlah = parseInt(document.getElementById("jumlah").value);
                    var panjang = parseFloat(document.getElementById("panjang").value);
                    var lebar = parseFloat(document.getElementById("lebar").value);
                    var hargaTotalField = document.getElementById("total_harga");

                    // make all number to positive
                    if (panjang < 0) {
                        panjang = panjang * -1;
                    } else if (lebar < 0) {
                        lebar = lebar * -1;
                    } else if (jumlah < 0) {
                        jumlah = jumlah * -1;
                    } else if (harga < 0) {
                        harga = harga * -1;
                    }

                    var hargaTotal = 0;
                    var luas = 1;

                    if (!isNaN(panjang) && !isNaN(lebar)) {
                        luas = roundUp(panjang) * roundUp(lebar);
                    }

                    hargaTotal = harga * jumlah * luas;

                    // Update the harga total field with the calculated value
                    hargaTotalField.value = hargaTotal;
                    updateSisa();
                }

                // Function to toggle the custom price input field based on user's choice
                function toggleCustomPrice() {
                    var useDefaultPrice = document.getElementById("useDefaultPrice").checked;
                    var hargaField = document.getElementById("harga");

                    // readonly the price input field based on user's choice
                    hargaField.readOnly = useDefaultPrice;

                    // If using default price, update the harga field
                    if (useDefaultPrice) {
                        updateHarga();
                    } else {
                        // Clear the harga field when not using default price
                        hargaField.value = "";
                        updateHargaTotal();
                    }
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
