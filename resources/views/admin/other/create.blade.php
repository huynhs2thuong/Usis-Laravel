@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => 'Admin\OmemberController@store', 'method' => 'POST', 'id' => 'form-post', 'class' => 'row']) !!}
	{{ method_field('POST') }}
    @include('admin.other.form')
{!! Form::close() !!}
@endsection
