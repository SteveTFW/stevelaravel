@extends('layouts.admin')

@section('title')
    Detail Pesanan
@endsection

@section('page')
    Menu Pembelanjaan / Daftar Pesanan / Detail Pesanan
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

    <div class="title-container">
        <a href="javascript:void(0);" onclick="history.back();" class="btn btn-info">
            <i class="fa fa-arrow-left fa-lg"></i> <!-- Ikon Font Awesome -->
        </a>
    </div>

    @if ($groupedPesananProduk->count() > 0)
        <div class="row mb-4">
            <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Kode Pesanan {{ $pesanan->first()->kode }}</h6>
                                <p class="text-sm mb-0">
                                    @if ($pesanan->first()->status == 'Selesai')
                                        <i class="fa fa-check text-success" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Status:</span> {{ $pesanan->first()->status }}
                                    @elseif (
                                        $pesanan->first()->status == 'Menunggu Konfirmasi' ||
                                            $pesanan->first()->status == 'Dikonfirmasi' ||
                                            $pesanan->first()->status == 'Menunggu' ||
                                            $pesanan->first()->status == 'Pengiriman' ||
                                            $pesanan->first()->status == 'Selesai Produksi' ||
                                            $pesanan->first()->status == 'Sedang Produksi')
                                        <i class="fa fa-clock-o text-info" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Status:</span> {{ $pesanan->first()->status }}
                                    @else
                                        <i class="fa fa-times-circle text-danger" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Status:</span> {{ $pesanan->first()->status }}
                                    @endif
                                </p>
                                <p class="text-sm mb-0">
                                    @if ($pesanan->first()->status_pembayaran == 'Sudah Dibayar')
                                        <i class="fa fa-check text-success" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Pembayaran:</span> Lunas
                                    @elseif ($pesanan->first()->status_pembayaran == 'Sudah Bayar DP')
                                        <i class="fa fa-check text-success" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Pembayaran:</span> DP Lunas
                                    @elseif ($pesanan->first()->status_pembayaran == 'Belum Dibayar')
                                        <i class="fa fa-clock-o text-info" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Pembayaran:</span> Belum Dibayar
                                    @elseif ($pesanan->first()->status_pembayaran == 'Menunggu Pembayaran')
                                        <i class="fa fa-clock-o text-info" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Pembayaran:</span> Menunggu Pembayaran DP
                                    @elseif ($pesanan->first()->status_pembayaran == 'Menunggu Pelunasan')
                                        <i class="fa fa-clock-o text-info" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Pembayaran:</span> Menunggu Pelunasan
                                    @elseif ($pesanan->first()->status_pembayaran == 'Kadaluarsa')
                                        <i class="fa fa-times-circle text-danger" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Pembayaran:</span> Kadaluarsa
                                    @else
                                        <i class="fa fa-times-circle text-danger" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Pembayaran:</span> Batal
                                    @endif
                                </p>
                            </div>
                            @if (
                                $pesanan->first()->status == 'Menunggu Konfirmasi' ||
                                    $pesanan->first()->status == 'Dikonfirmasi' ||
                                    $pesanan->first()->status == 'Menunggu' ||
                                    $pesanan->first()->status == 'Sedang Produksi')
                                <div class="col-lg-6 col-5 d-flex justify-content-end align-items-center">
                                    <button class="btn btn-info" id="cekBahanBakuButton">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Barang</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Kuantitas</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Harga per Satuan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalHargaKeseluruhan = 0;
                                    @endphp
                                    {{-- @foreach ($pesananproduk as $item) --}}
                                    @foreach ($groupedPesananProduk as $pesananId => $pesananGroup)
                                        @foreach ($pesananGroup as $produkUkuranId => $group)
                                            <tr
                                                title="Bahan Baku untuk {{ $group[0]->jumlah }}x {{ $group[0]->nama_produk }} ({{ $group[0]->ukuran_produk }}):
                                            @foreach ($group as $item)
                                            {{ $item->nama_bahan_baku }} {{ $item->jumlah_bahan_baku }} {{ $item->jenis_satuan }} @endforeach">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="{{ asset($group[0]->gambar_produk) }}"
                                                                style="width: 50px; margin-right: 10px;">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $group[0]->nama_produk }}
                                                                ({{ $group[0]->ukuran_produk }})
                                                            </h6>
                                                            @if (!empty($group[0]->catatan))
                                                                <h6 class="mb-0 text-sm" style="font-weight: normal;">Note:
                                                                    {{ $group[0]->catatan }}</h6>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-xs font-weight-bold">{{ $group[0]->jumlah }}</span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-xs font-weight-bold">Rp.
                                                        {{ number_format($group[0]->harga_produk, 0, ',', '.') }}</span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-xs font-weight-bold">Rp.
                                                        {{ number_format($group[0]->jumlah * $group[0]->harga_produk, 0, ',', '.') }}</span>
                                                </td>
                                                @php
                                                    $totalHargaKeseluruhan += $group[0]->jumlah * $group[0]->harga;
                                                @endphp
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    @if ($pesanan->first()->status == 'Menunggu Konfirmasi')
                                        <tr>
                                            @if (session('kode_peran_admin') == 'ADMN' || session('kode_peran_admin') == 'KBLJ')
                                                <td colspan="4" class="text-center">
                                                    <br>
                                                    <h6>Konfirmasi Pesanan?</h6>
                                                    <form
                                                        action="{{ route('ubah-status-pesanan', ['id' => $pesanan->first()->id_pesanan]) }}"
                                                        method="post" class="d-inline-block">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Dikonfirmasi">
                                                        <!-- Sesuaikan dengan nilai status yang diinginkan -->
                                                        <button type="submit" class="btn btn-success me-2"
                                                            onclick="return konfirmasiTerima()">Terima</button>
                                                    </form>

                                                    <form
                                                        action="{{ route('ubah-status-pesanan', ['id' => $pesanan->first()->id_pesanan]) }}"
                                                        method="post" class="d-inline-block">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Ditolak">
                                                        <!-- Sesuaikan dengan nilai status yang diinginkan -->
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return konfirmasiTolak()">Tolak</button>
                                                    </form>
                                                </td>
                                            @else
                                                <td colspan="4" class="text-center">
                                                    <br>
                                                    <h6 class="text-info">Hanya karyawan pembelanjaan yang memiliki
                                                        akses
                                                        untuk
                                                        menerima / menolak pesanan!</h6>
                                                </td>
                                            @endif
                                        </tr>
                                    @elseif ($pesanan->first()->status == 'Dikonfirmasi')
                                        @if ($pesanan->first()->status_pembayaran == 'Menunggu Pembayaran')
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    <br>
                                                    <h6 class="text-info">Menunggu pembayaran DP dari pelanggan...</h6>
                                                </td>
                                            </tr>
                                        @endif
                                    @elseif ($pesanan->first()->status == 'Menunggu')
                                        <tr>
                                            @if (session('kode_peran_admin') == 'ADMN' || session('kode_peran_admin') == 'KPRD')
                                                <td colspan="4" class="text-center">
                                                    <br>
                                                    <h6 class="text-info">Mulai produksi sekarang?</h6>
                                                    <button type="submit" class="btn btn-info"
                                                        onclick="showForm()">Produksi</button>
                                                </td>
                                            @else
                                                <td colspan="4" class="text-center">
                                                    <br>
                                                    <h6 class="text-info">Hanya karyawan produksi yang memiliki akses
                                                        untuk
                                                        memulai produksi!</h6>
                                                </td>
                                            @endif
                                        </tr>
                                    @elseif ($pesanan->first()->status == 'Selesai Produksi')
                                        @if (session('kode_peran_admin') == 'ADMN' || session('kode_peran_admin') == 'KBLJ')
                                            @if ($pesanan->first()->status_pembayaran == 'Sudah Bayar DP')
                                                <tr>
                                                    @if ($pesanan->first()->metode_pembayaran == 'Transfer')
                                                        <form
                                                            action="{{ route('minta-lunas-pesanan', ['id' => $pesanan->first()->id_pesanan]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <td colspan="4" class="text-center">
                                                                <br>
                                                                <h6 class="text-info">Ajukan pelunasan pembayaran
                                                                    pesanan?
                                                                </h6>
                                                                <button type="submit" class="btn btn-info"
                                                                    onclick="return konfirmasiLunas()">Aju
                                                                    Pelunasan</button>
                                                            </td>
                                                        </form>
                                                    @elseif ($pesanan->first()->metode_pembayaran == 'COD')
                                                        <form
                                                            action="{{ route('minta-kirim-pesanan', ['id' => $pesanan->first()->id_pesanan]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <td colspan="4" class="text-center">
                                                                <br>
                                                                <h6 class="text-info">Pelunasan pesanan akan dilakukan
                                                                    dengan
                                                                    metode pembayaran COD. Kirim pesanan
                                                                    sekarang?</h6>
                                                                <button type="submit" class="btn btn-info"
                                                                    onclick="return konfirmasiKirim()">Kirim
                                                                    Sekarang</button>
                                                            </td>
                                                        </form>
                                                    @endif
                                                </tr>
                                            @elseif ($pesanan->first()->status_pembayaran == 'Menunggu Pelunasan')
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <br>
                                                        <h6 class="text-info">Menunggu pelunasan...</h6>
                                                    </td>
                                                </tr>
                                            @elseif ($pesanan->first()->status_pembayaran == 'Sudah Dibayar')
                                                <tr>
                                                    <form
                                                        action="{{ route('minta-kirim-pesanan', ['id' => $pesanan->first()->id_pesanan]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <td colspan="4" class="text-center">
                                                            <br>
                                                            <h6 class="text-info">Pembayaran pesanan telah lunas. Kirim
                                                                pesanan
                                                                sekarang?</h6>
                                                            <button type="submit" class="btn btn-info"
                                                                onclick="return konfirmasiKirim()">Kirim
                                                                Sekarang</button>
                                                        </td>
                                                    </form>
                                                </tr>
                                            @endif
                                        @else
                                            <td colspan="4" class="text-center">
                                                <br>
                                                <h6 class="text-info">Hanya karyawan pembelanjaan yang memiliki akses
                                                    untuk
                                                    meminta pelunasan / pengiriman pesanan!</h6>
                                            </td>
                                        @endif
                                    @elseif ($pesanan->first()->status == 'Sedang Produksi')
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <br>
                                                <h6 class="text">Barang sedang dalam proses produksi!<br>Cek disini
                                                    untuk
                                                    melihat progressnya!</h6>
                                                <a href="{{ route('detail-produksi', ['id' => $pesanan->first()->id_pesanan]) }}"
                                                    class="btn btn-info mt-4">
                                                    Cek
                                                </a>
                                            </td>
                                        </tr>
                                    @elseif ($pesanan->first()->status == 'Pengiriman')
                                        @if (session('kode_peran_admin') == 'ADMN' || session('kode_peran_admin') == 'KBLJ')
                                            <tr>
                                                <form
                                                    action="{{ route('minta-selesai-pesanan', ['id' => $pesanan->first()->id_pesanan]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <td colspan="4" class="text-center">
                                                        <br>
                                                        <h6 class="text-info">Sedang dalam pengiriman...</h6>
                                                        <button type="submit" class="btn btn-success"
                                                            onclick="return konfirmasiSelesai()">Selesai Kirim</button>
                                                    </td>
                                                </form>
                                            </tr>
                                        @else
                                            <td colspan="4" class="text-center">
                                                <br>
                                                <h6 class="text-info">Hanya karyawan pembelanjaan yang memiliki akses
                                                    untuk
                                                    menyelesaikan pengiriman pesanan!</h6>
                                            </td>
                                        @endif
                                    @elseif ($pesanan->first()->status == 'Selesai')
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <br>
                                                <h6 class="text-success">Pesanan telah selesai!</h6>
                                            </td>
                                        </tr>
                                    @elseif ($pesanan->first()->status == 'Ditolak')
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <br>
                                                <h6 class="text-danger">Pesanan ditolak!</h6>
                                            </td>
                                        </tr>
                                    @elseif ($pesanan->first()->status == 'Dibatalkan')
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <br>
                                                <h6 class="text-danger">Pesanan dibatalkan pelanggan!</h6>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6>Detail Pesanan</h6><br>
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Dipesan oleh:</span> {{ $pesanan->first()->nama }}
                        </p>
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Nomor Telp.:</span> {{ $pesanan->first()->nomor_telepon }}
                        </p>
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Tanggal pemesanan:</span>
                            {{ \Carbon\Carbon::parse($pesanan->first()->tanggal)->locale('id')->translatedFormat('l, d M Y') }}
                        </p>
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Dikirim ke:</span> {{ $pesanan->first()->alamat_pengiriman }}
                        </p>
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Metode Pembayaran:</span>
                            {{ $pesanan->first()->metode_pembayaran }}
                        </p>
                        <p class="text-sm">
                            <span class="font-weight-bold">Estimasi Pesanan Selesai:</span>
                            {{ \Carbon\Carbon::parse($pesanan->first()->tgl_estimasi)->locale('id')->translatedFormat('l, d M Y') }}
                        </p>
                        <p class="text-sm">
                            <span class="font-weight-bold">Tgl. Pembayaran DP:</span>
                            @if ($pesanan->first()->tgl_dp)
                                {{ \Carbon\Carbon::parse($pesanan->first()->tgl_dp)->locale('id')->translatedFormat('l, d M Y') }}
                            @else
                                Pembayaran DP belum dibayar
                            @endif
                        </p>
                        @if ($pesanan->first()->metode_pembayaran == 'Transfer')
                            <p class="text-sm">
                                {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                                <span class="font-weight-bold">Tgl. Pelunasan:</span>
                                @if ($pesanan->first()->tgl_lunas)
                                    {{ \Carbon\Carbon::parse($pesanan->first()->tgl_lunas)->locale('id')->translatedFormat('l, d M Y') }}
                                @else
                                    Pelunasan belum dilakukan
                                @endif
                            </p>
                        @endif
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Tgl. Pesanan Selesai:</span>
                            @if ($pesanan->first()->tgl_selesai)
                                {{ \Carbon\Carbon::parse($pesanan->first()->tgl_selesai)->locale('id')->translatedFormat('l, d M Y') }}
                            @else
                                Pesanan masih berjalan
                            @endif
                        </p>
                        <br>
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Grand Total:</span>
                        </p>
                        <h3>Rp. {{ number_format($totalHargaKeseluruhan, 0, ',', '.') }}</h3>
                    </div>
                    <div class="card-body p-3">
                        {{-- <div class="timeline timeline-one-side">
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <i class="material-icons text-success text-gradient">notifications</i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">$2400, Design changes</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 PM</p>
                                </div>
                            </div>
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <i class="material-icons text-danger text-gradient">code</i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">New order #1832412</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p>
                                </div>
                            </div>
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <i class="material-icons text-info text-gradient">shopping_cart</i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">Server payments for April</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 9:34 PM</p>
                                </div>
                            </div>
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <i class="material-icons text-warning text-gradient">credit_card</i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">New card added for order #4395133
                                    </h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">20 DEC 2:20 AM</p>
                                </div>
                            </div>
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <i class="material-icons text-primary text-gradient">key</i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">Unlock packages for development
                                    </h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">18 DEC 4:54 AM</p>
                                </div>
                            </div>
                            <div class="timeline-block">
                                <span class="timeline-step">
                                    <i class="material-icons text-dark text-gradient">payments</i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">New order #9583120</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">17 DEC</p>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    @else
        <p>Tidak ada pesanan yang ditemukan.</p>
    @endif

    <div id="modalForm" style="display: none;">
        <div class="modal-content">
            <form class="formTambah" action="{{ route('mulai-produksi') }}" method="POST"
                enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">@csrf
                        <h4>Produksi Pesanan {{ $pesanan->first()->kode }}</h4>

                        <input type="hidden" name="pesanan_id" value="{{ $pesanan->first()->id_pesanan }}">

                        <label>Apakah Anda yakin ingin memulai produksi untuk:</label>
                        <ul>
                            @foreach ($pesananproduk as $item)
                                <li>
                                    <h6 class="mb-0 text-sm">{{ $item->jumlah }}x {{ $item->nama_produk }}
                                        ({{ $item->ukuran_produk }})
                                    </h6>
                                </li>
                            @endforeach
                        </ul>

                        <label>Estimasi Lama Produksi:</label>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="estimasi-container">
                                    <input type="number" name="estimasiJam" id="estimasiJam" class="form-control"
                                        value="0" required>
                                    <label>Jam</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="estimasi-container">
                                    <input type="number" name="estimasiMenit" id="estimasiMenit" class="form-control"
                                        value="0" required max="59" oninput="limitMaxValue(this, 59)">
                                    <label>Menit</label>
                                </div>
                            </div>
                        </div>

                        <label class="text-danger"><b>Peringatan!</b><br>Pastikan
                            semua persiapan sebelum memulai proses
                            produksi telah siap!</label>
                        <br>

                        <button type="submit" class="btn btn-success" onclick="return konfirmasiMulai()">Mulai</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div id="bahanBakuModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bahan Baku untuk Produksi</h5>
                </div>
                <div class="modal-body">
                    <ul id="bahanBakuList">
                        @foreach ($stokBahanBaku as $bahan)
                            <li class="@if ($bahan->sisa_stok_bahan_baku < 0) text-danger @endif">
                                {{ $bahan->nama_bahan_baku }}: {{ $bahan->total_jumlah_bahan_baku }}
                                {{ $bahan->jenis_satuan }} -
                                (Stok: {{ $bahan->stok_bahan_baku }} {{ $bahan->jenis_satuan }})
                            </li>
                        @endforeach
                        @php
                            $bahanKekurangan = $stokBahanBaku->filter(function ($item) {
                                return $item->sisa_stok_bahan_baku < 0;
                            });
                        @endphp
                        @if ($bahanKekurangan->isNotEmpty())
                            <div class="text-danger mt-4"><strong>!!! PERINGATAN !!!</strong></div>
                            <div><strong>Ada kekurangan bahan baku berikut:</strong></div>
                            @foreach ($bahanKekurangan as $bahan)
                                <li>
                                    {{ $bahan->nama_bahan_baku }} (Kekurangan: {{ abs($bahan->sisa_stok_bahan_baku) }}
                                    {{ $bahan->jenis_satuan }})
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('add-script')
    <script>
        function showForm() {
            // Logika Anda untuk menampilkan formulir
            // Menunjukkan modal atau mengatur properti CSS untuk menampilkannya
            var modalForm = document.getElementById('modalForm');
            modalForm.style.display = 'block';
        }

        document.addEventListener("DOMContentLoaded", function() {
            var btnTambah = document.getElementById('btnTambah');
            var modalForm = document.getElementById('modalForm');
            var formProduksi = document.getElementById('formProduksi');

            btnTambah.addEventListener('click', function() {
                modalForm.style.display = 'block';
            });

            // Menyembunyikan pop-up ketika klik di luar area formulir
            window.addEventListener('click', function(event) {
                if (event.target === modalForm) {
                    modalForm.style.display = 'none';
                }
            });

            formProduksi.addEventListener('submit', function(event) {
                event.preventDefault();

                // Lakukan pengiriman data menggunakan Ajax di sini
                // Contoh menggunakan Fetch API
                fetch('', {
                        method: 'POST',
                        body: new FormData(formProduksi),
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Tampilkan respons dari server
                        alert(data.message);
                        if (data.success) {
                            modalForm.style.display = 'none';
                            window.location.reload(true);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengolah permintaan.');
                    });
            });
        });

        function konfirmasiMulai() {
            var konfirmasi = confirm("Apakah Anda yakin ingin memulai produksi?");

            // Jika pengguna menekan OK pada konfirmasi
            if (konfirmasi) {
                // Lanjutkan dengan penyimpanan data
                return true;
            } else {
                // Batal penyimpanan data
                return false;
            }
        }

        function closeModal() {
            var modalForm = document.getElementById('modalForm');
            modalForm.style.display = 'none';
        }

        // Menangani klik di luar modal
        window.addEventListener('click', function(event) {
            var modalForm = document.getElementById('modalForm');
            if (event.target === modalForm) {
                closeModal();
            }
        });

        function limitMaxValue(element, maxValue) {
            // Memastikan nilai tidak melebihi maxValue
            if (element.value > maxValue) {
                element.value = maxValue;
            }
        }

        function konfirmasiTerima() {
            return confirm('Apakah Anda yakin ingin menerima pesanan ini?');
        }

        function konfirmasiTolak() {
            return confirm('Apakah Anda yakin ingin menolak pesanan ini?');
        }

        function konfirmasiLunas() {
            return confirm('Apakah Anda yakin ingin mengajukan pelunasan sekarang?');
        }

        function konfirmasiKirim() {
            return confirm('Apakah Anda yakin ingin mengirim pesanan sekarang?');
        }

        function konfirmasiSelesai() {
            return confirm('Apakah pesanan telah terkirim?\nMohon lakukan pengecekan sebelum menyelesaikan pengiriman!');
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cekBahanBakuButton').on('click', function() {
                $('#bahanBakuModal').modal('show');
            });
        });
    </script>
@endpush
