<div class="primary col s9">
	<h1 class="text-capitalize">
        @if ($category->id)
            @lang('admin.title.edit', ['object' => trans('admin.object.category')])
            <a href="{{ action('Admin\CategoryController@create') }}?type={{$category->type}}" class="page-title-action btn waves-effect waves-light cyan">@lang('admin.title.create raw')</a>
        @else
            @lang('admin.title.create', ['object' => trans('admin.object.category')])
        @endif
    </h1>
	<div class="input-field">
	    @include('partials.lang_input', ['type' => 'text', 'model' => 'category', 'attr' => 'title', 'title' => trans('admin.field.title')])
	</div>
	<div class="input-field">
         @include('partials.lang_input', ['type' => 'text', 'model' => 'category', 'attr' => 'slug', 'title' => trans('admin.field.slug')])
	</div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'text', 'model' => 'category', 'attr' => 'canonical', 'title' => trans('admin.field.meta_desc')])
    </div>
	<div class="input-field">
	    @include('partials.lang_input', ['type' => 'textarea', 'attr' => "description", 'model' => 'category', 'class' => 'description ckeditor'])
	</div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'textarea', 'attr' => "meta_title", 'model' => 'category', 'class' => 'description materialize-textarea', 'title' => trans('admin.field.meta_title')])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'textarea', 'attr' => "meta_desc", 'model' => 'category', 'class' => 'description materialize-textarea', 'title' => trans('admin.field.meta_desc')])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'textarea', 'attr' => "meta_keyword", 'model' => 'category', 'class' => 'description materialize-textarea', 'title' => trans('admin.field.meta_keyword')])
    </div>
</div>
<div class="side col s3">
	<div class="cat-top card hoverable">
        <h3 class="text-capitalize">@lang('admin.button.publish')</h3>
        <div class="divider"></div>
        <div class="status">
            <p>@lang('admin.field.status'):
                {{ Form::radio('active', 1, $category->active, ['id' => 'status-publish', 'class' => 'with-gap']) }}<label for="status-publish">@lang('admin.status.publish')</label>
                {{ Form::radio('active', 0, !$category->active, ['id' => 'status-draft', 'class' => 'with-gap']) }}<label for="status-draft">@lang('admin.status.draft')</label>
            </p>
            <p>@lang('admin.field.sticky'): {{ Form::checkbox('sticky', 1, $category->sticky, ['id' => 'sticky']) }}<label for="sticky"><span class="non-visib">1</span></label></p>
            @if ($category->id)

            <p>@lang('admin.field.created at'): {{ $category->created_at }}</p>
            <p>@lang('admin.field.updated at'): {{ $category->updated_at }}</p>

            @endif
        </div>
        @if ($category->id)
        	<button type="button" class="btn-delete btn btn-sm left waves-light waves-effect red darken-4">@lang('admin.button.delete')</button>
        	<button type="submit" class="btn btn-sm right waves-light waves-effect green accent-4">@lang('admin.button.update')</button>
        @else
        	<button type="submit" class="btn btn-sm waves-light waves-effect green accent-4">@lang('admin.button.publish')</button>
        @endif
        <div class="clearfix"></div>
    </div>
    <div class="cat-middle card hoverable">
        <h1 class="text-capitalize">@lang('admin.title.attribute')</h1>
        <div class="divider"></div>
        <p>
            <label>@lang('admin.object.module')</label>
            {{ Form::select("module_id", $modules, $category->cid, ['class' => 'browser-default', 'placeholder' => '--']) }}
        </p>
    </div>
    <div class="cat-middle card hoverable">
        <h1 class="text-capitalize">@lang('admin.field.cate parent')</h1>
        <div class="divider"></div>
        <p>
            {{ Form::radio('cid', 0, true, ['id' => 'category-none']) }}
            <label for="category-none">None</label>
        </p>
        @foreach ($cates as $k => $cate)
            <p>
                @if(intval($category->parent_id) == intval($k))
                {{ Form::radio('cid', $k, true, ['id' => 'category-' . $k]) }}
                @else
                    {{ Form::radio('cid', $k, false, ['id' => 'category-' . $k]) }}
                @endif
                <label for="category-{{ $k }}">{{ $cate }}</label>
            </p>
        @endforeach
    </div>
	<div class="cat-bottom card hoverable">
        <h3 class="text-capitalize">@lang('admin.field.image')</h3>
        <div class="divider"></div>
        <div class="postimagediv">
            <img src="{{ $category->image }}" class="responsive-img" alt="">
            <input type="hidden" name="resource_id" value="{{ $category->resource_id }}">
            <div class="clearfix"></div>
            <a class="btn waves-effect waves-light cyan {{ $category->resource_id ? 'hide' : '' }} set-image modal-trigger" href="#modal-upload">@lang('admin.button.set image')</a>
            <a class="btn waves-effect waves-light cyan {{ $category->resource_id ? '' : 'hide' }} remove-image">@lang('admin.button.remove image')</a>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#form-category").validate({
                rules: {
                    'title[vi]': {
                        required: true,
                        minlength: 3
                    },
                    'title[en]': {
                        minlength: 3
                    },
                    'slug[vi]': {
                        required: true,
                        minlength: 3,
                        pattern: /^[\w\-\/]+[a-zA-Z\d]$/
                    },
                    'slug[en]': {
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
