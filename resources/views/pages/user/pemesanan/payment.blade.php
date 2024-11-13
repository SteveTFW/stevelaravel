@extends('layouts.landing2')

@section('style')
    <style>
        html {
            font-size: 14px;
        }

        @media (min-width: 768px) {
            html {
                font-size: 16px;
            }
        }

        .container {
            max-width: 960px;
        }

        .pricing-header {
            max-width: 700px;
        }

        .card-deck .card {
            min-width: 220px;
        }

        .border-top {
            border-top: 1px solid #e5e5e5;
        }

        .border-bottom {
            border-bottom: 1px solid #e5e5e5;
        }

        .box-shadow {
            box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05);
        }
    </style>
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
    <section class="pb-5 position-relative bg-gradient-dark">
        <div class="container">

            <div class="row">
                <div class="col-md-8 text-start mt-5">
                    <h3 class="text-white z-index-1 position-relative">Detail Pesanan</h3>
                    <p class="text-white opacity-8 mb-0">Cek lagi sebelum melakukan pembayaran</p>
                    {{-- <p class="text-white opacity-8 mb-0">Status pembayaran akan berubah setelah pengecekan dari Admin</p> --}}
                </div>
            </div>

            <div class="container pb-5 pt-5">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="card shadow">
                            <div class="card-header">
                                <h5>Data Pemesanan</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-condensed">
                                    <tr>
                                        <td>Kode Pesanan</td>
                                        <td><b>{{ $pesanan->first()->kode }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td><b>{{ $pesanan->first()->alamat_pengiriman }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Produk Pesanan</td>
                                        <td>
                                            @foreach ($pesananproduk as $item)
                                                <b>{{ $item->jumlah }}x {{ $item->nama_produk }}
                                                    {{ $item->ukuran_produk }}</b><br>
                                                <p>Rp. {{ number_format($item->harga_produk, 0, ',', '.') }}
                                                    <br>
                                                    Note: {{ $item->catatan }}
                                                </p>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Harga</td>
                                        <td><b>Rp {{ number_format($pesanan->first()->total_harga, 2, ',', '.') }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Total DP</td>
                                        <td><b>Rp {{ number_format($pesanan->first()->total_harga * 0.3, 2, ',', '.') }}</b></td>
                                    </tr>
                                    @if ($pesanan->first()->status != 'Menunggu Konfirmasi')
                                        <tr>
                                            <td>Status Pembayaran</td>
                                            <td><b>
                                                    @if ($pesanan->first()->status_pembayaran == 'Menunggu Pembayaran')
                                                        Menunggu Pembayaran
                                                    @elseif ($pesanan->first()->status_pembayaran == 'Sudah Dibayar')
                                                        Lunas
                                                    @elseif ($pesanan->first()->status_pembayaran == 'Sudah Bayar DP')
                                                        DP Lunas
                                                    @elseif ($pesanan->first()->status_pembayaran == 'Menunggu Pelunasan')
                                                        Menunggu Pelunasan
                                                    @elseif ($pesanan->first()->status_pembayaran == 'Belum Dibayar')
                                                        Belum Dibayar
                                                    @elseif ($pesanan->first()->status_pembayaran == 'Batal')
                                                        Batal
                                                    @else
                                                        Kadaluarsa
                                                    @endif
                                                </b></td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>Status Pesanan</td>
                                        <td><b>{{ $pesanan->first()->status }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Pemesanan</td>
                                        <td><b>{{ \Carbon\Carbon::parse($pesanan->first()->tanggal)->locale('id')->translatedFormat('l, d M Y') }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Estimasi Pesanan Selesai</td>
                                        <td><b>{{ \Carbon\Carbon::parse($pesanan->first()->tgl_estimasi)->locale('id')->translatedFormat('l, d M Y') }}</b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card shadow">
                            <div class="card-header">
                                <h3>Pembayaran</h3>
                            </div>
                            <div class="card-body">
                                <p>
                                    <span class="font-weight-bold">Tgl. Pembayaran DP:</span>
                                    @if ($pesanan->first()->tgl_dp)
                                        {{ \Carbon\Carbon::parse($pesanan->first()->tgl_dp)->locale('id')->translatedFormat('l, d M Y') }}
                                    @else
                                        Pembayaran DP belum dibayar
                                    @endif
                                </p>
                                @if ($pesanan->first()->metode_pembayaran == 'Transfer')
                                    <p>
                                        {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                                        <span class="font-weight-bold">Tgl. Pelunasan:</span>
                                        @if ($pesanan->first()->tgl_lunas)
                                            {{ \Carbon\Carbon::parse($pesanan->first()->tgl_lunas)->locale('id')->translatedFormat('l, d M Y') }}
                                        @else
                                            Pelunasan belum dilakukan
                                        @endif
                                    </p>
                                @endif
                                <p>
                                    {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                                    <span class="font-weight-bold">Tgl. Pesanan Selesai:</span>
                                    @if ($pesanan->first()->tgl_selesai)
                                        {{ \Carbon\Carbon::parse($pesanan->first()->tgl_selesai)->locale('id')->translatedFormat('l, d M Y') }}
                                    @else
                                        Pesanan masih berjalan
                                    @endif
                                </p>
                                @if ($pesanan->first()->status_pembayaran == 'Menunggu Pembayaran')
                                    @if ($pesanan->first()->status == 'Menunggu Konfirmasi')
                                        <p>Mohon menunggu konfirmasi pesanan!</p>
                                    @else
                                        <button class="btn btn-primary w-100" id="pay-button">Bayar DP</button>
                                    @endif
                                @elseif ($pesanan->first()->status_pembayaran == 'Sudah Bayar DP')
                                    @if ($pesanan->first()->metode_pembayaran == 'Transfer')
                                        <p>Barang pesanan sedang diproses. Mohon menunggu!</p>
                                    @else
                                        <p>Pembayaran DP lunas. Sisa Pembayaran COD akan dilakukan setelah barang siap
                                            dikirim.</p>
                                    @endif
                                @elseif ($pesanan->first()->status_pembayaran == 'Menunggu Pelunasan')
                                    <p>Barang yang dipesan telah siap. Mohon untuk segera melakukan pelunasan.</p>
                                    <br><br>
                                    <button class="btn btn-primary w-100" id="pay-button">Bayar Lunas</button>
                                @elseif ($pesanan->first()->status_pembayaran == 'Belum Dibayar')
                                    <p>Pembayaran menggunakan metode COD!</p>
                                @elseif ($pesanan->first()->status_pembayaran == 'Batal')
                                    <p>Pesanan dibatalkan / ditolak!</p>
                                @else
                                    <p>Pembayaran berhasil!</p>
                                @endif
                            </div>
                        </div>
                        @if ($pesanan->first()->status == 'Menunggu Konfirmasi' || $pesanan->first()->status == 'Dikonfirmasi')
                            <div class="mt-4">
                                <form action="{{ route('batal-pesanan', ['id' => $pesanan->first()->id]) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100"
                                        onclick="konfirmasiBatal()">Batal</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('add-script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        const payButton = document.querySelector('#pay-button');
        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    // Kirim permintaan ke server Laravel untuk memperbarui status pesanan
                    fetch('/update-status/{{ $pesanan->first()->id }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Sesuaikan dengan cara Anda mengelola CSRF token
                            },
                            body: JSON.stringify(result),
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Handle respons dari server jika diperlukan
                            console.log(data);

                            // Refresh halaman setelah berhasil
                            window.location.reload();
                        })
                        .catch(error => {
                            // Handle error jika diperlukan
                            console.error(error);
                        });

                    // ...

                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                }
            });
        });

        function konfirmasiBatal() {
            if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
                document.getElementById('form-batal-pesanan').submit();
            }
        }
    </script>
@endpush
