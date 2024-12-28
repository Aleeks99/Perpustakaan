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
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kategori</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <a href="/category/create" class="btn btn-primary btn-icon-split float-right">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah</span>
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="categoryTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1 ?>
                        @foreach ($categories as $category)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <a href="/category/{{ $category->id }}/edit" class="btn btn-light btn-icon-split">
                                    <span class="icon text-gray-600">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </a>

                                <form action="/category/{{ $category->id }}" method="POST" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
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
        $(document).ready(function() {
            $('#categoryTable').DataTable({
                order: [],
                columns: [{ width: '5%' }, null, { width: '140px' }]
            });
        });
    </script>
    <script>
        @if (Session::has('message'))
            {
                toastr.{{ Session::get('alert') }}("{{ Session::get('message') }}");
            }
        @endif
    </script>
@endsection