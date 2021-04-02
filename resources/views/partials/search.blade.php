@if(count($posts)>0)
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
				}elseif($slug == 'dich-vu' || $slug == 'huong-dan-dinh-cu-hoa-ky'){
					$link = action('SiteController@hddcDetail',['slug'=>$post->slug]);
				}else{
					$slug = $category->slug;
					if($slug == 'hoat-dong-an-cu' ){
						$first = 'dich-vu-an-cu';
					$link = action('SiteController@dtAncuChitiet',['slug'=>$first,'permalink'=>$slug,'partners'=>$post->slug]);
						// $link = action('SiteController@hdAncuChitiet',$post->slug);
					}else{
						$link ='/';
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

@endif
