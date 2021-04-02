<div class="primary col s9">
    <h1 class="text-capitalize">
        @if ($post->id)
            @lang('admin.title.edit', ['object' => trans('admin.object.post')])
            <a href="{{ action('Admin\PostController@create') }}" class="page-title-action btn waves-effect waves-light cyan">@lang('admin.title.create raw')</a>
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
        <label class="active" for="created_at">@lang('admin.field.created at')</label>
        {{ Form::text('created_at', $post->created_at, ['id' => 'created_at', 'class' => 'job-date', 'placeholder' => '']) }}
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'text', 'model' => 'post', 'attr' => 'canonical', 'title' => trans('admin.field.canonical')])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'textarea', 'attr' => "excerpt", 'model' => 'post', 'class' => 'materialize-textarea', 'title' => trans('admin.field.excerpt')])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'textarea', 'attr' => "description", 'model' => 'post', 'class' => 'description ckeditor','id'=>'my-editor'])
    </div>
    <div class="input-field">
        <label class="active" style="position: relative;top: auto" for="content_vn">Nội dung tiếng Việt cũ(nếu có nội dung trong đây sẽ được ưu tiên)</label>
        {{ Form::textarea('content_vn',$post->content_vn,['id'=>'my-editor','class'=>'description ckeditor'])}}
    </div>
    <div class="input-field">
        <label class="active" style="position: relative;top: auto" for="content_en">Nội dung tiếng Anh cũ(nếu có nội dung trong đây sẽ được ưu tiên)</label>
        {{ Form::textarea('content_en',$post->content_en,['id'=>'my-editor','class'=>'description ckeditor'])}}
    </div>
    <div class="input-field">
        <label class="active" for="slug">Video url</label>
        {{ Form::text('video_url', $post->video_url, ['id' => 'video_url', 'placeholder' => '']) }}
    </div>
    <div class="input-field">
        <label class="active" for="slug">Tag</label>
        {{ Form::text('tagsinput', '', ['id' => 'tags', 'placeholder' => '']) }}
        <div class="tag-value">
            @if(isset($tags) && count($tags) > 0)
                @foreach($tags as $tag)
                    <p class="tags"><span class="close-tag mdi-navigation-close"></span><span>{{$tag->name}}</span><input type="hidden" name="tags[]" value="{{$tag->name}}" readonly></p>
                @endforeach
            @endif
        </div>
    </div>
    <h3 class="title">Gallery</h3>
    <div class="input-field">
        <div id="galleryUploader" class="dropzone"></div>
    </div>
    <ul id="bar" class="gallery block__list block__list_tags row">
        @if ($post->id)
            @foreach ($gallery as $resource)
                <li class="item col s4"><img src="{{ $resource->square }}" class="responsive-img" alt=""><input type="hidden" name="gallery[]" value="{{ $resource->id }}"><button class="resource-delete" type="button"><i class="mdi-navigation-close"></i></button></li>
            @endforeach
        @endif
    </ul>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'text', 'attr' => "meta_title", 'model' => 'post', 'class' => 'materialize-textarea', 'title' => trans('admin.field.meta_title')])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'textarea', 'attr' => "meta_desc", 'model' => 'post', 'class' => 'materialize-textarea', 'title' => trans('admin.field.meta_desc')])
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
            <p>@lang('admin.field.sticky'): {{ Form::checkbox('sticky', 1, $post->sticky, ['id' => 'sticky']) }}<label for="sticky"><span class="non-visib">1</span></label> </p>
     <!--        <p>@lang('admin.field.service_display'): {{ Form::checkbox('service_display', 1, $post->service_display, ['id' => 'service_display']) }}<label for="service_display"><span class="non-visib">1</span></label></p> -->
            <p>
                Hiện trong DV an cư: 
                <p>
                {{ Form::radio('service_display', 0, $post->service_display == 0 ? true : false , ['id' => 'service_display-0', 'class' => 'with-gap']) }}
                {{ Form::label('service_display-0', 'Không hiện') }}
                </p>
                <p>
                {{ Form::radio('service_display', 1, $post->service_display == 1 ? true : false, ['id' => 'service_display-1', 'class' => 'with-gap']) }}
                {{ Form::label('service_display-1', 'Tin tức') }}
                </p>
                <p>
                {{ Form::radio('service_display', 2, $post->service_display == 2 ? true : false, ['id' => 'service_display-2', 'class' => 'with-gap']) }}
                {{ Form::label('service_display-2', 'Video') }}
                </p>
            </p>
            <p> Số thứ tự: {{ Form::text('ordering', $post->ordering, array('class' => 'field inline-form ordering-input')) }}</p>
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

        //select module => show category 
        $("[name='module_id']").on('change',function(){
            var cid = $(this).val();
            $('.category').hide();
            $('.category input').prop('checked', false);
            $('.'+cid).show();
        });


        $(document).ready(function() {

            //tags
            $('input#tags').keypress(function(e) {
                var code = e.keyCode || e.which;
                if(code == 13){
                    var keytext = $(this).val();
                    var arrtext = keytext.split(',');

                    // console.log(arrtext[]);
                    $.each(arrtext,function(index,value){
                        if($.trim(value) != ''){
                            var tagsArr = [];
                            $('p.tags').each(function(){
                                var valuetext = $(this).children('input').val();
                                tagsArr.push(valuetext);
                            });
                            if($.inArray(value,tagsArr) == -1){
                                $('<p class="tags"><span class="close-tag mdi-navigation-close"></span><span>'+$.trim(value)+'</span><input type="hidden" name="tags[]" value="'+$.trim(value)+'" readonly></p>').appendTo('.tag-value');
                            }
                        }
                        
                    });
                    $('#tags').val('');
                    return false;
                }
            });

            //close tag
            $(document).on('click','.close-tag',function(){
                $(this).parent().remove();
            });

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
            })

            $('.btn-preview').click(function(event) {
                event.preventDefault();

                $form.attr({
                    action: '{{ action('Admin\PostController@preview') }}',
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

            Dropzone.options.galleryUploader = {
            url: '{{ action('Admin\ResourceController@store') }}',
            paramName: 'upload',
            thumbnailWidth: 150,
            thumbnailHeight: 150,
            acceptedFiles: 'image/*',
            parallelUploads: 25,
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
    <style type="text/css">
        input.ordering-input{width: auto;border: 1px solid #ddd;text-align: center;}
        .tag-value .tags {display: inline-block;margin-right: 20px;}
        .close-tag{border-radius: 100%;-webkit-border-radius:100%;-moz-border-radius:100%;width: 18px;height: 18px;
            display: inline-block;
            background: #f95757;
            text-align: center;
            line-height: 17px;
            margin-right: 5px;
            color: #fff;
        }
        .close-tag{
            cursor: pointer;
        }
    </style>
@endpush
