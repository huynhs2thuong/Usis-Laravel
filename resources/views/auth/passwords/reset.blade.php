@extends('layouts.app')

@section('content')
<div class="container" style="min-height: 500px;">
    <!-- <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('admin.title.reset password')</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">@lang('admin.field.email')</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">@lang('admin.field.password')</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">@lang('admin.field.password_confirmation')</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-color">
                                    @lang('admin.title.reset password')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->
</div>
<div class="modal fade" id="modal-reset-password">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body text-center">
                <form action="{{ action('Auth\ResetPasswordController@reset') }}" method="POST" class="form-reset" role="form">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-top">
                        <img class="" src="/images/logo.png">
                        <h4 class="text-uppercase text-white">@lang('admin.title.reset password')</h4>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="@lang('admin.field.email')" required="">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" value="" placeholder="@lang('admin.field.password')" required="">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password_confirmation" value="" placeholder="@lang('admin.field.password_confirmation')" required="">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group"><button type="submit" class="btn btn-color text-uppercase">@lang('admin.title.reset password')</button></div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#modal-reset-password').modal({
                backdrop: 'static',
                keyboard: false
            }).modal('show');
        });
    </script>
@endpush
