@extends('layouts.app')

@section('content')

<section class=" wrapSlideshow wow fadeInUpS thumbCover_35">
	
		@if($page->video_url)
		<?php 
			$arrayvideo = explode('=', $page->video_url);
			$codevideo = end($arrayvideo);
		?>
		<iframe width="560" height="315" src="https://www.youtube.com/embed/{{$codevideo}}?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		@else
		<div  id="slideshow" class=" single-slide owl-carousel s-dots  s-auto s-loop">
		<?php 
			$links = unserialize($page->links);

		?>
		@foreach ($slides as $gallery)
			<?php $link = '';
			?>
			
			@if($current_locale == 'en')
				<?php 
				if(isset($links[$gallery->id]['en'])){
					$link = $links[$gallery->id]['en'];
				}	
				?>
			@else
				<?php 
				if(isset($links[$gallery->id]['vn'])){
					$link = $links[$gallery->id]['vn'];
				}
				?>
			@endif
		<a href="{{$link}}"><div class="item bg-lazy thumbCover_35 {{$gallery->id}}" data-src="/uploads/thumbnail/page/{{$gallery->name}}">
		</div></a>
		
		@endforeach
		</div>
		@endif
	
</section>



<section class="u004 row-section wow fadeInUpS">
	<div class="container">
		{!!$page->description!!}
	</div>	
</section>


<!-- 
<section class="row-section  bg-white">
	<div class="container"> 
		<div class="section-header wow fadeInUpS" >
		<h2 class="section-title text-center"> <a href="{{route('subpagedv',['slug'=>$services[0]->slug,'suffix'=>'.html'])}}">@lang('menu.page.service')</a> </h2>
		</div>
		
		<div id="carousel" class="carousel slide homecarousel" data-ride="carousel">
	
			<div class="carousel-inner">
			@foreach($dautudc as $key => $dautu)
				<div class="item <?php if($key == 0) echo 'active'; ?> "  title="{{$dautu->title}}">
					<figure class="snip1544">
						<span class="thumbCover_56">
						@if($dautu->resource_id != NULL)
							<img class="img-lazy" data-src="{{$dautu->imageUrl($dautu->getImage('thumbnail'),1140,638,100)}}" alt="" /> 
						@else
							@if($dautu->content_image != '')
								<img class="img-lazy" data-src="/uploads/images/contents/{{$dautu->content_image }}" alt="" />
							@else
								<img class="img-lazy" data-src="{{$dautu->getImage('thumbnail')}}" alt="" /> 
							@endif
						@endif
						</span>
					<a href="{{action('SiteController@showPageDichVu',['slug'=>$dautu->getSlug(),'suffix'=>'.html'])}}"><figcaption>  </figcaption></a>
					<a href="{{action('SiteController@showPageDichVu',['slug'=>$dautu->getSlug(),'suffix'=>'.html'])}}" class="desc">
						<div class="display-table">
							<div class="table-cell">
								<h3>{{$dautu->title}}</h3>
								<p>{{$dautu->excerpt}}</p>	

							</div>
						</div>
					</a>
					</figure>
				</div>
			@endforeach
			<a class="left carousel-control" href="#carousel" data-slide="prev" ><i class="icon-keyboard_arrow_left"></i><span class="text"></span></a>
			<a class="right carousel-control" href="#carousel" data-slide="next" ><i class="icon-keyboard_arrow_right"></i><span class="text"></span></a>

			</div>
		</div>
	</div>
</section> -->

<section class="row-section list12">
	<div class="container">	
	<div class="section-header wow fadeInUpS" >
		<h2 class="section-title text-center"> <a href="{{route('subpagedv',['slug'=>$services[0]->slug,'suffix'=>'.html'])}}">@lang('menu.page.service')</a> </h2>
		</div>
		<div class=" list slide3-arr owl-carousel">
		@foreach($dautudc as $key => $dautu)
			<a href="{{action('SiteController@showPageDichVu',['slug'=>$dautu->getSlug(),'suffix'=>'.html'])}}" class="list_item wow fadeInUpS">
				<div class="list_img thumbCover_133">
					<img class="img-lazy" data-src="{{$dautu->imageUrl($dautu->getImage('thumbnail'),360,479,100)}}" alt="" />
				</div>
				<div class="list_text">
					<div class="list_title">{{$dautu->title}}&nbsp;</div>
					<div class="list_desc">
					<?php 
                	$string = strip_tags($dautu->excerpt);
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
			</a> <!--End item-->
			@endforeach
		</div>
	</div>	
</section>

<!-- <section class="block4 wow fadeInUpS bg-white row-section">
	<div class="container">	
		<h2 class="section-title text-center"> <a href="{{route('subpagedv',['slug'=>$services[0]->slug,'suffix'=>'.html'])}}">@lang('menu.page.service')</a> </h2>
	  
		<ul class="menutab2 clearfix" role="tablist">
			@foreach($services as $key => $service)
			<li role="presentation" <?php if($key == 0) echo 'class="active"'; ?>>
			<a href="#{{$service->slug}}" aria-controls="{{$service->slug}}" role="tab" data-toggle="tab">
				@if($current_locale == 'en')
					<img class="img-lazy" data-src="{{URL::to('/')}}/uploads/thumbnail/page/{{$service->featureImage->name}}" alt="">
				@else
					<img class="img-lazy" data-src="{{$service->getImage('thumbnail')}}" alt="" />
				@endif
			</a>
			</li>
			@endforeach
		</ul>

  		<div class="tab-content block">
			@foreach($services as $key => $service)
	    	<div role="tabpanel" class="tab-pane <?php if($key == 0) echo 'active'; ?>" id="{{$service->slug}}">
				<div class="block_item ">
					<div class="block_text">
						<div class="block_desc">
							{{$service->excerpt}}
						</div>
						<div >
							<?php 
								if($current_locale == 'en'){
									$urlservice = 'en/service/'.$service->slug;
								}else{
									$urlservice = 'dich-vu/'.$service->slug;
								}
							?>
							<a href="{{$urlservice}}" class="btn btn-white">@lang('admin.button.view_more')</a>
						</div>
					</div>	
					<div class="block_img thumbCover_85">
						<?php 
						$image = '/images/no-image.jpg';
						if(count($service->gallery) > 0){
							$image = '/uploads/thumbnail/page/'.$resource[$service->gallery[0]];
						}
						?>
						<img class="img-lazy" data-src="{{$service->imageUrl($image,570,485,100)}}" alt="" />
						
					</div>						
				</div>   	
	    	</div>
	    	@endforeach
  		</div>
	</div>
</section> -->
<!-- <section class="row-section list12">
	<div class="container">	
		<div class="section-header wow fadeInUpS">
			<h2 class="section-title">
				<a href="{{action('SiteController@projects')}}">@lang('page.current_project')</a>
			</h2>
		</div>
		<div class=" list slide3-arr owl-carousel">
			@foreach($projects as $project)
			<a href="{{action('SiteController@projectDetail',['slug'=>$project->getSlug(),'suffix'=>'.html'])}}" class="list_item wow fadeInUpS">
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
			@endforeach
		</div>
	</div>	
</section> -->

@if(count($news) > 0)
<section class="row-section ">
	<div class="container"> 
		<div class="section-header wow fadeInUpS">
			<?php 
				if($current_locale == 'en'){
					$url = 'us-news';
				}else{
					$url = 'tin-tuc-my';
				}
				
			?>
			<h2 class="section-title"><a href="{{route('subnews',$url)}}"> @lang('menu.page.news') </a></h2>
		</div>
        <div class="row">
            <div class="col-md-6 list12">
                <div class="list">
                	@foreach($news as $key => $data)
                	<?php 
                		$img = "/uploads/images/contents/$data->content_image";
                		if($data->resource_id != ''){
                			$img = $data->getImage('thumbnail');
                		}
                	?>
                    <div class="list_item " >
                        <a href="{{action('SiteController@newsDetail',['slug'=>$data->getSlug(),'suffix'=>'.html'])}}" class="list_img thumbCover_86">
                            <img class="img-lazy" data-src="{{$img}}" alt="" />
                        </a>
                        <div class="list_text">
                            <a href="{{action('SiteController@newsDetail',['slug'=>$data->getSlug(),'suffix'=>'.html'])}}" class="list_title">{{ stripslashes($data->title) }}</a>

                            <!-- css 2 hàng không chạy được trên firefox phải sửa lại -->
                            <p class="list_desc">
                            	<?php 
                            	$string = strip_tags(stripslashes($data->excerpt));
								if (strlen($string) > 120) {

								    // truncate string
								    $stringCut = substr($string, 0, 120);
								    $endPoint = strrpos($stringCut, ' ');

								    //if the string doesn't contain any space then it will cut without word basis.
								    $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
								    $string .= '...';
								}
								echo $string;
                            	?>
                            </p>
                            <div class="list_meta">
                                <span><i class="fa fa-calendar-o"></i> {{$data->updated_at}}</span>
                            </div>                                                
                        </div>                                    
                    </div> 

                    @if($key == 0)
            	</div>
            </div>
            <div class="col-md-6 list13">
            	<div class="list">
                    @endif

                    @endforeach
                    <!-- end item -->
                </div>
            </div>
        </div>
	</div>	
</section>
@endif
@if(count($event) >0)
<section class="row-section  bg-white">
	<div class="container"> 
		<div class="section-header wow fadeInUpS" >
			<h2 class="section-title"><a href="{{route('subevents','')}}"> @lang('menu.page.events') </a></h2>
		</div>

		<div id="carousel-bt" class="carousel slide homecarousel" data-ride="carousel">
		<!-- FIRST for slide -->
			<div class="carousel-inner">
			@foreach($event as $key => $ev)
				<div class="item <?php if($key == 0) echo 'active'; ?> "  title="{{$ev->title}}">
					<figure class="snip1544">
						<span class="thumbCover_56">
						@if($ev->resource_id != NULL)
							<img class="img-lazy" data-src="{{$ev->imageUrl($ev->getImage('thumbnail'),1140,638,100)}}" alt="" /> 
						@else
							@if($ev->content_image != '')
								<img class="img-lazy" data-src="/uploads/images/contents/{{$ev->content_image }}" alt="" />
							@else
								<img class="img-lazy" data-src="{{$ev->getImage('thumbnail')}}" alt="" /> 
							@endif
						@endif
					  	</span>
					  	<a href="{{action('SiteController@eventsDetail',['slug'=>$ev->getSlug(),'suffix'=>'.html'])}}"><figcaption>  </figcaption></a>
					  	<a href="{{action('SiteController@eventsDetail',['slug'=>$ev->getSlug(),'suffix'=>'.html'])}}" class="desc">
						  	<div class="display-table">
						  		<div class="table-cell">
								    <h3>{{$ev->title}}</h3>
								    <p>{{$ev->excerpt}}</p>	

						  		</div>
						  	</div>
					  	</a>
					</figure>
				</div>
			@endforeach
			<a class="left carousel-control" href="#carousel-bt" data-slide="prev" ><i class="icon-keyboard_arrow_left"></i><span class="text"></span></a>
			<a class="right carousel-control" href="#carousel-bt" data-slide="next" ><i class="icon-keyboard_arrow_right"></i><span class="text"></span></a>

			</div>
		</div>
	</div>
</section>
@endif
@if(count($videos)>0)
@endif
<section class="row-section bg-white">
	<div class="container"> 
		<div class="section-header wow fadeInUpS">
			<h2 class="section-title"><a href="{{route('subnews',$url)}}"> @lang('menu.page.videos') </a></h2>
		</div>
        <div class="row fadeInUpS">
        	@foreach($videos as $video)
        	<?php 
        		$img = $video->getImage('thumbnail');
        	?>
            <div class="col-md-4 list14 ">
                <div class="list_item " >

                    <a href="{{action('SiteController@dtAncuChitiet',['slug'=>$slug_v1,'permalink'=>$slug_v2,'partners'=>$video->getSlug()])}}" class="list_img thumbCover_86">
                        <img class="img-lazy" data-src="{{$video->imageUrl($img,360,311,80)}}" alt="" />
                    </a>
                    <a href="{{action('SiteController@dtAncuChitiet',['slug'=>$slug_v1,'permalink'=>$slug_v2,'partners'=>$video->getSlug()])}}" class="title_video">{{ stripslashes($video->title) }}</a>                                                                          
                </div> 
            </div>
            @endforeach

        </div>
	</div>	
</section>
@endsection
<style type="text/css">
	.list14 .title_video{text-align: center;margin-top:10px;display: block;font-weight: bold}
	.list14 .title_video:hover{color:#0C50B8;}
	.list13 .list_desc{
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 2;
		-moz-box-orient: vertical;
		-moz-line-clamp: 2;
	}
#wrapper #wrapper{
	overflow: visible;
}
	.list13 .list_title:hover{color:#081D61;}
	#slideshow [class*=thumbCover]:before{background: none !important}
</style>
@push('styles')
	<style type="text/css">
	.list13 .list_item{margin-bottom:26px;}
	.list13 .list_title{height:48px;overflow: hidden}
	@media screen and (max-width: 1023px){
		#slideshow .item {background-size: 100% auto !important;background-repeat: no-repeat;}
	}
	@media (max-width: 767px){
		.wrapSlideshow.thumbCover_35:before, .wrapSlideshow .thumbCover_35:before {
			padding-top: 35%
		}	
		body {
		    font-size: 1.2em;
		}
	}
	@media screen and (max-width: 540px){
		.list12 .list_title{
			font-size: 1.2em
		}
	}
	
	</style>
@endpush
@push('og-meta')
	<link rel="canonical" href="{{URL::to('/')}}">
	<title>@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->title}} @endif</title>
	<meta name="description" content="@if(isset($page->meta_desc) && $page->meta_desc != '') {{$page->meta_desc}} @else {{$page->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->excerpt}} @endif">
	<meta property="og:description" content="@if(isset($page->meta_desc) && $page->meta_desc != '') {{$page->meta_desc}} @else {{$page->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->title}} @endif">
	<meta property="og:type"   content="article" /> 
	<meta property="og:image" content="@if($page->resource_id) {{$page->image}} @else <?php echo URL::to('/').'/images/no-image.jpg';?> @endif"/>
@endpush