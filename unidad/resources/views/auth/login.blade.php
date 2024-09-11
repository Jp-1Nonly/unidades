<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>login | PH - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-stylesheet" />
</head>

<body class="authentication-page">

    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">
                        <div class="card-header bg-img p-5 position-relative">
                            <div class="bg-overlay"></div>
                            <h4 class="text-white text-center mb-0">PH ADMIN - En prueba</h4>
                        </div>
                        <div class="card-body p-4 mt-2">
                            <form method="POST" action="{{ route('login') }}" class="p-3">
                                @csrf

                                <!-- Email Address -->
                                <div class="form-group mb-3">
                                    <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus placeholder="Correo electrónico" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div class="form-group mb-3">
                                    <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Contraseña" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Remember Me -->
                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input id="remember_me" type="checkbox" class="custom-control-input" name="remember">
                                        <label class="custom-control-label" for="remember_me">Recordarme</label>
                                    </div>
                                </div>

                                <div class="form-group text-center mt-5 mb-4">
                                    <button type="submit" class="btn btn-primary waves-effect width-md waves-light">
                                        {{ __('Log In') }}
                                    </button>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-sm-7">
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}">
                                                <i class="fa fa-lock mr-1"></i> Olvidó su contraseña?
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-sm-5 text-right">
                                        <a href="{{ route('register') }}">Crear cuenta</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>

    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

</body>

</html>
