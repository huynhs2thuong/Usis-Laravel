@extends('layouts.amp')

@section('content')

	<div class="page-store container-fluid" ng-controller="StoreController">
		<div class="flex-box row first">
			<div class="shadow-bottom col-sm-6">
				<div class="form-container center-block">
					<h1 class="text-uppercase"><b>@lang('page.store.text1')</b></h1>
					<form class="form-inline" ng-submit="submit()">
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
						<button type="submit" class="btn btn-color text-uppercase">@lang('user.button.search')</button>
					</form>
				</div>
			</div>
			<div class="shadow-bottom col-sm-6 text-center" ng-show="stores.length">
				<h4 class="text-uppercase">@{{ getTranslate(currentStore.title) }}</h4>
				<p>@lang('admin.field.address'): @{{ getTranslate(currentStore.address) }}</p>
				<p>@lang('admin.field.business_hours'): @{{ getTranslate(currentStore.hour) }}</p>
			</div>
		</div>
		<div class="row second">
			<div class="col-xs-12 col-sm-5 col-md-6 no-padding img-background">
				<div class="stores-container text-white pull-right">
					<div class="stores-inner scrollbar-inner">
						<div class="store-entry" ng-repeat="store in stores" ng-click="storeClick($index, store)">
							<h4 class="text-uppercase">@{{ getTranslate(store.title) }}</h4>
							<p>@lang('admin.field.address'):  @{{ getTranslate(store.address) }}</p>
							<p>@lang('admin.field.business_hours'): @{{ getTranslate(store.hour) }}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-7 col-md-6 no-padding">
				<div id="map-canvas"></div>
			</div>
		</div>
		<div class="text-center visible-xs" ng-show="stores.length">
			<h4 class="text-uppercase">@{{ getTranslate(currentStore.title) }}</h4>
			<p></p>
			<p>@lang('admin.field.address'): @{{ getTranslate(currentStore.address) }}</p>
			<p>@lang('admin.field.business_hours'): @{{ getTranslate(currentStore.hour) }}</p>
		</div>
	</div>

@endsection

@push('og-meta')
@include('partials.canonical')
	<title>@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->title}} @endif</title>
	<meta name="title" content="@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->title}} @endif">
	<meta name="description" content="@if(isset($page->meta_desc) && $page->meta_desc != '') {{$page->meta_desc}} @else {{$page->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->title}} @endif">
	<meta property="og:description" content="@if(isset($page->meta_desc) && $page->meta_desc != '') {{$page->meta_desc}} @else {{$page->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($page->meta_desc) && $page->meta_title != '') {{$page->meta_desc}} @else {{$page->excerpt}} @endif">
	<meta property="og:type"   content="article" /> 
	<meta property="og:image" content="@if($page->resource_id) {{$page->image}} @else <?php echo URL::to('/').'/images/no-image.jpg';?> @endif"/>
	@include('partials.linklanguage')
	<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "BreadcrumbList",
		"itemListElement": [{
			"@type": "ListItem",
			"position": 1,
			"item": {
				"@id": "{{URL::to('/')}}{{ ($current_locale == 'vi') ? '/' : '/en' }}",
				"name": "Home"
			}
		},{
			"@type": "ListItem",
			"position": 2,
			"item": {
				"@id": "{{ Request::url() }}",
				"name": "{{ $page->title }}"
			}
		}
		]
	}
	</script>
@endpush