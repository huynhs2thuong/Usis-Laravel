@push('styles')
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
        <link rel="stylesheet" href="{{URL::to('/')}}/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css">
@endpush

<div class="row col-md-12">
<div class="primary col-md-9">     
    <h1 class="text-capitalize">
        @if ($menu->id)
            @lang('admin.title.edit', ['object' => trans('admin.object.menu')])
            <a href="{{ action('Admin\MenuController@create') }}" class="page-title-action btn waves-effect waves-light cyan">@lang('admin.title.create raw')</a>
        @else
            @lang('admin.title.create', ['object' => trans('admin.object.menu')])
        @endif
    </h1>
    <div class="input-field">
        <label class="active">@lang('admin.field.title')</label>

        {{ Form::text('title', $menu->title)}}

    </div>
    <div class="row">
		<div class="col-md-6">
			<div class="card mb-3">
				<div class="card-header"><h5 class="float-left">Menu</h5>
					<div class="float-right">
						<!-- <button id="btnReload" type="button" class="btn btn-outline-secondary">
							<i class="fa fa-play"></i> Load Data</button> -->
					</div>
				</div>
				<div class="card-body">
					<ul id="myEditor" class="sortableLists list-group">
					</ul>
				</div>
                <div class="menu-output" style="display: none">
                    {{ Form::text('data', '', ['id' => 'nestable-output', 'class' => 'nestable-output', 'placeholder' => '']) }}
                </div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card border-primary mb-3">
				<div class="card-header bg-primary text-white">Edit Menu</div>
				<div class="card-body">
						<div class="form-group">
							<label for="text">VI</label>
							<div class="input-group">
								<input type="text" class="form-control item-menu" name="vi" id="vi" placeholder="Text">
								<!-- <div class="input-group-append">
									<button type="button" id="myEditor_icon" class="btn btn-outline-secondary"></button>
								</div> -->
							</div>
						</div>
                        <div class="form-group">
                            <label for="href">VI URL</label>
                            <input type="text" class="form-control item-menu" id="vi_url" name="vi_url" placeholder="URL">
                        </div>
						<div class="form-group">
                            <label for="text">EN</label>
                            <div class="input-group">
                                <input type="text" class="form-control item-menu" name="en" id="en" placeholder="Text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="href">VI URL</label>
                            <input type="text" class="form-control item-menu" id="en_url" name="en_url" placeholder="URL">
                        </div>
				</div>
				<div class="card-footer">
					<button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Cập Nhật</button>
					<button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Thêm</button>
                    <button type="button" id="btnSave" class="btn btn-success" style="display: none;"><i class="fas fa-check-square"></i> Lưu Tạm</button>
				</div>
			</div>
			{{-- <p>Click the Output button to execute the function <code>getString();</code></p>
			<div class="card">
			<div class="card-header">JSON Output
			<div class="float-right">
			<button id="btnOutput" type="button" class="btn btn-success"><i class="fas fa-check-square"></i> Output</button>
			</div>
			</div>
			<div class="card-body">
			<div class="form-group"><textarea id="out" class="form-control" cols="50" rows="10"></textarea>
			</div>
			</div>
			</div>  --}}
		</div>
	</div>
</div>
<div class="side col-md-3">
    <div class="cat-top card hoverable">
        <h3 class="text-capitalize">@lang('admin.button.publish')</h3>
        <div class="divider"></div>
        @if ($menu->id)
            <div class="status">
                <p>@lang('admin.field.created at'): {{ $menu->created_at }}</p>
                <p>@lang('admin.field.updated at'): {{ $menu->updated_at }}</p>
            </div>
            <button type="button" class="btn-delete btn btn-sm left waves-light waves-effect red darken-4">@lang('admin.button.delete')</button>
            <button type="submit" class="btn btn-sm right waves-light waves-effect green accent-4">@lang('admin.button.update')</button>
        @else
            <button type="submit" class="btn btn-sm waves-light waves-effect green accent-4">@lang('admin.button.publish')</button>
        @endif
        <div class="clearfix"></div>
    </div>
    <div class="cat-bottom card hoverable">
        <h1 class="text-capitalize">@lang('admin.field.position')</h1>
        <div class="divider"></div>
        <?php $pos = ['header' => 'Header', 'sidebar' => 'Side bar', 'footer' => 'Footer','amp' => 'AMP'] ?>
        <div style="margin-top: 20px">
        @foreach($pos as $k => $gr)
            {{ Form::radio('position', $k, ($k == $menu->position), ['id' => 'type-'.$k]) }}<label for="type-{{$k}}">{{$gr}}</label>
        @endforeach
        </div>
    </div>
</div>
</div>
@push('scripts')
        <script>
            jQuery(document).ready(function () {

            var updateOutput = function(e) {
                var list = e.length ? e : $(e.target),
                    output = list.data('output');
                if(window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                }
                else {
                    output.val('JSON browser support required for this demo.');
                }
            };

            var output = '';

            var obj = '{!!  $menu->data  !!}';
            @if($menu->data != null and $menu->data != '[]' and $menu->data != '[{}]')

                $.each(JSON.parse(obj), function (index, item) {
                    output += (item);
                });
            @endif  
            
                // menu items
                // var arrayjson = [
                // {"num":"http://home.com", "href":"http://home.com","icon":"fas fa-home","text":"Home", "target": "_top", "title": "My Home"},
                // {"href":"http://123.com","icon":"fas fa-home","text":"123", "target": "_top", "title": "My Home123"},
                // {"icon":"fas fa-chart-bar","text":"Opcion2"},
                // {"icon":"fas fa-bell","text":"Opcion3"},
                // {"icon":"fas fa-crop","text":"Opcion4"},
                // {"icon":"fas fa-flask","text":"Opcion5"},
                // {"icon":"fas fa-map-marker","text":"Opcion6"},
                // ];
                // icon picker options
                var iconPickerOptions = {searchText: "Buscar...", labelHeader: "{0}/{1}"};
                // sortable list options
                var sortableListOptions = {
                    placeholderCss: {'background-color': "#cccccc"}
                };

                var editor = new MenuEditor('myEditor', {listOptions: sortableListOptions, iconPicker: iconPickerOptions});
                // editor.setForm($('#frmEdit'));
                editor.setForm($('#form-menu'));
                editor.setData(obj);
                editor.setUpdateButton($('#btnUpdate'));
                 $('#nestable-output').val(obj); 
                 
                //demo output
                $('#btnOutput').on('click', function () {
                    var str = editor.getString();
                    $("#out").text(str);
                });

                $('#btnSave').on('click', function () {
                    var str = editor.getString();
                   $('#nestable-output').val(str);
                   //confirm('Lưu tạm thành công!!');
                });

                $("#btnUpdate").click(function(){
                    editor.update();
                    var str = editor.getString();
                   $('#nestable-output').val(str);
                   console.log($('#nestable-output').val(str));
                });

                $('#btnAdd').click(function(){
                    editor.add();
                });
                /* ====================================== */

                /** PAGE ELEMENTS **/
            });
        </script>
@endpush