@extends('layouts.app')

@section('title', $page->title)
@push('og-meta')
	<meta name="robots" content="noindex">
@endpush
@section('content')
<section class="top-page bg-white">
	<?php 
	$duplicate = false;
		if(isset($module)){
			$title = $module->title;
		}elseif(isset($page)){
			if(isset($secPage)){
				if($page->slug == $secPage->slug){
					$duplicate = true;
				}
			}
			$title = $page->title;
		}else{
			$title = 'title';
		}
	?>
	<div id="breadcrumbs">
		<div class="container">
		<ul class="breadcrumb">
			<li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
			@if(isset($secPage))
			<li>
				<a href="{{action('SiteController@showPageDichVu',$secPage->slug)}}">{{$secPage->title}}</a>
			</li>
			@endif
			@if($duplicate != true)
			<li>
					{{$title}}
			</li>
			@endif
		</ul>
	</div>
	</div>
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
{!! $contentget !!}
@if(isset($deputy))
<section class="u020 row-section wow" > 
	<div class="container">
		<div class="section-header wow fadeInUpS">
			<h2 class="section-title"> @lang('menu.page.doingu') </h2>
		</div>
		<div class="slide3-arr owl-carousel list14 arrow-style-1"> 
			@foreach($deputy as $member)
				<div class="item ">
					<div class="top-img">
						<?php 
							if($current_locale == 'en'){
								$slugurl = 'us-settlement-service';
							}else{
								$slugurl = 'dich-vu-an-cu-my';
							}
						?>
						<a href="{{action('SiteController@level3Dichvu',['slug'=>$slugurl,'permalink'=>$member->slug])}}">
							<div class="img thumbCover_127">
								
									@if($member->content_image != '')
										<img class="img-lazy" data-src="{{URL::to('/')}}/uploads/images/contents/{{$member->content_image }}" alt="{{$member->title}}" /> 
									@else
										<img class="img-lazy" data-src="{{$member->getImage('thumbnail')}}" alt="" /> 
									@endif

								
							</div>
						</a>
					<h3 class="title"><a href="{{action('SiteController@level3Dichvu',['slug'=>$slugurl,'permalink'=>$member->slug])}}">{{$member->title}}</a></h3>
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
@if(isset($doitac))
	@if(count($doitac)>0)
	<section class="u020  row-section  bg-white  wow" > 
		<div class="container">
			<div class="section-header wow fadeInUpS">
				<h2 class="section-title"> @lang('menu.page.partner') </h2>
			</div>	
			<div class="@if(count($doitac)>3) slide4-arr @else no-slide-arr @endif owl-carousel list14 list14-1 arrow-style-1"> 
				<?php 
		      		if($current_locale == 'en'){
						$slug = 'us-settlement-service';
			            $permalink = 'partners';
		      		}else{
		      			$slug = 'dich-vu-an-cu';
        				$permalink = 'doi-tac-an-cu';
		      		}
		      	?>
				@foreach($doitac as $part)
				
					<div class="item ">
						<a href="{{route('dtAncuChitiet',['slug'=>$slug,'permalink'=>$permalink,'partners'=>$part->slug])}}"><div class="img thumbCover_4_3"><img src="{{$part->getImage('thumbnail')}}" alt="{{$part->title}}" /></div></a>
						<div class="text ">
							
							<div class="position"><a href="{{route('dtAncuChitiet',['slug'=>$slug,'permalink'=>$permalink,'partners'=>$part->slug])}}">{{$part->title}}</a></div>
							<div class="desc">
								@if($part->excerpt)
									{{str_limit($part->excerpt,150)}}
								@else
									{{str_limit($part->description,150)}}
								@endif
							</div>
						</div>										
					</div>
				@endforeach
			</div>	
		</div>
	</section>
	@endif
@endif

@if(isset($video) || (isset($hoatdong) && count($hoatdong)>0))
<section class="row-section ">
	<div class="container"> 
		<div class="section-header wow fadeInUpS">
			<h2 class="section-title"> @lang('menu.hoatdongancu') </h2>
		</div>
        <div class="row">
        	@if($video)
            <div class="col-md-6 list15">
                <div class="list">
                    <div class="list_item " >
                        <div class="list_img thumbCover_16_9">
                        	@if($video->video_url)
                        		<!-- get video in video_url -->
                        		{!!$video->video_url!!}
                        	@else
                        		<?php 
                        			//get video in description
									preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $video->description, $matches);
									if(isset($matches[0])){
										echo ($matches[0]); //only the <iframe ...></iframe> part
									}
									// echo ($matches[1]); // only the https://youtube.com/...... part
                                ?>
                        	@endif
                        </div>
                            <div class="list_text">
                                    <div class="list_meta">
                                        <span><i class="fa fa-calendar-o"></i> {{$video->created_at}}</span>
                                    </div>   
                                     <a href="{{ action('SiteController@dtAncuChitiet',['slug'=>$secPage->slug,'permalink'=>$category->slug,'partners'=>$video->slug]) }}" class="list_title">
                                    {{$video->title}}

                                    </a>

                                    <p class="list_desc">
                                    	@if($video->excerpt)
                                    		{{$video->excerpt}}
                                    	@else
                                    		<?php echo strip_tags(str_words($video->description,75,'...'))?>
                                    	@endif
                                    	
                                    </p>
                                
                            </div>                                    
                    </div> 
                    <!-- end item -->
                </div>
            </div>
            @endif
            @if(isset($hoatdong) && count($hoatdong)>0)
            <div class="col-md-6 list13 list13-1">
                <div class="list">
                    @foreach($hoatdong as $post)
                        <div class="list_item " >
                        <a href="{{ action('SiteController@dtAncuChitiet',['slug'=>$secPage->slug,'permalink'=>$category->slug,'partners'=>$post->slug]) }}" class="list_img thumbCover_4_3">

                                <img class="img-lazy" data-src="{{$post->getImage('thumbnail')}}" alt="{{$post->title}}" />
                            </a>
                            <div class="list_text">
                            	 <a href="{{ action('SiteController@dtAncuChitiet',['slug'=>$secPage->slug,'permalink'=>$category->slug,'partners'=>$post->slug]) }}" class="list_title">
          
                                    {{$post->title}}
                                    </a>
                                     <div class="list_meta">
                                        <span><i class="fa fa-calendar-o"></i> {{$post->created_at}}</span>
                                    </div>                                                
                            </div>
                        </div> 
                    <!-- end item -->
                    @endforeach
                </div>
            </div>
            @endif
        </div>
	</div>	
</section>
@endif

@endsection
@push('scripts')
<style type="text/css">
	.owl-carousel.no-slide-arr{display: block;text-align: center;}
	.owl-carousel.no-slide-arr .item {width: 360px;margin-right: 20px;display: inline-block;}
	.owl-carousel.no-slide-arr .item:last-child {margin-right:0;}
</style>
@endpush
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