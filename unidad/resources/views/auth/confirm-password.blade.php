<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Confirm Password | PH - Admin</title>
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
                            <h4 class="text-white text-center mb-0">Confirm Your Password</h4>
                        </div>
                        <div class="card-body p-4 mt-2">
                            <div class="mb-4 text-sm text-gray-600">
                                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                            </div>

                            <form method="POST" action="{{ route('password.confirm') }}">
                                @csrf

                                <!-- Password -->
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div class="form-group text-center mt-4">
                                    <button type="submit" class="btn btn-primary waves-effect width-md waves-light">
                                        {{ __('Confirm') }}
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
