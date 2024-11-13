<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function pemasukkan(Request $request)
    // {
    //     if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
    //         $query = DB::table('pesanan')
    //             ->join('user', 'pesanan.user_id', '=', 'user.id')
    //             ->whereNull('pesanan.deleted_at')
    //             ->whereNotIn('pesanan.status_pembayaran', ['Batal']);

    //         // Filter berdasarkan Kode Pesanan
    //         if ($request->filled('kode')) {
    //             $query->where('pesanan.kode', 'LIKE', '%' . $request->kode . '%');
    //         }

    //         // Filter berdasarkan Tanggal
    //         if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
    //             $query->whereBetween('pesanan.created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
    //         }

    //         // Filter berdasarkan Penanggung Jawab
    //         if ($request->filled('pelanggan')) {
    //             $query->where('user.nama', 'LIKE', '%' . $request->pelanggan . '%');
    //         }

    //         // Filter berdasarkan Status Pembayaran
    //         if ($request->filled('status_pembayaran')) {
    //             $query->where('pesanan.status_pembayaran', $request->status_pembayaran);
    //         }

    //         // Filter berdasarkan Jumlah Pemasukkan
    //         if ($request->filled('jumlah') && $request->filled('jenis_jumlah')) {
    //             if ($request->jenis_jumlah == 'kurang_dari') {
    //                 $query->where('pesanan.total_jumlah', '<', $request->jumlah);
    //             } elseif ($request->jenis_jumlah == 'lebih_dari') {
    //                 $query->where('pesanan.total_jumlah', '>', $request->jumlah);
    //             }
    //         }

    //         $pemasukkan = $query->orderByDesc('pesanan.id')->get();

    //         return view('pages/admin/laporan/pemasukkan', compact('pemasukkan'));
    //     } else {
    //         return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!');
    //     }
    // }
    public function pemasukkan(Request $request)
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ' || Session::get('kode_peran_admin') == 'KKEU')) {
            $pemasukkan = $this->filterLaporanMasuk($request);

            return view('pages/admin/laporan/pemasukkan', compact('pemasukkan'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!');
        }
    }

    public function pengeluaran(Request $request)
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ' || Session::get('kode_peran_admin') == 'KKEU')) {
            $pengeluaran = $this->filterLaporanKeluar($request);

            return view('pages/admin/laporan/pengeluaran', compact('pengeluaran'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    private function filterLaporanMasuk($request)
    {
        $query = DB::table('pesanan')
            ->join('user', 'pesanan.user_id', '=', 'user.id')
            ->whereNull('pesanan.deleted_at')
            ->whereNotIn('pesanan.status_pembayaran', ['Batal'])
            ->select(
                'pesanan.id as pesanan_id',
                'user.id as user_id',
                'pesanan.kode',
                'pesanan.created_at as tanggal',
                'user.nama as nama',
                'pesanan.status_pembayaran',
                'pesanan.total_harga'
            );

        // Filter berdasarkan Kode Pesanan
        if ($request->filled('kode')) {
            $query->where('pesanan.kode', 'LIKE', '%' . $request->kode . '%');
        }

        // Filter berdasarkan Tanggal
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween(DB::raw('DATE(pesanan.created_at)'), [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        // Filter berdasarkan Pelanggan
        if ($request->filled('pelanggan')) {
            $query->where('user.nama', 'LIKE', '%' . $request->pelanggan . '%');
        }

        // Filter berdasarkan Status Pembayaran
        if ($request->filled('status_pembayaran')) {
            $query->where('pesanan.status_pembayaran', $request->status_pembayaran);
        }

        // Filter berdasarkan Jumlah Pemasukkan
        if ($request->filled('jumlah') && $request->filled('jenis_jumlah')) {
            if ($request->jenis_jumlah == 'kurang_dari') {
                $query->where('pesanan.total_harga', '<', $request->jumlah);
            } elseif ($request->jenis_jumlah == 'lebih_dari') {
                $query->where('pesanan.total_harga', '>', $request->jumlah);
            }
        }

        return $query->orderByDesc('pesanan.id')->get();
    }

    private function filterLaporanKeluar($request)
    {
        $query = DB::table('transaksi')
            ->join('user', 'transaksi.user_id', '=', 'user.id')
            ->join('supplier', 'transaksi.supplier_id', '=', 'supplier.id')
            ->select(
                'transaksi.*',
                'user.nama as nama_user',
                'supplier.nama as nama_supplier'
            )
            ->whereNull('transaksi.deleted_at')
            ->whereNotIn('transaksi.status', ['Dibatalkan']);

        // Filter berdasarkan Kode Pesanan
        if ($request->filled('kode')) {
            $query->where('transaksi.kode_transaksi', 'LIKE', '%' . $request->kode . '%');
        }

        // Filter berdasarkan Tanggal
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween(DB::raw('DATE(transaksi.created_at)'), [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        // Filter berdasarkan Penanggung Jawab
        if ($request->filled('pjawab')) {
            $query->where('user.nama', 'LIKE', '%' . $request->pjawab . '%');
        }

        // Filter berdasarkan Supplier
        if ($request->filled('supplier')) {
            $query->where('supplier.nama', 'LIKE', '%' . $request->supplier . '%');
        }

        // Filter berdasarkan Status Pembayaran
        if ($request->filled('status')) {
            $query->where('transaksi.status', $request->status);
        }

        // Filter berdasarkan Jumlah Pemasukkan
        if ($request->filled('jumlah') && $request->filled('jenis_jumlah')) {
            if ($request->jenis_jumlah == 'kurang_dari') {
                $query->where('transaksi.total_harga', '<', $request->jumlah);
            } elseif ($request->jenis_jumlah == 'lebih_dari') {
                $query->where('transaksi.total_harga', '>', $request->jumlah);
            }
        }

        // Filter berdasarkan Status Pembayaran
        if ($request->filled('cara_pengiriman')) {
            $query->where('transaksi.cara_pengiriman', $request->cara_pengiriman);
        }

        return $query->orderByDesc('transaksi.id')->get();
    }


    public function generatePDFmasuk(Request $request)
    {
        $grand_total = 0;

        // Ambil data laporan berdasarkan filter yang diterima
        $pemasukkan = $this->filterLaporanMasuk($request);

        if ($pemasukkan->isNotEmpty()) {
            // Hitung grand total hanya jika ada data
            $grand_total = $pemasukkan->sum('total_harga');
        }

        // Kirim data ke template PDF
        $pdf = Pdf::loadView('pages.admin.pdf.pemasukkan', compact('pemasukkan', 'grand_total'));

        // Simpan atau kirim PDF kepada pengguna
        return $pdf->download('laporan-pemasukkan.pdf');
    }

    public function generatePDFkeluar(Request $request)
    {
        $grand_total = 0;

        // Ambil data laporan berdasarkan filter yang diterima
        $pengeluaran = $this->filterLaporanKeluar($request);

        if ($pengeluaran->isNotEmpty()) {
            // Hitung grand total hanya jika ada data
            $grand_total = $pengeluaran->sum('total_harga');
        }

        // Kirim data ke template PDF
        $pdf = Pdf::loadView('pages.admin.pdf.pengeluaran', compact('pengeluaran', 'grand_total'));

        // Simpan atau kirim PDF kepada pengguna
        return $pdf->download('laporan-pengeluaran.pdf');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
