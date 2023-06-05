@props([
    'group' => 'form',
    'name' => null,
    'label' => null,
    'value' => null,
])

<div class="form-group">
    <label for="{{$group}}_{{$name}}">{{$label}}</label>
    <input
        id="{{$group}}_{{$name}}"
        name="{{$group}}[{{$name}}]"
        type="text"
        class="form-control @error($name) is-invalid @enderror"
        value="{{$value}}"
    >
</div>
@error($name)
<div class="invalid-feedback d-block" role="alert">{{ $message }}</div>
@enderror
