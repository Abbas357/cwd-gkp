<?php

namespace App;

use Illuminate\Http\Request;

class SearchBuilder
{
    protected $request;
    protected $query;
    protected $allowedColumns;
    protected $mapColumns;

    protected $sbRules = [
        '=' => '=',
        '>' => '>',
        '>=' => '>=',
        '<' => '<',
        '<=' => '<=',
        '!=' => '!=',
        'starts' => 'LIKE',
        '!starts' => 'NOT LIKE',
        'contains' => 'LIKE',
        '!contains' => 'NOT LIKE',
        'ends' => 'LIKE',
        '!ends' => 'NOT LIKE',
        'null' => 'IS NULL',
        '!null' => 'IS NOT NULL',
        'between' => 'between',
        '!between' => 'not between',
    ];

    public function __construct(Request $request, $query, array $allowedColumns = [], array $mapColumns = [])
    {
        $this->request = $request;
        $this->query = $query;
        $this->allowedColumns = !empty($allowedColumns) ? $allowedColumns : \Illuminate\Support\Facades\Schema::getColumnListing($query->getModel()->getTable());
        $this->mapColumns = $mapColumns;
    }

    public function build()
    {
        if ($this->request->has('searchBuilder')) {
            $searchBuilder = $this->request->searchBuilder;
            if ($searchBuilder) {
                $this->applySearchBuilderCriteria($this->query, $searchBuilder);
            }
        }

        return $this->query;
    }

    protected function applySearchBuilderCriteria($query, $searchBuilder, $logic = 'AND')
    {
        $logicValid = in_array($logic, ['AND', "OR"]);

        if ($logicValid && isset($searchBuilder['criteria'])) {
            $sbLogic = [];
            foreach ($searchBuilder['criteria'] as $rule) {
                if (isset($rule['criteria'])) {
                    $this->applySearchBuilderCriteria($query, $rule, $rule['logic'] ?? 'AND');
                } else {
                    $col = $rule['origData'] ?? 'id';
                    if (empty($col) || !in_array($col, $this->allowedColumns)) {
                        $col = 'id';
                    }

                    $searchTerm = (!in_array($rule['condition'] ?? null, ['null', '!null'])) ? $rule['value1'] ?? false : true;

                    $colType = \Illuminate\Support\Facades\Schema::getColumnType($this->query->getModel()->getTable(), $col);

                    if ($col && $searchTerm && array_key_exists($rule['condition'] ?? null, $this->sbRules) && in_array($col, $this->allowedColumns)) {
                        if ($rule['condition'] === 'starts' || $rule['condition'] === '!starts') {
                            $searchTerm = $searchTerm . '%';
                        } elseif ($rule['condition'] === 'ends' || $rule['condition'] === '!ends') {
                            $searchTerm = '%' . $searchTerm;
                        } elseif ($rule['condition'] === 'contains' || $rule['condition'] === '!contains') {
                            $searchTerm = '%' . $searchTerm . '%';
                        } elseif ($rule['condition'] === 'between' || $rule['condition'] === '!between') {
                            if (preg_match("/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/", $rule['value1'])) {
                                $date2 = $rule['value2'] ?? $rule['value1'];
                                $searchTerm = [$rule['value1'] . " 00:00:00", $date2 . " 23:59:59"];
                            } else {
                                $searchTerm = [$rule['value1'], $rule['value2'] ?? null];
                            }
                        }

                        $col = (!empty($this->mapColumns)) ? $this->mapColumns[$col] ?? $col : $col;
                        $sbLogic[] = [$col, $this->sbRules[$rule['condition'] ?? null], $searchTerm];
                    }
                }
            }

            if ($sbLogic) {
                $query->where(function ($query) use ($sbLogic, $logic) {
                    foreach ($sbLogic as $r) {
                        $cond = 'where';
                        if ($r[1] == 'between') {
                            $cond = ($logic == 'AND') ? 'whereBetween' : 'orWhereBetween';
                            $query->{$cond}($r[0], $r[2]);
                        } elseif ($r[1] == 'not between') {
                            $cond = ($logic == 'AND') ? 'whereNotBetween' : 'orWhereNotBetween';
                            $query->{$cond}($r[0], $r[2]);
                        } elseif ($r[1] == 'IS NULL') {
                            $cond = ($logic == 'AND') ? 'whereNull' : 'orWhereNull';
                            $query->{$cond}($r[0]);
                        } elseif ($r[1] == 'IS NOT NULL') {
                            $cond = ($logic == 'AND') ? 'whereNotNull' : 'orWhereNotNull';
                            $query->{$cond}($r[0]);
                        } else {
                            if ($logic == 'AND') {
                                $query->where($r[0], $r[1], $r[2]);
                            } else {
                                $query->orWhere($r[0], $r[1], $r[2]);
                            }
                        }
                    }
                });
            }
        }
    }
}
