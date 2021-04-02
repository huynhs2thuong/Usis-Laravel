@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => 'Admin\MenuController@store', 'method' => 'POST', 'id' => 'form-menu', 'class' => 'row']) !!}

@include('admin.menu.form')
{!! Form::close() !!}
@endsection
