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

        .btn-metode.selected {
            background-color: #4CAF50;
            /* Warna hijau yang dapat Anda sesuaikan */
            color: white;
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
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <nav
                    class="navbar navbar-expand-lg  blur border-radius-xl mt-4 top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                    <div class="container-fluid px-0">
                        <a class="navbar-brand" href="{{ route('home') }}" title="Usaha Jaya - Toko dan Jasa Konveksi"
                            data-placement="bottom">
                            <img alt="Image placeholder" class="avatar avatar-sm rounded-circle"
                                src="{{ asset('/landing/img/LOGO.png') }}">
                            <div class="brand-text">
                                <h1 class="navbar-brand">USAHA JAYA</h1>
                            </div>
                        </a>
                        <div class="collapse navbar-collapse pt-3 pb-2 py-lg-0 w-100" id="navigation">
                            <ul class="navbar-nav navbar-nav-hover ms-auto">
                                <li class="nav-item dropdown dropdown-hover mx-2">
                                    <a class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center"
                                        id="dropdownMenuPages8" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="material-icons opacity-6 me-2 text-md">dashboard</i>
                                        Menu
                                        <img src="{{ asset('/landing/img/down-arrow.svg') }}" alt="down-arrow"
                                            class="arrow ms-2 d-lg-block d-none">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-lg mt-0 mt-lg-3"
                                        aria-labelledby="dropdownMenuPages8">
                                        <div class="d-none d-lg-block">
                                            <h6
                                                class="dropdown-header text-dark font-weight-bolder d-flex align-items-center px-1">
                                                Pemesanan
                                            </h6>
                                            <a href="{{ route('halaman-produk') }}"
                                                class="dropdown-item border-radius-md">
                                                <span>Produk</span>
                                            </a>

                                            @if (session()->has('user_id'))
                                                <a href="{{ route('halaman-keranjang', ['id' => session('user_id')]) }}"
                                                    class="dropdown-item border-radius-md">
                                                    <span>Keranjang</span>
                                                </a>
                                            @else
                                                <a href="{{ route('view-login') }}"
                                                    class="dropdown-item border-radius-md">
                                                    <span>Keranjang</span>
                                                </a>
                                            @endif

                                            @if (session()->has('user_id'))
                                                <a href="{{ route('show-pesanan', ['id' => session('user_id')]) }}"
                                                    class="dropdown-item border-radius-md">
                                                    <span>Pembayaran</span>
                                                </a>
                                            @else
                                                <a href="{{ route('view-login') }}"
                                                    class="dropdown-item border-radius-md">
                                                    <span>Pembayaran</span>
                                                </a>
                                            @endif

                                            @if (session()->has('user_id'))
                                                <a href="{{ route('show-semua-pesanan', ['id' => session('user_id')]) }}"
                                                    class="dropdown-item border-radius-md">
                                                    <span>Riwayat Pesanan</span>
                                                </a>
                                            @else
                                                <a href="{{ route('view-login') }}"
                                                    class="dropdown-item border-radius-md">
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
                                        <img src="{{ asset('/landing/img/down-arrow.svg') }}" alt="down-arrow"
                                            class="arrow ms-2 d-lg-block d-none">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-lg mt-0 mt-lg-3"
                                        aria-labelledby="dropdownMenuPages8">
                                        <div class="d-none d-lg-block">
                                            <h6
                                                class="dropdown-header text-dark font-weight-bolder d-flex align-items-center px-1">
                                                Akun
                                            </h6>
                                            @if (session()->has('user_id'))
                                                <!-- Tampilkan saat pengguna sudah login -->
                                                <a href="{{ route('view-profile') }}"
                                                    class="dropdown-item border-radius-md">
                                                    <span>Profil</span>
                                                </a>
                                                <a href="{{ route('user-logout') }}"
                                                    class="dropdown-item border-radius-md">
                                                    <span>Keluar</span>
                                                </a>
                                            @else
                                                <!-- Tampilkan saat pengguna belum login -->
                                                <a href="{{ route('view-login') }}"
                                                    class="dropdown-item border-radius-md">
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
                                            <p class="d-inline text-sm z-index-1 font-weight-bold"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom">
                                                {{ session('nama_user') }}</p>
                                        </a>
                                    @else
                                        <a class="nav-link nav-link-icon me-2" href="{{ route('view-login') }}">
                                            <i class="fa fa-user-circle me-1"></i>
                                            <p class="d-inline text-sm z-index-1 font-weight-bold"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom">Masuk</p>
                                        </a>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>
        </div>
    </div>
    <!-- -------- START HEADER 7 w/ text and video ------- -->
    <header class="bg-gradient-dark">
        <div class="page-header min-height-200"
            style="background-image: url('{{ asset('/landing/img/background.jpeg') }}');">
            <span class="mask bg-gradient-dark opacity-6"></span>
        </div>
    </header>
    <!-- -------- END HEADER 7 w/ text and video ------- -->
    <div class="card card-body shadow-xl mx-auto mx-md-4 mt-n6">

        <!-- -------- START Features w/ pattern background & stats & rocket -------- -->
        @yield('content')

        <!-- -------- END Features w/ pattern background & stats & rocket -------- -->
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
                                <a class="nav-link pe-1" href="https://www.facebook.com/stevanusmichaelwibisono" target="_blank">
                                    <i class="fab fa-facebook text-lg opacity-8"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pe-1" href="https://www.instagram.com/steve_michael_07/" target="_blank">
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
    @stack('add-script')
</body>

</html>
