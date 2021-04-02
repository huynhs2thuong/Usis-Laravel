@extends('layouts.app')

@section('content')
	{!!  Breadcrumbs::render('post', $post)  !!}

	<div class="wrap-page-title-emty"></div>
	<div id="maincontent">
		<div class="container">
			<div class="max-830">
				<h2 class="color-main text-center"> <span>{{$post->title}}</span></h2>
				{!!  $post->description !!}
			</div>
			<div class="share">
				<a href="" class="fb"><img src="{{asset('images/share/fb.png')}}" alt=""></a>
				<a href="" class="in"><img src="{{asset('images/share/in.png')}}" alt=""></a>
				<a href="" class="you"><img src="{{asset('images/share/you.png')}}" alt=""></a>
				<a href="" class="tw"><img src="{{asset('images/share/tw.png')}}" alt=""></a>
				<a href="" class="gg"><img src="{{asset('images/share/gg.png')}}" alt=""></a>
			</div>
		</div>
		<div class="bottom-content bg-1 TOA001">
			<div class="container">
				<div class="row block-1">
					@foreach($relateds as $related)
						<div class="col-sm-4 col-md-4">
							<div class="item">
								<a href="{{ action('AboutController@index',['slug' => $related->slug]) }}" class="item_img">
									<img src="{!! ($related->resource_id == null) ? "https://unsplash.it/360/251/?random" : $related->getImage('thumbnail')!!}" alt="">
								</a>
								<div class="item_content">
									<p class="item_date">{{date('d-MM-Y', strtotime($related->created_at))}}</p>
									<a href="{{ action('AboutController@index',['slug' => $related->slug]) }}" class="item_title">
										{{$related->title}}
									</a>
								</div>
							</div>
						</div>
					@endforeach
				</div> <!--End row-->
				<a href="{{ action('AboutController@index',['slug' => $slug]) }}" class="more btn  btn-primary"> <span class="inner">@lang('about.more')</span></a>
			</div>
		</div>
	</div>
@endsection
