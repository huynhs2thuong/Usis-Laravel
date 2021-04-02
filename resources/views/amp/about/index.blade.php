@extends('layouts.app')

@section('title', $page->title)

@section('content')
	{!! $page->description !!}
<section class="row-section ">
	<div class="slide-center2 owl-carousel">
		@foreach($development as $data)
			<div class="item">
				<a class="item" href="{{ action('AboutController@development') }}" title="{{$data->title}}"">
					<img src="{{$data->getImage('full')}}" alt="{{$data->title}}" />
					<h2 class="title title-more">{{$data->title}}</h2>
				</a>
			</div>
		@endforeach
	</div>
</section>

<section class="TOA041 hidden-xs" >
		<div class="row grid-space-0 block block-8">

			@foreach($project as $data)

			<div class="col-sm-3 col-xs-6 col-xxs-12">
				<a href="{{action('ProjectController@index')}}" class="block_item" style="background-image: url({!! ($data->resource_id == null) ? "https://unsplash.it/1140/445/?random" : $data->getImage('full') !!});">

					<span class="display-table">
		    			<span class="table-cell">
		    				<span class="block_title2 "> @lang('about.featured_projects') </span>
							<span class="block_title "> <span>{{$data->title}}</span></span>
							<span class="block_decs"> <i class="icon-map"> </i> {{$data->excerpt}} </span>
		    			</span>
		    		</span>

					<span class="block_title3"> {{$data->title}} </span>
				</a>
			</div>	
			@endforeach	

		</div>
</section>
<style type="text/css">
	.slide-center2 .item .title-more{
	    font-size: 22px !important;
	    text-transform: uppercase;
	    color: #fff;
	    position: fixed;
	    bottom: 3px;
	    left: 30px;
	}
</style>
@endsection
