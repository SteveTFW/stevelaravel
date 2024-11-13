@extends('layouts.admin')

@section('title')
    Ubah Bahan Baku
@endsection

@section('page')
    Menu Master / Daftar Bahan Baku / Ubah Bahan Baku
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

    <form class="formUbah" action="{{ route('ubah-bahanbaku', ['id' => $bahanbaku->id]) }}" method="POST"
        enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">
                @csrf
                @method('PUT')
                <h1 class="mb-4">Ubah Bahan Baku</h1>

                <!-- Nama Bahan Baku -->
                <div class="form-group">
                    <label for="nama">Nama Bahan Baku</label>
                    <input type="text" id="nama" name="nama" value="{{ $bahanbaku->nama }}"
                        placeholder="Masukkan Nama Bahan Baku" required>
                </div>

                <!-- Jenis Satuan Bahan Baku -->
                <div class="form-group">
                    <label for="jenis_satuan">Jenis Satuan Bahan Baku</label>
                    <select id="jenis_satuan" name="jenis_satuan" required>
                        <option value="" disabled selected>Silahkan pilih jenis satuan</option>
                        @foreach (['Unit', 'Kilogram (kg)', 'Gram (g)', 'Liter (L)', 'Mililiter (mL)', 'Meter (m)', 'Sentimeter (cm)', 'Buah (pcs)', 'Gulung (roll)', 'Meter Persegi (m^2)', 'Meter Kubik (m^3)', 'Ton'] as $jenis_satuan)
                            <option value="{{ $jenis_satuan }}"
                                {{ $bahanbaku->jenis_satuan == $jenis_satuan ? 'selected' : '' }}>
                                {{ $jenis_satuan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Simpan -->
                <div class="form-group mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success" onclick="return konfirmasiUbah()">Ubah</button>

                    <a href="{{ route('list-bahanbaku') }}" class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('add-script')
    <script>
        function konfirmasiUbah() {
            return confirm('Apakah Anda yakin ingin mengubah bahanbaku ini?');
        }
    </script>
@endpush
