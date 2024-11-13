@extends('layouts.admin')

@section('title')
    Ubah Ukuran Produk
@endsection

@section('page')
    Menu Master / Daftar Produk / Ukuran Produk / Ubah Ukuran Produk
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

    <form class="formUbah" action="{{ route('update-ukuran-produk', $ukuranProduk->id) }}" method="POST"
        enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">
                @csrf
                @method('PUT')
                <h1 class="mb-4">Ubah Ukuran Produk</h1>
                <h6 class="mb-4">{{ $namaProduk }}</h6>
                <div class="form-group">
                    <label for="ukuran">Ukuran Produk</label>
                    <select id="ukuran" name="ukuran" required>
                        <option value="" disabled selected>Pilih Ukuran</option>
                        <option value="XS" {{ $ukuranProduk->ukuran == 'XS' ? 'selected' : '' }}>XS</option>
                        <option value="S" {{ $ukuranProduk->ukuran == 'S' ? 'selected' : '' }}>S</option>
                        <option value="M" {{ $ukuranProduk->ukuran == 'M' ? 'selected' : '' }}>M</option>
                        <option value="L" {{ $ukuranProduk->ukuran == 'L' ? 'selected' : '' }}>L</option>
                        <option value="XL" {{ $ukuranProduk->ukuran == 'XL' ? 'selected' : '' }}>XL</option>
                        <option value="XXL" {{ $ukuranProduk->ukuran == 'XXL' ? 'selected' : '' }}>XXL</option>
                        <option value="3XL" {{ $ukuranProduk->ukuran == '3XL' ? 'selected' : '' }}>3XL</option>
                        <option value="4XL" {{ $ukuranProduk->ukuran == '4XL' ? 'selected' : '' }}>4XL</option>
                        <option value="5XL" {{ $ukuranProduk->ukuran == '5XL' ? 'selected' : '' }}>5XL</option>
                        <option value="All Size" {{ $ukuranProduk->ukuran == 'All Size' ? 'selected' : '' }}>All Size</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="harga">Harga Produk</label>
                    <input type="number" id="harga" name="harga" value="{{ $ukuranProduk->harga }}"
                        placeholder="Masukkan Harga Produk" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi Ukuran Produk</label>
                    <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi Ukuran Produk" rows="4"
                        required>{{ $ukuranProduk->deskripsi }}</textarea>
                </div>

                <!-- Tombol Simpan -->
                <div class="form-group mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success" onclick="return konfirmasiUbah()">Ubah</button>

                    <a href="{{ route('ukuran-produk', $ukuranProduk->produk_id) }}" class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('add-script')
    <script>
        function konfirmasiUbah() {
            return confirm('Apakah Anda yakin ingin mengubah produk ini?');
        }
    </script>
@endpush