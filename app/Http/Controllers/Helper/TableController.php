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
        $table = new Table($tableName);

        $db = DB::table($tableName);
        $page = min($page, intval(ceil($db->count() / $limit)));
        $db->select(array_merge(['id'], $table->fieldNames));

        if ($search) {
            $db->where(function ($q) use ($table, $search) {
                foreach ($table->fieldNames as $col) {
                    $q->orWhere($col, 'like', '%'.$search.'%');
                }
            });
        }

        $db->orderBy($column, $order);
        $items = $db->paginate($limit, [], 'page', $page);

        return response()->json([
            'html' => view('layouts.table', [
                'items' => $items,
                'table' => $table,
            ])->render(),
            'lastPage' => $items->lastPage(),
            'currentPage' => $items->currentPage(),
        ]);
    }
}
