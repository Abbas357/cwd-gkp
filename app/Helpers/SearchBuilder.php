<?php

namespace App\Helpers;

use App\Helpers\Database;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class SearchBuilder
{
    protected $request;
    protected $query;
    protected $allowedColumns;
    protected $mapColumns;
    protected $debug = false;

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
                    Log::info('SearchBuilder Criteria:', ['criteria' => $searchBuilder]);
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
        $this->applyCondition($query, $method, $col, $operator, $values);
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
        // Split the path into relation and column parts
        $parts = explode('.', $path);
        $column = array_pop($parts);
        $relationPath = implode('.', $parts);
        
        // Determine the correct whereHas method
        $whereHasMethod = $method === 'where' ? 'whereHas' : 'orWhereHas';
        
        // Apply the condition through the relationship
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