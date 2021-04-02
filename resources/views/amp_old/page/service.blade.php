@extends('layouts.amp')
@push('styleinline')
img{object-fit: cover;width: 100%;}.page-title{padding-bottom:40px}.h2, h2 {font-size: 26px;line-height: 36px;}row{margin:0}.container ul {padding-left: 30px;}.list .col-xs-6{width:100%}.container ul.breadcrumb{padding:0}ul.list-check2>li {padding: 5px 0 5px 45px;}.chart-div .col-md-8,.chart-div .col-md-6{padding:0}ul.list-check2>li:before {content: "\e907";top: 0;font-size: 12px;line-height: 32px;width: 32px;height: 32px;text-align: center;color: #B52243;}ul[class*=list-]>li{position:relative}ul[class*=list-]>li:before {font-size: inherit;position: absolute;left: 1px;font-family: 'icomoon';}.block1 .block_item_left .block_img:before {background-color: #1D3768;}.block1 .block_item_right .block_img:before {background-color: #B52243;}.block1 .block_img:before {content: "";display: block;position: absolute;left: 0;top: 0;right: 0;bottom: 0;z-index: 2;opacity: 0.85;}section.u011 {overflow:hidden}.entry-content ol, .entry-content ul {margin: 0 0 25px 25px;}.list_position{white-space: initial;}.row.list>div:first-child{margin-top:0}.u011 .block_img amp-img img {height:100%;}.u011 .block_img{height:400px}.u011 .display-table{height:400px}.list4 .list_text{color:#fff}.u011 .block_title{text-align:center}
@endpush
@section('title', $page->title)

@section('content')
<section class="top-page bg-white">
	
	@include('partials.breadcrumb')
	<div class="container">
		<div class="page-title wow">
			<h1 class="title">
				<span>
					{{$page->title}}
				</span>
			</h1>
		</div>
	</div>
</section>
	<?php 
	$content = preg_replace('/style=[^>]*/', '', $page->description);
	$content1 = preg_replace('/<img .*? data-src="([^"]*)" .*?>/', '<amp-img src="$1" width="375" height="400"></amp-img>',$content);
	$html = preg_replace('/<img(.*?)\/?>/', '<amp-img$1 width="375" height="400" alt="AMP"></amp-img>',$content1);
	$regex=  '#<iframe(.*?)\/?>(.*?)</iframe>#';
	preg_match($regex, $html, $matches);
	preg_match('/src="([^"]+)"/', $matches[1], $returnurl);
	$codearr = explode('/', end($returnurl));

	$html = preg_replace('/<iframe .*? src="([^"]*)" .*?>/', '<amp-youtube data-videoid="'.end($codearr).'" width="375" height="321" layout="responsive"></amp-yotubeu>',$content1);
	?>
    {!! $html !!}
<?php 
	if (strpos($page->title, 'L-1') === false) {
?>
@if($page->slug !== 'dich-vu-an-cu')
    <section class="row-section list4 pb-0 bg-white wow">
		<div class="section-header">
			<h2 class="section-title"><a href="{{action('AmpController@projects')}}">@lang('page.project_calling')</a></h2>
			<i class="icon-star3"></i>
		</div>
		<div class=" list slide3-arr owl-carousel">
		<amp-carousel height="308" layout="fixed-height" type="slides" class="list slide3-arr owl-carousel">
			@foreach($p49 as $project)
			<a href="{{ action('AmpController@projectDetail',['slug'=>$project->slug]) }}" class="list_item">
				<div class="list_img thumbCover_90">
					<amp-img src="{{$project->getImage()}}" alt="" width="343" height="308" layout="responsive"></amp-img>
				</div>
				<div class="list_text">
					<div class="list_title">{{$project->title}}</div>
					<div class="list_position">{{$project->excerpt}}</div>
				</div>
			</a>
			@endforeach
		</amp-carousel>
	</section>

	<section class="u012 row-section list6 bg-white wow">
	<div class="container"> 
		<div class="section-header">
			<h2 class="section-title"><a href="{{action('AmpController@projects')}}#project_end">@lang('page.project_end')</a></h2>
			<i class="icon-star3"></i>
		</div>
		<div class=" list row">
		
			@foreach($p48 as $project)
			<div class="col-md-4 col-sm-6 col-xs-6 col-xs-12">
				<div class="list_item ">
					<a href="{{ action('AmpController@projectDetail',['slug'=>$project->slug]) }}" class="list_img thumbCover_75">
						<amp-img src="{{$project->getImage()}}" alt="" width="343" height="308" layout="responsive"/>
					</a>
					<div class="list_text">
						<a href="{{ action('AmpController@projectDetail',['slug'=>$project->slug]) }}" class="list_title">{{$project->title}}</a>
						<div class="list_position">{{$project->excerpt}}</div>
					</div>
				</div> 
			</div>
			<!--End item-->
			@endforeach
		</div>
		<p class="text-center"><a href="{{action('AmpController@projects')}}" class="btn">@lang('page.menu.xem_them')</a></p>
	</div>	
</section>
@endif
@if(isset($deputy))
<section class="u020  row-section wow" > 
	<div class="container">
		<div class="slide3-arr owl-carousel list14 arrow-style-1"> 

			@foreach($deputy as $member)
				<div class="item ">
					<div class="top-img">
						<a href="{{action('AmpController@daidienDetail',$member->slug)}}">
							<div class="img thumbCover_127">
								
									@if($member->content_image != '')
										<amp-img src="{{URL::to('/')}}/uploads/images/contents/{{$member->content_image }}" alt="{{$member->title}}" width="322" height="241" layout="responsive"/> 
									@else
										<amp-img src="{{$member->getImage('thumbnail')}}" alt="" width="322" height="241" layout="responsive" /> 
									@endif

								
							</div>
						</a>
					<h3 class="title"><a href="{{action('AmpController@daidienDetail',$member->slug)}}">{{$member->title}}</a></h3>
					</div>
					<div class="text ">					
						<div class="position">{{$member->excerpt}}</div>
						<div class="desc">
							<?php 
		                	$string = strip_tags($member->description);
							if (strlen($string) > 250) {

							    // truncate string
							    $stringCut = substr($string, 0, 250);
							    $endPoint = strrpos($stringCut, ' ');

							    //if the string doesn't contain any space then it will cut without word basis.
							    $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
							    $string .= '...';
							}
							echo $string;
		                	?>
						</div>
					</div>										
				</div>
			@endforeach
			
		</div>	
	</div>
</section>
@endif
<?php  } ?>
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