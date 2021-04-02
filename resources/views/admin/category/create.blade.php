@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => 'Admin\CategoryController@store', 'method' => 'POST', 'id' => 'form-category', 'class' => 'row']) !!}
{{ Form::hidden('type', $type) }}

@include('admin.category.form')
{!! Form::close() !!}
@endsection
