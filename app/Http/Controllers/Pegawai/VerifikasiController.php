<?php

namespace App\Http\Controllers\Pegawai;

use App\Helpers\Pembantu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Verifikasi;

class VerifikasiController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pegawai.verifikasi.skp.tampilan');
    }
    public function dataPns(Request $request)
    {
        $request->validate([
            'type' => 'required',
        ]);
        $type = $request->input('type');
        $_id_jabatan_dinas = Verifikasi::ambilPNSBawahan(session()->get('_id_jabatan_dinas'));
        $_id_jabatan_tbh = 'kosong';
        $_id_jabatan_lain = 'kosong';
        $_id_jabatan_lain_tbh = 'kosong';
        if (session()->get('_id_jabatan_tbh') !== 'kosong') {
            $_id_jabatan_tbh = Verifikasi::ambilPNSBawahan(session()->get('_id_jabatan_tbh'));
        } elseif (session()->get('_id_jabatan_lain') !== 'kosong') {
            $_id_jabatan_lain = Verifikasi::ambilPNSBawahan(session()->get('_id_jabatan_lain'));
        } elseif (session()->get('_id_jabatan_lain_tbh') !== 'kosong') {
            $_id_jabatan_lain_tbh = Verifikasi::ambilPNSBawahan(session()->get('_id_jabatan_lain_tbh'));
        }
        if ($type === 's') {
            return view('pegawai.verifikasi.skp.data', [
                '_id_jabatan_dinas' => $_id_jabatan_dinas,
                '_id_jabatan_tbh' => $_id_jabatan_tbh,
                '_id_jabatan_lain' => $_id_jabatan_lain,
                '_id_jabatan_lain_tbh' => $_id_jabatan_lain_tbh,
            ]);
        } elseif ($type === 'a') {
            return view('pegawai.verifikasi.aktivitas.data', [
                '_id_jabatan_dinas' => $_id_jabatan_dinas,
                '_id_jabatan_tbh' => $_id_jabatan_tbh,
                '_id_jabatan_lain' => $_id_jabatan_lain,
                '_id_jabatan_lain_tbh' => $_id_jabatan_lain_tbh,
            ]);
        } else {
            return '<div class="col-12 text-center"><h1>MAAF <span class="text-danger">PNS</span> YANG BERSANGKUTAN BELUM MEMBUAT <span class="text-danger">PERIODE</span> SKP</h1></div>';
        }
    }
    public function dataSKP(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $id = decrypt($request->input('id'));
        $periode_skp = Verifikasi::_ambilSatuRecordLimitOne('periode_skp', ['id_periode_skp', 'tanggal_awal', 'tanggal_akhir'], ['id_pegawai_jabatan' => $id, 'tahun' => date('Y'), 'status_data' => 'a'], 'id_periode_skp');
        if ($periode_skp !== null) {
            $ad = [
                'tb1' => 'skp AS skp',
                'tb2' => 'satuan AS s',
                'pk1' => 'skp.id_satuan',
                'pk2' => 's.id_satuan',
                'select' => ['skp.id_skp', 'skp.kegiatan', 'skp.angka_kredit', 'skp.output', 'skp.mutu', 'skp.waktu', 'skp.biaya', 'skp.verifikasi_atasan', 'skp.alasan_penolakan', 's.satuan'],
                'where' => ['skp.id_periode_skp' => $periode_skp->id_periode_skp, 'skp.status_skp' => 's'],
            ];
            $skp = Verifikasi::_joinOneWhere($ad);
            if ($skp->count() > 0) {
                return view('pegawai.verifikasi.skp.data-skp', [
                    'periode_skp' => $periode_skp,
                    'skp' => $skp,
                ]);
            } else {
                return '<div class="col-12 text-center"><h1>MAAF <span class="text-danger">PNS</span> YANG BERSANGKUTAN BELUM MEMBUAT <span class="text-danger">DATA SKP PADA PERIODE SKP TERAKHIR</span></h1></div>';
            }
        } else {
            return '<div class="col-12 text-center"><h1>MAAF <span class="text-danger">PNS</span> YANG BERSANGKUTAN BELUM MEMBUAT <span class="text-danger">PERIODE</span> SKP</h1></div>';
        }
    }
    public function prosesDataSKP(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'data' => 'required',
        ]);
        $id = decrypt($request->input('id'));
        DB::beginTransaction();
        try {
            $data = $request->input('data');
            foreach ($data as $x) {
                $data = [
                    'verifikasi_atasan' => $x[1],
                    'alasan_penolakan' => $x[2],
                ];
                Verifikasi::_updateManual('skp', ['id_skp' => $x[0]], $data);
                if ($x[1] == 't' && $x[3] == '12') {
                    $kegiatan_bulan = Verifikasi::_ambilBeberapaRecord('kegiatan_bulan', ['id_kegiatan_bulan'], ['id_skp' => $x[0]]);
                    if ($kegiatan_bulan->count() == 0) {
                        for ($i = 1; $i <= 12; $i++) {
                            $bulan = [
                                'id_kegiatan_bulan' => Pembantu::kode('kegiatan_bulan', 'id_kegiatan_bulan', 'KBP'),
                                'id_skp' => $x[0],
                                'id_pegawai' => session()->get('_id_pegawai'),
                                'bulan_pelaksanaan' => $i,
                            ];
                            Verifikasi::_simpanManual('kegiatan_bulan', $bulan);
                        }
                    }
                }
                if ($x[1] == 'x') {
                    Verifikasi::_updateManual('skp', ['id_periode_skp' => $id], ['status_skp' => 'b']);
                }
            }
            DB::commit();
            return json_encode(['status' => true]);
        } catch (\Throwable $e) {
            DB::rollback();
            return json_encode(['status' => false]);
        }
    }
    public function aktivitas()
    {
        return view('pegawai.verifikasi.aktivitas.tampilan');
    }
    public function dataAktivitas(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $tahun = date('Y');
        $bulan = date('m');
        $tahunLalu = Pembantu::tahunLalu(date('m'));
        $bulanLalu = Pembantu::bulanLalu();
        if ($bulanLalu < 10) {
            $bln = '0' . $bulanLalu;
        } else {
            $bln = $bulanLalu;
        }
        if (date('d') <= 2) {
            $tanggal =  $tahunLalu . '-' . $bln . '-01';
        } else if (date('d') > 2) {
            $tanggal = $tahun . '-' . $bulan . '-01';
        }
        $id = decrypt($request->input('id'));
        $data = Verifikasi::ambilKegiatanHarian($id, $tanggal);
        if ($data->count() > 0) {
            return view('pegawai.verifikasi.aktivitas.data-aktivitas', [
                'tanggal' => $tanggal,
                'data' => $data,
            ]);
        } else {
            return '<div class="col-12 text-center"><h1>MAAF <span class="text-danger">PNS</span> YANG BERSANGKUTAN BELUM MEMBUAT <span class="text-danger">KEGIATAN HARIAN</span></h1></div>';
        }
    }
    public function prosesDataAktivitas(Request $request)
    {
        $request->validate([
            'data' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $data = $request->input('data');
            foreach ($data as $x) {
                $data = [
                    'status_aktivitas' => $x[1],
                    'alasan_penolakan' => $x[2],
                ];
                Verifikasi::_updateManual('kegiatan_hari', ['id_kegiatan_hari' => $x[0]], $data);
            }
            DB::commit();
            return json_encode(['status' => true]);
        } catch (\Throwable $e) {
            DB::rollback();
            return json_encode(['status' => false]);
        }
    }
}
