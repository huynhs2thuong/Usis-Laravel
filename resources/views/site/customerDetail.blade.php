
@extends('layouts.app')

@section('title', $customer->meta_title)

@section('content')
<section class="top-page bg-white">
	
		<div id="breadcrumbs">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
		      <li><a href="{{ action('SiteController@customer') }}">{{ $module->title }}</a></li>
		      <li><a href="">{{ $customer->title }}</a></li>
		    </ul>
		</div>
		</div>
	<div class="container"> 
		<div class="page-title wow">
				<h1 class="title"> <span>{{ $customer->title }}</span></h1>
		</div>
	</div>	
</section>

<section class="pb-70 bg-white wow">
	<div class="container"> 
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				@if($customer->video_url)
				<div class="videoTubte thumbCover_16_9">
					<?php echo $customer->video_url ?>
				</div>
				<p class="text-center">Video khách hàng đang chia sẻ</p>
				@endif
				{!! stripslashes($customer->description) !!}
			</div>
		</div>
	</div>	
</section>

<section class="row-section list8 wow">
	<div class="container"> 
		<h2 class="section-title"> @lang('menu.page.khach_hang_khac') </h2>
		<div class=" list slide3-arr top-arrows owl-carousel">
			@foreach($others as $data)
				<div class="list_item ">
					<a href="{{ action('SiteController@customerDetail',['slug'=>$data->getSlug(),'suffix'=>'.html']) }}" class="list_img">
						@if($data->content_image != '')
							<img class="img-lazy" data-src="/uploads/images/contents/{{$data->content_image }}" alt="" /> 
						@else
							<img class="img-lazy" data-src="{{$data->getImage('thumbnail')}}" alt="" /> 
						@endif
					</a>
					<span class="list_arrow"></span>
					<div class="list_text">
						<a href="{{ action('SiteController@customerDetail',['slug'=>$data->getSlug(),'suffix'=>'.html']) }}" class="list_title">{{ $data->title }}</a>
						<div class="list_desc">{!! $data->excerpt !!}</div>
					</div>
				</div> 

			@endforeach
		</div>
	</div>	
</section>

@endsection

@push('og-meta')
@include('partials.canonical')
	<title>@if(isset($customer->meta_title) && $customer->meta_title != '') {{$customer->meta_title}} @else {{$customer->title}} @endif</title>
	<meta name="title" content="@if(isset($customer->meta_title) && $customer->meta_title != '') {{$customer->meta_title}} @else {{$customer->title}} @endif">
	<meta name="description" content="@if(isset($customer->meta_desc) && $customer->meta_desc != '') {{$customer->meta_desc}} @else {{$customer->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($customer->meta_title) && $customer->meta_title != '') {{$customer->meta_title}} @else {{$customer->title}} @endif">
	<meta property="og:description" content="@if(isset($customer->meta_desc) && $customer->meta_desc != '') {{$customer->meta_desc}} @else {{$customer->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($customer->meta_desc) && $customer->meta_title != '') {{$customer->meta_desc}} @else {{$customer->excerpt}} @endif">
	<meta property="og:type"   content="article" /> 
	<meta property="og:image" content="@if($customer->resource_id) {{$customer->getImage('full')}} @else <?php echo URL::to('/').'/images/no-image.jpg';?> @endif"/>
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
	        "name": "Home",
	        "image": ""
	      }
	    },{
	      "@type": "ListItem",
	      "position": 2,
	      "item": {
	        "@id": "{{ action('SiteController@customer') }}",
	        "name": "{{ $module->title }}",
	        "image": ""
	      }
	    },{
	      "@type": "ListItem",
	      "position": 3,
	      "item": {
	        "@id": "{{ Request::url() }}",
	        "name": "{{ $customer->title }}",
	        "image": ""
	      }
	    }
	    ]
	  }
	</script>

@endpush