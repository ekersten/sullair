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
    @parent
@stop