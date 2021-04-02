@extends('layouts.amp')
@push('styleinline')
img{object-fit:cover;width:100%;height:auto}
@endpush
@section('title', $post->meta_title)

@section('content')
<section class="top-page bg-white">
	
		<div id="breadcrumbs" style="margin-bottom: 0">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/amp' : '/en/amp' }}">@lang('menu.page.home') </a></li>
		      <?php 
		      	$slugnew = ($current_locale == 'en') ? 'us-news' : 'tin-tuc-my';
		      ?>
		      <li><a href="{{action('AmpController@news',$slugnew)}}">@lang('menu.page.news')</a></li>
		      <li><a href="{{route('huongdandinhcuamp')}}">{{$module->title}}</a></li>
		      <li><a href="">{{$post->title}}</a></li>
		    </ul>
		    </div>	
		</div>

	
</section>


<section class="post-detail  bg-white">
	<div class="container"> 
		<div class="row">
			<div class="col-sm-8">
				<div class="page-title wow">
					<h1 class="title"> <span><?php echo stripslashes($post->title)?></span></h1>
				</div>				
				<div class="entry-content">
					<?php 
		            $content = preg_replace('/style=[^>]*/', '', $contentget);
		            $content1 = preg_replace('/<img .*? data-src="([^"]*)" .*?>/', '<amp-img src="$1" width="372" height="300" heights="(min-width:500px) 250px, 80%"></amp-img>',$content);
		            $html = preg_replace('/<img(.*?)\/?>/', '<amp-img$1 width="372" height="300" alt="AMP" heights="(min-width:500px) 250px, 80%"></amp-img>',$content1);
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

		<div class="col-sm-4 sidebar">
			@if(isset($lifeCategories))
			<div class="widget widget-american">
				<h3 class="widget-title">Danh mục</h3>
				<div class="widget-content">
					<ul class="menu">
						@foreach($lifeCategories as $category)
						<li <?php if($post->cat_id == $category->id): ?> class="active" <?php endif; ?>><a href="{{ action('AmpController@life',['slug'=>$category->slug]) }}">{{$category->title}}</a></li>
						@endforeach

					</ul>			
				</div>
			</div> <!--End widget-->
			@endif

			@if(isset($newCategories))
			<div class="widget widget-american">
				<h3 class="widget-title">@lang('page.category')</h3>
				<div class="widget-content">
					<ul class="menu">
						@foreach($newCategories as $category)
						@if($category->id != 45)
						<li <?php if($post->cat_id == $category->id): ?> class="active" <?php endif; ?>><a href="{{ action('AmpController@news',['slug'=>$category->slug]) }}">{{$category->title}}</a></li>
						@else
						<li <?php if($post->cat_id == $category->id): ?> class="active" <?php endif; ?>><a href="{{ route('lawsamp') }}">{{$category->title}}</a></li>
						@endif
						@endforeach

						@if($lifecate)
						<li <?php if($post->cat_id == $lifecate->id): ?> class="active" <?php endif; ?>><a href="{{ route('lifeamp') }}">{{$lifecate->title}}</a></li>
						@endif
					</ul>			
				</div>
			</div> <!--End widget-->
			@endif

			<div class="widget widget-register">
				<h3 class="widget-title">@lang('menu.page.dang_ky_tu_van_eb5_mien_phi')</h3>
				<div class="widget-content">
					@include('partials.formRegistry')
				</div>
			</div> <!--End widget-->
		</div>
	</div>
</section>

@if(count($relateds)>0)
<section class="row-section u008 list5 ">
	<div class="container"> 
		<h2 class="section-title"> {{$module->title}} khác </h2>
		<div class=" list slide3-arr owl-carousel top-arrows">
			@foreach($relateds as $item)
			<?php $site = 'AmpController@hddcDetail'; ?>
				<div class="list_item ">
					<a href="{{action($site,['slug'=>$item->getSlug()])}}" class="list_img thumbCover_60">

						@if($item->content_image != '')
							<amp-img src="{{URL::to('/')}}/uploads/images/contents/{{$item->content_image }}" alt="" width="384" height="230" layout="responsive" /> 
						@else
							<amp-img src="{{$item->getImage('thumbnail')}}" alt="" width="384" height="230" layout="responsive" /> 
						@endif
					</a>
					<div class="list_text">

						<a href="{{action($site,['slug'=>$item->getSlug()])}}" class="list_title">
							{{ $item->title }}
						</a>
						<div class="list_position">{{$item->excerpt}}</div>
					</div>
				</div> 
			<!--End item-->
			@endforeach
		</div>
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
	<meta property="og:title" content="@if(isset($post->meta_title) && $post->meta_title != '') {{$post->meta_title}} @else {{$post->title}} @endif">
	<meta property="og:description" content="@if(isset($post->meta_desc) && $post->meta_desc != '') {{$post->meta_desc}} @else {{$post->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($post->meta_desc) && $post->meta_title != '') {{$post->meta_desc}} @else {{$post->excerpt}} @endif">
	<meta property="og:type"   content="article" /> 
	<meta property="og:image" content="@if($post->resource_id) {{$post->getImage('full')}} @else <?php echo URL::to('/').'/images/no-image.jpg';?> @endif"/>
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
	        "@id": "{{route('huongdandinhcuamp')}}",
	        "name": "{{ $module->title }}",
	        "image": ""
	      }
	    },{
	      "@type": "ListItem",
	      "position": 4,
	      "item": {
	        "@id": "{{ Request::url() }}",
	        "name": "{{ $post->title }}",
	        "image": ""
	      }
	    }
	    ]
	  }
	</script>
@endpush