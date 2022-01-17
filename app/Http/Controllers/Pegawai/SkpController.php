<?php

namespace App\Http\Controllers\Pegawai;

use App\Helpers\Pembantu;
use App\Http\Controllers\Controller;
use App\Models\Skp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkpController extends Controller
{
    public function tupoksi()
    {
        return view('pegawai.skp.tupoksi.tampilan');
    }
    public function dataTupoksi()
    {
        $data = Skp::_ambilBeberapaRecord('tupoksi', ['id_tupoksi', 'tupoksi'], ['id_jabatan' => session()->get('_id_jabatan_dinas'), 'status_data' => 'a']);
        return view('pegawai.skp.tupoksi.data', ['data' => $data]);
    }
    public function simpanTupoksi(Request $request)
    {
        $request->validate([
            'tupoksi' => 'required|max:255',
        ]);
        $data = [
            'id_tupoksi' => Pembantu::kode('tupoksi', 'id_tupoksi', 'TP'),
            'tupoksi' => $request->input('tupoksi'),
            'id_jabatan' => session()->get('_id_jabatan_dinas'),
            'id_opd' => session()->get('_id_opd'),
        ];
        if (Skp::_simpanTable('tupoksi', $data)) {
            return json_encode(['status' => true]);
        } else {
            return json_encode(['status' => false]);
        }
    }
    public function hapusTupoksi(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $data = [
            'status_data' => 't',
        ];
        $where = [
            'id_tupoksi' => decrypt($request->input('id')),
        ];
        if (skp::_updateTable('tupoksi', $where, $data)) {
            return json_encode(['status' => true]);
        } else {
            return json_encode(['status' => false]);
        }
    }
    public function periode()
    {
        return view('pegawai.skp.periode.tampilan');
    }
    public function dataPeriode()
    {
        $data = Skp::_ambilBeberapaRecord('periode_skp', ['id_periode_skp', 'tanggal_awal', 'tanggal_akhir'], ['id_pegawai_jabatan' => session()->get('_id_pegawai_jabatan_dinas'), 'status_data' => 'a']);
        return view('pegawai.skp.periode.data', ['data' => $data]);
    }
    public function simpanPeriode(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required',
            'tanggal_akhir' => 'required',
        ]);
        $p = DB::table('pegawai_jabatan AS pj')
            ->join('jabatan AS j', 'pj.id_jabatan', '=', 'j.id_jabatan')
            ->join('pegawai_tmt AS pt', 'pj.id_pegawai', '=', 'pt.id_pegawai')
            ->select(['j.atasan_jabatan', 'pt.id_pegawai_tmt'])
            ->where(['pj.id_pegawai_jabatan' => session()->get('_id_pegawai_jabatan_dinas'), 'pt.jenis_tmt' => 'p', 'pt.status_data' => 'a'])
            ->first();
        $pa = DB::table('pegawai_jabatan AS pj')
            ->join('pegawai_tmt AS pt', 'pj.id_pegawai', '=', 'pt.id_pegawai')
            ->select(['pj.id_pegawai_jabatan', 'pt.id_pegawai_tmt'])
            ->where(['pj.id_jabatan' => $p->atasan_jabatan, 'pj.status_data' => 'a', 'pt.jenis_tmt' => 'p', 'pt.status_data' => 'a'])
            ->first();
        $data = [
            'id_periode_skp' => Pembantu::kode('periode_skp', 'id_periode_skp', 'PSKP'),
            'id_pegawai_jabatan' => session()->get('_id_pegawai_jabatan_dinas'),
            'id_pegawai_tmt' => $p->id_pegawai_tmt,
            'id_pegawai_jabatan_atasan' => $pa->id_pegawai_jabatan,
            'id_pegawai_tmt_atasan' => $pa->id_pegawai_tmt,
            'tahun' => date('Y'),
            'tanggal_awal' => Carbon::createFromFormat('d-m-Y', $request->input('tanggal_awal'))->format('Y-m-d'),
            'tanggal_akhir' => Carbon::createFromFormat('d-m-Y', $request->input('tanggal_akhir'))->format('Y-m-d'),
        ];
        if (Skp::_simpanTable('periode_skp', $data)) {
            return json_encode(['status' => true]);
        } else {
            return json_encode(['status' => false]);
        }
    }
    public function hapusPeriode(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $data = [
            'status_data' => 't',
        ];
        $where = [
            'id_periode_skp' => decrypt($request->input('id')),
        ];
        if (skp::_updateTable('periode_skp', $where, $data)) {
            return json_encode(['status' => true]);
        } else {
            return json_encode(['status' => false]);
        }
    }
    public function skp()
    {
        $data = Skp::_ambilSatuRecordLimitOne('periode_skp', ['id_periode_skp', 'tanggal_awal', 'tanggal_akhir'], ['id_pegawai_jabatan' => session()->get('_id_pegawai_jabatan_dinas'), 'tahun' => date('Y'), 'status_data' => 'a'], 'id_periode_skp');
        if ($data !== null) {
            $skp = Skp::_ambilBeberapaRecord('skp', ['id_skp'], ['id_periode_skp' => $data->id_periode_skp]);
            $skp_blm_dikirim = Skp::_ambilBeberapaRecord('skp', ['id_skp'], ['status_skp' => 'b', 'id_periode_skp' => $data->id_periode_skp]);
            $ad = [
                'skp' => $skp,
                'skp_blm_dikirim' => $skp_blm_dikirim,
                'data' => $data,
            ];
            if ($skp_blm_dikirim->count() == $skp->count()) {
                $ad = [
                    'skp' => $skp,
                    'skp_blm_dikirim' => $skp_blm_dikirim,
                    'data' => $data,
                    'tupoksi' => Skp::_ambilBeberapaRecord('tupoksi', ['id_tupoksi', 'tupoksi'], ['id_jabatan' => session()->get('_id_jabatan_dinas'), 'status_data' => 'a']),
                    'satuan' => Skp::_ambilBeberapaRecord('satuan', ['id_satuan', 'satuan'], ['status_data' => 'a']),
                ];
            }
            return view('pegawai.skp.skp.tampilan', $ad);
        } else {
            $pesan = [
                1 => 'Kami tidak menemukan data periode skp terakhir pada tahun ' . date('Y'),
                2 => 'Jadi anda tidak bisa membuat skp',
            ];
            return view('errors.pesan', ['pesan' => $pesan]);
        }
    }
    public function kegiatanAtasan()
    {
        if (session()->get('_level_dinas') != '1') {
            $dinas = DB::table('jabatan AS j')
                ->join('pegawai_jabatan AS pj', 'j.atasan_jabatan', '=', 'pj.id_jabatan')
                ->select(['pj.jenis_jabatan', 'pj.id_pegawai_jabatan'])
                ->where(['j.id_jabatan' => session()->get('_id_jabatan_dinas'), 'pj.status_data' => 'a'])
                ->first();
            if ($dinas->jenis_jabatan == 'plt' || $dinas->jenis_jabatan == 'plh') {
                echo '<option value=""></option>';
                echo '<option disabled="disabled" value="kosong">ATASAN ANDA MERUPAKAN PLT/PLH, JADI TIDAK BISA MEMBREACKDOWN KE SKP ANDA</option>';
                echo '<option value="-">1. TIDAK ADA DATA SKP</option>';
            } elseif ($dinas->jenis_jabatan == 'tbh') {
            } else {
                $ad = [
                    'tb1' => 'periode_skp AS ps',
                    'tb2' => 'skp AS s',
                    'pk1' => 'ps.id_periode_skp',
                    'pk2' => 's.id_periode_skp',
                    'select' => ['s.id_tupoksi', 's.kegiatan'],
                    'where' => ['ps.id_pegawai_jabatan' => $dinas->id_pegawai_jabatan, 'ps.status_data' => 'a', 's.status_skp' => 's', 's.verifikasi_atasan' => 't'],
                ];
                $periode = Skp::_joinOneWhere($ad);
                if ($periode->count() > 0) {
                    $n = 1;
                    echo '<option value=""></option>';
                    foreach ($periode as $k) {
                        echo '<option value="' . $k->id_tupoksi . '">' . $n++ . '. ' . $k->kegiatan . '</option>';
                    }
                } else {
                    echo '<option value=""></option>';
                    echo '<option disabled="disabled" value="kosong">PNS YANG BERSANGKUTAN BELUM MEMBUAT SKP PADA PERIODE TERAKHIR</option>';
                }
            }
        }
    }
    public function simpanSkp(Request $request)
    {
        $request->validate([
            'id_periode_skp' => 'required',
            'id_tupoksi_atasan' => 'required',
            'id_tupoksi' => 'required',
            'kegiatan' => 'required',
            'angka_kredit' => 'required',
            'output' => 'required',
            'id_satuan' => 'required',
            'mutu' => 'required|numeric',
            'waktu' => 'required|numeric|between:1,12',
            'biaya' => 'required|numeric',
        ]);
        $atasan = Skp::_ambilSatuRecord('jabatan', ['atasan_jabatan'], ['id_jabatan' => session()->get('_id_jabatan_dinas')]);
        $status_skp = 'b';
        $verifikasi_atasan = 't';
        if (session()->get('_level_dinas') != '1') {
            $verifikasi_atasan = 'm';
        }
        $data = [
            'id_skp' => Pembantu::kode('skp', 'id_skp', 'SKP'),
            'id_pegawai' => session()->get('_id_pegawai'),
            'id_tupoksi' => $request->input('id_tupoksi'),
            'id_opd' => session()->get('_id_opd'),
            'id_periode_skp' => decrypt($request->input('id_periode_skp')),
            'id_jabatan_atasan' => $atasan->atasan_jabatan,
            'id_tupoksi_atasan' => $request->input('id_tupoksi_atasan'),
            'sumber_skp' => 't',
            'kegiatan' => $request->input('kegiatan'),
            'angka_kredit' => $request->input('angka_kredit'),
            'output' => $request->input('output'),
            'mutu' => $request->input('mutu'),
            'waktu' => $request->input('waktu'),
            'id_satuan' => $request->input('id_satuan'),
            'biaya' => $request->input('biaya'),
            'status_skp' => $status_skp,
            'verifikasi_atasan' => $verifikasi_atasan,
            'prosentase' => 0,
        ];
        if (Skp::_simpanTable('skp', $data)) {
            return json_encode(['status' => true]);
        } else {
            return json_encode(['status' => false]);
        }
    }
    public function dataSkp(Request $request)
    {
        $request->validate([
            'id_periode_skp' => 'required',
        ]);
        $id_periode_skp = decrypt($request->input('id_periode_skp'));
        $ad = [
            'tb1' => 'skp AS skp',
            'tb2' => 'satuan AS s',
            'pk1' => 'skp.id_satuan',
            'pk2' => 's.id_satuan',
            'select' => ['skp.id_skp', 'skp.kegiatan', 'skp.angka_kredit', 'skp.output', 'skp.mutu', 'skp.waktu', 'skp.biaya', 'skp.status_skp', 'skp.verifikasi_atasan', 's.satuan'],
            'where' => ['skp.id_periode_skp' => $id_periode_skp],
        ];
        $skp = Skp::_joinOneWhere($ad);
        return view('pegawai.skp.skp.data', [
            'id_periode_skp' => $id_periode_skp,
            'skp' => $skp,
            'skp_diterima' => Skp::_ambilBeberapaRecord('skp', ['id_skp'], ['verifikasi_atasan' => 't', 'id_periode_skp' => $id_periode_skp]),
            'skp_blm_dikirim' => Skp::_ambilBeberapaRecord('skp', ['id_skp'], ['status_skp' => 'b', 'id_periode_skp' => $id_periode_skp]),
            'skp_dikirim' => Skp::_ambilBeberapaRecord('skp', ['id_skp'], ['status_skp' => 's', 'id_periode_skp' => $id_periode_skp]),
        ]);
    }
    public function kirimSkp(Request $request)
    {
        $request->validate([
            'id_periode_skp' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $id_periode_skp = decrypt($request->input('id_periode_skp'));
            if (session()->get('_level_dinas') == '1') {
                $skp = Skp::_ambilBeberapaRecord('skp', ['id_skp'], ['id_periode_skp' => $id_periode_skp, 'waktu' => '12']);
                if ($skp->count() > 0) {
                    foreach ($skp as $k) {
                        for ($i = 1; $i <= 12; $i++) {
                            $bulan = [
                                'id_kegiatan_bulan' => Pembantu::kode('kegiatan_bulan', 'id_kegiatan_bulan', 'KBP'),
                                'id_skp' => $k->id_skp,
                                'id_pegawai' => session()->get('_id_pegawai'),
                                'bulan_pelaksanaan' => $i,
                            ];
                            Skp::_simpanManual('kegiatan_bulan', $bulan);
                        }
                    }
                }
            }
            Skp::_updateTable('skp', ['id_periode_skp' => $id_periode_skp], ['status_skp' => 's']);
            DB::commit();
            return json_encode(['status' => true]);
        } catch (\Throwable $e) {
            DB::rollback();
            return json_encode(['status' => false]);
        }
    }
    public function cetakSkp(Request $request)
    {
        $request->validate([
            'id_periode_skp' => 'required',
        ]);
        $id_periode_skp = decrypt($request->input('id_periode_skp'));
        $ad = [
            'tb1' => 'skp AS skp',
            'tb2' => 'satuan AS s',
            'pk1' => 'skp.id_satuan',
            'pk2' => 's.id_satuan',
            'select' => ['skp.id_skp', 'skp.kegiatan', 'skp.angka_kredit', 'skp.output', 'skp.mutu', 'skp.waktu', 'skp.biaya', 'skp.status_skp', 'skp.verifikasi_atasan', 's.satuan'],
            'where' => ['skp.id_periode_skp' => $id_periode_skp],
        ];
        $skp = Skp::_joinOneWhere($ad);
        return view('pegawai.skp.skp.cetak', [
            'skp' => $skp,
        ]);
    }
    public function hapusSkp(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $where = [
            'id_skp' => decrypt($request->input('id')),
        ];
        if (skp::_hapusTable('skp', $where)) {
            return json_encode(['status' => true]);
        } else {
            return json_encode(['status' => false]);
        }
    }
    public function breakdownSkp()
    {
        $data = Skp::_ambilSatuRecordLimitOne('periode_skp', ['id_periode_skp', 'tanggal_awal', 'tanggal_akhir'], ['id_pegawai_jabatan' => session()->get('_id_pegawai_jabatan_dinas'), 'tahun' => date('Y'), 'status_data' => 'a'], 'id_periode_skp');
        if ($data !== null) {
            $ad = [
                'tb1' => 'skp AS skp',
                'tb2' => 'satuan AS s',
                'pk1' => 'skp.id_satuan',
                'pk2' => 's.id_satuan',
                'select' => ['skp.id_skp', 'skp.kegiatan', 'skp.angka_kredit', 'skp.output', 'skp.mutu', 'skp.waktu', 'skp.biaya', 'skp.status_skp', 'skp.verifikasi_atasan', 's.satuan'],
                'where' => ['skp.id_periode_skp' => $data->id_periode_skp, 'skp.status_skp' => 's'],
            ];
            $skp = Skp::_joinOneWhere($ad);
            if ($skp->count() > 0) {
                return view('pegawai.skp.breakdown.tampilan', [
                    'skp' => $skp,
                    'data' => $data,
                    'skp_diterima' => Skp::_ambilBeberapaRecord('skp', ['id_skp'], ['verifikasi_atasan' => 't', 'id_periode_skp' => $data->id_periode_skp]),
                    'skp_dikirim' => Skp::_ambilBeberapaRecord('skp', ['id_skp'], ['status_skp' => 's', 'id_periode_skp' => $data->id_periode_skp]),
                ]);
            } else {
                $pesan = [
                    1 => 'Tidak ada data skp yang sudah diterima oleh atasan',
                    2 => 'Jadi anda tidak bisa membreakdown data skp anda',
                ];
                if (session()->get('_level_dinas') == '1') {
                    $pesan = [
                        1 => 'Data skp belum divalidasi oleh anda',
                        2 => 'Jadi anda tidak bisa membreakdown data skp anda',
                    ];
                }
                return view('errors.pesan', ['pesan' => $pesan]);
            }
        } else {
            $pesan = [
                1 => 'Kami tidak menemukan data periode skp terakhir pada tahun ' . date('Y'),
                2 => 'Jadi anda tidak bisa membuat skp',
            ];
            return view('errors.pesan', ['pesan' => $pesan]);
        }
    }
    function tampilBreakdownSkp(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $id = decrypt($request->input('id'));
        $ad = [
            'tb1' => 'skp AS skp',
            'tb2' => 'satuan AS s',
            'pk1' => 'skp.id_satuan',
            'pk2' => 's.id_satuan',
            'select' => ['skp.id_skp', 'skp.kegiatan', 'skp.angka_kredit', 'skp.output', 'skp.mutu', 'skp.waktu', 'skp.biaya', 's.satuan'],
            'where' => ['skp.id_skp' => $id],
        ];
        $skp = Skp::_joinOneWhereGetOne($ad);
        $skp_breakdown = Skp::_ambilBeberapaRecord('kegiatan_bulan', ['id_kegiatan_bulan'], ['id_skp' => $id]);
        if ($skp !== null) {
            return view('pegawai.skp.breakdown.data', ['skp' => $skp, 'skp_breakdown' => $skp_breakdown]);
        } else {
            return "MAAF! DATA TIDAK DITEMUKAN";
        }
    }
    function simpanBreakdownSkp(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'data' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $id = decrypt($request->input('id'));
            $data = $request->input('data');
            $skp_breakdown = Skp::_ambilBeberapaRecord('kegiatan_bulan', ['id_kegiatan_bulan'], ['id_skp' => $id]);
            if ($skp_breakdown->count() > 0) {
                $i = 0;
                foreach ($skp_breakdown as $k) {
                    DB::table('kegiatan_bulan')
                        ->where(['id_kegiatan_bulan' => $k->id_kegiatan_bulan])
                        ->update(['bulan_pelaksanaan' => $data[$i++]]);
                }
            } else {
                for ($i = 0; $i < count($data); $i++) {
                    $d = [
                        'id_kegiatan_bulan' => Pembantu::kode('kegiatan_bulan', 'id_kegiatan_bulan', 'KBP'),
                        'id_skp' => $id,
                        'id_pegawai' => session()->get('_id_pegawai'),
                        'bulan_pelaksanaan' => $data[$i],
                    ];
                    DB::table('kegiatan_bulan')->insert($d);
                }
            }
            DB::commit();
            return json_encode(['status' => true]);
        } catch (\Throwable $e) {
            DB::rollback();
            return json_encode(['status' => false]);
        }
    }
}
