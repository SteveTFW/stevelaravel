@extends('layouts.admin')

@section('title')
    Ubah Pesanan
@endsection

@section('page')
    Menu Pembelanjaan / Daftar Pesanan / Ubah Pesanan
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

    <form class="formUbah" action="{{ route('ubah-pesanan', ['id' => $pesanan->id]) }}" method="POST"
        enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">
                @csrf
                @method('PUT')
                <h1 class="mb-4">Ubah Pesanan</h1>
                <h6 class="mb-4">{{ $pesanan->kode }}</h6>
                <!-- Alamat Pesanan -->
                <div class="form-group">
                    <label for="alamat">Alamat Pesanan</label>
                    <textarea id="alamat" name="alamat" placeholder="Masukkan Alamat Pesanan" rows="4" required>{{ $pesanan->alamat_pengiriman }}</textarea>
                </div>

                <div class="form-group">
                    <label for="metode_pembayaran">Metode Pembayaran</label>
                    <select id="metode_pembayaran" name="metode_pembayaran" required>
                        <option value="cod" {{ $pesanan->metode_pembayaran == 'COD' ? 'selected' : '' }}>COD</option>
                        <option value="transfer" {{ $pesanan->metode_pembayaran == 'Transfer' ? 'selected' : '' }}>Transfer
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="total_harga">Total Harga Pesanan</label>
                    <input type="number" id="total_harga" name="total_harga" placeholder="Masukkan Total Harga Pesanan"
                        value="{{ $pesanan->total_harga }}" pattern="[0-9]*" required>
                </div>

                <div class="form-group">
                    <label for="status_pembayaran">Status Pembayaran</label>
                    <select id="status_pembayaran" name="status_pembayaran" required>

                        <option value="belum dibayar"
                            {{ $pesanan->status_pembayaran == 'Belum Dibayar' ? 'selected' : '' }}>Belum Dibayar
                        </option>
                        <option value="menunggu pembayaran"
                            {{ $pesanan->status_pembayaran == 'Menunggu Pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran
                        </option>
                        <option value="sudah bayar dp"
                            {{ $pesanan->status_pembayaran == 'Sudah Bayar DP' ? 'selected' : '' }}>Sudah Bayar DP
                        </option>
                        <option value="menunggu pelunasan"
                            {{ $pesanan->status_pembayaran == 'Menunggu Pelunasan' ? 'selected' : '' }}>Menunggu Pelunasan
                        </option>
                        <option value="sudah dibayar"
                            {{ $pesanan->status_pembayaran == 'Sudah Dibayar' ? 'selected' : '' }}>Sudah Dibayar
                        </option>
                        <option value="kadaluarsa" {{ $pesanan->status_pembayaran == 'Kadaluarsa' ? 'selected' : '' }}>
                            Kadaluarsa
                        </option>
                        <option value="batal" {{ $pesanan->status_pembayaran == 'Batal' ? 'selected' : '' }}>Batal
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status Pesanan</label>
                    <select id="status" name="status" required>
                        <option value="menunggu konfirmasi"
                            {{ $pesanan->status == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="dikonfirmasi" {{ $pesanan->status == 'Dikonfirmasi' ? 'selected' : '' }}>
                            Dikonfirmasi</option>
                        <option value="menunggu" {{ $pesanan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="sedang produksi" {{ $pesanan->status == 'Sedang Produksi' ? 'selected' : '' }}>
                            Sedang Produksi</option>
                        <option value="selesai produksi" {{ $pesanan->status == 'Selesai Produksi' ? 'selected' : '' }}>
                            Selesai Produksi</option>
                        <option value="pengiriman" {{ $pesanan->status == 'Pengiriman' ? 'selected' : '' }}>Pengiriman
                        </option>
                        <option value="selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ $pesanan->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan
                        </option>
                        <option value="ditolak" {{ $pesanan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>

                    </select>
                </div>

                <div class="form-group">
                    <label for="catatan">Catatan Tambahan</label>
                    <textarea id="catatan" name="catatan" placeholder="Masukkan Catatan Tambahan" rows="4">{{ $pesanan->catatan_tambahan }}</textarea>
                </div>

                <!-- Tombol Simpan -->
                <div class="form-group mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success" onclick="return konfirmasiUbah()">Ubah</button>

                    <a href="{{ route('list-pesanan') }}" class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('add-script')
    <script>
        function konfirmasiUbah() {
            return confirm('Apakah Anda yakin ingin mengubah pesanan ini?');
        }
    </script>
@endpush
