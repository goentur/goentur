<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Verifikasi extends MY_Model
{
    use HasFactory;
    public static function ambilPNSBawahan($id_jabatan)
    {
        return DB::table('jabatan AS j')
            ->join('pegawai_jabatan AS pj', 'j.id_jabatan', '=', 'pj.id_jabatan')
            ->join('pegawai AS p', 'pj.id_pegawai', '=', 'p.id_pegawai')
            ->join('opd AS o', 'j.id_opd', '=', 'o.id_opd')
            ->select(['j.unit_organisasi', 'j.detail_jabatan', 'j.jabatan_tambahan', 'pj.id_pegawai_jabatan', 'p.id_pegawai', 'p.nip', 'p.gelar_depan', 'p.nama_pegawai', 'p.gelar_belakang', 'o.opd', 'o.sub_opd'])
            ->where(['j.atasan_jabatan' => $id_jabatan, 'pj.jenis_jabatan' => '-', 'pj.status_data' => 'a'])
            ->get();
    }
    public static function ambilKegiatanHarian($id, $tgl)
    {
        return DB::table('kegiatan_hari AS kh')
            ->join('kegiatan_bulan AS kb', 'kh.id_kegiatan_bulan', '=', 'kb.id_kegiatan_bulan')
            ->join('skp AS skp', 'kb.id_skp', '=', 'skp.id_skp')
            ->join('aktivitas AS a', 'kh.id_aktivitas', '=', 'a.id_aktivitas')
            ->join('satuan AS s', 'a.id_satuan', '=', 's.id_satuan')
            ->select(['kh.id_kegiatan_hari', 'kh.tanggal_pelaksanaan', 'kh.jam_mulai', 'kh.jam_selesai', 'kh.kuantitas', 'kh.poin', 'kh.status_aktivitas', 'kh.keterangan', 'a.aktivitas', 's.satuan', 'skp.kegiatan'])
            ->where(['kh.id_pegawai' => $id, 'kh.status_aktivitas' => 'm'])
            ->whereBetween('kh.tanggal_pelaksanaan', [$tgl, date('Y-m-d')])
            ->orderBy('kh.tanggal_pelaksanaan', 'asc')
            ->orderBy('kh.jam_mulai', 'asc')
            ->get();
    }
}
