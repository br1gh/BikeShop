<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use App\Vendor\Table;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    public function fetch(string $tableName)
    {
        $column = request()->get('column', 'name');
        $order = request()->get('order', 'asc');
        $search = request()->get('search');
        $page = request()->get('page', 1);
        $limit = request()->get('limit', 10);
        $filter = request()->get('filter', []);

        $table = new Table($tableName);

        $db = DB::table($tableName);
        $page = min($page, intval(ceil($db->count() / $limit)));
        $db->select(array_merge(['id'], $table->fieldNames));

        if ($tableName == 'users') {
            $db->where('id', '<>', 1);
        }

        if ($filter) {
            foreach ($filter['multiselect'] ?? [] as $field => $value) {
                if ($value) {
                    $db->whereIn($field, $value);
                }
            }

            foreach ($filter['select'] ?? [] as $field => $value) {
                if ($value) {
                    $db->where($field, $value);
                }
            }
        }

        if ($search) {
            $db->where(function ($q) use ($table, $search) {
                foreach ($table->fieldNames as $col) {
                    $q->orWhere($col, 'like', '%' . $search . '%');
                }
            });
        }

        $db->whereNull('deleted_at');
        $db->orderBy($column, $order);
        $items = $db->paginate($limit, [], 'page', $page);

        return response()->json([
            'html' => view('layouts.index.table', [
                'items' => $items,
                'table' => $table,
            ])->render(),
            'lastPage' => $items->lastPage(),
            'currentPage' => $items->currentPage(),
        ]);
    }
}
