@extends('layouts.admin')

@section('title')
    Tambah Pembelian Bahan Baku
@endsection

@section('page')
    Menu Master / Daftar Pembelian Bahan Baku / Tambah Pembelian Bahan Baku
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

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible text-white" role="alert">
            @foreach ($errors->all() as $error)
                <span>{{ $error }}</span>
            @endforeach
        </div>
    @endif

    <form class="formTambahTransaksi" action="{{ route('simpan-transaksi') }}" method="POST" enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">
                @csrf
                <h1 class="mb-4">Tambah Transaksi</h1>

                <div class="form-group">
                    <label for="supplier">Supplier:</label>
                    <select id="supplier" name="supplier" required>
                        <option value="" disabled selected>Pilih Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">
                                {{ $supplier->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <div class="d-flex align-items-center">
                        <label for="bahan_baku_supplier">Bahan Baku Supplier:</label>
                        <button type="button" id="addBahanBakuSupplier" class="btn btn-info btn-sm"
                            style="margin-left: 10px;" disabled>
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div id="dynamicFormContainer">
                        <!-- Tempat untuk menambahkan elemen form bahan baku supplier secara dinamis -->
                    </div>
                </div>

                <div class="form-group">
                    <label for="metode_pembayaran">Metode Pembayaran:</label>
                    <select id="metode_pembayaran" name="metode_pembayaran" required>
                        <option value="" disabled selected>Pilih Metode Pembayaran</option>
                        <option value="Cash">Cash</option>
                        <option value="Kartu Kredit">Kartu Kredit</option>
                        <option value="Transfer">Transfer</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cara_pengiriman">Cara Pengiriman:</label>
                    <select id="cara_pengiriman" name="cara_pengiriman" required>
                        <option value="" disabled selected>Pilih Cara Pengiriman</option>
                        <option value="Diambil Sendiri">Diambil Sendiri</option>
                        <option value="Dikirim Kurir">Dikirim Kurir</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="catatan_tambahan">Catatan Tambahan:</label>
                    <textarea id="catatan_tambahan" name="catatan_tambahan" rows="3"></textarea>
                </div>

                <input type="hidden" id="totalHargaInput" name="total_harga">
                <input type="hidden" id="bahanBakuDataInput" name="bahan_baku_data">

                <div class="form-group mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success" onclick="return confirmTambah()">Tambah</button>
                    <a href="{{ route('list-transaksi') }}" class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('add-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var supplierSelect = document.getElementById('supplier');
            var addButton = document.getElementById('addBahanBakuSupplier');
            var container = document.getElementById('dynamicFormContainer');
            var index = 0;
            var totalHarga = 0;
            var bahanBakuData = []; // Array untuk menyimpan data bahan baku

            // Inisialisasi state awal
            if (!supplierSelect.value) {
                addButton.disabled = true;
            }

            // Event listener untuk perubahan pada dropdown supplier
            supplierSelect.addEventListener('change', function() {
                // Hapus semua elemen form yang telah ditambahkan sebelumnya
                while (container.firstChild) {
                    container.removeChild(container.firstChild);
                }

                if (this.value) {
                    addButton.disabled = false;
                } else {
                    addButton.disabled = true;
                }
            });

            addButton.addEventListener('click', function() {
                index++;

                var newFormGroup = document.createElement('div');
                newFormGroup.classList.add('form-group');

                var htmlContent = `
                <div class="d-flex align-items-center">
                    <select class="supplier-dropdown" style="width: 40%" name="bahan_baku_supplier_${index}" required>
                        <option value="" disabled selected>Pilih Bahan Baku Supplier</option>
                    </select>

                    <div style="margin-left: 10px; flex-grow: 1; width: 35%;">
                        <input type="number" class="harga-bahan-baku" name="harga_bahan_baku_${index}"
                            placeholder="Harga per Unit" min="1" step="any" required>
                    </div>
                    <div style="margin-left: 10px; flex-grow: 1;">
                        <input type="number" class="jumlah-bahan-baku" name="jumlah_bahan_baku_${index}"
                            placeholder="Jumlah Bahan Baku" min="1" required>
                    </div>
                    
                    <span class="jenis-satuan-span" style="margin-left: 10px; width: 25%;"></span>
                    <span class="harga-total-span" style="margin-left: 10px; width: 15%;"></span>
                    <button type="button" class="btn btn-danger btn-sm ml-auto deleteButton" style="margin-left: 10px;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                `;

                newFormGroup.innerHTML = htmlContent;
                container.appendChild(newFormGroup);

                var dropdown = newFormGroup.querySelector('.supplier-dropdown');
                var jumlahBahanBakuInput = newFormGroup.querySelector('.jumlah-bahan-baku');
                var hargaBahanBakuInput = newFormGroup.querySelector('.harga-bahan-baku');
                var jenisSatuanSpan = newFormGroup.querySelector('.jenis-satuan-span');
                var hargaTotalSpan = newFormGroup.querySelector('.harga-total-span');

                dropdown.addEventListener('change', function() {
                    var selectedOption = this.options[this.selectedIndex];
                    var jenisSatuan = selectedOption.dataset.jenisSatuan;
                    jenisSatuanSpan.textContent = jenisSatuan;
                    updateBahanBakuData();
                });

                jumlahBahanBakuInput.addEventListener('input', function() {
                    hitungTotalHarga();
                    updateBahanBakuData();
                });

                hargaBahanBakuInput.addEventListener('input', function() {
                    hitungTotalHarga();
                    updateBahanBakuData();
                });

                // Ambil data bahan baku supplier dari server saat tombol add ditekan
                fetch(`/admin/transaksi/get-bahan-baku-supplier/${supplierSelect.value}`)
                    .then(response => response.json())
                    .then(data => {
                        // Kosongkan combobox dan tambahkan opsi berdasarkan data yang diambil
                        dropdown.innerHTML =
                            '<option value="" disabled selected>Pilih Bahan Baku Supplier</option>';
                        data.forEach(bahanBaku => {
                            var option = document.createElement('option');
                            option.value = bahanBaku.id;
                            option.textContent = `${bahanBaku.bahan_baku_nama}`;
                            option.dataset.jenisSatuan = bahanBaku.jenis_satuan;
                            dropdown.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching bahan baku suppliers:', error);
                        dropdown.innerHTML =
                            '<option value="" disabled selected>Error fetching data</option>';
                    });

                // Menambahkan event listener untuk tombol delete
                var deleteButton = newFormGroup.querySelector('.deleteButton');
                deleteButton.addEventListener('click', function() {
                    newFormGroup.remove();
                    hitungTotalHarga();
                    updateBahanBakuData();
                });
            });

            // Fungsi untuk memformat angka menjadi mata uang (misalnya Rupiah)
            function formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(amount);
            }

            // Fungsi untuk menghitung total harga dari semua bahan baku
            // Fungsi untuk menghitung total harga dari semua bahan baku
            function hitungTotalHarga() {
                var totalHarga = 0; // Reset total harga

                // Ambil semua elemen form yang memiliki class .harga-total-span
                var semuaHargaSpans = document.querySelectorAll('.harga-total-span');
                semuaHargaSpans.forEach(function(span) {
                    var hargaString = span.textContent.replace('Rp', '').replace(/\./g, '').replace(',',
                        '.');
                    var harga = parseFloat(hargaString);
                    if (!isNaN(harga)) {
                        totalHarga += harga; // Tambahkan harga ke total
                    }
                });

                // Update nilai input hidden total_harga
                document.getElementById('totalHargaInput').value = totalHarga;

                // Tampilkan total harga dalam format mata uang di halaman
                var totalHargaFormatted = formatCurrency(totalHarga);
                console.log('Total Harga:', totalHargaFormatted);
            }


            // Fungsi untuk mengupdate data bahan baku dalam hidden input
            function updateBahanBakuData() {
                bahanBakuData = []; // Reset data bahan baku

                var formGroups = document.querySelectorAll('.form-group');
                formGroups.forEach(function(group) {
                    var dropdown = group.querySelector('.supplier-dropdown');
                    var jumlahBahanBakuInput = group.querySelector('.jumlah-bahan-baku');
                    var hargaBahanBakuInput = group.querySelector('.harga-bahan-baku');
                    if (dropdown && jumlahBahanBakuInput && hargaBahanBakuInput) {
                        var selectedOption = dropdown.options[dropdown.selectedIndex];
                        var bahanBakuId = selectedOption.value;
                        var jumlah = jumlahBahanBakuInput.value;
                        var harga = hargaBahanBakuInput.value;

                        // Cari jika sudah ada bahan baku dengan ID yang sama
                        var existingBahanBaku = bahanBakuData.find(item => item.bahan_baku_id ===
                            bahanBakuId);
                        if (existingBahanBaku) {
                            // Update jumlah dan harga jika sudah ada
                            existingBahanBaku.jumlah = jumlah;
                            existingBahanBaku.harga = harga;
                        } else {
                            // Tambahkan bahan baku baru ke array
                            bahanBakuData.push({
                                bahan_baku_id: bahanBakuId,
                                jumlah: jumlah,
                                harga: harga
                            });
                            var totalHargaBahanBaku = parseFloat(jumlah) * parseFloat(harga);
                            var hargaFormatted = formatCurrency(totalHargaBahanBaku);

                            // Update tampilan harga total
                            var hargaTotalSpan = group.querySelector('.harga-total-span');
                            if (hargaTotalSpan) {
                                hargaTotalSpan.textContent = hargaFormatted;
                            }
                        }
                    }
                });

                // Simpan data bahan baku dalam hidden input sebagai JSON string
                document.getElementById('bahanBakuDataInput').value = JSON.stringify(bahanBakuData);
            }
        });

        function confirmTambah() {
            return confirm("Apakah Anda yakin ingin menyimpan data ini?");
        }
    </script>


    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var supplierSelect = document.getElementById('supplier');
            var addButton = document.getElementById('addBahanBakuSupplier');
            var container = document.getElementById('dynamicFormContainer');
            var index = 0;
            var totalHarga = 0;
            var bahanBakuData = []; // Array untuk menyimpan data bahan baku

            // Inisialisasi state awal
            if (!supplierSelect.value) {
                addButton.disabled = true;
            }

            // Event listener untuk perubahan pada dropdown supplier
            supplierSelect.addEventListener('change', function() {
                // Hapus semua elemen form yang telah ditambahkan sebelumnya
                while (container.firstChild) {
                    container.removeChild(container.firstChild);
                }

                if (this.value) {
                    addButton.disabled = false;
                } else {
                    addButton.disabled = true;
                }
            });

            addButton.addEventListener('click', function() {
                index++;

                var newFormGroup = document.createElement('div');
                newFormGroup.classList.add('form-group');

                var htmlContent = `
                <div class="d-flex align-items-center">
                    <select class="form-control supplier-dropdown" name="bahan_baku_supplier_${index}" required disabled>
                        <option value="" disabled selected>Pilih Supplier Terlebih Dahulu</option>
                    </select>
                    <div style="margin-left: 10px; flex-grow: 1;">
                        <input type="number" class="form-control jumlah-bahan-baku" name="jumlah_bahan_baku_${index}"
                            placeholder="0" min="1" required>
                    </div>
                    <span class="jenis-satuan-span" style="margin-left: 10px; width: 25%;"></span>
                    <span class="harga-total-span" style="margin-left: 10px; width: 25%;"></span>
                    <button type="button" class="btn btn-danger btn-sm ml-auto deleteButton" style="margin-left: 10px;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;

                newFormGroup.innerHTML = htmlContent;
                container.appendChild(newFormGroup);

                // Fetch data bahan baku supplier berdasarkan supplier yang dipilih
                var dropdown = newFormGroup.querySelector('.supplier-dropdown');
                var jumlahBahanBakuInput = newFormGroup.querySelector('.jumlah-bahan-baku');
                var jenisSatuanSpan = newFormGroup.querySelector('.jenis-satuan-span');
                var hargaTotalSpan = newFormGroup.querySelector('.harga-total-span');

                dropdown.addEventListener('change', function() {
                    var selectedBahanBakuOption = this.options[this.selectedIndex];
                    var jenisSatuan = selectedBahanBakuOption.dataset.jenisSatuan;
                    jenisSatuanSpan.textContent = jenisSatuan;
                    updateBahanBakuData();
                });

                jumlahBahanBakuInput.addEventListener('input', function() {
                    var jumlahBahanBaku = parseInt(this.value);

                    // Ambil harga per unit dari opsi yang dipilih
                    var selectedOption = dropdown.querySelector('option:checked');
                    if (!selectedOption) {
                        return; // Jika tidak ada bahan baku yang dipilih, keluar dari fungsi
                    }

                    var hargaPerUnit = parseFloat(selectedOption.dataset.harga);

                    // Hitung total harga untuk bahan baku ini
                    var totalHargaBahanBaku = jumlahBahanBaku * hargaPerUnit;

                    // Tampilkan total harga untuk bahan baku ini dalam format mata uang
                    hargaTotalSpan.textContent = formatCurrency(totalHargaBahanBaku);

                    // Update total harga keseluruhan
                    hitungTotalHarga();
                    updateBahanBakuData();
                });

                fetch(`/admin/transaksi/get-bahan-baku-supplier/${supplierSelect.value}`)
                    .then(response => response.json())
                    .then(data => {
                        // Kosongkan combobox dan tambahkan opsi berdasarkan data yang diambil
                        dropdown.innerHTML =
                            '<option value="" disabled selected>Pilih Bahan Baku Supplier</option>';
                        data.forEach(bahanBaku => {
                            var hargaFormatted = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(bahanBaku.harga);

                            var option = document.createElement('option');
                            option.value = bahanBaku.id;
                            option.textContent =
                                `${bahanBaku.bahan_baku_nama} - ${hargaFormatted}`;
                            option.dataset.jenisSatuan = bahanBaku.jenis_satuan;
                            option.dataset.harga = bahanBaku.harga; // Simpan harga di dataset
                            dropdown.appendChild(option);
                        });
                        // Aktifkan kembali combobox bahan baku supplier
                        dropdown.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error fetching bahan baku suppliers:', error);
                        dropdown.innerHTML =
                            '<option value="" disabled selected>Error fetching data</option>';
                    });

                // Menambahkan event listener untuk tombol delete
                var deleteButton = newFormGroup.querySelector('.deleteButton');
                deleteButton.addEventListener('click', function() {
                    newFormGroup.remove(); // Menghapus elemen form saat tombol delete ditekan
                    hitungTotalHarga(); // Hitung kembali total harga setelah menghapus item
                    updateBahanBakuData();
                });
            });

            // Fungsi untuk memformat angka menjadi mata uang (misalnya Rupiah)
            function formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(amount);
            }

            // Fungsi untuk menghitung total harga dari semua bahan baku
            function hitungTotalHarga() {
                totalHarga = 0; // Reset total harga

                // Ambil semua elemen form yang memiliki class .harga-total-span
                var semuaHargaSpans = document.querySelectorAll('.harga-total-span');
                semuaHargaSpans.forEach(function(span) {
                    var hargaString = span.textContent.replace('Rp', '').replace(/\./g, '').replace(',',
                        '.');
                    var harga = parseFloat(hargaString);
                    if (!isNaN(harga)) {
                        totalHarga += harga; // Tambahkan harga ke total
                    }
                });

                // Update nilai input hidden total_harga
                document.getElementById('totalHargaInput').value = totalHarga;

                // Tampilkan total harga dalam format mata uang di halaman
                var totalHargaFormatted = formatCurrency(totalHarga);
                console.log('Total Harga:', totalHargaFormatted);
            }

            // Fungsi untuk mengupdate data bahan baku dalam hidden input
            function updateBahanBakuData() {
                bahanBakuData = []; // Reset data bahan baku

                var formGroups = document.querySelectorAll('.form-group');
                formGroups.forEach(function(group) {
                    var dropdown = group.querySelector('.supplier-dropdown');
                    var jumlahBahanBakuInput = group.querySelector('.jumlah-bahan-baku');
                    if (dropdown && jumlahBahanBakuInput) {
                        var selectedOption = dropdown.querySelector('option:checked');
                        if (selectedOption) {
                            var bahanBakuId = selectedOption.value;
                            var jumlah = jumlahBahanBakuInput.value;
                            var harga = selectedOption.dataset.harga;

                            // Cari jika sudah ada bahan baku dengan ID yang sama
                            var existingBahanBaku = bahanBakuData.find(item => item.bahan_baku_id ===
                                bahanBakuId);
                            if (existingBahanBaku) {
                                // Update jumlah dan harga jika sudah ada
                                existingBahanBaku.jumlah = jumlah;
                                existingBahanBaku.harga = harga;
                            } else {
                                // Tambahkan bahan baku baru ke array
                                bahanBakuData.push({
                                    bahan_baku_id: bahanBakuId,
                                    jumlah: jumlah,
                                    harga: harga
                                });
                            }
                        }
                    }
                });

                // Simpan data bahan baku dalam hidden input sebagai JSON string
                document.getElementById('bahanBakuDataInput').value = JSON.stringify(bahanBakuData);
            }
        });
    </script> --}}
@endpush
