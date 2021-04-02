@extends('layouts.admin')


@section('content')
    <div class="row">
        <h1 class="col s12 head-2">
            @lang('admin.object.menu')
            <a href="{{ action('Admin\MenuController@create') }}" class="page-title-action btn waves-effect waves-light cyan">@lang('admin.title.create raw')</a>
        </h1>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <div class="col s12">
        <table class="bordered highlight posts datatable responsive-table display" cellspacing="0">
            <thead class="cyan white-text">
            <th class="no-sort"></th>
            <th>@lang('admin.field.title')</th>
            <th>@lang('admin.field.position')</th>
            <th class="no-sort">@lang('admin.field.author')</th>
            <th>@lang('admin.field.date')</th>
            <th class="no-sort"></th>
            </thead>
            <tbody>
            @foreach ($menus as $menu)
                <tr>
                    <td></td>
                    <td><a href="{{ action('Admin\MenuController@edit', $menu->id) }}">{{ $menu->title }}</a></td>
                    <td>{{ $menu->position }}</td>
                    <td>{{ $menu->user->name or '' }}</td>
                    <td>{{ $menu->created_at }}</td>
                    <td>
                        <a class="waves-effect waves-light btn btn-sm" href="{{ action('Admin\MenuController@edit', $menu->id) }}">@lang('admin.button.edit')</a>
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

</script>
@endpush