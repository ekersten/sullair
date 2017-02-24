@extends('adminlte::login')
@section('title', 'Login')

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@stop

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js">
    @if(Session::has('flashSuccess'))
        <script>
            $(document).ready(function() {
                toastr["success"]('{{ Session::get('flashSuccess') }}');
            });
        </script>
    @endif
@stop

