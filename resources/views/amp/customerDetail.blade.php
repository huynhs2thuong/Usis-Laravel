@extends('layouts.amp')

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

				<?php 
	            $content = preg_replace('/style=[^>]*/', '', stripslashes($customer->description));
	            $content1 = preg_replace('/<img .*? data-src="([^"]*)" .*?>/', '<amp-img src="$1" width="472" height="400" layout="responsive"></amp-img>',$content);
	            $html = preg_replace('/<img(.*?)\/?>/', '<amp-img$1 width="472" height="400" alt="AMP" layout="responsive"></amp-img>',$content1);
	            $regex=  '#<iframe(.*?)\/?>(.*?)</iframe>#';
	            if (preg_match($regex, $html, $matches)){
	              if(preg_match('/src="([^"]+)"/', $matches[1], $returnurl)){
	                $codearr = explode('/', end($returnurl));
	                $html = preg_replace('/<iframe(.*?)\/?>/', '<amp-youtube data-videoid="'.end($codearr).'" width="375" height="321" layout="responsive"></amp-yotubeu>',$content1);
	              }
	            }
	            ?>
              {!! $html !!}
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
							<amp-img src="/uploads/images/contents/{{$data->content_image }}" alt="" width="60" height="60"/> 
						@else
							<amp-img src="{{$data->getImage('thumbnail')}}" alt="" width="60" height="60" /> 
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