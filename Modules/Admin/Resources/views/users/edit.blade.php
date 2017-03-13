@extends('adminlte::page')

@section('title', trans('admin::admin.edit') . ' ' .  trans('admin::users.user'))

@section('content_header')
    <div class="row">
        <div class="col-xs-12">
            <h1>{{ trans('admin::admin.edit') . ' ' .  trans('admin::users.user') }}</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                {!! Form::model($user, ['route' => ['admin.users.update', $user->id], 'method' => 'put']) !!}


                <div class="box-header"></div>
                <div class="box-body">

                    @foreach($edit_fields as $field => $props)
                        {!! call_user_func(array('Form', $props['type']), $field, $props['label']) !!}
                    @endforeach

                    {!! Form::select2('roles[]', trans('admin::roles.roles'), $roles, $user_roles, ['multiple' => true]) !!}


                </div>
                <div class="box-footer">
                    {!! Form::submit(trans('admin::admin.save'), ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
@stop

@section('css')
    {!! Html::style('modules/admin/vendor/select2/dist/css/select2.min.css') !!}
@stop

@section('js')
    {!! Html::script('modules/admin/vendor/select2/dist/js/select2.min.js') !!}

    <script>
        $('.select2').select2();
    </script>
@stop