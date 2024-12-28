@extends('layouts.main')

@section('custom_style')
    <!-- Custom styles for this template -->
    <link href={{ asset("css/sb-admin-2.min.css") }} rel="stylesheet">
@endsection

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
    <p class="mb-4">{{ $desc }}</p>
   
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                Sedang Meminjam</div>
                                <div class="col-auto"><div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $transactions->where('detail', 'borrow')->count() }}</div></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-suitcase fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                Peminjaman</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $transactions->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hands fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                Terlambat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $returnings->where('detail', 'overdue')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                Total Denda</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $returnings->sum('fine_fee') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Buku</h6>
        </div>
        <div class="card-body">      
            <div class="table-responsive">
                <table class="table table-bordered" id="booksTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul</th>
                            <th>ISBN</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun</th>
                            <th>Kategori</th>
                            <th>Ketersediaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1 ?>
                        @foreach ($books as $book)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->ISBN }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->publisher }}</td>
                            <td>{{ $book->published_at }}</td>
                            <td>{{ $categories->find($book->category_id)->name ?? 'Category not found' }}</td>
                            <td class="font-weight-bold {{ $book->item->where('status', 'available')->count() === 0 ? 'text-danger' : '' }}">{{ $book->item->where('status', 'available')->count() . '/' . $book->item->count() }}</td>
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

    <!-- Page level custom scripts -->
    <script src={{ asset("js/demo/datatables-demo.js") }}></script>
    <script>
        $(document).ready(function() {
            table = $('#booksTable').DataTable({
                order: [],
                columns: [{ width: '5%' }, null, null, null, null, null, null, { width: '5%' }]
            });
        });
    </script>
@endsection