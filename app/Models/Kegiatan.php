<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Kegiatan extends MY_Model
{
    use HasFactory;
    public static function ambilKegiatanHarian($tgl)
    {
        return DB::table('kegiatan_hari AS kh')
            ->join('kegiatan_bulan AS kb', 'kh.id_kegiatan_bulan', '=', 'kb.id_kegiatan_bulan')
            ->join('skp AS skp', 'kb.id_skp', '=', 'skp.id_skp')
            ->join('aktivitas AS a', 'kh.id_aktivitas', '=', 'a.id_aktivitas')
            ->join('satuan AS s', 'a.id_satuan', '=', 's.id_satuan')
            ->select(['kh.id_kegiatan_hari', 'kh.jam_mulai', 'kh.jam_selesai', 'kh.kuantitas', 'kh.poin', 'kh.status_aktivitas', 'kh.keterangan', 'a.aktivitas', 's.satuan', 'skp.kegiatan'])
            ->where(['kh.id_pegawai' => session()->get('_id_pegawai'), 'kh.tanggal_pelaksanaan' => $tgl])
            ->get();
    }
    public static function formAmbilKegiatanHarian($tgl)
    {
        return DB::table('kegiatan_hari AS kh')
            ->join('aktivitas AS a', 'kh.id_aktivitas', '=', 'a.id_aktivitas')
            ->select(['kh.jam_mulai', 'kh.jam_selesai', 'kh.keterangan', 'a.aktivitas'])
            ->where(['kh.id_pegawai' => session()->get('_id_pegawai'), 'kh.tanggal_pelaksanaan' => $tgl])
            ->get();
    }
    public static function ambilKegiatanBulanan($tgl)
    {
        return DB::table('kegiatan_hari AS kh')
            ->join('kegiatan_bulan AS kb', 'kh.id_kegiatan_bulan', '=', 'kb.id_kegiatan_bulan')
            ->join('skp AS skp', 'kb.id_skp', '=', 'skp.id_skp')
            ->join('aktivitas AS a', 'kh.id_aktivitas', '=', 'a.id_aktivitas')
            ->join('satuan AS s', 'a.id_satuan', '=', 's.id_satuan')
            ->select(['kh.id_kegiatan_hari', 'kh.tanggal_pelaksanaan', 'kh.jam_mulai', 'kh.jam_selesai', 'kh.kuantitas', 'kh.poin', 'kh.status_aktivitas', 'kh.keterangan', 'a.aktivitas', 's.satuan', 'skp.kegiatan'])
            ->where(['kh.id_pegawai' => session()->get('_id_pegawai')])
            ->where('kh.tanggal_pelaksanaan', 'like', '%' . $tgl . '%')
            ->orderBy('kh.tanggal_pelaksanaan', 'asc')
            ->orderBy('kh.jam_mulai', 'asc')
            ->get();
    }
    public static function ambilKegiatanBulananGroup($tgl)
    {
        return DB::table('kegiatan_hari')
            ->select(['tanggal_pelaksanaan as tg', 'status_aktivitas as sa', DB::raw('SUM(poin) as p')])
            ->where(['id_pegawai' => session()->get('_id_pegawai')])
            ->where('tanggal_pelaksanaan', 'like', '%' . $tgl . '%')
            ->groupBy('tanggal_pelaksanaan')
            ->groupBy('status_aktivitas')
            ->get();
    }
}
