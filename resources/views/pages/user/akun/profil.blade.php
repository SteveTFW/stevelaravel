@extends('layouts.landing2')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible text-white" role="alert">
            <span class="text-sm">{{ session('success') }}</span>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible text-white" role="alert">
            <span class="text-sm">{{ session('error') }}</span>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <section class="py-lg-5 bg-gradient-dark">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card box-shadow-xl overflow-hidden mb-5">
                        <div class="row">
                            <div class="col-lg-5 position-relative bg-cover px-0"
                                style="background-image: url('{{ asset('/landing/img/background.jpeg') }}')" loading="lazy">
                                <div class="z-index-2 text-center d-flex h-100 w-100 d-flex m-auto justify-content-center">
                                    <div class="mask bg-gradient-dark opacity-6"></div>
                                    {{-- <div class="p-5 ps-sm-8 position-relative text-start my-auto z-index-2">
                                        <h3 class="text-white">Contact Information</h3>
                                        <p class="text-white opacity-8 mb-4">Fill up the form and our Team will get back to
                                            you within 24 hours.</p>
                                        <div class="d-flex p-2 text-white">
                                            <div>
                                                <i class="fas fa-phone text-sm"></i>
                                            </div>
                                            <div class="ps-3">
                                                <span class="text-sm opacity-8">(+40) 772 100 200</span>
                                            </div>
                                        </div>
                                        <div class="d-flex p-2 text-white">
                                            <div>
                                                <i class="fas fa-envelope text-sm"></i>
                                            </div>
                                            <div class="ps-3">
                                                <span class="text-sm opacity-8">hello@creative-tim.com</span>
                                            </div>
                                        </div>
                                        <div class="d-flex p-2 text-white">
                                            <div>
                                                <i class="fas fa-map-marker-alt text-sm"></i>
                                            </div>
                                            <div class="ps-3">
                                                <span class="text-sm opacity-8">Dyonisie Wolf Bucharest, RO 010458</span>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <button type="button" class="btn btn-icon-only btn-link text-white btn-lg mb-0"
                                                data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Log in with Facebook">
                                                <i class="fab fa-facebook"></i>
                                            </button>
                                            <button type="button" class="btn btn-icon-only btn-link text-white btn-lg mb-0"
                                                data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Log in with Twitter">
                                                <i class="fab fa-twitter"></i>
                                            </button>
                                            <button type="button" class="btn btn-icon-only btn-link text-white btn-lg mb-0"
                                                data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Log in with Dribbble">
                                                <i class="fab fa-dribbble"></i>
                                            </button>
                                            <button type="button" class="btn btn-icon-only btn-link text-white btn-lg mb-0"
                                                data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Log in with Instagram">
                                                <i class="fab fa-instagram"></i>
                                            </button>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <form class="p-3" id="contact-form" action="{{ route('ubah-profile') }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="card-header px-4 py-sm-5 py-3">
                                        <h2>Profil</h2>
                                        <p class="lead">Selamat datang, {{ $user->nama }}</p>
                                    </div>
                                    <div class="card-body pt-1">
                                        <div class="row">
                                            <div class="col-md-12 pe-2 mb-3">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Nama Pengguna</label>
                                                    <input type="text" class="form-control" id="nama" name="nama"
                                                        placeholder="Masukkan nama pengguna disini..."
                                                        value="{{ $user->nama }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12 pe-2 mb-3">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Email Pengguna</label>
                                                    <input type="text" class="form-control" id="email" name="email"
                                                        placeholder="Masukkan email pengguna disini.."
                                                        value="{{ $user->email }}" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-12 pe-2 mb-3">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Nomor Telepon</label>
                                                    <input type="text" class="form-control" id="nomor_telepon"
                                                        name="nomor_telepon" pattern="^[0-9\s\+\(\)\-]+$"
                                                        title="Format yang valid: 1234, +1234, (1234), (123) 456-7890"
                                                        placeholder="Masukkan nomor telepon pengguna disini.."
                                                        value="{{ $user->nomor_telepon }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12 pe-2 mb-3">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Alamat Pengguna</label>
                                                    <textarea name="alamat" class="form-control" id="alamat" rows="4" placeholder="Masukkan alamat pengguna..."
                                                        required>{{ $user->alamat }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 text-end ms-auto">
                                                <button type="submit" class="btn bg-gradient-info mb-0">Ubah</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('add-script')
    <script>
        function confirmUbah() {
            var result = confirm("Apakah Anda yakin ingin mengubah profil?");
            return result; // Mengembalikan true jika pengguna mengklik 'OK', dan false jika 'Cancel'
        }

        document.getElementById('contact-form').addEventListener('submit', function(event) {
            if (!confirmUbah()) {
                event.preventDefault(); // Mencegah pengiriman form jika pengguna membatalkan
            }
        });
    </script>
@endpush
