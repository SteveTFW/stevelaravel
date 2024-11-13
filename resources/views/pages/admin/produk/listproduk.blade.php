@extends('layouts.admin')

@section('title')
    Daftar Produk
@endsection

@section('page')
    Menu Master / Daftar Produk
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
                            <h5 class="text-white text-capitalize ps-3">Daftar Produk</h5>
                            <button id="btnTambah" class="btn btn-info mt-3" onclick="showForm()">
                                <i class="fa fa-plus-square fa-lg"></i> <!-- Ikon Font Awesome -->
                            </button>
                        </div>
                    </div>
                    @if ($groupedProduk->count() > 0)
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 text-center" style="min-height:500px; max-height:500px">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Gambar</th>
                                            <th>Deskripsi</th>
                                            <th>Status</th>
                                            <th>Ukuran</th>
                                            <th>Kategori</th>
                                            <th>Atur Ukuran Produk</th>
                                            <th>Atur Bahan Baku Produk</th>
                                            <th colspan="2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($groupedProduk as $id => $group)
                                            <tr>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $group[0]->nama }}</p>
                                                </td>
                                                <td>
                                                    @if ($group[0]->gambar)
                                                        <img src="{{ asset($group[0]->gambar) }}"
                                                            alt="{{ $group[0]->nama }}" class="gambar-produk">
                                                    @else
                                                        <p>Tidak ada gambar</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">
                                                        {{ strlen($group[0]->deskripsi) > 50 ? substr($group[0]->deskripsi, 0, 50) . '...' : $group[0]->deskripsi }}
                                                    </p>
                                                </td>

                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $group[0]->status }}</p>
                                                </td>
                                                <td>
                                                    @foreach ($group as $item)
                                                        <p class="text-sm font-weight-bold mb-0">
                                                            {{ $item->nama_ukuran }} - Rp
                                                            {{ number_format($item->harga_ukuran, 0, ',', '.') }}<br></p>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $group[0]->nama_kategori }}
                                                    </p>
                                                </td>
                                                {{-- <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $group[0]->created_at }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $group[0]->updated_at }}</p>
                                            </td> --}}
                                                <td>
                                                    <button id="btnAturUkuran" class="btn btn-info mt-4"
                                                        onclick="window.location.href='{{ route('ukuran-produk', ['id' => $group[0]->id]) }}'">
                                                        <i class="fa fa-pencil-square fa-lg"></i> <!-- Ikon Font Awesome -->
                                                    </button>
                                                </td>
                                                <td>
                                                    <button id="btnAturUkuran" class="btn btn-info mt-4"
                                                        onclick="window.location.href='{{ route('bahan-baku-produk', ['id' => $group[0]->id]) }}'">
                                                        <i class="fa fa-pencil-square fa-lg"></i> <!-- Ikon Font Awesome -->
                                                    </button>
                                                </td>
                                                <td>
                                                    <a href="{{ route('show-ubah-produk', ['id' => $item->id]) }}"
                                                        class="btn btn-info mt-4">
                                                        <i class="fa fa-pencil-square fa-lg"></i> <!-- Ikon Font Awesome -->
                                                    </a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('hapus-produk', $item->id) }}" method="post"
                                                        onsubmit="return confirmDelete()">
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
                            <p>Tidak ada produk yang ditemukan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div id="modalForm" style="display: none;">
        <div class="modal-content">
            <form class="formTambah" action="/admin/sukses/produk" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">@csrf
                        <h1>Tambah Produk</h1>
                        <!-- Field-field data produk di sini -->
                        <label for="nama">Nama Produk</label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Produk" required>

                        <label for="gambar">Gambar Produk</label>
                        <input type="file" id="gambar" name="gambar" accept="image/*" required>

                        <label for="deskripsi">Deskripsi Produk</label>
                        <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi Produk" rows="4" required></textarea>

                        <label for="kategori">Kategori Produk</label>
                        <select id="kategori" name="kategori" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach ($kategoriOptions as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>

                        <br><br>
                        <!-- ... tambahkan field lainnya sesuai kebutuhan -->
                        <button type="submit" class="btn btn-success" onclick="return konfirmasiSimpan()">Simpan</button>
                    </div>
                </div>
            </form>
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

        function redirectToEditPage(id) {
            // Buat URL berdasarkan ID produk
            var editUrl = '/ubahproduk/' + id;

            // Arahkan pengguna ke halaman edit
            window.location.href = editUrl;
        }

        document.addEventListener("DOMContentLoaded", function() {
            var btnTambah = document.getElementById('btnTambah');
            var modalForm = document.getElementById('modalForm');
            var formTambahProduk = document.getElementById('formTambahProduk');
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

            formTambahProduk.addEventListener('submit', function(event) {
                event.preventDefault();

                // Lakukan pengiriman data menggunakan Ajax di sini
                // Contoh menggunakan Fetch API
                fetch('/admin/sukses/produk', {
                        method: 'POST',
                        body: new FormData(formTambahProduk),
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
            return confirm('Apakah Anda yakin ingin menghapus produk ini?');
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
