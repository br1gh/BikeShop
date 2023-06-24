<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Vendor\Table;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ParameterController extends Controller
{
    private $validationRules = [
        "type" => "required|string",
        "name" => "required|string",
        "unit" => "required_if:type,integer with unit,float with unit,text with unit|string",
        "min" => "required_if:type,integer,integer with unit,float,float with unit|numeric",
        "max" => "required_if:type,integer,integer with unit,float,float with unit|numeric",
        "step" => "required_if:type,integer,integer with unit,float,float with unit|numeric",
    ];

    public function index()
    {
        $table = new Table('parameters');
        return view('layouts.index.index', [
            'columns' => $table->columns,
            'tableName' => $table->tableName,
            'title' => $table->title,
            'filters' => [
                'multiselect' => [
                    'type' => Parameter::getTypes(),
                ]
            ],
            'pageHasTable' => true,
        ]);
    }

    public function edit($id = 0)
    {
        $obj = $id > 0 ? Parameter::findOrFail($id) : new Parameter();
        if (request()->isMethod('post')) {
            $post = request()->get('form', []);

            Validator::make($post, $this->validationRules)->validate();

            DB::beginTransaction();
            try {
                $obj->fill($post);
                $obj->save();
                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();
                return redirect()
                    ->route('parameters.edit', ['id' => $obj->id])
                    ->with('danger', 'Something went wrong');
            }
            return redirect()
                ->route('parameters.edit', ['id' => $obj->id])
                ->with('success', 'Parameter has been saved successfully');
        }

        return view('admin.parameters.edit', [
            'obj' => $obj,
            'types' => Parameter::getTypes(),
        ]);
    }

    public function delete($id)
    {
        $obj = Parameter::findOrFail($id);
        DB::beginTransaction();
        try {
            $obj->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()
                ->route('parameters.index')
                ->with('danger', 'Something went wrong');
        }
        return redirect()
            ->route('parameters.index')
            ->with('success', 'Parameter deleted successfully');
    }
}
