@extends('layouts.app')

@section('content')
	<h1 class="checkout-title text-uppercase">@lang('user.button.checkout')</h1>
	<form id="form-checkout" action="{{ action('CartController@checkout') }}" method="POST" ng-controller="CheckoutController as checkout">
		{{ csrf_field() }}
		<div class="checkout-information center-block">
			<h2>@lang('cart.your info')</h2>
			<div class="form-information">
				<input type="text" name="name" value="{{ $currentUser ? $currentUser->name : session('customerName', '') }}" placeholder="@lang('cart.form.name')" />
				<div class="address-group">
					<div class="col">
						<input type="text" name="phone" value="{{ session('customerPhone', '') }}" placeholder="@lang('cart.form.phone')" />
					</div>
					<div class="col">
						<select name="city" ng-model="city" ng-options="city.id as getTranslate(city.title) for city in cities">
							<option value="" disabled="">@lang('cart.form.city')</option>
						</select>
					</div>
					<div class="col">
						<select name="district" ng-model="district" ng-options="district.id as getTranslate(district.title) for district in districts | filter:{city_id: city}:true">
							<option value="" disabled="">@lang('cart.form.district')</option>
						</select>
					</div>
				</div>
				<input type="text" name="address" value="{{ session('customerAddress', '') }}" placeholder="@lang('cart.form.address')" />
			</div>
			<h3 class="dozen-25 text-uppercase">@lang('cart.your cart')</h3>
			<div class="row cart-header text-uppercase hidden-xs">
				<div class="col-sm-6">
					<h3 class="dozen-25">@lang('cart.dish name')</h3>
				</div>
				<div class="col-sm-3 text-center">
					<h3 class="dozen-25">@lang('cart.qty')</h3>
				</div>
				<div class="col-sm-3 text-right">
					<h3 class="dozen-25">@lang('cart.price')</h3>
				</div>
			</div>
			<div class="row cart-item" ng-repeat="product in products">
				@verbatim
					<div class="col col-xs-7 col-sm-6 item-name text-uppercase">
						{{ getTranslate(product.title) }}
						<input type="hidden" name="dishes[{{ $index }}][{{ product.id }}]" value="{{ product.qty }}">
					</div>
					<div class="col col-xs-5 col-sm-3 add-item text-center">
						<span class="change-qty delete" ng-click="delete($index, product)">×</span>
						<span class="change-qty increase" ng-click="increase(product)">+</span>
						<input type="text" value="{{ product.qty }}" class="show-number-order" readonly="readonly" />
						<span class="change-qty decrease" ng-click="decrease(product)">-</span>
					</div>
					<div class="col col-sm-3 item-price text-right"><b>{{ product.price.toMoney() }}</b></div>
					<div class="col-xs-12 text-uppercase" ng-show="product.options.length">
						<div class="row" ng-repeat="option in product.options">
							<div class="col-xs-11 col-xs-offset-1">
								{{ getTranslate(option.title) }}
								<input type="hidden" name="dishes[{{ $parent.$index }}][{{ option.id }}]" value="{{ product.qty }}">
							</div>
						</div>
					</div>
				@endverbatim
			</div>
		</div>
		<div class="optional-drink">
			<div class="optdrink-wrapper center-block">
				<h3 class="dozen-25 text-uppercase">@lang('cart.extra')</h3>
				<ks-swiper-container class="hidden-xs" swiper="swiper" slides-per-view="2">
					<ks-swiper-slide ng-repeat="extra in extras">
			        	<img ng-src="@{{ extra.image }}" alt="">@{{ getTranslate(extra.title) }}
			        	<div class="checkbox">
							<input type="checkbox" id="extra-@{{ extra.id }}" ng-click="changeExtra($event, extra)" />
							<label class="white" for="extra-@{{ extra.id }}"></label>
						</div>
					</ks-swiper-slide>
				</ks-swiper-container>
				<div class="extra-item text-right visible-xs" ng-repeat="extra in extras">
					<img ng-src="@{{ extra.image }}" width="75" alt="">@{{ getTranslate(extra.title) }}
					<div class="checkbox">
						<input type="checkbox" id="extra-xs-@{{ extra.id }}" ng-click="changeExtra($event, extra)" />
						<label class="white" for="extra-xs-@{{ extra.id }}"></label>
					</div>
				</div>
			</div>
		</div>
		<div class="checkout-total center-block">
			<div class="row cart-item sum">
				<div class="col col-xs-5 col-sm-6 dozen-25 text-uppercase">@lang('cart.total')</div>
				<div class="col col-sm-3 hidden-xs text-center add-item"><input value="@{{ total().count }}" class="show-number-order" readonly="readonly" type="text"></div>
				<div class="col col-xs-7 col-sm-3 text-right item-price"><b>@{{ total().money }}</b></div>
			</div>
			<p class="checkout-notice">*@lang('cart.notice')</p>
			<div class="text-right">
				<a class="btn" href="{{ action('GroupController@index') }}">@lang('user.button.continue')</a>
				<button type="submit" class="btn btn-submit">@lang('user.button.checkout')</button>
			</div>
		</div>
	</form>

@endsection

@push('scripts')
	<script type="text/javascript">
		var cookieCity = {{ $cookie_city === 0 ? 'null' : $cookie_city }},
    		cookieDistrict = {{ $cookie_district === 0 ? 'null' : $cookie_district }},
    		extras = [
				@foreach ($extras as $extra) { id : {{ $extra->id }}, title: '{{ $extra->title }}', qty: 1, price: {{ $extra->price }}, image: '{{ $extra->getImage('full') }}' , extra: true }, @endforeach
			];
	</script>
	<script type="text/javascript" src="/js/checkout/normal.js"></script>
@endpush
