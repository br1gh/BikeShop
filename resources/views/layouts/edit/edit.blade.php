@extends('layouts.app')

@section('content')
    <form method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">{{$title}}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <x-input.text
                                    :label="'Name'"
                                    :name="'name'"
                                    :value="$obj->name"
                                />
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <x-input.number
                                    :label="'Price'"
                                    :name="'price'"
                                    :min="'0.00'"
                                    :max="'999999.99'"
                                    :step="'0.01'"
                                    :value="$obj->price"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($parametersGroupChunk as $parametersGroup)
                <div class="col-md-6">
                    @foreach($parametersGroup as $parameterType => $parameters)
                        <div class="card">
                            <div class="card-header">
                                <h5 class="title">{{$parameterTypes[$parameterType]}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($parameters as $parameter)
                                        <div class="col-12">

                                            @if($parameter->type == 'integer')
                                                <x-input.number
                                                    :label="$parameter->name"
                                                    :group="'form_parameter_integer'"
                                                    :name="$parameter->id"
                                                    :value="$parameter->value_integer"
                                                    :min="$parameter->min"
                                                    :max="$parameter->max"
                                                    :step="$parameter->step"
                                                />
                                            @endif

                                            @if($parameter->type == 'integer with unit')
                                                <x-input.number
                                                    :label="$parameter->name . ' ('. $parameter->unit.')'"
                                                    :group="'form_parameter_integer'"
                                                    :name="$parameter->id"
                                                    :value="$parameter->value_integer"
                                                    :min="$parameter->min"
                                                    :max="$parameter->max"
                                                    :step="$parameter->step"
                                                />
                                            @endif

                                            @if($parameter->type == 'float')
                                                <x-input.number
                                                    :label="$parameter->name"
                                                    :group="'form_parameter_float'"
                                                    :name="$parameter->id"
                                                    :value="$parameter->value_float"
                                                    :min="$parameter->min"
                                                    :max="$parameter->max"
                                                    :step="$parameter->step"
                                                />
                                            @endif

                                            @if($parameter->type == 'float with unit')
                                                <x-input.number
                                                    :label="$parameter->name . ' ('. $parameter->unit.')'"
                                                    :group="'form_parameter_float'"
                                                    :name="$parameter->id"
                                                    :value="$parameter->value_float"
                                                    :min="'0'"
                                                    :max="'100'"
                                                    :step="'0.1'"
                                                />
                                            @endif

                                            @if($parameter->type == 'text')
                                                <x-input.text
                                                    :label="$parameter->name"
                                                    :group="'form_parameter_string'"
                                                    :name="$parameter->id"
                                                    :value="$parameter->value_string"
                                                />
                                            @endif

                                            @if($parameter->type == 'text with unit')
                                                <x-input.text
                                                    :label="$parameter->name . ' ('. $parameter->unit.')'"
                                                    :group="'form_parameter_string'"
                                                    :name="$parameter->id"
                                                    :value="$parameter->value_string"
                                                />
                                            @endif

                                            @if($parameter->type == 'checkbox')
                                                <x-input.checkbox
                                                    :label="$parameter->name"
                                                    :group="'form_parameter_integer'"
                                                    :name="$parameter->id"
                                                    :value="$parameter->value_integer"
                                                />
                                            @endif

                                            @if($parameter->type == 'part')
                                                <div class="form-group">
                                                    <label for="form_parameter_select_{{$parameter->id}}">
                                                        {{$parameter->name}}
                                                    </label>
                                                    <select
                                                        id="form_parameter_select_{{$parameter->id}}"
                                                        name="form_parameter_select[{{$parameter->id}}]"
                                                        class="form-control selectpicker"
                                                        data-live-search="true"
                                                    >
                                                        @foreach($parts as $id => $name)
                                                            <option
                                                                value="{{$id}}"{{$id == $parameter->value_integer ? 'selected': ''}}>
                                                                {{$name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        @include('layouts.edit.buttons')
    </form>
@endsection
