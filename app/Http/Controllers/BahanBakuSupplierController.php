<?php

namespace App\Http\Controllers;

use App\Models\BahanBakuSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BahanBakuSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $bahanbakuSupplier = DB::table('bahan_baku_supplier')
                ->join('bahan_baku', 'bahan_baku_supplier.bahan_baku_id', '=', 'bahan_baku.id')
                ->join('supplier', 'bahan_baku_supplier.supplier_id', '=', 'supplier.id')
                ->where('bahan_baku_supplier.supplier_id', $id)
                ->whereNull('bahan_baku_supplier.deleted_at')
                ->select('bahan_baku_supplier.*', 'supplier.id as id_supplier', 'supplier.nama as nama_supplier', 'bahan_baku.id as id_bahan_baku', 'bahan_baku.nama as bahan_baku_nama')
                ->get();

            $bahanBaku = DB::table('bahan_baku')
                ->whereNull('deleted_at')
                ->get();

            $supplier = DB::table('supplier')
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->select('supplier.*')
                ->first();

            // dd($bahanbaku);
            return view('pages/admin/supplier/listbahanbakusupplier', compact('bahanbakuSupplier', 'bahanBaku', 'supplier'));
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
    public function simpanbahanbaku(Request $request)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            // Validasi input
            $request->validate([
                'id_supplier' => 'required|integer',
                'bahan_baku' => 'required|integer'
            ]);

            // Cek apakah kombinasi id_supplier dan bahan_baku_id sudah ada
            $exists = DB::table('bahan_baku_supplier')
                ->where('supplier_id', $request->input('id_supplier'))
                ->where('bahan_baku_id', $request->input('bahan_baku'))
                ->whereNull('deleted_at') // Mengecualikan yang telah di-soft delete
                ->exists();

            if ($exists) {
                // Redirect kembali dengan pesan error
                return redirect()->back()->withErrors(['error' => 'Data bahan baku untuk supplier ini sudah pernah dimasukkan.']);
            }

            // Menyimpan data ke tabel bahan_baku_supplier
            DB::table('bahan_baku_supplier')->insert([
                'supplier_id' => $request->input('id_supplier'),
                'bahan_baku_id' => $request->input('bahan_baku'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Redirect ke halaman yang diinginkan dengan pesan sukses
            return redirect()->back()->with('success', 'Data bahan baku supplier berhasil ditambahkan.');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    // YourController.php
    public function hapusbahanbaku(Request $request)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $request->validate([
                'id_supplier' => 'required|integer',
                'bahan_baku' => 'required|integer'
            ]);

            $exists = DB::table('bahan_baku_supplier')
                ->where('supplier_id', $request->input('id_supplier'))
                ->where('bahan_baku_id', $request->input('bahan_baku'))
                ->exists();

            if (!$exists) {
                return redirect()->back()->withErrors(['error' => 'Data bahan baku untuk supplier ini tidak ditemukan.']);
            }

            DB::table('bahan_baku_supplier')
                ->where('supplier_id', $request->input('id_supplier'))
                ->where('bahan_baku_id', $request->input('bahan_baku'))
                ->delete();

            return redirect()->back()->with('success', 'Data bahan baku supplier berhasil dihapus.');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(BahanBakuSupplier $bahanBakuSupplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BahanBakuSupplier $bahanBakuSupplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BahanBakuSupplier $bahanBakuSupplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BahanBakuSupplier $bahanBakuSupplier)
    {
        //
    }
}
