<?php
	$canonical = '';
	if(isset($post)){
		if($post->canonical != ''){
			$canonical = $post->canonical;
		}	
	}elseif(isset($page)){
		if($page->canonical != ''){
			$canonical = $page->canonical;
		}
	}elseif(isset($project)){
		if($project->canonical != ''){
			$canonical = $project->canonical;
		}
	}elseif(isset($category)){
		if($category->canonical != ''){
			$canonical = $category->canonical;
		}
	}elseif(isset($module)){
		if($module->canonical != ''){
			$canonical = $module->canonical;
		}
	}
?>
@if($canonical == '')
	<link rel="canonical" href="{{URL::to('/')}}/{{Request::path()}}">
@else
	<link rel="canonical" href="{{$canonical}}">
@endif