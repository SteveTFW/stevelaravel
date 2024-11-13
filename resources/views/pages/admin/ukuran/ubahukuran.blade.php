@extends('layouts.admin')

@section('title')
    Ubah Ukuran
@endsection

@section('page')
    Menu Master / Daftar Ukuran / Ubah Ukuran
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

    <form class="formUbah" action="{{ route('ubah-ukuran', ['id' => $ukuran->id]) }}" method="POST"
        enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">
                @csrf
                @method('PUT')
                <h1 class="mb-4">Ubah Ukuran</h1>

                <!-- Nama Ukuran -->
                <div class="form-group">
                    <label for="nama">Nama Ukuran</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $ukuran->nama }}"
                        placeholder="Masukkan Nama Ukuran" required>
                </div>

                <!-- Tombol Simpan -->
                <div class="form-group mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success" onclick="return konfirmasiUbah()">Ubah</button>

                    <a href="{{ route('list-ukuran') }}" class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('add-script')
    <script>
        function konfirmasiUbah() {
            return confirm('Apakah Anda yakin ingin mengubah ukuran ini?');
        }
    </script>
@endpush
