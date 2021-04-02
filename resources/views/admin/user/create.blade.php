@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => 'Admin\UserController@store', 'method' => 'POST', 'id' => 'form-user', 'class' => 'row']) !!}
	{{ method_field('POST') }}
    @include('admin.user.form')
{!! Form::close() !!}
@endsection
