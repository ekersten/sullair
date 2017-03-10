@extends('adminlte::page')

@section('title', trans('admin::admin.edit') . ' ' . trans('admin::roles.role'))

@section('content_header')
    <div class="row">
        <div class="col-xs-12">
            <h1>{{ trans('admin::admin.edit') . ' ' . trans('admin::roles.role') }}</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                {!! Form::model($role, ['route' => ['admin.roles.update', $role->id], 'method' => 'put']) !!}
                <div class="box-header"></div>
                <div class="box-body">

                    @foreach($update_fields as $field => $props)
                        {!! call_user_func(array('Form', $props['type']), $field, $props['label']) !!}
                    @endforeach

                    <div class="row">
                        <div class="col-sm-12">
                            <h3>Permissions</h3>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($modules as $module)
                            @if(isset($permissions[$module->getLowerName()]))
                            <div class="col-sm-3">
                                <h4>{{ $module->getName() }}</h4>
                                <ul class="list-group">
                                    @foreach($permissions[$module->getLowerName()] as $permission)
                                    <li class="list-group-item">
                                        <label class="checkbox-inline"><input type="checkbox" value="true" @if($role->hasAccess($permission))checked="checked"@endif name="{{ $permission }}">{{ str_replace('.', ' ', ucwords(str_replace($module->getLowerName().'.', '', $permission)))}}</label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        @endforeach
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