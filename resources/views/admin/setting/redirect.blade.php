@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => ['Admin\SettingController@updateRedirect'], 'method' => 'POST', 'id' => 'form-setting', 'class' => 'row','files'=>true]) !!}
<div class="col s12">
	<div class="row list-links">
	<div class="col s12">
	<div class="col s10">
		<div class="col s6"><label class="active">Link gốc</label></div>
		<div class="col s6"><label class="active">Link redirect to</label></div>
		</div>
	</div>
	@if(isset($value['old-link']))
	@for($i=0;$i<=count($value['old-link']) - 1 ;$i++)
		<div class="col s12">
		<div class="col s10">
		@if(isset($value['old-link'][$i]))
			<div class="col s6"><input type="text" name="old-link[]" value="{{$value['old-link'][$i]}}"></div>
		@endif
		@if(isset($value['new-link'][$i]))
			<div class="col s6"><input type="text" name="new-link[]" value="{{$value['new-link'][$i]}}"></div>
		@endif
		</div>
		<div class="col s2">
			<div class="remove_link button_link red">-</div>
		</div>
		</div>
	@endfor
	@endif
	</div>
</div>
<div class="add_more button_link green">+</div>
  <button type="submit" class="btn btn-sm right waves-light waves-effect green accent-4">@lang('admin.button.update')</button>


{!! Form::close() !!}


@endsection
@push('styles')
<style type="text/css">
.list-links{margin-top: 40px}
.red {color:red;}
.button_link{width:22px;height: 22px;color:#fff;line-height: 22px;border-radius: 100px;text-align: center;font-size: 30px;cursor: pointer;}
.add_more{display: inline-block;margin:20px;}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	$('.add_more').click(function(){
		var html = '<div class="col s12">';
			html += '<div class="col s10">';
				html += '<div class="col s6">';
				html += '<input type="text" name="old-link[]" value="">';
				html += '</div>';
				html += '<div class="col s6">';
				html += '<input type="text" name="new-link[]" value="">';
				html += '</div>';
			html += '</div>';
			html += '<div class="col s2">';
			html += '<div class="remove_link button_link red">-</div>';
			html += '</div>';
		html += '</div>';
		$('.list-links').append(html);
	});
	$(document).on('click','.remove_link',function(){
		$(this).parent().parent().remove();
	})
</script>
@endpush