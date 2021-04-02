@extends('layouts.admin')

@push('styles')
    <style type="text/css">
        #form-city {
            margin-bottom: 2rem;
        }
        .input-field + p {
            margin-top: 0;
        }
    </style>
@endpush

@section('content')
<div class="row">
    <h1 class="col s12 head-2">@lang('admin.field.city')</h1>
    <div class="col s6">
        {!! Form::open(['action' => 'Admin\CityController@store', 'method' => 'POST', 'id' => 'form-city']) !!}
            <div class="input-field">
                @include('partials.lang_input', ['type' => 'text', 'model' => 'city', 'attr' => 'title', 'title' => trans('admin.field.title')])
            </div>
            <div class="input-field">
                <label class="active" for="code">@lang('admin.field.code')</label>
                {{ Form::text('code', NULL, ['id' => 'code', 'class' => 'num', 'placeholder' => '']) }}
            </div>
            <p>
                {{ Form::checkbox('delivery', 1, false, ['id' => 'delivery']) }}
                <label for="delivery">@lang('admin.field.delivery')</label>
            </p>
            <button type="submit" class="btn btn-sm waves-light waves-effect cyan right">@lang('admin.button.create')</button>
            <div class="clearfix"></div>
        {!! Form::close() !!}
        <table class="bordered highlight posts datatable responsive-table display" cellspacing="0">
            <thead class="cyan white-text">
                <tr>
                    <th class="no-sort"></th>
                    <th>@lang('admin.field.title')</th>
                    <th>@lang('admin.field.code')</th>
                    <th>@lang('admin.field.delivery')</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var table = $('table').DataTable({
            processing: true,
            ajax: '{{ action('Admin\CityController@index') }}',
            order: [],
            paging: false,
            select: false,
            columnDefs: [
                { orderable: false, targets: 0 },
                { orderable: false, targets: 'no-sort' }
            ]
        });

        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

        $('#form-city').validate({
            rules: {
                'title[vi]': {
                    required: true,
                    minlength: 3
                },
                'title[en]': {
                    minlength: 3
                },
                code: {
                    required: true,
                    number: true
                }
            },
            errorElement : 'div',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) $(placement).append(error)
                error.insertAfter(element);
            },
            submitHandler: function(form) {
                var self = $(form);
                $.ajax({
                    url: self.attr('action'),
                    type: 'POST',
                    data: self.serialize()
                })
                .done(function(data) {
                    if (data.status === 'success') {
                        Materialize.toast('<i class="mdi-action-done green-text"></i>' + data.message, 3000);
                        table.ajax.reload();
                        $('#form-city')[0].reset();
                    } else Materialize.toast('<i class="mdi-alert-error red-text"></i>' + data.message, 3000);
                });
            }
        })
    </script>
@endpush
