<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function indexadmin()
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN'
            || Session::get('kode_peran_admin') == 'KBLJ'
            || Session::get('kode_peran_admin') == 'KKEU'
            || Session::get('kode_peran_admin') == 'KPRD')) {

            // Logika untuk mendapatkan produk yang terjual paling banyak pada bulan ini
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            $topProduct = DB::table('pesanan_produk as pp')
                ->join('produk_ukuran as pu', 'pp.produk_ukuran_id', '=', 'pu.id')
                ->join('produk as p', 'pu.produk_id', '=', 'p.id')
                ->join('pesanan as pe', 'pp.pesanan_id', '=', 'pe.id')
                ->select('p.id', 'p.nama', DB::raw('SUM(pp.jumlah) as total_terjual'))
                ->whereMonth('pp.created_at', $currentMonth)
                ->whereYear('pp.created_at', $currentYear)
                ->whereNotIn('pe.status', ['Ditolak', 'Dibatalkan'])
                ->whereNull('pp.deleted_at')
                ->groupBy('p.id', 'p.nama')
                ->orderByDesc('total_terjual')
                ->first();

            $jumlahProduksi = DB::table('produksi')
                ->where('status', 'Sedang Berjalan')
                ->whereNull('deleted_at')
                ->distinct('pesanan_id')
                ->count('pesanan_id');

            $produksiTerakhir = DB::table('produksi')
                ->whereNull('deleted_at')
                ->max('created_at');

            $resultPesanan = DB::table('pesanan')
                ->select(
                    DB::raw('COUNT(id) as total_pesanan'),
                    DB::raw('MAX(created_at) as pesanan_terakhir')
                )
                ->whereIn('status', ['Menunggu Konfirmasi', 'Dikonfirmasi', 'Menunggu', 'Sedang Produksi', 'Selesai Produksi', 'Pengiriman', 'Selesai'])
                ->whereMonth('created_at', '=', date('m'))
                ->whereYear('created_at', '=', date('Y'))
                ->whereNull('deleted_at')
                ->first();

            $pesananMenunggu = DB::table('pesanan')
                ->select(
                    DB::raw('COUNT(id) as total_pesanan'),
                    DB::raw('MAX(created_at) as pesanan_terakhir')
                )
                ->whereIn('status', ['Menunggu Konfirmasi'])
                ->whereMonth('created_at', '=', date('m'))
                ->whereYear('created_at', '=', date('Y'))
                ->whereNull('deleted_at')
                ->first();

            $pesananSiapProduksi = DB::table('pesanan')
                ->select(
                    DB::raw('COUNT(id) as total_pesanan'),
                    DB::raw('MAX(created_at) as pesanan_terakhir')
                )
                ->whereIn('status', ['Menunggu'])
                ->whereMonth('created_at', '=', date('m'))
                ->whereYear('created_at', '=', date('Y'))
                ->whereNull('deleted_at')
                ->first();

            $resultTransaksi = DB::table('transaksi')
                ->select(
                    DB::raw('COUNT(id) as total_transaksi'),
                    DB::raw('MAX(created_at) as transaksi_terakhir')
                )
                ->whereIn('status', ['Menunggu', 'Selesai'])
                ->whereMonth('created_at', '=', date('m'))
                ->whereYear('created_at', '=', date('Y'))
                ->whereNull('deleted_at')
                ->first();

            $bulanList = DB::table(DB::raw('(SELECT DATE_FORMAT(CURDATE() - INTERVAL (a.a) MONTH, "%Y-%m") AS bulan
                FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6) AS a) bulan_list'))
                ->select('bulan')
                ->where('bulan', '>=', DB::raw('DATE_FORMAT(CURDATE() - INTERVAL 6 MONTH, "%Y-%m")'));

            $jumlahPesanan = DB::table(DB::raw('(' . $bulanList->toSql() . ') as bulan_list'))
                ->leftJoin('pesanan', function ($join) {
                    $join->on(DB::raw('DATE_FORMAT(pesanan.created_at, "%Y-%m")'), '=', 'bulan_list.bulan')
                        ->whereIn('pesanan.status', ['Menunggu Konfirmasi', 'Dikonfirmasi', 'Menunggu', 'Sedang Produksi', 'Selesai Produksi', 'Pengiriman', 'Selesai'])
                        ->whereNull('pesanan.deleted_at');
                })
                ->select(
                    DB::raw('bulan_list.bulan AS bulan'),
                    DB::raw('COALESCE(COUNT(pesanan.id), 0) AS jumlah_pesanan'),
                    DB::raw('COALESCE(SUM(pesanan.total_harga), 0) AS total_harga_pesanan')
                )
                ->groupBy('bulan_list.bulan')
                ->orderBy('bulan_list.bulan', 'ASC')
                ->mergeBindings($bulanList) // Menggabungkan parameter dari subquery
                ->get();

            $jumlahTransaksi = DB::table(DB::raw('(' . $bulanList->toSql() . ') as bulan_list'))
                ->leftJoin('transaksi', function ($join) {
                    $join->on(DB::raw('DATE_FORMAT(transaksi.created_at, "%Y-%m")'), '=', 'bulan_list.bulan')
                        ->whereIn('transaksi.status', ['Menunggu', 'Selesai'])
                        ->whereNull('transaksi.deleted_at');
                })
                ->select(
                    DB::raw('bulan_list.bulan AS bulan'),
                    DB::raw('COALESCE(COUNT(transaksi.id), 0) AS jumlah_transaksi'),
                    DB::raw('COALESCE(SUM(transaksi.total_harga), 0) AS total_harga_transaksi')
                )
                ->groupBy('bulan_list.bulan')
                ->orderBy('bulan_list.bulan', 'ASC')
                ->mergeBindings($bulanList) // Menggabungkan parameter dari subquery
                ->get();

            $jumlahProduksi2 = DB::table(DB::raw('(' . $bulanList->toSql() . ') as bulan_list'))
                ->leftJoin('produksi', function ($join) {
                    $join->on(DB::raw('DATE_FORMAT(produksi.created_at, "%Y-%m")'), '=', 'bulan_list.bulan')
                        ->whereIn('produksi.status', ['Selesai', 'Sedang Berjalan'])
                        ->whereNull('produksi.deleted_at');
                })
                ->select(
                    DB::raw('bulan_list.bulan AS bulan'),
                    DB::raw('COALESCE(COUNT(produksi.pesanan_id), 0) AS jumlah_produksi'),
                )
                ->groupBy('bulan_list.bulan')
                ->orderBy('bulan_list.bulan', 'ASC')
                ->mergeBindings($bulanList) // Menggabungkan parameter dari subquery
                ->get();

            $stokBahanBaku = DB::table('pesanan_produk')
                ->join('pesanan', 'pesanan_produk.pesanan_id', '=', 'pesanan.id')
                ->join('produk_ukuran', 'pesanan_produk.produk_ukuran_id', '=', 'produk_ukuran.id')
                ->join('produk', 'produk_ukuran.produk_id', '=', 'produk.id')
                ->join('bahan_baku_produk', 'produk.id', '=', 'bahan_baku_produk.produk_id')
                ->join('bahan_baku', 'bahan_baku_produk.bahan_baku_id', '=', 'bahan_baku.id')
                ->select(
                    'bahan_baku.nama as nama_bahan_baku',
                    DB::raw('SUM(bahan_baku_produk.jumlah * pesanan_produk.jumlah) as total_jumlah_bahan_baku'),
                    'bahan_baku.jenis_satuan',
                    'bahan_baku.stok_kuantitas as stok_bahan_baku',
                    DB::raw('bahan_baku.stok_kuantitas - SUM(bahan_baku_produk.jumlah * pesanan_produk.jumlah) as sisa_stok_bahan_baku')
                )
                ->whereIn('pesanan.status', ['Menunggu Konfirmasi', 'Dikonfirmasi', 'Menunggu'])
                ->groupBy('bahan_baku.nama', 'bahan_baku.jenis_satuan', 'bahan_baku.stok_kuantitas')
                ->orderBy('bahan_baku.nama')
                ->get();

            $labaRugi = $jumlahPesanan->map(function ($pesanan) use ($jumlahTransaksi) {
                $transaksi = $jumlahTransaksi->firstWhere('bulan', $pesanan->bulan);
                $totalHargaTransaksi = $transaksi ? $transaksi->total_harga_transaksi : 0;
                $labaRugiBulan = $pesanan->total_harga_pesanan - $totalHargaTransaksi;
                return (object) [
                    'bulan' => $pesanan->bulan,
                    'total_harga_pesanan' => $pesanan->total_harga_pesanan,
                    'total_harga_transaksi' => $totalHargaTransaksi,
                    'laba_rugi' => $labaRugiBulan,
                ];
            });

            return view('pages/admin/dashboard', compact(
                'topProduct',
                'jumlahProduksi',
                'produksiTerakhir',
                'resultPesanan',
                'pesananMenunggu',
                'pesananSiapProduksi',
                'resultTransaksi',
                'jumlahPesanan',
                'jumlahTransaksi',
                'jumlahProduksi2',
                'stokBahanBaku', 
                'labaRugi'
            ));
        } elseif (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'CUST') {
            Session::flush();
            return redirect('/login');
        } else {
            return redirect('/admin/login'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function indexuser()
    {
        // if (Session::has('nama_peran') && (Session::get('kode_peran') == 'ADMN' || Session::get('kode_peran') == 'KBLJ' || Session::get('kode_peran') == 'KKEU' || Session::get('kode_peran') == 'KPROD' || Session::get('kode_peran') == 'CUST')) {
        $produk = DB::table('produk')
            ->where('status', 'Tersedia')
            ->whereNull('deleted_at') // Menambahkan kondisi untuk mengecualikan yang telah di-soft delete
            ->get();

        $thirtyDaysAgo = Carbon::now()->subDays(30);

        $pesanan = DB::table('pesanan')
            ->where('user_id', session('user_id'))
            ->whereNull('deleted_at') // Menambahkan kondisi untuk mengecualikan yang telah di-soft delete
            ->whereDate('tanggal', '>=', $thirtyDaysAgo)
            ->count('id');
        // dd($pesanan);

        $menunggu = DB::table('pesanan')
            ->where('user_id', session('user_id'))
            ->where('status', 'Menunggu Konfirmasi')
            ->whereNull('deleted_at')
            ->count('id');

        $belumlunas = DB::table('pesanan')
            ->where('user_id', session('user_id'))
            ->where('status_pembayaran', ['Menunggu Pembayaran', 'Menunggu Pelunasan'])
            ->whereNull('deleted_at')
            ->count('id');

        return view('pages/user/dashboard', compact('produk', 'pesanan', 'menunggu', 'belumlunas'));
        // } else {
        // return redirect('/admin/login'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        // }
    }
}
