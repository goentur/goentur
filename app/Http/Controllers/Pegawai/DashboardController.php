<?php

namespace App\Http\Controllers\Pegawai;

use App\Helpers\Pembantu;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Kegiatan;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tahunLalu = Pembantu::tahunLalu(date('m'));
        $bulanLalu = Pembantu::bulanLalu();
        if ($bulanLalu < 10) {
            $bln = '0' . $bulanLalu;
        } else {
            $bln = $bulanLalu;
        }
        $tanggal =  $tahunLalu . '-' . $bln;
        return view('pegawai.dashboard.data', [
            'ini' => $this->getCalendar(date('Y-m')),
            'lalu' => $this->getCalendar($tanggal),
        ]);
    }
    public function getCalendar($tanggal)
    {
        $kegiatan = Kegiatan::ambilKegiatanBulananGroup($tanggal);
        $today = Carbon::createFromDate($tanggal);
        $tempDate = Carbon::createFromDate($today->year, $today->month, 1);
        $poinMax = 100;
        $pointotal = 0;
        $poinm = 0;
        $point = 0;
        $html = '<div class="card">';
        $html .= '<div class="card-header bg-primary"><h3 class="text-white text-center"><i class="mdi mdi-calendar-month-outline"></i> ' . strtoupper($today->format('F Y')) . '</h3></div>';
        $html .= '<div class="card-body border border-primary border-top-0"><table class="table table-sm table-bordered">
           <thead><tr class="bg-secondary text-white">
           <th class="text-center">MIN</th>
           <th class="text-center">SEN</th>
           <th class="text-center">SEL</th>
           <th class="text-center">RAB</th>
           <th class="text-center">KAM</th>
           <th class="text-center">JUM</th>
           <th class="text-center">SAB</th>
           </tr></thead>';
        $skip = $tempDate->dayOfWeek;
        for ($i = 0; $i < $skip; $i++) {
            $tempDate->subDay();
        }
        do {
            $html .= '<tr>';
            for ($i = 0; $i < 7; $i++) {
                $bln = $tempDate->month;
                if ($tempDate->month < 10) {
                    $bln = '0' . $tempDate->month;
                }
                $day = $tempDate->day;
                if ($tempDate->day < 10) {
                    $day = '0' . $tempDate->day;
                }
                $data_kegiatan = '';
                foreach ($kegiatan as $k) {
                    if ($k->tg === $tempDate->year . '-' . $bln . '-' . $day) {
                        $m = substr($k->p, 0, 4);
                        $pointotal += $m;
                        if ($k->sa === 'm') {
                            $d = substr($k->p, 0, 4);
                            $poinm += $d;
                            $data_kegiatan .=  '<span class="badge badge-primary">' . $d . '</span>';
                        } elseif ($k->sa === 't') {
                            if ($k->p > 10) {
                                $d = 10;
                            } else {
                                $d = substr($k->p, 0, 4);
                            }
                            $point += $d;
                            $data_kegiatan .=  '<span class="badge badge-success">' .  $d . '</span>';
                        } elseif ($k->sa === 'x') {
                            $data_kegiatan .=  '<span class="badge badge-danger">' . substr($k->p, 0, 4) . '</span>';
                        }
                    }
                }
                if ($data_kegiatan == '') {
                    $data_kegiatan = '&nbsp;';
                }
                $html .= '<td align="center" class="pt-1 shadow-lg bg-white">';
                $html .= '<b style="font-size:20px">' . $day . '</b><br>' . $data_kegiatan;
                $html .= '</td>';
                $tempDate->addDay();
            }
            $html .= '</tr>';
        } while ($tempDate->month == $today->month);
        if ($point > 100) {
            $point = 100;
        }
        $html .= '</table>
            <table class="table-sm">
                <tr>
                    <td><b>POIN MAKSIMAL</b></td>
                    <td>:</td>
                    <td>' . $poinMax . '</td>
                </tr>
                <tr>
                    <td><b>POIN YANG TERKUMPUL</b></td>
                    <td>:</td>
                    <td>' . substr($pointotal, 0, 5) . '</td>
                </tr>
                <tr>
                    <td><b>POIN YANG BELUM DIVERIFIKASI</b></td>
                    <td>:</td>
                    <td>' . substr($poinm, 0, 5) . '</td>
                </tr>
                <tr>
                    <td><b>POIN YANG DIPERHITUNGKAN</b></td>
                    <td>:</td>
                    <td>' . $point . '</td>
                </tr>
            </table></div></div>';
        return $html;
    }
}
