<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

        <h1 class="logo">
            <a href="/"><img src="{{ asset('assets/img/logo.png') }}" width="100em" height="40em"></a>
        </h1>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="{{url ('/')}}">Home</a></li>
                <li><a class="nav-link scrollto " href="#services">Product</a></li>
                <li><a class="nav-link scrollto " href="#about">About</a></li>

                <li class="dropdown"><a href="#"><span>Kategori</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        @isset($ar_kategori)
                            @foreach ($ar_kategori as $kategori)
                                <li><a
                                        href="{{ route('categories.index', ['category' => $kategori->nama]) }}">{{ $kategori->nama }}</a>
                                </li>
                            @endforeach
                        @endisset
                    </ul>
                </li>
                @if (Auth::user())
                    <li><a class="getstarted scrollto" href="{{ url('/login') }}">{{ Auth::user()->name }}
                            ({{ Auth::user()->level }})</a></li>
                @else(Auth::user() == false)
                    <li><a class="getstarted scrollto" href="{{ url('/login') }}">Login</a></li>
                @endif

            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header>
