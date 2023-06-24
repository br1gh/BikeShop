<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\AccessoryParameter;
use App\Models\Parameter;
use App\Vendor\Table;
use Exception;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AccessoryController extends Controller
{
    private $validationRules = [
        'name' => 'required',
        'price' => 'required|numeric',
    ];

    public function index()
    {
        $table = new Table('accessories');
        return view('layouts.index.index', [
            'columns' => $table->columns,
            'tableName' => $table->tableName,
            'title' => $table->title,
            'pageHasTable' => true,
        ]);
    }

    public function edit($id = 0)
    {
        $obj = $id > 0 ? Accessory::findOrFail($id) : new Accessory();

        $parametersGroupChunk = Parameter::select([
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
            ->leftJoin('accessory_parameters', function (JoinClause $join) use ($obj) {
                $join->on('parameters.id', '=', 'accessory_parameters.parameter_id');
                $join->where('accessory_parameters.accessory_id', '=', $obj->id);
            })
            ->where('for_accessories', '=', 1)
            ->where('type', '<>', 'part')
            ->orderBy('name')
            ->get()
            ->groupBy('type')
            ->chunk(4);

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
                        AccessoryParameter::updateOrCreate(
                            [
                                'accessory_id' => $obj->id,
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
                    ->route('accessories.edit', ['id' => $obj->id])
                    ->with('danger', 'Something went wrong');
            }
            return redirect()
                ->route('accessories.edit', ['id' => $obj->id])
                ->with('success', 'Accessory has been saved successfully');
        }

        return view('layouts.edit.edit', [
            'title' => 'Accessories',
            'obj' => $obj,
            'parametersGroupChunk' => $parametersGroupChunk,
            'parameterTypes' => Parameter::getTypes(),
        ]);
    }

    public function delete($id)
    {
        $obj = Accessory::findOrFail($id);
        DB::beginTransaction();
        try {
            $obj->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()
                ->route('accessories.index')
                ->with('danger', 'Something went wrong');
        }
        return redirect()
            ->route('accessories.index')
            ->with('success', 'Accessory deleted successfully');
    }
}
