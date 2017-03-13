<div class="form-group @if ($errors->has($name)) has-error @endif">
    {!! Form::label($name, $label) !!}
    <select name="{{ $name }}" id="{{ $name }}" class="form-control select2" multiple>
        @foreach($options as $key => $value)
            <option value="{{ $key }}" @if(in_array($key, $selected))selected="selected"@endif>{{ $value }}</option>
        @endforeach
    </select>
    @if ($errors->has($name)) <p class="help-block">{{ $errors->first($name) }}</p> @endif
</div>