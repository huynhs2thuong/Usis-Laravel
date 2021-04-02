<div class="post col s9">
    <h1 class="text-capitalize">
        @if ($page->id)
            @lang('admin.title.edit', ['object' => trans('admin.object.page')])
            <a href="{{ action('Admin\PageController@create') }}" class="page-title-action btn waves-effect waves-light cyan">@lang('admin.title.create raw')</a>
        @else
            @lang('admin.title.create', ['object' => trans('admin.object.page')])
        @endif
    </h1>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'text', 'model' => 'page', 'attr' => 'title', 'title' => trans('admin.field.title')])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'text', 'model' => 'page', 'attr' => 'slug', 'title' => trans('admin.field.slug')])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'text', 'model' => 'page', 'attr' => 'canonical', 'title' => trans('admin.field.canonical')])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'textarea', 'attr' => "excerpt", 'model' => 'page', 'class' => 'materialize-textarea', 'title' => trans('admin.field.excerpt')])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'textarea', 'attr' => "description", 'model' => 'page', 'class' => 'description ckeditor'])
    </div>
    <div class="input-field">
        <label class="active" style="margin:20px 0;display: block;float: left;width: 100%;clear: both;position: relative;">Nội dung AMP</label>
        @include('partials.lang_input', ['type' => 'textarea', 'attr' => "amp_content", 'model' => 'page', 'class' => 'description ckeditor'])
    </div>
    <div class="input-field">
        <label class="active" for="slug">Video url</label>
        {{ Form::text('video url', $page->video_url, ['id' => 'video_url', 'placeholder' => '']) }}
    </div>
    <?php $linksgo = unserialize($page->links);
    // var_dump($linksgo);die;
    ?>
    @if($page->id == 13)
    <ul class="lang-switch" role="tablist">
        <li class="active" role="presentation">
            <a href="#input-59591e4845-vi" role="tab" data-toggle="tab" data-tab-lang="vi">Tiếng Việt</a>
        </li>
            <li class="" role="presentation">
            <a href="#input-59591e4845-en" role="tab" data-toggle="tab" data-tab-lang="en">English</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="input-59591e4845-vi">
            <h3 class="title">Gallery_vi</h3>
            <p><a class="btn waves-effect waves-light cyan set-image modal-trigger" href="#modal-gallery">@lang('admin.button.set image')</a></p>
            <ul id="bar" class="gallery block__list block__list_tags row">
                @if ($page->id)
                    @foreach ($gallery as $resource)
                        <li class="item col s4"><img src="{{ $resource->thumbnail }}" class="responsive-img" alt="">
                            <input type="hidden" name="gallery[]" value="{{ $resource->id }}">
                            <button class="resource-edit" type="button">
                                <i class="mdi-editor-border-color"></i></button><button class="resource-delete" type="button"><i class="mdi-navigation-close"></i></button><input type="hidden" name="textlink" value="@if(isset($linksgo[$resource->id]['vn'])){{ $linksgo[$resource->id]['vn'] }}@endif"><input type="hidden" name="linksgo[]" value="{{ $resource->id }},@if(isset( $linksgo[$resource->id]['vn'])){{ $linksgo[$resource->id]['vn'] }}@else{{'/'}}@endif,@if(isset($linksgo[$resource->id]['en'])){{ $linksgo[$resource->id]['en'] }}@else{{'/'}}@endif"><input type="hidden" name="textlinken" value="@if(isset($linksgo[$resource->id]['en'])){{ $linksgo[$resource->id]['en'] }}@endif"></li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="tab-pane" id="input-59591e4845-en">
            <h3 class="title">Gallery_en</h3>
            <p><a class="btn waves-effect waves-light cyan set-image modal-trigger" href="#modal-banner">@lang('admin.button.set image')</a></p>
            <ul id="bar_banner" class="banner block__list block__list_tags row">
                @if ($page->id)
                    @foreach ($banner as $resource)
                        <li class="item col s4"><img src="{{ $resource->thumbnail }}" class="responsive-img" alt="">
                            <input type="hidden" name="banner[]" value="{{ $resource->id }}">
                            <button class="resource-edit-banner" type="button">
                                <i class="mdi-editor-border-color"></i></button><button class="resource-delete_banner" type="button"><i class="mdi-navigation-close"></i></button><input type="hidden" name="textlink" value="@if(isset($linksgo[$resource->id]['vn'])){{ $linksgo[$resource->id]['vn'] }}@endif"><input type="hidden" name="linksgo[]" value="{{ $resource->id }},@if(isset( $linksgo[$resource->id]['vn'])){{ $linksgo[$resource->id]['vn'] }}@else{{'/'}}@endif,@if(isset($linksgo[$resource->id]['en'])){{ $linksgo[$resource->id]['en'] }}@else{{'/'}}@endif"><input type="hidden" name="textlinken" value="@if(isset($linksgo[$resource->id]['en'])){{ $linksgo[$resource->id]['en'] }}@endif"></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    @else
    <h3 class="title">Gallery</h3>
    <p><a class="btn waves-effect waves-light cyan set-image modal-trigger" href="#modal-gallery">@lang('admin.button.set image')</a></p>
    <ul id="bar" class="gallery block__list block__list_tags row">
        @if ($page->id)
            @foreach ($gallery as $resource)
                <li class="item col s4"><img src="{{ $resource->thumbnail }}" class="responsive-img" alt=""><input type="hidden" name="gallery[]" value="{{ $resource->id }}"><button class="resource-edit" type="button"><i class="mdi-editor-border-color"></i></button><button class="resource-delete" type="button"><i class="mdi-navigation-close"></i></button><input type="hidden" name="textlink" value="@if(isset($linksgo[$resource->id]['vn'])){{ $linksgo[$resource->id]['vn'] }}@endif"><input type="hidden" name="linksgo[]" value="{{ $resource->id }},@if(isset( $linksgo[$resource->id]['vn'])){{ $linksgo[$resource->id]['vn'] }}@else{{'/'}}@endif,@if(isset($linksgo[$resource->id]['en'])){{ $linksgo[$resource->id]['en'] }}@else{{'/'}}@endif"><input type="hidden" name="textlinken" value="@if(isset($linksgo[$resource->id]['en'])){{ $linksgo[$resource->id]['en'] }}@endif"></li>
            @endforeach
        @endif
    </ul>
    @endif
    {{$page->meta_title}}
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'text', 'attr' => "meta_title", 'model' => 'page', 'class' => 'materialize-textarea', 'title' => trans('admin.field.meta_title')])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'textarea', 'attr' => "meta_desc", 'model' => 'page', 'class' => 'materialize-textarea', 'title' => trans('admin.field.meta_desc')])
    </div>
</div>
<div class="category col s3">
    <div class="cat-top card hoverable">
        <h1 class="text-capitalize">@lang('admin.button.publish')</h1>
        <div class="divider"></div>
        <div class="status">
            <p>@lang('admin.field.status'):
                {{ Form::radio('active', 1, $page->active, ['id' => 'status-publish', 'class' => 'with-gap']) }}<label for="status-publish">@lang('admin.status.publish')</label>
                {{ Form::radio('active', 0, !$page->active, ['id' => 'status-draft', 'class' => 'with-gap']) }}<label for="status-draft">@lang('admin.status.draft')</label>
            </p>
            @if ($page->id)
            <p>@lang('admin.field.created at'): {{ $page->created_at }}</p>
            <p>@lang('admin.field.updated at'): {{ $page->updated_at }}</p>
            @endif
        </div>

        @if ($page->id)
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
            <label>@lang('admin.field.page parent')</label>
         
            <select class="browser-default" name="id_cate" style="margin-top: 19px">
                <option selected="selected"  hidden="hidden" value="0">None</option>
                @foreach ($categories as $title => $key)
                <option value=" {{ $key }} "
                     @if ($key == $page->id_cate)
                        selected="selected"
                    @endif
                >{{ $title }}</option>
                @endforeach
            </select>
        </p>
        <p>
            <label>@lang('admin.field.page template')</label>
            {{ Form::select('template', $templates, $page->template, ['class' => 'browser-default']) }}
        </p>
         <p>
            <label>Chương trình</label>
            {{ Form::select('id_pro', $id_pro, $page->id_pro, ['class' => 'browser-default']) }}
        </p>
    </div>
    <!-- anh giao dien -->
    <div class="cat-bottom card hoverable">
        <h1 class="text-capitalize">@lang('admin.field.image')</h1>
        <div class="divider"></div>
        <div class="postimagediv">
            <img src="@if($page->resource_id){{ $page->image }} @endif" class="responsive-img" alt="">
            <input type="hidden" name="resource_id" value="@if($page->resource_id){{ $page->resource_id }} @endif">
            <div class="clearfix"></div>
            <a class="btn waves-effect waves-light cyan {{ $page->resource_id ? 'hide' : '' }} set-image modal-trigger" href="#modal-upload">@lang('admin.button.set image')</a>
            <a class="btn waves-effect waves-light cyan {{ $page->resource_id ? '' : 'hide' }} remove-image">@lang('admin.button.remove image')</a>
        </div>
    </div>

    <div class="cat-bottom card hoverable">
        <h1 class="text-capitalize">Hình đại diện tiếng Anh</h1>
        <div class="divider"></div>
        <div class="postimagediv2">
            @if(isset($imgFeature))
            <img src="{{URL::to('/')}}/uploads/thumbnail/page/{{ $imgFeature }}" class="responsive-img" alt="">
            @endif
            <input type="hidden" name="feature" value="{{ $page->feature }}">
            <div class="clearfix"></div>
            <a class="btn waves-effect waves-light cyan {{ $page->feature ? 'hide' : '' }} set-image modal-trigger" href="#modal-upload2">@lang('admin.button.set image')</a>
            <a class="btn waves-effect waves-light cyan {{ $page->feature ? '' : 'hide' }} remove-image2">@lang('admin.button.remove image')</a>
        </div>
    </div>
</div>
<div class="modal" id="modal-gallery">
    <div class="modal-content">
        <h4 class="modal-title">@lang('admin.title.upload image')</h4>
        <div id="galleryUploader" class="dropzone"></div>
    </div>
</div>
<div class="modal" id="modal-banner">
    <div class="modal-content">
        <h4 class="modal-title">@lang('admin.title.upload image')</h4>
        <div id="bannerUploader" class="dropzone"></div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/js/plugins/sortable/Sortable.js"></script>
    <script type="text/javascript">
        // CKEDITOR.on( 'instanceReady', function( ev ) {
        //     // Output self-closing tags the HTML4 way, like <br>.
        //     ev.editor.dataProcessor.writer.selfClosingEnd = ' />';

        //     // Use line breaks for block elements, tables, and lists.
        //     var dtd = CKEDITOR.dtd;
        //     for ( var e in CKEDITOR.tools.extend( {}, dtd.$nonBodyContent, dtd.$block, dtd.$inline, dtd.$listItem, dtd.$tableContent ) ) {
        //         ev.editor.dataProcessor.writer.setRules( e, {
        //             indent: true,
        //             breakBeforeOpen: true,
        //             breakAfterOpen: true,
        //             breakBeforeClose: true,
        //             breakAfterClose: false
        //         });
        //     }
        //     // Start in source mode.
        //     ev.editor.setMode('source');
        // });
        // CKEDITOR.on('instanceCreated', function(ev) {
        //     var dtd = CKEDITOR.dtd;
        //     dtd.$removeEmpty.a = false;
        //     dtd.$removeEmpty.i = false;
        //     dtd.$removeEmpty.span = false;
        // });
        $(document).ready(function() {
            $("#form-page").validate({
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
                        pattern: slug_pattern
                    },
                    'slug[en]': {
                        required: true,
                        minlength: 3,
                        pattern: slug_pattern
                    }
                },
                errorElement : 'div',
                errorPlacement: function(error, element) {
                    var placement = $(element).data('error');
                    if (placement) $(placement).append(error)
                    error.insertAfter(element);
                }
            })
        });
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
        Dropzone.options.galleryUploader = {
            url: '{{ action('Admin\ResourceController@store') }}',
            paramName: 'upload',
            thumbnailWidth: 150,
            thumbnailHeight: 150,
            acceptedFiles: 'image/*',
            parallelUploads: 10,
            sending: function(file, xhr, formData) {
                formData.append('type', 'page');
            },
            success: function(file, response) {
                console.log(response);
                $('.gallery').append('<li class="item col s4"><img src="' + response.square + '" class="responsive-img" alt=""><input type="hidden" name="gallery[]" value="' + response.id + '"><button class="resource-edit" type="button"><i class="mdi-editor-border-color"></i></button><button class="resource-delete" type="button"><i class="mdi-navigation-close"></i></button><input type="hidden" name="textlink" value=""><input type="hidden" name="linksgo[]" value="' + response.id + ',"><input type="hidden" name="textlinken" value=""></li>')
                $('#modal-gallery').closeModal();
                this.removeAllFiles();
            }
        };
        Dropzone.options.bannerUploader = {
            url: '{{ action('Admin\ResourceController@store') }}',
            paramName: 'upload',
            thumbnailWidth: 150,
            thumbnailHeight: 150,
            acceptedFiles: 'image/*',
            parallelUploads: 10,
            sending: function(file, xhr, formData) {
                formData.append('type', 'page');
            },
            success: function(file, response) {
                console.log(response);
                $('.banner').append('<li class="item col s4"><img src="' + response.square + '" class="responsive-img" alt=""><input type="hidden" name="banner[]" value="' + response.id + '"><button class="resource-edit" type="button"><i class="mdi-editor-border-color"></i></button><button class="resource-delete_banner" type="button"><i class="mdi-navigation-close"></i></button><input type="hidden" name="textlink" value=""><input type="hidden" name="linksgo[]" value="' + response.id + ',"><input type="hidden" name="textlinken" value=""></li>')
                $('#modal-banner').closeModal();
                this.removeAllFiles();
            }
        };
        $(document).on('click','.resource-edit',function(){
            var $this = $(this);
            var idget = $this.parent().children('input').val();
            var textget = $this.parent().children('input[name="textlink"]').val();
            var textgeten = $this.parent().children('input[name="textlinken"]').val();
            $('#popup-links').attr('dataid',idget);
            $('#valueToLinks').val(textget);
            $('#valueToLinksEN').val(textgeten);
            $('#popup-links').show();
        });

        $(document).on('click','div#saveLinks',function(){
            var idcurrent = $('#popup-links').attr('dataid');
            var textcurrent = $('#valueToLinks').val();
            var textcurrenten = $('#valueToLinksEN').val();
            $('input[value='+idcurrent+']').parent().children('input[name="textlink"]').val(textcurrent);
            $('input[value='+idcurrent+']').parent().children('input[name^="linksgo"]').val(idcurrent+','+textcurrent+','+textcurrenten);
            $('input[value='+idcurrent+']').parent().children('input[name="textlinken"]').val(textcurrenten);
            $('#valueToLinks').val('');
            $('#valueToLinksEN').val('');
            $('#popup-links').attr('dataid','').hide();
        });
        
        $(document).on('click','div.close-popup-links',function(){
            $('#valueToLinks').val('');
            $('#popup-links').hide();
        })
        $(document).on('click','.resource-edit-banner',function(){
            var $this = $(this);
            var idget = $this.parent().children('input').val();
            var textget = $this.parent().children('input[name="textlink"]').val();
            var textgeten = $this.parent().children('input[name="textlinken"]').val();
            $('#popup-links_banner').attr('dataid',idget);
            $('#valueToLinks_banner').val(textget);
            $('#valueToLinksEN_banner').val(textgeten);
            $('#popup-links_banner').show();
        });
        $(document).on('click','div#saveLinks_banner',function(){
            var idcurrent = $('#popup-links_banner').attr('dataid');
            var textcurrent = $('#valueToLinks_banner').val();
            var textcurrenten = $('#valueToLinksEN_banner').val();
            $('input[value='+idcurrent+']').parent().children('input[name="textlink"]').val(textcurrent);
            $('input[value='+idcurrent+']').parent().children('input[name^="linksgo"]').val(idcurrent+','+textcurrent+','+textcurrenten);
            $('input[value='+idcurrent+']').parent().children('input[name="textlinken"]').val(textcurrenten);
            $('#valueToLinks_banner').val('');
            $('#valueToLinksEN_banner').val('');
            $('#popup-links_banner').attr('dataid','').hide();
        });
        $(document).on('click','div.close-popup-links_banner',function(){
            $('#valueToLinks_banner').val('');
            $('#popup-links_banner').hide();
        })
    </script>
 
    <div id="popup-links">
        <p>Chèn link cho hình:</p>
        VN: <input type="text" id="valueToLinks"><br>
        EN: <input type="text" id="valueToLinksEN">
        <div id="saveLinks">Save</div>
        <div class="close-popup-links"><i class="mdi-navigation-close"></i></div>
    </div>
    <div id="popup-links_banner">
        <p>Chèn link cho hình:</p>
        VN: <input type="text" id="valueToLinks_banner"><br>
        EN: <input type="text" id="valueToLinksEN_banner">
        <div id="saveLinks_banner">Save</div>
        <div class="close-popup-links_banner"><i class="mdi-navigation-close"></i></div>
    </div>
    <style type="text/css">
        .cke_dialog_image_url .cke_dialog_ui_hbox_last{vertical-align: middle}
        #popup-links{display: none;position: fixed;top:50%;left:calc(50% - 250px);background: #ddd;border: 1px solid #000;min-width: 500px;padding: 20px;transform: translateY(-50%);z-index: 9999;}
        #saveLinks,.close-popup-links{cursor: pointer;}
        #popup-links_banner{display: none;position: fixed;top:50%;left:calc(50% - 250px);background: #ddd;border: 1px solid #000;min-width: 500px;padding: 20px;transform: translateY(-50%);z-index: 9999;}
        #saveLinks_banner,.close-popup-links{cursor: pointer;}.close-popup-links_banner{cursor: pointer;}
        .close-popup-links{
            width: 32px;
            height: 32px;
            border-radius: 100%;
            background: #000;
            color: #fff;
            text-align: center;
            line-height: 32px;
            position: absolute;
            top: -16px;
            right: -16px;
            z-index: 9999;
        }
        .close-popup-links_banner{
            width: 32px;
            height: 32px;
            border-radius: 100%;
            background: #000;
            color: #fff;
            text-align: center;
            line-height: 32px;
            position: absolute;
            top: -16px;
            right: -16px;
            z-index: 9999;
        }
        .gallery > .item > .resource-edit {
            position: absolute;
            top: 5px;
            right: 50px;
            background: white;
            border: 1px solid #ddd;
            /* border-radius: 50%; */
            width: 30px;
            height: 30px;
            outline: none;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
            z-index: 1;
            color: black;
            font-weight: bold;
        }
        .banner {
            padding-left: 0;
            padding-top: 15px;
            overflow: auto;
        }
        .banner > .item {
            margin-bottom: 15px;
            cursor: move;
            position: relative;
        }
        .banner > .item > .resource-delete_banner {
            position: absolute;
            top: 5px;
            right: 15px;
            background: white;
            border: 1px solid #ddd;
            /* border-radius: 50%; */
            width: 30px;
            height: 30px;
            outline: none;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
            z-index: 1;
            color: black;
            font-weight: bold;
        }
        .banner > .item > .resource-edit-banner {
            position: absolute;
            top: 5px;
            right: 50px;
            background: white;
            border: 1px solid #ddd;
            /* border-radius: 50%; */
            width: 30px;
            height: 30px;
            outline: none;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
            z-index: 1;
            color: black;
            font-weight: bold;
        }
        </style>
@endpush
