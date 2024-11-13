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
        Login - Usaha Jaya
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

<body class="bg-gray-200">

    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('{{ asset('/landing/img/background.jpeg') }}');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-auto">
                <div class="text-center mb-4">
                    <img src="{{ asset('/landing/img/LOGO.png') }}" alt="Your Image" width="200" height="200">
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h3 class="text-white font-weight-bolder text-center mt-2 mb-0">Usaha Jaya
                                    </h3>
                                    <p class="text-white font-weight-bolder text-center mt-2 mb-0">Toko dan Jasa
                                        Konveksi</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <form role="form" class="text-start" action="{{ route('user-login') }}"
                                    method="post">
                                    @csrf <!-- Tambahkan token CSRF untuk melindungi formulir -->

                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" required
                                            autocomplete="new-email"
                                            oninvalid="this.setCustomValidity('Mohon untuk mengisi alamat email!')"
                                            oninput="this.setCustomValidity('')">
                                    </div>

                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" required
                                            minlength="8"
                                            oninvalid="this.setCustomValidity('Mohon untuk mengisi password!')"
                                            oninput="this.setCustomValidity('')">
                                    </div>

                                    {{-- ... bagian formulir lainnya ... --}}
                                    @error('email')
                                        <h6 class="text-danger mt-2">{{ $message }}</h6>
                                    @enderror

                                    @error('password')
                                        <h6 class="text-danger mt-2">{{ $message }}</h6>
                                    @enderror

                                    <div class="text-center">
                                        <button type="submit"
                                            class="btn bg-gradient-primary w-100 my-4 mb-2">Masuk</button>
                                    </div>

                                    <p class="mt-4 text-sm text-center">
                                        Belum punya akun?
                                        <a href="{{ route('view-register') }}"
                                            class="text-primary text-gradient font-weight-bold">Daftar Disini</a>
                                    </p>
                                </form>
                            </div>

                            {{-- <p class="mt-4 text-sm text-center">
                                Belum punya akun?
                                <a href="../pages/sign-up.html"
                                    class="text-primary text-gradient font-weight-bold">Daftar Disini</a>
                            </p> --}}
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer position-absolute bottom-2 py-2 w-100">
                <div class="container">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-12 col-md-6 my-auto">
                            <div class="copyright text-center text-sm text-white text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>,
                                Developed for
                                <a href="{{ route('home') }}" class="text-white fw-bold">Usaha Jaya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            
        </div>
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
</body>

</html>
