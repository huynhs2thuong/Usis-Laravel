@if (session('response'))
<script type="text/javascript">
	$(window).load(function() {
        Materialize.toast('<i class="{{ session('response')['status'] === 'success' ? 'mdi-action-done green-text' : 'mdi-alert-error red-text' }}"></i>{{ session('response')['message'] }}', 3000);
	});
</script>
@endif

@if (count($errors) > 0)
<script type="text/javascript">
	$(window).load(function() {
		@foreach($errors->all() as $error)
            Materialize.toast('<i class="mdi-alert-error red-text"></i>{{ $error }}', 3000);
        @endforeach
	});
</script>
@endif
