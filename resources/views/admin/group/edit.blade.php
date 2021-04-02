@extends('layouts.admin')

@section('view-page')
    <a href="{{ action('GroupController@show', $group->slug) }}" target="_blank">@lang('admin.button.view') @lang('admin.object.group')</a>
@endsection

@section('content')
{!! Form::open(['action' => ['Admin\GroupController@update', $group->id], 'method' => 'PUT', 'id' => 'form-group', 'class' => 'row', 'ng-controller' => 'GroupController']) !!}
    @include('admin.group.form')
{!! Form::close() !!}
@endsection

@push('scripts')
	<script type="text/javascript">
		var form = $('#form-group');
		$('.btn-delete').click(function(event) {
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			form.children('input[name="_method"]').val('DELETE');
			form.submit();
		});
	</script>
@endpush
