@extends('layouts.amp')
@push('styleinline')
.list4 .list_title{color:#fff}.row.list>div:first-child{margin-top:0}.page-title .desc{max-width: 600px;margin: 20px auto 0;}p{margin:0}.top-page{padding-bottom:20px}.thumbCover_90:before {padding-top: 90%;}
@endpush
@section('title', $module->meta_title)

@section('content')

<section class="top-page bg-white">
	
		<div id="breadcrumbs">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/amp' : '/en/amp' }}">@lang('menu.page.home') </a></li>
		      <li><a href="{{ action('AmpController@projects') }}">{{ $module->title }}</a></li>
		    </ul>
		</div>
		</div>
	<div class="container"> 
		<div class="page-title wow">
				<h1 class="title"> <span>{{ $module->title }}</span></h1>
				<div class="desc">{{$module->meta_desc}}</p>
		</div>
	</div>	
</section>

<section class="list4 bg-white wow">
		<div class="section-header">
			<h2 class="section-title"> @lang('page.current_project') </h2>
			<i class="icon-star3"></i>
		</div>
			<amp-carousel width="502" height="452" layout="responsive" type="slides">
			@foreach($datas_top as $data)
			<?php $img = $data->resource_id ? $data->getImage('thumbnail') : '/images/no-image.jpg' ?>
			<div class="">
				<a href="{{ action('AmpController@projectDetail',$data->getSlug()) }}" class="list_item ">
					<div class="list_img thumbCover_90">
						<amp-img src="{{$data->getImage('thumbnail')}}" alt="" width="502" height="425" layout="responsive" />
					</div>
					<div class="list_text">
						<div class="list_title">{{ $data->title }}</div>
						<div class="list_position">{{ $data->address }} &nbsp;</div>
					</div>
				</a> 
			</div>
			@endforeach
			</amp-carousel>
</section>
<a name="du_an_da_het_suat"></a>
<section class="u012 row-section list6 wow ">
	<div class="container"> 
		<div class="section-header">
			<h2 class="section-title"> @lang('page.fully_subscribed')</h2>
			<i class="icon-star3"></i>
		</div>
		<div class=" list row">
		
			@foreach($datas as $data)
			<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12">
				<div class="list_item  wow">
					<a href="{{ action('AmpController@projectDetail',$data->getSlug()) }}" class="list_img thumbCover_75">
						<amp-img src="{{$data->getImage('thumbnail')}}" alt="" width="221" height="166" layout="responsive" />
					</a>
					<div class="list_text">
						<a href="{{ action('AmpController@projectDetail',$data->slug) }}" class="list_title">{{ $data->title }}</a>
						<div class="list_position"></div>
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
	<title>@if(isset($module->meta_title) && $module->meta_title != '') {{strip_tags($module->meta_title)}} @else {{$module->title}} @endif</title>
	<meta name="title" content="@if(isset($module->meta_title) && $module->meta_title != '') {{strip_tags($module->meta_title)}} @else {{$module->title}} @endif">
	<meta name="description" content="@if(isset($module->meta_desc) && $module->meta_desc != '') {{$module->meta_desc}} @else {{$module->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($module->meta_title) && $module->meta_title != '') {{strip_tags($module->meta_title)}} @else {{$module->title}} @endif">
	<meta property="og:description" content="@if(isset($module->meta_desc) && $module->meta_desc != '') {{$module->meta_desc}} @else {{$module->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($module->meta_desc) && $module->meta_title != '') {{strip_tags($module->meta_title)}} @else {{$module->excerpt}} @endif">
	<meta property="og:type"   content="article" /> 
	<meta property="og:image" content="{{$imagepage}}"/>
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
	        "name": "{{ $module->title }}"
	      }
	    }
	    ]
	  }
	</script>
@endpush