<div class="modal fade" id="modal-login" ng-controller="CustomerLoginController">
    <div class="modal-dialog">
        @if (!$currentUser)
            <div class="modal-content" ng-show="isTab(1)">
                <div class="modal-body text-center">
                    <form action="{{ action('Auth\LoginController@login') }}" method="POST" role="form" data-type="login" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="form-top">
                            <img class="" src="/images/logo.png" width="120">
                            <h4 class="text-uppercase text-white">@lang('user.title.login')</h4>
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" value="" placeholder="@lang('admin.field.email')" required="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" name="password" value="" placeholder="@lang('admin.field.password')" required="">
                            </div>
                        </div>
                        <p><a href="" ng-click="setTab(3)">@lang('user.title.forgot password')</a></p>
                        <div class="form-group"><button type="submit" class="btn btn-color text-uppercase">@lang('admin.button.login')</button></div>
                        <ul class="form-group list-inline text-white social-login">
                            <li>
                                <a class="btn-icon active" href="{{ action('Auth\LoginController@redirectToProvider', empty($group) ? 'facebook' : ['facebook', 'thuc-don' => $group->slug]) }}" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            </li>
                            <li>
                                <a class="btn-icon active" href="{{ action('Auth\LoginController@redirectToProvider', empty($group) ? 'google' : ['google', 'thuc-don' => $group->slug]) }}" title="Google"><i class="fa fa-google" aria-hidden="true"></i></a>
                            </li>
                        </ul>
                        <div class="form-group switch-text">@lang('user.message.goToSignUp')</div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
            <div class="modal-content" ng-show="isTab(2)">
                <div class="modal-body text-center">
                    <form action="{{ action('Auth\RegisterController@register') }}" method="POST" role="form" data-type="register" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="form-top">
                            <img class="" src="/images/logo.png" width="120">
                            <h4 class="text-uppercase text-white">@lang('user.title.register')</h4>
                            <div class="form-group">
                                <input class="form-control" type="text" name="name" value="" placeholder="@lang('admin.field.name')" required="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" value="" placeholder="@lang('admin.field.email')" required="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" name="password" value="" placeholder="@lang('admin.field.password')" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-color text-uppercase">@lang('admin.button.register')</button>
                        </div>
                        <div class="form-group switch-text">@lang('user.message.backToLogin')</div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
            <div class="modal-content" ng-show="isTab(3)">
                <div class="modal-body text-center">
                    <form action="{{ action('Auth\ForgotPasswordController@sendResetLinkEmail') }}" method="POST" role="form" data-type="forgot" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="form-top">
                            <img class="" src="/images/logo.png" width="120">
                            <h4 class="text-uppercase text-white">@lang('user.title.forgot password')</h4>
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" value="" placeholder="@lang('admin.field.email')" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-color text-uppercase">@lang('admin.button.send email')</button>
                        </div>
                        <div class="form-group switch-text">@lang('user.message.backToLogin')</div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        @else
            <div class="modal-content" ng-show="isTab(1)">
                <div class="modal-body text-center">
                    <form action="{{ action('Auth\CustomerController@update', $currentUser->id) }}" method="POST" role="form" data-type="change-pass" autocomplete="off">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <div class="form-top">
                            <img class="" src="/images/logo.png" width="120">
                            <h4 class="text-uppercase text-white">@lang('user.button.change pass')</h4>
                            <div class="form-group">
                                <input id="input-password" type="password" class="form-control" name="password" value="" placeholder="@lang('admin.field.new password')" required="">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password_confirmation" value="" placeholder="@lang('admin.field.password_confirmation')" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-color">@lang('user.button.change pass')</button>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        @endif
        <div class="modal-content" ng-show="isTab(4)">
            <div class="modal-body text-center">
                <form action="/api/area" method="POST" role="form" data-type="area" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="form-top">
                        <img class="" src="/images/logo.png" width="120">
                        <h4 class="text-uppercase text-white">@lang('user.title.area')</h4>
                        <div class="form-group">
                            <select class="form-control" name="city" ng-model="city" ng-options="city.id as getTranslate(city.title) for city in cities">
                                <option value="" disabled="">@lang('cart.form.city')</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="district" ng-model="district" ng-options="district.id as getTranslate(district.title) for district in districts | filter:{city_id: city}:true">
                                <option value="" disabled="">@lang('cart.form.district')</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-group">
                        <input class="form-control text-center" value="@lang('user.message.area.min price')" aria-describedby="basic-addon2">
                        <span class="input-group-addon">@{{ getMinPrice() }}</span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-color text-uppercase">@lang('admin.button.confirm')</button>
                    </div>
                    <div class="form-group switch-text">@lang('user.message.area.notice')</div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>

        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">×</button>
    </div>
</div>
