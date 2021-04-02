@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => 'Admin\HoidongController@store', 'method' => 'POST', 'id' => 'form-post', 'class' => 'row']) !!}
	{{ method_field('POST') }}
    @include('admin.hoidong.form')
{!! Form::close() !!}
@endsection
