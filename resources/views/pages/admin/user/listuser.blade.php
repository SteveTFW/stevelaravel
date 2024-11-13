@extends('layouts.admin')

@section('title')
    Daftar User
@endsection

@section('page')
    Menu Master / Daftar User
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
                            <h5 class="text-white text-capitalize ps-3">Daftar User</h5>
                        </div>
                    </div>
                    @if ($user->count() > 0)
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 text-center" style="min-height:500px; max-height:500px">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Gambar</th>
                                            <th>Alamat</th>
                                            <th>Peran</th>
                                            <th>Nomor Telepon</th>
                                            <th>Email</th>
                                            <th>Tanggal Bergabung</th>
                                            <th>Dibuat pada</th>
                                            <th>Diubah pada</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $item)
                                            <tr>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->nama }}</p>
                                                </td>
                                                <td>
                                                    @if ($item->gambar)
                                                        <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama }}"
                                                            class="gambar-user">
                                                    @else
                                                        <p>Tidak ada gambar</p>
                                                    @endif
                                                </td>
                                                @if ($item->nomor_telepon == '')
                                                    <td>
                                                        <p class="text-sm mb-0">Pengguna belum mengisi alamat!</p>
                                                    </td>
                                                @else
                                                    <td>
                                                        <p class="text-sm font-weight-bold mb-0">{{ $item->alamat }}</p>
                                                    </td>
                                                @endif
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->nama_peran }}</p>
                                                </td>
                                                @if ($item->nomor_telepon == '')
                                                    <td>
                                                        <p class="text-sm mb-0">Pengguna belum mengisi nomor telepon!</p>
                                                    </td>
                                                @else
                                                    <td>
                                                        <p class="text-sm font-weight-bold mb-0">{{ $item->nomor_telepon }}
                                                        </p>
                                                    </td>
                                                @endif
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->email }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->tanggal_bergabung }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->created_at }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item->updated_at }}</p>
                                                </td>
                                                <td>
                                                    <!-- Kondisi untuk menentukan apakah harus menampilkan tombol hapus -->
                                                    @if ($item->kode_peran != 'ADMN')
                                                        <form action="{{ route('hapus-user', $item->id) }}" method="post"
                                                            onsubmit="return confirmDelete()">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-danger mt-4">
                                                                <i class="fa fa-trash fa-lg"></i> <!-- Ikon Font Awesome -->
                                                            </button>
                                                        </form>
                                                    @endif
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
                            <p>Tidak ada user yang ditemukan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    {{-- <div id="modalForm" style="display: none;">
        <div class="modal-content">
            <form class="formTambah" action="/sukses/bahanbaku" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">@csrf
                        <h1>Tambah Bahan Baku</h1>
                        <!-- Field-field data kategori di sini -->
                        <label for="nama">Nama Bahan Baku</label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Kategori" required>

                        <label for="deskripsi">Deskripsi Bahan</label>
                        <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi Kategori" rows="4" required></textarea>

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
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus user ini?');
        }
    </script>
@endpush
