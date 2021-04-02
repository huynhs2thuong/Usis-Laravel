@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => 'Admin\ProjectController@store', 'method' => 'POST', 'id' => 'form-project', 'class' => 'row']) !!}
	{{ method_field('POST') }}
    @include('admin.project.form')
{!! Form::close() !!}
@endsection
