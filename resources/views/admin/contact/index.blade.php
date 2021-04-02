@extends('layouts.admin')

@push('styles')
    <style type="text/css">
        table.dataTable.display tbody {
            font-size: 0.8667rem;
        }
    </style>
@endpush

@section('content')
<div class="row">
    <h1 class="col s12 head-2">
        @lang('admin.object.contact')
        {{ Form::open(['action' => 'Admin\ContactController@export', 'method' => 'POST', 'class' => 'form-inline']) }}
            <button class="page-title-action btn waves-effect waves-light cyan">@lang('admin.button.export')</button>
        {{ Form::close() }}
    </h1>
    <div class="clearfix"></div>
    <div class="col s12">
        <table class="bordered highlight posts datatable responsive-table display" cellspacing="0">
            <thead class="cyan white-text">
                <th class="no-sort"></th>
                <th>@lang('admin.field.name')</th>
                <th>@lang('admin.field.email')</th>
                <th>@lang('admin.field.phone')</th>
                <th class="no-sort">@lang('admin.field.message')</th>
                <th>@lang('admin.field.date')</th>
                <th class="no-sort"></th>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td></td>
                        <td class="no-wrap">{{ $contact->name }}</td>
                        <td class="no-wrap">{{ $contact->email }}</td>
                        <td class="no-wrap">{{ $contact->phone }}</td>
                        <td>{{ $contact->message }}</td>
                        <td class="no-wrap">{{ $contact->created_at }}</td>
                        <td>
                            <a class="waves-effect waves-light btn btn-delete btn-sm red darken-4" href="{{ action('Admin\ContactController@destroy', $contact->id) }}">@lang('admin.button.delete')</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var _TOKEN = $('input[name="_token"]').val();

        var table = $('table').DataTable();

        $('.btn-delete').click(function(event) {
            event.preventDefault();
            var self = $(this);
            $.post(self.attr('href'), {_method: 'DELETE', _token: _TOKEN}, function(data, textStatus, xhr) {
                if (data.status === 'success') {
                    Materialize.toast('<i class="mdi-action-done green-text"></i>' + data.message, 3000);
                    table.row(self.parents('tr')).remove().draw();
                } else Materialize.toast('<i class="mdi-alert-error red-text"></i>' + data.message, 3000);
            });
        });
    </script>
@endpush
