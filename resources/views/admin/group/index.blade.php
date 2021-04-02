@extends('layouts.admin')

@section('content')
<div class="row">
    <h1 class="col s12 head-2">
        @lang('admin.object.group')
        <a href="{{ action('Admin\GroupController@create') }}" class="page-title-action btn waves-effect waves-light cyan">@lang('admin.title.create raw')</a>
    </h1>
    <div class="clearfix"></div>
    <div class="col s12">
        <table class="bordered highlight posts datatable responsive-table display" cellspacing="0">
            <thead class="cyan white-text">
                <th class="no-sort"></th>
                <th>@lang('admin.field.title')</th>
                <th>@lang('admin.dish type.side dish')</th>
                <th>@lang('admin.field.count')</th>
                <th class="no-sort">@lang('admin.field.author')</th>
                <th>@lang('admin.field.date')</th>
                <th class="no-sort"></th>
            </thead>
            <tbody>
            	@foreach ($groups as $group)
            		<tr>
            			<td></td>
            			<td><a href="{{ action('Admin\GroupController@edit', $group->id) }}">{{ $group->title }}</a></td>
                        <td>{!! $group->is_side_html !!}</td>
            			<td>{{ $group->dishes_count }}</td>
                        <td>{{ $group->user->name or '' }}</td>
            			<td>{{ $group->created_at }}</td>
            			<td>
            				<a class="waves-effect waves-light btn btn-sm" href="{{ action('Admin\GroupController@edit', $group->id) }}">@lang('admin.button.edit')</a>
                            <a class="waves-effect waves-light btn btn-sm grey" href="{{ action('GroupController@show', $group->slug) }}" target="_blank">@lang('admin.button.view')</a>
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
        $('table').DataTable();
    </script>
@endpush
