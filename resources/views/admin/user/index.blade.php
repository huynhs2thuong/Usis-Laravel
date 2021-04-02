@extends('layouts.admin')

@section('content')
<div class="row">
    <h1 class="col s12 head-2">
        @lang('admin.object.user')
        <a href="{{ action('Admin\UserController@create') }}" class="page-title-action btn waves-effect waves-light cyan">@lang('admin.title.create raw')</a>
    </h1>
    <div class="col s12">
        <table class="bordered highlight posts datatable responsive-table display" cellspacing="0">
            <thead class="cyan white-text">
                <tr>
                    <th class="no-sort"></th>
                    <th>@lang('admin.field.name')</th>
                    <th>@lang('admin.field.email')</th>
                    <th>@lang('admin.field.level')</th>
                    <th class="no-sort">@lang('admin.field.date')</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td></td>
                        <td><a href="{{ action('Admin\UserController@edit', $user->id) }}">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->level }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <a class="waves-effect waves-light btn btn-sm" href="{{ action('Admin\UserController@edit', $user->id) }}">@lang('admin.button.edit')</a>
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
