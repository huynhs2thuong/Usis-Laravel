@extends('layouts.app')

@section('content')
	<h1 class="checkout-title text-uppercase">@lang('user.button.checkout')</h1>
	<form id="form-checkout" action="{{ action('CartController@checkout') }}" method="POST" ng-controller="CheckoutController as checkout">
		{{ csrf_field() }}
		<input type="hidden" name="gartId" value="{{ $gartId }}">
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
			<div class="row cart-header text-uppercase">
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
					<div class="col col-sm-6 item-name text-uppercase">
						{{ getTranslate(product.title) }}
						<input type="hidden" name="dishes[{{ $index }}][{{ product.id }}]" value="{{ product.qty }}">
					</div>
					<div class="col col-sm-3 add-item text-center">
						<input type="text" value="{{ product.qty }}" class="show-number-order" readonly="readonly" />
					</div>
					<div class="col col-sm-3 item-price text-right"><b>{{ product.price.toMoney() }}</b></div>
					<div class="col-xs-12 text-uppercase" ng-show="product.options.length">
						<div class="row" ng-repeat="option in product.options">
							<div class="col-sm-4 col-sm-offset-1">
								{{ getTranslate(option.title) }}
								<input type="hidden" name="dishes[{{ $parent.$index }}][{{ option.id }}]" value="{{ product.qty }}">
							</div>
						</div>
					</div>
				@endverbatim
			</div>
		</div>
		<!-- <div class="optional-drink">
			<div class="optdrink-wrapper center-block">
				<h3 class="dozen-25 text-uppercase">@lang('cart.extra')</h3>
				<ks-swiper-container swiper="swiper" slides-per-view="2">
					<ks-swiper-slide ng-repeat="extra in extras">
			        	<img ng-src="@{{ extra.image }}" alt="@{{ extra.title }}">@{{ extra.title }}
			        	<div class="checkbox">
							<input type="checkbox" id="extra-@{{ extra.id }}" ng-click="changeExtra($event, extra)" />
							<label for="extra-@{{ extra.id }}"></label>
						</div>
					</ks-swiper-slide>
				</ks-swiper-container>
			</div>
		</div> -->
		<div class="checkout-total center-block">
			<div class="row cart-item sum">
				<div class="col col-sm-6 dozen-25 text-uppercase">@lang('cart.total')</div>
				<div class="col col-sm-3 text-center add-item"><span class="show-number-order">@{{ total().count }}</span></div>
				<div class="col col-sm-3 text-right item-price"><b>@{{ total().money }}</b></div>
			</div>
			<p class="checkout-notice">*@lang('cart.notice')</p>
			<div class="text-right">
				<a class="btn" href="{{ action('GroupController@index', ['gartId' => $gartId]) }}">@lang('user.button.continue')</a>
				<button type="submit" class="btn">@lang('user.button.checkout')</button>
			</div>
		</div>
	</form>

@endsection

@push('scripts')
	<script type="text/javascript">
		app.controller('CheckoutController', ['$scope', '$http', function($scope, $http) {
			$scope.swiper = {};
			$scope.cities = $scope.districts = $scope.products = [];

			$http.get('/api/area').success(function(response) {
                $scope.cities = response.cities;
                $scope.districts = response.districts;
            });

			$http.get('{{ action('GartController@data', $gartId) }}').success(function(response) {
				$scope.products = response;
			});

			$scope.total = function() {
				var count = total = 0;
				angular.forEach($scope.products, function(value, key) {
					count += value.qty;
					total += value.price * value.qty;
				});
				return {
					count: count,
					money: total.toMoney()
				};
			};

			{{--$scope.extras = [
				@foreach ($extras as $extra) { id : {{ $extra->id }}, title: '{{ $extra->title }}', qty: 1, price: {{ $extra->price }}, image: '{{ $extra->thumbnail }}' , extra: true }, @endforeach
			];
			$scope.changeExtra = function($event, extra) {
				if ($event.target.checked) {
					$scope.products.push(extra);
					$scope.swiper.slideNext(true, 0);
				} else {
					var index = $scope.products.indexOf(extra);
					if (index !== -1) $scope.products.splice(index, 1);
				}
			};--}}
		}]);
	</script>
@endpush
