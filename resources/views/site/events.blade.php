@extends('layouts.app')

@section('title', $category->meta_title)

@section('content')

<section class="top-page bg-white">
<?php 
if($current_locale == 'vi'){
    $slug = 'hoat-dong-usis';
}else{
    $slug = 'usis-activities';
}           
?>
		<div id="breadcrumbs">
			<div class="container">
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
		      <li><a href="{{action('SiteController@events',['slug'=>$slug])}}">{{$module->title}}</a></li>
		      <li><a href="{{action('SiteController@events',['slug'=>$category->slug])}}">{{$category->title}}</a></li>
		    </ul>
		</div>
		</div>
	<div class="container">
		<div class="page-title wow">
				<h1 class="title"> <span>{{$category->title}}</span></h1>
		</div>
	</div>	
</section>



@if($stickyEvent)
<?php 

if($stickyEvent->content_image != ''){
	$url = URL::to('/').'/uploads/images/contents/'.$stickyEvent->content_image;
}else{
	$url = $stickyEvent->getImage('thumbnail');
}
// var_dump($url);die;
?>
<section class="pb-70 bg-white wow"> 
    <div class="container">
    	<div class="block2">
	    	<div class="row block">
	    		<div class="col-md-6 block_img">
	    			<a href="{{route('eventsnewsDetail',['slug'=>$stickyEvent->slug,'suffix'=>'.html'])}}" title="{{$stickyEvent->title}}">
						<img class="img-lazy" data-src="{{$stickyEvent->imageUrl($url,570,296,80)}}" alt="" /> 
					</a>
					<div class="inner">
						<div class="inner2">
						<h4 class="text-1"></h4>
						<h2 class="text-2"><a href="{{route('eventsnewsDetail',['slug'=>$stickyEvent->slug,'suffix'=>'.html'])}}" title="{{$stickyEvent->title}}"> {{$stickyEvent->title}}	</a></h2>
						</div>
					</div>
	    		</div>
	    		<div class="col-md-6 block_text">
					<!-- <h4 class="block_title"> <i class="fa fa-clock-o"></i>	17h00 ngày 10/10 tại KS New World  (Tp.HCM)	<br>
					<h4 class="block_title"> <i class="fa fa-clock-o"></i>	17h00 ngày 12/10 tại KS Melia (Hà Nội) 	</h4> -->
					<div class="block_decs">{!! stripslashes($stickyEvent->excerpt) !!}</div>
					<a href="{{action('SiteController@eventsDetail',['slug'=>$stickyEvent->slug,'suffix'=>'.html'])}}" class="btn  ">@lang('page.menu.xem_them')</a>
	    		</div>
	    	</div>
		</div>	    	
    </div> 
</section>
@endif

<section class="row-section list5  wow">
	<div class="container"> 

		<div class="section-header">
			<h2 class="section-title"> @lang('page.news_event') </h2>
			<i class="icon-star3"></i>
		</div>

		<div class="menu-content">
			<ul>
				@foreach($categories as $cate)
				<li <?php if($cate->id == $category->id): ?> class="active" <?php endif; ?>>
					<a href="{{ action('SiteController@events',['slug'=>$cate->slug]) }}">{{ $cate->title }}</a>
				</li>
				@endforeach

			</ul>
		</div>

		<div class=" list row">
			@foreach($datas as $data)
			<div class="col-md-4 col-sm-6 col-sm-6 col-xxs-12">
				<div class="list_item ">
					<a href="{{action('SiteController@events',$data->getSlug())}}" class="list_img thumbCover_60">
					@if($data->resource_id != NULL)
						<img class="img-lazy" data-src="{{$data->imageUrl($data->getImage('thumbnail'),360,216,80)}}" alt="" /> 
					@else
						@if($data->content_image != '')
							<img class="img-lazy" data-src="{{URL::to('/')}}/uploads/images/contents/{{$data->content_image }}" alt="" /> 
						@else
							<img class="img-lazy" data-src="{{$data->imageUrl($data->getImage('thumbnail'),360,216,80)}}" alt="" /> 
						@endif
					@endif	
					</a>
					<div class="list_text">
						<a href="{{action('SiteController@events',$data->getSlug())}}" class="list_title">{!! stripslashes($data->title) !!}</a>
						<div class="list_position">{!! stripslashes($data->excerpt) !!}</div>
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

@push('og-meta')
@include('partials.canonical')
	<title>@if(isset($category->meta_title) && $category->meta_title != '') {{strip_tags($category->meta_title)}} @else {{$category->title}} @endif</title>
	<meta name="title" content="@if(isset($category->meta_title) && $category->meta_title != '') {{strip_tags($category->meta_title)}} @else {{$category->title}} @endif">
	<meta name="description" content="@if(isset($category->meta_desc) && $category->meta_desc != '') {{$category->meta_desc}} @else {{$category->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($category->meta_title) && $category->meta_title != '') {{strip_tags($category->meta_title)}} @else {{$category->title}} @endif">
	<meta property="og:description" content="@if(isset($category->meta_desc) && $category->meta_desc != '') {{$category->meta_desc}} @else {{$category->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($category->meta_desc) && $category->meta_title != '') {{strip_tags($category->meta_title)}} @else {{$category->excerpt}} @endif">
	<meta property="og:type"   content="article" /> 
	<meta property="og:image" content="@if($category->resource_id) {{$category->getImage('full')}} @else <?php echo URL::to('/').'/images/no-image.jpg';?> @endif"/>
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
	        "@id": "{{action('SiteController@events',['slug'=>$slug])}}",
	        "name": "{{$module->title}}",
	        "image": ""
	      }
	    },{
	      "@type": "ListItem",
	      "position": 3,
	      "item": {
	        "@id": "{{ Request::url() }}",
	        "name": "{{ $category->title }}",
	        "image": ""
	      }
	    }
	    ]
	  }
	</script>
@endpush