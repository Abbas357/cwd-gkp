<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Database
{
    public static function getColumns($table)
    {
        try {
            return array_column(DB::select("SHOW COLUMNS FROM $table"), 'Field');
        } catch (\Exception $e) {
            return ['id', 'created_at', 'updated_at'];
        }
    }

    public static function tableExists($table)
    {
        try {
            DB::select("SHOW TABLES LIKE '$table'");
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function getTableSize($table)
    {
        try {
            $result = DB::select("
                SELECT 
                    round(((data_length + index_length) / 1024 / 1024), 2) as 'size' 
                FROM information_schema.TABLES 
                WHERE table_schema = DATABASE()
                AND table_name = ?
            ", [$table]);
            
            return $result[0]->size ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }
}