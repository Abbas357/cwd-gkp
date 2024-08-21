<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;

abstract class Controller
{
    protected function DataTable($dataSource, $searchColumns, $recordFormatter)
    {
        $request = request();
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");
    
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
    
        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];
    
        // Determine the type of $dataSource and get the query or collection
        if ($dataSource instanceof \Illuminate\Database\Eloquent\Model) {
            $query = $dataSource->newQuery();
        } elseif ($dataSource instanceof \Illuminate\Database\Eloquent\Builder) {
            $query = $dataSource;
        } elseif ($dataSource instanceof \Illuminate\Support\Collection) {
            $query = null;
            $collection = $dataSource;
        } else {
            throw new \InvalidArgumentException('The second argument must be an instance of Model, Builder, or Collection.');
        }
    
        if ($query) {
            if ($rowperpage == -1) {
                $totalRecords = $query->count();
                $rowperpage = $totalRecords;
            }
    
            // Total records
            $totalRecords = $query->count();
            $totalRecordswithFilter = $query->where(function ($query) use ($searchColumns, $searchValue) {
                foreach ($searchColumns as $column) {
                    $query->orWhere($column, 'like', '%' . $searchValue . '%');
                }
            })->count();
    
            // Get records, also we have included search filter as well
            $records = $query->orderBy($columnName, $columnSortOrder)
                ->where(function ($query) use ($searchColumns, $searchValue) {
                    foreach ($searchColumns as $column) {
                        $query->orWhere($column, 'like', '%' . $searchValue . '%');
                    }
                })
                ->skip($start)
                ->take($rowperpage)
                ->get();
        } else {
            $totalRecords = $collection->count();
            $filtered = $collection->filter(function ($item) use ($searchColumns, $searchValue) {
                foreach ($searchColumns as $column) {
                    if (stripos($item[$column], $searchValue) !== false) {
                        return true;
                    }
                }
                return false;
            });
    
            $totalRecordswithFilter = $filtered->count();
            $sorted = $filtered->sortBy(function ($item) use ($columnName, $columnSortOrder) {
                return $item[$columnName];
            }, SORT_REGULAR, $columnSortOrder == 'desc');
            $records = $sorted->slice($start, $rowperpage);
        }
    
        $formattedRecords = $records->map($recordFormatter);
    
        $response = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $formattedRecords->values(),
        ];
    
        return response()->json($response);
    }
}
