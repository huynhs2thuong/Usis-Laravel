@push('styles')
    <style type="text/css">
        .input-field > .browser-default {
            margin-top: 1rem;
        }
        .btn-change-pass {
            margin-bottom: 1rem;
        }
    </style>
@endpush

<div class="primary col s6">
    <h1 class="text-capitalize">
        @if ($user->id)
            @lang('admin.title.edit', ['object' => trans('admin.object.user')])
            <a href="{{ action('Admin\UserController@create') }}" class="page-title-action btn waves-effect waves-light cyan">@lang('admin.title.create raw')</a>
        @else
            @lang('admin.title.create', ['object' => trans('admin.object.user')])
        @endif
    </h1>
    <div class="input-field">
        <label class="active" for="name">@lang('admin.field.name')</label>
        {{ Form::text('name', $user->name, ['id' => 'name', 'placeholder' => '']) }}
    </div>
    <div class="input-field">
        <label class="active" for="email">@lang('admin.field.email')</label>
        {{ Form::email('email', $user->email, ['id' => 'email', 'placeholder' => '']) }}
    </div>

    @if ($user->id)
        <button type="button" class="btn-change-pass btn btn-sm waves-light waves-effect cyan">@lang('admin.button.change pass')</button>
        <div class="password-input-wrapper hide">
            <div class="input-field">
                <label class="active" for="password">@lang('admin.field.password')</label>
                {{ Form::password('password', ['id' => 'password', 'placeholder' => '', 'disabled' => '']) }}
            </div>
            <div class="input-field">
                <label class="active" for="password_confirmation">@lang('admin.field.password_confirmation')</label>
                {{ Form::password('password_confirmation', ['id' => 'password_confirmation', 'placeholder' => '', 'disabled' => '']) }}
            </div>
        </div>
    @else
        <div class="input-field">
            <label class="active" for="password">@lang('admin.field.password')</label>
            {{ Form::password('password', ['id' => 'password', 'placeholder' => '']) }}
        </div>
        <div class="input-field">
            <label class="active" for="password_confirmation">@lang('admin.field.password_confirmation')</label>
            {{ Form::password('password_confirmation', ['id' => 'password_confirmation', 'placeholder' => '']) }}
        </div>
    @endif

    @can('manage-user', User::class)
        <div class="row">
            <div class="input-field col s12">
                <label class="active">@lang('admin.field.level')</label>
                {{ Form::select('level', ['editor' => 'Editor', 'admin' => 'Admin'], ($user->level) ? $user->level : 'editor', ['class' => 'browser-default', 'placeholder' => '--']) }}
            </div>
        </div>
    @endcan

    @if ($user->id)
        <div class="clearfix"></div>
        <button type="submit" class="btn btn-sm left waves-light waves-effect green accent-4">@lang('admin.button.update')</button>
        @can('delete-user', $user)
            <button type="button" class="btn-delete btn btn-sm right waves-light waves-effect red darken-4">@lang('admin.button.delete')</button>
        @endcan
    @else
        <button type="submit" class="btn btn-sm waves-light waves-effect green accent-4">@lang('admin.button.create')</button>
    @endif
</div>
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#form-user').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 6,
                        equalTo: '#password'
                    },
                    level: {
                        required: true,
                        minlength: 1
                    }
                },
                errorElement : 'div',
                errorPlacement: function(error, element) {
                    var placement = $(element).data('error');
                    if (placement) $(placement).append(error)
                    else error.insertAfter(element);
                }
            })

            $('.btn-change-pass').click(function(event) {
                $(this).next('.password-input-wrapper').toggleClass('hide').find('input').prop('disabled', function(i, v) { return !v; });
                if (!$('.password-input-wrapper').hasClass('hide')) $('#password').focus();
            });
        });

    </script>
@endpush
