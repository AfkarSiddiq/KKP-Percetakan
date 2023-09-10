<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>

                    <a class="nav-link" href="{{ url('/dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                        <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                        Transaksi
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link" href="{{ url('/transaksi') }}">Data Transaksi</a>
                            <a class="nav-link" href="{{ url('/pelunasan') }}">Pelunasan DP</a>
                        </nav>
                    </div>
                    {{-- <a class="nav-link" href="{{ url('/transaksi') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                        Transaksi
                    </a> --}}
                    {{-- <a class="nav-link" href="{{ url('/pelunasan') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-money-bill-alt"></i></div>
                        Pelunasan DP
                    </a> --}}
                    <a class="nav-link" href="{{ url('/jatuhTempo') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-bell"></i></div>
                        Jatuh Tempo
                    </a>

                    <div class="sb-sidenav-menu-heading">Interface</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Produk
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ url('/barang') }}">Data Produk</a>
                            <a class="nav-link" href="{{ url('/kategori') }}">Kategori Barang</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                        Costumer
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link" href="{{ url('/pelanggan') }}">Data Pelanggan</a>
                            <a class="nav-link" href="{{ url('/member') }}">Member</a>
                        </nav>
                    </div>
                    <div class="sb-sidenav-menu-heading">Addons</div>
                    <a class="nav-link" href="{{ url('/suplaibahan') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-cart-plus"></i></div>
                        Suplai Bahan
                    </a>

                    <a class="nav-link" href="{{ url('/bahan') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                        Bahan Mentah
                    </a>
                    <a class="nav-link" href="{{ url('/toko') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-shop"></i></div>
                        Profil Toko
                    </a>
                    </a>
                    <a class="nav-link" href="{{ url('/datauser') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-user"></i></div>
                        User
                    </a>

                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                @if (Auth::user() == true)
                    {{ Auth::user()->name }} ({{ Auth::user()->level }})
                @else
                    -
                @endif
            </div>
        </nav>
    </div>
