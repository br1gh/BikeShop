<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Vendor\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BikeController extends Controller
{
    private $validationRules = [
        'name' => 'required',
        'price' => 'required|numeric',
    ];

    public function index()
    {
        $table  = new Table('bikes');
        return view('layouts.index', [
            'columns' => $table->columns,
            'tableName' => $table->tableName,
            'title' => $table->title,
            'pageHasTable' => true,
        ]);
    }

    public function edit($id = 0)
    {
        $obj = $id > 0 ? Bike::find($id) : new Bike();
        if (request()->isMethod('post')) {
            $post = request()->get('form', []);

            Validator::make($post, $this->validationRules)->validate();

            DB::beginTransaction();
            try {
                $obj->fill($post);
                $obj->save();
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                throw $exception;
            }

            return redirect()->route('bikes.edit', ['id' => $obj->id]);
        }

        return view('admin.bikes.edit', [
            'obj' => $obj,
        ]);
    }
}
