@extends('layouts.app')
@section('title', $current_category->title)
@section('content')
<div id="breadcrumbs">
	<div class="container"> 
		<ul class="breadcrumb">
			<li><a href="/@lang('menu.url.home')">@lang('menu.page.home')</a></li>
			<li><span>@lang('admin.object.product')</span></li>
		</ul>
	</div>
</div>

<div class="wrap-page-title-emty"></div>

<div id="maincontent">
	<div class="container">
		<div class="page-title">
			<h1 class="title"> <span>@lang('admin.object.product')</span></h1>
		</div>
		<ul class="contentmenu-2">
			@foreach($category as $cate)
				@if($cate->slug == $slug)
					<li class="active"><a href="{{action('ProductController@index',['slug'=>$cate->slug])}}">{{$cate->title}}</a></li>
				@else
					<li><a href="{{action('ProductController@index',['slug'=>$cate->slug])}}">{{$cate->title}}</a></li>
				@endif	
			@endforeach
		</ul>
		<div class="filter-product">
			<form id="product_filter" action="{{action('ProductController@index',['slug'=>$slug])}}" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			@foreach($product_types as $product_type)
				<div class="item">
					<div class="title">{{$product_type->title}}:</div>
					<div class="content">					
						@foreach($product_type->features as $feature)
						<label class="checkbox ">  <input type="checkbox" value="{{$feature->id}}" name="features{{$product_type->id}}[]" <?php if(in_array($feature->id, $arrFeatures)): ?> checked <?php endif; ?>>  <span></span>{{$feature->title}}</label>
						@endforeach					
					</div>
				</div>
			@endforeach
			
			</form>

		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$('form#product_filter').on('click','input[type="checkbox"]',function(){
					$('#product_filter').submit();
				});
			})
		</script>

		<h2 class="color-main uppercase">{{$current_category->title}}</h2>

		<div class="page-list-products">
			
			<div class="row block-4">
				@foreach($datas as $data)
					<div class="col-sm-4 col-md-4">
						<div class="item">
							<div class="item_inner">						
								<a href="{{action('ProductController@detail',['slug'=>$data->slug])}}" class="item_img">
									<img height="300" src="{{$data->getImage('full')}}" alt="">
								</a>
								<a href="{{action('ProductController@detail',['slug'=>$data->slug])}}" class="item_title">
									@if($data->shortTitle != '') 
										{{$data->shortTitle}}
									@else
										{{$data->title}}
									@endif	
								</a>
								<ul class="list-check primary">
									<?php $excerpts = explode('|', $data->excerpt); $i=0;?>
									@foreach($excerpts as $ex)
										<?php $i++; if($i>4) break; ?>
										@if(strlen($ex)>0)
										<li>{{$ex}}</li>
										@endif
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				@endforeach	
			</div> 		

			@if($datas->lastPage() > 1)
                {{ $datas->links() }}
            @endif


		</div>			

		{!!$page->description!!}

	</div>
</div>
	@include('partials.toaTool')
@endsection	