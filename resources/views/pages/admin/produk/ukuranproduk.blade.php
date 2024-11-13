@extends('layouts.admin')

@section('title')
    Ukuran Produk
@endsection

@section('page')
    Menu Master / Daftar Produk / Ukuran Produk
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
                            <h5 class="text-white text-capitalize ps-3">Ukuran Produk {{ $produk->nama }}</h5>
                            <button id="btnTambah" class="btn btn-info mt-3" onclick="showForm()">
                                <i class="fa fa-plus-square fa-lg"></i> <!-- Ikon Font Awesome -->
                            </button>
                        </div>
                    </div>
                    @if ($ukuranProduk->count() > 0)
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 text-center" style="min-height:425px; max-height:425px">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Ukuran</th>
                                            <th>Deskripsi</th>
                                            <th>Harga</th>
                                            <th>Dibuat pada</th>
                                            <th>Diperbarui pada</th>
                                            <th colspan="2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ukuranProduk as $item)
                                            <tr>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->ukuran }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->deskripsi }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">Rp
                                                        {{ number_format($item->harga, 0, ',', '.') }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->created_at }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->updated_at }}</p>
                                                </td>
                                                <td>
                                                    <a href="{{ route('ubah-ukuran-produk', $item->id) }}"
                                                        class="btn btn-info mt-4">
                                                        <i class="fa fa-pencil-square fa-lg"></i> <!-- Ikon Font Awesome -->
                                                    </a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('hapus-ukuran-produk', $item->id) }}"
                                                        method="post" onsubmit="return confirmDelete()">
                                                        @csrf
                                                        @method('delete')
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
                            <p>Produk belum dicatat ukurannya.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div id="modalForm" style="display: none;">
        <div class="modal-content">
            <form class="formTambah" action="/admin/sukses/ukuranproduk" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">@csrf
                        <h1>Tambah Ukuran Produk</h1>
                        <h6 class="mb-4">{{ $produk->nama }}</h6>
                        <input type="hidden" id="produk_id" name="produk_id" value="{{ $produk->id }}">

                        <label for="ukuran">Ukuran Produk</label>
                        <select id="ukuran" name="ukuran" required>
                            <option value="" disabled selected>Pilih Ukuran</option>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                            <option value="3XL">3XL</option>
                            <option value="4XL">4XL</option>
                            <option value="5XL">5XL</option>
                            <option value="All Size">All Size
                            </option>
                        </select>

                        <label for="harga">Harga Produk</label>
                        <input type="number" id="harga" name="harga" placeholder="Masukkan Harga Produk" required>

                        <label for="deskripsi">Deskripsi Produk</label>
                        <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi Produk" rows="4" required></textarea>

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
            return confirm('Apakah Anda yakin ingin menghapus ukuran produk ini?');
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
