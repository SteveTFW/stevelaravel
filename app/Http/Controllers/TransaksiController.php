<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ')) {
            $transaksi = DB::table('transaksi')
                ->join('user', 'transaksi.user_id', '=', 'user.id')
                ->join('supplier', 'transaksi.supplier_id', '=', 'supplier.id')
                ->select('transaksi.*', 'supplier.nama as nama_supplier', 'user.nama as user_name')
                ->whereNull('transaksi.deleted_at') // Tambahkan pengecualian untuk deleted_at null
                ->orderBy('transaksi.id', 'desc')
                ->get();

            $transaksiGrouped = $transaksi->groupBy('kode_transaksi')->map(function ($items) {
                return [
                    'id' => $items->first()->id,
                    'kode_transaksi' => $items->first()->kode_transaksi,
                    'user_name' => $items->first()->user_name,
                    'tanggal' => $items->first()->tanggal,
                    'nama_supplier' => $items->first()->nama_supplier,
                    'total_harga' => $items->sum('total_harga'),
                    'metode_pembayaran' => $items->first()->metode_pembayaran,
                    'status' => $items->first()->status,
                    'cara_pengiriman' => $items->first()->cara_pengiriman,
                    'catatan_tambahan' => $items->first()->catatan_tambahan,
                    'created_at' => $items->max('created_at'), // Ambil waktu pembuatan terakhir
                    'updated_at' => $items->max('updated_at'), // Ambil waktu pembaruan terakhir
                    // Tambahkan kolom lain yang ingin Anda tampilkan atau manipulasi
                ];
            });

            $transaksiGrouped = $transaksiGrouped->values()->all();

            // dd($transaksiGrouped);

            return view('pages/admin/transaksi/listbelibahanbaku', compact('transaksiGrouped'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ')) {
            $suppliers = DB::table('supplier')
                ->whereNull('deleted_at')
                ->get();

            $bahanBakuSuppliers = DB::table('bahan_baku_supplier')
                ->orderBy('supplier_id', 'asc')
                ->orderBy('bahan_baku_id', 'asc')
                ->whereNull('deleted_at')
                ->get();

            return view('pages/admin/transaksi/tambahtransaksi', compact('suppliers', 'bahanBakuSuppliers'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function getBahanBakuSupplier($supplierId)
    {
        // Query untuk mengambil bahan baku supplier berdasarkan supplier_id yang dipilih
        $bahanBakuSuppliers = DB::table('bahan_baku_supplier')
            ->join('bahan_baku', 'bahan_baku_supplier.bahan_baku_id', '=', 'bahan_baku.id')
            ->where('bahan_baku_supplier.supplier_id', $supplierId)
            ->whereNull('bahan_baku_supplier.deleted_at')
            ->select('bahan_baku.id', 'bahan_baku.nama as bahan_baku_nama', 'bahan_baku.jenis_satuan as jenis_satuan')
            ->orderBy('bahan_baku.nama')
            ->get();

        return response()->json($bahanBakuSuppliers);
    }

    private function generateKodeTransaksi($userId)
    {
        // Mendapatkan jumlah transaksi pada hari ini menggunakan Query Builder
        $jumlahTransaksi = DB::table('transaksi')
            ->whereDate('tanggal', now())
            ->where('user_id', $userId) // Sesuaikan dengan nama kolom user ID di tabel transaksi
            ->count();

        // Format kode transaksi: T-YYYYMMDD-<jumlah transaksi hari ini + 1>
        $urutanTransaksi = $jumlahTransaksi + 1;
        $kodeTransaksi = 'T-' . now()->format('Ymd') . '-' . session('user_id_admin') . '-' . $urutanTransaksi;

        return $kodeTransaksi;
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     // Validasi data yang diterima dari form
    //     $request->validate([
    //         'supplier' => 'required',
    //         'metode_pembayaran' => 'required',
    //         'cara_pengiriman' => 'required',
    //         // 'bahan_baku_data' => 'required'
    //     ]);

    //     // Ambil data dari form
    //     $supplierId = $request->supplier;
    //     $metodePembayaran = $request->metode_pembayaran;
    //     $caraPengiriman = $request->cara_pengiriman;
    //     $catatanTambahan = $request->catatan_tambahan ?? 'Tidak ada catatan tambahan';
    //     $totalharga = $_POST['total_harga'];
    //     dd($totalharga);

    //     // Mendapatkan user_id dari sesi atau pengguna saat ini
    //     $userId = session('user_id_admin'); // Sesuaikan dengan implementasi autentikasi Anda

    //     // Hitung jumlah transaksi pada hari ini untuk mendapatkan urutan transaksi
    //     $kodeTransaksi = $this->generateKodeTransaksi($userId);

    //     // Mulai transaksi database menggunakan Query Builder
    //     try {
    //         DB::beginTransaction();

    //         // Simpan data transaksi ke dalam tabel transaksi
    //         DB::table('transaksi')->insert([
    //             'kode_transaksi' => $kodeTransaksi,
    //             'user_id' => $userId,
    //             'tanggal' => now(),
    //             'supplier_id' => $supplierId,
    //             'total_harga' => $totalharga,
    //             'metode_pembayaran' => $metodePembayaran,
    //             'cara_pengiriman' => $caraPengiriman,
    //             'catatan_tambahan' => $catatanTambahan,
    //             'status' => 'Menunggu', // Secara default status Menunggu
    //             // Tambahkan properti lain sesuai kebutuhan
    //         ]);

    //         // Selesai transaksi database
    //         DB::commit();

    //         return redirect()->route('list-transaksi')->with('success', 'Transaksi berhasil ditambahkan.');
    //     } catch (\Exception $e) {
    //         // Jika terjadi kesalahan, rollback transaksi
    //         DB::rollback();
    //         return redirect()->back()->withInput()->with('error', 'Gagal menambahkan transaksi. Silakan coba lagi.');
    //     }
    // }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'supplier' => 'required',
            'metode_pembayaran' => 'required',
            'cara_pengiriman' => 'required',
            'total_harga' => 'required|numeric',
            'bahan_baku_data' => 'required|json'
        ]);

        // Ambil data dari form
        $supplierId = $request->supplier;
        $metodePembayaran = $request->metode_pembayaran;
        $caraPengiriman = $request->cara_pengiriman;
        $catatanTambahan = $request->catatan_tambahan ?? 'Tidak ada catatan tambahan';

        $bahanBakuData = json_decode($request->bahan_baku_data, true); // Decode JSON data

        // dd($bahanBakuData);
        
        $totalHarga = 0;
        foreach ($bahanBakuData as $bahanBaku) {
            // Validasi input jumlah dan harga sebelum menggunakan dalam perhitungan
            $jumlah = isset($bahanBaku['jumlah']) ? $bahanBaku['jumlah'] : 0;
            $harga = isset($bahanBaku['harga']) ? $bahanBaku['harga'] : 0;

            // Hitung total harga per bahan baku
            $totalHarga += $jumlah * $harga;
        }
        // dd($totalHarga);

        $userId = session('user_id_admin');

        $kodeTransaksi = $this->generateKodeTransaksi($userId);

        // Mulai transaksi database menggunakan Query Builder
        try {
            DB::beginTransaction();

            // Simpan data transaksi ke dalam tabel transaksi
            $transaksiId = DB::table('transaksi')->insertGetId([
                'kode_transaksi' => $kodeTransaksi,
                'user_id' => $userId,
                'tanggal' => now(),
                'supplier_id' => $supplierId,
                'total_harga' => $totalHarga,
                'metode_pembayaran' => $metodePembayaran,
                'cara_pengiriman' => $caraPengiriman,
                'catatan_tambahan' => $catatanTambahan,
                'status' => 'Menunggu', // Secara default status Menunggu
                // Tambahkan properti lain sesuai kebutuhan
            ]);

            // Simpan data bahan baku ke dalam tabel transaksi_bahan_baku
            foreach ($bahanBakuData as $bahanBaku) {
                DB::table('transaksi_bahan_baku')->insert([
                    'transaksi_id' => $transaksiId,
                    'bahan_baku_id' => $bahanBaku['bahan_baku_id'],
                    'jumlah' => $bahanBaku['jumlah'],
                    'harga' => $bahanBaku['jumlah'] * $bahanBaku['harga']
                ]);
            }

            // Selesai transaksi database
            DB::commit();

            return redirect()->route('list-transaksi')->with('success', 'Transaksi berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, rollback transaksi
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan transaksi. Silakan coba lagi.');
        }
    }

    public function updateStok(Request $request)
    {
        $transaksiId = $request->input('transaksi_id');
        $bahanBakuIds = $request->input('bahan_baku_ids');
        $jumlahs = $request->input('jumlahs');
        // dd($transaksiId);
        try {
            DB::beginTransaction();

            foreach ($bahanBakuIds as $index => $bahanBakuId) {
                $jumlah = $jumlahs[$index];

                // Update stok bahan baku
                DB::table('bahan_baku')
                    ->where('id', $bahanBakuId)
                    ->increment('stok_kuantitas', $jumlah);
            }

            DB::table('transaksi')
                ->where('id', $transaksiId)
                ->update(['status' => 'Selesai']);

            DB::commit();

            return redirect()->back()->with('success', 'Stok berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui stok: ' . $e->getMessage());
        }
    }

    public function batalTransaksi(Request $request)
    {
        // Mengambil ID transaksi dari request
        $transaksiId = $request->input('transaksi_id');

        // Memeriksa apakah pengguna memiliki akses untuk melakukan aksi ini
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ')) {
            // Melakukan update status transaksi dan status pembayaran menggunakan Query Builder
            DB::table('transaksi')
                ->where('id', $transaksiId)
                ->update(['status' => 'Dibatalkan']);

            return redirect()->back()->with('success', 'Transaksi berhasil dibatalkan');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ')) {
            $transaksi = DB::table('transaksi')->where('id', $id)->first();

            $suppliers = DB::table('supplier')
                ->whereNull('deleted_at')
                ->get();
            return view('pages/admin/transaksi/ubahtransaksi', compact('transaksi', 'suppliers'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ')) {
            // Validasi input
            $request->validate([
                'total_harga' => 'required|numeric',
                'metode_pembayaran' => 'required|string',
                'cara_pengiriman' => 'required|string',
                'catatan_tambahan' => 'nullable|string',
            ]);

            // Siapkan data untuk diupdate
            $data = [
                'supplier_id' => $request->input('supplier'),
                'total_harga' => $request->input('total_harga'),
                'metode_pembayaran' => $request->input('metode_pembayaran'),
                'cara_pengiriman' => $request->input('cara_pengiriman'),
                'catatan_tambahan' => $request->input('catatan_tambahan', 'Tidak ada catatan tambahan'), // Default value if null
                'status' => $request->input('status'),
                'updated_at' => now(), // Update timestamp
            ];

            // Update data transaksi menggunakan Query Builder
            DB::table('transaksi')->where('id', $id)->update($data);

            // Redirect ke halaman daftar transaksi dengan pesan sukses
            return redirect()->route('list-transaksi')->with('success', 'Transaksi berhasil diubah.');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ')) {

            // Hapus transaksi berdasarkan kode transaksi
            DB::table('transaksi')->where('id', $id)->delete();

            return redirect()->back()->with('success', 'Transaksi berhasil dihapus');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function detailTransaksi($id)
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ')) {

            // Ambil data transaksi berdasarkan kode transaksi
            $transaksiDetail = DB::table('transaksi_bahan_baku')
                ->join('transaksi', 'transaksi_bahan_baku.transaksi_id', '=', 'transaksi.id')
                ->join('user', 'transaksi.user_id', '=', 'user.id')
                ->join('bahan_baku', 'transaksi_bahan_baku.bahan_baku_id', '=', 'bahan_baku.id')
                ->join('supplier', 'transaksi.supplier_id', '=', 'supplier.id')
                ->where('transaksi_bahan_baku.transaksi_id', $id)
                ->whereNull('transaksi_bahan_baku.deleted_at')
                ->select('transaksi.*', 'transaksi_bahan_baku.*', 'supplier.nama as nama_supplier', 'user.nama as nama_user', 'bahan_baku.nama as nama_bahan_baku')
                ->get();

            return view('pages/admin/transaksi/detailbelibahanbaku', compact('transaksiDetail'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }
}
