@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => ['Admin\SettingController@update', $setting->name], 'method' => 'PUT', 'id' => 'form-setting', 'class' => 'row']) !!}

{!! Form::close() !!}
@endsection
