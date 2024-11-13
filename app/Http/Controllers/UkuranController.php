<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UkuranController extends Controller
{
    public function index()
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $ukuran = DB::table('ukuran')->get();
            // dd($ukuran);
            return view('pages/admin/ukuran/listukuran', compact('ukuran'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function store(Request $request)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $request->validate([
                'nama' => 'required|string|max:255',
            ]);

            $data = [
                'nama' => $request->input('nama'),
            ];

            DB::table('ukuran')->insert($data);

            // Redirect atau berikan respons sesuai kebutuhan
            return redirect()->back()->with('success', 'Ukuran berhasil ditambahkan');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function destroy($id)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            DB::table('ukuran')->where('id', $id)->delete();

            return redirect()->back()->with('success', 'Ukuran berhasil dihapus');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function edit($id)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            // Ambil data ukuran berdasarkan ID menggunakan Query Builder
            $ukuran = DB::table('ukuran')->where('id', $id)->first();

            // Tampilkan halaman ubahukuran.blade.php dengan membawa data ukuran
            return view('pages/admin/ukuran/ubahukuran', compact('ukuran'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }
    public function update(Request $request, $id)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            // Validasi data yang diterima dari formulir
            $request->validate([
                'nama' => 'required|string|max:255',
            ]);

            // Proses penyimpanan data menggunakan SQL Query Builder
            $data = [
                'nama' => $request->input('nama'),
            ];

            // Update data produk
            DB::table('ukuran')->where('id', $id)->update($data);

            // Redirect atau berikan respons sesuai kebutuhan
            return redirect()->route('list-ukuran')->with('success', 'Ukuran berhasil diubah');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }
}
