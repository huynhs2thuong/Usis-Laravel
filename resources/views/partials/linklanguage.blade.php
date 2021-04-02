<?php 
	$routeName = \Request::route()->getName();
	$otherurl = '';
	if($current_locale == 'en'){
		$lang = 'en';
		$urlcurget = Request::url();
		$olang = 'vn';
		LaravelLocalization::setLocale('vn');
		App::setLocale('vn');
		Session::put('locale', 'vn');
		app()->setLocale('vn');
		$url = URL::to('/').'/';
		$path1 = Request::segment(2);

		//get route name 
		
		switch ($path1){
			case 'about-us':
				$path1_r = 'gioi-thieu/';
				$otherurl = $url.$path1_r.$page->slug;
			break;
			case 'service':
				$path1_r = 'dich-vu/';
				if($routeName == 'level3Dichvu'){
					$path2_r = $secPage->slug.'/';
				}else{
					$path2_r='';
				}
				if(isset($page)){
					$otherurl = $url.$path1_r.$path2_r.$page->slug;
				}else{
					if(isset($category)){
						$otherurl = $url.$path1_r.$path2_r.$category->slug;
					}		
				}
				if($routeName == 'dtAncuChitiet'){
					$path2_r = $secPage->slug.'/';
					$path3_r = $thiPage->slug.'/';
					$otherurl = '';
					if($post->slug != ''){
						$otherurl = $url.$path1_r.$path2_r.$path3_r.$post->slug;
					}
				}
			break;
			case 'partners':
				$path1_r = 'doi-tac';
				if($routeName == 'doitacDetail'){
					$path2_r = $post->slug;
					$path1_r = $path1_r.'/';
				}else{
					$path2_r='';
				}
				$otherurl = $url.$path1_r.$path2_r;
			break;
			case 'eb-5-projects':
				$path1_r = 'du-an-dau-tu-eb-5';
				$otherurl = $url.$path1_r;
				if($routeName == 'projects-Details'){
					$otherurl = $otherurl.'/'.$project->slug;
				}
			break;
			case 'events':
				$path1_r = 'su-kien';
				if(isset($post)){
					$otherurl = $url.$path1_r.'/'.$post->slug;
				}else{
					$otherurl = $url.$path1_r.'/'.$category->slug;
				}		
			break;
			case 'news':
				$path1_r = 'tin-tuc-usis';
				$otherurl = $url.$path1_r;
				$path2_r = '';
				if(isset($post)){
					$path2_r = $post->slug;
					if($path2_r != ''){
						$otherurl = $url.$path1_r.'/'.$path2_r;
					}else{
						$otherurl = '';
					}
				}else{
					$path2_r = $category->slug;
					$otherurl = $url.$path1_r.'/'.$path2_r;
				}
			break;
			case 'life-in-america':
				$path1_r = 'cuoc-song-tai-my';
				$otherurl = $url.$path1_r;
				if(isset($post)){
					$path2_r = $post->slug;
					$otherurl = $url.$path1_r.'/'.$path2_r;
				}
			break;
			case 'regulator-law':
				$path1_r = 'luat-di-tru';
				$otherurl = $url.$path1_r;
				if(isset($post)){
					$path2_r = $post->slug;
					if($path2_r != ''){
						$otherurl = $url.$path1_r.'/'.$path2_r;
					}else{
						$otherurl = '';
					}
				}
			break;
			case 'recruitment':
				$path1_r = 'tuyen-dung';
				$otherurl = $url.$path1_r;
				if(isset($post)){
					$path2_r = $post->slug;
					if($path2_r != ''){
						$otherurl = $url.$path1_r.'/'.$path2_r;
					}else{
						$otherurl = '';
					}
				}
			break;
			case 'testimonials':
				$path1_r = 'cam-nhan-khach-hang';
				$otherurl = $url.$path1_r;
				if(isset($customer)){
					$path2_r = $customer->slug;
					if($path2_r != ''){
						$otherurl = $url.$path1_r.'/'.$path2_r;
					}else{
						$otherurl = '';
					}
				}
			break;
			case 'lien-he':
				$path1_r = 'lien-he';
				$otherurl = $url.$path1_r;
			break;
			default:
				$path1_r = '';
				$path2_r = '';
			break;
		}

		LaravelLocalization::setLocale('en');
		App::setLocale('en');
		Session::put('locale', 'en');
		app()->setLocale('en');
	}else{
		$lang = 'vn';
		$olang = 'en';
		$urlcurget = Request::url();
		LaravelLocalization::setLocale('en');
		App::setLocale('en');
		Session::put('locale', 'en');
		app()->setLocale('en');
		$url = URL::to('/').'/en/';
		$path1 = Request::segment(1);
		switch ($path1){
			case 'gioi-thieu':
				$path1_r = 'about-us/';
				$otherurl = $url.$path1_r.$page->slug;
			break;
			case 'dich-vu':
				$path1_r = 'service/';
				if($routeName == 'level3Dichvu'){
					$path2_r = $secPage->slug.'/';
				}else{
					$path2_r='';
				}
				if(isset($page)){
					$otherurl = $url.$path1_r.$path2_r.$page->slug;
				}else{
					if(isset($category)){
						$otherurl = $url.$path1_r.$path2_r.$category->slug;
					}		
				}
				if($routeName == 'dtAncuChitiet'){
					$path2_r = $secPage->slug.'/';
					$path3_r = $thiPage->slug.'/';
					$otherurl = '';
					if($post->slug != ''){
						$otherurl = $url.$path1_r.$path2_r.$path3_r.$post->slug;
					}
				}
				
			break;
			case 'doi-tac':
				$path1_r = 'partners';
				if($routeName == 'doitacDetail'){
					$path2_r = $post->slug;
					$path1_r = $path1_r.'/';
				}else{
					$path2_r='';
				}
				$otherurl = $url.$path1_r.$path2_r;
			break;
			case 'du-an-dau-tu-eb-5':
				$path1_r = 'eb-5-projects';
				$otherurl = $url.$path1_r;
				if($routeName == 'projects-Details'){
					$otherurl = $otherurl.'/'.$project->slug;
				}
			break;
			case 'su-kien':
				$path1_r = 'events';
				if(isset($post)){
					$otherurl = $url.$path1_r.'/'.$post->slug;
				}else{
					$otherurl = $url.$path1_r.'/'.$category->slug;
				}	
			break;
			case 'tin-tuc-usis':
				$path1_r = 'news';
				$otherurl = $url.$path1_r;
				$path2_r = '';
				if(isset($post)){
					$path2_r = $post->slug;
					if($path2_r != ''){
						$otherurl = $url.$path1_r.'/'.$path2_r;
					}else{
						$otherurl = '';
					}
				}else{
					$path2_r = $category->slug;
					$otherurl = $url.$path1_r.'/'.$path2_r;
				}
			break;
			case 'cuoc-song-tai-my':
				$path1_r = 'life-in-america';
				$otherurl = $url.$path1_r;
				if(isset($post)){
					$path2_r = $post->slug;
					$otherurl = $url.$path1_r.'/'.$path2_r;
				}
			break;
			case 'luat-di-tru':
				$path1_r = 'regulator-law';
				$otherurl = $url.$path1_r;
				if(isset($post)){
					$path2_r = $post->slug;
					if($path2_r != ''){
						$otherurl = $url.$path1_r.'/'.$path2_r;
					}else{
						$otherurl = '';
					}
				}
			break;
			case 'tuyen-dung':
				$path1_r = 'recruitment';
				$otherurl = $url.$path1_r;
				if(isset($post)){
					$path2_r = $post->slug;
					if($path2_r != ''){
						$otherurl = $url.$path1_r.'/'.$path2_r;
					}else{
						$otherurl = '';
					}
				}
			break;
			case 'cam-nhan-khach-hang':
				$path1_r = 'testimonials';
				$otherurl = $url.$path1_r;
				if(isset($customer)){
					$path2_r = $customer->slug;
					if($path2_r != ''){
						$otherurl = $url.$path1_r.'/'.$path2_r;
					}else{
						$otherurl = '';
					}
				}
			break;
			case 'lien-he':
				$path1_r = 'lien-he';
				$otherurl = $url.$path1_r;
			break;
			default:
				$path1_r = '';
				$path2_r = '';
			break;

		}
		LaravelLocalization::setLocale('vn');
		App::setLocale('vn');
		Session::put('locale', 'vn');
		app()->setLocale('vn');
	}
?>
<link rel="alternate" ref="{{$urlcurget}}" hreflang="{{$lang}}" />
@if($otherurl != '')
<link rel="alternate" ref="{{$otherurl}}" hreflang="{{$olang}}" />
@endif

