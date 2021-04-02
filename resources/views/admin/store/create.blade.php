@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => 'Admin\StoreController@store', 'method' => 'POST', 'id' => 'form-store', 'class' => 'row', 'onkeypress' => 'return event.keyCode != 13;']) !!}
    @include('admin.store.form')
{!! Form::close() !!}
@endsection
