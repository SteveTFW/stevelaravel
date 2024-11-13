@extends('layouts.admin')

@section('title')
    Daftar Bahan Baku
@endsection

@section('page')
    Menu Master / Daftar Bahan Baku
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
                            <h5 class="text-white text-capitalize ps-3">Daftar Bahan Baku</h5>
                            <button id="btnTambah" class="btn btn-info mt-3" onclick="showForm()">
                                <i class="fa fa-plus-square fa-lg"></i> <!-- Ikon Font Awesome -->
                            </button>
                        </div>
                    </div>
                    @if ($bahanbaku->count() > 0)
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 text-center" style="min-height:500px; max-height:500px">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Jenis Satuan</th>
                                            <th>Dibuat pada</th>
                                            <th>Diperbarui pada</th>
                                            <th colspan="2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bahanbaku as $item)
                                            <tr>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->nama }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->jenis_satuan }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->created_at }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->updated_at }}</p>
                                                </td>
                                                <td>
                                                    <a href="{{ route('show-ubah-bahanbaku', ['id' => $item->id]) }}"
                                                        class="btn btn-info mt-4">
                                                        <i class="fa fa-pencil-square fa-lg"></i> <!-- Ikon Font Awesome -->
                                                    </a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('hapus-bahanbaku', $item->id) }}" method="post"
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
                            <p>Tidak ada bahan baku yang ditemukan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div id="modalForm" style="display: none;">
        <div class="modal-content">
            <form class="formTambah" action="/admin/sukses/bahanbaku" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">@csrf
                        <h1>Tambah Bahan Baku</h1>
                        <!-- Field-field data bahan baku di sini -->
                        <label for="nama">Nama Bahan Baku</label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Bahan Baku" required>

                        <label for="jenis_satuan">Satuan</label>
                        <select id="jenis_satuan" name="jenis_satuan" required>
                            <option value="" disabled selected>Silahkan pilih jenis satuan</option>
                            @foreach (['Unit', 'Kilogram (kg)', 'Gram (g)', 'Liter (L)', 'Mililiter (mL)', 'Meter (m)', 'Sentimeter (cm)', 'Buah (pcs)', 'Gulung (roll)', 'Meter Persegi (m^2)', 'Meter Kubik (m^3)', 'Ton'] as $jenis_satuan)
                                <option value="{{ $jenis_satuan }}">{{ $jenis_satuan }}</option>
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
        document.addEventListener("DOMContentLoaded", function() {
            var btnTambah = document.getElementById('btnTambah');
            var modalForm = document.getElementById('modalForm');
            var formTambahBahanBaku = document.getElementById('formTambahBahanBaku');

            btnTambah.addEventListener('click', function() {
                modalForm.style.display = 'block';
            });

            // Menyembunyikan pop-up ketika klik di luar area formulir
            window.addEventListener('click', function(event) {
                if (event.target === modalForm) {
                    modalForm.style.display = 'none';
                }
            });

            formTambahBahanBaku.addEventListener('submit', function(event) {
                event.preventDefault();

                // Lakukan pengiriman data menggunakan Ajax di sini
                // Contoh menggunakan Fetch API
                fetch('/admin/sukses/bahanbaku', {
                        method: 'POST',
                        body: new FormData(formTambahBahanBaku),
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
            return confirm('Apakah Anda yakin ingin menghapus bahan baku ini?');
        }
    </script>
@endpush
