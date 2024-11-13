@extends('layouts.admin')

@section('title')
    Ubah Produk
@endsection

@section('page')
    Menu Master / Daftar Produk / Ubah Produk
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

    <form class="formUbah" action="{{ route('ubah-produk', ['id' => $produk->id]) }}" method="POST"
        enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">
                @csrf
                @method('PUT')
                <h1 class="mb-4">Ubah Produk</h1>

                <!-- Nama Produk -->
                <div class="form-group">
                    <label for="nama">Nama Produk</label>
                    <input type="text" id="nama" name="nama" value="{{ $produk->nama }}"
                        placeholder="Masukkan Nama Produk" required>
                </div>

                <!-- Gambar Produk -->
                <div class="form-group">
                    <label for="gambar">Gambar Produk</label><br>
                    <input type="file" id="gambar" name="gambar" accept="image/*"><br>
                    <img src="{{ asset($produk->gambar) }}" alt="Current Image" width="100">
                </div>

                <!-- Deskripsi Produk -->
                <div class="form-group">
                    <label for="deskripsi">Deskripsi Produk</label>
                    <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi Produk" rows="4"
                        required>{{ $produk->deskripsi }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status Produk</label>
                    <select id="status" name="status" required>
                        <option value="tersedia" {{ $produk->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak tersedia" {{ $produk->status == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak
                            Tersedia</option>
                    </select>
                </div>

                <!-- Kategori Produk -->
                <div class="form-group">
                    <label for="kategori">Kategori Produk</label>
                    <select  id="kategori" name="kategori" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach ($kategoriOptions as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ $produk->kategori_id == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Simpan -->
                <div class="form-group mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success" onclick="return konfirmasiUbah()">Ubah</button>

                    <a href="{{ route('list-produk') }}" class="btn btn-info">Kembali</a>
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
