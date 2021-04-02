@extends('layouts.amp')
@push('styleinline')
.h3, h3 {font-size: 24px;line-height: 34px;}
@endpush
@section('title', $post->title)

@section('content')

<section class="top-page bg-white">
	
		<div id="breadcrumbs">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
		        @if(isset($secPage))
				<li>
					<a href="{{action('AmpController@showPageDichVu',$secPage->slug)}}">{{$secPage->title}}</a>
				</li>
				@endif
				@if(isset($thiPage))
				<li>
					<a href="{{action('AmpController@level3Dichvu',['slug'=>$secPage->slug,'permalink'=>$thiPage->slug])}}">{{$thiPage->title}}</a>
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
					<?php 
		            $content = preg_replace('/style=[^>]*/', '', stripslashes($post->description));
		            $content1 = preg_replace('/<img .*? data-src="([^"]*)" .*?>/', '<amp-img src="$1" width="372" height="459" heights="(min-width:500px) 459px, 80%"></amp-img>',$content);
		            $html = preg_replace('/<img(.*?)\/?>/', '<amp-img$1 width="372" height="459" alt="AMP" heights="(min-width:500px) 459px, 80%"></amp-img>',$content1);
		            $regex=  '#<iframe(.*?)\/?>(.*?)</iframe>#';
		            // preg_match($regex, $html, $matches);
		            if (preg_match($regex, $html, $matches)){
		              if(preg_match('/src="([^"]+)"/', $matches[1], $returnurl)){
		                $codearr = explode('/', end($returnurl));
		                $html = preg_replace('/<iframe(.*?)\/?>/', '<amp-youtube$1 data-videoid="'.end($codearr).'" width="375" height="321" layout="responsive"></amp-yotubeu>',$content1);
		              }
		            }
		            ?>
		              {!! $html !!}	
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
					<div class="img "><a href="{{route('dtAncuChitietamp',['slug'=>$slug,'permalink'=>$permalink,'partners'=>$team->slug])}}"><amp-img src="{{$team->image}}" alt="{{$team->title}}" height="459" width="345" layout="responsive" /></a></div>
					<div class="text equal">
						<h3 class="title"><a href="{{route('dtAncuChitietamp',['slug'=>$slug,'permalink'=>$permalink,'partners'=>$team->slug])}}">{{$team->title}}</a></h3>
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
	        "@id": "{{action('AmpController@showPage','doi-tac')}}",
	        "name": "@lang('menu.page.partner')"
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