<div class="col-md-4">
    <div class="card info-card sales-card text-center align-items-center">

        <div class="filter">
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <h3 class="card-title">Bulan ini terjadi </h3>

            <div class="d-flex align-items-center ">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center ">
                    <i class="text-primary fas fa-exchange-alt fa-3x"></i>
                </div>

                <div class="ps-3">
                    <h3 class="text-primary fw-bold mb-0  ">
                        @foreach ($jml_transaksi as $jml)
                            {{ $jml->jumlah }}
                        @endforeach
                    </h3>
                    <h5 class=" pt-1 ">Transaksi</h5>
                </div>

            </div>
        </div>

    </div>
</div>
