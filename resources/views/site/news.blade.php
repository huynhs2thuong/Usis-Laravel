@extends('layouts.app')
<?php 
	if(isset($category)){
				$title = $category->title;
		$slug = $category->slug;
	}elseif($module){

				$title  = $module->meta_title;
		$slug = $module->slug;
	}else{
		$title = $title;
		$slug = '';
	}
?>
@section('title', $title)
@section('content')
<section class="top-page bg-white">
		<div id="breadcrumbs">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
		      @if(isset($secPage))
			      <li>
					<a href="{{action('SiteController@showPageDichVu',$secPage->slug)}}">{{$secPage->title}}</a>
				</li>
		      @endif
		      <?php 
		      	$slugnew = ($current_locale == 'en') ? 'us-news' : 'tin-tuc-my';
		      ?>
		      <li><a href="{{action('SiteController@news',$slugnew)}}">@lang('menu.page.news')</a></li>
		      <li><a href="{{action('SiteController@news',['slug'=>$slug])}}">{{$category->title}}</a></li>
		    </ul>
		</div>
		</div>
	<div class="container"> 
		<div class="page-title wow">
				<h1 class="title"> <span>@if($category){{$category->title}}@else @lang('menu.page.news') @endif</span></h1>
		</div>
	</div>	
</section>


<section class=" list5 bg-white">
	<div class="container"> 
		@if(isset($categories))
		<div class="menu-content">
			<ul>
				@foreach($categories as $cate)
				@if((($cate->slug !='tuyen-dung') && ($current_locale == 'vi')) || (($cate->slug != 'recruitment') && ($current_locale != 'vi')) )
				<li <?php if($cate->id == $category->id): ?> class="active" <?php endif; ?>>
					<a href="{{ action('SiteController@news',['slug'=>$cate->slug]) }}">{{ $cate->title }}</a>
				</li>
				@endif
				@endforeach
			<!--	@if($lifemodule)
				<li><a href="{{ action('SiteController@life',['slug'=>'']) }}">{{ $lifemodule->title }}</a></li>
				@endif
				@if($luatdichu)
				<li><a href="{{ action('SiteController@laws') }}">{{ $luatdichu->title }}</a></li>
				@endif
				@if($huongdan)
				<li><a href="{{ action('SiteController@huongdandinhcu') }}">{{ $huongdan->title }}</a></li>
				@endif -->
				@foreach($categories as $cate)
				@if((($cate->slug =='tuyen-dung') && ($current_locale == 'vi')) || (($cate->slug == 'recruitment') && ($current_locale != 'vi')) )
				<li <?php if($cate->id == $category->id): ?> class="active" <?php endif; ?>>
					<a href="{{ action('SiteController@news',['slug'=>$cate->slug]) }}">{{ $cate->title }}</a>
				</li>
				@endif
				@endforeach
			</ul>
		</div>
		@endif
		<div class=" list row">
			@if(isset($checkPag) && $checkPag == TRUE)
				@foreach($posts as $data)
					<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12">
						<div class="list_item  wow">
							<a href="{{action('SiteController@hdAncuChitiet',['slug'=>$data->slug,'suffix'=>'.html'])}}" class="list_img thumbCover_60">
							@if($data->resource_id != NULL)
								<img class="img-lazy" data-src="{{$data->imageUrl($data->getImage('thumbnail'),358,215,100)}}" alt="" /> 
							@else
								@if($data->content_image != '')
									<?php 
										$url = URL::to('/').'/uploads/images/contents/'.$data->content_image;
									?>
									<img class="img-lazy" data-src="{{$data->imageUrl($url,358,215,100)}}" alt="" /> 
								@else
									<img class="img-lazy" data-src="{{$data->imageUrl($data->getImage('thumbnail'),358,215,100)}}" alt="" /> 
								@endif
							@endif
								
							</a>
							<div class="list_text">
								<a href="{{action('SiteController@hdAncuChitiet',['slug'=>$data->slug,'suffix'=>'.html'])}}" class="list_title">
									{{ stripslashes($data->title) }}xxxxxx
								</a> 
								<div class="list_position">{!! stripslashes($data->excerpt) !!}</div>
							</div>
						</div> 
					</div>
				@endforeach
			@else
				@foreach(collect($posts)->paginate( 12 ) as $data)

				<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12">
					<div class="list_item  wow">
						<a href="{{action('SiteController@news',$data->slug)}}" class="list_img thumbCover_60">
						@if($data->resource_id != NULL)
							<img class="img-lazy" data-src="{{$data->imageUrl($data->getImage('thumbnail'),358,215,100)}}" alt="" /> 
						@else
							@if($data->content_image != '')
								<?php 
									$url = URL::to('/').'/uploads/images/contents/'.$data->content_image;
								?>
								<img class="img-lazy" data-src="{{URL::to('/')}}/uploads/images/contents/{{$data->content_image }}" alt="" /> 
							@else
								<img class="img-lazy" data-src="{{$data->imageUrl($data->getImage('thumbnail'),358,215,100)}}" alt="" /> 
							@endif
						@endif
						</a>
						<div class="list_text">
							<a href="{{action('SiteController@news',$data->slug)}}" class="list_title">
								{{ stripslashes($data->title) }}
							</a> 
							<div class="list_position">{!! stripslashes($data->excerpt) !!}</div>
						</div>
					</div> 
				</div>

				@endforeach
			@endif
		</div>
		
		<div class="div-pagination ">
		@if(isset($collection ))
		{{$collection}}
		@else
		{{$posts->links()}}
		@endif
		<div>
		
	</div>	
</section>
<style>
	.list5 .list_item{border: 1px solid #ddd;}
</style>
@endsection

@push('og-meta')
	<?php
		$imagepage = URL::to('/').'/images/no-image.jpg';
		if(isset($module)){
			if($module->resource_id){
				$imagepage = $module->image;

			}else{
				if(isset($category)){
					if($category->resource_id){
						$imagepage = $category->image;
					}else{
						if(isset($posts)){
							if(count($posts)>0){
								if($posts[0]->content_image != ''){
									$imagepage = URL::to('/')."/uploads/images/contents/".$data->content_image;
								}else{
									$imagepage = $data->getImage('thumbnail');
								}
							}
						}
					}
				}
			}
		}
	?>
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
	<meta property="og:image" content="{{$imagepage}}"/>
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
	        "@id": "{{action('SiteController@news',$slugnew)}}",
	        "name": "@lang('menu.page.news')",
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