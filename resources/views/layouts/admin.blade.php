<!DOCTYPE html>
<html lang="{{ $current_locale }}">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="format-detection" content="telephone=no">
	<meta name="msapplication-tap-highlight" content="no">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="robots" content="noindex">
	<title>Admin - Usis</title>
	<link rel="icon" href="/images/logo.png" sizes="32x32">
	<!-- CORE CSS-->
	<link href="/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
	<link href="/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
	<!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
	<link href="/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
	<link rel="stylesheet" type="text/css" href="/js/plugins/data-tables/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="/css/plugins/select.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="/css/plugins/dropzone.min.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link href="/css/admin.css" type="text/css" rel="stylesheet" media="screen,projection">
	<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->

    <script>
        // var options = {
        // filebrowserImageBrowseUrl: '{{URL::to('/')}}/laravel-filemanager?type=Images',
        //     filebrowserImageUploadUrl: '{{URL::to('/')}}/laravel-filemanager/upload?type=Images&_token=',
        //     filebrowserBrowseUrl: '{{URL::to('/')}}/laravel-filemanager?type=Files',
        //     filebrowserUploadUrl: '{{URL::to('/')}}/laravel-filemanager/upload?type=Files&_token='
        // };
        // jQuery(document).ready(function($){
        //     $('.description').ckeditor(options);
        // })
        
        // var lfm = function(options, cb) {

        //     var route_prefix = (options && options.prefix) ? options.prefix : '{{URL::to('/')}}/laravel-filemanager';

        //     window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
        //     window.SetUrl = cb;
        // }
        // lfm({type: 'image', prefix: 'prefix'}, function(url, path) {

        // });
    </script>
	@stack('styles')
	<style>
		.side-nav .collapsible-body{
			border-bottom: 1px solid #ccc;
		}
	</style>
</head>
<?php 
// $user = Auth::user()->level;
// var_dump($user);die;
 ?>
<body ng-app="jollibee">
	<!-- Start Page Loading -->
	<div id="loader-wrapper">
		<div id="loader"></div>
		<div class="loader-section section-left"></div>
		<div class="loader-section section-right"></div>
	</div>
	<!-- End Page Loading -->
	<header id="header" class="page-topbar">
		<div class="navbar-fixed">
			<nav class="navbar-color">
				<div class="nav-wrapper">
					<ul class="left">
						<li><h1 class="logo-wrapper"><a href="{{ route('home') }}" class="brand-logo darken-1" target="_blank"><img src="/images/logo.png" alt="logo" width="64" height="64"></a> <span class="logo-text">Jollibee</span></h1></li>
					</ul>
					<ul class="header-search-wrapper hide-on-med-and-down">
						<li>@yield('view-page')</li>
					</ul>
					<ul class="right hide-on-med-and-down">
						<li><a href="javascript:void(0);" class="waves-effect waves-block waves-light translation-button" data-activates="translation-dropdown"><img src="/images/flag-icons/{{ $current_locale }}.png" alt="" /></a></li>
						<li><a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen"><i class="mdi-action-settings-overscan"></i></a></li>
						{{-- <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light notification-button" data-activates="notifications-dropdown"><i class="mdi-social-notifications"><small class="notification-badge">5</small></i>                    </a>                        </li> --}}
						{{-- <li><a href="#" data-activates="chat-out" class="waves-effect waves-block waves-light chat-collapse"><i class="mdi-communication-chat"></i></a>                        </li> --}}
					</ul>
					<!-- translation-button -->
					<ul id="translation-dropdown" class="dropdown-content">
						@foreach ($supported_locales as $localeCode => $properties)
							<li><a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}"><img src="/images/flag-icons/{{ $localeCode }}.png" alt="{{ $properties['native'] }}" /> <span class="language-select">{{ $properties['native'] }}</span></a></li>
						@endforeach
						{{-- <li><a href="#!"><img src="/images/flag-icons/en.png" alt="English" /> <span class="language-select">English</span></a></li> --}}
					</ul>
					<!-- notifications-dropdown -->
					<!-- <ul id="notifications-dropdown" class="dropdown-content">
						<li>
							<h5>NOTIFICATIONS <span class="new badge">5</span></h5>
						</li>
						<li class="divider"></li>
						<li>
							<a href="#!"><i class="mdi-action-add-shopping-cart"></i> A new order has been placed!</a>
							<time class="media-meta" datetime="2015-06-12T20:50:48+08:00">2 hours ago</time>
						</li>
						<li>
							<a href="#!"><i class="mdi-action-stars"></i> Completed the task</a>
							<time class="media-meta" datetime="2015-06-12T20:50:48+08:00">3 days ago</time>
						</li>
						<li>
							<a href="#!"><i class="mdi-action-settings"></i> Settings updated</a>
							<time class="media-meta" datetime="2015-06-12T20:50:48+08:00">4 days ago</time>
						</li>
						<li>
							<a href="#!"><i class="mdi-editor-insert-invitation"></i> Director meeting started</a>
							<time class="media-meta" datetime="2015-06-12T20:50:48+08:00">6 days ago</time>
						</li>
						<li>
							<a href="#!"><i class="mdi-action-trending-up"></i> Generate monthly report</a>
							<time class="media-meta" datetime="2015-06-12T20:50:48+08:00">1 week ago</time>
						</li>
					</ul> -->
				</div>
			</nav>
		</div>
	</header>

	<div id="main">
		<div class="wrapper">
			<!-- START LEFT SIDEBAR NAV-->
			<aside id="left-sidebar-nav">
				<ul id="slide-out" class="side-nav fixed leftside-navigation collapsible" data-collapsible="accordion">
					<li class="user-details cyan darken-2">
						<div class="row">
							<div class="col s4 m4 l4">
								<img src="/images/user-default.png" alt="" class="circle responsive-img valign profile-image">
							</div>
							<div class="col s8 m8 l8">
								<ul id="profile-dropdown" class="dropdown-content">
									<li><a href="{{ action('Admin\UserController@edit', Auth::user()->id) }}"><i class="mdi-action-face-unlock"></i> Profile</a></li>
									{{-- <li><a href="#"><i class="mdi-action-settings"></i> Settings</a></li>
									<li><a href="#"><i class="mdi-communication-live-help"></i> Help</a></li>
									<li class="divider"></li>
									<li><a href="#"><i class="mdi-action-lock-outline"></i> Lock</a></li> --}}
									<li>
										<form action="{{ route('logout_admin') }}" method="POST" class="" role="form">
											{{ csrf_field() }}
											<button class="btn-logout" type="submit"><i class="mdi-hardware-keyboard-tab"></i> Logout</button>
										</form>
									</li>
								</ul>
								<a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown">{{ Auth::user()->name }}<i class="mdi-navigation-arrow-drop-down right"></i></a>
								<p class="user-roal text-capitalize">{{ Auth::user()->level }}</p>
							</div>
						</div>
					</li>
					<li class="no-padding bold">
						<a class="collapsible-header waves-effect waves-cyan {{ active_class((if_controller(['App\Http\Controllers\Admin\PostController']) || if_controller(['App\Http\Controllers\Admin\ModuleController']) ||if_controller(['App\Http\Controllers\Admin\CategoryController']) && $type=='post')) }}"><i class="mdi-editor-border-color"></i> @lang('admin.object.post')</a>
						<div class="collapsible-body">
							<ul>
								<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\PostController@index'])) }}"><a href="{{ action('Admin\PostController@index') }}">@lang('admin.title.index', ['object' => trans('admin.object.post')])</a></li>
								<li class="{{ active_class((if_controller(['App\Http\Controllers\Admin\CategoryController']) && $type=='post')) }}"><a href="{{ action('Admin\CategoryController@index',['type' => 'post']) }}">@lang('admin.object.category')</a></li>
								<li class="{{ active_class((if_controller(['App\Http\Controllers\Admin\ModuleController']))) }}"><a href="{{ action('Admin\ModuleController@index') }}">@lang('admin.object.module')</a></li>
								<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\PostController@create'])) }}"><a href="{{ action('Admin\PostController@create') }}">@lang('admin.title.create raw')</a></li>
							</ul>
						</div>

					</li>
					<li class="no-padding bold">

								<a class="collapsible-header waves-effect waves-cyan {{ active_class((if_controller(['App\Http\Controllers\Admin\ProjectController']) || if_controller(['App\Http\Controllers\Admin\CategoryController']) && $type=='project')) }}"><i class="mdi-social-location-city"></i> @lang('admin.object.project')</a>
								<div class="collapsible-body">
									<ul>
										<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\ProjectController@index'])) }}"><a href="{{ action('Admin\ProjectController@index') }}">@lang('admin.title.index', ['object' => trans('admin.object.project')])</a></li>
										<li class="{{ active_class((if_controller(['App\Http\Controllers\Admin\CategoryController']) && $type=='project')) }}"><a href="{{ action('Admin\CategoryController@index', ['type' => 'project']) }}">@lang('admin.object.category')</a></li>
										<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\ProjectController@create'])) }}"><a href="{{ action('Admin\ProjectController@create') }}">@lang('admin.title.create raw')</a></li>
									</ul>
								</div>

					</li>
					<li class="no-padding bold">

						<a class="collapsible-header waves-effect waves-cyan {{ active_class(if_controller(['App\Http\Controllers\Admin\ServiceController'])) }}"><i class="mdi-action-question-answer"></i> @lang('admin.object.faq')</a>
						<div class="collapsible-body">
							<ul>
								<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\ServiceController@index'])) }}"><a href="{{ action('Admin\ServiceController@index') }}">@lang('admin.title.index', ['object' => trans('admin.object.faq')])</a></li>
								<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\ServiceController@create'])) }}"><a href="{{ action('Admin\ServiceController@create') }}">@lang('admin.title.create raw')</a></li>
							</ul>
						</div>

					</li>
					
					<li class="no-padding bold">

						<a class="collapsible-header waves-effect waves-cyan {{ active_class(if_controller(['App\Http\Controllers\Admin\MenuController'])) }}"><i class="mdi-navigation-menu"></i> @lang('admin.object.menu')</a>
						<div class="collapsible-body">
							<ul>
								<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\MenuController@index'])) }}"><a href="{{ action('Admin\MenuController@index') }}">@lang('admin.title.index', ['object' => trans('admin.object.menu')])</a></li>
								<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\MenuController@create'])) }}"><a href="{{ action('Admin\MenuController@create') }}">@lang('admin.title.create raw')</a></li>
							</ul>
						</div>

					</li>
					<li class="no-padding bold">

						<a class="collapsible-header waves-effect waves-cyan {{ active_class(if_controller(['App\Http\Controllers\Admin\PageController'])) }}"><i class="mdi-social-pages"></i> @lang('admin.object.page')</a>
						<div class="collapsible-body">
							<ul>
								<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\PageController@index'])) }}"><a href="{{ action('Admin\PageController@index') }}">@lang('admin.title.index', ['object' => trans('admin.object.page')])</a></li>
								<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\PageController@create'])) }}"><a href="{{ action('Admin\PageController@create') }}">@lang('admin.title.create raw')</a></li>
							</ul>
						</div>

					</li>
					<li class="no-padding bold">

						<a class="collapsible-header waves-effect waves-cyan {{ active_class(if_controller(['App\Http\Controllers\Admin\HoidongController'])) }}"><i class="mdi-action-assignment-ind"></i> @lang('admin.object.nhan_su')</a>
						<div class="collapsible-body">
							<ul>
								<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\HoidongController@index'])) }}"><a href="{{ action('Admin\HoidongController@index') }}">@lang('admin.title.index', ['object' => trans('admin.object.nhan_su')])</a></li>
								<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\HoidongController@create'])) }}"><a href="{{ action('Admin\HoidongController@create') }}">@lang('admin.title.create raw')</a></li>
							</ul>
						</div>

					</li>

					<li class="no-padding bold">
						<a class="collapsible-header waves-effect waves-cyan {{ active_class(if_controller(['App\Http\Controllers\Admin\OmemberController'])) }}"><i class="mdi-action-assignment-ind"></i> @lang('admin.object.nhan_su_khac')</a>
						<div class="collapsible-body">
							<ul>
								<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\OmemberController@index'])) }}"><a href="{{ action('Admin\OmemberController@index') }}">@lang('admin.title.index', ['object' => trans('admin.object.nhan_su_khac')])</a></li>
								<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\OmemberController@create'])) }}"><a href="{{ action('Admin\OmemberController@create') }}">@lang('admin.title.create raw')</a></li>
							</ul>
						</div>
					</li>

					<li class="no-padding bold">
						<a href="{{ action('Admin\FormController@index') }}"><i class="mdi-device-developer-mode"></i> @lang('admin.title.index', ['object' => trans('admin.object.form')])</a>
					</li>
					<li class="no-padding bold">
						<a href="{{ action('Admin\SettingController@redirectLink') }}"><i class="mdi-content-link"></i> Redirect Link</a>
					</li>
					 <li class="no-padding bold">
						<a href="{{ action('Admin\SettingController@basicSetting') }}"><i class="mdi-action-settings-applications"></i>@lang('admin.title.setting')</a>
					</li>
					@can('manage-user', User::class)
                    <li class="no-padding bold">

                                <a class="collapsible-header waves-effect waves-cyan {{ active_class(if_controller(['App\Http\Controllers\Admin\UserController'])) }}"><i class="mdi-action-account-circle"></i> @lang('admin.object.user')</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li class="{{ active_class(if_action(['App\Http\Controllers\Admin\UserController@index'])) }}"><a href="{{ action('Admin\UserController@index') }}">@lang('admin.title.index', ['object' => trans('admin.object.user')])</a></li>
                                        <li class="{{ active_class(if_action(['App\Http\Controllers\Admin\UserController@create'])) }}"><a href="{{ action('Admin\UserController@create') }}">@lang('admin.title.create raw')</a></li>
                                    </ul>
                                </div>

                    </li>
                    @endcan
                    @can('ltm-admin-translations', User::class)
                    <li><a href="{{URL::to('/')}}/translations">Translation</a></li>
                    @endcan
                    <li><a href="{{action('Admin\SettingController@filemanager')}}"><i class="mdi-image-add-to-photos"></i>Image Manager</a></li>
					{{--<li class="bold"><a href="{{ action('Admin\ContactController@index') }}" class="waves-effect waves-cyan"><i class="mdi-communication-email"></i> @lang('admin.object.contact')</a></li>--}}
					{{--@can('manage-user', User::class)--}}
					{{--<li class="no-padding bold">--}}

								{{--<a class="collapsible-header waves-effect waves-cyan {{ active_class(if_controller(['App\Http\Controllers\Admin\UserController'])) }}"><i class="mdi-action-account-circle"></i> @lang('admin.object.user')</a>--}}
								{{--<div class="collapsible-body">--}}
									{{--<ul>--}}
										{{--<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\UserController@index'])) }}"><a href="{{ action('Admin\UserController@index') }}">@lang('admin.title.index', ['object' => trans('admin.object.user')])</a></li>--}}
										{{--<li class="{{ active_class(if_action(['App\Http\Controllers\Admin\UserController@create'])) }}"><a href="{{ action('Admin\UserController@create') }}">@lang('admin.title.create raw')</a></li>--}}
									{{--</ul>--}}
								{{--</div>--}}

					{{--</li>--}}
					{{--@endcan--}}
					{{--<li class="no-padding bold">
						<ul>
							<li class="bold">
								<a class="collapsible-header waves-effect waves-cyan {{ active_class(if_controller(['App\Http\Controllers\Admin\SettingController'])) }}"><i class="mdi-action-settings"></i> @lang('admin.object.setting')</a>
								<div class="collapsible-body">
									<ul>
										<li class="{{ active_class(if_route_param('name', 'home-banner')) }}"><a href="{{ route('setting', 'home-banner') }}">@lang('admin.setting.home-banner')</a></li>
										<li class="{{ active_class(if_route_param('name', 'home-promo')) }}"><a href="{{ route('setting', 'home-promo') }}">@lang('admin.setting.home-promo')</a></li>
									</ul>
								</div>
							</li>
						</ul>
					</li>--}}
				</ul>
				<a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
			</aside>
			<!-- END LEFT SIDEBAR NAV-->
			<section id="content">
				<div class="container">@yield('content')</div>
			</section>
		</div>
	</div>
	<div class="modal" id="modal-upload">
		<div class="modal-content">
			<h4 class="modal-title">@lang('admin.title.upload image')</h4>
			<div id="uploader" class="dropzone"></div>
		</div>
	</div>
	<div class="modal" id="modal-upload2">
		<div class="modal-content">
			<h4 class="modal-title">@lang('admin.title.upload image')</h4>
			<div id="uploader2" class="dropzone"></div>
		</div>
	</div>
	<div class="modal" id="modal-upload3">
		<div class="modal-content">
			<h4 class="modal-title">@lang('admin.title.upload image')</h4>
			<div id="uploader3" class="dropzone"></div>
		</div>
	</div>
	@for($i=9;$i<=12;$i++)
	<div class="modal" id="modal-upload{{$i}}">
		<div class="modal-content">
			<h4 class="modal-title">@lang('admin.title.upload image')</h4>
			<div id="uploader{{$i}}" class="dropzone"></div>
		</div>
	</div>
	@endfor
	<div class="modal" id="modal-upload15">
		<div class="modal-content">
			<h4 class="modal-title">@lang('admin.title.upload image')</h4>
			<div id="uploader15" class="dropzone"></div>
		</div>
	</div>
	<script type="text/javascript" src="/js/plugins/jquery-1.11.2.min.js"></script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->




<!-- <script type="text/javascript" src="/js/plugins/jquery-1.11.2.min.js"></script> -->
	<script type="text/javascript" src="/js/materialize.min.js"></script>
	<script type="text/javascript" src="/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script type="text/javascript" src="/js/plugins.min.js"></script>

	<script type="text/javascript" src="/js/plugins/data-tables/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="/js/plugins/data-tables/js/dataTables.select.min.js"></script>
	<script type="text/javascript" src="/js/plugins/jquery-validation/jquery.validate.min.js"></script>
	<script type="text/javascript" src="/js/plugins/jquery-validation/additional-methods.min.js"></script>
	<script type="text/javascript" src="/js/plugins/dropzone.js"></script>
	<script type="text/javascript" src="/js/plugins/tabs.js"></script>
	<script type="text/javascript" src="/js/jquery.nestable.js"></script>
	<script src="https://cdn.jsdelivr.net/gh/jquery-form/form@4.2.2/dist/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script>
	<script type="text/javascript">
		current_locale_name = '{{ LaravelLocalization::getCurrentLocaleName() }}';
		current_locale      = '{{ $current_locale }}';

		$postimagediv       = $('.postimagediv');
		$uploader           = $('#uploader');
		$modalupload        = $('#modal-upload');

		$postimagediv2       = $('.postimagediv2');
		$uploader2           = $('#uploader2');
		$modalupload2        = $('#modal-upload2');

		$postimagediv3       = $('.postimagediv3');
		$uploader3           = $('#uploader3');
		$modalupload3        = $('#modal-upload3');

		$postimagediv15       = $('.postimagediv15');
		$uploader15           = $('#uploader15');
		$modalupload15        = $('#modal-upload15');

		Dropzone.options.uploader = {
			url: '{{ action('Admin\ResourceController@store') }}',
			paramName: 'upload',
			thumbnailWidth: 150,
			thumbnailHeight: 150,
			acceptedFiles: 'image/*',
			sending: function(file, xhr, formData) {
				formData.append('type', '{{ str_replace('Controller', '', explode('@', class_basename(Route::currentRouteAction()))[0]) }}');
				formData.append('resize', 1);
			},
			success: function(file, response) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$postimagediv.find('img').attr('src', e.target.result);
				}
				reader.readAsDataURL(file);
				// $postimagediv.find('img').attr('src', response.thumbnail);
				$postimagediv.find('input').val(response.id);
				$postimagediv.find('.set-image').addClass('hide');
				$postimagediv.find('.remove-image').removeClass('hide');
				$modalupload.closeModal();
				this.removeAllFiles();
			}
		};

		Dropzone.options.uploader2 = {
			url: '{{ action('Admin\ResourceController@store') }}',
			paramName: 'upload',
			thumbnailWidth: 150,
			thumbnailHeight: 150,
			acceptedFiles: 'image/*',
			sending: function(file, xhr, formData) {
				formData.append('type', '{{ str_replace('Controller', '', explode('@', class_basename(Route::currentRouteAction()))[0]) }}');
				formData.append('resize', 1);
			},
			success: function(file, response) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$postimagediv2.find('img').attr('src', e.target.result);
				}
				reader.readAsDataURL(file);
				// $postimagediv.find('img').attr('src', response.thumbnail);
				$postimagediv2.find('input').val(response.id);
				$postimagediv2.find('.set-image').addClass('hide');
				$postimagediv2.find('.remove-image2').removeClass('hide');
				$modalupload2.closeModal();
				this.removeAllFiles();
			}
		};

		Dropzone.options.uploader3 = {
			url: '{{ action('Admin\ResourceController@store') }}',
			paramName: 'upload',
			thumbnailWidth: 150,
			thumbnailHeight: 150,
			acceptedFiles: 'image/*',
			sending: function(file, xhr, formData) {
				formData.append('type', '{{ str_replace('Controller', '', explode('@', class_basename(Route::currentRouteAction()))[0]) }}');
				formData.append('resize', 1);
			},
			success: function(file, response) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$postimagediv3.find('img').attr('src', e.target.result);
				}
				reader.readAsDataURL(file);
				// $postimagediv.find('img').attr('src', response.thumbnail);
				$postimagediv3.find('input').val(response.id);
				$postimagediv3.find('.set-image').addClass('hide');
				$postimagediv3.find('.remove-image').removeClass('hide');
				$modalupload3.closeModal();
				this.removeAllFiles();
			}
		};

		Dropzone.options.uploader15 = {
			url: '{{ action('Admin\ResourceController@store') }}',
			paramName: 'upload',
			thumbnailWidth: 150,
			thumbnailHeight: 150,
			acceptedFiles: 'image/*',
			sending: function(file, xhr, formData) {
				formData.append('type', '{{ str_replace('Controller', '', explode('@', class_basename(Route::currentRouteAction()))[0]) }}');
				formData.append('resize', 1);
			},
			success: function(file, response) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$postimagediv15.find('img').attr('src', e.target.result);
				}
				reader.readAsDataURL(file);
				// $postimagediv.find('img').attr('src', response.thumbnail);
				$postimagediv15.find('input').val(response.id);
				$postimagediv15.find('.set-image').addClass('hide');
				$postimagediv15.find('.remove-image').removeClass('hide');
				$modalupload15.closeModal();
				this.removeAllFiles();
			}
		};

		$postimagediv.on('click', '.remove-image', function(event) {
			event.preventDefault();
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			var $input = $postimagediv.find('input');
			$.post('{{ action('Admin\ResourceController@destroy', 'id') }}'.replace('id', $input.val()), {_method: 'DELETE'}, function(data, textStatus, xhr) {
				if (data.status === 'success') {
					$postimagediv.find('.set-image').removeClass('hide');
					$postimagediv.find('.remove-image').addClass('hide');
					$postimagediv.find('img').attr('src', '{{ App\Resource::NO_SRC }}');
					$input.val('');
				}
			});
		   
		});

		//chay remove image setting
		$postimagediv.on('click', '.remove-image3', function(event) {
			event.preventDefault();
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			var $input = $postimagediv.find('input');
			$.post('{{ action('Admin\ResourceController@destroy', 'id') }}'.replace('id', $input.val()), {_method: 'DELETE'}, function(data, textStatus, xhr) {
				if (data.status === 'success') {
					$postimagediv.find('.set-image').removeClass('hide');
					$postimagediv.find('.remove-image3').addClass('hide');
					$postimagediv.find('img').attr('src', '{{ App\Resource::NO_SRC }}');
					$input.val('');
				}
			});
			$.post('{{ action('Admin\SettingController@removeResource') }}'.replace('id', $input.val()), {_method: 'DELETE'}, function(data, textStatus, xhr) {
			});
		   
		});

		//chay remove image setting
		$postimagediv15.on('click', '.remove-image15', function(event) {
			event.preventDefault();
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			var $input = $postimagediv15.find('input');
			$.post('{{ action('Admin\ResourceController@destroy', 'id') }}'.replace('id', $input.val()), {_method: 'DELETE'}, function(data, textStatus, xhr) {
				if (data.status === 'success') {
					$postimagediv15.find('.set-image').removeClass('hide');
					$postimagediv15.find('.remove-image15').addClass('hide');
					$postimagediv15.find('img').attr('src', '{{ App\Resource::NO_SRC }}');
					$input.val('');
				}
			});
			$.post('{{ action('Admin\SettingController@removeResource') }}'.replace('id', $input.val()), {_method: 'DELETE'}, function(data, textStatus, xhr) {
			});
		   
		});

		//chay remove image setting
		$postimagediv2.on('click', '.remove-image2', function(event) {
			event.preventDefault();
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			var $input = $postimagediv2.find('input');
			$.post('{{ action('Admin\ResourceController@destroy', 'id') }}'.replace('id', $input.val()), {_method: 'DELETE'}, function(data, textStatus, xhr) {
				if (data.status === 'success') {
					$postimagediv2.find('.set-image').removeClass('hide');
					$postimagediv2.find('.remove-image2').addClass('hide');
					$postimagediv2.find('img').attr('src', '{{ App\Resource::NO_SRC }}');
					$input.val('');
				}
			});
			$.post('{{ action('Admin\SettingController@removeResource') }}'.replace('id', $input.val()), {_method: 'DELETE'}, function(data, textStatus, xhr) {
			});
		   
		});

		$postimagediv2.on('click', '.remove-image4', function(event) {
			event.preventDefault();
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			var $input = $postimagediv2.find('input');
			$.post('{{ action('Admin\ResourceController@destroy', 'id') }}'.replace('id', $input.val()), {_method: 'DELETE'}, function(data, textStatus, xhr) {
				if (data.status === 'success') {
					$postimagediv2.find('.set-image').removeClass('hide');
					$postimagediv2.find('.remove-image').addClass('hide');
					$postimagediv2.find('img').attr('src', '{{ App\Resource::NO_SRC }}');
					$input.val('');
				}
			});
		});

		$postimagediv3.on('click', '.remove-image5', function(event) {
			event.preventDefault();
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			var $input = $postimagediv3.find('input');
			$.post('{{ action('Admin\ResourceController@destroy', 'id') }}'.replace('id', $input.val()), {_method: 'DELETE'}, function(data, textStatus, xhr) {
				if (data.status === 'success') {
					$postimagediv3.find('.set-image').removeClass('hide');
					$postimagediv3.find('.remove-image').addClass('hide');
					$postimagediv3.find('img').attr('src', '{{ App\Resource::NO_SRC }}');
					$input.val('');
				}
			});
		});

		$postimagediv9       = $('.postimagediv9');
		$uploader9         = $('#uploader9');
		$modalupload9       = $('#modal-upload9');
		Dropzone.options.uploader9 = {
			url: '{{ action('Admin\ResourceController@store') }}',
			paramName: 'upload',
			thumbnailWidth: 150,
			thumbnailHeight: 150,
			acceptedFiles: 'image/*',
			sending: function(file, xhr, formData) {
				formData.append('type', '{{ str_replace('Controller', '', explode('@', class_basename(Route::currentRouteAction()))[0]) }}');
				formData.append('resize', 1);
			},
			success: function(file, response) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$postimagediv9.find('img').attr('src', e.target.result);
				}
				reader.readAsDataURL(file);
				// $postimagediv.find('img').attr('src', response.thumbnail);
				$postimagediv9.find('input').val(response.id);
				$postimagediv9.find('.set-image').addClass('hide');
				$postimagediv9.find('.remove-image').removeClass('hide');
				$modalupload9.closeModal();
				this.removeAllFiles();
			}
		};

		$postimagediv9.on('click', '.remove-image9', function(event) {

			event.preventDefault();
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;

			var $input = $postimagediv9.find('input');
			var id = $(this).closest('input[name="footer_image9"]').val();
			$(this).closest('form').ajaxSubmit({
				target: "{{action('Admin\SettingController@updateBasic')}}"
			});
			$.post('{{ action('Admin\ResourceController@destroy', 'id') }}'.replace('id', $input.val()), {_method: 'DELETE'}, function(data, textStatus, xhr) {
				if (data.status === 'success') {
					$postimagediv9.find('.set-image').removeClass('hide');
					$postimagediv9.find('.remove-image9').addClass('hide');
					$postimagediv9.find('img').attr('src', '{{ App\Resource::NO_SRC }}');
					$input.val('');
				}
			});

		});
		
		$postimagediv12       = $('.postimagediv12');
		$uploader12         = $('#uploader12');
		$modalupload12       = $('#modal-upload12');
		Dropzone.options.uploader12 = {
			url: '{{ action('Admin\ResourceController@store') }}',
			paramName: 'upload',
			thumbnailWidth: 150,
			thumbnailHeight: 150,
			acceptedFiles: 'image/*',
			sending: function(file, xhr, formData) {
				formData.append('type', '{{ str_replace('Controller', '', explode('@', class_basename(Route::currentRouteAction()))[0]) }}');
				formData.append('resize', 1);
			},
			success: function(file, response) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$postimagediv12.find('img').attr('src', e.target.result);
				}
				reader.readAsDataURL(file);
				// $postimagediv.find('img').attr('src', response.thumbnail);
				$postimagediv12.find('input').val(response.id);
				$postimagediv12.find('.set-image').addClass('hide');
				$postimagediv12.find('.remove-image').removeClass('hide');
				$modalupload12.closeModal();
				this.removeAllFiles();
			}
		};

		$postimagediv12.on('click', '.remove-image12', function(event) {
			event.preventDefault();
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			var $input = $postimagediv12.find('input');
			$(this).closest('form').ajaxSubmit({
				target: "{{action('Admin\SettingController@updateBasic')}}"
			});
			var id = $(this).closest('input[name="footer_image12"]').val();
			$.post('{{ action('Admin\ResourceController@destroy', 'id') }}'.replace('id', $input.val()), {_method: 'DELETE'}, function(data, textStatus, xhr) {
				if (data.status === 'success') {
					$postimagediv12.find('.set-image').removeClass('hide');
					$postimagediv12.find('.remove-image12').addClass('hide');
					$postimagediv12.find('img').attr('src', '{{ App\Resource::NO_SRC }}');
					$input.val('');
				}
			});
		});

		$postimagediv10       = $('.postimagediv10');
		$uploader10         = $('#uploader10');
		$modalupload10       = $('#modal-upload10');
		Dropzone.options.uploader10 = {
			url: '{{ action('Admin\ResourceController@store') }}',
			paramName: 'upload',
			thumbnailWidth: 150,
			thumbnailHeight: 150,
			acceptedFiles: 'image/*',
			sending: function(file, xhr, formData) {
				formData.append('type', '{{ str_replace('Controller', '', explode('@', class_basename(Route::currentRouteAction()))[0]) }}');
				formData.append('resize', 1);
			},
			success: function(file, response) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$postimagediv10.find('img').attr('src', e.target.result);
				}
				reader.readAsDataURL(file);
				// $postimagediv.find('img').attr('src', response.thumbnail);
				$postimagediv10.find('input').val(response.id);
				$postimagediv10.find('.set-image').addClass('hide');
				$postimagediv10.find('.remove-image').removeClass('hide');
				$modalupload10.closeModal();
				this.removeAllFiles();
			}
		};

		$postimagediv10.on('click', '.remove-image10', function(event) {
			event.preventDefault();
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			var $input = $postimagediv10.find('input');
			var id = $(this).closest('input[name="footer_image10"]').val();
			$(this).closest('form').ajaxSubmit({
				target: "{{action('Admin\SettingController@updateBasic')}}"
			});
			$.post('{{ action('Admin\ResourceController@destroy', 'id') }}'.replace('id', $input.val()), {_method: 'DELETE'}, function(data, textStatus, xhr) {
				if (data.status === 'success') {
					$postimagediv10.find('.set-image').removeClass('hide');
					$postimagediv10.find('.remove-image10').addClass('hide');
					$postimagediv10.find('img').attr('src', '{{ App\Resource::NO_SRC }}');
					$input.val('');
				}
			});
		});

		$postimagediv11       = $('.postimagediv11');
		$uploader11         = $('#uploader11');
		$modalupload11       = $('#modal-upload11');
		Dropzone.options.uploader11 = {
			url: '{{ action('Admin\ResourceController@store') }}',
			paramName: 'upload',
			thumbnailWidth: 150,
			thumbnailHeight: 150,
			acceptedFiles: 'image/*',
			sending: function(file, xhr, formData) {
				formData.append('type', '{{ str_replace('Controller', '', explode('@', class_basename(Route::currentRouteAction()))[0]) }}');
				formData.append('resize', 1);
			},
			success: function(file, response) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$postimagediv11.find('img').attr('src', e.target.result);
				}
				reader.readAsDataURL(file);
				// $postimagediv.find('img').attr('src', response.thumbnail);
				$postimagediv11.find('input').val(response.id);
				$postimagediv11.find('.set-image').addClass('hide');
				$postimagediv11.find('.remove-image').removeClass('hide');
				$modalupload11.closeModal();
				this.removeAllFiles();
			}
		};

		$postimagediv11.on('click', '.remove-image11', function(event) {
			event.preventDefault();
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			var $input = $postimagediv11.find('input');
			var id = $(this).closest('input[name="footer_image11"]').val();
			$(this).closest('form').ajaxSubmit({
				target: "{{action('Admin\SettingController@updateBasic')}}"
			});
			$.post('{{ action('Admin\ResourceController@destroy', 'id') }}'.replace('id', $input.val()), {_method: 'DELETE'}, function(data, textStatus, xhr) {
				if (data.status === 'success') {
					$postimagediv11.find('.set-image').removeClass('hide');
					$postimagediv11.find('.remove-image11').addClass('hide');
					$postimagediv11.find('img').attr('src', '{{ App\Resource::NO_SRC }}');
					$input.val('');
				}
			});
		});

	</script>
	<script type="text/javascript" src="/js/custom-script.js"></script>
	@stack('scripts')
	 <script>
      var options = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
      };
    </script>
<!-- 	<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
	<script src="/vendor/unisharp/laravel-ckeditor/config.js"></script> -->
	<script src="{{URL::to('/')}}/editor/ckeditor.js"></script>
    <script src="{{URL::to('/')}}/editor/jquery.js"></script>
	<script src="{{URL::to('/')}}/editor/config.js"></script>
    <script>
    	jQuery(document).ready(function($){
    	// $('description').ckeditor();
        $('.description').ckeditor(options);
        // CKEDITOR.replace('my-editor', options);
    	})

    </script>
	@include('partials.toast')
</body>

</html>

