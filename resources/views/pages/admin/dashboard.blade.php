@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('page')
    Dashboard
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
    @if (session('kode_peran_admin') == 'ADMN')
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <a href="{{ route('list-produk') }}" style="text-decoration: none;">
                    <div class="card">
                        @if ($topProduct && $topProduct->total_terjual > 0)
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">checkroom</i>
                                </div>
                                <div class="text-end pt-1">
                                    <h4 class="text-sm mb-0 text-capitalize"><b>Produk Terlaris Bulan Ini</b></h4>
                                    <h4 class="mb-0">{{ $topProduct->total_terjual }} Unit</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <h6 class="mb-0"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: normal;">
                                    {{ $topProduct->nama }}</h6>
                            </div>
                        @else
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">local_mall</i>
                                </div>
                                <div class="text-end pt-1">
                                    <h4 class="text-sm mb-0 text-capitalize">Produk Terlaris Bulan Ini</h4>
                                    <h4 class="mb-0">0 Unit</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <h6 class="mb-0"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: normal;">
                                    Tidak ada</h6>
                            </div>
                        @endif
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <a href="{{ route('list-pesanan') }}" style="text-decoration: none;">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">shopping_cart</i>
                            </div>
                            <div class="text-end pt-1">
                                <h4 class="text-sm mb-0 text-capitalize"><b>Pesanan Bulan Ini</b></h4>
                                <h4 class="mb-0">{{ $resultPesanan->total_pesanan }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        @if (is_null($resultPesanan))
                            <div class="card-footer p-3">
                                <p class="mb-0">Tidak ada pesanan yang tercatat</p>
                            </div>
                        @else
                            <div class="card-footer p-3">
                                <h6 class="mb-0" style="font-weight: normal;"><b>Terakhir Tgl:</b>
                                    {{ \Carbon\Carbon::parse($resultPesanan->pesanan_terakhir)->locale('id')->translatedFormat('l, d M Y') }}
                                </h6>
                            </div>
                        @endif
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <a href="{{ route('list-transaksi') }}" style="text-decoration: none;">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">local_mall</i>
                            </div>
                            <div class="text-end pt-1">
                                <h4 class="text-sm mb-0 text-capitalize"><b>Pembelian Bulan Ini</b></h4>
                                <h4 class="mb-0">{{ $resultTransaksi->total_transaksi }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        @if (is_null($resultTransaksi))
                            <div class="card-footer p-3">
                                <h6 class="mb-0" style="font-weight: normal;">Tidak ada transaksi yang tercatat</h6>
                            </div>
                        @else
                            <div class="card-footer p-3">
                                <h6 class="mb-0" style="font-weight: normal;"><b>Terakhir Tgl:</b>
                                    {{ \Carbon\Carbon::parse($resultTransaksi->transaksi_terakhir)->locale('id')->translatedFormat('l, d M Y') }}
                                </h6>
                            </div>
                        @endif
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-sm-6">
                <a href="{{ route('list-produksi') }}" style="text-decoration: none;">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">precision_manufacturing</i>
                            </div>
                            <div class="text-end pt-1">
                                <h4 class="text-sm mb-0 text-capitalize"><b>Produksi Sedang Berjalan</b></h4>
                                <h4 class="mb-0">{{ $jumlahProduksi }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        @if (is_null($produksiTerakhir))
                            <div class="card-footer p-3">
                                <h6 class="mb-0" style="font-weight: normal;">Tidak ada produksi yang tercatat</h6>
                            </div>
                        @else
                            <div class="card-footer p-3">
                                <h6 class="mb-0" style="font-weight: normal;"><b>Terakhir Tgl:</b>
                                    {{ \Carbon\Carbon::parse($produksiTerakhir)->locale('id')->translatedFormat('l, d M Y') }}
                                </h6>
                            </div>
                        @endif
                    </div>
                </a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <a href="{{ route('list-pesanan') }}" style="text-decoration: none;">
                    <div class="card z-index-2 ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-pesanan-masuk-admin" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 ">Jumlah Pesanan Masuk</h6>
                            <h6 class="text-sm" style="font-weight: normal;">7 Bulan Sebelumnya</h6>
                            <hr class="dark horizontal">
                            @if (is_null($resultPesanan))
                                <div class="d-flex ">
                                    <p class="mb-0 text-sm">
                                        <b>Tidak ada pesanan yang tercatat</b>
                                    </p>
                                </div>
                            @else
                                <div class="d-flex ">
                                    <h6 class="mb-0 text-sm" style="font-weight: normal;"><b>Pemesanan Terakhir:</b>
                                        {{ \Carbon\Carbon::parse($resultPesanan->pesanan_terakhir)->locale('id')->translatedFormat('l, d M Y') }}
                                    </h6>
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <a href="{{ route('view-pemasukkan') }}" style="text-decoration: none;">
                    <div class="card z-index-2  ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-jumlah-pemasukkan-admin" class="chart-canvas"
                                        height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 ">Jumlah Pemasukkan (dalam Rupiah)</h6>
                            <h6 class="text-sm" style="font-weight: normal;">7 Bulan Sebelumnya</h6>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <h6 class="mb-0 text-sm" style="font-weight: normal;"><b>Pemasukkan Bulan Ini:</b> Rp
                                    {{ number_format($jumlahPesanan->last()->total_harga_pesanan, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 mt-4 mb-3">
                <a href="{{ route('view-pengeluaran') }}" style="text-decoration: none;">
                    <div class="card z-index-2 ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-jumlah-pengeluaran-admin" class="chart-canvas"
                                        height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 ">Jumlah Pengeluaran</h6>
                            <h6 class="text-sm" style="font-weight: normal;">7 Bulan Sebelumnya</h6>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <h6 class="mb-0 text-sm" style="font-weight: normal;"><b>Pengeluaran Bulan Ini:</b> Rp
                                    {{ number_format($jumlahTransaksi->last()->total_harga_transaksi, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @elseif (session('kode_peran_admin') == 'KBLJ')
        <div class="row">
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <a href="{{ route('list-pesanan') }}" style="text-decoration: none;">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">shopping_cart</i>
                            </div>
                            <div class="text-end pt-1">
                                <h4 class="text-sm mb-0 text-capitalize"><b>Pesanan Bulan Ini</b></h4>
                                <h4 class="mb-0">{{ $resultPesanan->total_pesanan }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        @if (is_null($resultPesanan->pesanan_terakhir))
                            <div class="card-footer p-3">
                                <p class="mb-0">Tidak ada pesanan yang tercatat</p>
                            </div>
                        @else
                            <div class="card-footer p-3">
                                <h6 class="mb-0" style="font-weight: normal;"><b>Terakhir Tgl:</b>
                                    {{ \Carbon\Carbon::parse($resultPesanan->pesanan_terakhir)->locale('id')->translatedFormat('l, d M Y') }}
                                </h6>
                            </div>
                        @endif

                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <a href="{{ route('list-transaksi') }}" style="text-decoration: none;">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-secondary shadow-secondary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">local_mall</i>
                            </div>
                            <div class="text-end pt-1">
                                <h4 class="text-sm mb-0 text-capitalize"><b>Pembelian Bulan Ini</b></h4>
                                <h4 class="mb-0">{{ $resultTransaksi->total_transaksi }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        @if (is_null($resultTransaksi->transaksi_terakhir))
                            <div class="card-footer p-3">
                                <h6 class="mb-0" style="font-weight: normal;">Tidak ada transaksi yang tercatat</h6>
                            </div>
                        @else
                            <div class="card-footer p-3">
                                <h6 class="mb-0" style="font-weight: normal;"><b>Terakhir Tgl:</b>
                                    {{ \Carbon\Carbon::parse($resultTransaksi->transaksi_terakhir)->locale('id')->translatedFormat('l, d M Y') }}
                                </h6>
                            </div>
                        @endif
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <a href="{{ route('list-pesanan') }}" style="text-decoration: none;">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            @if (is_null($pesananMenunggu->pesanan_terakhir))
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">store</i>
                                </div>
                            @else
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">store</i>
                                </div>
                            @endif
                            <div class="text-end pt-1">
                                <h4 class="text-sm mb-0 text-capitalize"><b>Pesanan yang belum diterima:</b></h4>
                                <h4 class="mb-0">{{ $pesananMenunggu->total_pesanan }}
                                </h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        @if (is_null($pesananMenunggu->pesanan_terakhir))
                            <div class="card-footer p-3">
                                <h6 class="mb-0" style="font-weight: normal;">Menunggu pesanan baru untuk masuk</h6>
                            </div>
                        @else
                            <div class="card-footer p-3">
                                <h6 class="mb-0" style="font-weight: normal;"><b>Terakhir Tgl:</b>
                                    {{ \Carbon\Carbon::parse($pesananMenunggu->pesanan_terakhir)->locale('id')->translatedFormat('l, d M Y') }}
                                </h6>
                            </div>
                        @endif
                    </div>
                </a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <a href="{{ route('list-pesanan') }}" style="text-decoration: none;">
                    <div class="card z-index-2 ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-pesanan-masuk-kblj" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 ">Jumlah Pesanan Masuk</h6>
                            <h6 class="text-sm" style="font-weight: normal;">7 Bulan Sebelumnya</h6>
                            <hr class="dark horizontal">
                            @if (is_null($resultPesanan))
                                <div class="d-flex ">
                                    <p class="mb-0 text-sm">
                                        <b>Tidak ada pesanan yang tercatat</b>
                                    </p>
                                </div>
                            @else
                                <div class="d-flex ">
                                    <h6 class="mb-0 text-sm" style="font-weight: normal;"><b>Pemesanan Terakhir:</b>
                                        {{ \Carbon\Carbon::parse($resultPesanan->pesanan_terakhir)->locale('id')->translatedFormat('l, d M Y') }}
                                    </h6>
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <a href="{{ route('list-transaksi') }}" style="text-decoration: none;">
                    <div class="card z-index-2  ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-secondary shadow-secondary border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-transaksi-masuk-kblj" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 ">Jumlah Transaksi Pembelian Bahan Baku</h6>
                            <h6 class="text-sm" style="font-weight: normal;">7 Bulan Sebelumnya</h6>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                @if (is_null($resultTransaksi))
                                    <h6 class="mb-0 text-sm" style="font-weight: normal;">Tidak ada transaksi yang
                                        tercatat
                                    </h6>
                                @else
                                    <h6 class="mb-0 text-sm" style="font-weight: normal;"><b>Transaksi Terakhir: </b>
                                        {{ \Carbon\Carbon::parse($resultTransaksi->transaksi_terakhir)->locale('id')->translatedFormat('l, d M Y') }}
                                    </h6>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-info shadow-info border-radius-lg py-3 pe-1">
                            <h6 class="text-white ms-4">Bahan Baku untuk Pesanan</h6>
                        </div>
                    </div>
                    @php
                        $bahanKekurangan = $stokBahanBaku->filter(function ($item) {
                            return $item->sisa_stok_bahan_baku < 0;
                        });
                    @endphp
                    @if ($bahanKekurangan->isNotEmpty())
                        <div class="card-body" style="height:275px; overflow-y: auto;">
                            <div class="text-center"><strong>Ada bahan baku yang harus dipesan!</strong></div>
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th scope="col">Bahan Baku</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bahanKekurangan as $bahan)
                                        <tr>
                                            <th scope="row">{{ $bahan->nama_bahan_baku }}</th>
                                            <td>{{ abs($bahan->sisa_stok_bahan_baku) }}
                                                {{ $bahan->jenis_satuan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="card-body" style="height:275px; overflow-y: auto;">
                            <div class="text-center"><strong>Belum ada bahan baku yang harus dipesan!</strong></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @elseif (session('kode_peran_admin') == 'KKEU')
        <div class="row">
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <a href="{{ route('view-pemasukkan') }}" style="text-decoration: none;">
                    <div class="card">

                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">trending_up</i>
                            </div>
                            <div class="text-end pt-1">
                                <h4 class="text-sm mb-0 text-capitalize"><b>Pemasukkan Bulan Ini</b></h4>
                                <h4 class="mb-0">Rp
                                    {{ number_format($jumlahPesanan->last()->total_harga_pesanan, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <h6 id="footer-date-pemasukkan" class="mb-0"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: normal;">
                            </h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">

                <div class="card">
                    <div class="card-header p-3 pt-2">
                        @if ($labaRugi->last()->laba_rugi < 0)
                            <div
                                class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">account_balance_wallet</i>
                            </div>
                        @else
                            <div
                                class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">account_balance_wallet</i>
                            </div>
                        @endif
                        <div class="text-end pt-1">
                            @if ($labaRugi->last()->laba_rugi < 0)
                                <h4 class="text-sm mb-0 text-capitalize"><b>Rugi Bulan Ini</b></h4>
                            @else
                                <h4 class="text-sm mb-0 text-capitalize"><b>Laba Bulan Ini</b></h4>
                            @endif
                            <h4 class="mb-0">
                                Rp {{ number_format(abs($labaRugi->last()->laba_rugi), 0, ',', '.') }}
                            </h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <h6 class="mb-0"
                            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: normal;">
                            Berdasarkan Data Pemasukkan & Pengeluaran</h6>
                    </div>
                </div>

            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <a href="{{ route('view-pengeluaran') }}" style="text-decoration: none;">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">trending_down</i>
                            </div>
                            <div class="text-end pt-1">
                                <h4 class="text-sm mb-0 text-capitalize"><b>Pengeluaran Bulan Ini</b></h4>
                                <h4 class="mb-0">Rp
                                    {{ number_format($jumlahTransaksi->last()->total_harga_transaksi, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <h6 id="footer-date-pengeluaran" class="mb-0"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: normal;">
                            </h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-6 col-md-6 mt-4 mb-4">
                <a href="{{ route('view-pemasukkan') }}" style="text-decoration: none;">
                    <div class="card z-index-2  ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-jumlah-pemasukkan-kkeu" class="chart-canvas"
                                        height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 ">Jumlah Pemasukkan (dalam Rupiah)</h6>
                            <h6 class="text-sm" style="font-weight: normal;">7 Bulan Sebelumnya</h6>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <h6 class="mb-0 text-sm" style="font-weight: normal;"><b>Pemasukkan Bulan Ini:</b> Rp
                                    {{ number_format($jumlahPesanan->last()->total_harga_pesanan, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 mt-4 mb-3">
                <a href="{{ route('view-pengeluaran') }}" style="text-decoration: none;">
                    <div class="card z-index-2 ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-jumlah-pengeluaran-kkeu" class="chart-canvas"
                                        height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 ">Jumlah Pengeluaran</h6>
                            <h6 class="text-sm" style="font-weight: normal;">7 Bulan Sebelumnya</h6>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <h6 class="mb-0 text-sm" style="font-weight: normal;"><b>Pengeluaran Bulan Ini:</b> Rp
                                    {{ number_format($jumlahTransaksi->last()->total_harga_transaksi, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @elseif (session('kode_peran_admin') == 'KPRD')
        <div class="row">
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <a href="{{ route('list-pesanan') }}" style="text-decoration: none;">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">shopping_cart</i>
                            </div>
                            <div class="text-end pt-1">
                                <h4 class="text-sm mb-0 text-capitalize"><b>Pesanan Bulan Ini</b></h4>
                                <h4 class="mb-0">{{ $resultPesanan->total_pesanan }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        @if (is_null($resultPesanan))
                            <div class="card-footer p-3">
                                <p class="mb-0">Tidak ada pesanan yang tercatat</p>
                            </div>
                        @else
                            <div class="card-footer p-3">
                                <h6 class="mb-0" style="font-weight: normal;"><b>Terakhir Tgl:</b>
                                    {{ \Carbon\Carbon::parse($resultPesanan->pesanan_terakhir)->locale('id')->translatedFormat('l, d M Y') }}
                                </h6>
                            </div>
                        @endif
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <a href="{{ route('list-pesanan') }}" style="text-decoration: none;">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">factory</i>
                            </div>
                            <div class="text-end pt-1">
                                <h4 class="text-sm mb-0 text-capitalize"><b>Pesanan Siap Produksi</b></h4>
                                <h4 class="mb-0">{{ $pesananSiapProduksi->total_pesanan }}
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        @if (is_null($pesananSiapProduksi->pesanan_terakhir))
                            <div class="card-footer p-3">
                                <h6 class="mb-0" style="font-weight: normal;">Belum ada pesanan yang siap diproduksi
                                </h6>
                            </div>
                        @else
                            <div class="card-footer p-3">
                                <h6 class="mb-0" style="font-weight: normal;">Mohon untuk mengecek kelengkapan bahan
                                    baku
                                </h6>
                            </div>
                        @endif
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-sm-6">
                <a href="{{ route('list-produksi') }}" style="text-decoration: none;">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">precision_manufacturing</i>
                            </div>
                            <div class="text-end pt-1">
                                <h4 class="text-sm mb-0 text-capitalize"><b>Produksi Sedang Berjalan</b></h4>
                                <h4 class="mb-0">{{ $jumlahProduksi }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        @if (is_null($produksiTerakhir))
                            <div class="card-footer p-3">
                                <h6 class="mb-0" style="font-weight: normal;">Tidak ada produksi yang tercatat</h6>
                            </div>
                        @else
                            <div class="card-footer p-3">
                                <h6 class="mb-0" style="font-weight: normal;"><b>Terakhir Tgl:</b>
                                    {{ \Carbon\Carbon::parse($produksiTerakhir)->locale('id')->translatedFormat('l, d M Y') }}
                                </h6>
                            </div>
                        @endif
                    </div>
                </a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-6 col-md-6 mt-4 mb-4">
                <a href="{{ route('list-produksi') }}" style="text-decoration: none;">
                    <div class="card z-index-2 ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-produksi-kprd" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 ">Jumlah Kegiatan Produksi</h6>
                            <h6 class="text-sm" style="font-weight: normal;">7 Bulan Sebelumnya</h6>
                            <hr class="dark horizontal">
                            @if (is_null($produksiTerakhir))
                                <div class="d-flex ">
                                    <p class="mb-0 text-sm">
                                        <b>Tidak ada kegiatan produksi yang tercatat</b>
                                    </p>
                                </div>
                            @else
                                <div class="d-flex ">
                                    <h6 class="mb-0" style="font-weight: normal;"><b>Terakhir Tgl:</b>
                                        {{ \Carbon\Carbon::parse($produksiTerakhir)->locale('id')->translatedFormat('l, d M Y') }}
                                    </h6>
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-md-6 mt-4 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-info shadow-info border-radius-lg py-3 pe-1">
                            <h6 class="text-white ms-4">Bahan Baku untuk Produksi</h6>
                        </div>
                    </div>
                    @php
                        $bahanKekurangan = $stokBahanBaku->filter(function ($item) {
                            return $item->sisa_stok_bahan_baku < 0;
                        });
                    @endphp
                    @if ($bahanKekurangan->isNotEmpty())
                        <div class="card-body" style="height:275px; overflow-y: auto;">
                            <div class="text-center"><strong>Ada bahan baku yang harus dipesan!</strong></div>
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th scope="col">Bahan Baku</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bahanKekurangan as $bahan)
                                        <tr>
                                            <th scope="row">{{ $bahan->nama_bahan_baku }}</th>
                                            <td>{{ abs($bahan->sisa_stok_bahan_baku) }}
                                                {{ $bahan->jenis_satuan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="card-body" style="height:275px; overflow-y: auto;">
                            <div class="text-center"><strong>Belum ada bahan baku yang harus dipesan!</strong></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection

@push('add-script')
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var footerDatePemasukkan = document.getElementById('footer-date-pemasukkan');
            var footerDatePengeluaran = document.getElementById('footer-date-pengeluaran');

            var options = {
                month: 'long',
                year: 'numeric'
            };

            var date = new Date().toLocaleDateString('id-ID', options);
            footerDatePemasukkan.textContent = date;
            footerDatePengeluaran.textContent = date;
        });
        // Fungsi untuk mendapatkan labels dari 7 bulan sebelumnya
        function getLast7MonthsLabels() {
            const months = [
                "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
            ];

            const today = new Date();
            const currentMonth = today.getMonth(); // Mendapatkan bulan saat ini (0-11)

            let labels = [];

            // Mendapatkan 7 bulan sebelumnya, dimulai dari bulan saat ini
            for (let i = 6; i >= 0; i--) {
                const monthIndex = (currentMonth - i + 12) % 12; // Menggunakan modulus untuk wrapping
                labels.push(months[monthIndex]);
            }

            return labels;
        }

        // Menggunakan fungsi untuk mendapatkan labels
        const labels = getLast7MonthsLabels();

        var data_jumlah_pesanan = [
            @foreach ($jumlahPesanan as $jumlah)
                {{ $jumlah->jumlah_pesanan }},
            @endforeach
        ];

        var data_jumlah_transaksi = [
            @foreach ($jumlahTransaksi as $jumlah)
                {{ $jumlah->jumlah_transaksi }},
            @endforeach
        ];

        var data_jumlah_produksi = [
            @foreach ($jumlahProduksi2 as $jumlah)
                {{ $jumlah->jumlah_produksi }},
            @endforeach
        ];

        var data_harga_pesanan = [
            @foreach ($jumlahPesanan as $jumlah)
                {{ $jumlah->total_harga_pesanan }},
            @endforeach
        ];

        var data_harga_transaksi = [
            @foreach ($jumlahTransaksi as $jumlah)
                {{ $jumlah->total_harga_transaksi }},
            @endforeach
        ];

        @if (session('kode_peran_admin') == 'ADMN')
            // Chart Admin
            var ctx_pesanan_masuk_admin = document.getElementById("chart-pesanan-masuk-admin").getContext("2d");

            new Chart(ctx_pesanan_masuk_admin, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Pesanan",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "rgba(255, 255, 255, .8)",
                        data: data_jumlah_pesanan,
                        maxBarThickness: 6
                    }, ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 500,
                                beginAtZero: true,
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                color: "#fff"
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });

            var ctx_jumlah_pemasukkan_admin = document.getElementById("chart-jumlah-pemasukkan-admin").getContext("2d");

            new Chart(ctx_jumlah_pemasukkan_admin, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Total Pemasukkan",
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(255, 255, 255, .8)",
                        pointBorderColor: "transparent",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderWidth: 4,
                        backgroundColor: "transparent",
                        fill: true,
                        data: data_harga_pesanan,
                        maxBarThickness: 6
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'Rp ' + tooltipItem.raw.toLocaleString();
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });

            var ctx_jumlah_pengeluaran_admin = document.getElementById("chart-jumlah-pengeluaran-admin").getContext("2d");

            new Chart(ctx_jumlah_pengeluaran_admin, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Total Pengeluaran",
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(255, 255, 255, .8)",
                        pointBorderColor: "transparent",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderWidth: 4,
                        backgroundColor: "transparent",
                        fill: true,
                        data: data_harga_transaksi,
                        maxBarThickness: 6

                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'Rp ' + tooltipItem.raw.toLocaleString();
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });
        @elseif (session('kode_peran_admin') == 'KBLJ')
            // Chart Karyawan Pembelanjaan
            var ctx_pesanan_masuk_kblj = document.getElementById("chart-pesanan-masuk-kblj").getContext("2d");

            new Chart(ctx_pesanan_masuk_kblj, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Pesanan",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "rgba(255, 255, 255, .8)",
                        data: data_jumlah_pesanan,
                        maxBarThickness: 6
                    }, ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 500,
                                beginAtZero: true,
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                color: "#fff"
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });

            var ctx_transaksi_masuk_kblj = document.getElementById("chart-transaksi-masuk-kblj").getContext("2d");

            new Chart(ctx_transaksi_masuk_kblj, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Pesanan",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "rgba(255, 255, 255, .8)",
                        data: data_jumlah_transaksi,
                        maxBarThickness: 6
                    }, ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 500,
                                beginAtZero: true,
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                color: "#fff"
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });
        @elseif (session('kode_peran_admin') == 'KPRD')
            // Chart Karyawan Pembelanjaan
            var ctx_produksi_kprd = document.getElementById("chart-produksi-kprd").getContext("2d");

            new Chart(ctx_produksi_kprd, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Produksi",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "rgba(255, 255, 255, .8)",
                        data: data_jumlah_produksi,
                        maxBarThickness: 6
                    }, ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 500,
                                beginAtZero: true,
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                color: "#fff"
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });
        @elseif (session('kode_peran_admin') == 'KKEU')
            var ctx_jumlah_pemasukkan_kkeu = document.getElementById("chart-jumlah-pemasukkan-kkeu").getContext("2d");

            new Chart(ctx_jumlah_pemasukkan_kkeu, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Total Pemasukkan",
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(255, 255, 255, .8)",
                        pointBorderColor: "transparent",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderWidth: 4,
                        backgroundColor: "transparent",
                        fill: true,
                        data: data_harga_pesanan,
                        maxBarThickness: 6
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'Rp ' + tooltipItem.raw.toLocaleString();
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });

            var ctx_jumlah_pengeluaran_kkeu = document.getElementById("chart-jumlah-pengeluaran-kkeu").getContext("2d");

            new Chart(ctx_jumlah_pengeluaran_kkeu, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Total Pengeluaran",
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(255, 255, 255, .8)",
                        pointBorderColor: "transparent",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderWidth: 4,
                        backgroundColor: "transparent",
                        fill: true,
                        data: data_harga_transaksi,
                        maxBarThickness: 6

                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'Rp ' + tooltipItem.raw.toLocaleString();
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });
        @endif
    </script>
@endpush
