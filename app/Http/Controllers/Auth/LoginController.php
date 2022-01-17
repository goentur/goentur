<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request  $request, $user)
    {
        if ($user->hasRole('pegawai')) {
            $p = DB::table('pegawai')->select(['id_pegawai', 'nip', 'gelar_depan', 'nama_pegawai', 'gelar_belakang', 'jenis_kelamin', 'status_kepegawaian', 'id_opd'])->where(['email' => $user->email, 'status_data' => 'a'])->first();
            if ($p !== null) {
                $level_dinas   = 'kosong';
                $id_pegawai_jabatan_dinas   = 'kosong';
                $id_jabatan_dinas   = 'kosong';
                $level_tbh   = 'kosong';
                $id_pegawai_jabatan_tbh = 'kosong';
                $id_jabatan_tbh = 'kosong';
                $jenis_jabatan_lain = 'kosong';
                $id_jabatan_lain = 'kosong';
                $id_pegawai_jabatan_lain = 'kosong';
                $id_jabatan_lain_tbh = 'kosong';
                $id_pegawai_jabatan_lain_tbh = 'kosong';
                $d = DB::table('pegawai_jabatan AS pj')
                    ->join('jabatan AS j', 'pj.id_jabatan', '=', 'j.id_jabatan')
                    ->select(['pj.id_pegawai_jabatan', 'pj.id_jabatan', 'j.id_opd', 'j.jabatan_tambahan', 'j.level'])
                    ->where(['pj.id_pegawai' => $p->id_pegawai, 'pj.jenis_jabatan' => '-', 'pj.status_data' => 'a'])
                    ->first();
                if ($d !== null) {
                    $level_dinas = $d->level;
                    $id_jabatan_dinas = $d->id_jabatan;
                    $id_pegawai_jabatan_dinas = $d->id_pegawai_jabatan;
                    if ($d->jabatan_tambahan == 'Kepala Puskesmas' || $d->jabatan_tambahan == 'Kepala Sekolah') {
                        $dinas_tbh = DB::table('jabatan AS j')
                            ->join('pegawai_jabatan AS pj', 'j.id_jabatan', '=', 'pj.id_jabatan')
                            ->select(['j.level', 'pj.id_pegawai_jabatan', 'pj.id_jabatan'])
                            ->where('j.detail_jabatan', 'like', '%' . $d->jabatan_tambahan . '%')
                            ->where(['j.id_opd' => $d->id_opd, 'pj.id_pegawai' => $p->id_pegawai, 'pj.jenis_jabatan' => 'tbh', 'pj.status_data' => 'a'])
                            ->first();
                        $level_tbh = $dinas_tbh->level;
                        $id_jabatan_tbh = $dinas_tbh->id_jabatan;
                        $id_pegawai_jabatan_tbh = $dinas_tbh->id_pegawai_jabatan;
                    }
                } else {
                    Auth::logout();
                    return abort(503);
                }
                $jabatan_lain = DB::table('pegawai_jabatan AS pj')
                    ->join('jabatan AS j', 'pj.id_jabatan', '=', 'j.id_jabatan')
                    ->select(['pj.id_pegawai_jabatan', 'pj.jenis_jabatan', 'pj.id_jabatan', 'j.id_opd', 'j.jabatan_tambahan'])
                    ->where('pj.jenis_jabatan', '!=', '-')
                    ->where('pj.jenis_jabatan', '!=', 'tbh')
                    ->where(['pj.id_pegawai' => $p->id_pegawai, 'pj.status_data' => 'a'])
                    ->first();
                if ($jabatan_lain !== null) {
                    $jenis_jabatan_lain = $jabatan_lain->jenis_jabatan;
                    $id_jabatan_lain = $jabatan_lain->id_jabatan;
                    $id_pegawai_jabatan_lain = $jabatan_lain->id_pegawai_jabatan;
                    if ($jabatan_lain->jabatan_tambahan == 'Kepala Puskesmas' || $jabatan_lain->jabatan_tambahan == 'Kepala Sekolah') {
                        $jabatan_lain_tbh = DB::table('jabatan AS j')
                            ->join('pegawai_jabatan AS pj', 'j.id_jabatan', '=', 'pj.id_jabatan')
                            ->select(['pj.id_pegawai_jabatan', 'pj.id_jabatan'])
                            ->where('j.detail_jabatan', 'like', '%' . $jabatan_lain->jabatan_tambahan . '%')
                            ->where(['j.id_opd' => $jabatan_lain->id_opd, 'pj.id_pegawai' => $p->id_pegawai, 'pj.jenis_jabatan' => 'tbh', 'pj.status_data' => 'a'])
                            ->first();
                        $id_jabatan_lain_tbh = $jabatan_lain_tbh->id_jabatan;
                        $id_pegawai_jabatan_lain_tbh = $jabatan_lain_tbh->id_pegawai_jabatan;
                    }
                }
                $a = DB::table('aktivitas AS a')
                    ->join('satuan AS s', 'a.id_satuan', '=', 's.id_satuan')
                    ->select(['a.id_aktivitas', 'a.aktivitas', 'a.waktu', 's.satuan'])
                    ->where(['a.status_data' => 'a'])
                    ->get();
                $da = [];
                foreach ($a as $aktivitas) {
                    $da[] = [
                        'id_aktivitas' => $aktivitas->id_aktivitas,
                        'aktivitas' => $aktivitas->aktivitas,
                        'waktu' => $aktivitas->waktu,
                        'satuan' => $aktivitas->satuan,
                    ];
                }
                $request->session()->put(['_aktivitas' => $da]);
                $request->session()->put([
                    '_id_pegawai' => $p->id_pegawai,
                    '_nip' => $p->nip,
                    '_nama_pegawai' => $p->gelar_depan . ' ' . $p->nama_pegawai . ' ' . $p->gelar_belakang,
                    '_jenis_kelamin' => $p->jenis_kelamin,
                    '_status_kepegawaian' => $p->status_kepegawaian,
                    '_id_opd' => $p->id_opd,
                    '_level_dinas' => $level_dinas,
                    '_id_jabatan_dinas'   => $id_jabatan_dinas,
                    '_id_pegawai_jabatan_dinas'   => $id_pegawai_jabatan_dinas,
                    '_level_tbh' => $level_tbh,
                    '_id_jabatan_tbh' => $id_jabatan_tbh,
                    '_id_pegawai_jabatan_tbh' => $id_pegawai_jabatan_tbh,
                    '_jenis_jabatan_lain' => $jenis_jabatan_lain,
                    '_id_jabatan_lain' => $id_jabatan_lain,
                    '_id_pegawai_jabatan_lain' => $id_pegawai_jabatan_lain,
                    '_id_jabatan_lain_tbh' => $id_jabatan_lain_tbh,
                    '_id_pegawai_jabatan_lain_tbh' => $id_pegawai_jabatan_lain_tbh,
                ]);
                return redirect('pegawai/dashboard');
            } else {
                Auth::logout();
                return abort(503);
            }
        } else if ($user->hasRole('opd')) {
            return redirect('opd/dashboard');
        } else if ($user->hasRole('admin')) {
            return redirect('admin/dashboard');
        } else {
            return abort(404);
        }
    }
    public function unlock(Request  $request, $user)
    {
        dd('asda');
        $hasher = app('hash');
        if ($hasher->check('passwordToCheck', $request->input('password'))) {
            if ($user->hasRole('pegawai')) {
                $p = DB::table('pegawai')->select(['id_pegawai', 'nip', 'gelar_depan', 'nama_pegawai', 'gelar_belakang', 'jenis_kelamin', 'status_kepegawaian', 'id_opd'])->where(['email' => $user->email, 'status_data' => 'a'])->first();
                if ($p !== null) {
                    $level_dinas   = 'kosong';
                    $id_pegawai_jabatan_dinas   = 'kosong';
                    $id_jabatan_dinas   = 'kosong';
                    $level_tbh   = 'kosong';
                    $id_pegawai_jabatan_tbh = 'kosong';
                    $id_jabatan_tbh = 'kosong';
                    $jenis_jabatan_lain = 'kosong';
                    $id_jabatan_lain = 'kosong';
                    $id_pegawai_jabatan_lain = 'kosong';
                    $id_jabatan_lain_tbh = 'kosong';
                    $id_pegawai_jabatan_lain_tbh = 'kosong';
                    $d = DB::table('pegawai_jabatan AS pj')
                        ->join('jabatan AS j', 'pj.id_jabatan', '=', 'j.id_jabatan')
                        ->select(['pj.id_pegawai_jabatan', 'pj.id_jabatan', 'j.id_opd', 'j.jabatan_tambahan', 'j.level'])
                        ->where(['pj.id_pegawai' => $p->id_pegawai, 'pj.jenis_jabatan' => '-', 'pj.status_data' => 'a'])
                        ->first();
                    if ($d !== null) {
                        $level_dinas = $d->level;
                        $id_jabatan_dinas = $d->id_jabatan;
                        $id_pegawai_jabatan_dinas = $d->id_pegawai_jabatan;
                        if ($d->jabatan_tambahan == 'Kepala Puskesmas' || $d->jabatan_tambahan == 'Kepala Sekolah') {
                            $dinas_tbh = DB::table('jabatan AS j')
                                ->join('pegawai_jabatan AS pj', 'j.id_jabatan', '=', 'pj.id_jabatan')
                                ->select(['j.level', 'pj.id_pegawai_jabatan', 'pj.id_jabatan'])
                                ->where('j.detail_jabatan', 'like', '%' . $d->jabatan_tambahan . '%')
                                ->where(['j.id_opd' => $d->id_opd, 'pj.id_pegawai' => $p->id_pegawai, 'pj.jenis_jabatan' => 'tbh', 'pj.status_data' => 'a'])
                                ->first();
                            $level_tbh = $dinas_tbh->level;
                            $id_jabatan_tbh = $dinas_tbh->id_jabatan;
                            $id_pegawai_jabatan_tbh = $dinas_tbh->id_pegawai_jabatan;
                        }
                    } else {
                        Auth::logout();
                        return abort(503);
                    }
                    $jabatan_lain = DB::table('pegawai_jabatan AS pj')
                        ->join('jabatan AS j', 'pj.id_jabatan', '=', 'j.id_jabatan')
                        ->select(['pj.id_pegawai_jabatan', 'pj.jenis_jabatan', 'pj.id_jabatan', 'j.id_opd', 'j.jabatan_tambahan'])
                        ->where('pj.jenis_jabatan', '!=', '-')
                        ->where('pj.jenis_jabatan', '!=', 'tbh')
                        ->where(['pj.id_pegawai' => $p->id_pegawai, 'pj.status_data' => 'a'])
                        ->first();
                    if ($jabatan_lain !== null) {
                        $jenis_jabatan_lain = $jabatan_lain->jenis_jabatan;
                        $id_jabatan_lain = $jabatan_lain->id_jabatan;
                        $id_pegawai_jabatan_lain = $jabatan_lain->id_pegawai_jabatan;
                        if ($jabatan_lain->jabatan_tambahan == 'Kepala Puskesmas' || $jabatan_lain->jabatan_tambahan == 'Kepala Sekolah') {
                            $jabatan_lain_tbh = DB::table('jabatan AS j')
                                ->join('pegawai_jabatan AS pj', 'j.id_jabatan', '=', 'pj.id_jabatan')
                                ->select(['pj.id_pegawai_jabatan', 'pj.id_jabatan'])
                                ->where('j.detail_jabatan', 'like', '%' . $jabatan_lain->jabatan_tambahan . '%')
                                ->where(['j.id_opd' => $jabatan_lain->id_opd, 'pj.id_pegawai' => $p->id_pegawai, 'pj.jenis_jabatan' => 'tbh', 'pj.status_data' => 'a'])
                                ->first();
                            $id_jabatan_lain_tbh = $jabatan_lain_tbh->id_jabatan;
                            $id_pegawai_jabatan_lain_tbh = $jabatan_lain_tbh->id_pegawai_jabatan;
                        }
                    }
                    $a = DB::table('aktivitas AS a')
                        ->join('satuan AS s', 'a.id_satuan', '=', 's.id_satuan')
                        ->select(['a.id_aktivitas', 'a.aktivitas', 'a.waktu', 's.satuan'])
                        ->where(['a.status_data' => 'a'])
                        ->get();
                    $da = [];
                    foreach ($a as $aktivitas) {
                        $da[] = [
                            'id_aktivitas' => $aktivitas->id_aktivitas,
                            'aktivitas' => $aktivitas->aktivitas,
                            'waktu' => $aktivitas->waktu,
                            'satuan' => $aktivitas->satuan,
                        ];
                    }
                    $request->session()->put(['_aktivitas' => $da]);
                    $request->session()->put([
                        '_id_pegawai' => $p->id_pegawai,
                        '_nip' => $p->nip,
                        '_nama_pegawai' => $p->gelar_depan . ' ' . $p->nama_pegawai . ' ' . $p->gelar_belakang,
                        '_jenis_kelamin' => $p->jenis_kelamin,
                        '_status_kepegawaian' => $p->status_kepegawaian,
                        '_id_opd' => $p->id_opd,
                        '_level_dinas' => $level_dinas,
                        '_id_jabatan_dinas'   => $id_jabatan_dinas,
                        '_id_pegawai_jabatan_dinas'   => $id_pegawai_jabatan_dinas,
                        '_level_tbh' => $level_tbh,
                        '_id_jabatan_tbh' => $id_jabatan_tbh,
                        '_id_pegawai_jabatan_tbh' => $id_pegawai_jabatan_tbh,
                        '_jenis_jabatan_lain' => $jenis_jabatan_lain,
                        '_id_jabatan_lain' => $id_jabatan_lain,
                        '_id_pegawai_jabatan_lain' => $id_pegawai_jabatan_lain,
                        '_id_jabatan_lain_tbh' => $id_jabatan_lain_tbh,
                        '_id_pegawai_jabatan_lain_tbh' => $id_pegawai_jabatan_lain_tbh,
                    ]);
                    return redirect('pegawai/dashboard');
                } else {
                    Auth::logout();
                    return abort(503);
                }
            } else if ($user->hasRole('opd')) {
                return redirect('opd/dashboard');
            } else if ($user->hasRole('admin')) {
                return redirect('admin/dashboard');
            }
        }
    }
}
