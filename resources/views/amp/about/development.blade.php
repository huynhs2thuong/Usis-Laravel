@extends('layouts.app')
@section('title', $page->title)
@section('content')
	<div id="breadcrumbs">
		<div class="container"> 
			<ul class="breadcrumb">
				<li><a href="/@lang('menu.url.home')">@lang('menu.page.home')</a></li>
				<li><a href="{{action('AboutController@index')}}">@lang('admin.object.introduction')</a></li>
				<li><span>{!! $page->title !!}</span></li>
			</ul>
		</div>
	</div>
	{!! $page->description !!}
	@foreach($datas as $data)
		@if( count($data->posts) > 0)
		<div class="gallery mb-50">
			<div class="slide owl-carousel owl-theme">
				@foreach($data->posts as $key => $post)
					<?php $numberDev = count($data->posts); ?>
					<div class="slide_item">
						<a class="item" href="{{ action('SiteController@newsDetail',['slug' => $data->slug, 'slug_post' => $post->slug ]) }}" title="{{$post->title}}">
							<img src="{{$post->getImage('full')}}">
							<h2 class="title">{{$post->title}}</h2>
						</a>
						<div class="caption">
							<p>{{$post->excerpt}}</p>
							<div class="caption_share">

								@if($key < ($numberDev-1))
								<span><a class="item" style="height: 30px" href="{{ action('SiteController@newsDetail',['slug' => $data->slug, 'slug_post' => $data->posts[$key+1]->slug ]) }}" title="{{$data->posts[$key+1]->title}}""><i class="fa fa-share-square-o" aria-hidden="true"></i>{{$data->posts[$key+1]->title}}</a></span>
								@endif

								@if($key < ($numberDev-2))
								<span><a class="item" style="height: 30px" href="{{ action('SiteController@newsDetail',['slug' => $data->slug, 'slug_post' => $data->posts[$key+1]->slug ]) }}" title="{{$data->posts[$key+1]->title}}""><i class="fa fa-share-square-o" aria-hidden="true"></i>{{$data->posts[$key+2]->title}}</a></span>
								@endif

							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
		@endif	
	@endforeach

@endsection

@push('styles')
    <style type="text/css">
        .gallery .slide .item img {
            width: auto;
    		height: auto;
        }
        .gallery .slide .item{
        	overflow: hidden;
        	height: 500px
        }
        .rotate-left{ transform: scaleX(-1); margin-right: 5px; }
    </style>
@endpush