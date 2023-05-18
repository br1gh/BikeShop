@props([
    'group' => 'form',
    'name' => null,
    'label' => null,
    'value' => null,
])

<div class="form-check">
    <label class="form-check-label">
        <input type="hidden" name="{{$group}}[{{$name}}]" value="0">
        <input
            id="{{$group}}_{{$name}}"
            name="{{$group}}[{{$name}}]"
            class="form-check-input"
            type="checkbox"
            value="{{$value ? 1 : 0}}"
            {{$value ? 'checked' : ''}}
        >
        {{$label}}
        <span class="form-check-sign">
            <span class="check">
            </span>
        </span>
    </label>
</div>
