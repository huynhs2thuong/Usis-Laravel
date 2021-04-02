@extends('layouts.admin')

@push('styles')
	<link rel="stylesheet" type="text/css" href="/js/plugins/jquery.nestable/nestable.css">
	<style type="text/css">
		.dd {
			max-width: 100%;
		}
		.dd-handle {
			cursor: move;
			padding: 10px;
			padding-right: 50px;
			height: auto;
			font-size: 1.15em;
		}
		.dd-delete {
			position: absolute;
			top: 0;
			right: 0;
			bottom: 0;
			font-size: 1.2em;
			width: 42px;
			line-height: 42px;
			text-align: center;
			cursor: pointer;
		}
	</style>
@endpush

@section('content')
{!! Form::open(['action' => ['Admin\SettingController@update', $setting->name], 'method' => 'PUT', 'id' => 'form-setting', 'class' => 'row']) !!}
	<h1 class="text-capitalize col s12">@lang('admin.setting.home-promo')</h1>
	<div class="col s6">
		<table class="bordered highlight posts datatable responsive-table display" cellspacing="0">
            <thead class="cyan white-text">
                <tr>
                    <th class="no-sort"></th>
                    <th>ID</th>
                    <th>@lang('admin.field.title')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dishes as $dish)
                    <tr data-id="{{ $dish->id }}">
                        <td></td>
                        <td>{{ $dish->product_id }}</td>
                        <td>{{ $dish->title }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" class="add-to-menu btn btn-sm waves-light waves-effect right cyan">@lang('admin.button.add to list')</button>
	</div>
	<div class="col s5 offset-s1">
		<div id="nestable" class="dd">
		    <ol class="dd-list">
		    	@foreach (json_decode($setting->value) as $id)
		        <li class="dd-item" data-id="{{ $promos[$id]->id }}">
		            <div class="dd-handle">{{ $promos[$id]->title }}</div>
		            <span class="dd-delete"><i class="mdi-navigation-close"></i></span>
		        </li>
		        @endforeach
		    </ol>
		</div>
		{{ Form::textarea('dishes', null, ['id' => 'json-output', 'class' => 'hide']) }}
		<button type="submit" class="btn btn-sm left waves-light waves-effect right green accent-4">@lang('admin.button.save list')</button>
	</div>
{!! Form::close() !!}
@endsection

@push('scripts')
	<script type="text/javascript" src="/js/plugins/jquery.nestable/jquery.nestable.js"></script>
    <script type="text/javascript">
    	table = $('table').DataTable({
    		dom: 'frtp'
    	});
        $(document).ready(function() {
        	var $nestable = $('#nestable'),
				$json_output = $('#json-output');

        	var updateOutput = function(e) {
			    var list = e.length ? e : $(e.target),
			        output = list.data('output');
			    if (window.JSON) {
			        if (output) {
			            output.val(window.JSON.stringify(list.nestable('serialize')).replace(/{"id":|}/g, ''));
			        }
			    } else {
			        alert('JSON browser support required for this page.');
			    }
			};

			var addToMenu = function() {
			    var tr, data;
			    table.rows({selected: true}).every( function ( rowIdx, tableLoop, rowLoop ) {
			    	tr = $(table.row(this).node());
			    	data = this.data()[2];
			    	if ($json_output.val().indexOf(tr.data('id')) === -1)
			    		$nestable.children('.dd-list').append('<li class="dd-item" data-id="' + tr.data('id')  + '"><div class="dd-handle">' + data + '</div><span class="dd-delete"><i class="mdi-navigation-close"></i></span></li>');
			    });
			    updateOutput($nestable.data('output', $json_output));
			};

        	$nestable.nestable({
        		maxDepth: 1
        	});
        	updateOutput($nestable.data('output', $json_output));

        	$nestable.on('change', function() {
			    updateOutput($nestable.data('output', $json_output));
			}).on('click', '.dd-delete', function(event) {
				$(this).parent('.dd-item').detach();
				updateOutput($nestable.data('output', $json_output));
			});;

			$('.btn.add-to-menu').click(function(event) {
				addToMenu();
			});
        });
    </script>
@endpush
