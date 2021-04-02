@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => 'Admin\ModuleController@store', 'method' => 'POST', 'id' => 'form-category', 'class' => 'row']) !!}
@include('admin.module.form')
{!! Form::close() !!}
@endsection
