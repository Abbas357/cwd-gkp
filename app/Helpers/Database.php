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

    public static function applyRelationalSearch($dataTable, array $relationMappings)
    {
        return $dataTable->filter(function ($query) use ($relationMappings) {
            $keyword = request()->input('search.value');
            
            if (empty($keyword)) {
                return;
            }
            
            $query->where(function ($query) use ($keyword, $relationMappings) {
                $table = $query->getModel()->getTable();
                $columns = self::getColumns($table);
                
                foreach ($columns as $column) {
                    if (in_array($column, ['created_at', 'updated_at', 'deleted_at', 'remember_token', 'password'])) {
                        continue;
                    }
                    $query->orWhere($table.'.'.$column, 'LIKE', "%{$keyword}%");
                }
                
                foreach ($relationMappings as $relationPath) {
                    $parts = explode('.', $relationPath);
                    $column = array_pop($parts);
                    $relation = implode('.', $parts);
                    
                    $query->orWhereHas($relation, function ($q) use ($column, $keyword) {
                        $q->where($column, 'LIKE', "%{$keyword}%");
                    });
                }
            });
        });
    }
}