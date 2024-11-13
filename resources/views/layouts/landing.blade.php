<!--
=========================================================
* Material Kit 2 - v3.0.4
=========================================================

* Product Page:  https://www.creative-tim.com/product/material-kit
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/landing/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('/landing/img/LOGO.png') }}">
    <title>
        Usaha Jaya - Toko dan Jasa Konveksi
    </title>
    <style>
        .brand-text {
            display: inline-block;
            vertical-align: auto;
            margin-left: 10px;
            /* Sesuaikan margin sesuai kebutuhan Anda */
        }
    </style>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('/landing/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('/landing/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('/landing/css/material-kit.css?v=3.0.4') }}" rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="about-us bg-gray-200">
    {{-- @yield('navbar') --}}
    <!-- Navbar Transparent -->
    <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3  navbar-transparent ">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}" title="Usaha Jaya - Toko dan Jasa Konveksi"
                data-placement="bottom">
                <img alt="Image placeholder" class="avatar avatar-sm rounded-circle"
                    src="{{ asset('/landing/img/LOGO.png') }}">
                <div class="brand-text">
                    <h1 class="navbar-brand text-white">USAHA JAYA</h1>
                </div>
            </a>

            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon mt-2">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </span>
            </button>
            <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0 ms-lg-12 ps-lg-5" id="navigation">
                <ul class="navbar-nav navbar-nav-hover ms-auto">
                    <li class="nav-item dropdown dropdown-hover mx-2 ms-lg-6">
                        <a class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center"
                            id="dropdownMenuPages8" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons opacity-6 me-2 text-md">dashboard</i>
                            Menu
                            <img src="{{ asset('/landing/img/down-arrow-white.svg') }}" alt="down-arrow"
                                class="arrow ms-2 d-lg-block d-none">
                            <img src="{{ asset('/landing/img/down-arrow-dark.svg') }}" alt="down-arrow"
                                class="arrow ms-2 d-lg-none d-block">
                        </a>
                        <div class="dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-lg mt-0 mt-lg-3"
                            aria-labelledby="dropdownMenuPages8">
                            <div class="d-none d-lg-block">
                                <h6 class="dropdown-header text-dark font-weight-bolder d-flex align-items-center px-1">
                                    Pemesanan
                                </h6>
                                <a href="{{ route('halaman-produk') }}" class="dropdown-item border-radius-md">
                                    <span>Produk</span>
                                </a>

                                @if (session()->has('user_id'))
                                    <a href="{{ route('halaman-keranjang', ['id' => session('user_id')]) }}"
                                        class="dropdown-item border-radius-md">
                                        <span>Keranjang</span>
                                    </a>
                                @else
                                    <a href="{{ route('view-login') }}" class="dropdown-item border-radius-md">
                                        <span>Keranjang</span>
                                    </a>
                                @endif

                                @if (session()->has('user_id'))
                                    <a href="{{ route('show-pesanan', ['id' => session('user_id')]) }}"
                                        class="dropdown-item border-radius-md">
                                        <span>Pembayaran</span>
                                    </a>
                                @else
                                    <a href="{{ route('view-login') }}" class="dropdown-item border-radius-md">
                                        <span>Pembayaran</span>
                                    </a>
                                @endif

                                @if (session()->has('user_id'))
                                    <a href="{{ route('show-semua-pesanan', ['id' => session('user_id')]) }}"
                                        class="dropdown-item border-radius-md">
                                        <span>Riwayat Pesanan</span>
                                    </a>
                                @else
                                    <a href="{{ route('view-login') }}" class="dropdown-item border-radius-md">
                                        <span>Riwayat Pesanan</span>
                                    </a>
                                @endif

                                {{-- <h6
                                    class="dropdown-header text-dark font-weight-bolder d-flex align-items-center px-1 mt-3">
                                    Lain-lain
                                </h6>
                                <a href="" class="dropdown-item border-radius-md">
                                    <span>Tentang Kami</span>
                                </a>
                                <a href="" class="dropdown-item border-radius-md">
                                    <span>Kontak Kami</span>
                                </a> --}}
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown dropdown-hover mx-2 ms-lg-0">
                        <a class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center"
                            id="dropdownMenuPages8" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons opacity-6 me-2 text-md">settings</i>
                            Pengaturan
                            <img src="{{ asset('/landing/img/down-arrow-white.svg') }}" alt="down-arrow"
                                class="arrow ms-2 d-lg-block d-none">
                            <img src="{{ asset('/landing/img/down-arrow-dark.svg') }}" alt="down-arrow"
                                class="arrow ms-2 d-lg-none d-block">
                        </a>
                        <div class="dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-lg mt-0 mt-lg-3"
                            aria-labelledby="dropdownMenuPages8">
                            <div class="d-none d-lg-block">
                                <h6 class="dropdown-header text-dark font-weight-bolder d-flex align-items-center px-1">
                                    Akun
                                </h6>
                                @if (session()->has('user_id'))
                                    <!-- Tampilkan saat pengguna sudah login -->
                                    <a href="{{ route('view-profile', ['id' => session('user_id')]) }}"
                                        class="dropdown-item border-radius-md">
                                        <span>Profil</span>
                                    </a>
                                    <a href="{{ route('user-logout') }}" class="dropdown-item border-radius-md">
                                        <span>Keluar</span>
                                    </a>
                                @else
                                    <!-- Tampilkan saat pengguna belum login -->
                                    <a href="{{ route('view-login') }}" class="dropdown-item border-radius-md">
                                        <span>Masuk</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </li>
                    <li class="nav-item ms-lg-auto">
                        @if (session()->has('user_id'))
                            <a class="nav-link nav-link-icon me-2">
                                <i class="fa fa-user-circle me-1"></i>
                                <p class="d-inline text-sm z-index-1 font-weight-bold" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom">{{ session('nama_user') }}</p>
                            </a>
                        @else
                            <a class="nav-link nav-link-icon me-2" href="{{ route('view-login') }}">
                                <i class="fa fa-user-circle me-1"></i>
                                <p class="d-inline text-sm z-index-1 font-weight-bold" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom">Masuk</p>
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <!-- -------- START HEADER 7 w/ text and video ------- -->
    <header class="bg-gradient-dark">
        <div class="page-header min-vh-75"
            style="background-image: url('{{ asset('/landing/img/background.jpeg') }}');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center mx-auto my-auto">
                        @if (session()->has('user_id'))
                            <h1 class="text-white">Selamat datang, {{ session('nama_user') }}</h1>
                            <p class="lead mb-4 text-white opacity-8">Website Usaha Jaya dirancang untuk memudahkan
                                pelanggan dalam melakukan pemesanan dan pembayaran. Pembayaran transfer menggunakan
                                Midtrans Payment Gateway untuk menjamin keamanan transaksi. Selamat berbelanja di
                                website kami!</p>
                        @else
                            <h1 class="text-white">Usaha Jaya</h1>
                            <p class="lead mb-4 text-white opacity-8">Usaha Jaya merupakan usaha konveksi yang menjual
                                produk pakaian atau tekstil. Sejarahnya, usaha ini mulai ada sejak tahun 1998 dan hanya
                                memproduksi pada pembuatan celana dalam pria. Sekarang ini usaha ini telah berkembang
                                luas dalam produksi pakaian, mulai dari pembuatan pakaian bayi hingga pakaian orang
                                dewasa, akan tetapi masih tetap berfokus dalam produksi celana dalam.</p>
                            <a href="{{ route('view-register') }}" class="btn bg-white text-dark">Buat Akun</a>
                        @endif

                        <h6 class="text-white mb-2 mt-4">Ikuti kami di</h6>
                        <div class="d-flex justify-content-center">
                            <a href="https://www.facebook.com/stevanusmichaelwibisono" target="_blank"><i
                                    class="fab fa-facebook fa-2x text-white me-3"></i></a>
                            <a href="https://www.instagram.com/steve_michael_07/" target="_blank"><i
                                    class="fab fa-instagram fa-2x text-white me-3"></i></a>
                            <a href="https://wa.me/qr/YA7CQZMZ2LC3P1" target="_blank"><i
                                    class="fab fa-whatsapp fa-2x text-white"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- -------- END HEADER 7 w/ text and video ------- -->
    <div class="card card-body shadow-xl mx-3 mx-md-4 mt-n6">
        <!-- Section with four info areas left & one card right with image and waves -->
        {{-- <section class="py-7">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="row justify-content-start">
                            <div class="col-md-6">
                                <div class="info">
                                    <i class="material-icons text-3xl text-gradient text-info mb-3">public</i>
                                    <h5>Fully integrated</h5>
                                    <p>We get insulted by others, lose trust for those We get back freezes</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info">
                                    <i class="material-icons text-3xl text-gradient text-info mb-3">payments</i>
                                    <h5>Payments functionality</h5>
                                    <p>We get insulted by others, lose trust for those We get back freezes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-start mt-4">
                            <div class="col-md-6">
                                <div class="info">
                                    <i class="material-icons text-3xl text-gradient text-info mb-3">apps</i>
                                    <h5>Prebuilt components</h5>
                                    <p>We get insulted by others, lose trust for those We get back freezes</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info">
                                    <i class="material-icons text-3xl text-gradient text-info mb-3">3p</i>
                                    <h5>Improved platform</h5>
                                    <p>We get insulted by others, lose trust for those We get back freezes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 ms-auto mt-lg-0 mt-4">
                        <div class="card">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <a class="d-block blur-shadow-image">
                                    <img src="https://images.unsplash.com/photo-1544717302-de2939b7ef71?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80"
                                        alt="img-colored-shadow" class="img-fluid border-radius-lg">
                                </a>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="font-weight-normal">
                                    <a href="javascript:;">Get insights on Search</a>
                                </h5>
                                <p class="mb-0">
                                    Website visitors today demand a frictionless user expericence — especially when
                                    using search. Because of the hight standards.
                                </p>
                                <button type="button" class="btn bg-gradient-info btn-sm mb-0 mt-3">Find out
                                    more</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <section class="pt-4 pb-6 mt-5" id="count-stats">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-md-3">
                        <h1 class="text-gradient text-info" id="state1" countTo="{{ $pesanan }}">0</h1>
                        <h5>Pemesanan</h5>
                        <p>yang telah Anda dilakukan pada 30 hari terakhir</p>
                    </div>
                    <div class="col-md-3">
                        <h1 class="text-gradient text-info" id="state3" countTo="{{ $menunggu }}">0</h1>
                        <h5>Pesanan</h5>
                        <p>Anda sedang menunggu dikonfirmasi. Mohon ditunggu, ya!</p>
                    </div>
                    <div class="col-md-3">
                        <h1 class="text-gradient text-info" id="state2" countTo="{{ $belumlunas }}">0</h1>
                        <h5>Pesanan</h5>
                        <p>Anda sedang menunggu pembayaran DP maupun pelunasan pembayaran</p>
                    </div>

                </div>
            </div>
        </section>
        <!-- END Section with four info areas left & one card right with image and waves -->
        <!-- -------- START Features w/ pattern background & stats & rocket -------- -->
        <section class="pb-5 position-relative bg-gradient-dark mx-n0">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 text-start mb-5 mt-5">
                        <h3 class="text-white z-index-1 position-relative">Produk Kami</h3>
                        <p class="text-white opacity-8 mb-0">Usaha Jaya - Toko dan Jasa Konveksi</p>
                    </div>
                </div>
                <div class="row">
                    @foreach ($produk as $item)
                        <div class="col-lg-6 col-12">
                            <div class="card card-profile mt-4 mb-5">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-12 mt-n5">
                                        <a href="{{ route('halaman-detail-produk', ['id' => $item->id]) }}">
                                            <div class="p-3 pe-md-0">
                                                <img class="w-100 border-radius-md shadow-lg"
                                                    src="{{ asset($item->gambar) }}" alt="image">
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-8 col-md-6 col-12 my-auto">
                                        <div class="card-body ps-lg-0">
                                            <h5 class="mb-0">{{ $item->nama }}</h5><br>
                                            <h6 class="text-info">Deskripsi:</h6>
                                            <p class="mb-0">{{ $item->deskripsi }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- -------- END Features w/ pattern background & stats & rocket -------- -->
        {{-- <section class="pt-4 pb-6 mt-5" id="count-stats">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-md-3">
                        <h1 class="text-gradient text-info" id="state1" countTo="{{ $pesanan }}">0</h1>
                        <h5>Pemesanan</h5>
                        <p>yang telah Anda dilakukan pada 30 hari terakhir</p>
                    </div>
                    <div class="col-md-3">
                        <h1 class="text-gradient text-info" id="state3" countTo="{{ $menunggu }}">0</h1>
                        <h5>Pesanan</h5>
                        <p>Anda sedang menunggu untuk konfirmasi. Mohon ditunggu!</p>
                    </div>
                    <div class="col-md-3">
                        <h1 class="text-gradient text-info" id="state2" countTo="{{ $belumlunas }}">0</h1>
                        <h5>Pesanan</h5>
                        <p>yang menunggu pembayaran DP maupun pelunasan pembayaran</p>
                    </div>
                    
                </div>
            </div>
        </section> --}}
        <!-- -------- START PRE-FOOTER 1 w/ SUBSCRIBE BUTTON AND IMAGE ------- -->
        <section class="my-5 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 m-auto">
                        <h4>Hubungi kami...</h4>
                        <p class="mb-4">
                            Kami di sini untuk membantu Anda dengan pertanyaan atau permasalahan apa pun yang mungkin
                            Anda miliki. Jangan ragu untuk menghubungi kami melalui metode kontak yang kami sediakan!
                        </p>
                        <div class="row">
                            <div class="col-4 ps-0">
                                <button type="button"
                                    class="btn bg-gradient-info mb-0 h-100 position-relative z-index-2"
                                    onclick="openGmail()">
                                    Email kami...
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ms-auto">
                        <div class="position-relative">
                            <img class="max-width-50 w-75 position-relative z-index-2"
                                src="{{ asset('/landing/img/communications.png') }}" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- -------- END PRE-FOOTER 1 w/ SUBSCRIBE BUTTON AND IMAGE ------- -->
    </div>
    <footer class="footer pt-5 mt-5">
        <div class="container">
            <div class=" row">
                <div class="col-md-12 mb-4 ms-auto text-center">
                    <div>
                        <img src="{{ asset('/landing/img/LOGO.png') }}" class="mb-3 footer-logo" alt="main_logo">
                        <h6 class="font-weight-bolder mb-4">USAHA JAYA</h6>
                    </div>
                    <div>
                        <ul class="d-flex flex-row justify-content-center ms-n3 nav">
                            <li class="nav-item">
                                <a class="nav-link pe-1" href="https://www.facebook.com/stevanusmichaelwibisono"
                                    target="_blank">
                                    <i class="fab fa-facebook text-lg opacity-8"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pe-1" href="https://www.instagram.com/steve_michael_07/"
                                    target="_blank">
                                    <i class="fab fa-instagram text-lg opacity-8"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pe-1" href="https://wa.me/qr/YA7CQZMZ2LC3P1" target="_blank">
                                    <i class="fab fa-whatsapp text-lg opacity-8"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- <div class="col-md-2 col-sm-6 col-6 mb-4">
                    <div>
                        <h6 class="text-sm">Company</h6>
                        <ul class="flex-column ms-n3 nav">
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.creative-tim.com/presentation" target="_blank">
                                    About Us
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.creative-tim.com/templates/free"
                                    target="_blank">
                                    Freebies
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.creative-tim.com/templates/premium"
                                    target="_blank">
                                    Premium Tools
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.creative-tim.com/blog" target="_blank">
                                    Blog
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-6 mb-4">
                    <div>
                        <h6 class="text-sm">Resources</h6>
                        <ul class="flex-column ms-n3 nav">
                            <li class="nav-item">
                                <a class="nav-link" href="https://iradesign.io/" target="_blank">
                                    Illustrations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.creative-tim.com/bits" target="_blank">
                                    Bits & Snippets
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.creative-tim.com/affiliates/new"
                                    target="_blank">
                                    Affiliate Program
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-6 mb-4">
                    <div>
                        <h6 class="text-sm">Help & Support</h6>
                        <ul class="flex-column ms-n3 nav">
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.creative-tim.com/contact-us" target="_blank">
                                    Contact Us
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.creative-tim.com/knowledge-center"
                                    target="_blank">
                                    Knowledge Center
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://services.creative-tim.com/?ref=ct-mk2-footer"
                                    target="_blank">
                                    Custom Development
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.creative-tim.com/sponsorships" target="_blank">
                                    Sponsorships
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-6 mb-4 me-auto">
                    <div>
                        <h6 class="text-sm">Legal</h6>
                        <ul class="flex-column ms-n3 nav">
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="https://www.creative-tim.com/knowledge-center/terms-of-service"
                                    target="_blank">
                                    Terms & Conditions
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="https://www.creative-tim.com/knowledge-center/privacy-policy"
                                    target="_blank">
                                    Privacy Policy
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.creative-tim.com/license" target="_blank">
                                    Licenses (EULA)
                                </a>
                            </li>
                        </ul>
                    </div>
                </div> --}}
                <div class="col-12">
                    <div class="text-center">
                        <p class="text-dark my-4 text-sm font-weight-normal">
                            All rights reserved. Copyright ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Developed for Usaha Jaya
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--   Core JS Files   -->
    <script src="{{ asset('/landing/js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/landing/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/landing/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <!--  Plugin for TypedJS, full documentation here: https://github.com/inorganik/CountUp.js -->
    <script src="{{ asset('/landing/js/plugins/countup.min.js') }}"></script>
    <!-- Control Center for Material UI Kit: parallax effects, scripts for the example pages etc -->
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTTfWur0PDbZWPr7Pmq8K3jiDp0_xUziI"></script>
    <script src="{{ asset('/landing/js/material-kit.min.js?v=3.0.4') }}" type="text/javascript"></script>
    <script>
        // get the element to animate
        var element = document.getElementById('count-stats');
        var elementHeight = element.clientHeight;

        // listen for scroll event and call animate function

        document.addEventListener('scroll', animate);

        // check if element is in view
        function inView() {
            // get window height
            var windowHeight = window.innerHeight;
            // get number of pixels that the document is scrolled
            var scrollY = window.scrollY || window.pageYOffset;
            // get current scroll position (distance from the top of the page to the bottom of the current viewport)
            var scrollPosition = scrollY + windowHeight;
            // get element position (distance from the top of the page to the bottom of the element)
            var elementPosition = element.getBoundingClientRect().top + scrollY + elementHeight;

            // is scroll position greater than element position? (is element in view?)
            if (scrollPosition > elementPosition) {
                return true;
            }

            return false;
        }

        var animateComplete = true;
        // animate element when it is in view
        function animate() {

            // is element in view?
            if (inView()) {
                if (animateComplete) {
                    if (document.getElementById('state1')) {
                        const countUp = new CountUp('state1', document.getElementById("state1").getAttribute("countTo"));
                        if (!countUp.error) {
                            countUp.start();
                        } else {
                            console.error(countUp.error);
                        }
                    }
                    if (document.getElementById('state2')) {
                        const countUp1 = new CountUp('state2', document.getElementById("state2").getAttribute("countTo"));
                        if (!countUp1.error) {
                            countUp1.start();
                        } else {
                            console.error(countUp1.error);
                        }
                    }
                    if (document.getElementById('state3')) {
                        const countUp2 = new CountUp('state3', document.getElementById("state3").getAttribute("countTo"));
                        if (!countUp2.error) {
                            countUp2.start();
                        } else {
                            console.error(countUp2.error);
                        };
                    }
                    animateComplete = false;
                }
            }
        }

        if (document.getElementById('typed')) {
            var typed = new Typed("#typed", {
                stringsElement: '#typed-strings',
                typeSpeed: 90,
                backSpeed: 90,
                backDelay: 200,
                startDelay: 500,
                loop: true
            });
        }
    </script>
    <script>
        if (document.getElementsByClassName('page-header')) {
            window.onscroll = debounce(function() {
                var scrollPosition = window.pageYOffset;
                var bgParallax = document.querySelector('.page-header');
                var oVal = (window.scrollY / 3);
                bgParallax.style.transform = 'translate3d(0,' + oVal + 'px,0)';
            }, 6);
        }
    </script>
    <script>
        function openGmail() {
            var email = 'email@example.com';
            var subject = encodeURIComponent('Pertanyaan / Permasalahan terkait penggunaan Website Usaha Jaya');
            var body = encodeURIComponent('Silahkan tulis pertanyaan / permasalahan Anda disini');
            var url = `https://mail.google.com/mail/?view=cm&fs=1&to=${email}&su=${subject}&body=${body}`;
            window.open(url, '_blank');
        }
    </script>
</body>

</html>
