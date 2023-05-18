@extends('layouts.app2')

@section('content')
    @if(isset($filters))
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    Filters
                </h4>
            </div>
            <div class="card-body filters">
                <div class="row">
                    @foreach($filters as $type => $typeFilters)
                        @foreach($typeFilters as $name => $options)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="filter_{{$name}}">{{$name}}</label>
                                    @if($type == 'multiselect')
                                        <a href="#" class="pull-right clear-multiselect" style="color: inherit">
                                            Clear
                                        </a>
                                        <select
                                            id="filter_{{$name}}"
                                            class="form-control selectpicker multiselect"
                                            data-type="{{$type}}"
                                            title="All"
                                            multiple
                                        >
                                    @else
                                        <select id="filter_{{$name}}" class="form-control selectpicker" data-type="{{$type}}">
                                        <option value="" selected>All</option>
                                    @endif
                                        @foreach($options as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                {{$title}}
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="column">Sort by</label>
                        <select id="column" class="form-control selectpicker">
                            @foreach($columns as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="order">Order</label>
                        <select id="order" class="form-control selectpicker">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="limit">Limit</label>
                        <select id="limit" class="form-control selectpicker">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="search"></label>
                        <input id="search" class="form-control" type="text" placeholder="Search...">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card table-card">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <ul class="pagination card-body justify-content-center">
                    <li class="page-item">
                        <a href="#" id="first-page" class="first-last-button btn" data-page="1"><<</a>
                    </li>
                    <li class="page-item">
                        <a href="#" id="previous-page" class="btn"><</a>
                    </li>
                    <li class="page-item">
                        <select id="custom-page" class="form-control" data-live-search="true">
                        </select>
                    </li>
                    <li class="page-item">
                        <a href="#" id="next-page" class="btn">></a>
                    </li>
                    <li class="page-item">
                        <a href="#" id="last-page" class="first-last-button btn">>></a>
                    </li>
                </ul>
            </div>
            <div class="col-4">
                <ul class="pagination card-body pull-right">
                    <li class="page-item">
                        <a href="{{route($tableName.'.edit')}}" class="btn btn-primary">New</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body table-body">
        </div>
    </div>
@endsection
