<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JabatanController extends Controller
{
    /**
     * Show the application jabatan.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function jabatanAtasan()
    {
        $pesan = null;
        $jabatan = null;
        $atasan = null;
        $join = [
            'tb1' => 'jabatan AS j',
            'tb2' => 'opd AS o',
            'pk1' => 'j.id_opd',
            'pk2' => 'o.id_opd',
            'select' => ['j.unit_organisasi', 'j.detail_jabatan', 'j.atasan_jabatan', 'j.jabatan_tambahan', 'o.opd', 'o.sub_opd'],
            'where' => ['j.id_jabatan' => session()->get('_id_jabatan_dinas')],
        ];
        $dataJabatan = Jabatan::_joinOneWhereGetOne($join);
        if ($dataJabatan !== null) {
            $unor_pns = '';
            $jabatan_pns = '';
            if ($dataJabatan->unit_organisasi !== '-') {
                $unor_pns = $dataJabatan->unit_organisasi;
            }
            if ($dataJabatan->jabatan_tambahan == 'Kepala Sekolah' || $dataJabatan->jabatan_tambahan == 'Kepala Puskesmas') {
                $jabatan_pns = $dataJabatan->detail_jabatan . ' ' . $unor_pns . ' (' . $dataJabatan->jabatan_tambahan . ')';
            } else {
                $jabatan_pns = $dataJabatan->detail_jabatan . ' ' . $unor_pns;
            }
            $jabatan = [
                'jabatan_pns' =>  $jabatan_pns,
                'opd_pns' =>  $dataJabatan->sub_opd == '-' ? $dataJabatan->opd : $dataJabatan->sub_opd . ' - ' . $dataJabatan->opd,
            ];
            if (session()->get('_jenis_jabatan_lain') != 'kosong') {
                $join = [
                    'tb1' => 'jabatan AS j',
                    'tb2' => 'opd AS o',
                    'pk1' => 'j.id_opd',
                    'pk2' => 'o.id_opd',
                    'select' => ['j.unit_organisasi', 'j.detail_jabatan', 'j.jabatan_tambahan', 'o.opd', 'o.sub_opd'],
                    'where' => ['j.id_jabatan' => session()->get('_id_jabatan_lain')],
                ];
                $dataJabatanTambahan = Jabatan::_joinOneWhereGetOne($join);
                $unor_tambahan_pns = '';
                $jabatan_tambahan_pns = '';
                if ($dataJabatanTambahan->unit_organisasi !== '-') {
                    $unor_tambahan_pns = $dataJabatanTambahan->unit_organisasi;
                }
                if ($dataJabatanTambahan->jabatan_tambahan == 'Kepala Sekolah' || $dataJabatanTambahan->jabatan_tambahan == 'Kepala Puskesmas') {
                    $jabatan_tambahan_pns = $dataJabatanTambahan->detail_jabatan . ' ' . $unor_tambahan_pns . ' (' . $dataJabatanTambahan->jabatan_tambahan . ')';
                } else {
                    $jabatan_tambahan_pns = $dataJabatanTambahan->detail_jabatan . ' ' . $unor_tambahan_pns;
                }
                $jabatan = [
                    'jabatan_pns' =>  $jabatan_pns,
                    'opd_pns' =>  $dataJabatan->sub_opd == '-' ? $dataJabatan->opd : $dataJabatan->sub_opd . ' - ' . $dataJabatan->opd,
                    'jabatan_tambahan_pns' =>  $jabatan_tambahan_pns,
                    'opd_tambahan_pns' =>  $dataJabatanTambahan->sub_opd == '-' ? $dataJabatanTambahan->opd : $dataJabatanTambahan->sub_opd . ' - ' . $dataJabatanTambahan->opd,
                ];
            }
            $dataAtasan = DB::table('jabatan AS j')
                ->join('opd AS o', 'j.id_opd', '=', 'o.id_opd')
                ->join('pegawai_jabatan AS pj', 'j.id_jabatan', '=', 'pj.id_jabatan')
                ->join('pegawai AS p', 'pj.id_pegawai', '=', 'p.id_pegawai')
                ->select(['j.unit_organisasi', 'j.detail_jabatan', 'j.jabatan_tambahan', 'o.opd', 'o.sub_opd', 'pj.jenis_jabatan', 'p.nip', 'p.gelar_depan', 'p.nama_pegawai', 'p.gelar_belakang', 'p.jenis_kelamin'])
                ->where(['j.id_jabatan' => $dataJabatan->atasan_jabatan, 'pj.status_data' => 'a'])
                ->first();
            if ($dataAtasan !== null) {
                $unor_atasan = '';
                $jabatan_atasan = '';
                if ($dataAtasan->unit_organisasi !== '-') {
                    $unor_atasan = $dataAtasan->unit_organisasi;
                }
                if ($dataAtasan->jabatan_tambahan == 'Kepala Sekolah' || $dataAtasan->jabatan_tambahan == 'Kepala Puskesmas') {
                    $jabatan_atasan = $dataAtasan->detail_jabatan . ' ' . $unor_atasan . ' (' . $dataAtasan->jabatan_tambahan . ')';
                } else {
                    $jabatan_atasan = $dataAtasan->detail_jabatan . ' ' . $unor_atasan;
                }
                if ($dataAtasan->jenis_jabatan == 'plt' || $dataAtasan->jenis_jabatan == 'plh') {
                    $jabatan_atasan = strtoupper($dataAtasan->jenis_jabatan) . ' ' . $jabatan_atasan;
                }
                $atasan = [
                    'jk' => $dataAtasan->jenis_kelamin,
                    'nip' => $dataAtasan->nip,
                    'nama' => $dataAtasan->gelar_depan . ' ' . $dataAtasan->nama_pegawai . ' ' . $dataAtasan->gelar_belakang,
                    'jabatan' => $jabatan_atasan,
                    'opd' => $dataAtasan->sub_opd == '-' ? $dataAtasan->opd : $dataAtasan->sub_opd . ' - ' . $dataAtasan->opd,
                ];
            }
        }
        return view('pegawai.jabatan.jabatan-atasan.tampilan', [
            'pesan' => $pesan,
            'jabatan' => $jabatan,
            'atasan' => $atasan,
        ]);
    }
    public function riwayatJabatan()
    {
        $jabatan = DB::table('pegawai_jabatan AS pj')
            ->join('jabatan AS j', 'pj.id_jabatan', '=', 'j.id_jabatan')
            ->join('opd AS o', 'j.id_opd', '=', 'o.id_opd')
            ->select(['pj.id_pegawai_jabatan', 'pj.tanggal_awal', 'pj.tanggal_akhir', 'j.unit_organisasi', 'j.detail_jabatan', 'j.jabatan_tambahan', 'o.opd', 'o.sub_opd', 'pj.jenis_jabatan'])
            ->where(['pj.id_pegawai' => session()->get('_id_pegawai'), 'pj.jenis_jabatan' => '-'])
            ->get();
        return view('pegawai.jabatan.riwayat-jabatan.tampilan', ['jabatan' => $jabatan]);
    }
}
