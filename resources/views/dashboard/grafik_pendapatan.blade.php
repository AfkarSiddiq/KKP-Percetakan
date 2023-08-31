<div class="col-md-4">
    <div class="card info-card sales-card text-center align-items-center">

        <div class="card-body ">
            <h3 class="card-title">Bulan ini sebanyak</h3>

            <div class="d-flex align-items-center">
                <div class="card-icon  align-items-center justify-content-center ">
                    <i class="text-success fa-solid fa-money-check-dollar fa-4x"></i>
                </div>
                <div class="ps-3">
                    <h3 class="text-success fw-bold mb-0 text-center">
                        @foreach ($jml_pendapatan as $jml)
                            {{ '+ Rp ' . number_format($jml->jumlah, 0, ',', '.') }}
                        @endforeach
                    </h3>
                    <h5 class=" pt-1 ">Uang masuk</h5>

                </div>
            </div>
        </div>

    </div>
</div>
