<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>

<body class="bg-picture-bw">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card rounded o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 bg-cover d-flex justify-content-center text-center p-4">
                                <img src="{{ asset('img/favicon.png') }}" alt="SMK YPKK 1 Sleman" style="scale: 50%">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <h1 class="h4 text-gray-900">{{ __('Selamat Datang!') }}</h1>
                                        <div class="text-dark">{{ __('Di Perpustakaan SMK YPKK 1 Sleman') }}</div>
                                    </div>
                                    <form method="POST" class="user mb-4" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="email"
                                                class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
                                            <input id="email" type="email"
                                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" required autocomplete="email"
                                                autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="password"
                                                class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                                            <input id="password" type="password"
                                                class="form-control form-control-user @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        {{-- <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="remember">{{ __('Ingat Saya') }}</label>
                                            </div>
                                        </div> --}}
                                        <br><br>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            {{ __('Masuk') }}
                                        </button>
                                    </form>
                                    {{-- @if (Route::has('password.request'))
                                        <div class="text-center">
                                            <a class="small"
                                                href="{{ route('password.request') }}">{{ __('Lupa Password?') }}</a>
                                        </div>
                                    @endif
                                    <div class="text-center">
                                        <a class="small" href="register.html">{{ __('Buat Akun!') }}</a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
