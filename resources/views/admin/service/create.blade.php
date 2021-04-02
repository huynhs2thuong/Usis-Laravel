@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => 'Admin\ServiceController@store', 'method' => 'POST', 'id' => 'form-post', 'class' => 'row']) !!}
	{{ method_field('POST') }}
    @include('admin.service.form')
{!! Form::close() !!}
@endsection
