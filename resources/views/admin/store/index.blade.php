@extends('layouts.admin')

@section('content')
<div class="row">
    <h1 class="col s12 head-2">
        @lang('admin.object.store')
        <a href="{{ action('Admin\StoreController@create') }}" class="page-title-action btn waves-effect waves-light cyan">@lang('admin.title.create raw')</a>
    </h1>
    <div class="col s12">
        <table class="bordered highlight posts datatable responsive-table display" cellspacing="0">
            <thead class="cyan white-text">
                <tr>
                    <th class="no-sort"></th>
                    <th>@lang('admin.field.title')</th>
                    <th class="no-sort">@lang('admin.field.city')</th>
                    <th class="no-sort">@lang('admin.field.district')</th>
                    <th class="no-sort">@lang('admin.field.author')</th>
                    <th>@lang('admin.field.date')</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stores as $store)
                    <tr>
                        <td></td>
                        <td><a href="{{ action('Admin\StoreController@edit', $store->id) }}">{{ $store->title }}</a></td>
                        <td>{{ $store->district->city->title or '' }}</td>
                        <td>{{ $store->district->title or '' }}</td>
                        <td>{{ $store->user->name or '' }}</td>
                        <td>{{ $store->created_at }}</td>
                        <td>
                            <a class="waves-effect waves-light btn btn-sm" href="{{ action('Admin\StoreController@edit', $store->id) }}">@lang('admin.button.edit')</a>
                            <a class="waves-effect waves-light btn btn-delete" href="{{action('Admin\StoreController@delete', ['id'=>$store->id])}}">@lang('admin.button.delete')</a>
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
        $('table').DataTable({
            initComplete: function () {
                this.api().columns().every( function (colIdx) {
                    if ($.inArray(colIdx, [2]) !== -1) {
                        var column = this;
                        var select = $('<select class="browser-default"><option value="" selected=""></option></select>')
                            .appendTo( $(column.header()) )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    }
                } );
            }
        });
    </script>
@endpush
