@extends('layouts.amp')
@push('styleinline')
.pageSearch{min-height: calc(100vh - 90px);background-color: #fff;background: #fff url(../images/pagesearch.jpg) no-repeat bottom center;padding-bottom: 100px;}.pageSearch .ajaxsearch .input {border: none;width: 100%;font-size: 33px;border-bottom: 2px solid #1D3768;height: 50px;padding: 0 30px 0 0px;background: none;color: #1D3768;border-radius: 0;outline:none}.pageSearch .ajaxsearch {padding: 50px 0;position: relative;}.list_item amp-img img{width:100%;height:100%;object-fit:cover}
@endpush
@section('title', 'Tìm kiếm')

@section('content')
<div class="pageSearch">

	<div class="container">
		<form class="ajaxsearch" action="{{URL::current()}}" method="GET">
			<meta name="csrf-token" content="{{ csrf_token() }}">
			<input id="namesearch" type="text" class="input" name="namesearch" placeholder="@lang('menu.nhap_noi_dung')" value="@if($keyword != '') {{$keyword}} @endif"/>
			<label class="reset" for="namesearch"><i class="icon-close"> </i></label>
		</form>
		<section class="list5 list-product">
				<div class=" list row">
					@foreach($posts as $post)
					<div class="col-md-4 col-sm-4 col-sm-6 col-xxs-12">
						<div class="list_item ">
							<?php
							$module = $post->module()->first();
							$category = $post->category()->first();
							if($module){
								$slug = $module->slug;
								if($slug == 'tin-tuc' || $slug == 'news'){
									$link = action('AmpController@news',['slug'=>$post->slug]);
								}elseif($slug == 'du-an-dau-tu-eb-5' || $slug == 'eb-5-projects'){
									$link = action('AmpController@projectDetail',['slug'=>$post->slug]);
								}elseif($slug == 'hoat-dong-an-cu'){
									$link = action('AmpController@hdAncuChitiet',$post->slug);
								}elseif($slug == 'su-kien' || $slug == 'events'){
									$link = action('AmpController@events',['slug'=>$post->slug]);
								}elseif($slug == 'cuoc-song-tai-my' || $slug == 'life-in-america'){
									$link = action('AmpController@life',['slug'=>$post->slug]);
								}elseif($slug == 'luat-di-tru' || $slug == 'immigration-law'){
									$link = action('AmpController@lawsDetail',['slug'=>$post->slug]);
								}elseif($slug == 'cam-nhan-khach-hang' || $slug == 'testimonials'){
									$link = action('AmpController@customerDetail',['slug'=>$post->slug]);
								}elseif($slug == 'dich-vu' || $slug == 'huong-dan-dinh-cu-hoa-ky'){
									$link = action('AmpController@hddcDetail',['slug'=>$post->slug]);
								}else{
									$slug = $category->slug;
									if($slug == 'hoat-dong-an-cu' ){
										$first = 'dich-vu-an-cu';
									$link = action('AmpController@dtAncuChitiet',['slug'=>$first,'permalink'=>$slug,'partners'=>$post->slug]);
										// $link = action('SiteController@hdAncuChitiet',$post->slug);
									}else{
										$link ='/';
									}
								}
							}
							
							?>
							<a href="{{$link}}" class="list_img thumbCover_60">
								@if($post->content_image != '')
									<amp-img src="http://www.usis.us/uploads/images/contents/{{$post->content_image }}" width="343" height="206" layout="responsive" alt="" /> 
								@else
									<amp-img src="{{$post->getImage('thumbnail')}}" width="343" height="206" layout="responsive" alt="" /> 
								@endif
							</a>
							<div class="list_text">
								<a href="{{$link}}" class="list_title">{{ stripslashes($post->title) }}</a>
								<div class="list_position">{!! stripslashes($post->excerpt) !!}</div>
							</div>
						</div> 
					</div>
					@endforeach	
				</div>
		</section>
	</div>
</div>
@endsection