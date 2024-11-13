@extends('layouts.admin')

@section('title')
    Ubah Peran
@endsection

@section('page')
    Menu Master / Daftar Peran / Ubah Peran
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

    <form class="formUbah" action="{{ route('ubah-peran', ['id' => $peran->id]) }}" method="POST"
        enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">
                @csrf
                @method('PUT')
                <h1 class="mb-4">Ubah Peran</h1>

                <!-- Nama Peran -->
                <div class="form-group">
                    <label for="nama">Nama Peran</label>
                    <input type="text" id="nama" name="nama" value="{{ $peran->nama }}"
                        placeholder="Masukkan Nama Peran" required>
                </div>

                <!-- Deskripsi Peran -->
                <div class="form-group">
                    <label for="deskripsi">Deskripsi Peran</label>
                    <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi Peran" rows="4"
                        required>{{ $peran->deskripsi }}</textarea>
                </div>

                <!-- Kode Peran -->
                <div class="form-group">
                    <label for="kode">Kode Peran (Maksimal 4 Karakter)</label>
                    <input type="text" id="kode" name="kode" value="{{ $peran->kode }}"
                        placeholder="Masukkan Kode Peran" required>
                </div>

                <!-- Tombol Simpan -->
                <div class="form-group mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success" onclick="return konfirmasiUbah()">Ubah</button>

                    <a href="{{ route('list-peran') }}" class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('add-script')
    <script>
        function konfirmasiUbah() {
            return confirm('Apakah Anda yakin ingin mengubah peran ini?');
        }
    </script>
@endpush
