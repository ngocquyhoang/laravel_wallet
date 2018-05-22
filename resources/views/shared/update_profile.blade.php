<form method="POST" id="update_profile_form" action="{{ route('user.update', $user->id) }}">
    @method('PUT')
    @csrf

    <div class="modal fade" id="update_profile_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProfileModalTitle">{{ __('Update profile') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="update_email" class="col-sm-4 col-form-label text-md-right">
                            {{ __('E-Mail Address') }}
                        </label>

                        <div class="col-md-6">
                            <input id="update_email" type="email" class="form-control" name="email" value="{{ $user->email }}" required readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="update_username" class="col-md-4 col-form-label text-md-right">
                            {{ __('Username') }}
                        </label>

                        <div class="col-md-6">
                            <input id="update_username" type="text" class="form-control" name="username" value="{{ $user->username }}" required>

                            <span class="invalid-feedback">
                                <strong id="error_username"></strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="update_full_name" class="col-md-4 col-form-label text-md-right">
                            {{ __('Full name') }}
                        </label>

                        <div class="col-md-6">
                            <input id="update_full_name" type="text" class="form-control" name="full_name" value="{{ $user->full_name }}">

                            <span class="invalid-feedback">
                                <strong id="error_full_name"></strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="update_phone_number" class="col-md-4 col-form-label text-md-right">
                            {{ __('Phone number') }}
                        </label>

                        <div class="col-md-6">
                            <input id="update_phone_number" type="number" class="form-control" name="phone_number" value="{{ $user->phone_number }}">

                            <span class="invalid-feedback">
                                <strong id="error_phone_number"></strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="update_dob" class="col-md-4 col-form-label text-md-right">
                            {{ __('Date of birth') }}
                        </label>

                        <div class="col-md-6">
                            <input id="update_dob" type="text" class="form-control" name="dob" value="{{ $user->dob }}">

                            <span class="invalid-feedback">
                                <strong id="error_dob"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{ __('Close') }}
                    </button>
                    <button type="submit" class="btn btn-primary" id="update_profile_form_submit">
                        {{ __('Save changes') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $('#update_dob').datepicker({
        format: "yyyy/mm/dd"
    });

    $('#update_profile_form').on('submit', function(event) {
        var csrf_token = $('#update_profile_form input[name="_token"]').val();
        var username = $('#update_username').val();
        var full_name = $('#update_full_name').val();
        var phone_number = $('#update_phone_number').val();
        var dob = $('#update_dob').val();
        
        var profile_data = {
            _token: csrf_token,
            username: username,
            full_name: full_name,
            phone_number: phone_number,
            dob: dob
        }

        $.ajax({
            url : "{{ route('user.update', $user->id) }}",
            type : "PUT",
            dataType:"json",
            data : profile_data
        }).always(function(result) {
            $('#update_profile_form .form-control').removeClass('is-invalid');
            $('.invalid-feedback strong').text('');
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

                $('#update_profile_modal').modal('hide');
            }
        }).fail(function(result) {
            let messages = result.responseJSON.message;
            Object.keys(messages).forEach(function(object){
                $(`#update_${object}`).addClass('is-invalid');
                $(`#error_${object}`).text(messages[object][0]);
            });
        });

        event.preventDefault(); 
    });
</script>
