<?php

namespace App\Helpers;

use App\Helpers\Database;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class SearchBuilder
{
    protected $request;
    protected $query;
    protected $allowedColumns;
    protected $mapColumns;
    protected $debug = false;
    protected $numericColumns = []; // Add this property
    protected $dateColumns = []; // Add date columns property
    protected $jsonColumns = []; // Add JSON columns property

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

    public function __construct(Request $request, Builder $query, array $allowedColumns = [], array $mapColumns = [], bool $debug = false)
    {
        $this->request = $request;
        $this->query = $query;
        $this->allowedColumns = $allowedColumns ?: Database::getColumns($query->getModel()->getTable());
        $this->mapColumns = $mapColumns;
        $this->debug = $debug;
        
        // Detect numeric columns
        $this->detectNumericColumns();
    }

    /**
     * Detect which columns are numeric in the database
     */
    protected function detectNumericColumns(): void
    {
        $table = $this->query->getModel()->getTable();
        $columns = Schema::getColumnListing($table);
        
        foreach ($columns as $column) {
            $type = Schema::getColumnType($table, $column);
            
            // Check if column is numeric type
            if (in_array($type, ['integer', 'bigint', 'decimal', 'float', 'double', 'numeric', 'real'])) {
                $this->numericColumns[] = $column;
            }
            
            // Check if column is date/datetime type
            if (in_array($type, ['date', 'datetime', 'timestamp', 'time', 'year'])) {
                $this->dateColumns[] = $column;
            }
            
            // Check if column is JSON type
            if (in_array($type, ['json', 'jsonb'])) {
                $this->jsonColumns[] = $column;
            }
        }
    }

    /**
     * Set numeric columns manually if needed
     */
    public function setNumericColumns(array $columns): self
    {
        $this->numericColumns = $columns;
        return $this;
    }

    /**
     * Set date columns manually if needed
     */
    public function setDateColumns(array $columns): self
    {
        $this->dateColumns = $columns;
        return $this;
    }

    /**
     * Set JSON columns manually if needed
     */
    public function setJsonColumns(array $columns): self
    {
        $this->jsonColumns = $columns;
        return $this;
    }

    public function debug(bool $enabled = true): self
    {
        $this->debug = $enabled;
        return $this;
    }

    public function build(): Builder
    {
        if ($this->request->has('searchBuilder')) {
            $searchBuilder = $this->request->input('searchBuilder');
            
            if ($searchBuilder && is_array($searchBuilder)) {
                if ($this->debug) {
                    Log::info('SearchBuilder Criteria:', [
                        'criteria' => $searchBuilder,
                        'numeric_columns' => $this->numericColumns,
                        'date_columns' => $this->dateColumns,
                        'json_columns' => $this->jsonColumns
                    ]);
                }
                
                $this->applySearchBuilderCriteria($this->query, $searchBuilder);
                
                if ($this->debug) {
                    Log::info('SearchBuilder SQL:', [
                        'sql' => $this->query->toSql(),
                        'bindings' => $this->query->getBindings()
                    ]);
                }
            }
        }

        return $this->query;
    }

    protected function applySearchBuilderCriteria(Builder $query, array $searchBuilder): void
    {
        $groupLogic = isset($searchBuilder['logic']) ? strtoupper($searchBuilder['logic']) : 'AND';
        $groupLogic = in_array($groupLogic, ['AND', 'OR']) ? $groupLogic : 'AND';

        if (!isset($searchBuilder['criteria']) || empty($searchBuilder['criteria'])) {
            return;
        }

        $query->where(function (Builder $subQuery) use ($searchBuilder, $groupLogic) {
            foreach ($searchBuilder['criteria'] as $index => $rule) {
                if (isset($rule['criteria'])) {
                    $method = ($index > 0 && $groupLogic === 'OR') ? 'orWhere' : 'where';
                    $this->applyNestedGroup($subQuery, $rule, $method);
                } else {
                    $method = ($index > 0 && $groupLogic === 'OR') ? 'orWhere' : 'where';
                    $this->applyRule($subQuery, $rule, $method);
                }
            }
        });
    }

    protected function applyNestedGroup(Builder $query, array $rule, string $method): void
    {
        $groupLogic = isset($rule['logic']) ? strtoupper($rule['logic']) : 'AND';
        $groupLogic = in_array($groupLogic, ['AND', 'OR']) ? $groupLogic : 'AND';

        $query->{$method}(function (Builder $subQuery) use ($rule, $groupLogic) {
            foreach ($rule['criteria'] as $index => $criterion) {
                if (isset($criterion['criteria'])) {
                    $nestedMethod = ($index > 0 && $groupLogic === 'OR') ? 'orWhere' : 'where';
                    $this->applyNestedGroup($subQuery, $criterion, $nestedMethod);
                } else {
                    $ruleMethod = ($index > 0 && $groupLogic === 'OR') ? 'orWhere' : 'where';
                    $this->applyRule($subQuery, $criterion, $ruleMethod);
                }
            }
        });
    }

    protected function applyRule(Builder $query, array $rule, string $method): void
    {
        if (!isset($rule['origData'], $rule['condition']) || !$this->isValidRule($rule)) {
            return;
        }

        $col = $this->getValidColumn($rule['origData']);
        if (!$col) {
            return;
        }

        $condition = $rule['condition'];
        $operator = $this->sbRules[$condition] ?? null;
        if (!$operator) {
            return;
        }

        $values = $this->getFormattedValues($rule);
        
        if ($this->isNumericColumn($col) && $this->isNumericComparison($condition)) {
            $this->applyNumericCondition($query, $method, $col, $operator, $values);
        } 
        else if ($this->isDateColumn($col) && $this->isDateComparison($condition)) {
            $this->applyDateCondition($query, $method, $col, $operator, $values);
        }
        else if ($this->isJsonColumn($col)) {
            $this->applyJsonCondition($query, $method, $col, $operator, $values, $rule);
        }
        else {
            $this->applyCondition($query, $method, $col, $operator, $values);
        }
    }

    protected function isNumericColumn(string $column): bool
    {
        $columnName = $column;
        if (Str::contains($column, '.')) {
            $parts = explode('.', $column);
            $columnName = end($parts);
        }
        
        return in_array($columnName, $this->numericColumns);
    }

    protected function isDateColumn(string $column): bool
    {
        $columnName = $column;
        if (Str::contains($column, '.')) {
            $parts = explode('.', $column);
            $columnName = end($parts);
        }
        
        return in_array($columnName, $this->dateColumns);
    }

    protected function isJsonColumn(string $column): bool
    {
        $columnName = $column;
        if (Str::contains($column, '.')) {
            $parts = explode('.', $column);
            $columnName = end($parts);
        }
        
        return in_array($columnName, $this->jsonColumns);
    }

    protected function isNumericComparison(string $condition): bool
    {
        return in_array($condition, ['=', '>', '>=', '<', '<=', '!=', 'between', '!between']);
    }

    protected function isDateComparison(string $condition): bool
    {
        return in_array($condition, ['=', '>', '>=', '<', '<=', '!=', 'between', '!between', 'null', '!null']);
    }

    protected function applyNumericCondition(Builder $query, string $method, string $column, string $operator, array $values): void
    {
        if (Str::contains($column, '.')) {
            $this->applyRelationshipNumericCondition($query, $method, $column, $operator, $values);
            return;
        }

        $castColumn = "CAST({$column} AS DECIMAL)";
        
        switch ($operator) {
            case 'between':
                $query->{$method . 'Raw'}("$castColumn BETWEEN ? AND ?", $values);
                break;
            case 'not between':
                $query->{$method . 'Raw'}("$castColumn NOT BETWEEN ? AND ?", $values);
                break;
            default:
                $query->{$method . 'Raw'}("$castColumn $operator ?", [$values[0] ?? null]);
                break;
        }
    }

    protected function applyRelationshipNumericCondition(Builder $query, string $method, string $path, string $operator, array $values): void
    {
        $parts = explode('.', $path);
        $column = array_pop($parts);
        $relationPath = implode('.', $parts);
        
        $whereHasMethod = $method === 'where' ? 'whereHas' : 'orWhereHas';
        
        $query->{$whereHasMethod}($relationPath, function($relatedQuery) use ($column, $operator, $values) {
            $castColumn = "CAST({$column} AS DECIMAL)";
            
            switch ($operator) {
                case 'between':
                    $relatedQuery->whereRaw("$castColumn BETWEEN ? AND ?", $values);
                    break;
                case 'not between':
                    $relatedQuery->whereRaw("$castColumn NOT BETWEEN ? AND ?", $values);
                    break;
                default:
                    $relatedQuery->whereRaw("$castColumn $operator ?", [$values[0] ?? null]);
                    break;
            }
        });
    }

    protected function applyDateCondition(Builder $query, string $method, string $column, string $operator, array $values): void
    {
        if (Str::contains($column, '.')) {
            $this->applyRelationshipDateCondition($query, $method, $column, $operator, $values);
            return;
        }

        switch ($operator) {
            case 'between':
                $startDate = $values[0];
                $endDate = $values[1] ?? $values[0];
                
                if (strlen($startDate) === 10) { // Format: YYYY-MM-DD
                    $startDate .= ' 00:00:00';
                }
                if (strlen($endDate) === 10) {
                    $endDate .= ' 23:59:59';
                }
                
                $query->{$method . 'Between'}($column, [$startDate, $endDate]);
                break;
                
            case 'not between':
                $startDate = $values[0];
                $endDate = $values[1] ?? $values[0];
                
                if (strlen($startDate) === 10) {
                    $startDate .= ' 00:00:00';
                }
                if (strlen($endDate) === 10) {
                    $endDate .= ' 23:59:59';
                }
                
                $query->{$method . 'NotBetween'}($column, [$startDate, $endDate]);
                break;
                
            case '=':
                if (strlen($values[0]) === 10) {
                    $query->{$method . 'Between'}($column, [$values[0] . ' 00:00:00', $values[0] . ' 23:59:59']);
                } else {
                    $query->{$method}($column, $operator, $values[0]);
                }
                break;
                
            case 'IS NULL':
                $query->{$method . 'Null'}($column);
                break;
                
            case 'IS NOT NULL':
                $query->{$method . 'NotNull'}($column);
                break;
                
            default:
                $query->{$method}($column, $operator, $values[0] ?? null);
                break;
        }
    }

    protected function applyRelationshipDateCondition(Builder $query, string $method, string $path, string $operator, array $values): void
    {
        $parts = explode('.', $path);
        $column = array_pop($parts);
        $relationPath = implode('.', $parts);
        
        $whereHasMethod = $method === 'where' ? 'whereHas' : 'orWhereHas';
        
        $query->{$whereHasMethod}($relationPath, function($relatedQuery) use ($column, $operator, $values) {
            $tempQuery = clone $relatedQuery;
            $this->applyDateCondition($tempQuery, 'where', $column, $operator, $values);
        });
    }

    protected function applyJsonCondition(Builder $query, string $method, string $column, string $operator, array $values, array $rule): void
    {
        $jsonPath = $rule['jsonPath'] ?? null;
        
        if ($jsonPath) {
            $column = "{$column}->{$jsonPath}";
        }
        
        if (Str::contains($column, '.')) {
            $this->applyRelationshipCondition($query, $method, $column, $operator, $values);
            return;
        }
        
        switch ($operator) {
            case 'contains':
            case 'LIKE':
                $query->{$method}($column, 'LIKE', $values[0]);
                break;
                
            case 'IS NULL':
                $query->{$method . 'Null'}($column);
                break;
                
            case 'IS NOT NULL':
                $query->{$method . 'NotNull'}($column);
                break;
                
            default:
                $query->{$method}($column, $operator, $values[0] ?? null);
                break;
        }
    }

    protected function isValidRule(array $rule): bool
    {
        $condition = $rule['condition'] ?? '';
        $needsValue = !in_array($condition, ['null', '!null']);
        
        if ($needsValue && !isset($rule['value1'])) {
            return false;
        }

        if (in_array($condition, ['between', '!between']) && !isset($rule['value2'])) {
            return false;
        }

        return true;
    }

    protected function getValidColumn(string $column): ?string
    {
        if (!in_array($column, $this->allowedColumns) && !isset($this->mapColumns[$column])) {
            return null;
        }

        return $this->mapColumns[$column] ?? $column;
    }

    protected function getFormattedValues(array $rule): array
    {
        $condition = $rule['condition'];
        $value1 = $rule['value1'] ?? null;
        $value2 = $rule['value2'] ?? null;

        if (isset($rule['origData']) && $this->isNumericColumn($rule['origData']) && $this->isNumericComparison($condition)) {
            $value1 = is_numeric($value1) ? (float) $value1 : $value1;
            $value2 = is_numeric($value2) ? (float) $value2 : $value2;
        }

        switch ($condition) {
            case 'starts':
            case '!starts':
                return [$value1 . '%'];
            case 'ends':
            case '!ends':
                return ['%' . $value1];
            case 'contains':
            case '!contains':
                return ['%' . $value1 . '%'];
            case 'between':
            case '!between':
                return $this->formatBetweenValues($value1, $value2);
            case 'null':
            case '!null':
                return [];
            default:
                return [$value1];
        }
    }

    protected function formatBetweenValues($value1, $value2): array
    {
        $value2 = $value2 ?? $value1;

        if ($this->isDate($value1)) {
            return [
                $value1 . ' 00:00:00',
                ($this->isDate($value2) ? $value2 : $value1) . ' 23:59:59'
            ];
        }

        return [$value1, $value2];
    }

    protected function isDate($value): bool
    {
        if (!is_string($value)) {
            return false;
        }
        
        return (bool) preg_match("/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/", $value);
    }
    
    protected function applyCondition(Builder $query, string $method, string $column, string $operator, array $values): void
    {
        if (Str::contains($column, '.')) {
            $this->applyRelationshipCondition($query, $method, $column, $operator, $values);
            return;
        }
        
        switch ($operator) {
            case 'between':
                $query->{$method . 'Between'}($column, $values);
                break;
            case 'not between':
                $query->{$method . 'NotBetween'}($column, $values);
                break;
            case 'IS NULL':
                $query->{$method . 'Null'}($column);
                break;
            case 'IS NOT NULL':
                $query->{$method . 'NotNull'}($column);
                break;
            default:
                $query->{$method}($column, $operator, $values[0] ?? null);
                break;
        }
    }

    protected function applyRelationshipCondition(Builder $query, string $method, string $path, string $operator, array $values): void
    {
        $parts = explode('.', $path);
        $column = array_pop($parts);
        $relationPath = implode('.', $parts);
        
        $whereHasMethod = $method === 'where' ? 'whereHas' : 'orWhereHas';
        
        $query->{$whereHasMethod}($relationPath, function($relatedQuery) use ($column, $operator, $values) {
            switch ($operator) {
                case 'between':
                    $relatedQuery->whereBetween($column, $values);
                    break;
                case 'not between':
                    $relatedQuery->whereNotBetween($column, $values);
                    break;
                case 'IS NULL':
                    $relatedQuery->whereNull($column);
                    break;
                case 'IS NOT NULL':
                    $relatedQuery->whereNotNull($column);
                    break;
                default:
                    $relatedQuery->where($column, $operator, $values[0] ?? null);
                    break;
            }
        });
    }
}

// Usage examples:

// $dataTable->filter(function ($query) use ($request) {
//     $sb = new \App\Helpers\SearchBuilder($request, $query);
//     $sb->setNumericColumns(['damaged_length'])
//       ->setDateColumns(['created_at', 'updated_at'])
//       ->debug(true)
//       ->build();
// });

// Model with casts (alternative approach)
/*
class YourModel extends Model
{
    protected $casts = [
        'damaged_length' => 'integer',
        'price' => 'decimal:2',
        'inspection_date' => 'date',
        'settings' => 'json',
    ];
}
*/