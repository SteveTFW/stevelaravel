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
    <section class="pb-5 position-relative bg-gradient-dark">
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
                                            <img class="w-100 border-radius-md shadow-lg" src="{{ asset($item->gambar) }}"
                                                alt="image">
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
            {{-- <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 text-center">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Gambar</th>
                                            <th>Deskripsi</th>
                                            <th>Status</th>
                                            <th>Ukuran</th>
                                            <th>Kategori</th>
                                            <th>Atur Ukuran Produk</th>
                                            <th>Atur Bahan Baku Produk</th>
                                            <th colspan="2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">Nama</p>
                                            </td>
                                            <td>
                                                <p>Tidak ada gambar</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">Deskripsi</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">Status</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">
                                                    Rp
                                                    {{ number_format(20000, 0, ',', '.') }}<br></p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">Nama Kategori
                                                </p>
                                            </td>
                                            <td>
                                                <form action="" method="post" onsubmit="return confirmDelete()">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger mt-4">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
@endsection
