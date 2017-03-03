@extends('adminlte::page')

@section('title', 'Create User')

@section('content_header')
    <div class="row">
        <div class="col-xs-12">
            <h1>Create User</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                @if( isset($user) )
                    {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'put']) !!}
                @else
                    {!! Form::open(['route' => 'users.store']) !!}
                @endif

                <div class="box-header"></div>
                <div class="box-body">

                    {{ Form::token() }}
                    <div class="form-group @if ($errors->has('first_name')) has-error @endif">
                        {!! Form::label('first_name', trans('admin::users.first_name')) !!}
                        {!! Form::text('first_name', null, array_merge(['class' => 'form-control'])) !!}
                        @if ($errors->has('first_name')) <p class="help-block">{{ $errors->first('first_name') }}</p> @endif
                    </div>

                    <div class="form-group @if ($errors->has('last_name')) has-error @endif">
                        {!! Form::label('last_name', trans('admin::users.last_name')) !!}
                        {!! Form::text('last_name', null, array_merge(['class' => 'form-control'])) !!}
                        @if ($errors->has('last_name')) <p class="help-block">{{ $errors->first('last_name') }}</p> @endif
                    </div>

                    <div class="form-group @if ($errors->has('email')) has-error @endif">
                        {!! Form::label('email', trans('admin::users.email')) !!}
                        {!! Form::email('email', null, array_merge(['class' => 'form-control'])) !!}
                        @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                    </div>

                    <div class="form-group @if ($errors->has('password')) has-error @endif">
                        {!! Form::label('password', trans('admin::users.password')) !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                        @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                    </div>

                    <div class="form-group @if ($errors->has('password_confirm')) has-error @endif">
                        {!! Form::label('password_confirm', trans('admin::users.password_confirm')) !!}
                        {!! Form::password('password_confirm', ['class' => 'form-control']) !!}
                        @if ($errors->has('password_confirm')) <p class="help-block">{{ $errors->first('password_confirm') }}</p> @endif
                    </div>

                </div>
                <div class="box-footer">
                    {!! Form::submit(trans('admin::admin.save'), ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
@stop