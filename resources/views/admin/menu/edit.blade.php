@extends('layouts.admin')

@section('content')
{!! Form::open(['action' => ['Admin\MenuController@update', $menu->id ], 'method' => 'PUT', 'id' => 'form-menu', 'class' => 'row']) !!}
    @include('admin.menu.form')
{!! Form::close() !!}
@endsection

@push('scripts')
	<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/bootstrap-iconpicker/jquery-menu-editor.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/bootstrap-iconpicker/js/iconset/fontawesome5-3-1.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/bootstrap-iconpicker/js/bootstrap-iconpicker.js"></script>
	<script type="text/javascript">
		var form = $('#form-menu');
		$('.btn-delete').click(function(event) {
			if (!confirm('{{ trans('admin.message.confirm') }}')) return;
			form.children('input[name="_method"]').val('DELETE');
			form.submit();
		});
		$("#form-menu" ).submit(function( event ) {
			$( "#btnSave" ).trigger( "click" );
		});
	</script>
@endpush
