@extends('layouts.app')

@section('content')
<article class="container-fluid mobile">
	<section class="mobile-thanks-text row">
		<h1 class="text-primary text-uppercase">@e('Cảm ơn', 'Thank you')</h1>
		<p>{{ preg_replace('#<[^>]+>#', ' ', trans('cart.message.thank')) }}</p>
	</section>
	<!-- <section class="mobile-thanks-summary row">
		<div class="dish display-flex">
			<p class="dish-title">GÀ SÀI GÒN SỐT CAY</p>
			<div class="dish-qty">
				<span>Số lượng</span>
				<input type="number" name="" value="1" readonly>
			</div>
		</div>
		<div class="dish display-flex">
			<p class="dish-title">GÀ GIÒN VUI VẺ</p>
			<div class="dish-qty">
				<span>Số lượng</span>
				<input type="number" name="" value="1" readonly>
			</div>
		</div>
		<div class="total display-flex">
			<p class="total-title">TỔNG:</p>
			<p class="total-price">332.000 VNĐ</p>
		</div>
	</section> -->
	<section class="mobile-thanks-banner">
		<img src="/images/home/banner2.jpg" alt="" class="img-responsive">
		<a href="{{ route('page', 'khuyen-mai') }}"><img src="/images/mobile/banner-2.jpg" alt="" class="img-responsive"></a>
	</section>
</article>
@endsection
