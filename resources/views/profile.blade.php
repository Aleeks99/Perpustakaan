@extends('layouts.main')

@section('custom_style')
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
@endsection

@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <p class="mb-4">{{ $desc }}</p>

        <div class="row">

            <div class="col-lg-4">

                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Profil Pengguna</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="text-center">
                            <img class="img-profile rounded-circle mt-3 mb-5"
                    src="img/undraw_profile.svg" style="width: 140px">
                        </div>
                        <div class="text-center mb-4">
                            <strong>{{ Auth::user()->name }}</strong>
                            <br>{{ Auth::user()->email }}
                            <br>{{ Auth::user()->getRoleNames()->first() }}
                        </div>
                        
                    </div>
                </div>

                @hasrole('librarian')
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Peminjaman</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $borrow }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-suitcase fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Pengembalian</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $return }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-undo fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endhasrole
                

            </div>

            <div class="col-lg-8">

                <!-- Basic Card Example -->
                <div class="card shadow mb-4 h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Pengguna</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="inputName">Nama</label>
                                <input id="inputName" type="text" class="form-control bg-light border-0 small mb-4"
                                    aria-label="Search" aria-describedby="basic-addon2" value="{{ Auth::user()->name }}" disabled>
                                <label for="inputName">Email</label>
                                <input id="inputName" type="text" class="form-control bg-light border-0 small mb-4"
                                    aria-label="Search" aria-describedby="basic-addon2" value="{{ Auth::user()->email }}" disabled>
                                <label for="inputName">Alamat</label>
                                <input id="inputName" type="text" class="form-control bg-light border-0 small mb-4"
                                        aria-label="Search" aria-describedby="basic-addon2" value="{{ Auth::user()->address }}" disabled>
                            </div>
                            <div class="col-lg-6">
                                <label for="inputName">Posisi</label>
                                <input id="inputName" type="text" class="form-control bg-light border-0 small mb-4"
                                    aria-label="Search" aria-describedby="basic-addon2" value="{{ Auth::user()->getRoleNames()->first() }}" disabled>
                                <label for="inputName">Jenis Kelamin</label>
                                <input id="inputName" type="text" class="form-control bg-light border-0 small mb-4"
                                    aria-label="Search" aria-describedby="basic-addon2" value="{{ Auth::user()->gender }}" disabled>
                                <label for="inputName">Ponsel</label>
                                <input id="inputName" type="text" class="form-control bg-light border-0 small mb-4"
                                        aria-label="Search" aria-describedby="basic-addon2" value="{{ Auth::user()->phone }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- /.container-fluid -->
@endsection