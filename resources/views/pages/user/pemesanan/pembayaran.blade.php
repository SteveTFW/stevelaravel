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
                    <h3 class="text-white z-index-1 position-relative">Check Out</h3>
                    <p class="text-white opacity-8 mb-0">Pembayaran transfer menggunakan Midtrans Payment Gateway</p>
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
                                                            Status: <b>{{ $group[0]->status_pembayaran }}</b>
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
                                                                ({{ $item->ukuran }}) - Rp
                                                                {{ number_format($item->harga, 0, ',', '.') }}<br>
                                                            </p>
                                                        @endforeach
                                                    </td>
                                                    <td style="width: 20%;">
                                                    <td>
                                                        <a href="{{ route('show-detail-pesanan', ['id' => $item->id]) }}"
                                                            class="btn btn-info mt-4"
                                                            style="margin-right:40px;">Pembayaran</a>
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
                <p class="text-white">Tidak ada pesanan yang belum dibayar. <a class="text-white fw-bold"
                        href="{{ route('show-semua-pesanan', ['id' => session('user_id')]) }}">Klik disini</a> untuk
                    melihat riwayat pembelian.</p>
            @endif
        </div>
    </section>
@endsection

@push('add-script')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- 
    <script>
        function openModal(itemId) {
            var modalId = '#ubahJumlahModal' + itemId;
            $(modalId).modal('show');
        }

        function confirmUbahJumlah(itemId) {
            var confirmation = confirm("Apakah Anda yakin ingin mengubah jumlah?");
            if (confirmation) {
                // Jika pengguna menekan OK pada konfirmasi
                openModal(itemId);
            } else {
                // Jika pengguna menekan Batal pada konfirmasi
                // Tidak melakukan apa-apa
            }
        }

        function confirmUbah() {
            return confirm('Apakah Anda yakin ingin mengubah jumlah?');
        }

        function setMetodePembayaran(metode) {
            var buttons = document.querySelectorAll('.btn-metode');
            buttons.forEach(function(button) {
                button.classList.remove('selected');
            });

            var selectedButton = document.querySelector('.btn-metode[data-metode="' + metode + '"]');
            if (selectedButton) {
                selectedButton.classList.add('selected');
                document.getElementById('metode_pembayaran').value = metode;

                // Perbarui nilai status_pembayaran
                var statusPembayaran = (metode === 'COD') ? 'Belum Dibayar' : 'Menunggu Pembayaran';
                document.getElementById('status_pembayaran').value = statusPembayaran;

                console.log('Metode Pembayaran:', metode);
                console.log('Status Pembayaran:', statusPembayaran);
            } else {
                console.error('Tombol tidak ditemukan');
            }
        }

        function handleButtonClick() {
            var metode = this.getAttribute('data-metode');
            setMetodePembayaran(metode);
        }

        // Menambahkan event listener ke setiap tombol
        var buttons = document.querySelectorAll('.btn-metode');
        buttons.forEach(function(button) {
            button.addEventListener('click', handleButtonClick);
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Apa pun yang perlu dieksekusi setelah konten dimuat
        });

        function updateCatatanTambahan() {
            var catatanTambahanValue = document.getElementById('catatan_tambahan').value;
            document.getElementById('input_catatan_tambahan').value = catatanTambahanValue;
        }

        // Menambahkan event listener ke textarea
        document.getElementById('catatan_tambahan').addEventListener('input', updateCatatanTambahan);

        function confirmSubmission() {
            var confirmation = confirm("Apakah Anda yakin ingin menyimpan pesanan?");

            if (confirmation) {
                // Jika pengguna menekan OK, kirim formulir
                return true;
            } else {
                // Jika pengguna menekan Cancel, batalkan pengiriman formulir
                return false;
            }
        }
    </script> --}}
@endpush
