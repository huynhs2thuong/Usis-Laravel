@if ($breadcrumbs)
	<div id="breadcrumbs">
		<div class="container">
			<ul class="breadcrumb">
				@foreach ($breadcrumbs as $breadcrumb)
					@if ($breadcrumb->url && !$breadcrumb->last)
						<li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
					@else
						<li><span>{{ $breadcrumb->title }}</span></li>
					@endif
				@endforeach
			</ul>
		</div>
	</div>
@endif