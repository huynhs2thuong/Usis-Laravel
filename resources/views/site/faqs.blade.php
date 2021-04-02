@extends('layouts.app')

@section('title', $category->meta_title)

@section('content')
<section class="top-page bg-white">
	 
		<div id="breadcrumbs">
			<div class="container">
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
		      <li>{{$module->title}}</li>
		    </ul>
		</div>
		</div>
	<div class="container">
		<div class="page-title wow">
				<h1 class="title"> <span>{{$category->title}}</span></h1>
		</div>
	</div>	
</section>


<section class="  bg-white">
	<div class="container"> 
		<div class="row">
			<div class="col-sm-4 sidebar">
				<div class="widget widget-american">
					<h3 class="widget-title uppercase">@lang('page.faqs_category')</h3>
					<div class="widget-content">
						<ul class="menu">
							@foreach($categories as $cate)
							<li <?php if($cate->id == $category->id): ?> class="active" <?php endif; ?>>
								<a href="{{ action('SiteController@faqs',['slug'=>$cate->slug]) }}">{{ $cate->title }}</a>
							</li>
							@endforeach
						</ul>			
					</div>
				</div> <!--End widget-->
			</div>

			<div class="col-sm-8">
				<div class=" list-faqs" id="accordion" role="tablist" aria-multiselectable="true">
				@foreach($datas as $key => $data)
				  	<div class="panel  wow">
					    <div class="panel-title" role="tab" id="heading{{$key}}">
					        <a <?php if($key>0): ?> class="collapsed"  <?php endif; ?> 
					        	role="button" 
					        	data-toggle="collapse" 
					        	data-parent="#accordion" 
					        	href="#faq-{{$key}}" 
					        	aria-expanded="<?php echo $key == 0 ? 'true' : 'false' ?>" aria-controls="faq-{{$key}}">
					          	{{$key+1}}. {{ $data->title }} 
					        </a>
					    </div>
					    <div id="faq-{{$key}}" 
					    	class="panel-collapse collapse <?php echo $key == 0 ? 'in' : null;?>" 
					    	role="tabpanel" 
					    	aria-labelledby="heading{{$key}}"
				    	>
					      	<div class="panel-body">
					        	{!! stripslashes($data->description) !!}
					      	</div>
					    </div>
				  	</div>
				@endforeach
				</div>
			</div>


		</div>
	</div>	
</section>

@endsection
@if($page)
@push('og-meta')
@include('partials.canonical')
	<title>@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->title}} @endif</title>
	<meta name="title" content="@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->title}} @endif">
	<meta name="description" content="@if(isset($page->meta_desc) && $page->meta_desc != '') {{$page->meta_desc}} @else {{$page->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->excerpt}} @endif">
	<meta property="og:description" content="@if(isset($page->meta_desc) && $page->meta_desc != '') {{$page->meta_desc}} @else {{$page->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->title}} @endif">
	<meta property="og:type"   content="article" /> 
	<meta property="og:image" content="@if($page->resource_id) {{$page->getImage('full')}} @else <?php echo URL::to('/').'/images/no-image.jpg';?> @endif"/>
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
@endif