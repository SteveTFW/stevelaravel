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
        Register - Usaha Jaya
    </title>
    <style>
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

<body class="">
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
                                style="background-image: url('{{ asset('/landing/img/background.jpeg') }}'); background-size: cover;">
                            </div>
                        </div>
                        <div class="col-xl-0 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
                            <div class="card card-plain">
                                <div class="text-center">
                                    <img src="{{ asset('/landing/img/LOGO.png') }}" alt="Your Image" width="180"
                                        height="180">
                                </div>
                                <div class="card-header">
                                    <h5 class="font-weight-bolder">Selamat datang di Website Usaha Jaya</h5>
                                    <p class="mb-0">Masukkan email dan kata sandi Anda untuk mendaftar ke website
                                        Usaha Jaya</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" class="text-start" action="{{ route('user-register') }}"
                                        method="post">
                                        @csrf <!-- Tambahkan token CSRF untuk melindungi formulir -->

                                        <!-- Pesan Kesalahan -->
                                        @if (session('error'))
                                            <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                                <span class="text-sm">{{ session('error') }}</span>
                                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                                    data-bs-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        @if ($errors->any())
                                            <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                                <span class="text-sm">

                                                    @foreach ($errors->all() as $error)
                                                        {{ $error }}
                                                    @endforeach

                                                </span>
                                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                                    data-bs-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        <!-- Pesan Sukses -->
                                        @if (session('success'))
                                            <div class="alert alert-success alert-dismissible text-white"
                                                role="alert">
                                                <span class="text-sm">{{ session('success') }}</span>
                                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                                    data-bs-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        <label class="form-label">Nama</label>
                                        <div class="input-group input-group-outline mb-1">
                                            <input type="text" class="form-control" name="nama" required>
                                        </div>

                                        <label class="form-label">Email</label>
                                        <div class="input-group input-group-outline mb-1">
                                            <input type="email" class="form-control" name="email" required>
                                        </div>

                                        <label class="form-label">Password</label>
                                        <div class="input-group input-group-outline mb-1">
                                            <input type="password" class="form-control" name="password" required
                                                minlength="8">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Daftar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-2 text-sm mx-auto">
                                        Sudah memiliki akun?
                                        <a href="{{ route('view-login') }}"
                                            class="text-primary text-gradient font-weight-bold">Masuk</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!--   Core JS Files   -->
    <script src="{{ asset('/admin/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('/admin/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/smooth-scrollbar.min.js') }}"></script>
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
    <!-- Pastikan Anda sudah menyertakan Bootstrap CSS sebelumnya -->
    <!-- Skrip jQuery (diperlukan oleh Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Skrip Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
