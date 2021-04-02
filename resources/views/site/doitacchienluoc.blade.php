@extends('layouts.app')

@section('title', $post->title)

@section('content')

<section class="top-page bg-white">
	
		<div id="breadcrumbs">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
		        @if(isset($secPage))
				<li>
				<?php
					if($current_locale == 'en'){
						$slugpage = 'partners';
					}else{
						$slugpage = 'doi-tac';
					}
				?>
					<a href="{{action('SiteController@showPage',$slugpage)}}">{{$secPage->title}}</a>
				</li>
				@endif
		      <li><a href="">{{stripslashes($post->title)}}</a></li>
		    </ul>
		</div>
		</div>
	<div class="container"> 
		<div class="page-title wow">
				<h1 class="title"> <span>{{$post->title}}</span></h1>
		</div>
	</div>	
</section>
<section class="row-section bg-white  wow">
	<div class="container"> 
		<div class="  row">
			<div class=" col-md-8 col-md-offset-2  ">

				<div class="entry-content">
						<?php echo stripslashes($post->description) ?>
				</div>

			</div>
		</div>
	</div>	
</section>

@if(isset($relateds) && count($relateds)>0)
<section class="u019 row-section pb-0 wow" >
	<div class="container">
		<div class="section-header" ><h2 class="section-title">@lang('menu.doi_tac_khac')</h2></div>	
		<div class="slide3-a-arr owl-carousel">
			<?php 
	      		if($current_locale == 'en'){
					$slug = 'us-settlement-service';
		            $permalink = 'partners';
	      		}else{
	      			$slug = 'dich-vu-an-cu';
    				$permalink = 'doi-tac-an-cu';
	      		}
	      	?>
			@foreach($relateds as $team)
				<div class="item text-center">
					<div class="img "><a href="{{route('dtAncuChitiet',['slug'=>$slug,'permalink'=>$permalink,'partners'=>$team->slug])}}"><img src="{{$team->image}}" alt="{{$team->title}}" /></a></div>
					<div class="text equal">
						<h3 class="title"><a href="{{route('dtAncuChitiet',['slug'=>$slug,'permalink'=>$permalink,'partners'=>$team->slug])}}">{{$team->title}}</a></h3>
						<div class="position">{{$team->excerpt}}</div>
						<div class="desc">
							{!! strip_tags(str_limit($team->description,100))!!}		
						</div>
					</div>										
				</div>
			@endforeach
		</div>	
		<span class="bgequal equal"></span>
	</div>
</section>
@endif
@endsection
@push('scripts')
<style>
	.row-section{padding-top:20px;padding-bottom:30px;}
	.page-title{margin-bottom:20px;}
	.u019.row-section{padding-bottom: 0}
	.slide3-a-arr .img {position: relative;}
	.slide3-a-arr .img a{position: absolute;width: 100%;text-align: center;left: 0;top: 50%;transform: translateY(-50%);}
</style>
@endpush

@push('og-meta')
@include('partials.canonical')
	<title>@if(isset($post->meta_title) && $post->meta_title != '') {{$post->meta_title}} @else {{$post->title}} @endif</title>
	<meta name="title" content="@if(isset($post->meta_title) && $post->meta_title != '') {{$post->meta_title}} @else {{$post->title}} @endif">
	<meta name="description" content="@if(isset($post->meta_desc) && $post->meta_desc != '') {{$post->meta_desc}} @else {{$post->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($post->meta_title) && $post->meta_title != '') {{$post->meta_title}} @else {{$post->excerpt}} @endif">
	<meta property="og:description" content="@if(isset($post->meta_desc) && $post->meta_desc != '') {{$post->meta_desc}} @else {{$post->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($post->meta_title) && $post->meta_title != '') {{$post->meta_title}} @else {{$post->title}} @endif">
	<meta property="og:type"   content="article" /> 
	<meta property="og:image" content="@if($post->resource_id) {{$post->image}} @else <?php echo URL::to('/').'/images/no-image.jpg';?> @endif"/>
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
	        "@id": "{{action('SiteController@showPage',$slugpage)}}",
	        "name": "{{$secPage->title}}"
	      }
	    },{
	      "@type": "ListItem",
	      "position": 3,
	      "item": {
	        "@id": "{{ Request::url() }}",
	        "name": "{{ $post->title }}"
	      }
	    }
	    ]
	  }
	</script>
@endpush