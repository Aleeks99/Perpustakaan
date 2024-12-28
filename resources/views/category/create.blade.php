@extends('layouts.main')

@section('custom_style')
    <!-- Custom styles for this template -->
    <link href={{ asset("css/sb-admin-2.min.css") }} rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endsection

@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
        <p class="mb-4">{{ $desc }}</p>

        <!-- DataTales Example -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tambah</h6>
                    </div>
                    <div class="card-body">
                        <form action="/category" method="POST">
                            @method('post')
                            @csrf
                            <div class="form-group">
                                <label for="inputName">Nama<span class="text-danger">*</span></label>
                                <input name="name" id="inputName" type="text" class="form-control bg-light border-0 small mb-2 @error('name') is-invalid @enderror" placeholder="Masukan nama kategori">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @enderror
                            </div>
                            <br>
                            <small><span class="text-danger">*</span> Pastikan semua telah terisi</small>
                            <hr>
                            <button type="submit" class="btn btn-primary float-right">
                                Tambahkan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection

@section('custom_script')
    <!-- Page level plugins -->
    <script src={{ asset("vendor/datatables/jquery.dataTables.min.js") }}></script>
    <script src={{ asset("vendor/datatables/dataTables.bootstrap4.min.js") }}></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Page level custom scripts -->
    <script src={{ asset("js/demo/datatables-demo.js") }}></script>
    <script>
        toastr.options.closeButton = true;

        @if (Session::has('message'))
            {
                toastr.{{ Session::get('alert') }}("{{ Session::get('message') }}");
            }
        @endif

        @if ($errors->all())
            {
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            }
        @endif
    </script>
@endsection