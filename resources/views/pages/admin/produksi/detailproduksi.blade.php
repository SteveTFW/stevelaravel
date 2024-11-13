@extends('layouts.admin')

@section('title')
    Detail Produksi
@endsection

@section('page')
    Menu Produksi / Daftar Produksi / Detail Produksi
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
        <button class="btn btn-info" onclick="window.history.back();">
            <i class="fa fa-arrow-left fa-lg"></i> <!-- Ikon Font Awesome -->
        </button>
    </div>


    @if ($produksi->count() > 0)
        <div class="row mb-4">
            <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Produksi Pesanan {{ $produksi->first()->kode }}</h6>
                                <p class="text-sm mb-0">
                                    @if ($produksi->first()->status == 'Selesai')
                                        <i class="fa fa-check text-success" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Status:</span> {{ $produksi->first()->status }}
                                    @elseif ($produksi->first()->status == 'Sedang Berjalan')
                                        <i class="fa fa-clock-o text-info" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Status:</span> {{ $produksi->first()->status }}
                                    @else
                                        <i class="fa fa-times-circle text-danger" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">Status:</span> {{ $produksi->first()->status }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Barang</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Kuantitas</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Harga per Satuan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalHargaKeseluruhan = 0;
                                    @endphp
                                    @foreach ($produksi as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset($item->gambar_produk) }}"
                                                            style="width: 50px; margin-right: 10px;">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $item->nama_produk }}
                                                            ({{ $item->ukuran_produk }})
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold">{{ $item->jumlah }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold">Rp
                                                    {{ number_format($item->harga_produk, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold">Rp
                                                    {{ number_format($item->jumlah * $item->harga_produk, 0, ',', '.') }}</span>
                                            </td>
                                            @php
                                                $totalHargaKeseluruhan += $item->jumlah * $item->harga_produk;
                                            @endphp
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6>Detail Produksi</h6><br>
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Penanggung Jawab:</span> {{ $produksi->first()->nama_user }}
                        </p>
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Tanggal produksi:</span>
                            {{ \Carbon\Carbon::parse($produksi->first()->mulai)->locale('id')->translatedFormat('l, d M Y') }}
                        </p>
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Durasi:</span>
                            <span class="text-sm mb-0" id="waktuProduksi{{ $item->pesanan_id }}">
                            </span>
                        </p>
                        <p class="text-sm">
                            {{-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> --}}
                            <span class="font-weight-bold">Estimasi:</span>
                            {{ \Carbon\Carbon::parse($produksi->first()->estimasi)->locale('id')->translatedFormat('l, d M Y') }}
                        <p class="text-sm mb-0" id="estimasi{{ $item->pesanan_id }}"></p>
                        </p>
                        <br>

                        @if ($produksi->first()->status == 'Sedang Berjalan')
                            <form action="{{ route('selesai-produksi') }}" method="POST"
                                onsubmit="return confirmProduction()">
                                @csrf
                                <input type="hidden" name="id_pesanan" id="id_pesanan"
                                    value="{{ $produksi->first()->pesanan_id }}">

                                <button type="submit" class="btn btn-success" style="width: 100%;">Selesai</button>
                            </form>
                        @elseif ($produksi->first()->status == 'Selesai')
                            <h6 class="text-success">Produksi telah selesai!</h6>
                        @endif

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
                    </div>
                </div>
            </div>
        </div>
    @else
        <p>Tidak ada pesanan yang ditemukan.</p>
    @endif

    {{-- <div id="modalForm" style="display: none;">
        <div class="modal-content">
            <form class="formTambah" action="{{ route('mulai-produksi') }}" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">@csrf
                        <h4>Produksi Pesanan {{ $pesanan->first()->kode }}</h4>

                        <input type="hidden" name="pesanan_id" value="{{ $pesanan->first()->id_pesanan }}">

                        <label>Apakah Anda yakin ingin memulai produksi untuk:</label>
                        <ul>
                            @foreach ($pesananproduk as $item)
                                <li>
                                    <h6 class="mb-0 text-sm">{{ $item->jumlah }}x {{ $item->nama_produk }}
                                        ({{ $item->ukuran_produk }})
                                    </h6>
                                </li>
                            @endforeach
                        </ul>

                        <label>Estimasi Lama Produksi:</label>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="estimasi-container">
                                    <input type="number" name="estimasiJam" id="estimasiJam" class="form-control"
                                        value="0" required>
                                    <label>Jam</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="estimasi-container">
                                    <input type="number" name="estimasiMenit" id="estimasiMenit" class="form-control"
                                        value="0" required max="59" oninput="limitMaxValue(this, 59)">
                                    <label>Menit</label>
                                </div>
                            </div>
                        </div>

                        <label class="text-danger"><b>Peringatan!</b><br>Pastikan
                            semua persiapan sebelum memulai proses
                            produksi telah siap!</label>
                        <br>

                        <button type="submit" class="btn btn-success" onclick="return konfirmasiMulai()">Mulai</button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}
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
            var formProduksi = document.getElementById('formProduksi');

            btnTambah.addEventListener('click', function() {
                modalForm.style.display = 'block';
            });

            // Menyembunyikan pop-up ketika klik di luar area formulir
            window.addEventListener('click', function(event) {
                if (event.target === modalForm) {
                    modalForm.style.display = 'none';
                }
            });

            formProduksi.addEventListener('submit', function(event) {
                event.preventDefault();

                // Lakukan pengiriman data menggunakan Ajax di sini
                // Contoh menggunakan Fetch API
                fetch('', {
                        method: 'POST',
                        body: new FormData(formProduksi),
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

        function konfirmasiMulai() {
            var konfirmasi = confirm("Apakah Anda yakin ingin memulai produksi?");

            // Jika pengguna menekan OK pada konfirmasi
            if (konfirmasi) {
                // Lanjutkan dengan penyimpanan data
                return true;
            } else {
                // Batal penyimpanan data
                return false;
            }
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

        function limitMaxValue(element, maxValue) {
            // Memastikan nilai tidak melebihi maxValue
            if (element.value > maxValue) {
                element.value = maxValue;
            }
        }

        function confirmProduction() {
            return confirm("Apakah Anda yakin ingin menyelesaikan produksi?");
        }
    </script>
@endpush
