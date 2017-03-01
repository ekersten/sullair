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
                {!! Form::open(['route' => 'users.store']) !!}
                <div class="box-header"></div>
                <div class="box-body">

                    {{ Form::token() }}
                    <div class="form-group">
                        {!! Form::label('first_name', 'First Name') !!}
                        {!! Form::text('first_name', null, array_merge(['class' => 'form-control'])) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('last_name', 'Last Name') !!}
                        {!! Form::text('last_name', null, array_merge(['class' => 'form-control'])) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('email', 'Email') !!}
                        {!! Form::email('email', null, array_merge(['class' => 'form-control'])) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('password', 'Password') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>

                </div>
                <div class="box-footer">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

@stop