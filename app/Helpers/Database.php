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

    public static function getColumnDetails($table)
    {
        try {
            $columns = DB::select("SHOW COLUMNS FROM $table");
            $details = [];
            
            foreach ($columns as $column) {
                $details[] = [
                    'field' => $column->Field,
                    'type' => $column->Type,
                    'null' => $column->Null,
                    'key' => $column->Key,
                    'default' => $column->Default,
                    'extra' => $column->Extra
                ];
            }
            
            return $details;
        } catch (\Exception $e) {
            return [];
        }
    }

    public static function detectColumnTypes($table)
    {
        $columns = self::getColumnDetails($table);
        $result = [
            'numeric' => [],
            'date' => [],
            'json' => [],
            'text' => []
        ];

        foreach ($columns as $column) {
            $type = strtolower($column['type']);
            $field = $column['field'];

            // Detect numeric columns
            if (self::isNumericType($type)) {
                $result['numeric'][] = $field;
            }
            // Detect date/time columns
            elseif (self::isDateType($type)) {
                $result['date'][] = $field;
            }
            // Detect JSON columns
            elseif (self::isJsonType($type)) {
                $result['json'][] = $field;
            }
            // Detect text columns
            elseif (self::isTextType($type)) {
                $result['text'][] = $field;
            }
        }

        return $result;
    }

    public static function getNumericColumns($table)
    {
        $types = self::detectColumnTypes($table);
        return $types['numeric'];
    }

    public static function getDateColumns($table)
    {
        $types = self::detectColumnTypes($table);
        return $types['date'];
    }

    public static function getJsonColumns($table)
    {
        $types = self::detectColumnTypes($table);
        return $types['json'];
    }

    public static function getTextColumns($table)
    {
        $types = self::detectColumnTypes($table);
        return $types['text'];
    }

    private static function isNumericType($type)
    {
        $numericTypes = [
            'tinyint', 'smallint', 'mediumint', 'int', 'integer', 'bigint',
            'decimal', 'numeric', 'float', 'double', 'real', 'bit'
        ];

        foreach ($numericTypes as $numericType) {
            if (strpos($type, $numericType) === 0) {
                return true;
            }
        }

        return false;
    }

    private static function isDateType($type)
    {
        $dateTypes = [
            'date', 'datetime', 'timestamp', 'time', 'year'
        ];

        foreach ($dateTypes as $dateType) {
            if (strpos($type, $dateType) === 0) {
                return true;
            }
        }

        return false;
    }

    private static function isJsonType($type)
    {
        return strpos($type, 'json') === 0;
    }

    private static function isTextType($type)
    {
        $textTypes = [
            'char', 'varchar', 'text', 'tinytext', 'mediumtext', 'longtext'
        ];

        foreach ($textTypes as $textType) {
            if (strpos($type, $textType) === 0) {
                return true;
            }
        }

        return false;
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

    public static function applySmartSearch($dataTable, array $relationMappings = [])
    {
        return $dataTable->filter(function ($query) use ($relationMappings) {
            $keyword = request()->input('search.value');
            
            if (empty($keyword)) {
                return;
            }
            
            $query->where(function ($query) use ($keyword, $relationMappings) {
                $table = $query->getModel()->getTable();
                $columnTypes = self::detectColumnTypes($table);
                
                // Search in text columns
                foreach ($columnTypes['text'] as $column) {
                    if (in_array($column, ['remember_token', 'password'])) {
                        continue;
                    }
                    $query->orWhere($table.'.'.$column, 'LIKE', "%{$keyword}%");
                }
                
                // Search in numeric columns if keyword is numeric
                if (is_numeric($keyword)) {
                    foreach ($columnTypes['numeric'] as $column) {
                        $query->orWhere($table.'.'.$column, '=', $keyword);
                    }
                }
                
                // Search in date columns if keyword looks like a date
                if (self::isDateLike($keyword)) {
                    foreach ($columnTypes['date'] as $column) {
                        $query->orWhere($table.'.'.$column, 'LIKE', "%{$keyword}%");
                    }
                }
                
                // Search in relations
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

    private static function isDateLike($value)
    {
        return preg_match('/^\d{4}-\d{2}-\d{2}/', $value) || 
               preg_match('/^\d{2}\/\d{2}\/\d{4}/', $value) ||
               preg_match('/^\d{2}-\d{2}-\d{4}/', $value);
    }
}