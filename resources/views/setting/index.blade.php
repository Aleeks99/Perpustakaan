@extends('layouts.main')

@section('custom_style')
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endsection

@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <!-- Basic Card Example -->
                <div class="card shadow mb-4 h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Peminjaman</h6>
                    </div>
                    <div class="card-body">
                        <form action="/setting/update-preferences" method="POST">
                            @method('put')
                            @csrf
                            <div class="form-group mb-4">
                                <label for="inputDueDate">Batas Peminjaman Bawaan</label>
                                <div class="input-group">
                                    <input id="inputDueDate" name="due_date" type="number"
                                        class="form-control bg-light border-0 small" aria-label="Search"
                                        aria-describedby="basic-addon2"
                                        value="{{ $settings->where('key', 'due_date')->first()->value }}" disabled>
                                    <div class="input-group-append">
                                        <span class="input-group-text border-0">Hari</span>
                                        <button onclick="showEditDueDateModal()" class="btn btn-outline-secondary"
                                            type="button"><i class="fas fa-edit"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="inputFee">Biaya Denda Per Hari</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0">Rp.</span>
                                    </div>
                                    <input id="inputFee" name="fee" type="number"
                                        class="form-control bg-light border-0 small" aria-label="Search"
                                        aria-describedby="basic-addon2"
                                        value="{{ $settings->where('key', 'fee')->first()->value }}" disabled>
                                    <div class="input-group-append">
                                        <button onclick="showEditFeeModal()" class="btn btn-outline-secondary"
                                            type="button"><i class="fas fa-edit"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal -->
    <div class="modal fade" id="modalEditDueDate" tabindex="-1" role="dialog" aria-labelledby="modalEditDueDateTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="/setting/update/{{ $settings->where('key', 'due_date')->first()->id }}" method="POST">
                    @method('put')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-4">
                            <label for="inputDueDate">Batas Peminjaman Bawaan</label>
                            <div class="input-group">
                                <input id="inputDueDate" name="setting" type="number"
                                class="form-control bg-light border-0 small" aria-label="Search"
                                aria-describedby="basic-addon2"
                                value="{{ $settings->where('key', 'due_date')->first()->value }}">
                                <div class="input-group-append">
                                    <span class="input-group-text border-0">Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="text">Selesai</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalEditFee" tabindex="-1" role="dialog" aria-labelledby="modalEditFeeDateTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="/setting/update/{{ $settings->where('key', 'fee')->first()->id }}" method="POST">
                    @method('put')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-4">
                            <label for="inputFee">Biaya Denda Per Hari</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0">Rp.</span>
                                </div>
                                <input id="inputFee" name="setting" type="number"
                                class="form-control bg-light border-0 small" aria-label="Search"
                                aria-describedby="basic-addon2"
                                value="{{ $settings->where('key', 'fee')->first()->value }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="text">Selesai</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('custom_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        function showEditDueDateModal() {
            $('#modalEditDueDate').modal('show');
        }

        function showEditFeeModal() {
            $('#modalEditFee').modal('show');
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
