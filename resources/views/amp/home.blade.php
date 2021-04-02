@extends('layouts.amp')
@push('styleinline')
.list_item .list_img amp-img img {width:100%;height:auto;object-fit:cover}.list11 .list_img amp-img img {width:100%;height:auto;object-fit:cover}.list11 .list_title{margin:0}.list12 .amp-carousel-slide a amp-img img {width:100%;height:100%;object-fit:cover}.content-events{width:100%}.row-section amp-img img {width:100%;height:100%;object-fit:cover}.block4 amp-img img {object-fit: contain;}.thumbCover_85:before{padding-top:85%}.list12 .amp-carousel-slide a:before{z-index:2}
@endpush
@section('content')

<div class=" wrapSlideshow wow fadeInUpS thumbCover_35">
	
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
		<amp-carousel height="131" layout="fixed-height" type="carousel">
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
		<div>
			<a href="{{$link}}">
			  <amp-img src="/uploads/thumbnail/page/{{$gallery->name}}"width="414" height="131" alt=""></amp-img>
			</a>
		 </div>
		   @endforeach
		</amp-carousel>

		</div>
		@endif
	
</div>

<div class="u004 row-section wow fadeInUpS">
	<div class="chart-div">
	<?php
	echo preg_replace(
		'/<img .*? data-src="([^"]*)" .*?>/', 
        '<amp-img src="$1" width="600" height="600" layout="responsive"></amp-img>',
		$page->description
	);
	?>

	</div>	
</div>


<div class="block4 wow fadeInUpS bg-white row-section">
	<div class="chart-div">	
		<h2 class="section-title text-center"> <a href="{{route('subpagedvamp',['slug'=>$services[0]->slug])}}">@lang('menu.page.service')</a> </h2>
	  	<!-- Nav tabs -->
		<amp-selector role="tablist" layout="container" class="ampTabContainer menutab2 clearfix">
			@foreach($services as $key => $service)
			
			  <div role="tab" class="tabButton" @if($key == 0) selected @endif option="@if($key == 0) a @else b @endif">
			  	@if($current_locale == 'en')
					<amp-img src="{{URL::to('/')}}/uploads/thumbnail/page/{{$service->featureImage->name}}" width="158" height="100" layout="responsive" alt=""></amp-img>
				@else
					<amp-img src="{{$service->getImage('thumbnail')}}" width="158" height="100" layout="responsive" alt=""></amp-img>
				@endif	
			  </div>
			  <div role="tabpanel" class="tabContent">
			  	<div class="block_item ">
					<div class="block_text">
						<div class="block_desc">
							{{$service->excerpt}}
						</div>
						<div >
							<?php 
								if($current_locale == 'en'){
									$urlservice = 'amp/en/service/'.$service->slug;
								}else{
									$urlservice = 'amp/dich-vu/'.$service->slug;
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
						<amp-img src="{{$image}}" width="345" height="312" layout="responsive" alt=""></amp-img>
						
					</div>						
				</div> <!--End item-->   	
			  </div>
			@endforeach
		</amp-selector>
	</div>
</div>

<div class="row-section list12">
	<div class="chart-div">	
		<div class="section-header wow fadeInUpS">
			<h2 class="section-title">
				<a href="{{action('AmpController@projects')}}">@lang('page.current_project')</a>
			</h2>
		</div>
		<amp-carousel height="458" width="345" layout="responsive" type="slides">
			@foreach($projects as $project)
				<div>
				  	<a href="{{action('AmpController@projectDetail',['slug'=>$project->getSlug(),'suffix'=>'.html'])}}" class="list_item wow fadeInUpS">
				    <amp-img src="{{$project->getImage('thumbnail')}}" width="345" height="458" layout="responsive" alt=""></amp-img>
				    <div class="project_content">
					    <div class="list_title">{{$project->title}}</div>
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
				</div>
			@endforeach
		</amp-carousel>
	</div>	
</div>

@if(count($event) >0)
<div class="row-section  bg-white">
	<div class="chart-div"> 
		<div class="section-header wow fadeInUpS" >
			<h2 class="section-title"><a href="{{route('subeventsamp','')}}"> @lang('menu.page.events') </a></h2>
		</div>

		<amp-carousel width="384" height="215" layout="responsive" type="slides" autoplay delay="2000">
		  @foreach($event as $key => $ev)
			<div class="snip1543">
		  	<a href="{{action('AmpController@eventsDetail',['slug'=>$ev->getSlug(),'suffix'=>'.html'])}}" class="desc">
			<span class="thumbCover_56">
			@if($ev->resource_id != NULL)
				<amp-img src="{{$ev->getImage('thumbnail')}}" width="384" height="215" layout="responsive" alt=""></amp-img>
			@else
				@if($ev->content_image != '')
					<amp-img src="/uploads/images/contents/{{$ev->content_image }}" width="384" height="215" layout="responsive" alt=""></amp-img>
				@else
					<amp-img src="{{$ev->getImage('thumbnail')}}" width="384" height="215" layout="responsive" alt=""></amp-img>
				@endif
			@endif
		  	</span>
			  	<div class="display-table content-events">
			  		<div class="table-cell">
					    <h3>{{$ev->title}}</h3>
			  		</div>
			  	</div>
		  	</a>
			</div>
		    @endforeach
		</amp-carousel>
	</div>
</div>
@endif

@if(count($news) > 0)
<div class="row-section ">
	<div class="chart-div"> 
		<div class="section-header wow fadeInUpS">
			<?php 
				if($current_locale == 'en'){
					$url = 'us-news';
				}else{
					$url = 'tin-tuc-my';
				}
				
			?>
			<h2 class="section-title"><a href="{{route('subnewsamp',$url)}}"> @lang('menu.page.news') </a></h2>
		</div>
        <div class="row">
            <div class="col-md-6 list12">
                <div class="list">
                	<?php $i = 1;?>
                	@foreach($news as $key => $data)
                	<?php 
                		$img = "/uploads/images/contents/$data->content_image";
                		if($data->resource_id != ''){
                			$img = $data->getImage('thumbnail');
                		}
                	?>
                    <div class="list_item">
                        <a href="{{action('AmpController@newsDetail',['slug'=>$data->getSlug(),'suffix'=>'.html'])}}" class="list_img thumbCover_86">
                            <amp-img src="{{$img}}" @if($i == 1) width="384" height="332" @else width="64" height="36" @endif layout="responsive" alt=""></amp-img>
                        </a>
                        <div class="list_text">
                            <a href="{{action('AmpController@newsDetail',['slug'=>$data->getSlug(),'suffix'=>'.html'])}}" class="list_title">{{ stripslashes($data->title) }}</a>
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
                    <?php $i++;?>
                    @endforeach
                    <!-- end item -->
                </div>
            </div>
        </div>
	</div>	
</div>
@endif

@endsection
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