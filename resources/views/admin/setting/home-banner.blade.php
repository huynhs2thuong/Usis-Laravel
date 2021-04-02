@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => ['Admin\SettingController@update', $setting->name], 'method' => 'PUT', 'id' => 'form-setting', 'class' => 'row']) !!}
	<div class="primary col s12">
	    <h1 class="text-capitalize">@lang('admin.setting.home-banner')</h1>
	    <p><a class="btn waves-effect waves-light cyan set-image modal-trigger" href="#modal-upload">@lang('admin.button.set image')</a></p>
		<ul id="bar" class="gallery block__list block__list_tags row">
			@foreach (json_decode($setting->value) as $image)
				<li class="item col s4"><img src="{{ $image->url }}" class="responsive-img" alt=""><input type="hidden" name="images[]" value="{{ $image->id }}"><button class="resource-delete" type="button"><i class="mdi-navigation-close"></i></button></li>
			@endforeach
		</ul>
		<button type="submit" class="btn left waves-light waves-effect green accent-4">@lang('admin.button.save')</button>
{!! Form::close() !!}
@endsection

@push('scripts')
	<script type="text/javascript" src="/js/plugins/sortable/Sortable.js"></script>
	<script type="text/javascript">
		(function () {
			'use strict';

			var byId = function (id) { return document.getElementById(id); },

				loadScripts = function (desc, callback) {
					var deps = [], key, idx = 0;

					for (key in desc) {
						deps.push(key);
					}

					(function _next() {
						var pid,
							name = deps[idx],
							script = document.createElement('script');

						script.type = 'text/javascript';
						script.src = desc[deps[idx]];

						pid = setInterval(function () {
							if (window[name]) {
								clearTimeout(pid);

								deps[idx++] = window[name];

								if (deps[idx]) {
									_next();
								} else {
									callback.apply(null, deps);
								}
							}
						}, 30);

						document.getElementsByTagName('head')[0].appendChild(script);
					})()
				},

				console = window.console;
			Sortable.create(byId('bar'), {
				group: "words",
				animation: 150,
				/*onAdd: function (evt){ console.log('onAdd.bar:', evt.item); },
				onUpdate: function (evt){ console.log('onUpdate.bar:', evt.item); },
				onRemove: function (evt){ console.log('onRemove.bar:', evt.item); },
				onStart:function(evt){ console.log('onStart.foo:', evt.item);},
				onEnd: function(evt){ console.log('onEnd.foo:', evt.item);}*/
			});
		})();

		Dropzone.options.uploader = {
            url: '{{ action('Admin\ResourceController@store') }}',
            paramName: 'upload',
            thumbnailWidth: 150,
            thumbnailHeight: 150,
            acceptedFiles: 'image/*',
            sending: function(file, xhr, formData) {
                formData.append('type', 'images');
            },
            success: function(file, response) {
            	$('.gallery').append('<li class="item col s4"><img src="' + response.full + '" class="responsive-img" alt=""><input type="hidden" name="images[]" value="' + response.id + '"><button class="resource-delete" type="button"><i class="mdi-navigation-close"></i></button></li>')
            	$modalupload.closeModal();
                this.removeAllFiles();
            }
        };
	</script>
@endpush
