@extends('layouts.app')

@section('title', $category->title)

@section('content')

<section class="top-page bg-white">
	
		<div id="breadcrumbs">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
		      <li><a href="{{ action('SiteController@projects') }}">@if($category){{$category->title}}@else @lang('menu.page.home') @endif</a></li>
		    </ul>
		</div>
		</div>
	<div class="container"> 
		<div class="page-title wow">
				<h1 class="title"> <span>@if($category){{$category->title}}@else @lang('menu.page.home') @endif</span></h1>
				<div class="desc"><span>@if($category){{$category->canonical}}@else @lang('menu.page.home') @endif</span>
		</div>
	</div>	
</section>

<a name="du_an_da_het_suat"></a>
<section class="u012 row-section list6 wow ">
	<div class="container"> 
		
		<div class=" list row">
		
			@foreach($datas as $data)
			<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12">
				<div class="list_item  wow">
					<a href="{{ action('SiteController@showPageDuAn',$data->slug) }}" class="list_img thumbCover_75">
						<img class="img-lazy" data-src="{{$data->getImage('thumbnail')}}" alt="" />
					</a>
					<div class="list_text">
						<a href="{{ action('SiteController@showPageDuAn',$data->slug) }}" class="list_title">{{ $data->title }}</a>
						<div class="list_position">
						<?php 
		                	$string = strip_tags( $data->excerpt);
							if (strlen($string) > 10) {

							    // truncate string
							    $stringCut = substr($string, 0, 80);
							    $endPoint = strrpos($stringCut, ' ');

							    //if the string doesn't contain any space then it will cut without word basis.
							    $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
							    $string .= '...';
							}
							echo $string;
		                	?>
						</div>
						<div class="list_position"><span class="icon icon-xs mdi mdi-navigation text-middle text-primary"></span>
							<span class="text-middle text-primary ">@if($data->render == 0 ) @lang('menu.page.current_projects') @else @lang('menu.page.fully_subscribed')  @endif</span>
						</div>
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
@push('styles')
<style type="text/css">
	.slide6-arr.owl-carousel .owl-dots{text-align: center;bottom: 0;width: 100%;padding: 10px 0;position: absolute;}
	.slide6-arr.owl-carousel .owl-dots>div span{background: #fff}

</style>
@endpush
@push('og-meta')
	<?php
		$imagepage = URL::to('/').'/images/no-image.jpg';
		if($module->resource_id){
			$imagepage = $module->image;
		}else{
			if(isset($datas_top)){
				if(count($datas_top)>0){
					$imagepage = $datas_top[0]->getImage('thumbnail');
				}
			}
		}
	?>
	@include('partials.canonical')
	<title>@if(isset($category->meta_title) && $category->meta_title != '') {{strip_tags($category->meta_title)}} @else {{$module->meta_title}} @endif</title>
	<meta name="title" content="@if(isset($category->meta_title) && $category->meta_title != '') {{strip_tags($category->meta_title)}} @else {{$module->meta_title}} @endif">
	<meta name="description" content="@if(isset($module->meta_desc) && $module->meta_desc != '') {{$module->meta_desc}} @else {{$module->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($category->meta_title) && $category->meta_title != '') {{strip_tags($category->meta_title)}} @else {{$module->meta_title}} @endif">
	<meta property="og:description" content="@if(isset($module->meta_desc) && $module->meta_desc != '') {{$module->meta_desc}} @else {{$module->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($module->meta_desc) && $category->meta_title != '') {{strip_tags($category->meta_title)}} @else {{$module->excerpt}} @endif">
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
	        "name": "Home"
	      }
	    },{
	      "@type": "ListItem",
	      "position": 2,
	      "item": {
	        "@id": "{{ Request::url() }}",
	        "name": "{{ $module->meta_title }}"
	      }
	    }
	    ]
	  }
	</script>
@endpush