@extends('layouts.main')

@section('custom_style')
    <!-- Custom styles for this template-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
@endsection

@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
        <p class="mb-4">{{ $desc }}</p>

        <div class="row">

            <div class="col-lg-4">
                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Formulir Peminjaman</h6>
                    </div>
                    <div class="card-body">
                        <form action="/transaction" method="POST">
                            @method('post')
                            @csrf
                            {{-- <div class="col-md-12">
                                <input name="bookID" id="inputBookID" type="text"
                                    class="form-control bg-light border-0 small mb-2" aria-label="Search"
                                    aria-describedby="basic-addon2" hidden>
                            </div> --}}
                            <div class="form-group mb-4">
                                <label for="inputBookID">Buku<span class="text-danger">*</span></label>
                                <select class="custom-select item-select select2 @error('bookID') is-invalid @enderror"
                                    id="inputBookID" name="bookID" style="width: 100%; height: 20px">
                                    <option value="" selected disabled>Pilih Buku...</option>
                                    @foreach ($book_items as $item)
                                        <option value={{ $item->id }}> ID:{{ $item->inv_id }} -
                                            ISBN:{{ $item->book->ISBN }} - {{ $item->book->title }} </option>
                                    @endforeach
                                </select>
                                @error('bookID')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('bookID') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="inputMemberID">Peminjam<span class="text-danger">*</span></label>
                                <select class="custom-select item-select select2 @error('memberID') is-invalid @enderror"
                                    id="inputMemberID" name="memberID" style="width: 100%; height: 20px">
                                    <option value="" selected disabled>Pilih Peminjam...</option>
                                    @foreach ($students as $student)
                                        <option value={{ $student->super->id }}> {{ $student->nisn }} -
                                            {{ $student->name }}
                                            - {{ $student->classroom->name }} </option>
                                    @endforeach
                                </select>
                                @error('memberID')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('memberID') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="inputDate">Batas Waktu<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span id="due-day-info" class="input-group-text">{{ $due_date }} Hari</span>
                                    </div>
                                    <input name="date" id="inputDate" type="date"
                                        class="form-control @error('date') is-invalid @enderror"
                                        placeholder="Masukan tanggal"
                                        value="{{ date('Y-m-d', strtotime(date('Y-m-d') . ' + ' . $due_date . ' days')) }}"
                                        onchange="onDueDateChange();">
                                    @error('date')
                                        <div class="invalid-feedback">
                                            {{ $errors->first('date') }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <small><span class="text-danger">*</span> Pastikan semua telah terisi</small>
                            <hr>
                            <button type="submit" class="btn btn-primary btn-icon-split float-right">
                                <span class="icon text-white-50">
                                    <i class="fas fa-cart-arrow-down"></i>
                                </span>
                                <span class="text">Pinjam</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">

                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Buku</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="height: 540px;">
                            <table class="table table-bordered" id="bookTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Judul</th>
                                        <th>Penulis</th>
                                        <th>Penerbit</th>
                                        <th>Tahun</th>
                                        <th>ISBN</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach ($allbooks as $book)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $book->title }}</td>
                                            <td>{{ $book->author }}</td>
                                            <td>{{ $book->publisher }}</td>
                                            <td>{{ $book->published_at }}</td>
                                            <td>{{ $book->ISBN }}</td>
                                            <td>
                                                @if ($book->item->isNotEmpty())
                                                    <div class="btn-group dropleft">
                                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <span class="icon">
                                                                <i class="fas fa-shopping-basket"></i>
                                                            </span>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <label class="ml-4">Pilih item buku:</label>
                                                            <hr class="mb-2 mt-0">
                                                            @foreach ($book_items->where('book_id', $book->id) as $item)
                                                                <a class="dropdown-item btn-add-item" href="#"
                                                                    data-id="{{ $item->id }}">ID:{{ $item->inv_id }}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="btn-group dropleft">
                                                        <button type="button" class="btn btn-dark dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" disabled>
                                                            <span class="icon">
                                                                <i class="fas fa-shopping-basket"></i>
                                                            </span>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                        </div>
                                                    </div>
                                                    {{-- <button href="#" class="btn btn-light btn-icon-split btn-waitlist"
                                                        disabled>
                                                        <span class="icon text-gray-600">
                                                            <i class="fas fa-list"></i>
                                                        </span>
                                                    </button> --}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Transaksi terakhir</h6>
            </div>
            <div class="card-body">
                <div class="mb-4">Daftar 5 transaksi terakhir</div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="recentTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">No. Inventaris</th>
                                <th scope="col">Nama Peminjam</th>
                                <th scope="col">Buku</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->item->inv_id ?? 'Nomor tidak ditemukan' }}</td>
                                    <td>{{ $transaction->user->name ?? 'Pengguna tidak ditemukan' }}</td>
                                    <td>{{ $transaction->item->book->title ?? 'Buku tidak ditemukan' }}</td>
                                    <td>{{ date_format($transaction->created_at, 'd-m-Y') }}</td>
                                    <td>{{ date_format($transaction->created_at, 'H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    <!-- Modal -->
    <div class="modal fade" id="modalWaitlist" tabindex="-1" role="dialog" aria-labelledby="modalWaitlistTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Waitlist</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="extendform" action="/waiting" method="POST" class="d-inline">
                    @method('post')
                    @csrf
                    <div class="modal-body">
                        <div class="mb-4 subtitle-wait">
                            Add to waiting list
                        </div>
                        <div class="col-md-12">
                            <input name="bookID" id="inputIdWait" type="text"
                                class="form-control bg-light border-0 small mb-2" aria-label="Search"
                                aria-describedby="basic-addon2" value="" hidden>
                        </div>
                        <div class="input-group col-md-12">
                            <input name="memberID" id="inputMemberIDWait" type="text"
                                class="form-control bg-light border-0 small mb-2" placeholder="Member ID"
                                aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                {{-- <button href="#" class="btn btn-primary border-0 small mb-2 btn-searchid" type="button">Search</button> --}}
                                <a href="#" id='searchIDBtnWait'
                                    class="btn btn-primary border-0 small mb-2 btn-searchidwait">
                                    Search
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input name="name" id="inputNameWait" type="text"
                                class="form-control bg-light border-0 small mb-2" aria-label="Search"
                                aria-describedby="basic-addon2" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="text">Add</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous" ;></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            // toastr.success('Have fun storming the castle!', 'Miracle Max Says');

            @if (old('bookID'))
                {
                    $("#inputBookID").select2().val("{{ old('bookID') }}").trigger("change");
                }
            @endif

            @if (old('memberID'))
                {
                    $("#inputMemberID").select2().val("{{ old('memberID') }}").trigger("change");
                }
            @endif

            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });

        $(".btn-add-item").click(function() {
            var id = $(this).data('id');
            $("#inputBookID").select2().val(id).trigger("change");
        });

        // $(document).on('click', '.btn-waitlist', function() {
        //     var id = $(this).data('id');
        //     var title = $(this).data('title');
        //     console.log(title);
        //     document.getElementById("inputIdWait").value = id;
        //     $('.subtitle-wait').append(`<br>Book: <strong>${title}<strong>`);
        //     $('#modalWaitlist').modal('show');
        // });

        $(document).ready(function() {
            $(".btn-searchid").click(function() {
                // console.log('cek');
                var id = $('#inputMemberID').val();
                fetchRecords(id);
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function fetchRecords(id) {
                $.ajax({
                    url: 'search/' + id,
                    type: 'get',
                    data: {},
                    dataType: 'json',
                    success: function(response) {
                        var result = response['name'];
                        $("#inputName").val(result);
                    },
                    error: function(e) {
                        console.log(e);
                        $("#inputName").val('user not found');
                    }
                });
            }
        });

        $(document).ready(function() {
            $(".btn-searchidwait").click(function() {
                // console.log('cek');
                var id = $('#inputMemberIDWait').val();
                fetchRecords(id);
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function fetchRecords(id) {
                $.ajax({
                    url: 'search/' + id,
                    type: 'get',
                    data: {},
                    dataType: 'json',
                    success: function(response) {
                        var result = response['name'];
                        $("#inputNameWait").val(result);
                    },
                    error: function(e) {
                        console.log(e);
                        $("#inputNameWait").val('user not found');
                    }
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#bookTable').DataTable({
                searching: true,
                paging: true,
                info: false,
                scrollCollapse: true,
                scrollY: '300px',
                columns: [{
                    width: '5%'
                }, null, null, null, null, null, {
                    width: '80px'
                }]
            });
            $('#recentTable').DataTable({
                searching: false,
                paging: false,
                info: false,
                order: []
            });
        });
    </script>

    <script>
        function onDueDateChange() {
            var selectedDate = new Date($("#inputDate").val());
            var currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0);

            let time_difference = selectedDate.getTime() - currentDate.getTime()

            let days_difference = Math.round(
                time_difference / (1000 * 60 * 60 * 24)
            )
            $("#due-day-info").html(days_difference + " Hari");
        }
    </script>

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
                // toastr.info("{{ Session::get('errors')->getBag('default')->first('bookID') }}");
            }
        @endif
    </script>
@endsection

@section('custom_script')
    <!-- Page level plugins -->
    <script src={{ asset('vendor/datatables/jquery.dataTables.min.js') }}></script>
    <script src={{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}></script>
    <!-- Page level custom scripts -->
@endsection

{{-- @section('script')

@endsection --}}
