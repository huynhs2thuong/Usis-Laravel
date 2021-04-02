@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => ['Admin\ModuleController@update', $module->id ], 'method' => 'PUT', 'id' => 'form-category', 'class' => 'row']) !!}
    @include('admin.module.form')
{!! Form::close() !!}
@endsection

@push('scripts')
	<script type="text/javascript">
		var form = $('#form-category');
		$('.btn-delete').click(function(event) {
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			form.children('input[name="_method"]').val('DELETE');
			form.submit();
		});
	</script>
@endpush
