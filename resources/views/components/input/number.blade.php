@props([
    'group' => 'form',
    'name' => null,
    'label' => null,
    'value' => null,
    'min' => null,
    'max' => null,
    'step' => null,
])

<div class="form-group">
    <label for="{{$group}}_{{$name}}">{{$label}}</label>
    <input
        id="{{$group}}_{{$name}}"
        name="{{$group}}[{{$name}}]"
        type="number"
        class="form-control @error($name) border-warning @enderror"
        value="{{$value}}"
        min="{{$min}}"
        max="{{$max}}"
        step="{{$step}}"
    >
</div>
@error($name)
<div class="alert alert-danger">{{ $message }}</div>
@enderror
