@props([
    'name' => null,
    'label' => null,
    'value' => null,
])

<div class="form-group">
    <label>{{$label}}</label>
    <input
        name="form[{{$name}}]"
        type="text"
        class="form-control @error($name) border-warning @enderror"
        value="{{$value}}"
    >
</div>
@error($name)
<div class="alert alert-danger">{{ $message }}</div>
@enderror
