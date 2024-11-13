<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProdukBahanBakuController extends Controller
{
    public function show($id)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $produk = DB::table('produk')
                ->where('id', $id)
                ->whereNull('deleted_at') // Menambahkan kondisi untuk mengecualikan yang telah di-soft delete
                ->first();

            $bahanbakuProduk = DB::table('bahan_baku_produk')
                ->join('bahan_baku', 'bahan_baku_produk.bahan_baku_id', '=', 'bahan_baku.id')
                ->where('bahan_baku_produk.produk_id', $id)
                ->whereNull('bahan_baku_produk.deleted_at')
                ->select('bahan_baku_produk.*', 'bahan_baku.nama AS bahan_baku_nama', 'bahan_baku.jenis_satuan AS jenis_satuan')
                ->get();

            $bahanbakuOptions = DB::select('SELECT id, nama FROM bahan_baku');

            return view('pages/admin/produk/bahanbakuproduk', compact('produk', 'bahanbakuProduk', 'bahanbakuOptions'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function store(Request $request)
    {
        // Validasi request jika diperlukan
        $request->validate([
            'bahan_baku_id' => 'required|exists:bahan_baku,id',
            'jumlah' => 'required|numeric',
            'produk_id' => 'required|exists:produk,id',
        ]);

        // Simpan data bahan baku produk menggunakan Query Builder
        $inserted = DB::table('bahan_baku_produk')->insert([
            'bahan_baku_id' => $request->bahan_baku_id,
            'jumlah' => $request->jumlah,
            'produk_id' => $request->produk_id,
            'created_at' => now(), // menambahkan timestamp created_at
            'updated_at' => now(), // menambahkan timestamp updated_at
        ]);

        if ($inserted) {
            return redirect()->route('bahan-baku-produk', $request->produk_id)->with('success', 'Bahan baku produk berhasil disimpan!');
        }

        // Handle jika terjadi kesalahan saat menyimpan bahan baku produk
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan bahan baku produk.');
    }



    public function edit($produkId, $bahanBakuId)
    {
        $bahanbakuProduk = DB::table('bahan_baku_produk')
            ->where('produk_id', $produkId)
            ->where('bahan_baku_id', $bahanBakuId)
            ->first();

        if (!$bahanbakuProduk) {
            return redirect()->route('list-produk')->with('error', 'Data bahan baku produk tidak ditemukan.');
        }

        $namaProduk = DB::table('produk')->where('id', $bahanbakuProduk->produk_id)->value('nama');
        $bahanbakuOptions = DB::table('bahan_baku')->select('id', 'nama')->get();

        // Jangan lupa untuk mempassing data yang diperlukan ke view edit
        return view('pages/admin/produk/ubahbahanbakuproduk', compact('bahanbakuProduk', 'namaProduk', 'bahanbakuOptions'));
    }

    public function update(Request $request, $produk_id, $bahan_baku_id)
    {
        // dd($request->all());
        // Validasi request
        $request->validate([
            'bahan_baku' => 'required|exists:bahan_baku,id',
            'jumlah' => 'required|numeric',
            'produk_id' => 'required|exists:produk,id',
        ]);

        // Update data bahan baku produk menggunakan Query Builder
        $updated = DB::table('bahan_baku_produk')
            ->where('produk_id', $produk_id)
            ->where('bahan_baku_id', $bahan_baku_id) // Tambahkan pengecekan bahan_baku_id
            ->update([
                'jumlah' => $request->jumlah,
            ]);

        if ($updated) {
            return redirect()->route('bahan-baku-produk', $produk_id)
                ->with('success', 'Bahan baku produk berhasil diubah!');
        }

        return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah bahan baku produk.');
    }


    public function hapus(Request $request)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $produkId = $request->input('produk_id');
            $bahanBakuId = $request->input('bahan_baku_id');

            $bahan_baku_produk = DB::table('bahan_baku_produk')
                ->where('produk_id', $produkId)
                ->where('bahan_baku_id', $bahanBakuId)
                ->first();

            if ($bahan_baku_produk) {
                $deleted = DB::table('bahan_baku_produk')
                    ->where('produk_id', $produkId)
                    ->where('bahan_baku_id', $bahanBakuId)
                    ->delete();

                if ($deleted) {
                    return redirect()->back()->with('success', 'Bahan baku produk berhasil dihapus');
                } else {
                    return redirect()->back()->with('error', 'Gagal menghapus bahan baku produk');
                }
            } else {
                return redirect()->back()->with('error', 'Produk tidak ditemukan');
            }
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!');
        }
    }
}
