
@extends('layouts.app')
@if($lifemodule)
@section('title', $lifemodule->meta_title)
@endif
@section('content')
<section class="top-page bg-white">
	<div id="breadcrumbs">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
		      <?php 
		      	$slugnew = ($current_locale == 'en') ? 'us-news' : 'tin-tuc-my';
		      ?>
		      <li><a href="{{action('SiteController@news',$slugnew)}}">@lang('menu.page.news')</a></li>
		      @if($lifemodule)
		      <li><a href="{{action('SiteController@life',['slug'=>''])}}">{{$lifemodule->title}}</a></li>
		      @endif
		      @if($lifeCategory)
		      	@if(($lifeCategory->slug != 'vietnamese-pride-in-the-us') && ($lifeCategory->slug != 'cuoc-song-nguoi-viet-tai-my'))
		      	<li>{{$lifeCategory->title}}</li>
		      	@endif
		      @endif
		    </ul>
		</div>
		</div>
	<div class="container"> 
		<div class="page-title wow">
				<h1 class="title"> <span>{{$lifeCategory->title}}</span></h1>
		</div>
	</div>	
</section>


<section class="  bg-white">
	<div class="container"> 
		<div class="menu-content">
			<ul>
				@foreach($categories as $cate)
				@if((($cate->slug !='tuyen-dung') && ($current_locale == 'vi')) || (($cate->slug != 'recruitment') && ($current_locale != 'vi')) )
				<li>
					<a href="{{ action('SiteController@news',['slug'=>$cate->slug]) }}">{{ $cate->title }}</a>
				</li>
				@endif
				@endforeach
				@if($lifemodule)
				<li class="active"><a href="{{ action('SiteController@life',['slug'=>'']) }}">{{ $lifemodule->title }}</a></li>
				@endif
				<li><a href="{{ action('SiteController@laws') }}">{{ $luatdichu->title }}</a></li> 
				@if($huongdan)
				<li><a href="{{ action('SiteController@huongdandinhcu') }}">{{ $huongdan->title }}</a></li>
				@endif
				@foreach($categories as $cate)
				@if((($cate->slug =='tuyen-dung') && ($current_locale == 'vi')) || (($cate->slug == 'recruitment') && ($current_locale != 'vi')) )
				<li>
					<a href="{{ action('SiteController@news',['slug'=>$cate->slug]) }}">{{ $cate->title }}</a>
				</li>
				@endif
				@endforeach
			</ul>

		</div>
		<div class="row">
			<div class="col-sm-8 list5">
				<div class=" list row">
					@foreach($datas as $data)
					<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12">
						<div class="list_item  wow">
							<a href="{{action('SiteController@life',$data->getSlug())}}" class="list_img thumbCover_60">
								@if($data->resource_id != NULL)
									<img class="img-lazy" data-src="{{$data->imageUrl($data->getImage('thumbnail'),230,138,100)}}" alt="" /> 
								@else

									@if($data->content_image != '')
										<?php
											$urlimg = URL::to('/').'/uploads/images/contents/'.$data->content_image;
										?>
										<img class="img-lazy" data-src="{{$data->imageUrl($urlimg,230,138,100)}}" alt="" /> 
									@else
										<img class="img-lazy" data-src="{{$data->imageUrl($data->getImage('thumbnail'),230,138,100)}}" alt="" /> 
									@endif
								@endif
							</a>
							<div class="list_text">
								<a href="{{action('SiteController@lifeDetail',['slug'=>$data->getSlug(),'suffix'=>'.html'])}}" class="list_title">
									@if(isset($data->title))
									{{ stripslashes($data->title) }}
									@endif
								</a> 
								<div class="list_position">{!! stripslashes($data->excerpt) !!}</div>
							</div>
						</div> 
					</div>
					@endforeach
				</div>
			</div>
			<div class="col-sm-4 sidebar">
				<div class="widget widget-american wow">
					<h3 class="widget-title">@lang('page.category')</h3>
					<div class="widget-content">
						<ul class="menu">
							@foreach($lifeCategories as $lifecate)
							<li <?php if($lifecate->id == $lifeCategory->id): ?> class="active" <?php endif; ?>><a href="{{ action('SiteController@life',['slug'=>$lifecate->slug]) }}">{{$lifecate->title}}</a></li>
							@endforeach
						</ul>			
					</div>
				</div> <!--End widget-->

				<div class="widget widget-hotnews wow">
					<h3 class="widget-title">@lang('page.hot_news')</h3>
					<div class="widget-content">
						<div class="list7">
							<div class="list">
								@foreach($hots as $hot)
									<a href="{{action('SiteController@lifeDetail',['slug'=>$hot->slug,'suffix'=>'.html'])}}"  class="list_item ">
										<span   class="list_img thumbCover_60">
											<img class="img-lazy" data-src="/images/img-10.jpg" alt="" />
										</span>
										<span  class="list_title">{{ $hot->title }}</span>
									</a> 
								<!--End item-->
								@endforeach
							</div>
						</div>
						<a href="#" class="viewall">@lang('page.view_all')</a>
					</div>
				</div> <!--End widget-->

			</div>

		</div>

		@if($datas->lastPage() > 1)
		<div class="div-pagination ">
            {{ $datas->links() }}
        </div>
        @endif

	</div>	
</section>

@endsection

@if($lifeCategory)
@push('og-meta')
@include('partials.canonical')
	<title>@if(isset($lifeCategory->meta_title) && $lifeCategory->meta_title != '') {{strip_tags($lifeCategory->meta_title)}} @else {{strip_tags($lifeCategory->title)}} @endif</title>
	<meta name="title" content="@if(isset($lifeCategory->meta_title) && $lifeCategory->meta_title != '') {{strip_tags($lifeCategory->meta_title)}} @else {{$lifeCategory->title}} @endif">
	<meta name="description" content="@if(isset($lifeCategory->meta_desc) && $lifeCategory->meta_desc != '') {{$lifeCategory->meta_desc}} @else {{$lifeCategory->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($lifeCategory->meta_title) && $lifeCategory->meta_title != '') {{strip_tags($lifeCategory->meta_title)}} @else {{$lifeCategory->title}} @endif">
	<meta property="og:description" content="@if(isset($lifeCategory->meta_desc) && $lifeCategory->meta_desc != '') {{$lifeCategory->meta_desc}} @else {{$lifeCategory->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($lifeCategory->meta_title) && $lifeCategory->meta_title != '') {{strip_tags($lifeCategory->meta_title)}} @else {{$lifeCategory->title}} @endif">
	<meta property="og:type"   content="article" /> 
	<?php 
		if($lifeCategory->resource_id){
			$imagemeta = $lifeCategory->getImage('full');
		}else{
			if(count($datas)>0){
				if($datas[0]->content_image != ''){
					$imagemeta = URL::to('/').'/uploads/images/contents/'.$datas[0]->content_image;			
				}else{
					$imagemeta = $datas[0]->getImage('thumbnail');
				}
			}else{
				$imagemeta = $lifeCategory->getImage('full');
			}
			
		}
	?>
	<meta property="og:image" content="{{$imagemeta}}"/>
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
	        "name": "{{ $lifemodule->title }}",
	        "image": ""
	      }
	    }
	    ]
	  }
	</script>
@endpush
@endif