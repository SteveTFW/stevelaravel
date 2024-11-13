@extends('layouts.admin')

@section('title')
    Daftar Pesanan
@endsection

@section('page')
    Menu Pembelanjaan / Daftar Pesanan
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
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-0">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h5 class="text-white text-capitalize ps-3">Daftar Pesanan</h5>
                        </div>
                    </div>
                    @if ($pesanan->count() > 0)
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 text-center" style="min-height:500px; max-height:500px">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Pelanggan</th>
                                            <th>Kode</th>
                                            <th>Tanggal</th>
                                            <th>Total Harga</th>
                                            <th>Status Pembayaran</th>
                                            <th>Status</th>
                                            <th colspan="3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pesanan as $item)
                                            <tr>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->user_name }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->kode }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">
                                                        {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d M Y') }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">Rp
                                                        {{ number_format($item->total_harga, 0, ',', '.') }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->status_pembayaran }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->status }}</p>
                                                </td>
                                                <td>
                                                    @if ($item->status == 'Dibatalkan' || $item->status == 'Ditolak')
                                                        <a href="{{ route('detail-pesanan', ['id' => $item->id]) }}"
                                                            class="btn btn-danger mt-4">
                                                            <i class="fa fa-info-circle fa-lg"></i>
                                                        </a>
                                                    @elseif (
                                                        $item->status == 'Menunggu Konfirmasi' ||
                                                            $item->status == 'Menunggu' ||
                                                            $item->status == 'Sedang Produksi' ||
                                                            $item->status == 'Selesai Produksi' ||
                                                            $item->status == 'Pengiriman' ||
                                                            $item->status == 'Dikonfirmasi')
                                                        <a href="{{ route('detail-pesanan', ['id' => $item->id]) }}"
                                                            class="btn btn-warning mt-4">
                                                            <i class="fa fa-info-circle fa-lg"></i>
                                                        </a>
                                                    @elseif ($item->status == 'Selesai')
                                                        <a href="{{ route('detail-pesanan', ['id' => $item->id]) }}"
                                                            class="btn btn-success mt-4">
                                                            <i class="fa fa-info-circle fa-lg"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                @if (Session::has('nama_peran_admin') &&
                                                        (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ'))
                                                    <td>
                                                        <a href="{{ route('show-ubah-pesanan', ['id' => $item->id]) }}"
                                                            class="btn btn-info mt-4">
                                                            <i class="fa fa-pencil-square fa-lg"></i>
                                                            <!-- Ikon Font Awesome -->
                                                        </a>
                                                    </td>
                                                @endif
                                                @if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN')
                                                    <td>
                                                        <form action="{{ route('hapus-pesanan', $item->id) }}"
                                                            method="post" onsubmit="return confirmDelete()">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-danger mt-4">
                                                                <i class="fa fa-trash fa-lg"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <br>
                        <div class="container-fluid py-0">
                            <p>Tidak ada pesanan yang ditemukan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    {{-- <div id="modalForm" style="display: none;">
        <div class="modal-content">
            <form class="formTambah" action="/sukses/pesanan" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">@csrf
                        <h1>Tambah Pesanan</h1>
                        <!-- Field-field data pesanan di sini -->
                        <label for="nama">Nama Pesanan</label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Pesanan" required>

                        <label for="deskripsi">Deskripsi Pesanan</label>
                        <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi Pesanan" rows="4" required></textarea>

                        <br><br>
                        <!-- ... tambahkan field lainnya sesuai kebutuhan -->
                        <button type="submit" class="btn btn-success" onclick="return konfirmasiSimpan()">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}
@endsection

@push('add-script')
    <script>
        // function showForm() {
        //     // Logika Anda untuk menampilkan formulir
        //     // Menunjukkan modal atau mengatur properti CSS untuk menampilkannya
        //     var modalForm = document.getElementById('modalForm');
        //     modalForm.style.display = 'block';
        // }
        // document.addEventListener("DOMContentLoaded", function() {
        //     var btnTambah = document.getElementById('btnTambah');
        //     var modalForm = document.getElementById('modalForm');
        //     var formTambahPesanan = document.getElementById('formTambahPesanan');

        //     btnTambah.addEventListener('click', function() {
        //         modalForm.style.display = 'block';
        //     });

        //     // Menyembunyikan pop-up ketika klik di luar area formulir
        //     window.addEventListener('click', function(event) {
        //         if (event.target === modalForm) {
        //             modalForm.style.display = 'none';
        //         }
        //     });

        //     formTambahPesanan.addEventListener('submit', function(event) {
        //         event.preventDefault();

        //         // Lakukan pengiriman data menggunakan Ajax di sini
        //         // Contoh menggunakan Fetch API
        //         fetch('/sukses/pesanan', {
        //                 method: 'POST',
        //                 body: new FormData(formTambahPesanan),
        //             })
        //             .then(response => response.json())
        //             .then(data => {
        //                 console.log(data); // Tampilkan respons dari server
        //                 alert(data.message);
        //                 if (data.success) {
        //                     modalForm.style.display = 'none';
        //                     window.location.reload(true);
        //                 }
        //             })
        //             .catch(error => {
        //                 console.error('Error:', error);
        //                 alert('Terjadi kesalahan saat mengolah permintaan.');
        //             });
        //     });
        // });

        // function konfirmasiSimpan() {
        //     var konfirmasi = confirm("Apakah Anda yakin ingin menyimpan data?");

        //     // Jika pengguna menekan OK pada konfirmasi
        //     if (konfirmasi) {
        //         // Lanjutkan dengan penyimpanan data
        //         return true;
        //     } else {
        //         // Batal penyimpanan data
        //         return false;
        //     }
        // }
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');
        }
    </script>
@endpush
