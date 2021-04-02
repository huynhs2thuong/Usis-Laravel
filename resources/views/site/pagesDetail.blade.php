@extends('layouts.app')

@section('title', $post->meta_title)

@section('content')
<section class="top-page bg-white">
		<div id="breadcrumbs" style="margin-bottom: 0">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
		      <?php $link ='';
		      $title = '';
		      ?>
		     <?php if(isset($category) && $category): 
		     	if(isset($cateCheck)){
		     		$link = action('SiteController@showPageDichVu',['slug'=>$category->slug]);
		     	}else{
		     		$link = action('SiteController@level3Dichvu',['slug'=>'dich-vu-an-cu','permalink'=>$category->slug]);
		     	}
		     	$title = $category->title; 
		     else: ?>
		     	<?php if($module->name == 'event'): ?>
		      			<?php $link = action('SiteController@events',['slug'=>'']) ?>
		      		<?php else: ?>
		      			<?php if(isset($cureCateLife)): ?>
		      				<?php $link = action('SiteController@life',['slug'=>$cureCateLife->slug]) ?>
		      			<?php elseif(isset($curCateLaw)):?>	
		      				<?php $link = action('SiteController@laws') ?>
		      			<?php else: ?>
		      				<?php $link = action('SiteController@showPageDichVu',['slug'=>'']) ?>
		      			<?php endif;?>	
		      		<?php endif;?>	
		      		<?php
		      		$cat = $pages->getCat()->first();
		      		if(isset($cat->title) && $cat != NULL){
		      			$title = $cat->title;
		      		}
		      		
		      		?>
		     <?php endif; ?>
		      <li><a href="{{$link}}">{{$title}}</a></li>

		      	<li>{{stripslashes($pages->title)}}</li>
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

					@if($pages->content_vn != '' && $current_locale == 'vi') 
						{!!$pages->content_vn!!}
					@elseif($pages->content_en != '' && $current_locale == 'en')
						{!!$pages->content_en!!}
					@else
					{!!$contentget!!}
					@endif
				</div>
				@if(isset($tags) && count($tags)>0)
					<div class="tags">
						<span>@lang('page.tag')</span>
						<ul class="tags">
							
							@foreach($tags as $tag)
								<li><a href="{{action('SiteController@tags',$tag->slug)}}" data-id>{{$tag->name}}</a></li>
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
						<li <?php if($post->cat_id == $category->id): ?> class="active" <?php endif; ?>><a href="{{ action('SiteController@life',['slug'=>$category->slug]) }}">{{$category->title}}</a></li>
						@endforeach

					</ul>			
				</div>
			</div> <!--End widget-->
			@endif

			@if(isset($pageCategories))
			<div class="widget widget-american">
				<h3 class="widget-title">@lang('page.category')</h3>
				<div class="widget-content">
					<ul class="menu">
						@foreach($pageCategories as $category)
						@if($category->id != 45)
						<li <?php if($page->id_cate == $category->id): ?> class="active" <?php endif; ?>><a href="{{ action('SiteController@news',['slug'=>$category->slug]) }}">{{$category->title}}</a></li>
						@else
						<li <?php if($page->id_cate == $category->id): ?> class="active" <?php endif; ?>><a href="{{ route('laws') }}">{{$category->title}}</a></li>
						@endif
						@endforeach

						@if($lifecate)
						<li <?php if($page->id_cate == $lifecate->id): ?> class="active" <?php endif; ?>><a href="{{ route('life') }}">{{$lifecate->title}}</a></li>
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
			<?php $site = isset($lifeDetail) ? 'SiteController@life' : ( isset($lawDetail) ? 'SiteController@lawsDetail' : (isset($eventsDetail) ? 'SiteController@events' : 'SiteController@news')); ?>
			@endif
				<div class="list_item ">
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

						<a href="@if((isset($newcheck) && $newscheck == TRUE) || (isset($newscheck) && $newscheck == 'hdancu')){{action($site,$item->slug)}}@else{{action($site,$item->getSlug())}}@endif" class="list_title">
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
	        "@id": "{{action('SiteController@showPageDichVu',$slug)}}",
	        "name": "@lang('menu.page.service')",
	        "image": ""
	      }
	    },{
	      "@type": "ListItem",
	      "position": 3,
	      "item": {
	        "@id": "{{ $link }}",
	        "name": "{{ $title }}",
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