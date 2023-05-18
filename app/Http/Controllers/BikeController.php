<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\BikeParameter;
use App\Models\Parameter;
use App\Vendor\Table;
use Exception;
use Illuminate\Database\Query\JoinClause;
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
        $table = new Table('bikes');
        return view('layouts.index.index', [
            'columns' => $table->columns,
            'tableName' => $table->tableName,
            'title' => $table->title,
            'pageHasTable' => true,
        ]);
    }

    public function edit($id = 0)
    {
        $obj = $id > 0 ? Bike::findOrFail($id) : new Bike();

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
            ->leftJoin('bike_parameters', function (JoinClause $join) use ($obj) {
                $join->on('parameters.id', '=', 'bike_parameters.parameter_id');
                $join->where('bike_parameters.bike_id', '=', $obj->id);
            })
            ->where('for_bikes', '=', 1)
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
                        BikeParameter::updateOrCreate(
                            [
                                'bike_id' => $obj->id,
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
                    ->route('bikes.edit', ['id' => $obj->id])
                    ->with('danger', 'Something went wrong');
            }
            return redirect()
                ->route('bikes.edit', ['id' => $obj->id])
                ->with('success', 'Bike has been saved successfully');
        }

        return view('layouts.edit.edit', [
            'title' => 'Bikes',
            'obj' => $obj,
            'parameters' => $parameters,
            'parameterTypes' => Parameter::getTypes(),
        ]);
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $obj = Bike::findOrFail($id);
            $obj->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()
                ->route('bikes.index')
                ->with('danger', 'Something went wrong');
        }
        return redirect()
            ->route('bikes.index')
            ->with('success', 'Bike deleted successfully');
    }
}
