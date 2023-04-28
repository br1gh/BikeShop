@extends('layouts.app2')

@section('content')
    <form method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Bike</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <x-input.text :label="'Name'" :name="'name'" :value="$obj->name"/>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <x-input.number :label="'Price'" :name="'price'" :min="'0'" :max="'4'" :step="'0.01'"
                                                :value="$obj->price"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-fill btn-primary">Save</button>
    </form>
@endsection
