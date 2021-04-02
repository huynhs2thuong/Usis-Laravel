@extends('layouts.app')

@section('content')
<article class="thankyou">
	<h1 class="text-uppercase text-center">@e('Cảm ơn', 'Thank you')</h1>
	<div class="message display-flex">
		<div class="announce">
			<div class="text text-center">@lang('cart.message.thank')</div>
			<div class="bee">
				<img src="/images/thankyou/bee.png" alt="" class="img-responsive">
			</div>
		</div>
	</div>
</article>
@endsection

@push('scripts')
<script>
	if (dataLayer != undefined) {
	    dataLayer.push(JSON.parse('{!! $tracking !!}'));
	}
</script>
@endpush