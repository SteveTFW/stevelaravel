@extends('layouts.landing')

{{-- @section('navbar')
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

                                <a href="../pages/contact-us.html" class="dropdown-item border-radius-md">
                                    <span>Pembayaran</span>
                                </a>
                                <a href="../pages/author.html" class="dropdown-item border-radius-md">
                                    <span>Riwayat Pembelian</span>
                                </a>
                                <h6
                                    class="dropdown-header text-dark font-weight-bolder d-flex align-items-center px-1 mt-3">
                                    Lain-lain
                                </h6>
                                <a href="" class="dropdown-item border-radius-md">
                                    <span>Tentang Kami</span>
                                </a>
                                <a href="" class="dropdown-item border-radius-md">
                                    <span>Kontak Kami</span>
                                </a>
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
                                    <a href="" class="dropdown-item border-radius-md">
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
@endsection --}}
