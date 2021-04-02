@extends('layouts.app')

@section('title', $module->meta_title)

@section('content')
<section class="top-page bg-white">
	
		<div id="breadcrumbs">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
		      <li><a href="">{{ $module->title }}</a></li>
		    </ul>
		</div>
		</div>
	<div class="container"> 
		<div class="page-title wow">
				<h1 class="title"> <span>{{ $module->title }}</span></h1>
		</div>
	</div>	
</section>


<section class=" list8 bg-white">
	<div class="container"> 

		<div class=" list row">
			@foreach($datas as $data)
			<div class="col-md-4 col-sm-6 ">
				<div class="list_item  wow">
					<a href="{{ action('SiteController@customerDetail',$data->slug.'.html') }}" class="list_img">
					@if($data->resource_id != NULL)
						<img class="img-lazy" data-src="{{$data->imageUrl($data->getImage('thumbnail'),60,60,100)}}" alt="" /> 
					@else
						@if($data->content_image != '')
							<?php $url = URL::to('/').'/uploads/images/contents/'.$data->content_image; ?>
							<img class="img-lazy" data-src="{{$data->imageUrl($url,60,60,100)}}" alt="" /> 
						@else
							<img class="img-lazy" data-src="{{$data->imageUrl($data->getImage('thumbnail'),60,60,100)}}" alt="" /> 
						@endif
					@endif
							
					</a>
					<span class="list_arrow"></span>
					<div class="list_text">

						<a href="{{ action('SiteController@customerDetail',$data->slug.'.html') }}" class="list_title">{{$data->title }}</a>
						<div class="list_desc">{!!$data->excerpt !!}</div>
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
	<?php
		$imagepage = URL::to('/').'/images/no-image.jpg';
		if($module->image){
			$imagepage = $module->image;
		}else{
			if(isset($datas)){
				if(count($datas)>0){
					$imagepage = $datas[0]->getImage('thumbnail');
				}
			}
		}
	?>
	@include('partials.canonical')
	<title>@if(isset($module->meta_title) && $module->meta_title != '') {{$module->meta_title}} @else {{$module->title}} @endif</title>
	<meta name="title" content="@if(isset($module->meta_title) && $module->meta_title != '') {{$module->meta_title}} @else {{$module->title}} @endif">
	<meta name="description" content="@if(isset($module->meta_desc) && $module->meta_desc != '') {{$module->meta_desc}} @else {{$module->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($module->meta_title) && $module->meta_title != '') {{$module->meta_title}} @else {{$module->title}} @endif">
	<meta property="og:description" content="@if(isset($module->meta_desc) && $module->meta_desc != '') {{$module->meta_desc}} @else {{$module->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($module->meta_desc) && $module->meta_title != '') {{$module->meta_desc}} @else {{$module->excerpt}} @endif">
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
	        "@id": "{{ Request::url() }}",
	        "name": "{{ $module->title }}",
	        "image": ""
	      }
	    }
	    ]
	  }
	</script>
@endpush