<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            $user = DB::table('user')
                ->join('peran', 'user.peran_id', '=', 'peran.id')
                ->whereNull('user.deleted_at') // Menambahkan kondisi untuk mengecualikan yang telah di-soft delete
                ->select('user.*', 'peran.nama as nama_peran', 'peran.kode as kode_peran')
                ->get();

            // dd($user);
            return view('pages/admin/user/listuser', compact('user'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function viewadminlogin()
    {
        return view('pages/admin/login');
    }

    public function viewuserlogin()
    {
        return view('pages/user/login');
    }

    public function viewuserregister()
    {
        return view('pages/user/register');
    }

    public function viewadminregister()
    {
        $roles = DB::table('peran')
            ->whereNotIn('kode', ['CUST', 'ADMN'])
            ->whereNull('deleted_at') // Mengecualikan yang telah di-soft delete
            ->get();

        return view('pages/admin/register', compact('roles'));
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
    public function showadmin(User $user)
    {
        //
    }

    public function showuser(User $user)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Session::has('nama_peran_admin') && Session::get('kode_peran_admin') == 'ADMN') {
            DB::table('user')->where('id', $id)->update(['deleted_at' => now()]); // Soft delete dengan mengisi kolom 'deleted_at'

            return redirect()->back()->with('success', 'User berhasil dihapus');
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function userregister(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|unique:user,email',
            'password' => 'required|string|min:8',
        ]);

        // Hash password sebelum menyimpan ke database
        $hashedPassword = Hash::make($request->password);

        // Simpan user ke dalam tabel menggunakan Query Builder
        $data = [
            'nama' => $request->nama,
            'alamat' => '',
            'password' => $hashedPassword,
            'peran_id' => '5',
            'nomor_telepon' => '',
            'email' => $request->email,
            'tanggal_bergabung' => Carbon::now(),
        ];

        // Simpan data ke dalam tabel user dan ambil ID user yang baru saja disimpan
        $id_user = DB::table('user')->insertGetId($data);
        
        if ($id_user !== null) {
            // Path gambar default
            $defaultImagePath = public_path('landing/profile/default.jpeg');

            // Path untuk gambar baru dengan format nama yang berbeda
            $newImagePath = public_path('landing/profile/' . $id_user . '_' . $request->nama . '.jpeg');

            // Salin gambar default ke gambar baru
            File::copy($defaultImagePath, $newImagePath);

            // Update nama gambar berdasarkan format "produk{id_produk}"
            DB::table('user')->where('id', $id_user)->update(['gambar' => 'landing/profile/' . $id_user . '_' . $request->nama . '.jpeg']);

            // Redirect atau berikan respons sesuai kebutuhan
            return redirect()->back()->with('success', 'User berhasil didaftarkan!');
        } else {
            // Operasi insert gagal
            return redirect()->back()->with('error', 'Gagal mendaftarkan user. Silakan coba lagi.');
        }
    }

    public function adminregister(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|unique:user,email',
            'password' => 'required|string|min:8',
            'peran' => 'required|exists:peran,id',
        ]);

        // Hash password sebelum menyimpan ke database
        $hashedPassword = Hash::make($request->password);

        // Simpan user ke dalam tabel menggunakan Query Builder
        $data = [
            'nama' => $request->nama,
            'alamat' => '',
            'password' => $hashedPassword,
            'peran_id' => $request->peran,
            'nomor_telepon' => '',
            'email' => $request->email,
            'tanggal_bergabung' => Carbon::now(),
        ];

        // Simpan data ke dalam tabel user dan ambil ID user yang baru saja disimpan
        $id_user = DB::table('user')->insertGetId($data);

        // Path gambar default
        $defaultImagePath = public_path('admin/profile/default.jpeg');

        // Path untuk gambar baru dengan format nama yang berbeda
        $newImagePath = public_path('admin/profile/' . $id_user . '_' . $request->nama . '.jpeg');

        // Salin gambar default ke gambar baru
        File::copy($defaultImagePath, $newImagePath);

        // Update nama gambar berdasarkan format "produk{id_produk}"
        DB::table('user')->where('id', $id_user)->update(['gambar' => 'admin/profile/' . $id_user . '_' . $request->nama . '.jpeg']);

        // Redirect atau berikan respons sesuai kebutuhan
        return redirect()->back()->with('success', 'User berhasil didaftarkan!');
    }

    public function adminlogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Ambil data pengguna dan informasi peran dari database menggunakan Query Builder
        $user = DB::table('user')
            ->join('peran', 'user.peran_id', '=', 'peran.id')
            ->where('user.email', $request->email)
            ->whereNull('user.deleted_at') 
            ->select('user.*', 'peran.nama as nama_peran', 'peran.kode as kode_peran')
            ->first();

        // dd($hashedPassword);
        if ($user && Hash::check($request->password, $user->password)) {
            // Password cocok, lakukan login
            Session::put('user_id_admin', $user->id);
            Session::put('nama_user_admin', $user->nama);
            Session::put('alamat_admin', $user->alamat);
            Session::put('gambar_admin', $user->gambar);
            Session::put('nama_peran_admin', $user->nama_peran);
            Session::put('kode_peran_admin', $user->kode_peran);
            Session::put('nomor_telepon_admin', $user->nomor_telepon);
            Session::put('email_user_admin', $user->email);
            Session::put('tanggal_bergabung_admin', $user->tanggal_bergabung);
            // dd(Session::all());
            return redirect()->intended('/admin/dashboard');
        }

        // Login gagal, tambahkan logika lainnya
        return back()->withErrors(['email' => 'Email atau password salah!']);
    }

    public function userlogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Ambil data pengguna dan informasi peran dari database menggunakan Query Builder
        $user = DB::table('user')
            ->join('peran', 'user.peran_id', '=', 'peran.id')
            ->where('user.email', $request->email)
            ->whereNull('user.deleted_at') 
            ->select('user.*', 'peran.nama as nama_peran', 'peran.kode as kode_peran')
            ->first();

        // dd($hashedPassword);
        if ($user && Hash::check($request->password, $user->password)) {
            // Password cocok, lakukan login
            Session::put('user_id', $user->id);
            Session::put('nama_user', $user->nama);
            Session::put('alamat', $user->alamat);
            Session::put('gambar', $user->gambar);
            Session::put('nama_peran', $user->nama_peran);
            Session::put('kode_peran', $user->kode_peran);
            Session::put('nomor_telepon', $user->nomor_telepon);
            Session::put('email_user', $user->email);
            Session::put('tanggal_bergabung', $user->tanggal_bergabung);
            // dd(Session::all());
            return redirect()->intended('/');
        }

        // Login gagal, tambahkan logika lainnya
        return back()->withErrors(['email' => 'Email atau password salah!']);
    }

    public function userprofil()
    {
        if (Session::has('nama_peran') && Session::get('kode_peran') == 'CUST') {
            $user = DB::table('user as u')
                ->select('u.*', 'p.nama as nama_peran')
                ->join('peran as p', 'u.peran_id', '=', 'p.id')
                ->where('u.id', session('user_id'))
                ->first();

            return view('pages/user/akun/profil', compact('user'));
        } else {
            return redirect('/login')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function adminprofil()
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ' || Session::get('kode_peran_admin') == 'KKEU' || Session::get('kode_peran_admin') == 'KPRD')) {
            $admin = DB::table('user as u')
                ->select('u.*', 'p.nama as nama_peran')
                ->join('peran as p', 'u.peran_id', '=', 'p.id')
                ->where('u.id', session('user_id_admin'))
                ->first();

            return view('pages/admin/akun/profil', compact('admin'));
        } else {
            return redirect('/admin/dashboard')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function ubahadminprofil(Request $request)
    {
        if (Session::has('nama_peran_admin') && (Session::get('kode_peran_admin') == 'ADMN' || Session::get('kode_peran_admin') == 'KBLJ' || Session::get('kode_peran_admin') == 'KKEU' || Session::get('kode_peran_admin') == 'KPRD')) {
            // Validasi input
            $request->validate([
                'nama' => 'required|string',
                'alamat' => 'required|string',
                'nomor_telepon' => 'required|string',
                'email' => 'required|email',
            ]);

            // Update data menggunakan query builder
            $affectedRows = DB::table('user')
                ->where('id', session('user_id_admin'))
                ->update([
                    'nama' => $request->input('nama'),
                    'alamat' => $request->input('alamat'),
                    'nomor_telepon' => $request->input('nomor_telepon'),
                    'email' => $request->input('email'),
                ]);

            if ($affectedRows > 0) {
                // Update session
                Session::put('nama_user_admin', $request->input('nama'));
                Session::put('alamat_admin', $request->input('alamat'));
                Session::put('nomor_telepon_admin', $request->input('nomor_telepon'));
                Session::put('email_admin', $request->input('email'));

                return redirect()->route('admin-profile', ['id' => session('user_id_admin')])->with('success', 'Profil pengguna berhasil diubah');
            } else {
                return redirect()->back()->with('error', 'Gagal mengubah profil pengguna');
            }
        } else {
            return redirect('/login')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function ubahuserprofil(Request $request)
    {
        if (Session::has('nama_peran') && Session::get('kode_peran') == 'CUST') {
            // Validasi input
            $request->validate([
                'nama' => 'required|string',
                'alamat' => 'required|string',
                'nomor_telepon' => 'required|string',
                'email' => 'required|email',
            ]);

            // Update data menggunakan query builder
            $affectedRows = DB::table('user')
                ->where('id', session('user_id'))
                ->update([
                    'nama' => $request->input('nama'),
                    'alamat' => $request->input('alamat'),
                    'nomor_telepon' => $request->input('nomor_telepon'),
                    'email' => $request->input('email'),
                ]);

            if ($affectedRows > 0) {
                // Update session
                Session::put('nama_user', $request->input('nama'));
                Session::put('alamat', $request->input('alamat'));
                Session::put('nomor_telepon', $request->input('nomor_telepon'));
                Session::put('email', $request->input('email'));

                return redirect()->route('view-profile')->with('success', 'Profil pengguna berhasil diubah');
            } else {
                return redirect()->back()->with('error', 'Gagal mengubah profil pengguna');
            }
        } else {
            return redirect('/login')->with('error', 'Akses Ditolak!'); // Ganti dengan rute atau logika lain sesuai kebutuhan
        }
    }

    public function adminlogout()
    {
        // Hapus session secara manual
        Session::forget('user_id_admin');
        Session::forget('nama_user_admin');
        Session::forget('alamat_admin');
        Session::forget('gambar_admin');
        Session::forget('nama_peran_admin');
        Session::forget('kode_peran_admin');
        Session::forget('nomor_telepon_admin');
        Session::forget('email_user_admin');
        Session::forget('tanggal_bergabung_admin');

        // Redirect ke halaman login atau halaman lain yang diinginkan
        return redirect()->route('admin-view-login');
    }

    public function userlogout()
    {
        // Hapus session secara manual
        Session::forget('user_id');
        Session::forget('nama_user');
        Session::forget('alamat');
        Session::forget('gambar');
        Session::forget('nama_peran');
        Session::forget('kode_peran');
        Session::forget('nomor_telepon');
        Session::forget('email_user');
        Session::forget('tanggal_bergabung');

        // Redirect ke halaman login atau halaman lain yang diinginkan
        return redirect()->route('home');
    }
}
