@extends('layouts.amp')
@push('styleinline')
.u015 {background:url('{{$page->image}}');background-position:center}.u016 .thumbCover_43.bg-lazy {background:url('/images/img-25.jpg')}.grid-space-40>div.col-sm-6:last-child{margin-bottom:0}.u019 .item .desc,.u019 .item .position{white-space: initial;}.u019 .law{padding:0}amp-carousel div.item{margin:0}amp-carousel div.item div.text div.desc {padding:0 10px}
@endpush
@section('title', $page->title)

@section('content')
	<section class="u015  bg-lazy thumbCover_66">
		<div class="text">
			<div class="inner">
				{!! $page->excerpt !!}
			</div>
		</div>
	</section>
<?php 
$content = preg_replace('/style=[^>]*/', '', $page->description);
$html = preg_replace('/<img(.*?)\/?>/', '<amp-img$1 width="375" height="240" layout="responsive" alt="AMP"></amp-img>',$content);
?>
    {!! $html !!}
    @if(count($hoidong)>0)
	<section class="u019  row-section    wow bg-white pb-0" >
	
		<div class="container">

			<div class="section-header" ><h2 class="section-title">@lang('menu.page.ban_co_van')</h2></div>		

			<div class="row text-center">
				@foreach($hoidong as $team)
				@if($team->desc_en == 1)
				<div class="col-sm-6">
					<div class="item">
						<div class="img "><a href="{{action('AmpController@hoidongDetail',$team->slug)}}">
							<amp-img src="{{$team->image}}" alt="image01" width="207" height="203" layout="responsive"></amp-img>
						</a></div>
						<div class="text equal">
							<h3 class="title"><a href="{{action('AmpController@hoidongDetail',$team->slug)}}">{{$team->title}}</a></h3>
							<div class="position">{{$team->excerpt}}</div>
							<div class="desc">
							{!! strip_tags(str_limit($team->description,130))!!}		
							</div>
						</div>										
					</div>
				</div>
				@endif
				@endforeach
				<span class="bgequal equal"></span>
			</div>
		</div>
	</section>
	@endif

	<section class="u019 row-section pb-0 wow" >
	<div class="container">
		<div class="section-header" ><h2 class="section-title">@lang('menu.page.luat_su') </h2></div>	
		<amp-carousel height="510" layout="fixed-height" type="slides" class="law" controls>
			@foreach($hoidong as $team)
			@if($team->desc_en == 2) 		
				<div class="item text-center">
					<a href="{{action('AmpController@hoidongDetail',$team->slug)}}">
						<amp-img src="{{$team->image}}" alt="{{$team->title}}" layout="responsive" width="345" height="262"></amp-img>
					</a>
					<div class="text equal">
						<h3 class="title"><a href="{{action('AmpController@hoidongDetail',$team->slug)}}">{{$team->title}}</a></h3>
						<div class="position">{{$team->excerpt}}</div>
						<div class="desc">
							{!! strip_tags(str_limit($team->description,130))!!}		
						</div>
					</div>										
				</div>		
			@endif
			@endforeach
		</amp-carousel>
		<span class="bgequal equal"></span>
	</div>
</section>

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
				"name": "Home"
			}
		},{
			"@type": "ListItem",
			"position": 2,
			"item": {
				"@id": "{{ Request::url() }}",
				"name": "{{ $page->title }}"
			}
		}
		]
	}
	</script>
@endpush
@push('scripts')
<style>
	.u019 .bgequal{background: #fff}
</style>
@endpush