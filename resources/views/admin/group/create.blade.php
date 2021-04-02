@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => 'Admin\GroupController@store', 'method' => 'POST', 'id' => 'form-group', 'class' => 'row', 'ng-controller' => 'GroupController']) !!}
    @include('admin.group.form')
{!! Form::close() !!}
@endsection
