<?php 
	if(isset($module)){
		$title = $module->title;
	}elseif(isset($page)){
		$title = $page->title;
	}else{
		$title = 'title';
	}
?>
<div id="breadcrumbs">
	<div class="container">
	<ul class="breadcrumb">
		<li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
		<li>
				{{$title}}
		</li>
	</ul>
</div>
</div>
