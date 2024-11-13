<?php

namespace App\Http\Controllers;

use App\Models\Peran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PeranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $peran = DB::table('peran')->get();
            // dd($peran);
            return view('pages/admin/peran/listperan', compact('peran'));
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
                'kode' => 'required|string|alpha|max:4', // Menambahkan validasi untuk kode
            ]);

            $data = [
                'nama' => $request->input('nama'),
                'deskripsi' => $request->input('deskripsi'),
                'kode' => strtoupper($request->input('kode')), // Mengonversi kode menjadi huruf besar
            ];

            DB::table('peran')->insert($data);

            // Redirect atau berikan respons sesuai kebutuhan
            return redirect()->back()->with('success', 'Peran berhasil ditambahkan');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Peran $peran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            // Ambil data peran berdasarkan ID menggunakan Query Builder
            $peran = DB::table('peran')->where('id', $id)->first();

            // Tampilkan halaman ubahperan.blade.php dengan membawa data peran
            return view('pages/admin/peran/ubahperan', compact('peran'));
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
                'deskripsi' => 'nullable|string',
                'kode' => 'required|string|alpha|max:4', // Menambahkan validasi untuk kode
            ]);

            // Proses penyimpanan data menggunakan SQL Query Builder
            $data = [
                'nama' => $request->input('nama'),
                'deskripsi' => $request->input('deskripsi'),
                'kode' => strtoupper($request->input('kode')), // Mengonversi kode menjadi huruf besar
            ];

            // Update data peran
            DB::table('peran')->where('id', $id)->update($data);

            // Redirect atau berikan respons sesuai kebutuhan
            return redirect()->route('list-peran')->with('success', 'Produk berhasil diubah');
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
            DB::table('peran')->where('id', $id)->delete();

            return redirect()->back()->with('success', 'Peran berhasil dihapus');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }
}
