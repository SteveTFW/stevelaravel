@extends('layouts.admin')

@section('title')
    Bahan Baku Supplier
@endsection

@section('page')
    Menu Master / Daftar Supplier / Bahan Baku Supplier
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

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible text-white" role="alert">
            <span class="text-sm">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </span>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="title-container">
        <a href="{{ route('list-supplier') }}" class="btn btn-info">
            <i class="fa fa-arrow-left fa-lg"></i> <!-- Ikon Font Awesome -->
        </a>
    </div>

    <div class="container-fluid py-0">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-0">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h5 class="text-white text-capitalize ps-3">Daftar Bahan Baku Supplier
                                {{ $supplier->nama }}</h5>
                            <button id="btnTambah" class="btn btn-info mt-3" onclick="showForm()">
                                <i class="fa fa-plus-square fa-lg"></i> <!-- Ikon Font Awesome -->
                            </button>
                        </div>
                    </div>
                    @if ($bahanbakuSupplier->count() > 0)
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 text-center" style="min-height:425px; max-height:425px">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Bahan Baku</th>
                                            <th>Dibuat pada</th>
                                            <th>Diperbarui pada</th>
                                            <th colspan="2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bahanbakuSupplier as $item)
                                            <tr>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->bahan_baku_nama }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->created_at }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->updated_at }}</p>
                                                </td>
                                                <td>
                                                    <form action="{{ route('hapus-bahanbaku-supplier') }}" method="post"
                                                        onsubmit="return confirmDelete()">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="id_supplier"
                                                            value="{{ $item->id_supplier }}">
                                                        <input type="hidden" name="bahan_baku" value="{{ $item->id_bahan_baku }}">
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
                            <p>Data bahan baku supplier masih kosong.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="modalForm" style="display: none;">
        <div class="modal-content">
            <form class="formTambah" action="/admin/sukses/bahan-baku-supplier" method="POST"
                enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">@csrf
                        <h1>Tambah Bahan Baku</h1>

                        <!-- Input hidden untuk id_supplier -->
                        <input type="hidden" id="id_supplier" name="id_supplier" value="{{ $supplier->id }}">

                        <label for="bahan_baku">Bahan Baku</label>
                        <select id="bahan_baku" name="bahan_baku" required>
                            <option value="" disabled selected>Pilih Bahan Baku</option>
                            @foreach ($bahanBaku as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
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
                fetch('/admin/sukses/bahan-baku-supplier', {
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
            return confirm('Apakah Anda yakin ingin menghapus data bahan baku pada supplier ini?');
        }
    </script>
@endpush
