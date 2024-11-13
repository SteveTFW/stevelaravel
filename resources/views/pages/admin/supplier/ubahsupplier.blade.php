@extends('layouts.admin')

@section('title')
    Ubah Supplier
@endsection

@section('page')
    Menu Master / Daftar Supplier / Ubah Supplier
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

    <form class="formUbah" action="{{ route('ubah-supplier', ['id' => $supplier->id]) }}" method="POST"
        enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">
                @csrf
                @method('PUT')
                <h1 class="mb-4">Ubah Supplier</h1>

                <!-- Nama Supplier -->
                <div class="form-group">
                    <label for="nama">Nama Supplier</label>
                    <input type="text" id="nama" name="nama" value="{{ $supplier->nama }}"
                        placeholder="Masukkan Nama Supplier" required>
                </div>

                <!-- Alamat Supplier -->
                <div class="form-group">
                    <label for="alamat">Alamat Supplier</label>
                    <textarea id="alamat" name="alamat" placeholder="Masukkan Alamat Supplier" rows="4"
                        required>{{ $supplier->alamat }}</textarea>
                </div>

                <!-- Nomor Telepon Supplier -->
                <div class="form-group">
                    <label for="nomor_telepon">Nomor Telepon</label>
                    <input type="text" id="nomor_telepon" name="nomor_telepon"
                        value="{{ $supplier->nomor_telepon }}" placeholder="Masukkan Nomor Telepon Supplier"
                        pattern="^[0-9\s\+\(\)\-]+$" title="Format yang valid: 1234, +1234, (1234), (123) 456-7890"
                        required>
                </div>

                <!-- Email Supplier -->
                <div class="form-group">
                    <label for="deskripsi">Email Supplier</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $supplier->email }}"
                        placeholder="Masukkan Email Supplier" required>
                </div>

                <!-- Tombol Simpan -->
                <div class="form-group mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success" onclick="return konfirmasiUbah()">Ubah</button>

                    <a href="{{ route('list-supplier') }}" class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('add-script')
    <script>
        function konfirmasiUbah() {
            return confirm('Apakah Anda yakin ingin mengubah supplier ini?');
        }
    </script>
@endpush
