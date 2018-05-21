<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" 
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#" data-toggle="modal" 
                                        data-target="#update_profile_modal">
                                        {{ __('Update profile') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                            <form method="POST" id="update_profile_form" action="{{ route('user.update', Auth::id()) }}">
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
                                                        <input id="update_email" type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="update_username" class="col-md-4 col-form-label text-md-right">
                                                        {{ __('Username') }}
                                                    </label>

                                                    <div class="col-md-6">
                                                        <input id="update_username" type="text" class="form-control" name="username" value="{{ Auth::user()->username }}" required>

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
                                                        <input id="update_full_name" type="text" class="form-control" name="full_name" value="{{ Auth::user()->full_name }}">

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
                                                        <input id="update_phone_number" type="number" class="form-control" name="phone_number" value="{{ Auth::user()->phone_number }}">

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
                                                        <input id="update_dob" type="text" class="form-control" name="dob" value="{{ Auth::user()->dob }}">

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
                                        url : "{{ route('user.update', Auth::id()) }}",
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
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
