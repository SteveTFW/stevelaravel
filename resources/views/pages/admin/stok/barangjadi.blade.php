@extends('layouts.admin')

@section('title')
    Barang Jadi
@endsection

@section('page')
    Menu Stok / Barang Jadi
@endsection

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

    @if ($groupedProduk->count() > 0)
        <div class="container-fluid py-0">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h5 class="text-white text-capitalize ps-3">Stok Barang Jadi</h5>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 text-center" style="min-height:500px; max-height:500px">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Deskripsi</th>
                                            <th>Ukuran - Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($groupedProduk as $id => $group)
                                            <tr>
                                                <td>
                                                    @if ($group[0]->gambar)
                                                        <img src="{{ asset($group[0]->gambar) }}"
                                                            alt="{{ $group[0]->nama }}" class="gambar-produk">
                                                        <p class="text-sm font-weight-bold mb-0">{{ $group[0]->nama }}</p>
                                                    @else
                                                        <p>Tidak ada gambar</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $group[0]->deskripsi }}</p>
                                                </td>
                                                <td>
                                                    @foreach ($group as $item)
                                                        <p class="text-sm font-weight-bold mb-0">
                                                            {{ $item->nama_ukuran }} -
                                                            {{ $item->stok_ukuran }}<br></p>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid py-0">
            <p>Tidak ada produk yang ditemukan.</p>
        </div>
    @endif
@endsection
