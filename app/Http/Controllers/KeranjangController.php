<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KeranjangController extends Controller
{
    public function showkeranjang($id)
    {
        if (Session::has('nama_peran') && Session::get('kode_peran') == 'CUST' && Session::get('user_id') == $id) {
            $keranjang = DB::table('keranjang')
                ->select('keranjang.*', 'produk.nama AS nama', 'produk.gambar AS gambar', 'produk_ukuran.ukuran AS ukuran', 'produk_ukuran.harga AS harga')
                ->join('produk_ukuran', 'keranjang.produk_ukuran_id', '=', 'produk_ukuran.id')
                ->join('produk', 'produk_ukuran.produk_id', '=', 'produk.id')
                ->where('keranjang.user_id', $id)
                ->whereNull('keranjang.deleted_at')
                ->get();

            // dd($produk);

            return view('pages/user/pemesanan/keranjang', compact('keranjang'));
        } else {
            return redirect('/')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function ubahJumlahBarang(Request $request)
    {
        if (Session::has('nama_peran') && Session::get('kode_peran') == 'CUST') {
            // Validasi request sesuai kebutuhan
            $request->validate([
                'produk_ukuran_id' => 'required|exists:produk_ukuran,id',
                'jumlah' => 'required|integer|min:1',
            ]);

            $user_id = session('user_id');
            $produk_ukuran_id = $request->produk_ukuran_id;

            // Update jumlah barang di database sesuai request
            $updated = DB::table('keranjang')
                ->where('user_id', $user_id)
                ->where('produk_ukuran_id', $produk_ukuran_id)
                ->update(['jumlah' => $request->jumlah]);

            if ($updated) {
                return redirect()->route('halaman-keranjang', ['id' => $user_id])
                    ->with('success', 'Jumlah barang berhasil diubah');
            } else {
                return redirect()->back()->with('error', 'Gagal mengubah jumlah barang');
            }
        } else {
            return redirect('/')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }


    public function simpankeranjang(Request $request)
    {
        if (Session::has('nama_peran') && Session::get('kode_peran') == 'CUST') {

            $produkUkuran = DB::table('produk_ukuran')
                ->where('produk_id', $request->input('produk_id'))
                ->where('ukuran', $request->input('ukuran'))
                ->first();

            // Pengecekan apakah produk sudah ada di keranjang pelanggan
            $existingItem = DB::table('keranjang')
                ->where('user_id', session('user_id'))
                ->where('produk_ukuran_id', $produkUkuran->id)
                ->whereNull('keranjang.deleted_at')
                ->exists();

            // Jika produk sudah ada di keranjang, beri pesan error
            if ($existingItem) {
                return redirect()->back()->with('error', 'Produk sudah ada di keranjang Anda.');
            }

            // Pastikan $produkUkuran tidak null sebelum digunakan
            if (!$produkUkuran) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan');
            }

            $data = [
                'user_id' => session('user_id'),
                'produk_ukuran_id' => $produkUkuran->id, // Ambil id dari $produkUkuran
                'jumlah' => $request->input('jumlah'),
            ];
            // dd($request->all());
            // Pastikan bahwa struktur kolom di tabel 'keranjang' sesuai dengan $data yang akan diinsert
            DB::table('keranjang')->insert($data);

            return redirect()->route('halaman-produk')->with('success', 'Produk berhasil ditambahkan ke keranjang');
        } else {
            return redirect('/')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function hapuskeranjang(Request $request)
    {
        if (Session::has('nama_peran') && Session::get('kode_peran') == 'CUST') {
            // Validasi request sesuai kebutuhan
            $request->validate([
                'produk_ukuran_id' => 'required|exists:produk_ukuran,id',
            ]);

            $user_id = session('user_id');
            $produk_ukuran_id = $request->produk_ukuran_id;

            // Cek apakah item keranjang ada
            $keranjang = DB::table('keranjang')
                ->where('user_id', $user_id)
                ->where('produk_ukuran_id', $produk_ukuran_id)
                ->first();

            if ($keranjang) {
                // Hapus item dari keranjang
                $deleted = DB::table('keranjang')
                    ->where('user_id', $user_id)
                    ->where('produk_ukuran_id', $produk_ukuran_id)
                    ->delete();

                if ($deleted) {
                    return redirect()->back()->with('success', 'Produk berhasil dikeluarkan dari keranjang');
                } else {
                    return redirect()->back()->with('error', 'Gagal menghapus dari keranjang');
                }
            } else {
                return redirect()->back()->with('error', 'Produk dalam keranjang tidak ditemukan');
            }
        } else {
            return redirect('/')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function simpanCatatan(Request $request)
    {
        $request->validate([
            'produk_ukuran_id' => 'required|exists:keranjang,produk_ukuran_id',
            'catatan' => 'nullable|string',
        ]);

        $produkUkuranId = $request->input('produk_ukuran_id');
        $catatan = $request->input('catatan');

        // Simpan catatan ke dalam tabel keranjang
        DB::table('keranjang')
            ->where('produk_ukuran_id', $produkUkuranId)
            ->where('user_id', session('user_id'))
            ->update(['catatan' => $catatan]);

        return redirect()->back()->with('success', 'Catatan berhasil disimpan!');
    }
}
