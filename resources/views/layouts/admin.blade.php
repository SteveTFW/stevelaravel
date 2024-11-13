<!--
=========================================================
* Material Dashboard 2 - v3.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/admin/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('/admin/img/LOGO.png') }}">
    <title>
        @yield('title') - Usaha Jaya Admin
    </title>
    <style>
        /* body {
            font-family: Arial, sans-serif;
            margin: 20px;
        } */

        h1 {
            color: #333;
        }

        .gambar-produk,
        .gambar-user {
            max-width: 100px;
            max-height: 100px;
        }

        .title-container {
            position: relative;
        }

        #btnTambah {
            position: absolute;
            top: 0;
            right: 0;
            margin-top: 10px;
            margin-right: 10px;
        }

        #modalForm {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.7);
            width: 100%;
            height: 100%;
        }

        .formTambah {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* padding: 20px; */
            max-width: 540px;
            width: 100%;
            max-height: 80vh;
            /* Tinggi maksimum modal, disesuaikan sesuai kebutuhan */
            overflow-y: auto;
            /* Menambahkan scrollbar vertikal jika kontennya melebihi tinggi layar */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: left;
            color: #333;
        }

        .modal-content label {
            display: block;
            margin-bottom: 8px;
        }

        .modal-content input,
        .modal-content textarea,
        .modal-content select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
            /* Ganti dengan jenis font yang diinginkan */
            font-size: 14px;
            max-width: 100%;
        }

        .modal-content form {
            max-width: 520px;
            margin: 0 auto;
        }

        .modal-content button {
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
            /* Lebar tombol mengisi 100% */
        }

        .modal-content h1 {
            text-align: center;
            margin-top: 0;
        }

        .formUbah {
            max-width: 600px;
            margin: 0 auto;
        }

        .formTambahTransaksi {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Style untuk card */
        .card {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
        }

        /* Style untuk elemen-elemen formulir */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        /* Style untuk tombol simpan */
        .btn-success {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        /* Gaya khusus untuk input tipe file */
        .form-control[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            /* Gaya khusus untuk input file jika diperlukan */
        }

        .estimasi-container {
            display: flex;
            align-items: center;
        }

        .estimasi-container label {
            margin-right: 10px;
            /* Sesuaikan jarak dengan text box */
        }
    </style>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('/admin/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('/admin/css/material-dashboard.css?v=3.1.0') }}" rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-200">
    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" target="_blank">
                <img src="{{ asset('/admin/img/LOGO.png') }}" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold text-white">USAHA JAYA</span>
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('home-admin') ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('home-admin') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                @if (session('kode_peran_admin') == 'KPRD' ||
                        session('kode_peran_admin') == 'KBLJ' ||
                        session('kode_peran_admin') == 'ADMN')
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Menu Stok
                        </h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('stok-produk') ? 'active bg-gradient-primary' : '' }}"
                            href="{{ route('stok-produk') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">warehouse</i>
                            </div>
                            <span class="nav-link-text ms-1">Barang Jadi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('stok-bahanbaku') ? 'active bg-gradient-primary' : '' }}"
                            href="{{ route('stok-bahanbaku') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">warehouse</i>
                            </div>
                            <span class="nav-link-text ms-1">Bahan Baku</span>
                        </a>
                    </li>
                @endif
                @if (session('kode_peran_admin') == 'KPRD' || session('kode_peran_admin') == 'ADMN')
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Menu
                            Produksi
                        </h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('list-produksi') || request()->routeIs('detail-produksi') ? 'active bg-gradient-primary' : '' }}"
                            href="{{ route('list-produksi') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">precision_manufacturing</i>
                            </div>
                            <span class="nav-link-text ms-1">Produksi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('riwayat-produksi') ? 'active bg-gradient-primary' : '' }}"
                            href="{{ route('riwayat-produksi') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">history</i>
                            </div>
                            <span class="nav-link-text ms-1">Riwayat</span>
                        </a>
                    </li>
                @endif
                @if (session('kode_peran_admin') == 'KKEU' ||
                        session('kode_peran_admin') == 'KBLJ' ||
                        session('kode_peran_admin') == 'ADMN')
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Menu
                            Laporan
                        </h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('view-pemasukkan') ? 'active bg-gradient-primary' : '' }}"
                            href="{{ route('view-pemasukkan') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">trending_up</i>
                            </div>
                            <span class="nav-link-text ms-1">Pemasukkan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('view-pengeluaran') ? 'active bg-gradient-primary' : '' }}"
                            href="{{ route('view-pengeluaran') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">trending_down</i>
                            </div>
                            <span class="nav-link-text ms-1">Pengeluaran</span>
                        </a>
                    </li>
                @endif
                @if (session('kode_peran_admin') == 'KPRD' ||
                        session('kode_peran_admin') == 'KBLJ' ||
                        session('kode_peran_admin') == 'ADMN')
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Menu
                            Transaksi
                        </h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('list-pesanan') || request()->routeIs('detail-pesanan') || request()->routeIs('show-ubah-pesanan') ? 'active bg-gradient-primary' : '' }}"
                            href="{{ route('list-pesanan') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">shopping_cart</i>
                            </div>
                            <span class="nav-link-text ms-1">Pesanan Pelanggan</span>
                        </a>
                    </li>
                @endif
                @if (session('kode_peran_admin') == 'KBLJ' || session('kode_peran_admin') == 'ADMN')
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('list-transaksi') || request()->routeIs('detail-transaksi') ? 'active bg-gradient-primary' : '' }}"
                            href="{{ route('list-transaksi') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">local_mall</i>
                            </div>
                            <span class="nav-link-text ms-1">Pembelian Bahan Baku</span>
                        </a>
                    </li>
                @endif
                @if (session('kode_peran_admin') == 'ADMN')
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Menu
                            Master
                        </h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('list-produk') || request()->routeIs('show-ubah-produk') || request()->routeIs('ukuran-produk') || request()->routeIs('bahan-baku-produk') ? 'active bg-gradient-primary' : '' }}"
                            href="{{ route('list-produk') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">inventory</i>
                            </div>
                            <span class="nav-link-text ms-1">Produk</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('list-bahanbaku') || request()->routeIs('show-ubah-bahanbaku') ? 'active bg-gradient-primary' : '' }}"
                            href="{{ route('list-bahanbaku') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">inventory_2</i>
                            </div>
                            <span class="nav-link-text ms-1">Bahan Baku</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('list-kategori') || request()->routeIs('show-ubah-kategori') ? 'active bg-gradient-primary' : '' }}"
                            href="{{ route('list-kategori') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">category</i>
                            </div>
                            <span class="nav-link-text ms-1">Kategori</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('list-user') ? 'active bg-gradient-primary' : '' }}"
                            href="{{ route('list-user') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">people</i>
                            </div>
                            <span class="nav-link-text ms-1">User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('list-peran') || request()->routeIs('show-ubah-peran') ? 'active bg-gradient-primary' : '' }}"
                            href="{{ route('list-peran') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">military_tech</i>
                            </div>
                            <span class="nav-link-text ms-1">Peran</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('list-supplier') || request()->routeIs('list-bahanbaku-supplier') || request()->routeIs('show-ubah-supplier') ? 'active bg-gradient-primary' : '' }}"
                            href="{{ route('list-supplier') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">local_shipping</i>
                            </div>
                            <span class="nav-link-text ms-1">Supplier</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Menu Akun
                    </h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin-profile') ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('admin-profile', ['id' => session('user_id_admin')]) }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <span class="nav-link-text ms-1">Profil</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidenav-footer position-absolute w-100 bottom-0 ">
            <div class="mx-3">
                <a class="btn btn-danger mt-4 w-100" href="{{ route('admin-logout') }}" type="button">Log Out</a>
            </div>
        </div>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
            data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        {{-- <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
                                href="javascript:;">Pages</a></li> --}}
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">@yield('page')
                        </li>
                    </ol>
                    <h6 class="font-weight-bolder mb-0">@yield('title')</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group input-group-outline">
                            {{-- <label class="form-label">Type here...</label>
                            <input type="text" class="form-control"> --}}
                        </div>
                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0">
                                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                            </a>
                        </li>
                        {{-- <li class="nav-item dropdown px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell cursor-pointer"></i>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                                aria-labelledby="dropdownMenuButton">
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="{{ asset('/admin/img/team-2.jpg') }}"
                                                    class="avatar avatar-sm  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New message</span> from Laur
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    13 minutes ago
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="{{ asset('/admin/img/small-logos/logo-spotify.svg') }}"
                                                    class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New album</span> by Travis Scott
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    1 day
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                                <svg width="12px" height="12px" viewBox="0 0 43 36"
                                                    version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <title>credit-card</title>
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">
                                                        <g transform="translate(-2169.000000, -745.000000)"
                                                            fill="#FFFFFF" fill-rule="nonzero">
                                                            <g transform="translate(1716.000000, 291.000000)">
                                                                <g transform="translate(453.000000, 454.000000)">
                                                                    <path class="color-background"
                                                                        d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                                        opacity="0.593633743"></path>
                                                                    <path class="color-background"
                                                                        d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    Payment successfully completed
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    2 days
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a class="nav-link text-body font-weight-bold px-0">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none">
                                    @if (Session::has('nama_user_admin'))
                                        {{ Session::get('nama_user_admin') }}
                                    @else
                                        Nama User
                                    @endif
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">

            @yield('content')

            <footer class="footer py-4  ">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>,
                                Developed for Usaha Jaya
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                                <li class="nav-item">
                                    <a href="" class="nav-link text-muted" target="_blank">Tentang Kami</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-muted" target="_blank"></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-muted" target="_blank"></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-muted" target="_blank"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>
    <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="material-icons py-2">settings</i>
        </a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Pengaturan UI</h5>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="material-icons">clear</i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Warna Menu Sidebar</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary active" data-color="primary"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark" data-color="dark"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger"
                            onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Tipe Sidenav</h6>
                    <p class="text-sm">Pilih antara 3 jenis sidenav yang berbeda.</p>
                </div>
                <div class="d-flex">
                    <button class="btn bg-gradient-dark px-3 mb-2 active" data-class="bg-gradient-dark"
                        onclick="sidebarType(this)">Gelap</button>
                    <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent"
                        onclick="sidebarType(this)">Transparan</button>
                    <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-white"
                        onclick="sidebarType(this)">Putih</button>
                </div>
                <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
                <!-- Navbar Fixed -->
                <div class="mt-3 d-flex">
                    <h6 class="mb-0">Navbar Posisi Tetap</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                            onclick="navbarFixed(this)">
                    </div>
                </div>
                <hr class="horizontal dark my-3">
                <div class="mt-2 d-flex">
                    <h6 class="mb-0">Mode Terang / Mode Gelap</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version"
                            onclick="darkMode(this)">
                    </div>
                </div>
                <hr class="horizontal dark my-sm-4">
                <div class="w-100 text-center">
                    <h6 class="mt-3">Ikuti media sosial kami!</h6>
                    <a href="" class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-instagram me-1" aria-hidden="true"></i> Post
                    </a>
                    <a href="" class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('/admin/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('/admin/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/chartjs.min.js') }}"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('/admin/js/material-dashboard.min.js?v=3.1.0') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('add-script')
</body>

</html>
