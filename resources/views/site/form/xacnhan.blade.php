@extends('layouts.app')
@if($form)
@section('title', $form->title)
@endif
@section('content')
<section class="top-page bg-white">
	
		<div id="breadcrumbs" style="margin-bottom: 0">
			<div class="container"> 
		    <ul class="breadcrumb">
		      <li><a href="{{ ($current_locale == 'vi') ? '/' : '/en' }}">@lang('menu.page.home') </a></li>
		      <li><a href="{{action('SiteController@formXacNhan')}}">form</a></li>
		      @if($form) <li><a href="{{action('SiteController@formXacNhan')}}">{{$form->title}}</a></li> @endif
		    </ul>
		    </div>	
		</div>

	
</section>


<section class="post-detail  bg-white">
	<div class="container"> 
		<div class="row">
			<div class="col-sm-12">			
				<div class="entry-content">
					@if($form)
					{!! $form->description !!}
					{!! $form->excerpt!!}
					@endif
				</div>
			</div>
		</div>
	</div>
</section>

@endsection
@push('scripts')
<style>
.frameform {
    padding: 10px;
    border: solid #f1f1f1 1px;
    background: #fafafa;
}
.frameform .infusion-submit{
    text-align: center;
}
.frameform .infusion-field label,.frameform .infusion-submit label {
    width: 30%;
    float: left;
    text-align: left;
	color: #333;
}
.frameform .infusion-field input[type="text"],.frameform .infusion-field select,.frameform .infusion-field textarea {
    border: solid #eaeaea 1px;
    width: 70%;
    padding: 2px 0;
}
.frameform .infusion-field, .infusion-submit {
    clear: both;
    padding: 5px 0;
}
.frameform .infusion-submit input, .frameform .infusion-submit button {
    border: solid #b10e30 1px;
    padding: 10px 30px;
    color: #fff;
    background: #b10e30;
    text-transform: uppercase;
    font-size: 20px;
}
.frameform .infusion-option {
    width: 250px;
    display: inline-block;
    float: left;
}
.frameform input[type="checkbox"], .frameform input[type="radio"] {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    padding: 0;
}
.frameform .infusion-option label {
float: none;
    width: auto;
    font-family: Arial;
    font-size: 12px;
    font-weight: 400;
}
em{
	color: rgb(178, 34, 34)
}
</style>
@endpush