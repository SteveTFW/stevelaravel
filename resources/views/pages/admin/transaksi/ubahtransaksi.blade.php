@extends('layouts.admin')

@section('title')
    Ubah Pembelian Bahan Baku
@endsection

@section('page')
    Menu Master / Daftar Pembelian Bahan Baku / Ubah Pembelian Bahan Baku
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

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible text-white" role="alert">
            @foreach ($errors->all() as $error)
                <span>{{ $error }}</span>
            @endforeach
        </div>
    @endif

    <form class="formUbah" action="{{ route('ubah-transaksi', ['id' => $transaksi->id]) }}" method="POST"
        enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">
                @csrf
                @method('PUT')
                <h1 class="mb-4">Ubah Transaksi</h1>
                <h6 class="mb-4">{{ $transaksi->kode_transaksi }}</h6>
                <div class="form-group">
                    <label for="supplier">Supplier:</label>
                    <select id="supplier" name="supplier" required>
                        <option value="" disabled selected>Pilih Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ $transaksi->supplier_id == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="total_harga">Total Harga Pesanan</label>
                    <input type="number" id="total_harga" name="total_harga" placeholder="Masukkan Total Harga Pesanan"
                        value="{{ $transaksi->total_harga }}" pattern="[0-9]*" required>
                </div>

                <div class="form-group">
                    <label for="metode_pembayaran">Metode Pembayaran:</label>
                    <select id="metode_pembayaran" name="metode_pembayaran" required>
                        <option value="" disabled selected>Pilih Metode Pembayaran</option>
                        <option value="Cash" {{ $transaksi->metode_pembayaran == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Kartu Kredit"
                            {{ $transaksi->metode_pembayaran == 'Kartu Kredit' ? 'selected' : '' }}>Kartu Kredit</option>
                        <option value="Transfer" {{ $transaksi->metode_pembayaran == 'Transfer' ? 'selected' : '' }}>
                            Transfer</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cara_pengiriman">Cara Pengiriman:</label>
                    <select id="cara_pengiriman" name="cara_pengiriman" required>
                        <option value="" disabled selected>Pilih Cara Pengiriman</option>
                        <option value="Diambil Sendiri"
                            {{ $transaksi->cara_pengiriman == 'Diambil Sendiri' ? 'selected' : '' }}>Diambil Sendiri
                        </option>
                        <option value="Dikirim Kurir"
                            {{ $transaksi->cara_pengiriman == 'Dikirim Kurir' ? 'selected' : '' }}>Dikirim Kurir</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status Transaksi</label>
                    <select id="status" name="status" required>
                        <option value="menunggu" {{ $transaksi->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="selesai" {{ $transaksi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ $transaksi->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="catatan_tambahan">Catatan Tambahan:</label>
                    <textarea id="catatan_tambahan" name="catatan_tambahan" rows="3">{{ $transaksi->catatan_tambahan }}</textarea>
                </div>

                <div class="form-group mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success" onclick="return konfirmasiUbah()">Ubah</button>
                    <a href="{{ route('list-transaksi') }}" class="btn btn-info">Kembali</a>
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
