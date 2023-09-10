<section id="services" class="services section-bg">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col align-self-center">
                <div class="section-title nav-link-scrollto">
                    <h2>Product</h2>
                    <p>
                        Berikut merupakan beberapa produk unggulan kami
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="container">
                    <nav class="navbar navbar-expand-lg bg-light">
                        <div class="container-fluid">
                            <li class="dropdown" style="list-style: none;"><a class="navbar-brand dropdown" href="#"><span>Kategori</span><i class="bi bi-chevron-down"></i></a>
                                <ul class="dropdown">
                                    @isset($ar_kategori)
                                    @foreach ($ar_kategori as $kategori)
                                    <li><a href="{{ route('categories.index', ['category' => $kategori->nama]) }}">{{ $kategori->nama }}</a>
                                    </li>
                                    @endforeach
                                    @endisset
                                </ul>
                            </li>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="col-md-9">
                <div class="container px-4 px-lg-5 mt-5">
                    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content">
                        @foreach( $ar_barang as $barang )
                        <div class="col mb-5">
                            <div class="card h-100 shadow ">
                                <!-- Product image-->
                                <img class="card-img-top" img src="admin/assets/img/{{ $barang->foto }}" alt="..." width="250px" height="190px" />
                                <!-- Product details-->
                                <div class="card-body p-2">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <b>{{ $barang->nama_barang }}</b><br>
                                        <!-- Product price-->
                                        From: Rp {{ $barang->harga_member }},-
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto bg-new shadow" target="_blank" href="https://wa.me/6282321216131?text=hello digital pacific printing"><i class="bi-whatsapp">&nbsp;Pesan ke Whatsapp</i></a></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <a href="{{ url('/ourbarang') }}"><button type="button" class="btn btn-link">Lihat lebih banyak</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>