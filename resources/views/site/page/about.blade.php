@extends('layouts.app')

@section('title', $page->title)

@section('content')
	@if($page->slug == 'lien-he' || $page->slug =='contact')
	<section class="top-page bg-white">
		
			@include('partials.breadcrumb')
		<div class="container"> 
			<div class="page-title wow">
				<h1 class="title">
					<span>
						@lang('menu.page.contactus')
					</span>
				</h1>
			</div>
		</div>
	</section>
	<section class="u008 bg-white statue-of-liberty">
		<div class="container"> 
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					@if($form)
					{!!$form->excerpt!!}
					@endif
				</div>
			</div>
		</div>
	</section>
	@else
	<section class="top-page bg-white">
		
			@include('partials.breadcrumb')
		<div class="container">
			<div class="page-title wow">
					<h1 class="title"> <span>{{$page->title}}</span></h1>
			</div>
		</div>
	</section>
	@endif
	{!! $page->description !!} <!-- content -->
	
	
	<!-- @if($page->slug == 'lien-he' || $page->slug =='contact')
	@else -->
	<!-- //đói tác chiến lược -->
	<!-- <section class="u003 row-section  bg-white wow"  >
	<div class="container">
		<div class="section-header">
			<h2 class="section-title"> <a href="{{action('SiteController@showPage',['slug'=>'doi-tac'])}}">@lang('menu.page.partner_strategy') </a></h2>
		</div>
		@include('partials.partner')
	</div>
	</section>

	<section class="list8 row-section wow">
		<div class="container">
			<div class="section-header">
				<h2 class="section-title">
					<a href="{{route('customer')}}">
						@lang('menu.page.customer_success')
					</a>
				</h2>
			</div>
			<div class="list row">
				@foreach ($customer as $cust)
				<div class="col-md-4 col-sm-6 ">
					<div class="list_item ">
						<a class="list_img" href="{{ action('SiteController@customerDetail',['slug'=>$cust->getSlug(),'suffix'=>'.html']) }}">

							@if($cust->content_image)
								<img class="img-lazy" data-src="/uploads/images/contents/{{$cust->content_image}}" alt="" /> 
							@else
								<img class="img-lazy" data-src="{{$cust->getImage('thumbnail')}}" alt="" /> 
							@endif
						</a> 
						<span class="list_arrow">
							
						</span>
						<div class="list_text">
							<a class="list_title" href="{{ action('SiteController@customerDetail',['slug'=>$cust->getSlug(),'suffix'=>'.html']) }}">
								{{$cust->title }} 
							</a>
							<div class="list_desc">{!!$cust->excerpt !!}</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>
	@endif -->
@endsection
<style>
	.form-2{
		padding-bottom: 70px;
	}
	.form-2 .boxNull {
		margin-bottom: 68px
	}
.form-2 .radioGender,
.form-2 .radioAdvisory {
    display: flex;
    justify-content: space-between;
}

.form-2 .radioGender .input-group input,
.form-2 .radioAdvisory .input-group input {
    margin-right: 1rem;
    margin-left: 2rem;
}
.form-2 .radioGender span,.form-2 .radioGender .input-group .radio{
	display: flex;
	align-items: center
}
.form-2 .radioGender span,
.form-2 .radioAdvisory p {
    width: 50%;
}
.form-2 .checkbox+.checkbox,.form-2 .radio+.radio{
	margin-top: unset;
}
.form-2 .checkbox , .form-2 .radio{
	margin-top: 0;
	
}
.form-2 .radioGender .input-group{
	display: flex;
	height:56px;
}

.form-2 input[type="radio"] {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    width: 0;
    height: 0;
}
.form-2 .input-group{
	width: 100%;
}
.form-2 .input-group>.form-control {
    height: 56px;
}

.form-2 .radio {
    margin-left: 1rem;
}

.form-2 .radio label {
    padding-left: 35px;
    position: relative;
    margin: 0;
    line-height: 20px;
}

.form-2 .radio label:before {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 0;
    content: '';
    background: #fff;
    border: 1px solid black;
}

.form-2 input[type="radio"]:checked~label:after {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 4px;
    content: '';
    background: blue;
    border: blue;
}

.form-2 .col-12 .button {
    display: flex;
    justify-content: center;
}

.form-2 .col-12 .button button {
    position: relative;
    display: inline-block;
    overflow: hidden;
    color: #fff!important;
    vertical-align: middle;
    padding: 0 15px;
    border: none;
    box-shadow: none!important;
    line-height: 40px;
    border-radius: 5px;
    background-color: #1d3768;
	height: 56px;
    min-width: 165px;
}

@media only screen and (max-width: 992px) {
   .form-2  .radioAdvisory p {
        width: auto;
    }
    .form-2 .radioGender span {
        width: 50%;
    }
	.form-2 .boxNull {
		margin-bottom: 0px
	}
}

@media only screen and (max-width: 768px) {
    .form-2 .radioAdvisory p {
        width: 50%;
    }
    .form-2 .radioGender span {
        width: 50%;
    }
   .form-2  .radioAdvisory .radio {
        width: 45%;
    }
}

@media only screen and (max-width: 576) {
   .form-2  .radioAdvisory p {
        width: 50%;
    }
   .form-2  .radioGender span {
        width: 50%;
    }
  .form-2  .radioAdvisory .radio {
        width: unset;
    }
}
</style>
@push('og-meta')
@include('partials.canonical')
	<title>@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->title}} @endif</title>
	<meta name="title" content="@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->title}} @endif">
	<meta name="description" content="@if(isset($page->meta_desc) && $page->meta_desc != '') {{$page->meta_desc}} @else {{$page->excerpt}} @endif" />
	<meta name="keywords" content="Tư vấn đầu tư định cư Mỹ, đầu tư Mỹ, chương trình EB-5, thẻ xanh Mỹ"/>   
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta property="og:title" content="@if(isset($page->meta_title) && $page->meta_title != '') {{$page->meta_title}} @else {{$page->title}} @endif">
	<meta property="og:description" content="@if(isset($page->meta_desc) && $page->meta_desc != '') {{$page->meta_desc}} @else {{$page->excerpt}} @endif">
	<meta property="og:site_name" content="@if(isset($page->meta_desc) && $page->meta_title != '') {{$page->meta_desc}} @else {{$page->excerpt}} @endif">
	<meta property="og:type"   content="article" /> 
	<meta property="og:image" content="@if($page->resource_id) {{$page->image}} @else <?php echo URL::to('/').'/images/no-image.jpg';?> @endif"/>
	@include('partials.linklanguage')
	<script type="application/ld+json">
	{
	    "@context": "http://schema.org",
	    "@type": "BreadcrumbList",
	    "itemListElement": [{
	      "@type": "ListItem",
	      "position": 1,
	      "item": {
	        "@id": "{{URL::to('/')}}{{ ($current_locale == 'vi') ? '/' : '/en' }}",
	        "name": "Home",
	        "image": ""
	      }
	    },{
	      "@type": "ListItem",
	      "position": 2,
	      "item": {
	        "@id": "{{Request::url()}}",
	        "name": "{{ $page->title }}",
	        "image": ""
	      }
	    }
	    ]
	  }
	</script>
@endpush