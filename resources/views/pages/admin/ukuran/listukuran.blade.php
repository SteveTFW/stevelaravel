@extends('layouts.admin')

@section('title')
    Daftar Ukuran
@endsection

@section('page')
    Menu Master / Daftar Ukuran
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
        <h1>Daftar Ukuran</h1>
        <button id="btnTambah" class="btn btn-info mt-4" onclick="showForm()">Tambah</button>
    </div>

    @if ($ukuran->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0 text-center">
                            <table class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Dibuat pada</th>
                                        <th>Diperbarui pada</th>
                                        <th colspan="2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ukuran as $item)
                                        <tr>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $item->nama }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $item->created_at }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $item->updated_at }}</p>
                                            </td>
                                            <td>
                                                <a href="{{ route('show-ubah-ukuran', ['id' => $item->id]) }}"
                                                    class="btn btn-info mt-4">Ubah</a>
                                            </td>
                                            <td>
                                                <form action="{{ route('hapus-ukuran', $item->id) }}" method="post"
                                                    onsubmit="return confirmDelete()">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger mt-4">Hapus</button>
                                                </form>
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
        <p>Tidak ada ukuran yang ditemukan.</p>
    @endif

    <div id="modalForm" style="display: none;">
        <div class="modal-content">
            <form class="formTambah" action="/admin/sukses/ukuran" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">@csrf
                        <h1>Tambah Ukuran</h1>
                        <!-- Field-field data ukuran di sini -->
                        <label for="nama">Nama Ukuran</label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Ukuran" required>
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
            var formTambahUkuran = document.getElementById('formTambahUkuran');

            btnTambah.addEventListener('click', function() {
                modalForm.style.display = 'block';
            });

            // Menyembunyikan pop-up ketika klik di luar area formulir
            window.addEventListener('click', function(event) {
                if (event.target === modalForm) {
                    modalForm.style.display = 'none';
                }
            });

            formTambahUkuran.addEventListener('submit', function(event) {
                event.preventDefault();

                // Lakukan pengiriman data menggunakan Ajax di sini
                // Contoh menggunakan Fetch API
                fetch('/sukses/ukuran', {
                        method: 'POST',
                        body: new FormData(formTambahUkuran),
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
            return confirm('Apakah Anda yakin ingin menghapus ukuran ini?');
        }
    </script>
@endpush
