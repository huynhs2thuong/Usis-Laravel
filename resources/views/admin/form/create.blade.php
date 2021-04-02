@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => 'Admin\FormController@store', 'method' => 'POST', 'id' => 'form-post', 'class' => 'row']) !!}
	{{ method_field('POST') }}
    @include('admin.form.form')
{!! Form::close() !!}
@endsection
