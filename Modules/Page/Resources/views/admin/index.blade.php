@extends('adminlte::page')

@section('title', trans('admin::users.users'))

@section('content_header')
    <div class="row">
        <div class="col-xs-12">
            <h1>{{ trans('admin::users.users') }}</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header"></div>
                <div class="box-body">
                    <table id="mainTable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>{{ trans('admin::users.first_name') }}</th>
                            <th>{{ trans('admin::users.last_name') }}</th>
                            <th>{{ trans('admin::users.email') }}</th>
                            <th>{{ trans('admin::users.last_login') }}</th>
                            <th class="text-center">{{ trans('admin::users.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    {{ Html::style('//cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.css') }}
@stop

@section('js')
    {{ Html::script('//cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js') }}
    <script>
        $(function () {
            $('#mainTable').DataTable({
                language: {
                    url: '{{ trans('admin::admin.datatables_lang') }}'
                }
            });
        });
    </script>
@stop