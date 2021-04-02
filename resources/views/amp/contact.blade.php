@extends('layouts.amp')

@section('title', $post->meta_title)

@section('content')
<section class="top-page bg-white">
		<div id="breadcrumbs" style="margin-bottom: 0">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/amp' : '/en/amp' }}">@lang('menu.page.home') </a></li>
		      <li><a href="{{Request::url()}}">@lang('menu.page.contact')</a></li>
		    </ul>
		    </div>	
		</div>

	
</section>


<section class="post-detail  bg-white">
	<div class="container"> 
		<div class="row">
		<div class="col-sm-8">
			<div class="page-title wow">
				<h1 class="title"> <span>@lang('page.contact')</span></h1>
			</div>				
			<div class="entry-content text_center mb30">
				<a class="sendcontactbutton" href="{{URL::to('/')}}/lien-he">@lang('page.sendcontact')</a>
			</div>
		</div>

	</div>
</section>
@endsection
@push('og-meta')
@include('partials.canonical')
	<title>@if(isset($post->meta_title) && $post->meta_title != '') {{$post->meta_title}} @else {{$post->title}} @endif</title>
	<meta name="title" content="@if(isset($post->meta_title) && $post->meta_title != '') {{$post->meta_title}} @else {{$post->title}} @endif">
	<meta name="description" content="@if(isset($post->meta_desc) && $post->meta_desc != '') {{$post->meta_desc}} @else {{$post->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($post->meta_title) && $post->meta_title != '') {{$post->meta_title}} @else {{$post->title}} @endif">
	<meta property="og:description" content="@if(isset($post->meta_desc) && $post->meta_desc != '') {{$post->meta_desc}} @else {{$post->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($post->meta_desc) && $post->meta_title != '') {{$post->meta_desc}} @else {{$post->excerpt}} @endif">
	<meta property="og:type"   content="article" /> 
	<meta property="og:image" content="@if($post->content_image != '') https://www.usis.us/uploads/images/contents/{{$post->content_image }} @else{{$post->image}}@endif"/>
@endpush