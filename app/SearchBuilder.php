<?php

namespace App;

use Illuminate\Http\Request;

/**
 * Depth 1 SearchBuilder for DataTable
 * Supports Query Builder and Eloquent ORM
 * To prevent unauthorized access to the database, the code uses two security measures.
 * First, it filters out any columns that are not in the $allowedColumns array, which specifies
 * the columns that can be read. Second, it checks if the 'condition' parameter matches any of the
 * rules in the $sbRules list, which defines the valid conditions for the operation.
 *
 * If $mapColumns is provided, the join query will function correctly.
 *
 * Example
 * $allowedColumns = ['name','email','mobile','role'];
 * $mapColumns = ['name'=>'users.name', 'mobile'=> 'users.mobile', 'email'=> 'users.email', 'role'=>"roles.text"]; // for join query
 * datatables()
 *     ->of($query->select($_columns))
 *     ->filter(function ($query) use ($request, $allowedColumns, $mapColumns) {
 *         $sb    = new SearchBuilder($request, $query, $allowedColumns, $mapColumns);
 *         $query = $sb->build();
 *     })
 *     ->toJson();
 */

class SearchBuilder
{
    protected $request;
    protected $query;
    protected $allowedColumns;
    protected $mapColumns;

    protected $sbRules = [
        '='         => '=',
        '>'         => '>',
        '>='        => '>=',
        '<'         => '<',
        '<='        => '<=',
        '!='        => '!=',
        'starts'    => 'LIKE',
        '!starts'   => 'NOT LIKE',
        'contains'  => 'LIKE',
        '!contains' => 'NOT LIKE',
        'ends'      => 'LIKE',
        '!ends'     => 'NOT LIKE',
        'null'      => 'IS NULL',
        '!null'     => 'IS NOT NULL',
        'between'   => 'between',
        '!between'  => 'not between',
    ];

    public function __construct(Request $request, $query, array $mapColumns = [])
    {
        $this->request        = $request;
        $this->query          = $query;
        $this->allowedColumns = \Illuminate\Support\Facades\Schema::getColumnListing($query->getModel()->getTable());
        $this->mapColumns     = $mapColumns;
    }

    /**
     * Build Query Where Applicable
     * @note The code is safe from SQL injection attacks, as QueryBuilder and EloquentORM handle the escaping of user input.
     * @note Unwanted columss are protected by $allowedColumns and 'condition' is protected by $sbRules check list
     * @return $query
     */
    public function build()
    {
        if ($this->request->has('searchBuilder')) {
            $searchBuilder = $this->request->searchBuilder;
            if ($searchBuilder) {
                $sbLogic    = [];
                $logic      = $searchBuilder['logic'] ?? "AND";
                $logicValid = in_array($logic, ['AND', "OR"]);
                if ($logicValid && isset($searchBuilder['criteria'])) {
                    foreach ($searchBuilder['criteria'] as $rule) {
                        $col        = $rule['origData'] ?? null;
                        $searchTerm = (!in_array($rule['condition'] ?? null, ['null', '!null'])) ? $rule['value1'] ?? false : true;
                        if ($col && $searchTerm && array_key_exists($rule['condition'] ?? null, $this->sbRules) && in_array($col, $this->allowedColumns)) {
                            if ($rule['condition'] === 'starts' || $rule['condition'] === '!starts') {
                                $searchTerm = $searchTerm . '%';
                            } elseif ($rule['condition'] === 'ends' || $rule['condition'] === '!ends') {
                                $searchTerm = '%' . $searchTerm;
                            } elseif ($rule['condition'] === 'contains' || $rule['condition'] === '!contains') {
                                $searchTerm = '%' . $searchTerm . '%';
                            } elseif ($rule['condition'] === 'between' || $rule['condition'] === '!between') {
                                if (preg_match("/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/", $rule['value1'])) {
                                    $date2      = $rule['value2'] ?? $rule['value1'];
                                    $searchTerm = [$rule['value1'] . " 00:00:00", $date2 . " 23:59:59"];
                                } else {
                                    $searchTerm = [$rule['value1'], $rule['value2'] ?? null];
                                }
                            }
                            $col       = (!empty($this->mapColumns)) ? $this->mapColumns[$col] ?? $col : $col;
                            $sbLogic[] = [$col, $this->sbRules[$rule['condition'] ?? null], $searchTerm];
                        }
                    }

                    if ($sbLogic) {
                        $this->query = $this->query->where(function ($query) use ($sbLogic, $logic) {
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

        return $this->query;
    }

}