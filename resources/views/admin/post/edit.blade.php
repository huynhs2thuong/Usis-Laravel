@extends('layouts.admin')

@section('view-page')
    <a href="{{-- action('SiteController@showPost', $post->slug) --}}" target="_blank"> @lang('admin.button.view') @lang('admin.object.post')</a> 
@endsection

@section('content')
{!! Form::open(['action' => ['Admin\PostController@update', $post->id], 'method' => 'PUT', 'id' => 'form-post', 'class' => 'row']) !!}
    @include('admin.post.form')
{!! Form::close() !!}
@endsection

@push('scripts')
	<script type="text/javascript">
		var form = $('#form-post');
		$('.btn-delete').click(function(event) {
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			form.children('input[name="_method"]').val('DELETE');
			form.submit();
		});
	</script>
@endpush
