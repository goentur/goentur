<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Pembantu
{
    public static function kode($table, $field, $kode)
    {
        $hari = date('YmdHis');
        $ambil = DB::table($table)
            ->select($field)
            ->where($field, 'like', '%' . $kode . '-' . $hari . '%')
            ->get();
        $jml = $ambil->count() + 1;
        return $kode . '-' . $hari . '-' . $jml;
    }
    public static function bulanLalu()
    {
        if (date('m') == 1) {
            return 12;
        } else if (date('m') == 2) {
            return 1;
        } else if (date('m') == 3) {
            return 2;
        } else if (date('m') == 4) {
            return 3;
        } else if (date('m') == 5) {
            return 4;
        } else if (date('m') == 6) {
            return 5;
        } else if (date('m') == 7) {
            return 6;
        } else if (date('m') == 8) {
            return 7;
        } else if (date('m') == 9) {
            return 8;
        } else if (date('m') == 10) {
            return 9;
        } else if (date('m') == 11) {
            return 10;
        } else if (date('m') == 12) {
            return 11;
        }
    }
    public static function tahunLalu($b)
    {
        if ($b == 1) {
            return date('Y') - 1;
        } else {
            return date('Y');
        }
    }
}
