<!-- Contoh Struktur HTML, sesuaikan dengan kebutuhan Anda -->
@extends('layouts.admin')

@section('title')
    Detail Transaksi
@endsection

@section('page')
    Menu Master / Daftar Transaksi / Detail Transaksi
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

    @if ($transaksiDetail->count() > 0)
        <div class="row mb-4">
            <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Kode Transaksi {{ $transaksiDetail->first()->kode_transaksi }}</h6>
                                <p class="text-sm mb-0">
                                    @if ($transaksiDetail->first()->status == 'Selesai')
                                        <i class="fa fa-check text-success" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Status:</span>
                                        {{ $transaksiDetail->first()->status }}
                                    @elseif ($transaksiDetail->first()->status == 'Menunggu')
                                        <i class="fa fa-clock-o text-info" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Status:</span>
                                        {{ $transaksiDetail->first()->status }}
                                    @else
                                        <i class="fa fa-times-circle text-danger" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Status:</span>
                                        {{ $transaksiDetail->first()->status }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2 d-flex flex-column justify-content-between" style="height: 100%;">
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
                                    @foreach ($transaksiDetail as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $item->nama_bahan_baku }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold">{{ $item->jumlah }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold">Rp.
                                                    {{ number_format($item->harga / $item->jumlah, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold">Rp.
                                                    {{ number_format($item->harga, 0, ',', '.') }}</span>
                                            </td>
                                            @php
                                                $totalHargaKeseluruhan += $item->harga;
                                            @endphp
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($transaksiDetail->first()->status == 'Menunggu')
                            <!-- Form di halaman HTML -->
                            <form id="updateStokForm" method="POST" action="{{ route('transaksi-update-stok') }}"
                                onsubmit="return konfirmasiSimpan()">
                                @csrf
                                <input type="hidden" name="transaksi_id" value="{{ $item->transaksi_id }}">
                                <div id="bahanBakuInputs">
                                    @foreach ($transaksiDetail as $item)
                                        <input type="hidden" name="bahan_baku_ids[]" value="{{ $item->bahan_baku_id }}">
                                        <input type="hidden" name="jumlahs[]" value="{{ $item->jumlah }}">
                                    @endforeach
                                </div>
                                <div class="d-flex justify-content-center mt-auto" style="margin-bottom: 0px;">
                                    <button type="submit" class="btn btn-info w-40">Selesai</button>
                                </div>
                            </form>
                        @elseif ($transaksiDetail->first()->status == 'Dibatalkan')
                            <div class="d-flex justify-content-center mt-auto" style="margin-bottom: 0px;">
                                <h6 class="text-danger">Transaksi dibatalkan!</h6>
                            </div>
                        @else
                            <div class="d-flex justify-content-center mt-auto" style="margin-bottom: 0px;">
                                <h6 class="text-success">Transaksi telah tercatat selesai!</h6>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6>Detail Transaksi</h6><br>
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Dipesan oleh:</span> {{ $transaksiDetail->first()->nama_user }}
                        </p>
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Tanggal Transaksi:</span>
                            {{ \Carbon\Carbon::parse($transaksiDetail->first()->tanggal)->locale('id')->translatedFormat('l, d M Y') }}
                        </p>
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Supplier:</span> {{ $transaksiDetail->first()->nama_supplier }}
                        </p>
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Metode Pembayaran:</span>
                            {{ $transaksiDetail->first()->metode_pembayaran }}
                        </p>
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Cara Pengiriman:</span>
                            {{ $transaksiDetail->first()->cara_pengiriman }}
                        </p>
                        @if ($transaksiDetail->first()->catatan_tambahan == '')
                            <p class="text-sm">

                                Tidak ada catatan tambahan!
                            </p>
                        @else
                            <p class="text-sm">

                                {{ $transaksiDetail->first()->catatan_tambahan }}
                            </p>
                        @endif
                        <br>
                        <p class="text-sm">

                            <span class="font-weight-bold">Grand Total:</span>
                        </p>
                        <h3>Rp. {{ number_format($totalHargaKeseluruhan, 0, ',', '.') }}</h3>
                        <br>
                        @if ($transaksiDetail->first()->status == 'Menunggu')
                            <div class="d-flex justify-content-center">
                                <form action="{{ route('batal-transaksi') }}" method="POST"
                                    onsubmit="return konfirmasiBatal()">
                                    @csrf
                                    <input type="hidden" name="transaksi_id" value="{{ $item->transaksi_id }}">
                                    <button type="submit" class="btn btn-danger w-100">Batal</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <p>Tidak ada transaksi yang ditemukan.</p>
    @endif
@endsection

@push('add-script')
    <script>
        function konfirmasiSimpan() {
            return confirm("Apakah Anda yakin ingin menyelesaikan transaksi ini?");
        }

        function konfirmasiBatal() {
            return confirm("Apakah Anda yakin ingin membatalkan transaksi ini?");
        }
    </script>
@endpush
