<div class="col-md-4">

    <div class="card info-card sales-card text-center align-items-center">

        <div class="card-body">
            <div class="row">
                <h3 class="col-md card-title">Bulan ini sebanyak</h3>
            </div>

            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="text-danger fa-solid fa-money-check-dollar fa-4x"></i>
                </div>
                <div class="ps-3">
                    <h3 class="text-danger fw-bold mb-0 text-center">
                        @foreach ($jml_pelanggan as $jml)
                            {{ '+ Rp ' . number_format($jml->jumlah, 0, ',', '.') }}
                        @endforeach
                    </h3>
                    <h5 class=" pt-1 ">Belum masuk</h5>

                </div>
            </div>

        </div>
    </div>
</div>
