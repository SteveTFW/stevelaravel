@extends('layouts.admin')

@section('title')
    Halaman Produksi
@endsection

@section('page')
    Menu Produksi / Halaman Produksi
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
                            <h5 class="text-white text-capitalize ps-3">Halaman Produksi</h5>
                        </div>
                    </div>
                    @if ($produksi->count() > 0)
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 text-center" style="min-height:500px; max-height:500px">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Pesanan</th>
                                            <th>Produk</th>
                                            <th>Penanggung Jawab</th>
                                            <th>Estimasi</th>
                                            <th>Durasi</th>
                                            <th>Status</th>
                                            <th colspan="2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($produksi as $item)
                                            @if ($loop->first || $item->pesanan_id != $produksi[$loop->index - 1]->pesanan_id)
                                                <tr>
                                                    <td>
                                                        <p class="text-sm font-weight-bold mb-0">{{ $item->kode }}</p>
                                                    </td>
                                                    <td>

                                                        @foreach ($produksi as $produk)
                                                            @if ($produk->pesanan_id == $item->pesanan_id)
                                                                <li class="text-sm font-weight-bold mb-0">
                                                                    {{ $produk->jumlah }}x {{ $produk->nama_produk }}
                                                                    ({{ $produk->ukuran }})
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <p class="text-sm font-weight-bold mb-0">{{ $item->nama_user }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-sm font-weight-bold mb-0"
                                                            id="estimasi{{ $item->pesanan_id }}"></p>
                                                    </td>
                                                    <td>
                                                        <p class="text-sm font-weight-bold mb-0"
                                                            id="waktuProduksi{{ $item->pesanan_id }}">
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="text-sm font-weight-bold mb-0">{{ $item->status }}</p>
                                                    </td>
                                                    <td>
                                                        @if ($item->status == 'Sedang Berjalan')
                                                            <a href="{{ route('detail-produksi', ['id' => $item->pesanan_id]) }}"
                                                                class="btn btn-info mt-4">
                                                                <i class="fa fa-info fa-lg"></i> <!-- Ikon Font Awesome -->
                                                            </a>
                                                        @elseif ($item->status == 'Selesai')
                                                            <a href="{{ route('detail-produksi', ['id' => $item->pesanan_id]) }}"
                                                                class="btn btn-success mt-4">
                                                                <i class="fa fa-info fa-lg"></i> <!-- Ikon Font Awesome -->
                                                            </a>
                                                        @elseif ($item->status == 'Batal')
                                                            <a href="{{ route('detail-produksi', ['id' => $item->pesanan_id]) }}"
                                                                class="btn btn-danger mt-4">
                                                                <i class="fa fa-info fa-lg"></i> <!-- Ikon Font Awesome -->
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <script>
                                                    var estimasi{{ $item->pesanan_id }} = new Date("{{ $item->estimasi }}").getTime();
                                                    var mulai{{ $item->pesanan_id }} = new Date("{{ $item->mulai }}").getTime();

                                                    function updateEstimasi{{ $item->pesanan_id }}() {
                                                        var now = new Date().getTime();
                                                        var selisihEstimasi = estimasi{{ $item->pesanan_id }} - now;

                                                        if (selisihEstimasi <= 0) {
                                                            var elemEstimasi = document.getElementById("estimasi{{ $item->pesanan_id }}");
                                                            elemEstimasi.innerHTML = "Waktu Produksi Melebihi Estimasi";
                                                            elemEstimasi.style.color = "red"; // atau gunakan kode warna merah yang sesuai
                                                        } else {
                                                            var jam = Math.floor(selisihEstimasi / (1000 * 60 * 60));
                                                            var menit = Math.floor((selisihEstimasi % (1000 * 60 * 60)) / (1000 * 60));
                                                            var detik = Math.floor((selisihEstimasi % (1000 * 60)) / 1000);

                                                            document.getElementById("estimasi{{ $item->pesanan_id }}").innerHTML = jam + " jam " + menit + " menit " +
                                                                detik + " detik ";
                                                        }
                                                    }

                                                    function updateWaktuProduksi{{ $item->pesanan_id }}() {
                                                        var now = new Date().getTime();
                                                        var selisihWaktu = now - mulai{{ $item->pesanan_id }};

                                                        var jam = Math.floor(selisihWaktu / (1000 * 60 * 60));
                                                        var menit = Math.floor((selisihWaktu % (1000 * 60 * 60)) / (1000 * 60));
                                                        var detik = Math.floor((selisihWaktu % (1000 * 60)) / 1000);

                                                        document.getElementById("waktuProduksi{{ $item->pesanan_id }}").innerHTML = jam + " jam " + menit + " menit " +
                                                            detik + " detik ";
                                                    }

                                                    setInterval(updateEstimasi{{ $item->pesanan_id }}, 1000);
                                                    setInterval(updateWaktuProduksi{{ $item->pesanan_id }}, 1000);

                                                    updateEstimasi{{ $item->pesanan_id }}(); // Jalankan fungsi saat halaman dimuat
                                                    updateWaktuProduksi{{ $item->pesanan_id }}(); // Jalankan fungsi saat halaman dimuat
                                                </script>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                    <br>
                        <div class="container-fluid py-0">
                            <p>Tidak ada kegiatan produksi yang sedang berjalan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
