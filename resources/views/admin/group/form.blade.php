@push('styles')
	<link rel="stylesheet" type="text/css" href="/js/plugins/jquery.nestable/nestable.css">
	<style type="text/css">
		.dd-handle {
			cursor: move;
			padding: 10px;
			height: auto;
			font-weight: normal;
			font-size: 1.15em;
		}
		.dd-handle > a {
			display: inline-block;
			min-width: 30px;
			text-align: right;
			margin-right: 10px;
		}
	</style>
@endpush

<div class="primary col s9">
	<h1 class="text-capitalize">
        @if ($group->id)
            @lang('admin.title.edit', ['object' => trans('admin.object.group')])
            <a href="{{ action('Admin\GroupController@create') }}" class="page-title-action btn waves-effect waves-light cyan">@lang('admin.title.create raw')</a>
        @else
            @lang('admin.title.create', ['object' => trans('admin.object.group')])
        @endif
    </h1>
	<div class="input-field col s9">
	    @include('partials.lang_input', ['type' => 'text', 'model' => 'group', 'attr' => 'title', 'title' => trans('admin.field.title')])
	</div>
	<div class="input-field col s9">
	    <label class="active" for="slug">@lang('admin.field.slug')</label>
        {{ Form::text('slug', $group->slug, ['id' => 'slug', 'placeholder' => '']) }}
	</div>
    <div class="input-field col s9" ng-class="(group.is_side == 1 && (group.col == 1 || group.col == 3)) ? '' : 'hide'">
        @include('partials.lang_input', ['type' => 'text', 'model' => 'group', 'attr' => 'change_size', 'title' => trans('admin.field.change size')])
    </div>
    <div class="input-field col s9" ng-class="(group.is_side == 1) ? '' : 'hide'">
        @include('partials.lang_input', ['type' => 'text', 'model' => 'group', 'attr' => 'change_col', 'title' => trans('admin.field.change col')])
    </div>
	<div class="input-field col s12">
	    @include('partials.lang_input', ['type' => 'textarea', 'attr' => "description", 'model' => 'group', 'class' => 'description ckeditor'])
	</div>
	@if ($group->id and count($group->dishes) > 0)
	<div class="col s12">
		<h3 class="title">@lang('admin.title.dishes order')</h3>
		<div id="nestable" class="dd">
		    <ol class="dd-list">
		    	@foreach ($group->dishes as $dish)
		        <li class="dd-item" data-id="{{ $dish->id }}">
		            <div class="dd-handle"><a href="{{ action('Admin\DishController@edit', $dish->id) }}">{{ $dish->product_id }}. </a>{{ $dish->title }}</div>
		        </li>
		        @endforeach
		    </ol>
		</div>
		{{ Form::textarea('dishes_order', null, ['id' => 'json-output', 'class' => 'hide']) }}
	</div>
	@endif
</div>
<div class="side col s3">
	<div class="cat-top row card hoverable">
        <h3 class="text-capitalize">@lang('admin.field.type')</h3>
        <div class="divider"></div>
        <p>
            <input id="main-course" class="with-gap" name="is_side" ng-model="group.is_side" value="0" type="radio"><label for="main-course">@lang('admin.dish type.main course')</label>
            <input id="side-dish" class="with-gap" name="is_side" ng-model="group.is_side" value="1" type="radio"><label for="side-dish">@lang('admin.dish type.side dish')</label>
		</p>
        <p ng-if="group.is_side == 1">
            @for ($i = 1; $i <= 4; $i++)
                <input id="col-{{ $i }}" class="with-gap" name="col" ng-model="group.col" value="{{ $i }}" type="radio"><label for="col-{{ $i }}">@lang('admin.group col.' . $i)</label>
                @if ($i === 2) <br /> @endif
            @endfor
        </p>
        @if ($group->id)
            <button type="button" class="btn-delete btn btn-sm left waves-light waves-effect red darken-4">@lang('admin.button.delete')</button>
            <button type="submit" class="btn btn-sm right waves-light waves-effect green accent-4">@lang('admin.button.update')</button>
        @else
            <button type="submit" class="btn btn-sm waves-light waves-effect green accent-4">@lang('admin.button.publish')</button>
        @endif
        <div class="clearfix"></div>
    </div>
	<div class="cat-bottom row card hoverable">
        <h1 class="text-capitalize">@lang('admin.field.image')</h1>
        <div class="divider"></div>
        <div class="postimagediv">
            <img src="{{ $group->image }}" class="responsive-img" alt="">
            <input type="hidden" name="resource_id" value="{{ $group->resource_id }}">
            <div class="clearfix"></div>
            <a class="btn waves-effect waves-light cyan {{ $group->resource_id ? 'hide' : '' }} set-image modal-trigger" href="#modal-upload">@lang('admin.button.set image')</a>
            <a class="btn waves-effect waves-light cyan {{ $group->resource_id ? '' : 'hide' }} remove-image">@lang('admin.button.remove image')</a>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/js/plugins/angular.min.js"></script>
    <script type="text/javascript" src="/js/plugins/jquery.nestable/jquery.nestable.js"></script>
    <script type="text/javascript">
        var app = angular.module('jollibee', []).controller('GroupController', ['$scope', function($scope) {
            $scope.group = {
                is_side: {{ (int) $group->is_side }},
                col: {{ $group->col ? $group->col : 1 }}
            };
        }]);

        $(document).ready(function() {
        	var updateOutput = function(e) {
			    var list = e.length ? e : $(e.target),
			        output = list.data('output');
			    if (window.JSON) {
			        if (output) {
			            output.val(window.JSON.stringify(list.nestable('serialize')).replace(/{"id":|}/g, ''));
			        }
			    } else {
			        alert('JSON browser support required for this page.');
			    }
			};
			var $nestable = $('#nestable'),
				$json_output = $('#json-output');
        	$nestable.nestable({
        		maxDepth: 1
        	});
        	updateOutput($nestable.data('output', $json_output));
        	$nestable.on('change', function() {
			    updateOutput($nestable.data('output', $json_output));
			});

            $("#form-group").validate({
                rules: {
                    'title[vi]': {
                        required: true,
                        minlength: 3
                    },
                    'title[en]': {
                        minlength: 3
                    },
                    slug: {
                        required: true,
                        minlength: 3,
                        pattern: /^[\w\-\/]+[a-zA-Z\d]$/
                    },
                    type: {
                        required: true
                    }
                },
                errorElement : 'div',
                errorPlacement: function(error, element) {
                    var placement = $(element).data('error');
                    if (placement) $(placement).append(error)
                    else if ($(element).attr('type') === 'checkbox') error.insertBefore(element);
                    else error.insertAfter(element);
                }
            })
        });

    </script>
@endpush
