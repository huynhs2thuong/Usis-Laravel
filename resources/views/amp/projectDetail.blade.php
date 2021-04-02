@extends('layouts.amp')
@section('title', $project->meta_title)
@push('styleinline')
.page-title {padding-bottom: 40px;text-align: center;}.u007 .title {padding-top: 20px;}.list4 .list_text{color:#fff}.thumbCover_90:before {padding-top: 90%;}.list4 .list_img img{object-fit:cover}.section-header{margin-bottom:20px}
@endpush
@section('content')

<section class="top-page bg-white">
	
		<div id="breadcrumbs">
      <div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/amp' : '/en/amp' }}">@lang('menu.page.home') </a></li>
          <li><a href="{{ action('AmpController@projects') }}">{{ $module->title }}</a></li>
		      <li><a href="">{{ $project->title }}</a></li>
		    </ul>
      </div>
		</div>
    <div class="container"> 
		<div class="page-title wow">
				<h1 class="title"> <span>{{ $project->title }}</span></h1>
        <span>{{$project->category()->first()->title}}</span>
		</div>
	</div>	
</section>


@if($gallery)
<section class="row-section pt-30 slide4-arr owl-carousel bg-white  wow">
	@foreach($gallery as $g)
		<div class="item">
			<div class="thumbCover_80">
				<img class="img-lazy" data-src="{{URL::to('/')}}/uploads/thumbnail/page/{{$g->name}}" alt="" />
			</div>
		</div>
	@endforeach		
</section>
@endif

@if($project->overview)
<section class="u007 row-section ">
  <div class="container"> 
    <div class="  row">
      <div class="col-md-4 col-sm-6 ">
        <h2 class="title">@lang('menu.page.tong_quan_du_an')</h2>
        {!! $project->overview !!}
      </div>
      <div class=" col-md-7 col-md-offset-1 col-sm-6 ">
        <!-- <div id="map"></div> -->
        @if($imageOverview)
        <amp-img src="{{URL::to('/')}}/uploads/thumbnail/project/{{$imageOverview->name}}" width="472" height="270" layout="responsive"></amp-img>
        @endif
      </div>
    </div>
  </div>  
</section>
@endif

@if($project->description)
<section class="row-section bg-white  wow">
  <div class="container"> 
        <div class="section-header">
              <h2 class="section-title"> @lang('menu.thong_tin_chi_tiet_du_an') </h2>
              <i class="icon-star3"></i>
        </div>    
    <div class="  row">
      <div class=" col-md-8 col-md-offset-2  ">

        <div class="entry-content">
          <?php 
            $content = preg_replace('/style=[^>]*/', '', $project->description);
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
  </div>  
</section>
@endif

@if($project->progress)
<section class="row-section  wow">
  <div class="container"> 
    <div class="section-header">
      <h2 class="section-title"> @lang('menu.tien_do_du_an')</h2>
      <i class="icon-star3"></i>
    </div>    
    <div class="  row">
      <div class=" col-md-8 col-md-offset-2">
        <?php 
            $content = preg_replace('/style=[^>]*/', '', $project->progress);
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
@endif

@if($project->investor)
<section class="row-section bg-white wow">
  <div class="container"> 
    <div class="  row"><img class="img-lazy" data-src="" alt="">

      <div class="col-sm-5">
        <p>
          <amp-img src="<?php echo $investImg ? $investImg : 'http://via.placeholder.com/450x450'?>" alt="" width="472" height="373" layout="responsive">
        </p>
      </div>
      <div class=" col-sm-7">

        <div class="entry-content">
          <?php 
            $content = preg_replace('/style=[^>]*/', '', $project->investor);
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
  </div>  
</section>    
@endif 


<!-- related project -->
<section class="row-section list4 pb-0 bg-white wow">
    <div class="section-header">
      <h2 class="section-title">@lang('menu.page.project_related')</h2>
      <i class="icon-star3"></i>
    </div>
    <amp-carousel width="502" height="451" layout="responsive" type="slides" controls>
      @foreach($projects as $relate)
      <a href="{{ action('AmpController@projectDetail',$relate->slug) }}" class="list_item">
        <div class="list_img thumbCover_90">
          <amp-img src="{{$relate->getImage()}}" alt="" width="502" height="451" layout="responsive" />
        </div>
        <div class="list_text">
          <div class="list_title">{{$relate->title}}</div>
          <div class="list_position">{{$relate->excerpt}}</div>
        </div>
      </a> <!--End item-->
      @endforeach
    </amp-carousel>
  </section> 

@endsection

@push('scriptamp')
<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
@endpush
@push('og-meta')
@include('partials.canonical')
  <title>@if(isset($project->meta_title) && $project->meta_title != '') {{$project->meta_title}} @else {{$project->title}} @endif</title>
  <meta name="title" content="@if(isset($project->meta_title) && $project->meta_title != '') {{$project->meta_title}} @else {{$project->title}} @endif">
  <meta name="description" content="@if(isset($project->meta_desc) && $project->meta_desc != '') {{$project->meta_desc}} @else {{$project->excerpt}} @endif" />
  <meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
  <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
  <meta property="og:title" content="@if(isset($project->meta_title) && $project->meta_title != '') {{$project->meta_title}} @else {{$project->title}} @endif">
  <meta property="og:description" content="@if(isset($project->meta_desc) && $project->meta_desc != '') {{$project->meta_desc}} @else {{$project->excerpt}} @endif">
  <meta property="og:site_name" content="@if(isset($project->meta_desc) && $project->meta_title != '') {{$project->meta_desc}} @else {{$project->excerpt}} @endif">
  <meta property="og:type"   content="article" /> 
  <meta property="og:image" content="@if($project->resource_id) {{$project->image}} @else <?php echo URL::to('/').'/images/no-image.jpg';?> @endif"/>
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
        "@id": "{{ action('AmpController@projects') }}",
        "name": "{{ $module->title }}"
      }
    },{
      "@type": "ListItem",
      "position": 3,
      "item": {
        "@id": "{{ Request::url() }}",
        "name": "{{ $project->title }}"
      }
    }
    ]
  }
  </script>
@endpush