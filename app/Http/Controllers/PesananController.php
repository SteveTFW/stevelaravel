<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ' || Session::get('kode_peran_admin') == 'KPRD')) {
            $pesanan = DB::table('pesanan')
                ->join('user', 'pesanan.user_id', '=', 'user.id')
                ->select('pesanan.*', 'user.nama as user_name')
                ->whereNull('pesanan.deleted_at')
                ->orderBy('id', 'desc')
                ->get();
            // dd($pesanan);
            return view('pages/admin/transaksi/listpesanan', compact('pesanan'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function show($id)
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ' || Session::get('kode_peran_admin') == 'KPRD')) {
            $pesanan = DB::table('pesanan')
                ->join('user', 'pesanan.user_id', '=', 'user.id')
                ->select('pesanan.*', 'user.*', 'pesanan.id as id_pesanan')
                ->where('pesanan.id', $id)
                ->get();

            $pesananproduk = DB::table('pesanan_produk')
                ->join('produk_ukuran', 'pesanan_produk.produk_ukuran_id', '=', 'produk_ukuran.id')
                ->join('produk', 'produk_ukuran.produk_id', '=', 'produk.id')
                ->where('pesanan_produk.pesanan_id', $id)
                ->get(['pesanan_produk.*', 'produk.nama as nama_produk', 'produk.gambar as gambar_produk', 'produk_ukuran.ukuran as ukuran_produk', 'produk_ukuran.harga as harga_produk']);

            $bahanBakuProduk = DB::table('pesanan_produk')
                ->join('produk_ukuran', 'pesanan_produk.produk_ukuran_id', '=', 'produk_ukuran.id')
                ->join('produk', 'produk_ukuran.produk_id', '=', 'produk.id')
                ->join('bahan_baku_produk', 'produk.id', '=', 'bahan_baku_produk.produk_id')
                ->join('bahan_baku', 'bahan_baku_produk.bahan_baku_id', '=', 'bahan_baku.id')
                ->select(
                    'produk.nama',
                    'produk_ukuran.ukuran',
                    'bahan_baku.nama as nama_bahan_baku',
                    DB::raw('bahan_baku_produk.jumlah * pesanan_produk.jumlah as jumlah_bahan_baku'),
                    'bahan_baku.jenis_satuan'
                )
                ->where('pesanan_produk.pesanan_id', $id)
                ->orderBy('produk.id')
                ->get();

            $stokBahanBaku = DB::table('pesanan_produk')
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
                ->where('pesanan_produk.pesanan_id', $id)
                ->groupBy('bahan_baku.nama', 'bahan_baku.jenis_satuan', 'bahan_baku.stok_kuantitas')
                ->orderBy('bahan_baku.nama')
                ->get();

            $finalproduk = DB::table('pesanan_produk')
                ->join('produk_ukuran', 'pesanan_produk.produk_ukuran_id', '=', 'produk_ukuran.id')
                ->join('produk', 'produk_ukuran.produk_id', '=', 'produk.id')
                ->join('bahan_baku_produk', 'produk.id', '=', 'bahan_baku_produk.produk_id')
                ->join('bahan_baku', 'bahan_baku_produk.bahan_baku_id', '=', 'bahan_baku.id')
                ->where('pesanan_produk.pesanan_id', $id)
                ->orderBy('pesanan_produk.produk_ukuran_id')
                ->get([
                    'pesanan_produk.*',
                    'produk.nama as nama_produk',
                    'produk.gambar as gambar_produk',
                    'produk_ukuran.ukuran as ukuran_produk',
                    'produk_ukuran.harga as harga_produk',
                    'bahan_baku.nama as nama_bahan_baku',
                    DB::raw('bahan_baku_produk.jumlah * pesanan_produk.jumlah as jumlah_bahan_baku'),
                    'bahan_baku.jenis_satuan'
                ]);

            $groupedPesananProduk = $finalproduk->groupBy(['pesanan_id', 'produk_ukuran_id']);
            // dd($groupedPesananProduk);

            return view('pages/admin/transaksi/detailpesanan', compact('pesanan', 'pesananproduk', 'bahanBakuProduk', 'stokBahanBaku', 'groupedPesananProduk'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    private static function getUrutanPesananHariIni($userid)
    {
        // Mendapatkan jumlah pesanan pada hari ini menggunakan Query Builder
        $jumlahPesanan = DB::table('pesanan')
            ->whereDate('tanggal', now())
            ->where('user_id', $userid) // Sesuaikan dengan nama kolom user ID di tabel pesanan
            ->count();

        // Menambahkan 1 untuk mendapatkan urutan pesanan ke-x
        return $jumlahPesanan + 1;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ')) {

            // Ambil data pesanan berdasarkan ID menggunakan Query Builder
            $pesanan = DB::table('pesanan')->where('id', $id)->first();

            // Tampilkan halaman ubahpesanan.blade.php dengan membawa data pesanan
            return view('pages/admin/transaksi/ubahpesanan', compact('pesanan'));
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

            // Validasi data yang diterima dari formulir
            $request->validate([
                'alamat' => 'required|string',
                'metode_pembayaran' => 'required|in:cod,transfer',
                'total_harga' => 'required|numeric',
            ]);

            // Proses penyimpanan data menggunakan SQL Query Builder
            $data = [
                'alamat_pengiriman' => $request->input('alamat'),
                'metode_pembayaran' => $request->input('metode_pembayaran'),
                'total_harga' => $request->input('total_harga'),
                'status' => $request->input('status'),
                'status_pembayaran' => $request->input('status_pembayaran'),
                'catatan_tambahan' => $request->input('catatan'),
            ];

            // Update data pesanan
            DB::table('pesanan')->where('id', $id)->update($data);

            // Redirect atau berikan respons sesuai kebutuhan
            return redirect()->route('list-pesanan')->with('success', 'Pesanan berhasil diubah');
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
            DB::table('pesanan')->where('id', $id)->update(['deleted_at' => now()]);

            return redirect()->back()->with('success', 'Pesanan berhasil dihapus');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!');
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function simpanpesanan(Request $request)
    {
        if (Session::has('nama_peran') && Session::get('kode_peran') == 'CUST') {
            if (Session::get('alamat') != '' || Session::get('nomor_telepon') != '') {
                // Mendapatkan tanggal hari ini dalam format YYYYMMDD
                $tanggalHariIni = Carbon::now()->format('Ymd');
                // Mendapatkan urutan pesanan ke-x pada hari ini
                $urutanPesanan = self::getUrutanPesananHariIni(session('user_id'));
                // Membuat kode unik
                $kodeUnik = "P-{$tanggalHariIni}-" . session('user_id') . "-{$urutanPesanan}";

                $totalProduk = DB::table('keranjang')
                    ->where('user_id', session('user_id'))
                    ->sum('jumlah');

                $tglEstimasi = Carbon::now();
                if ($totalProduk < 50) {
                    $tglEstimasi = $tglEstimasi->addWeek();
                } elseif ($totalProduk >= 50 && $totalProduk < 100) {
                    $tglEstimasi = $tglEstimasi->addWeeks(2);
                } elseif ($totalProduk >= 100 && $totalProduk < 150) {
                    $tglEstimasi = $tglEstimasi->addWeeks(3);
                } elseif ($totalProduk >= 150 && $totalProduk < 200) {
                    $tglEstimasi = $tglEstimasi->addWeeks(4);
                } else {
                    $tglEstimasi = $tglEstimasi->addWeeks(5);
                }

                // Masukkan data ke dalam tabel pesanan
                $pesananId = DB::table('pesanan')->insertGetId([
                    'user_id' => session('user_id'),
                    'kode' => $kodeUnik,
                    'tanggal' => now(),
                    'alamat_pengiriman' => session('alamat'),
                    'metode_pembayaran' => $request->input('metode_pembayaran'),
                    'total_harga' => $request->input('total_harga'),
                    'status_pembayaran' => $request->input('status_pembayaran'),
                    'status' => 'Menunggu Konfirmasi',
                    'tgl_estimasi' => $tglEstimasi,
                ]);

                DB::table('pesanan_produk')->insertUsing(
                    ['pesanan_id', 'produk_ukuran_id', 'jumlah', 'harga', 'catatan'],
                    function ($query) use ($pesananId) {
                        $query->select([
                            DB::raw($pesananId),
                            'keranjang.produk_ukuran_id',
                            'keranjang.jumlah',
                            DB::raw('(SELECT harga FROM produk_ukuran WHERE id = keranjang.produk_ukuran_id) as harga'),
                            'keranjang.catatan',
                        ])->from('keranjang')
                            ->where('keranjang.user_id', session('user_id'))
                            ->whereNull('keranjang.deleted_at'); // Tambahkan syarat deleted_at NULL
                    }
                );

                // 3. Update field 'deleted_at' di tabel 'keranjang' setelah pemindahan item ke dalam pesanan
                DB::table('keranjang')
                    ->where('user_id', session('user_id'))
                    ->delete();

                return redirect()->route('show-pesanan', ['id' => session('user_id')])->with('success', 'Pesanan berhasil ditambahkan!');
            } else {
                return redirect()->back()->with('error', 'Mohon mengisi alamat dan nomor telepon terlebih dahulu!');
            }
        } else {
            return redirect('/login')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function showpesanan($id)
    {
        if (Session::has('nama_peran') && Session::get('kode_peran') == 'CUST') {
            $pesanan = DB::table('pesanan as pe')
                ->select('pe.*', 'p.nama', 'pu.ukuran', 'pp.jumlah', DB::raw('(pp.jumlah * pp.harga) AS harga'))
                ->join('pesanan_produk as pp', 'pe.id', '=', 'pp.pesanan_id')
                ->join('produk_ukuran as pu', 'pp.produk_ukuran_id', '=', 'pu.id')
                ->join('produk as p', 'pu.produk_id', '=', 'p.id')
                ->where('pe.user_id', $id)
                ->where(function ($query) {
                    $query->where('pe.status_pembayaran', 'Menunggu Pembayaran')
                        ->orWhere('pe.status_pembayaran', 'Menunggu Pelunasan');
                })
                ->whereNull('pe.deleted_at')
                ->get();

            $groupedPesanan = $pesanan->groupBy('id');

            return view('pages/user/pemesanan/pembayaran', compact('pesanan', 'groupedPesanan'));
        } else {
            return redirect('/login')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    /**
     * Display the specified resource.
     */
    public function showdetailpesanan($id)
    {
        if (Session::has('nama_peran') && Session::get('kode_peran') == 'CUST') {
            $pesanan = DB::table('pesanan')
                ->where('id', $id)
                ->get();
            // dd($pesanan->first()->snap_token);

            $pesananproduk = DB::table('pesanan_produk')
                ->join('produk_ukuran', 'pesanan_produk.produk_ukuran_id', '=', 'produk_ukuran.id')
                ->join('produk', 'produk_ukuran.produk_id', '=', 'produk.id')
                ->where('pesanan_produk.pesanan_id', $id)
                ->get(['pesanan_produk.*', 'produk.nama as nama_produk', 'produk_ukuran.ukuran as ukuran_produk', 'produk_ukuran.harga as harga_produk']);

            // Session::forget('pesanan_id');
            // Session::put('pesanan_id', $id);
            // dd(session('pesanan_id'));

            $snapToken = $pesanan->first()->snap_token;
            // if (is_null($snapToken)) {
            // If snap token is still NULL, generate snap token and save it to database
            if ($pesanan->first()->status_pembayaran == 'Menunggu Pembayaran' && $pesanan->first()->status == 'Dikonfirmasi') {
                if (is_null($snapToken)) {
                    $midtrans = new CreateSnapTokenService($id);
                    $snapToken = $midtrans->getSnapToken($id);
                    // dd($snapToken);
                    DB::table('pesanan')
                        ->where('id', $id)
                        ->update(['snap_token' => $snapToken]);
                }
            } elseif ($pesanan->first()->status_pembayaran == 'Menunggu Pelunasan') {
                if (is_null($snapToken)) {
                    $midtrans = new CreateSnapTokenService($id);
                    $snapToken = $midtrans->getSnapToken($id);
                    // dd($snapToken);
                    DB::table('pesanan')
                        ->where('id', $id)
                        ->update(['snap_token' => $snapToken]);
                }
            }
            return view('/pages/user/pemesanan/payment', compact('pesanan', 'pesananproduk', 'snapToken'));
        } else {
            return redirect('/login')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function showallpesanan($id)
    {
        if (Session::has('nama_peran') && Session::get('kode_peran') == 'CUST') {
            $pesanan = DB::table('pesanan as pe')
                ->select('pe.*', 'p.nama', 'pu.ukuran', 'pp.jumlah', DB::raw('(pp.jumlah * pp.harga) AS harga'))
                ->join('pesanan_produk as pp', 'pe.id', '=', 'pp.pesanan_id')
                ->join('produk_ukuran as pu', 'pp.produk_ukuran_id', '=', 'pu.id')
                ->join('produk as p', 'pu.produk_id', '=', 'p.id')
                ->where('pe.user_id', $id)
                ->whereNull('pe.deleted_at')
                ->orderBy('pe.id', 'desc') // Menambahkan ORDER BY untuk mengurutkan berdasarkan kolom 'id'
                ->get();

            $groupedPesanan = $pesanan->groupBy('id');

            return view('pages/user/pemesanan/riwayat', compact('pesanan', 'groupedPesanan'));
        } else {
            return redirect('/login')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function batalpesanan($id)
    {
        // Cari pesanan berdasarkan ID dan periksa statusnya
        $pesanan = DB::table('pesanan')
            ->where('id', $id)
            ->whereIn('status', ['Menunggu Konfirmasi', 'Dikonfirmasi'])
            ->first();

        // Jika pesanan ditemukan dan statusnya dapat dibatalkan
        if ($pesanan) {
            // Ubah status pesanan menjadi 'Dibatalkan'
            DB::table('pesanan')
                ->where('id', $id)
                ->update([
                    'status' => 'Dibatalkan',
                    'status_pembayaran' => 'Batal'
                ]);

            // Tambahkan pesan sukses
            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        // Tambahkan pesan error
        return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
    }


    public function updatestatuspembayaran(Request $request, $id)
    {
        // Validasi request jika diperlukan
        $pesanan = DB::table('pesanan')
            ->where('id', $id)
            ->get();

        if ($pesanan->first()->status_pembayaran == 'Menunggu Pembayaran') {

            // Ubah status pesanan berdasarkan $pesananId
            $affectedRows = DB::table('pesanan') // Ganti 'nama_tabel_pesanan' sesuai dengan nama tabel yang digunakan
                ->where('id', $id) // Ganti 'id' sesuai dengan kolom primary key pada tabel pesanan
                ->update([
                    'status_pembayaran' => 'Sudah Bayar DP',
                    'status' => 'Menunggu',
                    'tgl_dp' => now(),
                    'snap_token' => null,
                ]);

            if ($affectedRows > 0) {
                return response()->json(['message' => 'Status pesanan berhasil diperbarui'], 200);
            }

            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        } elseif ($pesanan->first()->status_pembayaran == 'Menunggu Pelunasan') {

            // Ubah status pesanan berdasarkan $pesananId
            $affectedRows = DB::table('pesanan') // Ganti 'nama_tabel_pesanan' sesuai dengan nama tabel yang digunakan
                ->where('id', $id) // Ganti 'id' sesuai dengan kolom primary key pada tabel pesanan
                ->update([
                    'status_pembayaran' => 'Sudah Dibayar',
                    'status' => 'Selesai Produksi',
                    'tgl_lunas' => now(),
                ]);

            if ($affectedRows > 0) {
                return response()->json(['message' => 'Status pesanan berhasil diperbarui'], 200);
            }

            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }
    }

    public function ubahstatuspesanan(Request $request, $id)
    {
        // Ambil status yang diinginkan dari request
        $status = $request->input('status'); // Dianggap ada input 'status' pada form

        $statusPembayaran = ($status == 'Ditolak') ? 'Batal' : 'Menunggu Pembayaran';

        // Lakukan update status pesanan berdasarkan $id
        $affectedRows = DB::table('pesanan')
            ->where('id', $id)
            ->update([
                'status' => $status,
                'status_pembayaran' => $statusPembayaran,
            ]);

        if ($affectedRows > 0) {
            return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui status pesanan');
    }

    public function mintalunas(Request $request, $id)
    {
        $affectedRows = DB::table('pesanan')
            ->where('id', $id)
            ->update([
                'status_pembayaran' => 'Menunggu Pelunasan',
            ]);

        if ($affectedRows > 0) {
            return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui status pesanan');
    }

    public function mintakirim(Request $request, $id)
    {
        // Ambil data pesanan
        $pesanan = DB::table('pesanan')->find($id);

        // Periksa apakah pesanan ditemukan
        if ($pesanan) {
            // Ambil detail pesanan
            $pesananProduk = DB::table('pesanan_produk')
                ->where('pesanan_id', $id)
                ->get();

            // Lakukan pengecekan stok
            $stokCukup = true;
            foreach ($pesananProduk as $item) {
                $stok = DB::table('produk_ukuran')
                    ->where('id', $item->produk_ukuran_id)
                    ->value('stok');

                // Jika stok tidak mencukupi, set flag $stokCukup menjadi false
                if ($stok < $item->jumlah) {
                    $stokCukup = false;
                    break; // Berhenti loop jika stok tidak mencukupi untuk salah satu produk
                }
            }

            // Jika stok mencukupi untuk semua produk, update status pesanan
            if ($stokCukup) {
                // Update status pesanan menjadi "Pengiriman"
                $affectedRows = DB::table('pesanan')
                    ->where('id', $id)
                    ->update(['status' => 'Pengiriman']);

                if ($affectedRows > 0) {
                    // Kurangi stok untuk setiap produk
                    foreach ($pesananProduk as $item) {
                        DB::table('produk_ukuran')
                            ->where('id', $item->produk_ukuran_id)
                            ->decrement('stok', $item->jumlah);
                    }

                    return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui dan stok barang dikurangi');
                }
            } else {
                // Jika stok tidak mencukupi, kembalikan pesan error
                return redirect()->back()->with('error', 'Stok barang tidak mencukupi untuk pesanan');
            }
        }

        return redirect()->back()->with('error', 'Gagal memperbarui status pesanan');
    }

    public function mintaselesai(Request $request, $id)
    {
        $affectedRows = DB::table('pesanan')
            ->where('id', $id)
            ->update([
                'status' => 'Selesai',
                'status_pembayaran' => 'Sudah Dibayar',
                'tgl_selesai' => now(),
            ]);

        if ($affectedRows > 0) {
            return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui status pesanan');
    }
}
