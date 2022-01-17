<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MY_Model extends Model
{
    use HasFactory;

    public static function _ambilSatuRecord($table, $select, $where)
    {
        return DB::table($table)->select($select)->where($where)->first();
    }
    public static function _ambilSatuRecordLimitOne($table, $select, $where, $order)
    {
        return DB::table($table)->select($select)->where($where)->latest($order)->first();
    }
    public static function _ambilBeberapaRecord($table, $select, $where)
    {
        return DB::table($table)->select($select)->where($where)->get();
    }
    public static function _ambilRecord($table, $select, $where)
    {
        return DB::table($table)->select($select)->where($where)->get();
    }
    public static function _simpanTable($table, $data)
    {
        DB::beginTransaction();
        try {
            DB::table($table)->insert($data);
            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollback();
            return false;
        }
    }
    public static function _simpanManual($table, $data)
    {
        return DB::table($table)->insert($data);
    }
    public static function _joinOne($d)
    {
        return DB::table($d['tb1'])
            ->join($d['tb2'], $d['pk1'], '=', $d['pk2'])
            ->select($d['select'])
            ->get();
    }
    public static function _joinOneWhere($d)
    {
        return DB::table($d['tb1'])
            ->join($d['tb2'], $d['pk1'], '=', $d['pk2'])
            ->select($d['select'])
            ->where($d['where'])
            ->get();
    }
    public static function _joinOneWhereGetOne($d)
    {
        return DB::table($d['tb1'])
            ->join($d['tb2'], $d['pk1'], '=', $d['pk2'])
            ->select($d['select'])
            ->where($d['where'])
            ->first();
    }
    public static function _updateTable($table, $where, $data)
    {
        DB::beginTransaction();
        try {
            DB::table($table)
                ->where($where)
                ->update($data);
            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollback();
            return false;
        }
    }
    public static function _updateManual($table, $where, $data)
    {
        return DB::table($table)
            ->where($where)
            ->update($data);
    }
    public static function _hapusTable($table, $where)
    {
        DB::beginTransaction();
        try {
            DB::table($table)
                ->where($where)
                ->delete();
            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollback();
            return false;
        }
    }
}
