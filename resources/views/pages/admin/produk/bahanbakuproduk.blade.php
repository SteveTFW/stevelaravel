@extends('layouts.admin')

@section('title')
    Bahan Baku Produk
@endsection

@section('page')
    Menu Master / Daftar Produk / Bahan Baku Produk
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
        <a href="{{ route('list-produk') }}" class="btn btn-info">
            <i class="fa fa-arrow-left fa-lg"></i> <!-- Ikon Font Awesome -->
        </a>
    </div>


    <div class="container-fluid py-0">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-0">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h5 class="text-white text-capitalize ps-3">Bahan Baku {{ $produk->nama }}</h5>
                            <button id="btnTambah" class="btn btn-info mt-3" onclick="showForm()">
                                <i class="fa fa-plus-square fa-lg"></i> <!-- Ikon Font Awesome -->
                            </button>
                        </div>
                    </div>
                    @if ($bahanbakuProduk->count() > 0)
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 text-center" style="min-height:425px; max-height:425px">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Bahan Baku</th>
                                            <th>Jumlah</th>
                                            <th>Dibuat pada</th>
                                            <th>Diperbarui pada</th>
                                            <th colspan="2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bahanbakuProduk as $item)
                                            <tr>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->bahan_baku_nama }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->jumlah }}
                                                        {{ $item->jenis_satuan }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->created_at }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->updated_at }}</p>
                                                </td>
                                                <td>
                                                    <a href="{{ route('ubah-bahanbaku-produk', ['produkId' => $item->produk_id, 'bahanBakuId' => $item->bahan_baku_id]) }}"
                                                        class="btn btn-info mt-4">
                                                        <i class="fa fa-pencil-square fa-lg"></i> <!-- Ikon Font Awesome -->
                                                    </a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('hapus-bahanbaku-produk') }}" method="post"
                                                        onsubmit="return confirmDelete()">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="produk_id"
                                                            value="{{ $item->produk_id }}">
                                                        <input type="hidden" name="bahan_baku_id"
                                                            value="{{ $item->bahan_baku_id }}">
                                                        <button type="submit" class="btn btn-danger mt-4">
                                                            <i class="fa fa-trash fa-lg"></i> <!-- Ikon Font Awesome -->
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <br>
                        <div class="container-fluid py-0">
                            <p>Produk belum dicatat bahan bakunya.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="modalForm" style="display: none;">
        <div class="modal-content">
            <form class="formTambah" action="/admin/sukses/bahanbakuproduk" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        <h1>Tambah Bahan Baku Produk</h1>
                        <h6 class="mb-4">{{ $produk->nama }}</h6>
                        <input type="hidden" id="produk_id" name="produk_id" value="{{ $produk->id }}">

                        <label for="bahan_baku_id">Bahan Baku</label>
                        <select id="bahan_baku_id" name="bahan_baku_id" required>
                            <option value="" disabled selected>Pilih Bahan Baku</option>
                            @foreach ($bahanbakuOptions as $bahanbaku)
                                <option value="{{ $bahanbaku->id }}">{{ $bahanbaku->nama }}</option>
                            @endforeach
                        </select>

                        <label for="jumlah">Jumlah Bahan Baku</label>
                        <input type="number" id="jumlah" name="jumlah"
                            placeholder="Masukkan Jumlah Bahan Baku untuk Produk" required>

                        <br><br>
                        <!-- ... tambahkan field lainnya sesuai kebutuhan -->
                        <button type="submit" class="btn btn-success" onclick="return konfirmasiSimpan()">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- <a href="{{ route('list-produk') }}" class="btn btn-info">Kembali</a> --}}
@endsection

@push('add-script')
    <script>
        function showForm() {
            // Logika Anda untuk menampilkan formulir
            // Menunjukkan modal atau mengatur properti CSS untuk menampilkannya
            var modalForm = document.getElementById('modalForm');
            var produkIdInput = document.getElementById('produk_id');

            // Mengatur nilai produk_id
            produkIdInput.value = '{{ $produk->id }}';

            modalForm.style.display = 'block';
        }

        function redirectToEditPage(id) {
            // Buat URL berdasarkan ID produk
            var editUrl = '/ubahproduk/' + id;

            // Arahkan pengguna ke halaman edit
            window.location.href = editUrl;
        }

        document.addEventListener("DOMContentLoaded", function() {
            var btnTambah = document.getElementById('btnTambah');
            var modalForm = document.getElementById('modalForm');
            var formTambahUkuranProduk = document.getElementById('formTambahUkuran');
            var btnUbah = document.getElementById('btnUbah'); // Ganti dengan ID tombol Ubah Anda

            btnTambah.addEventListener('click', function() {
                modalForm.style.display = 'block';
            });

            btnUbah.addEventListener('click', function() {
                // Logika ubah data
                var selectedId =
                    getSelectedProductId(); // Ganti dengan logika Anda untuk mendapatkan ID produk yang dipilih
                redirectToEditPage(selectedId);
            });

            // Menyembunyikan pop-up ketika klik di luar area formulir
            window.addEventListener('click', function(event) {
                if (event.target === modalForm) {
                    modalForm.style.display = 'none';
                }
            });

            formTambahUkuranProduk.addEventListener('submit', function(event) {
                event.preventDefault();

                // Lakukan pengiriman data menggunakan Ajax di sini
                // Contoh menggunakan Fetch API
                fetch('/admin/sukses/ukuranproduk', {
                        method: 'POST',
                        body: new FormData(formTambahUkuranProduk),
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

        function konfirmasiSimpan() {
            var konfirmasi = confirm("Apakah Anda yakin ingin menyimpan data?");

            // Jika pengguna menekan OK pada konfirmasi
            if (konfirmasi) {
                // Lanjutkan dengan penyimpanan data
                return true;
            } else {
                // Batal penyimpanan data
                return false;
            }
        }

        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus bahan baku pada produk ini?');
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
    </script>
@endpush
