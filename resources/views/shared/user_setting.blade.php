<form method="POST" id="user_setting_form" action="{{ route('update_password', $user->id) }}">
    @method('PUT')
    @csrf

    <div class="modal fade" id="user_setting_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProfileModalTitle">{{ __('Setting') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="setting_email" class="col-sm-4 col-form-label text-md-right">
                            {{ __('E-Mail Address') }}
                        </label>

                        <div class="col-md-6">
                            <input id="setting_email" type="email" class="form-control" name="email" value="{{ $user->email }}" required readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="setting_username" class="col-md-4 col-form-label text-md-right">
                            {{ __('Username') }}
                        </label>

                        <div class="col-md-6">
                            <input id="setting_username" type="text" class="form-control" name="username" value="{{ $user->username }}" required readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="setting_current_password" class="col-md-4 col-form-label text-md-right">
                            {{ __('Current Password') }}
                        </label>

                        <div class="col-md-6">
                            <input id="setting_current_password" type="password" class="form-control js--password-input" name="current_password">

                            <span class="invalid-feedback">
                                <strong id="error_current_password"></strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="setting_new_password" class="col-md-4 col-form-label text-md-right">
                            {{ __('New Password') }}
                        </label>

                        <div class="col-md-6">
                            <input id="setting_new_password" type="password" class="form-control js--password-input" name="new_password">

                            <span class="invalid-feedback">
                                <strong id="error_new_password"></strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="setting_new_password_confirmation" class="col-md-4 col-form-label text-md-right">
                            {{ __('Confirm Password') }}
                        </label>

                        <div class="col-md-6">
                            <input id="setting_new_password_confirmation" type="password" class="form-control js--password-input" name="new_password_confirmation">

                            <span class="invalid-feedback">
                                <strong id="error_new_password_confirmation"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{ __('Close') }}
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save changes') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $('#user_setting_form').on('submit', function(event) {
        var csrf_token = $('#user_setting_form input[name="_token"]').val();
        var current_password = $('#setting_current_password').val();
        var new_password = $('#setting_new_password').val();
        var new_password_confirmation = $('#setting_new_password_confirmation').val();
        
        var user_setting_data = {
            _token: csrf_token,
            current_password: current_password,
            new_password: new_password,
            new_password_confirmation: new_password_confirmation,
        }

        $.ajax({
            url : "{{ route('update_password', $user->id) }}",
            type : "PUT",
            dataType:"json",
            data : user_setting_data
        }).always(function(result) {
            $('#user_setting_form .form-control').removeClass('is-invalid');
            $('.invalid-feedback strong').text('');
            $('.js--password-input').val('');
        }).done(function(result) {
            if (result.status) {
                $.toast({
                    heading: 'Success!',
                    text: result.message,
                    allowToastClose: false,
                    position: 'top-right',
                    loaderBg:'#2f3d4a',
                    icon: 'success',
                    hideAfter: 3500
                });

                $('#user_setting_modal').modal('hide');
            }
        }).fail(function(result) {
            let messages = result.responseJSON.message;
            Object.keys(messages).forEach(function(object){
                $(`#setting_${object}`).addClass('is-invalid');
                $(`#error_${object}`).text(messages[object][0]);
            });
        });

        event.preventDefault(); 
    });
</script>
