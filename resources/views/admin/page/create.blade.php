@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => 'Admin\PageController@store', 'method' => 'POST', 'id' => 'form-page', 'class' => 'row']) !!}
    @include('admin.page.form')
{!! Form::close() !!}
@endsection
