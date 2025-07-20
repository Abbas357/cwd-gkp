<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    public function slug(string $title): string {
        $new_title = implode(' ', array_slice(explode(' ', $title), 0, 5));
        return Str::slug($new_title) . '-' . substr(uniqid('', true), -6) . '-' . date('Y-m-d');
    }

    public function incrementViews($model, $column = 'views_count', $sessionKeyPrefix = null)
    {
        $ipAddress = request()->ip();
        $modelClass = class_basename(get_class($model));
        $sessionKeyPrefix = $sessionKeyPrefix ?? strtolower($modelClass);
        $sessionKey = $sessionKeyPrefix . '_' . $model->id . '_' . md5($ipAddress);

        if (!session()->has($sessionKey)) {
            $model->increment($column);
            session()->put($sessionKey, true);
        }
    }

    public function toRawSql($query)
    {
        $sql = $query->toSql();
        $bindings = $query->getBindings();
        
        $bindings = array_map(function ($binding) {
            return is_numeric($binding) ? $binding : "'{$binding}'";
        }, $bindings);
        
        return vsprintf(str_replace('?', '%s', $sql), $bindings);
    }

    protected function getApiResults(Request $request, string $modelClass, array $config = [])
    {
        $defaults = [
            'searchColumns' => ['name'],
            'withRelations' => [],
            'textFormat' => function($item) { return $item->name; },
            'searchRelations' => [],
            'perPage' => 10,
            'conditions' => [],
            'orderBy' => 'name',
            'orderDirection' => 'asc'
        ];

        $config = array_merge($defaults, $config);
        
        $query = $modelClass::query();
        
        if (!empty($config['withRelations'])) {
            $query->with($config['withRelations']);
        }
        
        if ($request->q) {
            $query->where(function($q) use ($request, $config) {
                foreach ($config['searchColumns'] as $column) {
                    $q->orWhere($column, 'like', "%{$request->q}%");
                }
                
                foreach ($config['searchRelations'] as $relation => $columns) {
                    $q->orWhereHas($relation, function($subQuery) use ($request, $columns) {
                        $subQuery->where(function($sq) use ($request, $columns) {
                            foreach ($columns as $column) {
                                $sq->orWhere($column, 'like', "%{$request->q}%");
                            }
                        });
                    });
                }
            });
        }
        
        foreach ($config['conditions'] as $column => $value) {
            if (is_array($value) && isset($value[0], $value[1])) {
                $query->where($column, $value[0], $value[1]);
            } else {
                $query->where($column, $value);
            }
        }
        
        $query->orderBy($config['orderBy'], $config['orderDirection']);
        
        $results = $query->paginate($config['perPage']);
        
        return response()->json([
            'results' => collect($results->items())->map(function($item) use ($config) {
                return [
                    'id' => $item->id,
                    'text' => $config['textFormat']($item)
                ];
            }),
            'pagination' => [
                'more' => $results->hasMorePages()
            ]
        ]);
    }

    function years()
    {
        $years = [];
        for ($i = date('Y'); $i >= date('Y') - 10; $i--) {
            $years[$i] = $i;
        }
        return $years;
    }

    function months()
    {
        return ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',];
    }

    protected function getBpsRange($start = 1, $end = 22)
    {
        return range($start, $end);
    }
}
