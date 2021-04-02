<div class="primary col s9">
    <h1 class="text-capitalize">
        @if ($post->id)
            @lang('admin.title.edit', ['object' => trans('admin.object.post')])
            <a href="{{ action('Admin\ServiceController@create') }}" class="page-title-action btn waves-effect waves-light cyan">@lang('admin.title.create raw')</a>
        @else
            @lang('admin.title.create', ['object' => trans('admin.object.post')])
        @endif
    </h1>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'text', 'model' => 'post', 'attr' => 'title', 'title' => trans('admin.field.title')])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'text', 'model' => 'post', 'attr' => 'slug', 'title' => trans('admin.field.slug')])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'textarea', 'attr' => "excerpt", 'model' => 'post', 'class' => 'materialize-textarea', 'title' => trans('admin.field.excerpt')])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'textarea', 'attr' => "description", 'model' => 'post', 'class' => 'description ckeditor'])
    </div>
</div>
<div class="side col s3">
    <div class="cat-top card hoverable">
        <h1 class="text-capitalize">@lang('admin.button.publish')</h1>
        <div class="divider"></div>
        <div class="status">
            <p>@lang('admin.field.status'):
                {{ Form::radio('active', 1, $post->active, ['id' => 'status-publish', 'class' => 'with-gap']) }}<label for="status-publish">@lang('admin.status.publish')</label>
                {{ Form::radio('active', 0, !$post->active, ['id' => 'status-draft', 'class' => 'with-gap']) }}<label for="status-draft">@lang('admin.status.draft')</label>
            </p>
            @if ($post->id)
            <p>@lang('admin.field.created at'): {{ $post->created_at }}</p>
            <p>@lang('admin.field.updated at'): {{ $post->updated_at }}</p>
            @endif
        </div>
        @if ($post->id)
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
            {{ Form::select("module_id", $modules, $post->cid, ['class' => 'browser-default', 'placeholder' => '--']) }}
        </p>
    </div>
    <div class="cat-middle card hoverable">
        <h1 class="text-capitalize">@lang('admin.field.category')</h1>
        <div class="divider"></div>
            @foreach ($categories as $category)
            <p class="category {{$category->cid}}" >
                {{ Form::radio('cat_id', $category->id, ($category->id== $post->cat_id), ['id' => 'category-' . $loop->index, 'data-id' => $category->id]) }}
                <label for="category-{{ $loop->index }}">{{ $category->title }}</label>
            </p>
            @endforeach
    </div>
   <!--  <div class="cat-middle card hoverable">
        <h1 class="text-capitalize">@lang('admin.field.category')</h1>
        <div class="divider"></div>
            @foreach ($categories as $category)
            <p class="category {{$category->cid}}" >
                {{ Form::radio('cat_id', $category->id, ($category->id== $post->cat_id), ['id' => 'category-' . $loop->index, 'data-id' => $category->id]) }}
                <label for="category-{{ $loop->index }}">{{ $category->title }}</label>
            </p>
            @endforeach
    </div> -->
    <div class="cat-bottom card hoverable">
        <h1 class="text-capitalize">@lang('admin.field.image')</h1>
        <div class="divider"></div>
        <div class="postimagediv">
            <img src="{{ $post->image }}" class="responsive-img" alt="">
            <input type="hidden" name="resource_id" value="{{ $post->resource_id }}">
            <div class="clearfix"></div>
            <a class="btn waves-effect waves-light cyan {{ $post->resource_id ? 'hide' : '' }} set-image modal-trigger" href="#modal-upload">@lang('admin.button.set image')</a>
            <a class="btn waves-effect waves-light cyan {{ $post->resource_id ? '' : 'hide' }} remove-image">@lang('admin.button.remove image')</a>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">

        $("[name='module_id']").on('change',function(){
            var cid = $(this).val();
            $('.category').hide();
            $('.category input').prop('checked', false);
            $('.'+cid).show();
        });

        $(document).ready(function() {

            $("[name='module_id']").trigger('change');

            $('[data-id="{{$post->cat_id}}"]').trigger('click');

            var $form = $('#form-post'),
                $form_method = $form.children('input[name="_method"]'),
                form_action = $form.attr('action'),
                form_method = $form_method.val();

            $form.validate({
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
                    'cat_id': {
                        required: true,
                        minlength: 1
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

            $('.btn-preview').click(function(event) {
                event.preventDefault();

                $form.attr({
                    action: '{{ action('Admin\ServiceController@preview') }}',
                    target: '{{ config('app.name') }}'
                });
                $form_method.val('POST');
                $form.submit();

                $form.attr({
                    action: form_action,
                    target: '_self'
                });
                $form_method.val(form_method);
            });
        });

    </script>
@endpush
