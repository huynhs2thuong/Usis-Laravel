@extends('layouts.admin')

@section('content')
<div class="row">
    <h1 class="col s12 head-2">
        @lang('admin.object.category') 
        <a href="{{ action('Admin\ModuleController@create') }}" class="page-title-action btn waves-effect waves-light cyan">@lang('admin.title.create raw')</a>
    </h1>
    <div class="clearfix"></div>
    <div class="col s12">
        <table class="bordered highlight posts datatable responsive-table display" cellspacing="0">
            <thead class="cyan white-text">
                <th class="no-sort"></th>
                <th>@lang('admin.field.title')</th>
<!--                 <th>@lang('admin.field.count')</th> -->
                <th class="no-sort">@lang('admin.field.author')</th>
                <th>@lang('admin.field.date')</th>
                <th class="no-sort"></th>
            </thead>
            <tbody>
            	@foreach ($categories as $category)
            		<tr>
            			<td></td>
            			<td><a href="{{ action('Admin\ModuleController@edit', $category->id) }}">{{ $category->title }}</a></td>
            			<!-- <td>{{-- $category->posts_count --}}</td> -->
                        <td>{{ $category->user->name or '' }}</td>
            			<td>{{ $category->created_at }}</td>
            			<td>
            				<a class="waves-effect waves-light btn btn-sm" href="{{ action('Admin\ModuleController@edit', $category->id) }}">@lang('admin.button.edit')</a>
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
