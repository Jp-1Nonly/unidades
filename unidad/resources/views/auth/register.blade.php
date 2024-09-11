<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Register | PH - Admin</title>
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
                            <h4 class="text-white text-center mb-0">Register</h4>
                        </div>
                        <div class="card-body p-4 mt-2">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <!-- Name -->
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                    <input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Email Address -->
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Email Address" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group mb-3">
                                    <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <div class="form-group text-center mt-4">
                                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                                        {{ __('Already registered?') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary waves-effect width-md waves-light mt-3">
                                        {{ __('Register') }}
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
