@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<form action="{{ route('login_admin') }}" method="POST" role="form" class="login-form">
    {{ csrf_field() }}
    <div class="row">
        <div class="input-field col s12 center">
            <img src="/images/logo.png" alt="" class="circle responsive-img valign profile-image-login">
            <p class="center login-form-text">Admin Area</p>
        </div>
    </div>
    <div class="row margin">
        <div class="input-field col s12">
            <i class="mdi-social-person-outline prefix"></i>
            <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus>
            <label for="email" class="center-align">@lang('admin.field.email')</label>
        </div>
    </div>
    <div class="row margin">
        <div class="input-field col s12">
            <i class="mdi-action-lock-outline prefix"></i>
            <input id="password" type="password" name="password">
            <label for="password">@lang('admin.field.password')</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m12 l12  login-text">
            <input type="checkbox" id="remember-me" name="remember" />
            <label for="remember-me">Remember me</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <button type="submit" class="btn waves-effect waves-light col s12">@lang('admin.button.login')</button>
        </div>
    </div>
    <!-- <div class="row">
        <div class="input-field col s6 m6 l6">
            <p class="margin medium-small"><a href="page-register.html">Register Now!</a></p>
        </div>
        <div class="input-field col s6 m6 l6">
            <p class="margin right-align medium-small"><a href="#">Forgot password ?</a></p>
        </div>
    </div> -->
</form>
@endsection
