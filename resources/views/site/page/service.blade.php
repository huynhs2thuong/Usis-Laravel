@extends('layouts.app')

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
<section class="u009 statue-of-liberty bg-white wow">
<div class="container">
{!! $contentget !!}
</div>
</section>
<?php 
	if (strpos($page->title, 'L-1') === false) {
?>
@if($page->slug !== 'dich-vu-an-cu')
    <!-- <section class="row-section list4 pb-0 bg-white wow">
		<div class="section-header">
			<h2 class="section-title"><a href="{{action('SiteController@projects')}}">@lang('page.project_calling')</a></h2>
			<i class="icon-star3"></i>
		</div>
		<div class="container">
			<div class=" list slide3-arr owl-carousel">
				@foreach($p49 as $project)
				<a href="{{ action('SiteController@showPageDuAn',['slug'=>$project->slug,'suffix'=>'.html']) }}" class="list_item ">
					<div class="list_img thumbCover_90">
						<img class="img-lazy" data-src="{{$project->getImage()}}" alt="" />
					</div>
					<div class="list_text">
						<div class="list_title">{{$project->title}}</div>
						<div class="list_position">{{$project->excerpt}}</div>
						
					</div>
				</a>
				@endforeach
			</div>
		</div>
		
	</section> -->
@if(count($p48)>0)
<section class="row-section list12">
	<div class="container"> 
		<div class="section-header">
			<h2 class="section-title"><a href="{{action('SiteController@projects')}}#project_end">@lang('page.project')</a></h2>
			<i class="icon-star3"></i>
		</div>
		<div class=" list slide3-arr owl-carousel">
		
			@foreach($p48 as $project)
			<a href="{{ action('SiteController@showPageDuAn',['slug'=>$project->slug]) }}" class="list_item wow fadeInUpS">
				<div class="list_img thumbCover_133">
					<img class="img-lazy" data-src="{{$project->imageUrl($project->getImage('thumbnail'),360,479,100)}}" alt="" />
				</div>
				<div class="list_text">
					<div class="list_title">{{$project->title}}&nbsp;</div>
					<div class="list_desc">
					<?php 
                	$string = strip_tags($project->excerpt);
					if (strlen($string) > 230) {

					    // truncate string
					    $stringCut = substr($string, 0, 230);
					    $endPoint = strrpos($stringCut, ' ');

					    //if the string doesn't contain any space then it will cut without word basis.
					    $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
					    $string .= '...';
					}
					echo $string;
                	?>
					</div>
					
				</div>
			</a>
			<!--End item-->
			@endforeach
		</div>
		<!-- <p class="text-center"><a href="{{action('SiteController@projects')}}" class="btn">@lang('page.menu.xem_them')</a></p> -->
	</div>	
</section>
@endif
@endif


@if(isset($deputy))
<section class="u020  row-section wow" > 
	<div class="container">
		<div class="slide3-arr owl-carousel list14 arrow-style-1"> 

			@foreach($deputy as $member)
				<div class="item ">
					<div class="top-img">
						<a href="{{action('SiteController@daidienDetail',$member->slug)}}">
							<div class="img thumbCover_127">
								
									@if($member->content_image != '')
										<img class="img-lazy" data-src="{{URL::to('/')}}/uploads/images/contents/{{$member->content_image }}" alt="{{$member->title}}" /> 
									@else
										<img class="img-lazy" data-src="{{$member->getImage('thumbnail')}}" alt="" /> 
									@endif

								
							</div>
						</a>
					<h3 class="title"><a href="{{action('SiteController@daidienDetail',$member->slug)}}">{{$member->title}}</a></h3>
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