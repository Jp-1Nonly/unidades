<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Forgot Password | PH - Admin</title>
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
                            <h4 class="text-white text-center mb-0">Forgot Password</h4>
                        </div>
                        <div class="card-body p-4 mt-2">
                            <div class="mb-4 text-sm text-gray-600">
                                {{ __('¿Olvidó su contraseña? Háganos saber su dirección de correo electrónico y le enviaremos un enlace para restablecerla.') }}
                            </div>

                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <!-- Email Address -->
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">{{ __('Correo') }}</label>
                                    <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus placeholder="Correo electrónico" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div class="form-group text-center mt-4">
                                    <button type="submit" class="btn btn-primary waves-effect width-md waves-light">
                                        {{ __('Enviar Link') }}
                                    </button>
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
