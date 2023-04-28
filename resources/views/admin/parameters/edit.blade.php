@extends('layouts.app2')

@section('content')
    <form method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Parameter</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <x-input.text :label="'Name'" :name="'name'" :value="$obj->name"/>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <label for="type">Type</label>
                                <select name="type" class="form-control selectpicker">
                                    @foreach($types as $k => $v)
                                        <option value="{{$k}}" {{$k == $obj->type ? 'selected' : ''}}>{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <x-input.text :label="'Value'" :name="'value'" :value="$obj->value"/>
                            </div>
                            <div class="col-md-6 pr-md-1">
                                <x-input.text :label="'Unit'" :name="'unit'" :value="$obj->unit"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-fill btn-primary">Save</button>
    </form>
@endsection
