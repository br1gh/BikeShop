<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Models\Part;
use App\Models\PartParameter;
use App\Vendor\Table;
use Exception;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PartController extends Controller
{
    private $validationRules = [
        'name' => 'required',
        'price' => 'required|numeric',
    ];

    public function index()
    {
        $table = new Table('parts');
        return view('layouts.index.index', [
            'columns' => $table->columns,
            'tableName' => $table->tableName,
            'title' => $table->title,
            'pageHasTable' => true,
        ]);
    }

    public function edit($id = 0)
    {
        $obj = $id > 0 ? Part::findOrFail($id) : new Part();

        $parameters = Parameter::select([
            'parameters.id',
            'type',
            'name',
            'unit',
            'value_string',
            'value_integer',
            'value_float',
            'min',
            'max',
            'step',
        ])
            ->leftJoin('part_parameters', function (JoinClause $join) use ($obj) {
                $join->on('parameters.id', '=', 'part_parameters.parameter_id');
                $join->where('part_parameters.part_id', '=', $obj->id);
            })
            ->where('for_parts', '=', 1)
            ->get();

        if (request()->isMethod('post')) {
            $post = request()->get('form', []);
            $postParameter = [
                'integer' => request()->get('form_parameter_integer', []),
                'float' => request()->get('form_parameter_float', []),
                'string' => request()->get('form_parameter_string', []),
            ];

            Validator::make($post, $this->validationRules)->validate();

            DB::beginTransaction();
            try {
                $obj->fill($post);
                $obj->save();

                foreach ($postParameter as $valueType => $array) {
                    foreach ($array as $parameterId => $value) {
                        PartParameter::updateOrCreate(
                            [
                                'part_id' => $obj->id,
                                'parameter_id' => $parameterId,
                            ],
                            [
                                'value_' . $valueType => $value
                            ]
                        );
                    }
                }

                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();
                return redirect()
                    ->route('parts.edit', ['id' => $obj->id])
                    ->with('danger', 'Something went wrong');
            }
            return redirect()
                ->route('parts.edit', ['id' => $obj->id])
                ->with('success', 'Part has been saved successfully');
        }

        return view('layouts.edit.edit', [
            'title' => 'Parts',
            'obj' => $obj,
            'parameters' => $parameters,
            'parameterTypes' => Parameter::getTypes(),
        ]);
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $obj = Part::findOrFail($id);
            $obj->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()
                ->route('parts.index')
                ->with('danger', 'Something went wrong');
        }
        return redirect()
            ->route('parts.index')
            ->with('success', 'Part deleted successfully');
    }
}
