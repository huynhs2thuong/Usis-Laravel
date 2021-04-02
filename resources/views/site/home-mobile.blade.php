@extends('layouts.app')

@section('content')
<article ng-controller="StoreController">
	<section class="mobile-banner text-center">
		<div id="mobile-slider" class="banner-cover swiper-container">
			<div class="swiper-wrapper">
				<img src="/images/home/banner.jpg" class="swiper-slide img-responsive" alt="gà sài gòn sốt cay">
				<img src="/images/home/banner2.jpg" class="swiper-slide img-responsive" alt="vui ăn ngon thỏa sức phiêu lưu">
				<img src="/images/home/banner3.jpg" class="swiper-slide img-responsive" alt="vui ăn ngon thỏa sức phiêu lưu">
			</div>
			<div class="swiper-button-prev swiper-button-white"></div>
			<div class="swiper-button-next swiper-button-white"></div>
		</div>
		<a href="{{ action('GroupController@index') }}" class="btn btn-primary btn-blue text-uppercase" role="button">@lang('user.button.order')</a>
	</section>

	<section class="mobile-dishes">
		<div class="display-flex">
			@foreach (array_filter(trans('menu.group'), function($key) { return !in_array($key, ['khuyen-mai', 'mon-moi-mon-ngon']); }, ARRAY_FILTER_USE_KEY) as $key => $value)
				<a href="{{ action('GroupController@show', $key) }}" class="dish">
					<div class="dish-img display-flex">
						<img src="/images/menu/{{ $key }}.png" alt="" class="img-responsive">
					</div>
					<h4 class="dish-name text-uppercase text-center">{{ $value }}</h4>
				</a>
			@endforeach
		</div>
	</section>
	<form class="mobile-dist" ng-submit="submit()">
		<h2 class="dist-title text-uppercase text-center">@lang('page.store.text1')</h2>
		<div class="select-style">
			<select name="city" ng-model="city" ng-options="city.id as getTranslate(city.title) for city in cities">
                <option value="" disabled="">@lang('cart.form.city')</option>
            </select>
			<i class="fa fa-angle-down"></i>
		</div>
		<div class="select-style">
			<select name="district" ng-model="district" ng-options="district.id as getTranslate(district.title) for district in districts | filter:{city_id: city}:true">
                <option value="" disabled="">@lang('cart.form.district')</option>
            </select>
			<i class="fa fa-angle-down"></i>
		</div>
		<button type="submit" class="btn text-uppercase">@lang('admin.button.search')</button>
	</form>
	<section class="mobile-agent">
		<a href="#map-canvas" class="agent-block text-uppercase" ng-repeat="store in stores" ng-click="storeClick($index, store)">
			@{{ getTranslate(store.title) }}
			{{--<p>@lang('admin.field.address'):  @{{ store.address }}</p>
			<p>@lang('admin.field.business_hours'): @{{ store.hour }}</p>--}}
		</a>
	</section>
	<section id="map-canvas"></section>
	<section class="mobile-address" ng-show="stores.length">
		<h4 class="text-capitalize text-center">@{{ getTranslate(currentStore.title) }}</h4>
		<p class="text-center">@lang('admin.field.address'): @{{ getTranslate(currentStore.address) }}</p>
		<p class="text-center">@lang('admin.field.business_hours'): @{{ getTranslate(currentStore.hour) }}</p>
	</section>
	<section class="mobile-contact">
		<div class="display-flex contact">
			<a href="{{ action('GroupController@index') }}" class="contact-block">@lang('page.home.text6')</a>
			@foreach ($services as $service)
			<a href="{{ action('SiteController@showPage', $service->slug) }}" class="contact-block">{{ $service->title }}</a>
			@endforeach
		</div>
		<h4 class="text-uppercase text-center">CONNECT WITH JOLLIBEE</h4>
		<div class=" social text-center">
			<a href="#"><i class="fa fa-twitter fa-2x"></i></a>
			<a href="http://www.facebook.com/JollibeeVietnam"><i class="fa fa-facebook fa-2x"></i></a>
			<a href="#"><i class="fa fa-google fa-2x"></i></a>
		</div>
	</section>
</article>
@endsection

@push('scripts')
	<script type="text/javascript">
		var customerCity = {{ Cookie::get('customerCity', 1) }}
			messageNoStore = '@lang('user.message.no store')',
			locations = [
				@foreach ($stores as $store)
					{
						title: '{{ $store->title }}',
						slug: '{{ $store->slug }}',
						address: '{{ $store->address }}',
						hour: '{{ $store->business_hours }}',
						lat: {{ $store->lat }},
						lng: {{ $store->lng }},
						image: '{{ $store->image }}'
					},
				@endforeach
			];
	</script>
	<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key={{ config('services.google.key') }}&libraries=places&callback=initMap&language={{ $current_locale }}" async defer></script>
	<script type="text/javascript" src="{{ asset('/js/store.js') }}"></script>
@endpush
