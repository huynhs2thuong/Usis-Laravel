
@extends('layouts.amp')

@section('title', $customer->meta_title)

@section('content')
<section class="top-page bg-white">
		<div id="breadcrumbs">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/amp' : '/en/amp' }}">@lang('menu.page.home') </a></li>
		      @if(isset($secPage))
		      	<li>
				<a href="{{action('AmpController@showPageDichVu',$secPage->slug)}}">{{$secPage->title}}</a>
			</li>
		      @endif
		      @if(isset($thiPage))
				<li>
					<a href="{{action('AmpController@level3Dichvu',['>slug'=>$secPage->slug,'permalink'=>$thiPage->slug])}}">{{$thiPage->title}}</a>
				</li>
				@endif
		      <li><a href="{{ action('AmpController@customer') }}">{{ $customer->title }}</a></li>
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
					<amp-img src="{{$customer->getImage()}}" width="345" height="262" layout="responsive">
				</div>
				@if($customer->video_url)
				<div class="videoTubte thumbCover_16_9">
					<?php echo $customer->video_url ?>
				</div>
				<p class="text-center">Video khách hàng đang chia sẻ</p>
				@endif
				<?php 
				$getcontent = stripslashes($customer->description);
	            $content = preg_replace('/style=[^>]*/', '', $getcontent);
	            $content1 = preg_replace('/<img .*? data-src="([^"]*)" .*?>/', '<amp-img src="$1" width="472" height="400"></amp-img>',$content);
	            $html = preg_replace('/<img(.*?)\/?>/', '<amp-img$1 width="472" height="400" alt="AMP"></amp-img>',$content1);
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