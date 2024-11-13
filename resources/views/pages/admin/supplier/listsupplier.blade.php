@extends('layouts.admin')

@section('title')
    Daftar Supplier
@endsection

@section('page')
    Menu Master / Daftar Supplier
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
                            <h5 class="text-white text-capitalize ps-3">Daftar Supplier</h5>
                            <button id="btnTambah" class="btn btn-info mt-3" onclick="showForm()">
                                <i class="fa fa-plus-square fa-lg"></i> <!-- Ikon Font Awesome -->
                            </button>
                        </div>
                    </div>
                    @if ($supplier->count() > 0)
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 text-center" style="min-height:500px; max-height:500px">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Nomor Telepon</th>
                                            <th>Email</th>
                                            <th>Dibuat pada</th>
                                            <th>Diperbarui pada</th>
                                            <th>Aksi Bahan Baku</th>
                                            <th colspan="2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($supplier as $item)
                                            <tr>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->nama }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->alamat }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->nomor_telepon }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->email }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->created_at }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->updated_at }}</p>
                                                </td>
                                                <td>
                                                    <a href="{{ route('list-bahanbaku-supplier', ['id' => $item->id]) }}"
                                                        class="btn btn-info mt-4">
                                                        <i class="fa fa-info-circle fa-lg"></i> <!-- Ikon Font Awesome -->
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('show-ubah-supplier', ['id' => $item->id]) }}"
                                                        class="btn btn-info mt-4">
                                                        <i class="fa fa-pencil-square fa-lg"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('hapus-supplier', $item->id) }}" method="post"
                                                        onsubmit="return confirmDelete()">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger mt-4">
                                                            <i class="fa fa-trash fa-lg"></i>
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
                            <p>Tidak ada supplier yang ditemukan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div id="modalForm" style="display: none;">
        <div class="modal-content">
            <form class="formTambah" action="/admin/sukses/supplier" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">@csrf
                        <h1>Tambah Supplier</h1>
                        <!-- Field-field data supplier di sini -->
                        <label for="nama">Nama Supplier</label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Supplier" required>

                        <label for="alamat">Alamat Supplier</label>
                        <textarea id="alamat" name="alamat" placeholder="Masukkan Alamat Supplier" rows="4" required></textarea>

                        <label for="nomor_telepon">Nomor Telepon</label>
                        <input type="text" id="nomor_telepon" name="nomor_telepon"
                            placeholder="Masukkan Nomor Telepon Supplier" pattern="^[0-9\s\+\(\)\-]+$"
                            title="Format yang valid: 1234, +1234, (1234), (123) 456-7890" required>

                        <label for="email">Email Supplier</label>
                        <input type="email" id="email" name="email" placeholder="Masukkan Email Supplier" required>

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
        document.addEventListener("DOMContentLoaded", function() {
            var btnTambah = document.getElementById('btnTambah');
            var modalForm = document.getElementById('modalForm');
            var formTambahSupplier = document.getElementById('formTambahSupplier');

            btnTambah.addEventListener('click', function() {
                modalForm.style.display = 'block';
            });

            // Menyembunyikan pop-up ketika klik di luar area formulir
            window.addEventListener('click', function(event) {
                if (event.target === modalForm) {
                    modalForm.style.display = 'none';
                }
            });

            formTambahSupplier.addEventListener('submit', function(event) {
                event.preventDefault();

                // Lakukan pengiriman data menggunakan Ajax di sini
                // Contoh menggunakan Fetch API
                fetch('/admin/sukses/supplier', {
                        method: 'POST',
                        body: new FormData(formTambahSupplier),
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
            return confirm('Apakah Anda yakin ingin menghapus supplier ini?');
        }
    </script>
@endpush
