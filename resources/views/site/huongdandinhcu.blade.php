@extends('layouts.app')

@section('title', $module->meta_title)

@section('content')
<section class="top-page bg-white">

	<div id="breadcrumbs">
		<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
		       <?php 
		      	$slugnew = ($current_locale == 'en') ? 'us-news' : 'tin-tuc-my';
		      ?>
		      <li><a href="{{action('SiteController@news',$slugnew)}}">@lang('menu.page.news')</a></li>
		      <li><a href="javascript:;">{{$module->title}}</a></li>
		    </ul>
		</div>
	</div>
	<div class="container"> 
		<div class="page-title wow">
				<h1 class="title"> <span>{{$module->title}}</span></h1>
		</div>
	</div>	
</section>

<section class=" list5 bg-white">
	<div class="container"> 
		<div class="menu-content">
			<ul>
				@foreach($categories as $cate)
				@if((($cate->slug !='tuyen-dung') && ($current_locale == 'vi')) || (($cate->slug != 'recruitment') && ($current_locale != 'vi')) )
				<li>
					<a href="{{ action('SiteController@news',['slug'=>$cate->slug]) }}">{{ $cate->title }}</a>
				</li>
				@endif
				@endforeach
				<li><a href="{{ action('SiteController@life',['slug'=>'']) }}">{{ $lifemodule->title }}</a></li>
				@if($luatdichu)
				<li><a href="{{ action('SiteController@laws') }}">{{ $luatdichu->title }}</a></li>
				@endif
				<li class="active"><a href="{{ action('SiteController@laws') }}">{{ $module->title }}</a></li>
				@foreach($categories as $cate)
				@if((($cate->slug =='tuyen-dung') && ($current_locale == 'vi')) || (($cate->slug == 'recruitment') && ($current_locale != 'vi')) )
				<li>
					<a href="{{ action('SiteController@news',['slug'=>$cate->slug]) }}">{{ $cate->title }}</a>
				</li>
				@endif
				@endforeach
			</ul>
		</div>
		<div class=" list row">
			@foreach($datas as $data)
			<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12">
				<div class="list_item  wow">
					<a href="{{action('SiteController@hddcDetail',$data->getSlug())}}" class="list_img thumbCover_60">
						@if($data->resource_id != NULL)
							<img src="{{$data->imageUrl($data->getImage('thumbnail'),360,216,100)}}" alt="" /> 
						@else
							@if($data->content_image != '')
								<?php $url = URL::to('/').'/uploads/images/contents/'.$data->content_image ?>
								<img src="{{$data->imageUrl($url,360,216,100)}}" alt="" /> 
							@else
								<img src="{{$data->imageUrl($data->getImage('thumbnail'),360,216,100)}}" alt="" /> 
							@endif
						@endif
							
					</a>
					<div class="list_text">
						<div class="list_small"></div>
						<a href="{{action('SiteController@hddcDetail',$data->getSlug())}}" class="list_title">{{ $data->title }}</a>
						<div class="list_position">{{$data->excerpt}}</div>
					</div>
				</div> 
			</div>
			@endforeach
		</div>
		@if($datas->lastPage() > 1)
		<div class="div-pagination">
            {{ $datas->links() }}
        </div>
        @endif

	</div>	
</section>

@endsection
@if($module)
@push('og-meta')
@include('partials.canonical')
	<title>@if(isset($module->meta_title) && $module->meta_title != '') {{$module->meta_title}} @else {{$module->title}} @endif</title>
	<meta name="title" content="@if(isset($module->meta_title) && $module->meta_title != '') {{$module->meta_title}} @else {{$module->title}} @endif">
	<meta name="description" content="@if(isset($module->meta_desc) && $module->meta_desc != '') {{$module->meta_desc}} @else {{$module->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($module->meta_title) && $module->meta_title != '') {{$module->meta_title}} @else {{$module->excerpt}} @endif">
	<meta property="og:description" content="@if(isset($module->meta_desc) && $module->meta_desc != '') {{$module->meta_desc}} @else {{$module->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($module->meta_title) && $module->meta_title != '') {{$module->meta_title}} @else {{$module->title}} @endif">
	<meta property="og:type"   content="article" /> 
	<meta property="og:image" content="@if($module->resource_id) {{$module->getImage('full')}} @else <?php echo URL::to('/').'/images/no-image.jpg';?> @endif"/>
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
	        "@id": "{{action('SiteController@news',$slugnew)}}",
	        "name": "@lang('menu.page.news')",
	        "image": ""
	      }
	    },{
	      "@type": "ListItem",
	      "position": 3,
	      "item": {
	        "@id": "{{ Request::url() }}",
	        "name": "{{ $module->title }}",
	        "image": ""
	      }
	    }
	    ]
	  }
	</script>
@endpush
@endif