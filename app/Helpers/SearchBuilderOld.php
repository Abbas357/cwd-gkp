<?php

namespace App\Helpers;

use App\Helpers\Database;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

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

    public function __construct(Request $request, Builder $query, array $allowedColumns = [], array $mapColumns = [])
    {
        $this->request = $request;
        $this->query = $query;
        $this->allowedColumns = $allowedColumns ?: Database::getColumns($query->getModel()->getTable());
        $this->mapColumns = $mapColumns;
    }

    public function build(): Builder
    {
        if ($this->request->has('searchBuilder')) {
            $searchBuilder = $this->request->searchBuilder;
            if ($searchBuilder && is_array($searchBuilder)) {
                $this->applySearchBuilderCriteria($this->query, $searchBuilder);
            }
        }

        return $this->query;
    }

    protected function applySearchBuilderCriteria(Builder $query, array $searchBuilder): void
    {
        $groupLogic = isset($searchBuilder['logic']) ? strtoupper($searchBuilder['logic']) : 'AND';
        $groupLogic = in_array($groupLogic, ['AND', 'OR']) ? $groupLogic : 'AND';

        if (!isset($searchBuilder['criteria'])) {
            return;
        }

        $query->where(function (Builder $subQuery) use ($searchBuilder, $groupLogic) {
            foreach ($searchBuilder['criteria'] as $rule) {
                if (isset($rule['criteria'])) {
                    $this->applyNestedGroup($subQuery, $rule, $groupLogic);
                } else {
                    $this->applyRule($subQuery, $rule, $groupLogic);
                }
            }
        }, null, null, $groupLogic);
    }

    protected function applyNestedGroup(Builder $query, array $rule, string $parentLogic): void
    {
        $groupLogic = isset($rule['logic']) ? strtoupper($rule['logic']) : 'AND';
        $groupLogic = in_array($groupLogic, ['AND', 'OR']) ? $groupLogic : 'AND';

        $method = $parentLogic === 'OR' ? 'orWhere' : 'where';

        $query->{$method}(function (Builder $subQuery) use ($rule, $groupLogic) {
            $this->applySearchBuilderCriteria($subQuery, $rule);
        });
    }

    protected function applyRule(Builder $query, array $rule, string $groupLogic): void
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
        $method = $groupLogic === 'OR' ? 'orWhere' : 'where';

        $this->applyCondition($query, $method, $col, $operator, $values);
    }

    protected function isValidRule(array $rule): bool
    {
        $condition = $rule['condition'] ?? '';
        $needsValue = !in_array($condition, ['null', '!null']);
        
        if ($needsValue && !isset($rule['value1'])) {
            return false;
        }

        if (in_array($condition, ['between', '!between']) && !isset($rule['value1'])) {
            return false;
        }

        return true;
    }

    protected function getValidColumn(string $column): ?string
    {
        if (!in_array($column, $this->allowedColumns)) {
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
        return (bool) preg_match("/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/", $value);
    }

    protected function applyCondition(Builder $query, string $method, string $column, string $operator, array $values): void
    {
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
}