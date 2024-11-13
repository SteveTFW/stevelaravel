@extends('layouts.admin')

@section('title')
    Profil
@endsection

@section('page')
    Menu Akun / Profil
@endsection

@section('content')
    <div class="container-fluid py-0">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-0">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h5 class="text-white text-capitalize ps-3">Profil</h5>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-lg-5 position-relative bg-cover px-0"
                                            style="background-image: url('{{ asset('/landing/img/background.jpeg') }}')"
                                            loading="lazy">
                                            <div
                                                class="z-index-2 text-center d-flex h-100 w-100 d-flex m-auto justify-content-center">
                                                <div class="mask bg-gradient-dark opacity-6"></div>

                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <form class="p-3" id="contact-form"
                                                action="{{ route('admin-ubah-profile') }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <div class="card-header px-4 py-sm-5 py-3">
                                                    <h2>Profil</h2>
                                                    <p class="lead">Selamat datang, {{ $admin->nama }}</p>
                                                </div>
                                                <div class="card-body pt-1">
                                                    <div class="row">
                                                        <div class="col-md-12 pe-2 mb-3">
                                                            <div class="input-group input-group-static mb-4">
                                                                <label>Nama Pengguna</label>
                                                                <input type="text" class="form-control" id="nama"
                                                                    name="nama"
                                                                    placeholder="Masukkan nama pengguna disini..."
                                                                    value="{{ $admin->nama }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 pe-2 mb-3">
                                                            <div class="input-group input-group-static mb-4">
                                                                <label>Email Pengguna</label>
                                                                <input type="text" class="form-control" id="email"
                                                                    name="email"
                                                                    placeholder="Masukkan email pengguna disini.."
                                                                    value="{{ $admin->email }}" required readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 pe-2 mb-3">
                                                            <div class="input-group input-group-static mb-4">
                                                                <label>Nomor Telepon</label>
                                                                <input type="text" class="form-control"
                                                                    id="nomor_telepon" name="nomor_telepon"
                                                                    pattern="^[0-9\s\+\(\)\-]+$"
                                                                    title="Format yang valid: 1234, +1234, (1234), (123) 456-7890"
                                                                    placeholder="Masukkan nomor telepon pengguna disini.."
                                                                    value="{{ $admin->nomor_telepon }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 pe-2 mb-3">
                                                            <div class="input-group input-group-static mb-4">
                                                                <label>Alamat Pengguna</label>
                                                                <textarea name="alamat" class="form-control" id="alamat" rows="4" placeholder="Masukkan alamat pengguna..."
                                                                    required>{{ $admin->alamat }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-end ms-auto">
                                                            <button type="submit"
                                                                class="btn bg-gradient-info mb-0">Ubah</button>
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
                </div>
            </div>
        </div>
    </div>
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
