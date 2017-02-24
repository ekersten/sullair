@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Dashboard placeholder</p>
    <a href="{{ route('admin.login') }}">login</a>
    <a href="{{ route('admin.email') }}">email</a>
    <a href="{{ route('admin.reset') }}">reset</a>
@stop