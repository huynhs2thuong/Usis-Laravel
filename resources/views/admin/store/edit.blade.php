@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => ['Admin\StoreController@update', $store->id], 'method' => 'PUT', 'id' => 'form-store', 'class' => 'row', 'onkeypress' => 'return event.keyCode != 13;']) !!}
    @include('admin.store.form')
{!! Form::close() !!}
@endsection

@push('scripts')
	<script type="text/javascript">
		var form = $('#form-store');
		$('.btn-delete').click(function(event) {
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			form.children('input[name="_method"]').val('DELETE');
			form.submit();
		});
	</script>
@endpush
