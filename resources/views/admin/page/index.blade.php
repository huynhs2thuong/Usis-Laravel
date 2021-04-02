@extends('layouts.admin')

@section('content')
<div class="row">
    <h1 class="col s12 head-2">
        @lang('admin.object.page')
        <a href="{{ action('Admin\PageController@create') }}" class="page-title-action btn waves-effect waves-light cyan">@lang('admin.title.create raw')</a>
    </h1>
    <div class="clearfix"></div>
    <div class="col s12">
        <table class="bordered highlight posts datatable responsive-table display" cellspacing="0">
            <thead class="cyan white-text">
                <th class="no-sort"></th>
                <th>@lang('admin.field.title')</th>
                <td>@lang('admin.field.draft')</td>
                <th class="no-sort">@lang('admin.field.author')</th>
                <th>@lang('admin.field.date')</th>
                <th class="no-sort"></th>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td></td>
                        <td><a href="{{ action('Admin\PageController@edit', $page->id) }}">{{ $page->title }}</a></td>
                        <td class="center-align">{!! $page->is_draft_html !!}</td>
                        <td>{{ $page->user->name or '' }}</td>
                        <td>{{ $page->created_at }}</td>
                        <td>
                            <a class="waves-effect waves-light btn btn-sm" href="{{ action('Admin\PageController@edit', $page->id) }}">@lang('admin.button.edit')</a>
                            <a class="waves-effect waves-light btn btn-sm grey" href="{{-- action('SiteController@showPage', $page->slug) --}}" target="_blank">@lang('admin.button.view')</a>
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
