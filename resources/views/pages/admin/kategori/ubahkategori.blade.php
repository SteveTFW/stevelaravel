@extends('layouts.admin')

@section('title')
    Ubah Kategori
@endsection

@section('page')
    Menu Master / Daftar Kategori / Ubah Kategori
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

    <form class="formUbah" action="{{ route('ubah-kategori', ['id' => $kategori->id]) }}" method="POST"
        enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">
                @csrf
                @method('PUT')
                <h1 class="mb-4">Ubah Kategori</h1>

                <!-- Nama Kategori -->
                <div class="form-group">
                    <label for="nama">Nama Kategori</label>
                    <input type="text" id="nama" name="nama" value="{{ $kategori->nama }}"
                        placeholder="Masukkan Nama Kategori" required>
                </div>

                <!-- Deskripsi Kategori -->
                <div class="form-group">
                    <label for="deskripsi">Deskripsi Kategori</label>
                    <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi Kategori" rows="4"
                        required>{{ $kategori->deskripsi }}</textarea>
                </div>

                <!-- Tombol Simpan -->
                <div class="form-group mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success" onclick="return konfirmasiUbah()">Ubah</button>

                    <a href="{{ route('list-kategori') }}" class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('add-script')
    <script>
        function konfirmasiUbah() {
            return confirm('Apakah Anda yakin ingin mengubah kategori ini?');
        }
    </script>
@endpush
