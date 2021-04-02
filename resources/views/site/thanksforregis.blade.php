@extends('layouts.app')
@section('content')
<section class="post-detail  bg-white">
	<div id="breadcrumbs">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
		      <li><a href="">@lang('menu.page.thankstitle')</a></li>
		    </ul>
		</div>
	</div>
	<div class="container"> 
		<div class="page-title wow">
				<h1 class="title"> <span>@lang('menu.page.thankstitle')</span></h1>
		</div>
	</div>	
<div class="container">

	<p>@lang('menu.page.thanks1')</p>

	<p>@lang('menu.page.thanks2')</p>

	<p>@lang('menu.page.thanks3')</p>

	<p>@lang('menu.page.thanks4')</p>
</div>
</section>
@endsection

@push('og-meta')
@include('partials.canonical')
	<title>@lang('menu.page.thankstitle')</title>
	<meta name="description" content="Cảm ơn Anh/Chị đã quan tâm và tín nhiệm USIS Group" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@lang('menu.page.thankstitle')">
	<meta property="og:description" content="Cảm ơn Anh/Chị đã quan tâm và tín nhiệm USIS Group">
	<meta property="og:site_name" content="@lang('menu.page.thankstitle')">
	<meta property="og:type"   content="article" /> 
@endpush