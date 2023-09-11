<section id="services" class="services section-bg">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col align-self-center">
                <div class="section-title nav-link-scrollto">
                    <h2>Product</h2>
                    <!-- <p>
                        Berikut merupakan beberapa produk unggulan kami
                    </p> -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="container">
                    <div class="card" style="width: 18rem;">
                        <div class="card-header">
                            Kategori
                        </div>
                        <ul class="list-group list-group-flush">
                            @isset($ar_kategori)
                            @foreach ($ar_kategori as $kategori)
                            <a href="{{ route('categories.index', ['category' => $kategori->nama]) }}">
                                <li class="list-group-item">{{ $kategori->nama }}</li>
                            </a>

                            @endforeach
                            @endisset
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="container">
                    <div class="row justify-content">
                        @foreach( $ar_barang as $barang )
                        <div class="col-md-4 mb-4">
                            <div class="card" style="width: 300px;">
                                <img src="admin/assets/img/{{ $barang->foto }}" class="card-img-top" alt="Product Image" height="200px">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $barang->nama_barang }}</h5>
                                    <p class="card-text">
                                        <!-- Product price -->
                                        From: Rp {{ $barang->harga_member }},-
                                    </p>
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center"><a class="btn btn-outline-dark mt-auto bg-new shadow" target="_blank" href="https://wa.me/6282169019974"><i class="bi-whatsapp">&nbsp;Pesan ke Whatsapp</i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>