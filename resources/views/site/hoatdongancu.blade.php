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
		      <li><a href="{{ Request::url() }}">{{$category->title}}</a></li>
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
		<div class=" list row">
			@foreach($posts as $data)
				<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12">
					<div class="list_item  wow">
						<a href="{{action('SiteController@dtAncuChitiet',['slug'=>$secPage->slug,'permalink'=>$category->slug,'partners'=>$data->slug])}}" class="list_img thumbCover_60">
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
							<a href="{{action('SiteController@dtAncuChitiet',['slug'=>$secPage->slug,'permalink'=>$category->slug,'partners'=>$data->slug])}}" class="list_title">
								{{ stripslashes($data->title) }}
							</a> 
							<div class="list_position">{{ stripslashes($data->excerpt) }}</div>
						</div>
					</div> 
				</div>
			@endforeach
		</div>
		
		<div class="div-pagination ">
		{{$posts->links()}}
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
									$imagepage = "{{URL::to('/')}}/uploads/images/contents/".$data->content_image;
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
	<title>@if(isset($category->meta_title) && $category->meta_title != '') {{$category->meta_title}} @else {{$category->title}} @endif</title>
	<meta name="title" content="@if(isset($category->meta_title) && $category->meta_title != '') {{$category->meta_title}} @else {{$category->title}} @endif">
	<meta name="description" content="@if(isset($category->meta_desc) && $category->meta_desc != '') {{$category->meta_desc}} @else {{$category->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($category->meta_title) && $category->meta_title != '') {{$category->meta_title}} @else {{$category->title}} @endif">
	<meta property="og:description" content="@if(isset($category->meta_desc) && $category->meta_desc != '') {{$category->meta_desc}} @else {{$category->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($category->meta_desc) && $category->meta_title != '') {{$category->meta_desc}} @else {{$category->excerpt}} @endif">
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
	        "@id": "{{action('SiteController@showPageDichVu',$secPage->slug)}}",
	        "name": "{{ $secPage->title }}",
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