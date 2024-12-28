@extends('layouts.main')

@section('custom_style')
    <!-- Custom styles for this template -->
    <link href={{ asset('css/sb-admin-2.min.css') }} rel="stylesheet">
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
            <div class="col-lg-4">

                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Profil Pengguna</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="text-center">
                            <img class="img-profile rounded-circle mt-3 mb-5" src="{{ asset('img/undraw_profile.svg') }}"
                                style="width: 140px">
                        </div>
                        <div class="text-center mb-4">
                            <strong>{{ $student->name }}</strong>
                            <br>{{ $student->email }}
                            <br>{{ $student->classroom->name }}
                        </div>
                        <hr>
                        @role('admin')
                            <form action="/member/{{ $student->id }}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger btn-icon-split float-right"
                                    onclick="return confirm('Are you sure?')">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash-alt"></i>
                                    </span>
                                    <span class="text">Hapus</span>
                                </button>
                            </form>
                            <a href="/member/{{ $student->id }}/edit" class="btn btn-light btn-icon-split float-right mr-2">
                                <span class="icon text-gray-600">
                                    <i class="fas fa-edit"></i>
                                </span>
                                <span class="text text-gray-600">Edit</span>
                            </a>
                        @endrole
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                @role('admin')
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                Sedang Meminjam</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $transactions->where('detail', 'borrow')->count() }}</div>
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
                @endrole
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Peminjaman Berlangsung</h6>
                    </div>
                    <div class="card-body">
                        @if ($transactions->where('detail', 'borrow')->count() != 0)
                            <table class="table table-bordered" id="borrowedTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>No. Inventaris</th>
                                        <th>Buku</th>
                                        <th>Tanggal Peminjaman</th>
                                        <th>Batas Waktu</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach ($transactions->where('detail', 'borrow') as $transaction)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $transaction->item->inv_id }}</td>
                                            <td>{{ $transaction->item->book->title }}</td>
                                            <td>{{ date('d-m-Y', strtotime($transaction->created_at)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($transaction->due_date)) }}</td>
                                            <td class={{ (strtotime($transaction->due_date) > strtotime('now')) ? 'text-primary' : 'text-danger' }}>{{ (strtotime($transaction->due_date) > strtotime('now')) ? 'Berlangsung' : 'Terlambat' }}</td>
                                            {{-- <td>
                                        <a href="/member/{{ $user->id }}" class="btn btn-primary btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </a>
                                    </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center">Tidak ada buku yang sedang dipinjam</div>
                        @endif

                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Riwayat Peminjaman</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="historyTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No. Inventaris</th>
                                    <th>Buku</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $transaction->item->inv_id }}</td>
                                        <td>{{ $transaction->item->book->title }}</td>
                                        <td>{{ date('d-m-Y', strtotime($transaction->created_at)) }}</td>
                                        <td>{{ $transaction->detail === 'borrow' ? 'Sedang dipinjam' : 'Telah dikembalikan' }}
                                        </td>
                                        {{-- <td>
                                        <a href="/member/{{ $user->id }}" class="btn btn-primary btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </a>
                                    </td> --}}
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@section('custom_script')
    <!-- Page level plugins -->
    <script src={{ asset('vendor/datatables/jquery.dataTables.min.js') }}></script>
    <script src={{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Page level custom scripts -->
    {{-- <script src={{ asset('js/demo/datatables-demo.js') }}></script> --}}
    <script>
        $(document).ready(function() {
            $('#borrowedTable').DataTable({
                searching: false,
                paging: false,
                info: false,
                order: [],
                columns: [{
                    width: 5 %
                }, null, null, null, null, null]
            });
        });
        $(document).ready(function() {
            $('#historyTable').DataTable({
                searching: true,
                paging: true,
                info: false,
                order: [],
                columns: [{
                    width: 5 %
                }, null, null, null, null]
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
