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
                    <h3 class="text-white z-index-1 position-relative">Keranjang</h3>
                    <p class="text-white opacity-8 mb-0">Pastikan pesanan Anda telah sesuai</p>
                </div>
            </div>
            @if ($keranjang->count() > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0 text-center">
                                    <table class="table align-items-center justify-content-center mb-0">
                                        <tbody>
                                            @php
                                                $totalHargaKeseluruhan = 0;
                                            @endphp
                                            @foreach ($keranjang as $item)
                                                <tr>
                                                    <td style="width: 10%; text-align: left;">
                                                        <!-- Atur lebar sesuai kebutuhan Anda -->
                                                        <!-- Gambar -->
                                                        <img src="{{ asset($item->gambar) }}" alt="Gambar"
                                                            class="gambar-produk" width="100%" style="margin-left: 10px;">
                                                    </td>
                                                    <td style="width: 27.5%; text-align: left;">
                                                        <!-- Atur lebar sesuai kebutuhan Anda -->
                                                        <!-- Nama, Jumlah, dan Harga per Barang -->
                                                        <p class="text-lg font-weight-bold mb-0"
                                                            style="margin-bottom: 0; margin-left: 10px;">
                                                            {{ $item->nama }} ({{ $item->ukuran }})
                                                        </p>
                                                        <p class="text-lg mb-0"
                                                            style="margin-bottom: 0; margin-left: 10px;">Jumlah:
                                                            {{ $item->jumlah }}
                                                        </p>
                                                        <p class="text-lg mb-0"
                                                            style="margin-bottom: 0; margin-left: 10px;">Harga per Satuan:
                                                            Rp
                                                            {{ number_format($item->harga, 0, ',', '.') }}</p>
                                                    </td>

                                                    <td style="width: 27.5%; text-align: center;">
                                                        <form action="{{ route('simpan-catatan') }}" method="POST"
                                                            style="display: inline;">
                                                            @csrf
                                                            <textarea name="catatan" id="catatan_{{ $item->produk_ukuran_id }}"
                                                                placeholder="Silahkan berikan detail pada produk (opsional)" rows="2" style="width: 100%;">{{ $item->catatan }}</textarea>
                                                            <input type="hidden" name="produk_ukuran_id"
                                                                value="{{ $item->produk_ukuran_id }}">
                                                            <br>
                                                            <button type="submit" class="btn btn-primary mt-2">Simpan
                                                                Catatan</button>
                                                        </form>
                                                    </td>


                                                    <td style="width: 15%; text-align: right;">
                                                        <!-- Atur lebar sesuai kebutuhan Anda -->
                                                        <!-- Total Harga -->
                                                        <p class="text-lg font-weight-bold mb-0"
                                                            style="margin-bottom: 0; margin-right: 10px;">Rp
                                                            {{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}
                                                        </p>
                                                        @php
                                                            $totalHargaKeseluruhan += $item->jumlah * $item->harga;
                                                        @endphp
                                                    </td>
                                                    <td style="width: 10%;">
                                                        <button type="button" class="btn btn-info mt-4"
                                                            onclick="openModal('{{ $item->produk_ukuran_id }}')">Ubah
                                                            Jumlah</button>
                                                        <!-- Modal -->
                                                        <div class="modal fade"
                                                            id="ubahJumlahModal{{ $item->produk_ukuran_id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="ubahJumlahModalLabel{{ $item->produk_ukuran_id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="ubahJumlahModalLabel{{ $item->produk_ukuran_id }}">
                                                                            Ubah
                                                                            Jumlah Barang</h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Form untuk mengubah jumlah -->
                                                                        <form action="{{ route('ubah-jumlah-barang') }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('put')
                                                                            <input type="hidden" name="produk_ukuran_id"
                                                                                value="{{ $item->produk_ukuran_id }}">
                                                                            <label for="jumlah">Jumlah:</label>
                                                                            <input type="number" name="jumlah"
                                                                                value="{{ $item->jumlah }}" min="1"
                                                                                required>
                                                                            <button type="submit"
                                                                                class="btn btn-primary mt-3"
                                                                                onclick="confirmUbah()">Ubah</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Modal -->
                                                    </td>
                                                    <td style="width: 10%;">
                                                        <form action="{{ route('hapus-dari-keranjang') }}" method="post"
                                                            onsubmit="return confirmDelete()">
                                                            @csrf
                                                            @method('delete')
                                                            <input type="hidden" name="produk_ukuran_id"
                                                                value="{{ $item->produk_ukuran_id }}">
                                                            <button type="submit" class="btn btn-danger mt-4"
                                                                style="background-color: #dc3545; border: none; padding: 3px 13px; border-radius: 50%; color: #fff; font-size: 20px;">X</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="6" style="text-align: center;">
                                                    <h5>Metode Pembayaran:</h5>
                                                    <button type="button" class="btn btn-primary btn-metode"
                                                        data-metode="COD" onclick="setMetodePembayaran('COD')">Bayar
                                                        COD</button>
                                                    <button type="button" class="btn btn-primary btn-metode"
                                                        data-metode="Transfer"
                                                        onclick="setMetodePembayaran('Transfer')">Transfer</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="text-end">
                            <h3 class="text-white font-weight-bold mb-0">Total Harga: Rp
                                {{ number_format($totalHargaKeseluruhan, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Button Submit -->
                <div class="row">
                    <div class="col-12 mt-4">
                        <form action="{{ route('simpan-ke-pesanan') }}" method="POST"
                            onsubmit="return confirmSubmission()">
                            @csrf
                            <input type="hidden" name="total_harga" value="{{ $totalHargaKeseluruhan }}">
                            <input type="hidden" name="metode_pembayaran" id="metode_pembayaran" value="COD">
                            <input type="hidden" name="catatan_tambahan" id="input_catatan_tambahan" value="">
                            <input type="hidden" name="status_pembayaran" id="status_pembayaran"
                                value="Menunggu Pembayaran">

                            <button type="submit" class="btn btn-primary" style="width: 100%">Submit Pesanan</button>
                        </form>
                    </div>
                </div>
            @else
                <p class="text-white">Anda belum melakukan pemesanan produk. <a class="text-white fw-bold"
                        href="{{ route('halaman-produk') }}">Klik disini</a> untuk
                    melakukan pemesanan.</p>
            @endif
        </div>
    </section>
@endsection

@push('add-script')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
                // var statusPembayaran = (metode === 'COD') ? 'Belum Dibayar' : 'Menunggu Pembayaran';
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

        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?');
        }
    </script>
@endpush
