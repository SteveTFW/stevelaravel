<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $kategori = DB::table('kategori')->get();
            return view('pages/admin/kategori/listkategori', compact('kategori'));
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
            $request->validate([
                'nama' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
            ]);

            $data = [
                'nama' => $request->input('nama'),
                'deskripsi' => $request->input('deskripsi'),
            ];

            DB::table('kategori')->insert($data);

            // Redirect atau berikan respons sesuai kebutuhan
            return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            // Ambil data kategori berdasarkan ID menggunakan Query Builder
            $kategori = DB::table('kategori')->where('id', $id)->first();

            // Tampilkan halaman ubahproduk.blade.php dengan membawa data produk
            return view('pages/admin/kategori/ubahkategori', compact('kategori'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
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
                'deskripsi' => 'required|string',
            ]);

            // Proses penyimpanan data menggunakan SQL Query Builder
            $data = [
                'nama' => $request->input('nama'),
                'deskripsi' => $request->input('deskripsi'),
            ];

            // Update data kategori
            DB::table('kategori')->where('id', $id)->update($data);

            // Redirect atau berikan respons sesuai kebutuhan
            return redirect()->route('list-kategori')->with('success', 'Produk berhasil diubah');
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
            DB::table('kategori')->where('id', $id)->delete();

            return redirect()->back()->with('success', 'Kategori berhasil dihapus');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }
}
