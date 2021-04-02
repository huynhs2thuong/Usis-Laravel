@extends('layouts.app')

@section('meta')
	<title>{{ $group->title }} - Jollibee Vietnam</title>
    <meta name="description" content="{{ $group->description }}">
    <meta property="og:title" content="{{ $group->title }}" />
    <meta property="og:image" content="{{ $group->getImage('full') }}" />
@endsection

@section('content')
	<div class="banner-menu">
		<img src="/images/home/banner.jpg" alt="Thuc don banner" class="img-full-width"/>
		<ul class="sidebar-menu-left shadow-bottom list-inline text-uppercase text-center" data-position="absolute">
			@foreach ($groups as $main_group)
				@if ($main_group->dishes_count === 0) @continue @endif
				<li>
					<a class="{{ $main_group->id === $group->id ? 'active' : '' }}" href="{{ action('GroupController@show', $main_group->slug) }}">
						<i class="fa fa-group-{{ $main_group->slug }} hide-on-fix"></i>
						{{ $main_group->title }}
					</a>
				</li>
			@endforeach
		</ul>
	</div>

	<div class="item-menu-right">
		<form id="form-share-link" action="{{ action('GroupController@getShareLink', $group->slug) }}" method="GET" class="text-right text-white"><button class="btn btn-group-buy text-uppercase" type="submit">@lang('user.button.group buy')</button></form>
		@include('site.order.dishes', ['group' => $group])
		<div id="order-bar" class="row" ng-controller="CartController" data-position="absolute">
			<div class="order-toggle hide-active text-center"><i class="fa fa-cart"></i><span>@{{ total().money }}</span></div>
			@verbatim
			<div class="cart-list scrollbar-macosx">
				<div class="cart-item" ng-repeat="product in products" ng-class="{ first: $index === 0 }">
					<div class="row">
						<div class="pull-left dish-name">{{ getTranslate(product.title) }}</div>
						<div class="pull-right change-qty delete" ng-click="delete($index, product)">×</div>
					</div>
					<div class="dish-option" ng-repeat="option in product.options">- {{ getTranslate(option.title) }}</div>
					<div class="row">
						<div class="add-item text-center pull-left">
							<span class="change-qty increase" ng-click="increase(product)">+</span>
							<span class="quantity" data-id="{{ product.rowId }}">{{ product.qty }}</span>
							<span class="change-qty decrease" ng-click="decrease(product)">-</span>
						</div>
						<div class="dish-price pull-right">{{ (product.price * product.qty).toMoney() }}</div>
					</div>
				</div>
			</div>
			@endverbatim
			<div class="cart-item total">
				<div class="pull-left dish-name">@lang('cart.total')</div>
				<div class="pull-right dish-price cart-total">@{{ total().money }}</div>
				<div class="clearfix"></div>
			</div>
			<div class="text-center text-white">
				<a class="btn btn-checkout text-uppercase" href="{{ action('CartController@checkout') }}">@lang('user.button.checkout')</a>
			</div>
			<svg class="order-toggle hide-no-active" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="10.9px" viewBox="0 0 20 10.9" enable-background="new 0 0 20 10.9" xml:space="preserve">
			    <path fill="#950E08" d="M19.7,1.8c0.4-0.4,0.4-1.1,0-1.4c-0.4-0.4-1-0.4-1.4,0L9.9,8.5L1.7,0.3c-0.4-0.4-1-0.4-1.4,0
				C0.1,0.5,0,0.7,0,1c0,0.3,0.1,0.5,0.3,0.7l8.9,8.9c0.4,0.4,1.1,0.4,1.4,0L19.7,1.8z" />
			</svg>
		</div>
		<div class="clearfix"></div>
	</div>
@endsection

@push('scripts')
	<script type="text/javascript" src="/js/plugins/sticky/jquery-scrolltofixed.min.js"></script>
	<script type="text/javascript" src="/js/order/normal.js"></script>
	<script type="text/javascript">
		@if (!$currentUser)
			$('#form-share-link').submit(function(event) {
				var $form = $customerLogin.find('form[data-type="login"]');
				if ($form.children('input[name="getShareLink"]').length === 0)
					$form.append('<input type="hidden" name="getShareLink" value="1" />');
				angular.element($customerLogin[0]).scope().openTab(1);
				return false;
			});
		@endif
	</script>
@endpush
