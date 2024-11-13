@extends('layouts.admin')

@section('title')
    Ubah Bahan Baku Produk
@endsection

@section('page')
    Menu Master / Daftar Produk / Bahan Baku Produk / Ubah Bahan Baku Produk
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

    <form class="formUbah"
        action="{{ route('update-bahanbaku-produk', ['produk_id' => $bahanbakuProduk->produk_id, 'bahan_baku_id' => $bahanbakuProduk->bahan_baku_id]) }}"
        method="POST" enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">
                @csrf
                @method('PUT')
                <h1 class="mb-4">Ubah Bahan Baku Produk</h1>
                <h6 class="mb-4">{{ $namaProduk }}</h6>

                <input type="hidden" id="produk_id" name="produk_id" value="{{ $bahanbakuProduk->produk_id }}">
                <input type="hidden" id="bahan_baku" name="bahan_baku" value="{{ $bahanbakuProduk->bahan_baku_id }}">

                <div class="form-group">
                    <label for="bahan_baku">Bahan Baku</label>
                    <select id="bahan_baku" name="bahan_baku" required disabled>
                        <option value="" disabled selected>Pilih Bahan Baku</option>
                        @foreach ($bahanbakuOptions as $bahanbaku)
                            <option value="{{ $bahanbaku->id }}"
                                {{ $bahanbakuProduk->bahan_baku_id == $bahanbaku->id ? 'selected' : '' }}>
                                {{ $bahanbaku->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah Bahan Baku</label>
                    <input type="number" id="jumlah" name="jumlah" value="{{ $bahanbakuProduk->jumlah }}"
                        placeholder="Masukkan Jumlah Bahan Baku untuk Produk" required step="any">
                </div>
                <div class="form-group mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success" onclick="return konfirmasiUbah()">Ubah</button>
                    <a href="{{ route('bahan-baku-produk', $bahanbakuProduk->produk_id) }}" class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('add-script')
    <script>
        function konfirmasiUbah() {
            return confirm('Apakah Anda yakin ingin mengubah data ini?');
        }
    </script>
@endpush
