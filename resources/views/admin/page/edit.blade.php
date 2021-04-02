@extends('layouts.admin')

@section('view-page')
    <a href="{{-- action('SiteController@showPage', $page->getOriginal('slug')) --}}" target="_blank">@lang('admin.button.view') @lang('admin.object.page')</a>
@endsection

@section('content')
{!! Form::open(['action' => ['Admin\PageController@update', $page->id], 'method' => 'PUT', 'id' => 'form-page', 'class' => 'row']) !!}
    @include('admin.page.form')
{!! Form::close() !!}
@endsection

@push('scripts')
	<script type="text/javascript">
		var form = $('#form-page');
		$('.btn-delete').click(function(event) {
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			form.children('input[name="_method"]').val('DELETE');
			form.submit();
		});
	</script>
@endpush
