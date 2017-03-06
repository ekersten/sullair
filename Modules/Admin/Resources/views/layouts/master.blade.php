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
        <div class="col-md-12">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreate">{{ trans('admin::admin.create') }} {{ trans('admin::roles.role') }}</button>
        </div>
    </div>
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
                                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                                    <a href="{{ route('admin.roles.destroy', $role->id) }}" class="btn btn-danger" rel="delete" ><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['method' => 'POST', 'route' => 'admin.roles.store', 'role' => 'form'])  !!}
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
                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            {!! Form::label('name', trans('admin::roles.name')) !!}
                            {!! Form::text('name', null, array_merge(['class' => 'form-control'])) !!}
                            @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                        </div>
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

@section('css')
    {{ Html::style('//cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.css') }}
    {{ Html::style('//cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.3/css/bootstrap-dialog.min.css') }}
    {{ Html::style('//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.css') }}
@stop

@section('js')
    {{ Html::script('//cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js') }}
    {{ Html::script('//cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.3/js/bootstrap-dialog.min.js') }}
    {{ Html::script('//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js') }}

    <script>
        $(function () {
            $('#mainTable').DataTable({
                language: {
                    url: '{{ trans('admin::admin.datatables_lang') }}'
                }
            });

            $('#mainTable tbody').on('click','.btn[rel="delete"]',function(e) {
                e.preventDefault();

                var $this = $(this);
                var url = $this.attr('href');

                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: '{{trans('admin::admin.delete')}}',
                    message: '{{trans('admin::admin.confirm_delete')}}',
                    buttons: [{
                        label: '{{trans('admin::admin.confirm')}}',
                        cssClass: 'btn-danger',
                        action: function(dlg){

                            $.ajax({
                                type: 'POST',
                                url: url,
                                data: {
                                    '_method': 'DELETE',
                                    // 'id': id
                                },
                                dataType: 'json',
                                success: function (response) {
                                    dlg.close();

                                    toastr["success"](response);
                                    $this.closest('tr').fadeOut(500,function(){
                                        $(this).remove();
                                    });

                                },
                                error: function (response, ajaxOptions, thrownError) {
                                    dlg.close();
                                    // console.log('error');
                                    toastr["error"](response);
                                    console.log(response);
                                },
                                complete: function () {

                                }
                            });

                        }
                    }, {
                        label: '{{trans('admin::admin.cancel')}}',
                        cssClass: 'btn-default',
                        action: function(dlg){
                            dlg.close();
                        }
                    }]
                });

            });

        });
    </script>

@stop