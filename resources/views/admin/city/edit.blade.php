@extends('layouts.admin')

@push('styles')
    <style type="text/css">
        #form-city,
        #form-district {
            margin-bottom: 2rem;
        }
        td > .lang-switch {
            display: none;
        }
        td .form-control {
            margin-bottom: 0;
        }
        td:last-child {
            white-space: nowrap;
        }
        .input-field + p {
            margin-top: 0;
        }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col m4">
        <h2 class="head-2">@lang('admin.title.edit', ['object' => trans('admin.field.city')])</h2>
        {!! Form::open(['action' => ['Admin\CityController@update', $city->id], 'method' => 'PUT', 'id' => 'form-city']) !!}
            <div class="input-field">
                @include('partials.lang_input', ['type' => 'text', 'model' => 'city', 'attr' => 'title', 'title' => trans('admin.field.title')])
            </div>
            <p>
                {{ Form::checkbox('delivery', 1, $city->delivery, ['id' => 'city-delivery']) }}
                <label for="city-delivery">@lang('admin.field.delivery')</label>
            </p>
            <button type="button" class="btn-delete btn btn-sm left waves-light waves-effect red darken-4">@lang('admin.button.delete')</button>
            <button type="submit" class="btn btn-sm right waves-light waves-effect green accent-4">@lang('admin.button.update')</button>
            <div class="clearfix"></div>
        {!! Form::close() !!}
    </div>
    <div class="col m8">
        <h2 class="head-2">@lang('admin.field.district')</h2>
        {!! Form::open(['action' => ['Admin\DistrictController@store', $city->id], 'method' => 'POST', 'id' => 'form-district']) !!}
            <div class="input-field">
                @include('partials.lang_input', ['type' => 'text', 'attr' => 'title', 'title' => trans('admin.field.title')])
            </div>
            <div class="input-field">
                <label class="active">@lang('admin.field.code')</label>
                {{ Form::text('code', NULL, ['class' => 'num', 'placeholder' => '']) }}
            </div>
            <div class="input-field">
                <label class="active">@lang('admin.field.min price')</label>
                {{ Form::text('min_price', config('cart.total_min'), ['class' => 'num', 'placeholder' => '']) }}
            </div>
            <p>
                {{ Form::checkbox('delivery', 1, false, ['id' => 'district-delivery']) }}
                <label for="district-delivery">@lang('admin.field.delivery')</label>
            </p>
            <button type="submit" class="btn btn-sm waves-light waves-effect cyan right">@lang('admin.button.create')</button>
            <div class="clearfix"></div>
        {!! Form::close() !!}
        <table class="bordered highlight posts datatable responsive-table display" cellspacing="0">
            <thead class="cyan white-text">
                <tr>
                    <th></th>
                    <th class="no-sort">@lang('admin.field.title')</th>
                    <th>@lang('admin.field.code')</th>
                    <th>@lang('admin.field.min price')</th>
                    <th>@lang('admin.field.delivery')</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var _TOKEN = $('input[name="_token"]').val(),
            $form_city = $('#form-city'),
            $form_district = $('#form-district'),
            table = $('table').DataTable({
                processing: true,
                ajax: '{{ action('Admin\DistrictController@index', $city->id) }}',
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

        $form_district.validate({
            rules: {
                'title[vi]': {
                    required: true,
                    minlength: 3
                },
                'title[en]': {
                    minlength: 3
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
                    } else Materialize.toast('<i class="mdi-alert-error red-text"></i>' + data.message, 3000);
                });
            }
        })

        $form_city.validate({
            rules: {
                'title[vi]': {
                    required: true,
                    minlength: 3
                },
                'title[en]': {
                    minlength: 3
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
                    }
                });
            }
        })

        $('.btn-delete').click(function(event) {
            if (!confirm('{{ trans('admin.message.confirm') }}')) return;
            $form_city.children('input[name="_method"]').val('DELETE');
            $form_city[0].submit();
        });

        $('table').on('click', '.district-update', function(event) {
            event.preventDefault();
            var self = $(this),
                $row = self.closest('tr'),
                title = {},
                minPrice = {{ config('cart.total_min') }}
                delivery = 0;
            $row.children('td').eq(1).find('input.form-control').each(function(index, el) {
                title[$(el).data('lang')] = $(el).val();
            });
            minPrice = $row.children('td').eq(3).children('.form-control').val();
            if ($row.children('td').eq(4).children('.filled-in').is(':checked')) delivery = 1;
            $.post(self.attr('href'), {title: title, min_price: minPrice, delivery: delivery, _method: 'PUT', _token: _TOKEN}, function(data, textStatus, xhr) {
                Materialize.toast('<i class="' + (data.status === 'success' ? 'mdi-action-done green-text' : 'mdi-alert-error red-text') + '"></i>' + data.message, 3000);
            });
        }).on('click', '.district-delete', function(event) {
            event.preventDefault();
            if (!confirm('{{ trans('admin.message.confirm') }}')) return;
            var self = $(this);
            $.post($(this).siblings('.district-update').attr('href'), {_method: 'DELETE', _token: _TOKEN}, function(data, textStatus, xhr) {
                if (data.status === 'success') {
                    Materialize.toast('<i class="mdi-action-done green-text"></i>' + data.message, 3000);
                    table.ajax.reload();
                } else Materialize.toast('<i class="mdi-alert-error red-text"></i>' + data.message, 3000);
            });
        });
    </script>
@endpush
