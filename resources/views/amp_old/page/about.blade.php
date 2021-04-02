@extends('layouts.amp')
@push('styleinline')
.u008 .input {height: 57px;border: 1px solid #C8C8C8;border-radius: 4px;background-color: #FFFFFF;}h1.title{text-transform:uppercase}.row-label .input{width:100%}.list9 .list_text {padding: 10px;}.list9 .list_item{background:#fff;position: relative;-webkit-box-shadow: 0 4px 8px 0 rgba(129, 129, 129, 0.5);box-shadow: 0 4px 8px 0 rgba(129, 129, 129, 0.5);margin-bottom: 30px;}
@endpush
@section('title', $page->title)

@section('content')
	@if($page->slug == 'lien-he' || $page->slug =='contact')
	<section class="top-page bg-white">
		
			@include('partials.breadcrumb')
		<div class="container"> 
			<div class="page-title wow">
				<h1 class="title">
					<span>
						@lang('menu.page.contactus')
					</span>
				</h1>
			</div>
		</div>
	</section>
	<section class="u008 bg-white statue-of-liberty">
		<div class="container"> 
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					@if($form)
					<?php 
		            $content = preg_replace('/style=[^>]*/', '', $form->description);
		            $content = preg_replace('/<script(.*?)\/?>/', '', $content);
		            $content = str_replace('</script>', '', $content);
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
					@endif
				</div>
			</div>
		</div>	
	</section>
	@else
	<section class="top-page bg-white">
		
		@include('partials.breadcrumb')
		<div class="container">
			<div class="page-title wow">
					<h1 class="title"> <span>{{$page->title}}</span></h1>
			</div>
		</div>
	</section>
	@endif
	@if(isset($page->amp_content) && $page->amp_content != '')
		{!! $page->amp_content !!}
	@else
		<?php 
	    $content = preg_replace('/style=[^>]*/', '', $page->description);
	    $content1 = preg_replace('/<img .*? data-src="([^"]*)" .*?>/', '<amp-img src="$1" width="40" height="40" layout="fixed"></amp-img>',$content);
	    $html = preg_replace('/<img(.*?)\/?>/', '<amp-img$1 width="40" height="40" alt="AMP" layout="fixed"></amp-img>',$content1);
	    $regex=  '#<iframe(.*?)\/?>(.*?)</iframe>#';
	    preg_match($regex, $html, $matches);
	    if (preg_match($regex, $html, $matches)){
	      if(preg_match('/src="([^"]+)"/', $matches[1], $returnurl)){
	        $codearr = explode('/', end($returnurl));
	        $html = preg_replace('/<iframe(.*?)\/?>/', '<amp-iframe src="'.$returnurl[1].'" width="600" height="321" layout="responsive" sandbox="allow-scripts allow-same-origin" ></amp-iframe>',$content1);
	      }
	    }
	    ?>
		{!! $html !!}
	@endif
	
	@if($page->slug == 'lien-he' || $page->slug =='contact')
	@else
	<!-- //đói tác chiến lược -->
	<section class="u003 row-section  bg-white wow"  >
	<div class="container">
		<div class="section-header">
			<h2 class="section-title"> <a href="{{action('AmpController@showPage',['slug'=>'doi-tac'])}}">@lang('menu.page.partner_strategy') </a></h2>
		</div>
		@include('partials.amp.partner')
	</div>
	</section>

	<section class="list8 row-section wow">
		<div class="container">
			<div class="section-header">
				<h2 class="section-title">
					<a href="{{route('customeramp')}}">
						@lang('menu.page.customer_success')
					</a>
				</h2>
			</div>
			<div class="list row">
				@foreach ($customer as $cust)
				<div class="col-md-4 col-sm-6 ">
					<div class="list_item ">
						<a class="list_img" href="{{ action('AmpController@customerDetail',['slug'=>$cust->getSlug()]) }}">

							@if($cust->content_image)
								<amp-img src="/uploads/images/contents/{{$cust->content_image}}" width="60" height="60" alt=""></amp-img>
							@else
								<amp-img src="{{$cust->getImage('thumbnail')}}" width="60" height="60" alt=""></amp-img> 
							@endif
						</a> 
						<span class="list_arrow">
							
						</span>
						<div class="list_text">
							<a class="list_title" href="{{ action('AmpController@customerDetail',['slug'=>$cust->getSlug()]) }}">
								{{$cust->title }} 
							</a>
							<div class="list_desc">{!!$cust->excerpt !!}</div>
						</div>
					</div>
				</div><!--End item-->
				@endforeach
			</div>
		</div>
	</section>
	@endif
@endsection

@push('og-meta')
@include('partials.canonical')
	<title>@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->title}} @endif</title>
	<meta name="title" content="@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->title}} @endif">
	<meta name="description" content="@if(isset($page->meta_desc) && $page->meta_desc != '') {{$page->meta_desc}} @else {{$page->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->title}} @endif">
	<meta property="og:description" content="@if(isset($page->meta_desc) && $page->meta_desc != '') {{$page->meta_desc}} @else {{$page->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($page->meta_desc) && $page->meta_title != '') {{$page->meta_desc}} @else {{$page->excerpt}} @endif">
	<meta property="og:type"   content="article" /> 
	<meta property="og:image" content="@if($page->resource_id) {{$page->image}} @else <?php echo URL::to('/').'/images/no-image.jpg';?> @endif"/>
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
	        "@id": "{{Request::url()}}",
	        "name": "{{ $page->title }}",
	        "image": ""
	      }
	    }
	    ]
	  }
	</script>
@endpush