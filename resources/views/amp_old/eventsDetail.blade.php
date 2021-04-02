@extends('layouts.amp')
@push('styleinline')
.container ul{padding-left:0}.post-detail .container ul{padding-left: 30px;margin: 0 0 25px 25px;}amp-img{max-width:100%;height:auto}.post-detail .container .widget-content ul{margin-left:0;padding-left:0}
@endpush
@section('title', $post->meta_title)

@section('content')
<section class="top-page bg-white">
		<div id="breadcrumbs" style="margin-bottom: 0">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/amp' : '/en/amp' }}">@lang('menu.page.home') </a></li>
		      <?php $link ='';
		      $title = '';
		      ?>
		     <?php 
		     $cat = $post->getCat()->first();
		     if($current_locale == 'en'){
		     	$slug = $cat->alias_en;
		     }else{
		     	$slug = $cat->alias_vn;
		     }
		     if(isset($cat) && $cat): 
		     	$link = action('AmpController@events',$slug);
		     endif;
		     	?>
		      <li><a href="{{$link}}">{{$cat->title}}</a></li>

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
						<?php $contentr = $post->content_vn?>
					@elseif($post->content_en != '' && $current_locale == 'en')
						<?php $contentr = $post->content_en?>
					@else
					<?php $contentr = $contentget?>
					@endif

					<?php 
			            $content = preg_replace('/style=[^>]*/', '', $contentr);
			            $content1 = preg_replace('/<img .*? data-src="([^"]*)" .*?>/', '<amp-img src="$1" width="1.33" height="1" layout="responsive" heights="(min-width:500px) 300px, 80%"></amp-img>',$content);
			            $html = preg_replace('/<img(.*?)\/?>/', '<amp-img$1 alt="" width="1.33" height="1" layout="responsive" heights="(min-width:500px) 300px, 80%"></amp-img>',$content1);
			            $regex=  '#<iframe(.*?)\/?>(.*?)</iframe>#';
			            // preg_match($regex, $html, $matches);
			            if (preg_match($regex, $html, $matches)){
			              if(preg_match('/src="([^"]+)"/', $matches[1], $returnurl)){
			                $codearr = explode('/', end($returnurl));
			                $html = preg_replace('/<iframe(.*?)\/?>/', '<amp-youtube data-videoid="'.end($codearr).'" width="375" height="321" layout="responsive"></amp-yotubeu>',$content1);
			              }
			            }
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
					@include('partials.amp.formRegistry')
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
					<a href="{{action('AmpController@events',$item->getSlug())}}" class="list_img thumbCover_60">

					@if($item->resource_id !=NULL)
						<amp-img src="{{$item->imageUrl($item->getImage('thumbnail'),360,216,100)}}" alt="" /> 
					@else
						@if($item->content_image != '')
							<?php 
							$urlimageget  = 'https://www.usis.us/uploads/images/contents/'.$item->content_image;
							 ?>
							<amp-img src="{{$item->imageUrl($urlimageget,360,216,100)}}" alt="" /> 
						@else
							<amp-img src="{{$item->imageUrl($item->getImage('thumbnail'),360,216,100)}}" alt="" /> 
						@endif
					@endif
						
					</a>
					<div class="list_text">

						<a href="{{action('AmpController@events',$item->getSlug())}}" class="list_title">
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

@push('styles')
<style>
	.sidebar ul.menu{padding-left:0;}
</style>
@endpush

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
	        "@id": "{{ $link }}",
	        "name": "{{ $title }}",
	        "image": ""
	      }
	    },{
	      "@type": "ListItem",
	      "position": 3,
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