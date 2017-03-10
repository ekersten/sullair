<div class="form-group @if ($errors->has($name)) has-error @endif">
    {!! Form::label($name, $label) !!}
    {!! Form::password($name, array_merge(['class' => 'form-control'], $attributes)) !!}
    @if ($errors->has($name)) <p class="help-block">{{ $errors->first($name) }}</p> @endif
</div>