
@extends('layouts.app')

@section('title', 'Tìm kiếm')

@section('content')
<div class="pageSearch">

	<div class="container">
		<form class="ajaxsearch" action="">
			<meta name="csrf-token" content="{{ csrf_token() }}">
			<input id="namesearch" type="text" class="input" name="namesearch" placeholder="@lang('menu.nhap_noi_dung')" value="@if($keyword != '') {{$keyword}} @endif"/>
			<label class="reset" for="namesearch"><i class="icon-close"> </i></label>
		</form>
		<div class="loadingForm"><img src="{{URL::to('/')}}/images/loading_blue.gif"></div>
		<section class="list5 list-product">
				<div class=" list row">
					@foreach($posts as $post)
					<div class="col-md-4 col-sm-4 col-sm-6 col-xxs-12">
						<div class="list_item ">
							<?php
							$module = $post->module()->first();
							$category = $post->category()->first();
							if($module){
								if($module->slug != '' && $module->slug != NULL){
									$slug = $module->slug;
								}else{
									if($current_locale == 'en'){
										$slug = $module->alias_en;
									}else{
										$slug = $module->alias_vn;
									}
								}
								if($slug == 'tin-tuc' || $slug == 'news'){
									$link = action('SiteController@news',['slug'=>$post->slug]);
								}elseif($slug == 'du-an-dau-tu-eb-5' || $slug == 'eb-5-projects'){
									$link = action('SiteController@projectDetail',['slug'=>$post->slug]);
								}elseif($slug == 'hoat-dong-an-cu'){
									$link = action('SiteController@hdAncuChitiet',$post->slug);
								}elseif($slug == 'su-kien' || $slug == 'events'){
									$link = action('SiteController@events',['slug'=>$post->slug]);
								}elseif($slug == 'cuoc-song-tai-my' || $slug == 'life-in-america'){
									$link = action('SiteController@life',['slug'=>$post->slug]);
								}elseif($slug == 'luat-di-tru' || $slug == 'immigration-law'){
									$link = action('SiteController@lawsDetail',['slug'=>$post->slug]);
								}elseif($slug == 'cam-nhan-khach-hang' || $slug == 'testimonials'){
									$link = action('SiteController@customerDetail',['slug'=>$post->slug]);
								}elseif($slug == 'dich-vu' || $slug == 'huong-dan-dinh-cu-hoa-ky' || $slug == 'service' || $slug == 'u.s.-immigrants-guidebook'){
									$link = action('SiteController@hddcDetail',['slug'=>$post->slug]);
								}else{
									if($category){
										if($category->slug != '' && $category->slug != NULL){
											$slug = $category->slug;
										}else{
											if($current_locale == 'en'){
												$slug = $category->alias_en;
											}else{
												$slug = $category->alias_vn;
											}
										}
										if($slug == 'hoat-dong-an-cu' ){
											$first = 'dich-vu-an-cu';
										$link = action('SiteController@dtAncuChitiet',['slug'=>$first,'permalink'=>$slug,'partners'=>$post->slug]);
											// $link = action('SiteController@hdAncuChitiet',$post->slug);
										}else{
											$link ='/';
										}	
									}
										

									
								}
							}
							
							?>
							<a href="{{$link}}" class="list_img thumbCover_60">
								@if($post->content_image != '')
									<img src="http://www.usis.us/uploads/images/contents/{{$post->content_image }}" alt="" /> 
								@else
									<img src="{{$post->getImage('thumbnail')}}" alt="" /> 
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
<script>
	$(document).ready(function(){
		var requestSent = false;
		$('#namesearch').on('keyup',function(event){
			var keyword = $(this).val();
			var length = keyword.length;
			if(length >=3){
				if(!requestSent){
					requestSent = true;
				
					$.ajaxSetup({
			          headers: {
			            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			          }
			        });
			        $.ajax({
			            type: 'POST',
			            url: "{{action('SiteController@searching')}}",
			            data: {'keyword':keyword},
			            beforeSend: function(){
			                $('.loadingForm').show();
			            },
			            success: function(data){
			                $('.list-product').html(data);
			                $('.reset').css({'opacity':'1','visibility':'visible'});
			                // console.log(data);
			                $('.loadingForm').hide();
			                $('.pageSearch .list-product').css({'opacity':'1','visibility':'visible','height':'auto'})
			                requestSent = false;
			            },
			            error: function (data) {
			            	$('.loadingForm').hide();
			                // console.log('Error:', data);
			            }
			        });
		        }
			}
			// searchALl.abort();
		});
		$('.reset').click(function(){
			$('.list-product').html('');
			$('.reset').css({'opacity':'0','visibility':'hidden'});
			$('#namesearch').val('');
		})
	});
</script>
@endsection

@push('styles')
<style>
	.pageSearch .list-product{
		opacity:1;
		visibility:visible;
		height: auto
	}
	.loadingForm{
		z-index: 9999
	}
</style>
@endpush