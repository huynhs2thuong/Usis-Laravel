@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => ['Admin\SettingController@updateBasic'], 'method' => 'POST', 'id' => 'form-setting', 'class' => 'row','files'=>true]) !!}
<div class="col s6">
@if($setting)
	<div class="cat-bottom card hoverable">
        <h1 class="text-capitalize">@lang('admin.field.logo')</h1>
        <div class="divider"></div>
        <div class="postimagediv">
            <img src="{{ $setting->image }}" class="responsive-img" alt="">
            <input type="hidden" name="resource_id" value="{{ $setting->resource_id }}">
            <div class="clearfix"></div>
            <a class="btn waves-effect waves-light cyan {{ $setting->resource_id ? 'hide' : '' }} set-image modal-trigger" href="#modal-upload">@lang('admin.button.set image')</a>
            <a class="btn waves-effect waves-light cyan {{ $setting->resource_id ? '' : 'hide' }} remove-image3">@lang('admin.button.remove image')</a>
        </div>
    </div>
@else
<div class="cat-bottom card hoverable">
    <h1 class="text-capitalize">@lang('admin.field.logo')</h1>
    <div class="divider"></div>
    <div class="postimagediv">
        <img src="" class="responsive-img" alt="">
        <input type="hidden" name="resource_id" value="">
        <div class="clearfix"></div>
        <a class="btn waves-effect waves-light cyan set-image modal-trigger" href="#modal-upload">@lang('admin.button.set image')</a>
    </div>
</div>
@endif
</div>
<div class="col s12">
<div class="row">
@if($setting->value)
@endif
@for($i=9;$i<=12;$i++)
<div class="col s3">
@if($setting->value)
	<div class="cat-bottom card hoverable">
        <h1 class="text-capitalize">@lang('admin.field.logo')</h1>
        <div class="divider"></div>
        <div class="postimagediv{{$i}}">
        	@if($images[$i])
            <img src="{{URL::to('/')}}/uploads/thumbnail/setting/{{$images[$i]->name}}" class="responsive-img" alt="">
            @else
            <img src="" class="responsive-img" alt="">
            @endif
            @if($images[$i])
            <input type="hidden" name="footer_image{{$i}}" value="<?php echo $images[$i]->id ?>">
            @else
            <input type="hidden" name="footer_image{{$i}}" value="">
            @endif
            <div class="clearfix"></div>
            <a class="btn waves-effect waves-light cyan {{ $images[$i] ? 'hide' : '' }} set-image modal-trigger" href="#modal-upload{{$i}}">@lang('admin.button.set image')</a>
            <a class="btn waves-effect waves-light cyan {{ $images[$i] ? '' : 'hide' }} remove-image{{$i}}">@lang('admin.button.remove image')</a>
        </div>
    </div>
@else

	<div class="cat-bottom card hoverable">
	    <h1 class="text-capitalize">@lang('admin.field.logo')</h1>
	    <div class="divider"></div>
	    <div class="postimagediv{{$i}}">
	        <img src="" class="responsive-img" alt="">
	        <input type="hidden" name="footer_image{{$i}}" value="">
	        <div class="clearfix"></div>
	        <a class="btn waves-effect waves-light cyan set-image modal-trigger" href="#modal-upload{{$i}}">@lang('admin.button.set image')</a>
	    </div>
	</div>
@endif
@if(isset($links))
	@if(isset($links[$i]))
		<?php $linkget = $links[$i]; ?>
	@else
		<?php $linkget = ''; ?>
	@endif
@endif
{{ Form::text('url['.$i.']', $linkget, ['id' => 'url', 'placeholder' => '']) }}
</div>
@endfor
</div>
</div>
<div class="col s4">
    @if($logofooter)
        <div class="cat-bottom card hoverable">
            <h1 class="text-capitalize">@lang('admin.field.logo_footer')</h1>
            <div class="divider"></div>
            <div class="postimagediv15">
                @if($logofooter->resource_id)
                <img src="{{$logofooter->image}}" class="responsive-img" alt="">
                @else
                <img src="" class="responsive-img" alt="">
                @endif
                @if($logofooter->id)
                <input type="hidden" name="logo_footer" value="{{$logofooter->resource_id}}">
                @else
                <input type="hidden" name="logo_footer" value="">
                @endif
                <div class="clearfix"></div>
                <a class="btn waves-effect waves-light cyan {{ $logofooter->resource_id ? 'hide' : '' }} set-image modal-trigger" href="#modal-upload15">@lang('admin.button.set image')</a>
                <a class="btn waves-effect waves-light cyan {{ $logofooter->resource_id ? '' : 'hide' }} remove-image15">@lang('admin.button.remove image')</a>
            </div>
        </div>
    @else
    <div class="cat-bottom card hoverable">
        <h1 class="text-capitalize">@lang('admin.field.logo_footer')</h1>
        <div class="divider"></div>
        <div class="postimagediv15">
            <img src="" class="responsive-img" alt="">
            <input type="hidden" name="logo_footer" value="">
            <div class="clearfix"></div>
            <a class="btn waves-effect waves-light cyan set-image modal-trigger" href="#modal-upload15">@lang('admin.button.set image')</a>
        </div>
    </div>
    @endif
    @if($logofooter)
    {{ Form::text('footerlogourl', $logofooter->value, ['id' => 'url', 'placeholder' => '']) }}
    @else
     {{ Form::text('footerlogourl', '', ['id' => 'url', 'placeholder' => '']) }}
    @endif
</div>
   <button type="submit" class="btn btn-sm right waves-light waves-effect green accent-4">@lang('admin.button.update')</button>

{!! Form::close() !!}


@endsection