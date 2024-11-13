@extends('layouts.landing2')

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
    <section class="pb-5 position-relative bg-gradient-dark">
        <div class="container">

            <div class="row">
                <div class="col-md-8 text-start mb-5 mt-5">
                    <h3 class="text-white z-index-1 position-relative">Riwayat Pembelian</h3>
                    @if ($pesanan->isNotEmpty() && $pesanan->first()->tanggal)
                        <?php $formattedDate = \Carbon\Carbon::parse($pesanan->first()->tanggal)->locale('id')->translatedFormat('l, d M Y'); ?>
                        <p class="text-white opacity-8 mb-0">Pembelian terakhir kali dilakukan pada hari
                            {{ $formattedDate }}</p>
                    @else
                        <p class="text-white opacity-8 mb-0">Belum ada pembelian yang dilakukan</p>
                    @endif
                </div>
            </div>

            @if ($groupedPesanan->count() > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0 text-center">
                                    <table class="table align-items-center justify-content-center mb-0">
                                        <tbody>
                                            @foreach ($groupedPesanan as $id => $group)
                                                <tr>
                                                    <td style="width: 15%; text-align: left;">
                                                        <!-- Atur lebar sesuai kebutuhan Anda -->
                                                        <!-- Gambar -->
                                                        <p class="text-lg font-weight-bold mb-0"
                                                            style="margin-bottom: 0; margin-left:20px;">
                                                            Kode Pesanan
                                                        </p>
                                                        <p class="text-lg mb-0" style="margin-bottom: 0; margin-left:20px;">
                                                            {{ $group[0]->kode }}
                                                        </p>
                                                    </td>
                                                    <td style="width: 25%; text-align: left;">
                                                        <!-- Atur lebar sesuai kebutuhan Anda -->
                                                        <!-- Nama, Jumlah, dan Harga per Barang -->
                                                        <p class="text-lg mb-0" style="margin-bottom: 0;">
                                                            Status Pembayaran: <b>{{ $group[0]->status_pembayaran }}</b>
                                                        </p>
                                                        <p class="text-lg mb-0" style="margin-bottom: 0;">
                                                            Status Pesanan: <b>{{ $group[0]->status }}</b>
                                                        </p>
                                                        <p class="text-lg mb-0" style="margin-bottom: 0;">Total Harga:
                                                            Rp. {{ number_format($group[0]->total_harga, 0, ',', '.') }}, -
                                                        </p>

                                                    </td>
                                                    <td style="width: 40%; text-align: left;">
                                                        <p class="text-lg font-weight-bold mb-0" style="margin-bottom: 0;">
                                                            Isi Pesanan:
                                                        </p>
                                                        @foreach ($group as $item)
                                                            <p class="text-m mb-0">
                                                                {{ $item->jumlah }}x {{ $item->nama }}
                                                                ({{ $item->ukuran }})
                                                                - Rp
                                                                {{ number_format($item->harga, 0, ',', '.') }}<br>
                                                            </p>
                                                        @endforeach
                                                    </td>
                                                    <td style="width: 20%;">
                                                    <td>
                                                        <a href="{{ route('show-detail-pesanan', ['id' => $item->id]) }}"
                                                            class="btn btn-info mt-4" style="margin-right:40px;">Detail</a>
                                                    </td>
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
                <p class="text-white">Anda belum pernah melakukan pembelian pada sistem kami. <a class="text-white fw-bold"
                        href="{{ route('halaman-produk') }}">Klik disini</a> untuk
                    memulai pembelian.</p>
            @endif
        </div>
    </section>
@endsection

@push('add-script')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
