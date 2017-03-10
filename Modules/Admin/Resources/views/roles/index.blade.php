@extends('admin::layouts.list')

@section('title', trans('admin::roles.roles'))

@section('content_header')
    <div class="row">
        <div class="col-xs-12">
            <h1>{{ trans('admin::roles.roles') }}</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="row form-group">
        <div class="col-md-12">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreate">{{ trans('admin::admin.create') }} {{ trans('admin::roles.role') }}</button>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <table id="mainTable" class="table table-striped table-bordered table-hover dt-bootstrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            @foreach($fields as $field)
                            <th>{{  $field['label'] }}</th>
                            @endforeach
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['method' => 'POST', 'route' => $store_route, 'role' => 'form'])  !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">{{ trans('admin::admin.close') }}</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        {{ trans('admin::admin.create') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        @foreach($create_fields as $field => $props)
                            {!! call_user_func(array('Form', $props['type']), $field, $props['label']) !!}
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin::admin.close') }}</button>
                    {!! Form::submit(trans('admin::admin.save'),['class'=>'btn btn-primary'])  !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@stop