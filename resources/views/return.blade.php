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
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="returnTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No. Inventaris</th>
                                <th>Nama Peminjam</th>
                                <th>Buku</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Batas Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $transaction->item->inv_id }}</td>
                                    <td>{{ $transaction->user->name ?? 'User not found' }}</td>
                                    <td>{{ $transaction->item->book->title ?? 'User not found' }}</td>
                                    <td>{{ date_format($transaction->created_at, 'd-m-Y') }}</td>
                                    <td>{{ date('d-m-Y', strtotime($transaction->due_date)) }}</td>
                                    <td>
                                        <button type="button"
                                            class="btn {{ strtotime($transaction->due_date) > strtotime('now') ? 'btn-success' : 'btn-warning' }} btn-icon-split btn-open-modal"
                                            data-id="{{ $transaction->id }}" data-due="{{ $transaction->due_date }}">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span class="text">Selesai</span>
                                        </button>
                                        <button type="button" class="btn btn-light btn-icon-split btn-extend"
                                            data-id="{{ $transaction->id }}" data-due="{{ $transaction->due_date }}">
                                            <span class="icon text-gray-600">
                                                <i class="fas fa-calendar-plus"></i>
                                            </span>
                                        </button>
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

    <!-- Modal -->
    <div class="modal fade" id="modalReturn" tabindex="-1" role="dialog" aria-labelledby="modalReturnTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Pengembalian Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="detail" class="mb-4">
                    </div>
                    <div id="fee">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <form id="returnform" action="" method="POST" class="d-inline">
                        @method('post')
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <span class="text">Kembalikan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalExtend" tabindex="-1" role="dialog" aria-labelledby="modalExtendTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="extendform" action="" method="POST" class="d-inline">
                    @method('post')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Perpanjang Peminjaman</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input name="old_date" id="inputOldDate" type="date"
                            class="form-control bg-light border-0 small mb-2" hidden>
                        <div class="form-group mb-2">
                            <label for="inputDate">Batas Waktu<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span id="extend-date-info" class="input-group-text border-0">0 Hari</span>
                                </div>
                                <input name="date" id="inputDate" type="date"
                                    class="form-control bg-light border-0 small  @error('date') is-invalid @enderror"
                                    placeholder="Masukan tanggal" onchange="changeDueDate()">
                                @error('date')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('date') }}
                                    </div>
                                @enderror
                            </div>
                            <small id="extend-info" class="text-muted">
                                Perpanjang masa peminjaman.
                            </small>
                        </div>
                        <small><span class="text-danger">*</span> Pastikan telah terisi</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="text">Perpanjang</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('custom_script')
    <!-- Page level plugins -->
    <script src={{ asset('vendor/datatables/jquery.dataTables.min.js') }}></script>
    <script src={{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Page level custom scripts -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var dueState;

        $(document).on('click', '.btn-open-modal', function() {
            var dueDate = new Date($(this).data('due')); // the date that the task is due
            var today = new Date(); // the current date
            var textElement = document.getElementById("detail"); // select the element with id
            var textFee = document.getElementById("fee");
            var txid = $(this).data('id');
            document.getElementById("returnform").action = `/return/${txid}`;

            if (today > dueDate) {
                // the due date has passed
                var diff = today - dueDate;
                var days = Math.floor(diff / 86400000);
                var fee = days * {{ $fee }};

                textElement.innerHTML = `Buku dikembalikan dengan terlambat selama <strong>${days}</strong> hari.`;
                textFee.innerHTML = `Denda : <strong class="text-danger">Rp.${fee},-</strong>`;
                $('#modalReturn').modal('show');
            } else {
                // the due date has not yet passed
                textElement.innerHTML = "Buku dikembalikan dengan tepat waktu.";
                textFee.innerHTML = "";
                $('#modalReturn').modal('show');
            }
        });

        $(document).on('click', '.btn-extend', function() {
            var txid = $(this).data('id');
            dueState = $(this).data('due');
            document.getElementById("inputOldDate").value = dueState;
            document.getElementById("inputDate").value = dueState;
            document.getElementById("extendform").action = `/extend/${txid}`;
            $('#modalExtend').modal('show');
        });

        function changeDueDate() {
            var date = document.getElementById("inputDate").value;
            let oldDate = new Date(dueState);
            let newDate = new Date(date);
            let Difference_In_Time =
                newDate.getTime() - oldDate.getTime();
            let Difference_In_Days =
                Math.round(Difference_In_Time / (1000 * 3600 * 24));

            document.getElementById("extend-info").innerHTML = "Diperpanjang selama <strong>" + Difference_In_Days +
                "</strong> hari.";

            document.getElementById("extend-date-info").innerHTML = Difference_In_Days +
                " Hari";
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#returnTable').DataTable({
                order: [],
                columns: [{
                    width: '5%'
                }, null, null, null, null, null, {
                    width: '200px'
                }]
            });
        });
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
