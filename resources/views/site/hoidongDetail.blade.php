
@extends('layouts.app')

@section('title', $customer->meta_title)

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
		      @if(isset($thiPage))
				<li>
					<a href="{{action('SiteController@level3Dichvu',['>slug'=>$secPage->slug,'permalink'=>$thiPage->slug])}}">{{$thiPage->title}}</a>
				</li>
				@endif
		      <li><a href="{{ action('SiteController@customer') }}">{{ $customer->title }}</a></li>
		    </ul>
		</div>
		</div>
	<div class="container"> 
		<div class="page-title wow">
				<h1 class="title"> <span>{{ $customer->title }}</span></h1>
		</div>
	</div>	
</section>

<section class="pb-70 bg-white wow">
	<div class="container"> 
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="thumbnail-hoidong">
					<img src="{{$customer->getImage()}}">
				</div>
				@if($customer->video_url)
				<div class="videoTubte thumbCover_16_9">
					<?php echo $customer->video_url ?>
				</div>
				<p class="text-center">Video khách hàng đang chia sẻ</p>
				@endif
				{!! stripslashes($customer->description) !!}
			</div>
		</div>
	</div>	
</section>
@endsection
@push('scripts')
<style>
	.thumbnail-hoidong{text-align: center;padding: 10px 0 30px;}
</style>
@endpush

@push('og-meta')
@include('partials.canonical')
	<title>@if(isset($customer->meta_title) && $customer->meta_title != '') {{$customer->meta_title}} @else {{$customer->title}} @endif</title>
	<meta name="title" content="@if(isset($customer->meta_title) && $customer->meta_title != '') {{$customer->meta_title}} @else {{$customer->title}} @endif">
	<meta name="description" content="@if(isset($customer->meta_desc) && $customer->meta_desc != '') {{$customer->meta_desc}} @else {{$customer->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($customer->meta_title) && $customer->meta_title != '') {{$customer->meta_title}} @else {{$customer->title}} @endif">
	<meta property="og:description" content="@if(isset($customer->meta_desc) && $customer->meta_desc != '') {{$customer->meta_desc}} @else {{$customer->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($customer->meta_desc) && $customer->meta_title != '') {{$customer->meta_desc}} @else {{$customer->excerpt}} @endif">
	<meta property="og:type"   content="article" /> 
	<meta property="og:image" content="@if($customer->content_image != '') {{URL::to('/')}}/uploads/images/contents/{{$customer->content_image }} @else{{$customer->image}}@endif"/>
	@include('partials.linklanguage')
@endpush