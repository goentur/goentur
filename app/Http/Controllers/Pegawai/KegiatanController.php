<?php

namespace App\Http\Controllers\Pegawai;

use App\Helpers\Pembantu;
use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Show the application kegiatan.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function kegiatanHari()
    {
        $skp = null;
        $pesan  = null;
        $jabatanQuery = [
            'tb1' => 'jabatan AS j',
            'tb2' => 'pegawai_jabatan AS pj',
            'pk1' => 'j.atasan_jabatan',
            'pk2' => 'pj.id_jabatan',
            'select' => ['pj.id_pegawai_jabatan'],
            'where' => ['j.id_jabatan' => session()->get('_id_jabatan_dinas'), 'pj.status_data' => 'a'],
        ];
        $jabatan = Kegiatan::_joinOneWhereGetOne($jabatanQuery);
        if ($jabatan !== null) {
            $periode = Kegiatan::_ambilSatuRecordLimitOne('periode_skp', ['id_periode_skp'], ['id_pegawai_jabatan' => session()->get('_id_pegawai_jabatan_dinas'), 'tahun' => date('Y'), 'status_data' => 'a'], 'id_periode_skp');
            if ($periode !== null) {
                $bulan = 1;
                if (date('d') < 2) {
                    if (date('m') == 1) {
                        $bulan = 12;
                    } else {
                        if (date('m') < 10) {
                            $bulan =  str_replace("0", "", date('m'));
                        } else {
                            $bulan = date('m');
                        }
                    }
                } else {
                    if (date('m') < 10) {
                        $bulan =  str_replace("0", "", date('m'));
                    } else {
                        $bulan = date('m');
                    }
                }
                $skpQuery = [
                    'tb1' => 'kegiatan_bulan AS k',
                    'tb2' => 'skp AS s',
                    'pk1' => 'k.id_skp',
                    'pk2' => 's.id_skp',
                    'select' => ['k.id_kegiatan_bulan', 's.kegiatan'],
                    'where' => ['s.id_periode_skp' => $periode->id_periode_skp, 's.status_skp' => 's', 's.verifikasi_atasan' => 't', 'k.bulan_pelaksanaan' => $bulan],
                ];
                $skp = Kegiatan::_joinOneWhere($skpQuery);
                if ($skp->count() == 0) {
                    $pesan = [
                        1 => 'Coba cek data skp anda. Apakah ada atau tidak?',
                        2 => session()->get('_level_dinas') == '1' ? 'Kemudian, coba cek data skp anda. Apakah sudah divalidasi oleh anda?' : 'Kemudian, coba cek data skp anda. Apakah sudah disetujui oleh atasan?',
                        3 => 'Kemudian, coba cek apakah anda sudah membreakdown skp anda ke bulanan?',
                        4 => 'Jika ada permasalahan diatas, maka anda tidak bisa membuat kegiatan harian',
                    ];
                }
            } else {
                $pesan = [
                    1 => 'Maaf, tidak ada data periode skp pada tahun ' . date('Y'),
                    2 => 'Jadi anda tidak bisa membuat kegiatan harian',
                ];
            }
        } else {
            $pesan = [
                1 => 'Maaf, tidak ada data atasan',
                2 => 'Jadi anda tidak bisa membuat kegiatan harian',
            ];
        }
        return view('pegawai.kegiatan.harian.tampilan', [
            'pesan' => $pesan,
            'skp' => $skp,
        ]);
    }
    public function simpanKegiatanHari(Request $request)
    {
        $request->validate([
            'menit' => 'required|numeric',
            'bulan' => 'required',
            'hari' => 'required',
            'kuantitas' => 'required|numeric',
            'tanggal' => 'required',
            'jamMulai' => 'required',
            'jamSelesai' => 'required',
            'keterangan' => 'required',
        ]);
        $atasan = Kegiatan::_ambilSatuRecord('jabatan', ['atasan_jabatan'], ['id_jabatan' => session()->get('_id_jabatan_dinas')]);
        $tanggal = Carbon::createFromFormat('d-m-Y', $request->input('tanggal'))->format('Y-m-d');
        $dataSebelumnya = Kegiatan::_ambilSatuRecordLimitOne('kegiatan_hari', ['jam_selesai'], ['id_pegawai' => session()->get('_id_pegawai'), 'tanggal_pelaksanaan' => $tanggal], 'jam_selesai');
        if ($dataSebelumnya == null) {
            $data = [
                'id_kegiatan_hari' => Pembantu::kode('kegiatan_hari', 'id_kegiatan_hari', 'KHP'),
                'id_kegiatan_bulan' => $request->input('bulan'),
                'id_pegawai' => session()->get('_id_pegawai'),
                'id_jabatan_atasan' => $atasan->atasan_jabatan,
                'id_aktivitas' => $request->input('hari'),
                'tanggal_pelaksanaan' => $tanggal,
                'jam_mulai' => $request->input('jamMulai'),
                'jam_selesai' => $request->input('jamSelesai'),
                'kuantitas' => $request->input('kuantitas'),
                'poin' => $request->input('menit') * $request->input('kuantitas') / 60,
                'status_aktivitas' => session()->get('_level_dinas') != '1' ? 'm' : 't',
                'status_presensi' => 'm',
                'keterangan' => $request->input('keterangan'),
                'alasan_penolakan' => '-',
            ];
            if (Kegiatan::_simpanTable('kegiatan_hari', $data)) {
                return json_encode(['status' => true]);
            } else {
                return json_encode(['status' => false, 'message' => 'Data kegiatan harian gagal disimpan']);
            }
        } else {
            if (str_replace(":", "", $request->input('jamMulai') . ":00") > str_replace(":", "", $dataSebelumnya->jam_selesai)) {
                $data = [
                    'id_kegiatan_hari' => Pembantu::kode('kegiatan_hari', 'id_kegiatan_hari', 'KHP'),
                    'id_kegiatan_bulan' => $request->input('bulan'),
                    'id_pegawai' => session()->get('_id_pegawai'),
                    'id_jabatan_atasan' => $atasan->atasan_jabatan,
                    'id_aktivitas' => $request->input('hari'),
                    'tanggal_pelaksanaan' => $tanggal,
                    'jam_mulai' => $request->input('jamMulai'),
                    'jam_selesai' => $request->input('jamSelesai'),
                    'kuantitas' => $request->input('kuantitas'),
                    'poin' => $request->input('menit') * $request->input('kuantitas') / 60,
                    'status_aktivitas' => session()->get('_level_dinas') != '1' ? 'm' : 't',
                    'status_presensi' => 'm',
                    'keterangan' => $request->input('keterangan'),
                    'alasan_penolakan' => '-',
                ];
                if (Kegiatan::_simpanTable('kegiatan_hari', $data)) {
                    return json_encode(['status' => true]);
                } else {
                    return json_encode(['status' => false, 'message' => 'Data kegiatan harian gagal disimpan']);
                }
            } else {
                return json_encode(['status' => false, 'message' => 'Jam mulai sudah digunakan']);
            }
        }
    }
    public function dataKegiatanHari(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
        ]);
        $tanggal = Carbon::createFromFormat('d-m-Y', $request->input('tanggal'))->format('Y-m-d');
        $data = Kegiatan::ambilKegiatanHarian($tanggal);
        return view('pegawai.kegiatan.harian.data', [
            'tanggal' => $request->input('tanggal'),
            'data' => $data,
        ]);
    }
    public function dataFormKegiatanHari(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
        ]);
        $tanggal = Carbon::createFromFormat('d-m-Y', $request->input('tanggal'))->format('Y-m-d');
        $data = Kegiatan::formAmbilKegiatanHarian($tanggal);
        return view('pegawai.kegiatan.harian.data-form', [
            'tanggal' => $request->input('tanggal'),
            'data' => $data,
        ]);
    }
    public function hapusKegiatanHari(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $where = [
            'id_kegiatan_hari' => decrypt($request->input('id')),
        ];
        if (Kegiatan::_hapusTable('kegiatan_hari', $where)) {
            return json_encode(['status' => true]);
        } else {
            return json_encode(['status' => false]);
        }
    }
    public function kegiatanBulanan()
    {
        return view('pegawai.kegiatan.bulanan.tampilan');
    }
    public function dataKegiatanBulanan(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
        ]);
        $tanggal = Carbon::createFromFormat('m-Y', $request->input('tanggal'))->format('Y-m');
        $data = Kegiatan::ambilKegiatanBulanan($tanggal);
        return view('pegawai.kegiatan.bulanan.data', [
            'bulan' => $tanggal,
            'data' => $data,
        ]);
    }
}
