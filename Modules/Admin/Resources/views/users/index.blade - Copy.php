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
                        @foreach($users as $user)
                            <tr role="row">
                                <td class="text-center">{{ $user->id }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->last_login)
                                    {{ \Carbon\Carbon::setLocale(config('app.locale')) }}
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->last_login)->diffForHumans() }}
                                    @else
                                    {{ trans('admin::users.never') }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-warning" href="{{ route('users.edit', $user->id) }}"><i class="fa fa-pencil"></i></a>
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