@extends('layouts.admin')

@section('title')
    Pemasukkan
@endsection

@section('page')
    Menu Transaksi / Pemasukkan
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


    <div class="container-fluid py-0">
        <div class="row">
            <div class="col-md-12 mb-lg-0 mb-4">
                <div class="card mt-4">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-6 d-flex align-items-center">
                                <h5 class="mb-0">Cari berdasarkan...</h5>
                            </div>
                            <div class="col-6 text-end">
                                <button type="submit" form="filterForm" class="btn bg-gradient-dark mb-0">
                                    <i class="material-icons text-sm">search</i>&nbsp;&nbsp;CARI
                                </button>
                                @if ($pemasukkan->count() > 0)
                                    <a href="{{ route('generate-pdf-masuk') }}?{{ http_build_query(request()->all()) }}"
                                        class="btn btn-primary mb-0">Cetak PDF</a>
                                @else
                                    <button class="btn btn-primary mb-0"
                                        onclick="alert('Tidak ada data untuk dicetak');">Cetak PDF</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <form id="filterForm" action="{{ route('view-pemasukkan') }}" method="GET">
                            <div class="row">
                                <div class="col-md-4 mb-md-0 mb-4">
                                    <label for="selectKolom">Filter:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <select id="selectKolom" name="filter" class="form-select">
                                            <option selected disabled>Pilih filter</option>
                                            <option value="kode">Kode Pesanan</option>
                                            <option value="tanggal">Tanggal</option>
                                            <option value="pelanggan">Pelanggan</option>
                                            <option value="status_pembayaran">Status Pembayaran</option>
                                            <option value="jumlah">Total Jumlah</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8" id="divKolom1">
                                    <label for="kode">Kode Pesanan:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <input type="text" id="kode" name="kode" class="form-control"
                                            placeholder="Masukkan Kode Pesanan">
                                    </div>
                                </div>
                                <div class="col-md-4" id="divKolom2">
                                    <label for="tanggal1">Tanggal Awal:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <input type="date" id="tanggal1" name="tanggal_awal" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4" id="divKolom3">
                                    <label for="tanggal2">Tanggal Akhir:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <input type="date" id="tanggal2" name="tanggal_akhir" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-8" id="divKolom4">
                                    <label for="pelanggan">Pelanggan:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <input type="text" id="pelanggan" name="pelanggan" class="form-control"
                                            placeholder="Masukkan Nama Pelanggan">
                                    </div>
                                </div>
                                <div class="col-md-8" id="divKolom5">
                                    <label for="sbayar">Status Pembayaran:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <select id="sbayar" name="status_pembayaran" class="form-select">
                                            <option selected disabled>Pilih status pembayaran</option>
                                            <option value="Belum Dibayar">Belum Dibayar</option>
                                            <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                                            <option value="Sudah Bayar DP">Sudah Bayar DP</option>
                                            <option value="Menunggu Pelunasan">Menunggu Pelunasan</option>
                                            <option value="Sudah Dibayar">Sudah Dibayar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="divKolom6">
                                    <label for="jenisjumlah">Variabel Pemasukkan:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <select id="jenisjumlah" name="jenis_jumlah" class="form-select">
                                            <option selected disabled>Pilih variabel</option>
                                            <option value="kurang_dari">Kurang Dari</option>
                                            <option value="lebih_dari">Lebih Dari</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="divKolom7">
                                    <label for="jumlah">Jumlah Pemasukkan:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <input type="number" id="jumlah" name="jumlah" class="form-control"
                                            placeholder="Masukkan Jumlah">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if ($pemasukkan->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card my-6">
                        <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-0">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h5 class="text-white text-capitalize ps-3">Laporan Pemasukkan</h5>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 text-center" style="min-height:500px; max-height:500px">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Pesanan</th>
                                            <th>Tanggal</th>
                                            <th>Pelanggan</th>
                                            <th>Status Pembayaran</th>
                                            <th>Total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pemasukkan as $item)
                                            <tr>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->kode }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">
                                                        {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d M Y') }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->nama }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->status_pembayaran }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">Rp
                                                        {{ number_format($item->total_harga, 0, ',', '.') }}</p>
                                                </td>
                                                <td>
                                                    <a href="{{ route('detail-pesanan', ['id' => $item->pesanan_id]) }}"
                                                        class="btn btn-info mt-4">
                                                        <i class="fa fa-info-circle fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <br>
            <div class="container-fluid py-0">
                <p>Tidak ada data pemasukkan yang terdeteksi berdasarkan filter yang ditentukan.</p>
            </div>
        @endif
    </div>

@endsection

@push('add-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mendapatkan elemen select
            const selectKolom = document.getElementById('selectKolom');

            // Mendapatkan elemen div dan input untuk setiap kolom
            const divKolom1 = document.getElementById('divKolom1');
            const divKolom2 = document.getElementById('divKolom2');
            const divKolom3 = document.getElementById('divKolom3');
            const divKolom4 = document.getElementById('divKolom4');
            const divKolom5 = document.getElementById('divKolom5');
            const divKolom6 = document.getElementById('divKolom6');
            const divKolom7 = document.getElementById('divKolom7');

            const kodeInput = document.getElementById('kode');
            const tanggalAwalInput = document.getElementById('tanggal1');
            const tanggalAkhirInput = document.getElementById('tanggal2');
            const pelangganInput = document.getElementById('pelanggan');
            const statusPembayaranInput = document.getElementById('sbayar');
            const jenisJumlahInput = document.getElementById('jenisjumlah');
            const jumlahInput = document.getElementById('jumlah');

            // Menyembunyikan semua input pada awalnya
            function hideAllInputs() {
                divKolom1.style.display = 'none';
                divKolom2.style.display = 'none';
                divKolom3.style.display = 'none';
                divKolom4.style.display = 'none';
                divKolom5.style.display = 'none';
                divKolom6.style.display = 'none';
                divKolom7.style.display = 'none';

                kodeInput.required = false;
                tanggalAwalInput.required = false;
                tanggalAkhirInput.required = false;
                pelangganInput.required = false;
                statusPembayaranInput.required = false;
                jenisJumlahInput.required = false;
                jumlahInput.required = false;
            }

            function clearAllInputs() {
                kodeInput.value = '';
                tanggalAwalInput.value = '';
                tanggalAkhirInput.value = '';
                pelangganInput.value = '';
                statusPembayaranInput.value = '';
                jenisJumlahInput.value = '';
                jumlahInput.value = '';
            }

            hideAllInputs();
            clearAllInputs();

            // Menetapkan event listener untuk perubahan pada select
            selectKolom.addEventListener('change', function() {
                // Menyembunyikan semua input terlebih dahulu
                hideAllInputs();
                clearAllInputs();

                // Memeriksa nilai yang dipilih pada select
                if (selectKolom.value === 'kode') {
                    divKolom1.style.display = 'block';
                    kodeInput.required = true;
                } else if (selectKolom.value === 'tanggal') {
                    divKolom2.style.display = 'block';
                    divKolom3.style.display = 'block';
                    tanggalAwalInput.required = true;
                    tanggalAkhirInput.required = true;
                } else if (selectKolom.value === 'pelanggan') {
                    divKolom4.style.display = 'block';
                    pelangganInput.required = true;
                } else if (selectKolom.value === 'status_pembayaran') {
                    divKolom5.style.display = 'block';
                    statusPembayaranInput.required = true;
                } else if (selectKolom.value === 'jumlah') {
                    divKolom6.style.display = 'block';
                    divKolom7.style.display = 'block';
                    jenisJumlahInput.required = true;
                    jumlahInput.required = true;
                }
            });
        });
    </script>
@endpush
