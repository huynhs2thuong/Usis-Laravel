@extends('layouts.amp')
@push('styleinline')
.page-title{padding-bottom:40px}
@endpush
@section('title', $post->meta_title)

@section('content')
<section class="top-page bg-white">
		<div id="breadcrumbs" style="margin-bottom: 0">
			<div class="container"> 
		    <ul class="breadcrumb">
				<li><a href="{{ ($current_locale == 'vi') ? '/amp' : '/en/amp' }}">@lang('menu.page.home') </a></li>		
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
				<li>{{stripslashes($post->title)}}</li>
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

					@if($post->content_vn != '' && $current_locale == 'vi') 
						<?php $content = $post->content_vn?>
						
					@elseif($post->content_en != '' && $current_locale == 'en')
						<?php $content = $post->content_vn?>		
					@else
						<?php $content = $contentget?>
					@endif

					<?php 
					$content = preg_replace('/style=[^>]*/', '', $content);
					$content1 = preg_replace('/<img .*? data-src="([^"]*)" .*?>/', '<amp-img src="$1" width="375" height="400"></amp-img>',$content);
					$html = preg_replace('/<img(.*?)\/?>/', '<amp-img$1 width="375" height="400" alt="AMP"></amp-img>',$content1);
					$regex=  '#<iframe(.*?)\/?>(.*?)</iframe>#';
					preg_match($regex, $html, $matches);
					preg_match('/src="([^"]+)"/', $matches[1], $returnurl);
					$codearr = explode('/', end($returnurl));
					$return = explode('?', end($codearr));
					$html = preg_replace('/<iframe(.*?)\/?>/', '<amp-youtube data-videoid="'.$return[0].'" width="375" height="321" layout="responsive"></amp-yotubeu>',$content1);
					?>
				    {!! $html !!}
				</div>
				@if(isset($tags) && count($tags)>0)
					<div class="tags">
						<span>@lang('page.tag')</span>
						<ul class="tags">
							
							@foreach($tags as $tag)
								<li><a href="{{action('AmpController@tags',$tag->slug)}}" data-id>{{$tag->name}}</a></li>
							@endforeach
							
						</ul>
					</div>
				@endif
			</div>

		<div class="col-sm-4 sidebar">
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
		<?php $category= $post->category()->first(); ?>
		@if(isset($category))
		<h2 class="section-title">
		@if(isset($titleorder))
			{{$titleorder}}
		@else
		{{$category->title}}
		@endif
		</h2>
		@endif
		<div class=" list slide3-arr owl-carousel top-arrows">
			@foreach($relateds as $item)
				<div class="list_item ">
					<a href="{{action('AmpController@dtAncuChitiet',['slug'=>$secPage->slug,'permalink'=>$thiPage->slug,'partners'=>$item->slug])}}" class="list_img thumbCover_60">

					@if($item->resource_id !=NULL)
						<img class="img-lazy" data-src="{{$item->imageUrl($item->getImage('thumbnail'),360,216,100)}}" alt="" /> 
					@else
						@if($item->content_image != '')
							<?php 
								$urlimage = 'https://www.usis.us/uploads/images/contents/'.$item->content_image;
							?>
							<img class="img-lazy" data-src="{{$item->imageUrl($urlimage,360,216,100)}}" alt="" /> 
						@else
							<img class="img-lazy" data-src="{{$item->imageUrl($item->getImage('thumbnail'),360,216,100)}}" alt="" /> 
						@endif
					@endif
						
					</a>
					<div class="list_text">

						<a href="{{action('AmpController@dtAncuChitiet',['slug'=>$secPage->slug,'permalink'=>$thiPage->slug,'partners'=>$item->slug])}}" class="list_title">
							{{ stripslashes($item->title) }}
						</a>
						<div class="list_position">{{stripslashes($item->excerpt)}}</div>
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
	<meta property="og:image" content="@if($post->content_image != '') https://www.usis.us/uploads/images/contents/{{$post->content_image }} @else{{$post->image}}@endif"/>
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
	        "@id": "{{action('AmpController@showPageDichVu',$secPage->slug)}}",
	        "name": "{{ $secPage->title }}",
	        "image": ""
	      }
	    },{
	      "@type": "ListItem",
	      "position": 3,
	      "item": {
	        "@id": "{{action('AmpController@level3Dichvu',['slug'=>$secPage->slug,'permalink'=>$thiPage->slug])}}",
	        "name": "{{ $thiPage->title }}",
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