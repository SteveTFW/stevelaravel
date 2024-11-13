<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProduksiController extends Controller
{
    public function index()
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KPRD')) {
            $produksi = DB::table('produksi as pr')
                ->select('pr.*', 'pe.kode', 'p.nama as nama_produk', 'pu.ukuran', 'u.nama as nama_user')
                ->join('produk_ukuran as pu', 'pr.produk_ukuran_id', '=', 'pu.id')
                ->join('pesanan as pe', 'pr.pesanan_id', '=', 'pe.id')
                ->join('produk as p', 'pu.produk_id', '=', 'p.id')
                ->join('user as u', 'pr.user_id', '=', 'u.id')
                ->where('pr.status', 'Sedang Berjalan')
                ->whereNull('pr.selesai')
                ->orderBy('pr.pesanan_id', 'desc')
                ->get();

            return view('pages/admin/produksi/viewproduksi', compact('produksi'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function riwayat()
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KPRD')) {
            $produksi = DB::table('produksi as pr')
                ->select('pr.*', 'pe.kode', 'p.nama as nama_produk', 'pu.ukuran', 'u.nama as nama_user')
                ->join('produk_ukuran as pu', 'pr.produk_ukuran_id', '=', 'pu.id')
                ->join('pesanan as pe', 'pr.pesanan_id', '=', 'pe.id')
                ->join('produk as p', 'pu.produk_id', '=', 'p.id')
                ->join('user as u', 'pr.user_id', '=', 'u.id')
                ->orderBy('pr.pesanan_id', 'desc')
                ->get();

            return view('pages/admin/produksi/riwayatproduksi', compact('produksi'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function show($id)
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KPRD')) {
            $produksi = DB::table('produksi as pr')
                ->select('pr.*', 'pe.kode as kode', 'p.nama as nama_produk', 'p.gambar as gambar_produk', 'pu.harga as harga_produk', 'pu.ukuran as ukuran_produk', 'u.nama as nama_user')
                ->join('produk_ukuran as pu', 'pr.produk_ukuran_id', '=', 'pu.id')
                ->join('pesanan as pe', 'pr.pesanan_id', '=', 'pe.id')
                ->join('produk as p', 'pu.produk_id', '=', 'p.id')
                ->join('user as u', 'pr.user_id', '=', 'u.id')
                ->where('pr.pesanan_id', $id)
                ->orderBy('pr.pesanan_id', 'desc')
                ->get();

            return view('pages/admin/produksi/detailproduksi', compact('produksi'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function mulaiProduksi(Request $request)
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KPRD')) {
            // Validasi form
            $request->validate([
                'estimasiJam' => 'required|integer',
                'estimasiMenit' => 'required|integer',
            ]);

            $pesananId = $request->input('pesanan_id');
            // dd($pesananId);

            // Ambil data pesanan_produk berdasarkan ID pesanan
            $pesananProduk = DB::table('pesanan_produk as pp')
                ->select('pp.*', 'p.id as id_produk', 'p.nama as nama_produk', 'pu.ukuran')
                ->join('produk_ukuran as pu', 'pp.produk_ukuran_id', '=', 'pu.id')
                ->join('produk as p', 'pu.produk_id', '=', 'p.id')
                ->where('pp.pesanan_id', $pesananId)
                ->get();
            // dd($pesananProduk);

            // Proses tambah data ke tabel produksi
            Config::set('app.timezone', 'Asia/Jakarta'); // Ganti dengan zona waktu yang sesuai

            foreach ($pesananProduk as $item) {

                if (!$this->checkBahanBakuAvailability($item)) {
                    return redirect()->back()->with('error', 'Bahan baku tidak mencukupi');
                }

                // Insert produksi
                $produksiId = DB::table('produksi')->insertGetId([
                    'pesanan_id' => $item->pesanan_id,
                    'produk_ukuran_id' => $item->produk_ukuran_id,
                    'user_id' => session('user_id_admin'),
                    'jumlah' => $item->jumlah,
                    'estimasi' => now()->addHours($request->input('estimasiJam'))->addMinutes($request->input('estimasiMenit')),
                    'mulai' => now(),
                    'status' => 'Sedang Berjalan',
                ]);

                // Kurangi stok bahan baku
                $bahanBaku = DB::table('bahan_baku_produk')
                    ->select('bahan_baku.id', 'bahan_baku.stok_kuantitas', 'bahan_baku_produk.jumlah')
                    ->join('bahan_baku', 'bahan_baku_produk.bahan_baku_id', '=', 'bahan_baku.id')
                    ->where('bahan_baku_produk.produk_id', $item->id_produk)
                    ->get();

                foreach ($bahanBaku as $bahan) {
                    $jumlahBahanDiperlukan = $bahan->jumlah * $item->jumlah;

                    // Kurangi stok bahan baku menggunakan Query Builder
                    DB::table('bahan_baku')
                        ->where('id', $bahan->id)
                        ->update(['stok_kuantitas' => DB::raw("stok_kuantitas - $jumlahBahanDiperlukan")]);
                }
            }

            DB::table('pesanan')->where('id', $pesananId)->update(['status' => 'Sedang Produksi']);

            // Redirect atau berikan respon sesuai kebutuhan
            return redirect('/admin/produksi')->with('success', 'Produksi berhasil dimulai.');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    private function checkBahanBakuAvailability($item)
    {
        $bahanBaku = DB::table('bahan_baku_produk')
            ->select('bahan_baku.id', 'bahan_baku.stok_kuantitas', 'bahan_baku_produk.jumlah')
            ->join('bahan_baku', 'bahan_baku_produk.bahan_baku_id', '=', 'bahan_baku.id')
            ->where('bahan_baku_produk.produk_id', $item->id_produk)
            ->get();

        foreach ($bahanBaku as $bahan) {
            $jumlahBahanDiperlukan = $bahan->jumlah * $item->jumlah;

            if ($bahan->stok_kuantitas < $jumlahBahanDiperlukan) {
                return false; // Bahan baku tidak mencukupi
            }
        }

        return true; // Semua bahan baku mencukupi
    }

    public function selesaiProduksi(Request $request)
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KPRD')) {

            $pesananId = $request->input('id_pesanan');
            // dd($pesananId);
            Config::set('app.timezone', 'Asia/Jakarta');

            DB::table('produksi')
                ->where('pesanan_id', $pesananId)
                ->update([
                    'status' => 'Selesai',
                    'selesai' => now() // Update kolom 'selesai' dengan waktu sekarang
                ]);

            DB::table('pesanan')
                ->where('id', $pesananId)
                ->update([
                    'status' => 'Selesai Produksi',
                ]);

            // Mengambil data pesanan produk untuk mendapatkan produk yang terlibat dalam pesanan
            $pesananProduk = DB::table('pesanan_produk')
                ->where('pesanan_id', $pesananId)
                ->get();

            // Menambah stok produk berdasarkan jumlah yang telah diproduksi
            foreach ($pesananProduk as $item) {
                $produkUkuranId = $item->produk_ukuran_id;
                $jumlahDiproduksi = $item->jumlah;

                // Menambah jumlah stok produk sesuai dengan jumlah yang diproduksi
                DB::table('produk_ukuran')
                    ->where('id', $produkUkuranId)
                    ->increment('stok', $jumlahDiproduksi);
            }

            // Redirect atau berikan respon sesuai kebutuhan
            return redirect()->route('detail-produksi', ['id' => $pesananId])->with('success', 'Produksi selesai.');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }
}
