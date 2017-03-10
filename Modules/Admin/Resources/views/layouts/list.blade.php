@extends('adminlte::page')

@section('css')
    {{ Html::style('modules/admin/vendor/datatables/media/css/jquery.dataTables.min.css') }}
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
            var table = $('#mainTable').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autowidth: true,
                pageLength: 25,
                pagingType: 'full_numbers',
                search: {
                    caseInsensitive: true
                },
                order: [[2, "asc"]],
                ajax: '{{ request()->url() }}',
                columns: [
                    @foreach($fields as $field => $props)
                    { data: '{{ $field }}', searchable: '{{ (boolval($props['searchable'])) ? 'true' : 'false' }}', orderable: '{{ (boolval($props['orderable'])) ? 'true' : 'false' }}', className: '{{ $props['className'] }}'},
                    @endforeach
                ],
                language: {
                    processing: '<i class="fa fa-cog fa-spin fa-fw loading fa-2x"></i>'
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

    @yield('extra-js')

@stop