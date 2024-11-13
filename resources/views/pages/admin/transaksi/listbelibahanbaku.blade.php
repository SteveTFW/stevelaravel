@extends('layouts.admin')

@section('title')
    Daftar Pembelian Bahan Baku
@endsection

@section('page')
    Menu Master / Daftar Pembelian Bahan Baku
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
                            <h5 class="text-white text-capitalize ps-3">Daftar Pembelian Bahan Baku</h5>

                            <!-- Tombol menggunakan route() -->
                            <a href="{{ route('tambah-transaksi') }}" id="btnTambah" class="btn btn-info mt-3">
                                <i class="fa fa-plus-square fa-lg"></i>
                            </a>

                        </div>
                    </div>
                    @if (!empty($transaksiGrouped))
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 text-center" style="min-height:500px; max-height:500px">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Kode Transaksi</th>
                                            <th>Penanggung Jawab</th>
                                            <th>Tanggal</th>
                                            <th>Nama Supplier</th>
                                            <th>Grand Total</th>
                                            <th>Status</th>
                                            <th>Cara Pengiriman</th>
                                            <th>Catatan Tambahan</th>
                                            <th>Detail</th>
                                            <th colspan="2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaksiGrouped as $item)
                                            <tr>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item['kode_transaksi'] }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item['user_name'] }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">
                                                        {{ \Carbon\Carbon::parse($item['tanggal'])->locale('id')->translatedFormat('l, d M Y') }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item['nama_supplier'] }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">Rp
                                                        {{ number_format($item['total_harga'], 0, ',', '.') }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item['status'] }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $item['cara_pengiriman'] }}
                                                    </p>
                                                </td>
                                                <td>
                                                    @if (!empty($item['catatan_tambahan']))
                                                        <p class="text-sm font-weight-bold mb-0">
                                                            {{ $item['catatan_tambahan'] }}
                                                        </p>
                                                    @else
                                                        <p class="text-sm font-italic mb-0">
                                                            Tidak ada catatan tambahan!
                                                        </p>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($item['status'] == 'Dibatalkan')
                                                        <a href="{{ route('detail-transaksi', ['id' => $item['id']]) }}"
                                                            class="btn btn-danger mt-4"><i
                                                                class="fa fa-info-circle fa-lg"></i></a>
                                                    @elseif ($item['status'] == 'Menunggu')
                                                        <a href="{{ route('detail-transaksi', ['id' => $item['id']]) }}"
                                                            class="btn btn-info mt-4"><i
                                                                class="fa fa-info-circle fa-lg"></i></a>
                                                    @elseif ($item['status'] == 'Selesai')
                                                        <a href="{{ route('detail-transaksi', ['id' => $item['id']]) }}"
                                                            class="btn btn-success mt-4"><i
                                                                class="fa fa-info-circle fa-lg"></i></a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('show-ubah-transaksi', ['id' => $item['id']]) }}"
                                                        class="btn btn-info mt-4"><i
                                                            class="fa fa-pencil-square fa-lg"></i></a>
                                                </td>
                                                @if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN')
                                                    <td>
                                                        <form
                                                            action="{{ route('hapus-transaksi', ['id' => $item['id']]) }}"
                                                            method="post" onsubmit="return confirmDelete()">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-danger mt-4"><i
                                                                    class="fa fa-trash fa-lg"></i></button>
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
                            <p>Tidak ada transaksi yang ditemukan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('add-script')
    <script>
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');
        }
    </script>
@endpush
