<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $produk = DB::table('produk')
                ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
                ->leftJoin('produk_ukuran', function ($join) {
                    $join->on('produk.id', '=', 'produk_ukuran.produk_id')
                        ->whereNull('produk_ukuran.deleted_at'); // Menambahkan kondisi untuk mengecualikan yang telah di-soft delete
                })
                ->whereNull('produk.deleted_at')
                ->select('produk.*', 'kategori.nama as nama_kategori', 'produk_ukuran.ukuran as nama_ukuran', 'produk_ukuran.harga as harga_ukuran')
                ->get();


            // Mengelompokkan hasil query berdasarkan ID produk
            $groupedProduk = $produk->groupBy('id');
            // dd($produk);
            $kategoriOptions = DB::select('SELECT id, nama FROM kategori');

            return view('pages/admin/produk/listproduk', compact('groupedProduk', 'kategoriOptions'));
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            // Validasi data yang diterima dari formulir
            $request->validate([
                'nama' => 'required|string|max:255',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'deskripsi' => 'required|string',
                'kategori' => 'required|exists:kategori,id', // Pastikan ID kategori valid
            ]);

            // Proses penyimpanan data menggunakan SQL Query Builder
            $data = [
                'nama' => $request->input('nama'),
                'deskripsi' => $request->input('deskripsi'),
                'status' => 'Tidak Tersedia',
                'kategori_id' => $request->input('kategori'),
            ];

            // Simpan data ke dalam tabel produk dan ambil ID produk yang baru saja disimpan
            $id_produk = DB::table('produk')->insertGetId($data);

            // Proses penyimpanan gambar ke dalam folder public/image dengan nama berdasarkan format "produk{id_produk}"
            $gambarPath = $request->file('gambar')->move('image', 'produk' . $id_produk . '.' . $request->file('gambar')->getClientOriginalExtension());

            // Update nama gambar berdasarkan format "produk{id_produk}"
            DB::table('produk')->where('id', $id_produk)->update(['gambar' => 'image/produk' . $id_produk . '.' . $request->file('gambar')->getClientOriginalExtension()]);

            // Redirect atau berikan respons sesuai kebutuhan
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    /**
     * Display the specified resource.
     */
    public function edit($id)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            // Ambil data produk berdasarkan ID menggunakan Query Builder
            $produk = DB::table('produk')
                ->where('id', $id)
                ->whereNull('deleted_at') // Menambahkan kondisi untuk mengecualikan yang telah di-soft delete
                ->first();

            if ($produk) {
                // Jika produk ditemukan, lanjutkan dengan menyiapkan data untuk tampilan
                $kategoriOptions = DB::select('SELECT id, nama FROM kategori');

                // Tampilkan halaman ubahproduk.blade.php dengan membawa data produk
                return view('pages/admin/produk/ubahproduk', compact('produk', 'kategoriOptions'));
            } else {
                // Jika produk tidak ditemukan atau telah di-soft delete
                // Redirect atau tampilkan pesan kesalahan sesuai kebutuhan Anda
                return redirect()->back()->with('error', 'Produk tidak ditemukan atau telah dihapus.');
            }
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            // Validasi data yang diterima dari formulir
            $request->validate([
                'nama' => 'required|string|max:255',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'deskripsi' => 'required|string',
                'status' => 'required|in:tersedia,tidak tersedia', // Perbaikan: sesuaikan nilai status dengan opsi yang ada di dalam database
                'kategori' => 'required|exists:kategori,id', // Pastikan ID kategori valid
            ]);

            // Proses penyimpanan data menggunakan SQL Query Builder
            $data = [
                'nama' => $request->input('nama'),
                'deskripsi' => $request->input('deskripsi'),
                'status' => strtolower($request->input('status')), // Perbaikan: ubah ke lowercase
                'kategori_id' => $request->input('kategori'),
            ];

            // Update data produk
            DB::table('produk')->where('id', $id)->update($data);

            // Jika ada gambar baru diupload, proses penyimpanan gambar
            if ($request->hasFile('gambar')) {
                // Proses penyimpanan gambar ke dalam folder public/image dengan nama berdasarkan format "produk{id_produk}"
                $gambarPath = $request->file('gambar')->move('image', 'produk' . $id . '.' . $request->file('gambar')->getClientOriginalExtension());

                // Update nama gambar berdasarkan format "produk{id_produk}"
                DB::table('produk')->where('id', $id)->update(['gambar' => 'image/produk' . $id . '.' . $request->file('gambar')->getClientOriginalExtension()]);
            }

            // Redirect atau berikan respons sesuai kebutuhan
            return redirect()->route('list-produk')->with('success', 'Produk berhasil diubah');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $produk = DB::table('produk')->where('id', $id)->first();

            if ($produk) {
                $deleted = DB::table('produk')->where('id', $id)->update([
                    'deleted_at' => now(), // Set waktu sekarang sebagai nilai deleted_at
                ]);

                if ($deleted) {
                    return redirect()->back()->with('success', 'Produk berhasil dihapus');
                } else {
                    return redirect()->back()->with('error', 'Gagal menghapus produk');
                }
            } else {
                return redirect()->back()->with('error', 'Produk tidak ditemukan');
            }
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function showproduct()
    {
        if (Session::has('nama_peran') && Session::get('kode_peran') == 'CUST') {
            $produk = DB::table('produk')
                ->where('status', 'Tersedia')
                ->whereNull('deleted_at') // Menambahkan kondisi untuk mengecualikan yang telah di-soft delete
                ->get();

            // dd($produk);

            return view('pages/user/pemesanan/produk', compact('produk'));
        } else {
            return redirect('/login')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function showdetailproduct($id)
    {
        if (Session::has('nama_peran') && Session::get('kode_peran') == 'CUST') {
            $produk = DB::table('produk')
                ->where('status', 'Tersedia')
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->first(); // Menggunakan first() untuk mendapatkan satu baris atau null jika tidak ada

            $result = DB::table('produk')
                ->select('produk.nama', 'produk_ukuran.id', 'produk_ukuran.ukuran', 'produk_ukuran.harga')
                ->join('produk_ukuran', 'produk.id', '=', 'produk_ukuran.produk_id')
                ->where('produk.id', $id)
                ->whereNull('produk_ukuran.deleted_at') // menambahkan kondisi untuk soft delete
                ->get();
            // dd($result);

            return view('pages/user/pemesanan/detailproduk', compact('produk', 'result'));
        } else {
            return redirect('/login')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function viewstock()
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ' || Session::get('kode_peran_admin') == 'KPRD')) {

            $produk = DB::table('produk')
                ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
                ->leftJoin('produk_ukuran', function ($join) {
                    $join->on('produk.id', '=', 'produk_ukuran.produk_id')
                        ->whereNull('produk_ukuran.deleted_at'); // Menambahkan kondisi untuk mengecualikan yang telah di-soft delete
                })
                ->whereNull('produk.deleted_at')
                ->select('produk.*', 'kategori.nama as nama_kategori', 'produk_ukuran.stok as stok_ukuran', 'produk_ukuran.ukuran as nama_ukuran', 'produk_ukuran.harga as harga_ukuran')
                ->get();


            // Mengelompokkan hasil query berdasarkan ID produk
            $groupedProduk = $produk->groupBy('id');

            return view('pages/admin/stok/barangjadi', compact('groupedProduk'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }
}
