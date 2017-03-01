@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <div class="row">
        <div class="col-xs-12">
            <h1>Roles</h1>
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
                            <th>Name</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td class="text-center">{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td class="text-center">
                                    <a class="btn btn-warning" href="{{ route('roles.edit', $role->id) }}"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger" href="delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
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