<div class="primary col s9">
    <h1 class="text-capitalize">
        @if ($post->id)
            @lang('admin.title.edit', ['object' => trans('admin.object.form')])
            <a href="{{ action('Admin\PostController@create') }}" class="page-title-action btn waves-effect waves-light cyan">@lang('admin.title.create raw')</a>
        @else
            @lang('admin.title.create', ['object' => trans('admin.object.form')])
        @endif
    </h1>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'text', 'model' => 'post', 'attr' => 'title', 'title' => trans('admin.field.title')])
    </div>
    <div class="input-field">
        <label class="active" for="slug">tên code (không dấu, cách nhau bằng dấu "-")</label>
         {{ Form::text('slug', $post->slug, ['id' => 'slug', 'placeholder' => '']) }}
         <div>Code để hiện form</div>
         <div>[{{$post->slug}}]</div>
    </div>

    <div class="input-field"></div>
    <div class="input-field">
        <label class="active" for="created_at">@lang('admin.field.created at')</label>
        {{ Form::text('created_at', $post->created_at, ['id' => 'created_at', 'class' => 'job-date', 'readonly' => '', 'placeholder' => '']) }}
    </div>

    <div class="input-field">
        @include('partials.lang_input', ['type' => 'textarea', 'attr' => "excerpt", 'model' => 'post', 'class' => 'materialize-textarea', 'title' => 'form code'])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'textarea', 'attr' => "css", 'model' => 'post', 'class' => 'materialize-textarea','title' => 'css'])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'textarea', 'attr' => "description", 'model' => 'post', 'class' => 'materialize-textarea','title' => 'amp form'])
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
            <label>@lang('admin.field.typeform')</label>
            {{ Form::select('type', ['0'=>'---','1'=>'form xác nhận'], $post->type, ['class' => 'browser-default', 'placeholder' => '--']) }}
        </p>
    </div> 
</div>
@push('scripts')
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">

        //select module => show category 
        $("[name='module_id']").on('change',function(){
            var cid = $(this).val();
            $('.category').hide();
            $('.category input').prop('checked', false);
            $('.'+cid).show();
        });


        $(document).ready(function() {
            $("[name='module_id']").trigger('change');

            $('[data-id="{{$post->cat_id}}"]').trigger('click');

            $('.job-date').pickadate({
                selectMonths: true,
                selectYears: 15,
                format:'dd/mm/yyyy'
            });

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
                    'slug[vi]': {
                        required: true,
                        minlength: 3,
                        pattern: /^[\w\-\/]+[a-zA-Z\d]$/
                    },
                    'slug[en]': {
                        required: true,
                        minlength: 3,
                        pattern: /^[\w\-\/]+[a-zA-Z\d]$/
                    }
                },
                errorElement : 'div',
                errorPlacement: function(error, element) {
                    var placement = $(element).data('error');
                    if (placement) $(placement).append(error)
                    else if ($(element).attr('type') === 'checkbox') error.insertBefore(element);
                    else error.insertAfter(element);
                }
            });

            Dropzone.options.galleryUploader = {
            url: '{{ action('Admin\ResourceController@store') }}',
            paramName: 'upload',
            thumbnailWidth: 150,
            thumbnailHeight: 150,
            acceptedFiles: 'image/*',
            parallelUploads: 10,
            sending: function(file, xhr, formData) {
                formData.append('type', 'post');
            },
            success: function(file, response) {
                $('.gallery').append('<li class="item col s4"><img src="' + response.square + '" class="responsive-img" alt=""><input type="hidden" name="gallery[]" value="' + response.id + '"><button class="resource-delete" type="button"><i class="mdi-navigation-close"></i></button></li>')
                $('#modal-gallery').closeModal();
                this.removeAllFiles();
            }
        };
        });

    </script>
@endpush
