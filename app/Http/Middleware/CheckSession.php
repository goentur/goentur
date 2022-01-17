<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user->hasRole('pegawai')) {
            if (
                $request->session()->get('_id_pegawai') == null ||
                $request->session()->get('_nip') == null ||
                $request->session()->get('_nama_pegawai') == null ||
                $request->session()->get('_jenis_kelamin') == null ||
                $request->session()->get('_status_kepegawaian') == null ||
                $request->session()->get('_id_opd') == null ||
                $request->session()->get('_level_dinas') == null ||
                $request->session()->get('_id_jabatan_dinas') == null ||
                $request->session()->get('_id_pegawai_jabatan_dinas') == null ||
                $request->session()->get('_level_tbh') == null ||
                $request->session()->get('_id_jabatan_tbh') == null ||
                $request->session()->get('_id_pegawai_jabatan_tbh') == null ||
                $request->session()->get('_jenis_jabatan_lain') == null ||
                $request->session()->get('_id_jabatan_lain') == null ||
                $request->session()->get('_id_pegawai_jabatan_lain') == null ||
                $request->session()->get('_id_jabatan_lain_tbh') == null ||
                $request->session()->get('_id_pegawai_jabatan_lain_tbh') == null
            ) {
                // lock screen
                // Auth::logout();
                return response()->view('auth.lock');
                // return abort(404);
            }
        } else if ($user->hasRole('opd')) {
        } else if ($user->hasRole('admin')) {
        }
        return $next($request);
    }
}
