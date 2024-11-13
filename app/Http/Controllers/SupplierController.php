<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $supplier = DB::table('supplier')->get();
            // dd($supplier);
            return view('pages/admin/supplier/listsupplier', compact('supplier'));
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
                'alamat' => 'nullable|string',
                'nomor_telepon' => 'required|string|regex:/^[0-9\s\+\(\)\-]+$/',
                'email' => 'nullable|email',
            ]);

            $data = [
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'nomor_telepon' => $request->input('nomor_telepon'),
                'email' => $request->input('email'),
            ];

            DB::table('supplier')->insert($data);

            // Redirect atau berikan respons sesuai kebutuhan
            return redirect()->back()->with('success', 'Supplier berhasil ditambahkan');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            // Ambil data supplier berdasarkan ID menggunakan Query Builder
            $supplier = DB::table('supplier')->where('id', $id)->first();

            // Tampilkan halaman ubahsupplier.blade.php dengan membawa data supplier
            return view('pages/admin/supplier/ubahsupplier', compact('supplier'));
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
                'alamat' => 'nullable|string',
                'nomor_telepon' => 'required|string|regex:/^[0-9\s\+\(\)\-]+$/',
                'email' => 'nullable|email',
            ]);

            // Proses penyimpanan data menggunakan SQL Query Builder
            $data = [
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'nomor_telepon' => $request->input('nomor_telepon'),
                'email' => $request->input('email'),
            ];

            // Update data supplier
            DB::table('supplier')->where('id', $id)->update($data);

            // Redirect atau berikan respons sesuai kebutuhan
            return redirect()->route('list-supplier')->with('success', 'Supplier berhasil diupdate');
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
            DB::table('supplier')->where('id', $id)->delete();

            return redirect()->back()->with('success', 'Supplier berhasil dihapus');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }
}
