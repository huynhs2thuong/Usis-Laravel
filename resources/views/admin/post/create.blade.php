@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => 'Admin\PostController@store', 'method' => 'POST', 'id' => 'form-post', 'class' => 'row']) !!}
	{{ method_field('POST') }}
    @include('admin.post.form')
{!! Form::close() !!}
@endsection
