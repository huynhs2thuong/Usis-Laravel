
@extends('layouts.app')

@section('content')
<section class="top-page bg-white">
	<div id="breadcrumbs">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
		      <li><a href="{{action('SiteController@life',['slug'=>''])}}">{{$tag->name}}</a></li>

		    </ul>
		</div>
		</div>
	<div class="container"> 
		<div class="page-title wow">
				<h1 class="title"> <span>@lang('menu.tag'): {{$tag->name}}</span></h1>
		</div>
	</div>	
</section>


<section class="  bg-white">
	<div class="container"> 
		<div class="row">
			<div class="col-sm-12 list5">
				<div class=" list row">
					@foreach($posts as $data)
					<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12">
						<div class="list_item  wow">
							<?php 
								$check = $data->getLinkUrl();
								$check1 = $data->getLinkUrl1();
								switch($check){
									case 'tin-tuc':
										$action = action('SiteController@news',$data->slug);
									break;
									case 'news':
										$action = action('SiteController@news',$data->slug);
									break;
									case 'cuoc-song-tai-my':
										$action = action('SiteController@life',$data->slug);
									break;
									case 'life-in-america':
										$action = action('SiteController@life',$data->slug);
									break;
									case 'luat-di-tru':
										$action = action('SiteController@lawsDetail',$data->slug);
									break;
									case 'immigration-law':
										$action = action('SiteController@lawsDetail',$data->slug);
									break;
									case 'huong-dan-dinh-cu-hoa-ky':
										$action = action('SiteController@hddcDetail',$data->slug);
									break;
									case 'u.s.-immigrants-guidebook':
										$action = action('SiteController@hddcDetail',$data->slug);
									break;
									case 'su-kien':
										$action = action('SiteController@events',$data->slug);
									break;
									case 'events':
										$action = action('SiteController@events',$data->slug);
									break;
									default:
										if($check1 == 'hoat-dong-an-cu' || $check1 == 'activities'){
											$path3 = $data->slug;
											if($current_locale == 'en'){
												$path1 = 'us-settlement-service';
												$path2 = 'activities';
											}else{
												$path1 = 'dich-vu-an-cu-my';
												$path2 = 'hoat-dong-an-cu';
											}
											$action = action('SiteController@dtAncuChitiet',["slug"=>$path1,"permalink"=>$path2,"partner"=>$path3]);
										}else{
											$action = action('SiteController@news',$data->slug);
										}
									break;
								}
							?>
							<a href="{{$action}}" class="list_img thumbCover_60">
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
								<a href="{{$action}}" class="list_title">
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
		</div>

		@if($posts->lastPage() > 1)
		<div class="div-pagination ">
            {{ $posts->links() }}
        </div>
        @endif

	</div>	
</section>

@endsection

@push('og-meta')
@include('partials.canonical')
	<title>{{$tag->name}}</title>
	<meta name="title" content="{{$tag->name}}">
	<meta name="description" content="" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="{{$tag->name}}">
	<meta property="og:description" content="">
	<meta property="og:site_name" content="{{$tag->name}}">
	<meta property="og:type"   content="article" /> 
	<meta property="og:image" content=""/>
	@include('partials.linklanguage')
@endpush