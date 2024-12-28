<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Perpustakaan SMK YPKK 1 Sleman</title>

    <!-- Fonts -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <!-- Styles -->

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body class="bg-picture-bw">
    <div class="container">

        <!-- Outer Row -->
        <div class="row">

            <div class="col-xl-10 col-lg-12 col-md-9 mx-auto">

                <div class="card rounded o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 bg-cover d-flex justify-content-center text-center p-4">
                                <img src="{{ asset('img/favicon.png') }}" alt="SMK YPKK 1 Sleman" style="width: 48px, height:48px">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <h1 class="h4 text-gray-900">Selamat Datang!</h1>
                                        <div class="text-dark">Di Perpustakaan SMK YPKK 1 Sleman</div>
                                    </div>
                                    <br><br>
                                    @if (Route::has('login'))
                                        @auth
                                            <div class="text">Anda sudah berhasi masuk!</div>
                                            <form class="user">
                                                <a href="{{ url('/home') }}" class="btn btn-primary btn-user btn-block">
                                                    <i class="fas fa-home mr-2"></i>
                                                    <span class="text">Kembali ke halaman utama</span>
                                                </a>
                                            </form>
                                        @else
                                            <form class="user">
                                                <a href="{{ route('login') }}" class="btn btn-primary btn-user btn-block">
                                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                                    <span class="text">Masuk</span>
                                                </a>
                                            </form>
                                            {{-- @if (Route::has('register'))
                                                <form class="user mt-3">
                                                    <a href="{{ route('register') }}"
                                                        class="btn btn-light btn-user btn-block">
                                                        <i class="fas fa-user-plus mr-2"></i>
                                                        <span class="text">Daftar</span>
                                                    </a>
                                                </form>
                                            @endif --}}
                                        @endauth
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>
</body>

</html>
