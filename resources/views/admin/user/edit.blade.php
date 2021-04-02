@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => ['Admin\UserController@update', $user->id], 'method' => 'PUT', 'id' => 'form-user', 'class' => 'row']) !!}
    @include('admin.user.form')
{!! Form::close() !!}
@endsection

@push('scripts')
	<script type="text/javascript">
		var form = $('#form-user');
		$('.btn-delete').click(function(event) {
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			form.children('input[name="_method"]').val('DELETE');
			form.submit();
		});
	</script>
@endpush
