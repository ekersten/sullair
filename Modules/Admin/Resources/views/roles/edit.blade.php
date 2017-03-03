@extends('adminlte::page')

@section('title', trans('admin::admin.create') . ' ' . trans('admin::roles.role'))

@section('content_header')
    <div class="row">
        <div class="col-xs-12">
            <h1>{{ trans('admin::admin.create') . ' ' . trans('admin::roles.role') }}</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                @if( isset($role) )
                    {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'put']) !!}
                @else
                    {!! Form::open(['route' => 'roles.store']) !!}
                @endif

                <div class="box-header"></div>
                <div class="box-body">

                    {{ Form::token() }}
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('name', trans('admin::roles.name')) !!}
                        {!! Form::text('name', null, array_merge(['class' => 'form-control'])) !!}
                        @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
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