@extends('layouts.landing2')

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
    <section class="pb-5 position-relative bg-gradient-dark">
        <form action="{{ route('simpan-keranjang') }}" method="POST">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-5 ms-auto mb-5 mt-5">
                        <div class="position-relative">
                            <img class="position-relative z-index-2" style="width: 80%" src="{{ asset($produk->gambar) }}"
                                alt="image">
                        </div>
                    </div>

                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                    <input type="hidden" id="selected_ukuran" name="ukuran" value="{{ $result->first()->ukuran }}">

                    <div class="col-md-6 m-auto mb-5 mt-5 ">
                        <h4 class="text-white">{{ $produk->nama }}</h4>
                        <p class="mb-4 text-white">
                            {{ $produk->deskripsi }}
                        </p><br>

                        <p class="text-white text-center font-weight-bold" for="ukuran">Ukuran Produk:</p>
                        <div class="col-lg-4 mx-auto">
                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                    @foreach ($result as $item)
                                        <li class="nav-item" style="width: 25px">
                                            <p class="nav-link mb-0 px-0 py-1 active" data-ukuran="{{ $item->ukuran }}"
                                                data-harga="{{ $item->harga }}" data-bs-toggle="tab"
                                                href="#profile-tabs-simple" role="tab" aria-controls="profile"
                                                aria-selected="true">
                                                {{ $item->ukuran }}
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div><br>

                        <p class="text-white text-center font-weight-bold">Harga: </p>
                        <p id="harga" class="text-white text-center">Rp
                            {{ number_format($result->first()->harga, 0, ',', '.') }}</p><br>

                        <div class="col-lg-4 mb-4 mx-auto text-center">
                            <p class="text-white font-weight-bold">Jumlah:</p>
                            <input type="number" id="jumlah" name="jumlah" placeholder="Jumlah produk"
                                style="width: 100%;" required min="0" max="250">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2" style="width: 100%"
                            onclick="return confirmTambahKeKeranjang()">TAMBAH KE KERANJANG</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection

@push('add-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ukuranLinks = document.querySelectorAll('.nav-link');
            var selectedUkuranElement = document.getElementById('selected_ukuran');
            var hargaElement = document.getElementById('harga');
            var jumlahInput = document.getElementById('jumlah');

            ukuranLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    var selectedUkuran = link.getAttribute('data-ukuran');
                    var selectedHarga = link.getAttribute('data-harga');

                    // Log nilai ukuran dan harga yang dipilih untuk melihat apakah nilainya benar
                    console.log('Selected Ukuran:', selectedUkuran);
                    console.log('Selected Harga:', selectedHarga);

                    // Mengubah teks harga dan nilai ukuran sesuai dengan ukuran yang dipilih
                    hargaElement.textContent = 'Rp ' + number_format(selectedHarga, 0, ',', '.');
                    selectedUkuranElement.value = selectedUkuran;
                });
            });

            function number_format(number, decimals, dec_point, thousands_sep) {
                // Fungsi number_format untuk memformat angka menjadi format mata uang
                var n = number,
                    c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals,
                    d = dec_point === undefined ? '.' : dec_point,
                    t = thousands_sep === undefined ? ',' : thousands_sep,
                    s = n < 0 ? '-' : '',
                    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + '',
                    j = (j = i.length) > 3 ? j % 3 : 0;

                return s + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, '$1' + t) + (c ?
                    d + Math.abs(n - i).toFixed(c).slice(2) : '');
            }
        });

        function confirmTambahKeKeranjang() {
            return confirm('Apakah Anda yakin ingin menambahkan produk ini ke keranjang?');
        }

        document.getElementById('jumlah').addEventListener('input', function(e) {
            let value = e.target.value;
            if (value < 0) {
                e.target.value = 0;
            } else if (value > 250) {
                e.target.value = 250;
            }
        });
    </script>
@endpush
