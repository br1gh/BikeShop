@extends('layouts.app')

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
                            <div class="col-md-12 pr-md-1">
                                <x-input.checkbox
                                        :label="'For bikes'"
                                        :name="'for_bikes'"
                                        :value="$obj->for_bikes"
                                />
                                <x-input.checkbox
                                        :label="'For parts'"
                                        :name="'for_parts'"
                                        :value="$obj->for_parts"
                                />
                                <x-input.checkbox
                                        :label="'For accessories'"
                                        :name="'for_accessories'"
                                        :value="$obj->for_accessories"
                                />
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <x-input.text
                                        :label="'Name'"
                                        :name="'name'"
                                        :value="$obj->name"
                                />
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <label for="form_type">Type</label>
                                <select id="form_type" name="form[type]" class="form-control selectpicker">
                                    @foreach($types as $k => $v)
                                        <option value="{{$k}}" {{$k == $obj->type ? 'selected' : ''}}>{{$v}}</option>
                                    @endforeach
                                </select>
                                @error("type")
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <x-input.text
                                        :label="'Unit'"
                                        :name="'unit'"
                                        :value="$obj->unit"
                                />
                            </div>
                        </div>
                        <div class="row number-limits">
                            <div class="col-md-4 pr-md-1">
                                <x-input.number
                                        :label="'Min'"
                                        :name="'min'"
                                        :value="$obj->min"
                                        :min="-9999999999"
                                        :max="9999999999"
                                        :step="'any'"
                                />
                            </div>
                            <div class="col-md-4 px-md-1">
                                <x-input.number
                                        :label="'Max'"
                                        :name="'max'"
                                        :value="$obj->max"
                                        :min="-9999999999"
                                        :max="9999999999"
                                        :step="'any'"
                                />
                            </div>
                            <div class="col-md-4 pl-md-1">
                                <x-input.number
                                        :label="'Step'"
                                        :name="'step'"
                                        :value="$obj->step"
                                        :min="-9999999999"
                                        :max="9999999999"
                                        :step="'any'"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.edit.buttons')
    </form>
@endsection

@push('js')
    <script>
        let type = $('#form_type')
        let inputs = document.querySelectorAll('.number-limits input');
        type.on("change", function () {
            disableUnitInput()
            disableNumberLimitInputs()
        })

        $(document).ready(function () {
            disableUnitInput()
        })

        function disableUnitInput() {
            $("#form_unit").prop('disabled', !type.val().endsWith("with unit"));
        }

        function disableNumberLimitInputs() {
            let isFloatOrInteger = type.val().startsWith('float') || type.val().startsWith('integer');
            inputs.forEach(input => {
                input.disabled = !isFloatOrInteger;
            });
        }

        inputs.forEach(input => {
            input.addEventListener("input", function () {
                let value = input.value;
                if (value.indexOf(".") !== -1) {
                    let decimalPlaces = value.split(".")[1];
                    if (decimalPlaces && decimalPlaces.length > 5) {
                        input.value = parseFloat(value).toFixed(5);
                    }
                }
            });
        });
    </script>
@endpush
