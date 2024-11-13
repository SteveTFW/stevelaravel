<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;


class CheckRoleMiddleware
{
    public function handle($request, Closure $next)
    {
        // Cek keberadaan sesi 'nama_peran'
        if (Session::has('nama_peran')) {
            return $next($request);
        }

        // Redirect ke halaman lain jika tidak memenuhi kondisi
        return redirect('/admin/login'); // Ganti dengan halaman yang sesuai
    }
}
