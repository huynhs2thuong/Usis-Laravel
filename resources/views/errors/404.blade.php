@extends('layouts.app')

@section('meta')
    <title>Page not found - TOA</title>
@endsection

@section('content')

<div class="page404">
	<img class="img-lazy"  data-src="/images/404.jpg" alt="" />
	<div class="container">
		<div class="display-table">
			<div class="table-cell">
				<div class="text">
				<h1>404</h1>
				<p>“Nội dung này không có. Vui lòng quay trở lại trang chủ. Xin cảm ơn”</p>			
				<a href="/" class="btn btn-56">Quay về trang chủ</a>	
				</div>
			</div>
		</div>

	</div>
	
</div>
</div>
@endsection
@push('styles')
	<style type="text/css">
	body{overflow-x: hidden}
	</style>
@endpush
