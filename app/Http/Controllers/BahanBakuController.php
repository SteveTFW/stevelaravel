<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $bahanbaku = DB::table('bahan_baku')
                ->whereNull('deleted_at') // Menambahkan kondisi untuk mengecualikan yang telah di-soft delete
                ->get();
            // dd($bahanbaku);
            return view('pages/admin/bahanbaku/listbahanbaku', compact('bahanbaku'));
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
                'jenis_satuan' => 'required|string',
            ]);

            // Mengatur nilai default untuk stok_kuantitas
            $stokKuantitas = $request->input('stok_kuantitas', 0);

            // Proses penyimpanan data menggunakan SQL Query Builder
            $data = [
                'nama' => $request->input('nama'),
                'stok_kuantitas' => $stokKuantitas,
                'jenis_satuan' => $request->input('jenis_satuan'),
            ];

            // Menyimpan data bahan baku ke dalam database
            DB::table('bahan_baku')->insert($data);

            // Redirect atau berikan respons sesuai kebutuhan
            return redirect()->back()->with('success', 'Bahan Baku berhasil ditambahkan');
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
            // Ambil data bahan baku berdasarkan ID menggunakan Query Builder
            $bahanbaku = DB::table('bahan_baku')->where('id', $id)->first();

            // Tampilkan halaman ubahbahanbaku.blade.php dengan membawa data bahan baku
            return view('pages/admin/bahanbaku/ubahbahanbaku', compact('bahanbaku'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(BahanBaku $bahanBaku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $request->validate([
                'nama' => 'required|string|max:255',
                'jenis_satuan' => 'required',
            ]);

            $data = [
                'nama' => $request->input('nama'),
                'jenis_satuan' => $request->input('jenis_satuan'),
            ];

            // Update data bahan baku
            DB::table('bahan_baku')->where('id', $id)->update($data);

            // Redirect atau berikan respons sesuai kebutuhan
            return redirect()->route('list-bahanbaku')->with('success', 'Bahan baku berhasil diubah');
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
            DB::table('bahan_baku')->where('id', $id)->delete();

            return redirect()->back()->with('success', 'Bahan Baku berhasil dihapus');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function viewstock()
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ' || Session::get('kode_peran_admin') == 'KPRD')) {
            $bahanbaku = DB::table('bahan_baku')
                ->whereNull('deleted_at') // Menambahkan kondisi untuk mengecualikan yang telah di-soft delete
                ->get();

            return view('pages/admin/stok/bahanbaku', compact('bahanbaku'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }
}
