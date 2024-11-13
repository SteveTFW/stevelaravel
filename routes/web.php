<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk Halaman dan Function Admin
Route::get('/admin/dashboard', [App\Http\Controllers\HomeController::class, 'indexadmin'])->name('home-admin');
Route::get('/admin/profile/{id}', [App\Http\Controllers\UserController::class, 'showadmin'])->name('view-admin');

// Route Login & Register
Route::get('/admin/login', [App\Http\Controllers\UserController::class, 'viewadminlogin'])->name('admin-view-login');
Route::post('/admin/login/now', [App\Http\Controllers\UserController::class, 'adminlogin'])->name('admin-login');
Route::get('/admin/register', [App\Http\Controllers\UserController::class, 'viewadminregister'])->name('view-admin-register');
Route::post('/admin/register/now', [App\Http\Controllers\UserController::class, 'adminregister'])->name('admin-register');
Route::get('/admin/logout', [App\Http\Controllers\UserController::class, 'adminlogout'])->name('admin-logout');

// Route Master Menu
Route::get('/admin/listproduk', [App\Http\Controllers\ProdukController::class, 'index'])->name('list-produk');
Route::get('/admin/ubahproduk/{id}', [App\Http\Controllers\ProdukController::class, 'edit'])->name('show-ubah-produk');
Route::put('/admin/ubah/produk/{id}', [App\Http\Controllers\ProdukController::class, 'update'])->name('ubah-produk');
Route::post('/admin/sukses/produk', [App\Http\Controllers\ProdukController::class, 'store']);
Route::delete('/admin/delete/produk/{id}', [App\Http\Controllers\ProdukController::class, 'destroy'])->name('hapus-produk');
Route::get('/admin/stockbarangjadi', [App\Http\Controllers\ProdukController::class, 'viewstock'])->name('stok-produk');

Route::get('/admin/ukuranproduk/{id}', [App\Http\Controllers\ProdukUkuranController::class, 'show'])->name('ukuran-produk');
Route::get('/admin/ubah-ukuran-produk/{id}', [App\Http\Controllers\ProdukUkuranController::class, 'edit'])->name('ubah-ukuran-produk');
Route::put('/admin/update-ukuran-produk/{id}', [App\Http\Controllers\ProdukUkuranController::class, 'update'])->name('update-ukuran-produk');
Route::post('/admin/sukses/ukuranproduk', [App\Http\Controllers\ProdukUkuranController::class, 'store']);
Route::delete('/admin/hapus/ukuranproduk/{id}', [App\Http\Controllers\ProdukUkuranController::class, 'hapus'])->name('hapus-ukuran-produk');

Route::get('/admin/bahanbakuproduk/{id}', [App\Http\Controllers\ProdukBahanBakuController::class, 'show'])->name('bahan-baku-produk');
Route::get('/admin/ubah-bahanbaku-produk/{produkId}/{bahanBakuId}', [App\Http\Controllers\ProdukBahanBakuController::class, 'edit'])->name('ubah-bahanbaku-produk');
Route::put('/admin/update-bahanbaku-produk/{produk_id}/{bahan_baku_id}', [App\Http\Controllers\ProdukBahanBakuController::class, 'update'])->name('update-bahanbaku-produk');
Route::post('/admin/sukses/bahanbakuproduk', [App\Http\Controllers\ProdukBahanBakuController::class, 'store']);
Route::delete('/admin/hapus/bahanbakuproduk/', [App\Http\Controllers\ProdukBahanBakuController::class, 'hapus'])->name('hapus-bahanbaku-produk');

Route::get('/admin/listbahanbaku', [App\Http\Controllers\BahanBakuController::class, 'index'])->name('list-bahanbaku');
Route::get('/admin/ubahbahanbaku/{id}', [App\Http\Controllers\BahanBakuController::class, 'edit'])->name('show-ubah-bahanbaku');
Route::put('/admin/ubah/bahanbaku/{id}', [App\Http\Controllers\BahanBakuController::class, 'update'])->name('ubah-bahanbaku');
Route::post('/admin/sukses/bahanbaku', [App\Http\Controllers\BahanBakuController::class, 'store']);
Route::delete('/admin/delete/bahanbaku/{id}', [App\Http\Controllers\BahanBakuController::class, 'destroy'])->name('hapus-bahanbaku');
Route::get('/admin/stockbahanbaku', [App\Http\Controllers\BahanBakuController::class, 'viewstock'])->name('stok-bahanbaku');

Route::get('/admin/listkategori', [App\Http\Controllers\KategoriController::class, 'index'])->name('list-kategori');
Route::get('/admin/ubahkategori/{id}', [App\Http\Controllers\KategoriController::class, 'edit'])->name('show-ubah-kategori');
Route::put('/admin/ubah/kategori/{id}', [App\Http\Controllers\KategoriController::class, 'update'])->name('ubah-kategori');
Route::post('/admin/sukses/kategori', [App\Http\Controllers\KategoriController::class, 'store']);
Route::delete('/admin/delete/kategori/{id}', [App\Http\Controllers\KategoriController::class, 'destroy'])->name('hapus-kategori');

Route::get('/admin/listuser', [App\Http\Controllers\UserController::class, 'index'])->name('list-user');
Route::delete('/admin/delete/user/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('hapus-user');

Route::get('/admin/listperan', [App\Http\Controllers\PeranController::class, 'index'])->name('list-peran');
Route::get('/admin/ubahperan/{id}', [App\Http\Controllers\PeranController::class, 'edit'])->name('show-ubah-peran');
Route::put('/admin/ubah/peran/{id}', [App\Http\Controllers\PeranController::class, 'update'])->name('ubah-peran');
Route::post('/admin/sukses/peran', [App\Http\Controllers\PeranController::class, 'store']);
Route::delete('/admin/delete/peran/{id}', [App\Http\Controllers\PeranController::class, 'destroy'])->name('hapus-peran');

Route::get('/admin/listsupplier', [App\Http\Controllers\SupplierController::class, 'index'])->name('list-supplier');
Route::get('/admin/ubahsupplier/{id}', [App\Http\Controllers\SupplierController::class, 'edit'])->name('show-ubah-supplier');
Route::put('/admin/ubah/supplier/{id}', [App\Http\Controllers\SupplierController::class, 'update'])->name('ubah-supplier');
Route::post('/admin/sukses/supplier', [App\Http\Controllers\SupplierController::class, 'store']);
Route::delete('/admin/delete/supplier/{id}', [App\Http\Controllers\SupplierController::class, 'destroy'])->name('hapus-supplier');

Route::get('/admin/listsupplier/detail/{id}', [App\Http\Controllers\BahanBakuSupplierController::class, 'index'])->name('list-bahanbaku-supplier');
Route::post('/admin/sukses/bahan-baku-supplier', [App\Http\Controllers\BahanBakuSupplierController::class, 'simpanbahanbaku']);
Route::delete('/admin/hapus/bahan-baku-supplier', [App\Http\Controllers\BahanBakuSupplierController::class, 'hapusbahanbaku'])->name('hapus-bahanbaku-supplier');


Route::get('/admin/listpesanan', [App\Http\Controllers\PesananController::class, 'index'])->name('list-pesanan');
Route::get('/admin/ubahpesanan/{id}', [App\Http\Controllers\PesananController::class, 'edit'])->name('show-ubah-pesanan');
Route::put('/admin/ubah/pesanan/{id}', [App\Http\Controllers\PesananController::class, 'update'])->name('ubah-pesanan');
Route::delete('/admin/delete/pesanan/{id}', [App\Http\Controllers\PesananController::class, 'destroy'])->name('hapus-pesanan');
Route::get('/admin/pesanan/detail/{id}', [App\Http\Controllers\PesananController::class, 'show'])->name('detail-pesanan');
Route::post('/admin/pesanan/ubah/{id}', [App\Http\Controllers\PesananController::class, 'ubahstatuspesanan'])->name('ubah-status-pesanan');
Route::post('/admin/pesanan/minta-lunas/{id}', [App\Http\Controllers\PesananController::class, 'mintalunas'])->name('minta-lunas-pesanan');
Route::post('/admin/pesanan/minta-kirim/{id}', [App\Http\Controllers\PesananController::class, 'mintakirim'])->name('minta-kirim-pesanan');
Route::post('/admin/pesanan/minta-selesai/{id}', [App\Http\Controllers\PesananController::class, 'mintaselesai'])->name('minta-selesai-pesanan');

Route::get('/admin/listtransaksi', [App\Http\Controllers\TransaksiController::class, 'index'])->name('list-transaksi');
Route::get('/admin/listtransaksi/tambah', [App\Http\Controllers\TransaksiController::class, 'create'])->name('tambah-transaksi');
Route::get('/admin/ubahtransaksi/{id}', [App\Http\Controllers\TransaksiController::class, 'edit'])->name('show-ubah-transaksi');
Route::put('/admin/ubah/transaksi/{id}', [App\Http\Controllers\TransaksiController::class, 'update'])->name('ubah-transaksi');
Route::delete('/admin/delete/transaksi/{id}', [App\Http\Controllers\TransaksiController::class, 'destroy'])->name('hapus-transaksi');
Route::get('/admin/transaksi/detail/{id}', [App\Http\Controllers\TransaksiController::class, 'detailTransaksi'])->name('detail-transaksi');
Route::get('/admin/transaksi/get-bahan-baku-supplier/{supplierId}', [App\Http\Controllers\TransaksiController::class, 'getBahanBakuSupplier']);
Route::post('/admin/transaksi/simpan', [App\Http\Controllers\TransaksiController::class, 'store'])->name('simpan-transaksi');
Route::post('/admin/transaksi/update-stok', [App\Http\Controllers\TransaksiController::class, 'updateStok'])->name('transaksi-update-stok');
Route::post('/admin/transaksi/batal', [App\Http\Controllers\TransaksiController::class, 'batalTransaksi'])->name('batal-transaksi');

Route::get('/admin/produksi', [App\Http\Controllers\ProduksiController::class, 'index'])->name('list-produksi');
Route::get('/admin/produksi/{id}', [App\Http\Controllers\ProduksiController::class, 'show'])->name('detail-produksi');
Route::get('/admin/semua-produksi', [App\Http\Controllers\ProduksiController::class, 'riwayat'])->name('riwayat-produksi');
Route::post('/admin/produksi/mulai', [App\Http\Controllers\ProduksiController::class, 'mulaiProduksi'])->name('mulai-produksi');
Route::post('/admin/produksi/selesai', [App\Http\Controllers\ProduksiController::class, 'selesaiProduksi'])->name('selesai-produksi');

Route::get('/admin/laporan/pemasukkan', [App\Http\Controllers\LaporanController::class, 'pemasukkan'])->name('view-pemasukkan');
Route::get('/admin/laporan/pengeluaran', [App\Http\Controllers\LaporanController::class, 'pengeluaran'])->name('view-pengeluaran');
Route::get('/admin/laporan/pemasukkan/pdf', [App\Http\Controllers\LaporanController::class, 'generatePDFmasuk'])->name('generate-pdf-masuk');
Route::get('/admin/laporan/pengeluaran/pdf', [App\Http\Controllers\LaporanController::class, 'generatePDFkeluar'])->name('generate-pdf-keluar');

Route::get('/admin/profile/{id}', [App\Http\Controllers\UserController::class, 'adminprofil'])->name('admin-profile');
Route::put('/admin/ubah/profile', [App\Http\Controllers\UserController::class, 'ubahadminprofil'])->name('admin-ubah-profile');
// ----------------------------------------------------------------------------------------------------------------------------------------------------



// Route untuk Halaman dan Function User
Route::get('/', [App\Http\Controllers\HomeController::class, 'indexuser'])->name('home');
Route::get('/profile', [App\Http\Controllers\UserController::class, 'userprofil'])->name('view-profile');
Route::put('/ubah/profile', [App\Http\Controllers\UserController::class, 'ubahuserprofil'])->name('ubah-profile');

// Route Login & Register
Route::get('/login', [App\Http\Controllers\UserController::class, 'viewuserlogin'])->name('view-login');
Route::post('/login/now', [App\Http\Controllers\UserController::class, 'userlogin'])->name('user-login');
Route::get('/register', [App\Http\Controllers\UserController::class, 'viewuserregister'])->name('view-register');
Route::post('/register/now', [App\Http\Controllers\UserController::class, 'userregister'])->name('user-register');
Route::get('/logout', [App\Http\Controllers\UserController::class, 'userlogout'])->name('user-logout');

// Route Pemesanan
Route::get('/produk', [App\Http\Controllers\ProdukController::class, 'showproduct'])->name('halaman-produk');
Route::get('/produk/detail/{id}', [App\Http\Controllers\ProdukController::class, 'showdetailproduct'])->name('halaman-detail-produk');

Route::post('/simpan-keranjang/sukses', [App\Http\Controllers\KeranjangController::class, 'simpankeranjang'])->name('simpan-keranjang');
Route::get('/keranjang/{id}', [App\Http\Controllers\KeranjangController::class, 'showkeranjang'])->name('halaman-keranjang');
Route::put('/ubah-jumlah-barang', [App\Http\Controllers\KeranjangController::class, 'ubahJumlahBarang'])->name('ubah-jumlah-barang');
Route::delete('/hapus-dari-keranjang', [App\Http\Controllers\KeranjangController::class, 'hapuskeranjang'])->name('hapus-dari-keranjang');
Route::post('/simpan-catatan', [App\Http\Controllers\KeranjangController::class, 'simpanCatatan'])->name('simpan-catatan');

Route::get('/pesanan/{id}', [App\Http\Controllers\PesananController::class, 'showpesanan'])->name('show-pesanan');
Route::get('/semua-pesanan/{id}', [App\Http\Controllers\PesananController::class, 'showallpesanan'])->name('show-semua-pesanan');
Route::get('/pesanan/detail/{id}', [App\Http\Controllers\PesananController::class, 'showdetailpesanan'])->name('show-detail-pesanan');
Route::post('/simpan', [App\Http\Controllers\PesananController::class, 'simpanpesanan'])->name('simpan-ke-pesanan');
Route::post('/pesanan/batal/{id}', [App\Http\Controllers\PesananController::class, 'batalpesanan'])->name('batal-pesanan');
Route::post('/update-status/{pesananId}', [App\Http\Controllers\PesananController::class, 'updatestatuspembayaran']);

// Route::post('payments/midtrans-notification', [App\Http\Controllers\PaymentCallbackController::class, 'receive']);
