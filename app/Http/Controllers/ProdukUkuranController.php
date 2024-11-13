<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProdukUkuranController extends Controller
{
    public function show($id)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $produk = DB::table('produk')
                ->where('id', $id)
                ->whereNull('deleted_at') // Menambahkan kondisi untuk mengecualikan yang telah di-soft delete
                ->first();

            $ukuranProduk = DB::table('produk_ukuran')->where('produk_id', $id)->whereNull('deleted_at')->get();

            return view('pages/admin/produk/ukuranproduk', compact('produk', 'ukuranProduk'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function store(Request $request)
    {
        // Validasi request jika diperlukan
        $request->validate([
            'ukuran' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'produk_id' => 'required|exists:produk,id',
        ]);

        // Simpan data ukuran produk menggunakan Query Builder
        $produkUkuranId = DB::table('produk_ukuran')->insertGetId([
            'ukuran' => $request->ukuran,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'produk_id' => $request->produk_id,
            // Tambahkan kolom lain sesuai kebutuhan
        ]);

        if ($produkUkuranId) {
            return redirect()->route('ukuran-produk', $request->produk_id)->with('success', 'Ukuran produk berhasil disimpan!');
        }

        // Handle jika terjadi kesalahan saat menyimpan ukuran produk
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan ukuran produk.');
    }

    public function edit($id)
    {
        $ukuranProduk = DB::table('produk_ukuran')->where('id', $id)->first();
        $namaProduk = DB::table('produk')->where('id', $ukuranProduk->produk_id)->value('nama');
        // Jangan lupa untuk mempassing data yang diperlukan ke view edit
        return view('pages/admin/produk/ubahukuranproduk', compact('ukuranProduk', 'namaProduk'));
    }

    public function update(Request $request, $id)
    {
        // Validasi request jika diperlukan
        $request->validate([
            'ukuran' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
        ]);

        // Update data ukuran produk menggunakan Query Builder
        DB::table('produk_ukuran')
            ->where('id', $id)
            ->update([
                'ukuran' => $request->ukuran,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
            ]);

        // Setelah update, dapatkan produk_id
        $produk_ukuran = DB::table('produk_ukuran')->find($id);

        if ($produk_ukuran) {
            return redirect()->route('ukuran-produk', $produk_ukuran->produk_id)->with('success', 'Ukuran produk berhasil diubah!');
        }

        // Handle jika produk_ukuran tidak ditemukan
        return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah ukuran produk.');
    }


    public function hapus($id)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $produk_ukuran = DB::table('produk_ukuran')->where('id', $id)->first();

            if ($produk_ukuran) {
                // $deleted = DB::table('produk_ukuran')->where('id', $id)->delete();
                $deleted = DB::table('produk_ukuran')->where('id', $id)->update([
                    'deleted_at' => now(), // Set waktu sekarang sebagai nilai deleted_at
                ]);

                if ($deleted) {
                    return redirect()->back()->with('success', 'Ukuran produk berhasil dihapus');
                } else {
                    return redirect()->back()->with('error', 'Gagal menghapus ukuran produk');
                }
            } else {
                return redirect()->back()->with('error', 'Produk tidak ditemukan');
            }
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }
}
