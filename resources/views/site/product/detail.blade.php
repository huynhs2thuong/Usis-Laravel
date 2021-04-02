@extends('layouts.app')

@section('title', $product->title)

@section('content')
<div id="breadcrumbs">
	<div class="container"> 
		<ul class="breadcrumb">
			<li><a href="@lang('menu.url.home')">@lang('menu.page.home')</a></li>
			<li><a href="{{action('ProductController@index',['slug'=>$category->slug])}}">{{$category->title}}</a></li>
			<li><span>{{$product->title}}</span></li>
		</ul>
	</div>
</div>

<div class="wrap-page-title-emty"></div>

<div id="maincontent" class="product-detail">
	<div class="container">

		<div class="page-title">
			<h1 class="title"> <span>{{$product->title}}</span></h1>
		</div>

		<div class="row top-detail">
			<div class="col-sm-6 col-left">
				<div class="img-full"><img src="{{$product->getImage('full')}}" alt=""></div>	
				<div class="row more-link">
					<div class="col-xs-4">
					<a href="{{action('SiteController@color1')}}"><img src="/images/icon-svg/tu-phoi-mau-son.svg" alt="">	<br /> @lang('admin.product.coloring')</a>
					</div>
					<div class="col-xs-4">
						<a href="<?php echo $product->color_board_link ? $product->color_board_link : 'javascript:;' ?>">
							<img src="/images/icon-svg/bang-mau.svg" alt="">	<br /> @lang('admin.product.board')</a>
					</div>
					<div class="col-xs-4">
					<a href="{{action('ProjectController@index')}}"><img src="/images/icon-svg/du-an-noi-bat.svg" alt="">	<br /> @lang('admin.product.featured_project')</a>
					</div>

				</div>

				
			</div>
			<div class="col-sm-6 col-right">
				<div class="item">
					<div class="description">
						{!!$product->description!!}
					</div>			
					<p>
						<span  class="btn btn-primary btnshow"> <span class="inner"><span class="more">@lang('admin.button.view_more')</span><span class="less">Thu gọn</span></span></span>
					</p>
				</div>
				<?php if(count($technologies)>0): ?>
				<div class="item">
					<h4 class="color-main">@lang('admin.product.technology'):</h4>
					<p>
						@foreach($technologies as $tech)
							<a href="{{action('SiteController@technologyDetail',['slug'=>$tech->slug])}}">
								<img src="{{$tech->getImage('full')}}" alt="" height="60" />
							</a>
							&nbsp;&nbsp;
						@endforeach
					</p>
				</div>
				<?php endif; ?>
				<div class="item">
					<h4 class="color-main">@lang('admin.product.intended_use'):</h4>
					<p>{{$product->uses}}</p>
				</div>

			</div>

		</div>

		<div class="widget">
			<h3 class="widget-title">@lang('admin.product.specifications')</h3>
			<div class="widget-content">
				<ul class="list-border title-230">
					<?php $specifications = explode('|', $product->specification); ?>
					@foreach($specifications as $spec)
						@if($spec!=='')
						<li>
							<?php $items = explode(':', $spec); $i=0;?>
							@foreach($items as $item)
								@if($i==0)
									<span class="title">{{$item}}:</span>
								@else
									<span class="value">{{$item}}</span>
								@endif	
								<?php $i++; ?>
							@endforeach
						</li>
						@endif	
					@endforeach
					

				</ul>
			</div>
		</div>		
		<div class="row">
			<div class="col-sm-6">
				<div class="widget">
					<h3 class="widget-title">@lang('admin.product.methods')</h3>
					<div class="widget-content">
						<ul class="list-border title-150">
							<?php $methods = explode('|', $product->method); ?>
							@foreach($methods as $method)
								@if($method!=='')
								<li>
									<?php $items = explode(':', $method); $i=0;?>
									@foreach($items as $item)
										@if($i==0)
											<span class="title">{{$item}}:</span>
										@else
											<span class="value">{{$item}}</span>
										@endif	
										<?php $i++; ?>
									@endforeach
								</li>
								@endif	
							@endforeach
						</ul>
					</div>
				</div>	

			</div>
			<div class="col-sm-6">
				<div class="widget">
					<h3 class="widget-title">@lang('admin.product.guide')</h3>
					<div class="widget-content">
						{!!$product->guide!!}
					</div>
				</div>					
			</div>

		</div>






	</div>
</div>
<div class="TOA005">
	<div class="container">
		<div class="section-header">
    		<h2 class="section-title"> @lang('admin.product.system') </h2>
		</div>

		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				{!!$product->suggest !!}				
			</div>
		</div>


	</div>
</div>

<div class="TOA006">
	<div class="container">
		<div class="section-header">
    		<h2 class="section-title"> @lang('admin.product.other_products')  </h2>
		</div>
		<div class="slide4-arr top-arrows owl-carousel block-5">
			@foreach($datas as $data)
				<div class="item">
					<div class="item_inner">						
						<a href="{{action('ProductController@detail',['slug'=>$data->slug])}}" class="item_img">
							<img src="{{$data->getImage('full')}}" alt="">
						</a>
						<a href="{{action('ProductController@detail',['slug'=>$data->slug])}}" class="item_title">
							@if($data->shortTitle != '') 
								{{$data->shortTitle}}
							@else
								{{$data->title}}
							@endif		
						</a>
					</div>
				</div>
			@endforeach					
		</div>


	</div>
</div>

<div class="TOA050" >
		<div class="row grid-space-0 block-10">
			@foreach($categories as $cate)
				<div class="col-sm-3 col-xs-6 col-xxs-12">
					<a href="{{action('ProductController@index',['slug'=>$cate->slug])}}" class="item" style="background-image: url({{$cate->getImage('full')}});">
						<span class="item_inner">{{$cate->title}}</span>
					</a>
				</div>
			@endforeach
		</div>
</div>
	@include('partials.toaTool')
	<script type="text/javascript">
		$(document).ready(function(){
			$('.more').on('click',function(){
				$('.description').css('max-height','none');	
			})
		});
	</script>
@endsection	
@push('og-meta')
<meta name="description" content="{{$product->seoDescription}}" />
<meta property="og:title" content="{{$product->title}}" />
<meta property="og:type" content="image/jpeg" />
<meta property="og:url" content="{{ action('ProductController@detail',['slug' => $product->slug]) }}" />
<meta property="og:image" content="{{$product->getImage('thumbnail')}}" />
@endpush