@extends('adminlte::page')

@section('content')
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

@section('css')
    {{ Html::style('modules/admin/vendor/datatables/media/css/dataTables.bootstrap.min.css') }}
    {{ Html::style('modules/admin/vendor/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css') }}
    {{ Html::style('modules/admin/vendor/toastr/toastr.min.css') }}
    @yield('extra-css')
@stop

@section('js')
    {{ Html::script('modules/admin/vendor/datatables/media/js/jquery.dataTables.min.js') }}
    {{ Html::script('modules/admin/vendor/datatables/media/js/dataTables.bootstrap.min.js') }}
    {{ Html::script('modules/admin/vendor/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js') }}
    {{ Html::script('modules/admin/vendor/toastr/toastr.min.js') }}
    {{ Html::script('modules/admin/js/admin.js') }}

    <script>
        $(function () {
            window.table = $('#mainTable').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autowidth: true,
                pageLength: 25,
                pagingType: 'full_numbers',
                search: {
                    caseInsensitive: true
                },
                ajax: '{{ request()->url() }}',
                columns: [
                    @foreach($fields as $field => $props)
                    { data: '{{ $field }}', searchable: {{ (boolval($props['searchable'])) ? 'true' : 'false' }}, orderable: {{ (boolval($props['orderable'])) ? 'true' : 'false' }}, className: '{{ $props['className'] }}'},
                    @endforeach
                ],
                order: [],
                language: {
                    processing: '<i class="fa fa-cog fa-spin fa-fw loading fa-2x"></i>',
                    search: '{{ trans('admin::admin.search') }}: ',
                    paginate: {
                        first: '<i class="fa fa-fast-backward"></i>',
                        last: '<i class="fa fa-fast-forward"></i>',
                        next: '<i class="fa fa-chevron-right"></i>',
                        previous: '<i class="fa fa-chevron-left"></i>'
                    },
                    emptyTable: '{{ trans('admin::admin.empty') }}',
                    zeroRecords: '{{ trans('admin::admin.empty') }}',
                    lengthMenu: '{{ trans('admin::admin.show') }} &nbsp;&nbsp; _MENU_ &nbsp;&nbsp; {{ trans('admin::admin.records') }}',
                    info: '{{ trans('admin::admin.showing') }} _START_ {{ trans('admin::admin.to') }} _END_ {{ trans('admin::admin.of') }} _TOTAL_ {{ trans('admin::admin.records') }}'
                }
            });

            $('#modalCreate').on('click',  '.btn[type="submit"]', function(e){
                e.preventDefault();

                // remove previous errors
                $('.form-group.has-error').removeClass('has-error').find('.help-block').remove();

                var $form = $('#modalCreate form');
                $.ajax($form.attr('action'), {
                    dataType: 'json',
                    method: $form.attr('method'),
                    data: $form.serialize(),
                    success: function(data) {
                        $('.modal').modal('hide');
                        $('#modalCreate form')[0].reset()
                        $('#mainTable').dataTable().api().ajax.reload();

                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    },
                    error: function (request) {
                        if(request.status === 422) {
                            for(errorField in request.responseJSON) {
                                if(request.responseJSON.hasOwnProperty(errorField)) {
                                    var $field = $('#'+errorField);
                                    var $formGroup = $field.closest('.form-group')

                                    $formGroup.addClass('has-error');
                                    $formGroup.append('<p class="help-block">' + request.responseJSON[errorField][0] + '</p>')
                                }
                            }
                        }
                    }
                });
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

    @yield('extra-js')

@stop