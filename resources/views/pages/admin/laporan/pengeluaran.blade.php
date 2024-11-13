@extends('layouts.admin')

@section('title')
    Pengeluaran
@endsection

@section('page')
    Menu Transaksi / Pengeluaran
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
                                @if ($pengeluaran->count() > 0)
                                    <a href="{{ route('generate-pdf-keluar') }}?{{ http_build_query(request()->all()) }}"
                                        class="btn btn-primary mb-0">Cetak
                                        PDF</a>
                                @else
                                    <button class="btn btn-primary mb-0"
                                        onclick="alert('Tidak ada data untuk dicetak');">Cetak PDF</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <form id="filterForm" action="{{ route('view-pengeluaran') }}" method="GET">
                            <div class="row">
                                <div class="col-md-4 mb-md-0 mb-4">
                                    <label for="selectKolom">Filter:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <select id="selectKolom" name="filter" class="form-select">
                                            <option selected disabled>Pilih filter</option>
                                            <option value="kode">Kode Transaksi</option>
                                            <option value="tanggal">Tanggal</option>
                                            <option value="pjawab">Penanggung Jawab</option>
                                            <option value="supplier">Supplier</option>
                                            <option value="status">Status Transaksi</option>
                                            <option value="harga">Total Harga</option>
                                            <option value="cpengiriman">Cara Pengiriman</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8" id="divKolom1">
                                    <label for="kode">Kode Transaksi:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <input type="text" id="kode" name="kode" class="form-control"
                                            placeholder="Masukkan Kode Transaksi">
                                    </div>
                                </div>
                                <div class="col-md-8" id="divKolom2">
                                    <label for="pjawab">Penanggung Jawab:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <input type="text" id="pjawab" name="pjawab" class="form-control"
                                            placeholder="Masukkan Nama Penanggung Jawab">
                                    </div>
                                </div>
                                <div class="col-md-4" id="divKolom3">
                                    <label for="tanggal1">Tanggal Awal:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <input type="date" id="tanggal1" name="tanggal_awal" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4" id="divKolom4">
                                    <label for="tanggal2">Tanggal Akhir:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <input type="date" id="tanggal2" name="tanggal_akhir" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-8" id="divKolom5">
                                    <label for="supplier">Supplier:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <input type="text" id="supplier" name="supplier" class="form-control"
                                            placeholder="Masukkan Nama Supplier">
                                    </div>
                                </div>
                                <div class="col-md-8" id="divKolom6">
                                    <label for="status">Status Transaksi:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <select id="status" name="status" class="form-select">
                                            <option selected disabled>Pilih status transaksi</option>
                                            <option value="Menunggu">Menunggu</option>
                                            <option value="Selesai">Selesai</option>
                                            <option value="Dibatalkan">Dibatalkan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="divKolom7">
                                    <label for="jenisjumlah">Variabel Pengeluaran:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <select id="jenisjumlah" name="jenis_jumlah" class="form-select">
                                            <option selected disabled>Pilih variabel</option>
                                            <option value="kurang_dari">Kurang Dari</option>
                                            <option value="lebih_dari">Lebih Dari</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="divKolom8">
                                    <label for="jumlah">Jumlah Pengeluaran:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <input type="number" id="jumlah" name="jumlah" class="form-control"
                                            placeholder="Masukkan Jumlah">
                                    </div>
                                </div>
                                <div class="col-md-8" id="divKolom9">
                                    <label for="cpengiriman">Cara Pengiriman:</label>
                                    <div
                                        class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <select id="cpengiriman" name="cara_pengiriman" class="form-select">
                                            <option selected disabled>Pilih cara pengiriman</option>
                                            <option value="Diambil Sendiri">Diambil Sendiri</option>
                                            <option value="Dikirim Kurir">Dikirim Kurir</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if ($pengeluaran->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card my-6">
                        <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-0">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h5 class="text-white text-capitalize ps-3">Laporan Pengeluaran</h5>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 text-center" style="min-height:500px; max-height:500px">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Kode Transaksi</th>
                                            <th>Tanggal</th>
                                            <th>Penanggung Jawab</th>
                                            <th>Nama Supplier</th>
                                            <th>Status</th>
                                            <th>Cara Pengiriman</th>
                                            <th>Total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengeluaran as $item)
                                            <tr>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->kode_transaksi }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">
                                                        {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d M Y') }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->nama_user }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->nama_supplier }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->status }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->cara_pengiriman }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">Rp
                                                        {{ number_format($item->total_harga, 0, ',', '.') }}</p>
                                                </td>
                                                <td><a href="{{ route('detail-transaksi', ['id' => $item->id]) }}"
                                                        class="btn btn-info mt-4"><i
                                                            class="fa fa-info-circle fa-lg"></i></a></td>
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
                <p>Tidak ada data pengeluaran yang terdeteksi berdasarkan filter yang ditentukan.</p>
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
            const divKolom8 = document.getElementById('divKolom8');
            const divKolom9 = document.getElementById('divKolom9');

            const kodeInput = document.getElementById('kode');
            const pjawabInput = document.getElementById('pjawab');
            const tanggalAwalInput = document.getElementById('tanggal1');
            const tanggalAkhirInput = document.getElementById('tanggal2');
            const supplierInput = document.getElementById('supplier');
            const statusInput = document.getElementById('status');
            const jenisJumlahInput = document.getElementById('jenisjumlah');
            const jumlahInput = document.getElementById('jumlah');
            const cpengirimanInput = document.getElementById('cpengiriman');

            // Menyembunyikan semua input pada awalnya
            function hideAllInputs() {
                divKolom1.style.display = 'none';
                divKolom2.style.display = 'none';
                divKolom3.style.display = 'none';
                divKolom4.style.display = 'none';
                divKolom5.style.display = 'none';
                divKolom6.style.display = 'none';
                divKolom7.style.display = 'none';
                divKolom8.style.display = 'none';
                divKolom9.style.display = 'none';

                kodeInput.required = false;
                pjawabInput.required = false;
                tanggalAwalInput.required = false;
                tanggalAkhirInput.required = false;
                supplierInput.required = false;
                statusInput.required = false;
                jenisJumlahInput.required = false;
                jumlahInput.required = false;
                cpengirimanInput.required = false;
            }

            function clearAllInputs() {
                kodeInput.value = '';
                pjawabInput.value = '';
                tanggalAwalInput.value = '';
                tanggalAkhirInput.value = '';
                supplierInput.value = '';
                statusInput.value = '';
                jenisJumlahInput.value = '';
                jumlahInput.value = '';
                cpengirimanInput.value = '';
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
                } else if (selectKolom.value === 'pjawab') {
                    divKolom2.style.display = 'block';
                    pjawabInput.required = true;
                } else if (selectKolom.value === 'tanggal') {
                    divKolom3.style.display = 'block';
                    divKolom4.style.display = 'block';
                    tanggalAwalInput.required = true;
                    tanggalAkhirInput.required = true;
                } else if (selectKolom.value === 'supplier') {
                    divKolom5.style.display = 'block';
                    supplierInput.required = true;
                } else if (selectKolom.value === 'status') {
                    divKolom6.style.display = 'block';
                    statusInput.required = true;
                } else if (selectKolom.value === 'harga') {
                    divKolom7.style.display = 'block';
                    divKolom8.style.display = 'block';
                    jenisJumlahInput.required = true;
                    jumlahInput.required = true;
                } else if (selectKolom.value === 'cpengiriman') {
                    divKolom9.style.display = 'block';
                    cpengirimanInput.required = true;
                }
            });
        });
    </script>
@endpush
