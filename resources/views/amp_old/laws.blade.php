@extends('layouts.amp')
@push('styleinline')
.col-xs-6{width:100%}.list5 .list_title{text-align:left}.container ul{padding-left:30px}.menu-content li {padding: 0 10px;}.menu-content li.active a{color: #0C50B8;font-weight: 700;}.menu-content a {font-size: 20px;display: block;text-align: left;}
@endpush
@section('title', $module->meta_title)

@section('content')
<section class="top-page bg-white">

	<div id="breadcrumbs">
		<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/amp' : '/en/amp' }}">@lang('menu.page.home') </a></li>
		      <?php 
		      	$slugnew = ($current_locale == 'en') ? 'us-news' : 'tin-tuc-my';
		      ?>
		      <li><a href="{{action('AmpController@news',$slugnew)}}">@lang('menu.page.news')</a></li>
		      <li><a href="#">{{$module->title}}</a></li>
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
					<a href="{{ action('AmpController@news',['slug'=>$cate->slug]) }}">{{ $cate->title }}</a>
				</li>
				@endif
				@endforeach
				<li><a href="{{ action('AmpController@life',['slug'=>'']) }}">{{ $lifemodule->title }}</a></li>
				<li class="active"><a href="{{ action('AmpController@laws') }}">{{ $module->title }}</a></li>
				@if($huongdan)
				<li><a href="{{ action('AmpController@huongdandinhcu') }}">{{ $huongdan->title }}</a></li>
				@endif
				@foreach($categories as $cate)
				@if((($cate->slug =='tuyen-dung') && ($current_locale == 'vi')) || (($cate->slug == 'recruitment') && ($current_locale != 'vi')) )
				<li>
					<a href="{{ action('AmpController@news',['slug'=>$cate->slug]) }}">{{ $cate->title }}</a>
				</li>
				@endif
				@endforeach
			</ul>
		</div>
		<div class=" list row">
			@foreach($datas as $data)
			<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12">
				<div class="list_item  wow">
					<a href="{{action('AmpController@lawsDetail',['slug'=>$data->slug])}}" class="list_img thumbCover_60">
						<amp-img src="{{$data->imageUrl($data->getImage('thumbnail'),360,216,100)}}" width="384" height="230" layout="responsive" alt="" />
					</a>
					<div class="list_text">
						<div class="list_small"></div>
						<a href="{{action('AmpController@lawsDetail',['slug'=>$data->slug])}}" class="list_title">{{ $data->title }}</a>
						<div class="list_position">{{$data->excerpt}}</div>
					</div>
				</div> 
			</div>
			@endforeach
		</div>
		@if($datas->lastPage() > 1)
		<div class="div-pagination ">
            {{ $datas->links() }}
        </div>
        @endif

	</div>	
</section>

@endsection
@if($module)
@push('og-meta')
@include('partials.canonical')
	<title>@if(isset($module->meta_title) && $module->meta_title != '') {{strip_tags($module->meta_title)}} @else {{$module->title}} @endif</title>
	<meta name="title" content="@if(isset($module->meta_title) && $module->meta_title != '') {{strip_tags($module->meta_title)}} @else {{$module->title}} @endif">
	<meta name="description" content="@if(isset($module->meta_desc) && $module->meta_desc != '') {{$module->meta_desc}} @else {{$module->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($module->meta_title) && $module->meta_title != '') {{strip_tags($module->meta_title)}} @else {{$module->excerpt}} @endif">
	<meta property="og:description" content="@if(isset($module->meta_desc) && $module->meta_desc != '') {{$module->meta_desc}} @else {{$module->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($module->meta_title) && $module->meta_title != '') {{strip_tags($module->meta_title)}} @else {{$module->title}} @endif">
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
	        "@id": "{{action('AmpController@news',$slugnew)}}",
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