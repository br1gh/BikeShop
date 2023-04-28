<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Vendor\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ParameterController extends Controller
{
    private $types = [
        'select' => 'Select',
        'select_with_unit' => 'Select with unit',
        'text' => 'Text',
        'text_with_unit' => 'Text with unit',
        'checkbox' => 'Checkbox',
    ];

    public function index()
    {
        $table  = new Table('parameters');
        return view('layouts.index', [
            'columns' => $table->columns,
            'tableName' => $table->tableName,
            'title' => $table->title,
            'pageHasTable' => true,
        ]);
    }

    public function edit($id = 0)
    {
        $obj = $id > 0 ? Parameter::find($id) : new Parameter();
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

            return redirect()->route('parameters.edit', ['id' => $obj->id]);
        }

        return view('admin.parameters.edit', [
            'obj' => $obj,
            'types' => $this->types,
        ]);
    }
}
