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

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <h6 class="m-0 font-weight-bold text-primary">Waitlist</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($waitings as $waiting)
                        <tr>
                            <td>{{ $books->find($waiting->book_id)->title ?? 'User not found' }}</td>
                            <td>{{ $users->find($waiting->user_id)->name ?? 'User not found' }}</td>
                            <th>{{ date_format($waiting->created_at,"Y-m-d") }}</th>
                            <td>
                                <button type="button" class="btn btn-primary btn-add" data-bookid="{{ $waiting->book_id }}" data-memberid="{{ $waiting->user_id }}">
                                    <span class="icon text-white-50">
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
<div class="modal fade" id="modalBorrow" tabindex="-1" role="dialog" aria-labelledby="modalBorrowTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Borrow</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="transactionform" action="/transaction" method="POST" class="d-inline">
        @method('post')
        @csrf
        <div class="modal-body">
            <div>
                Add new borrowing
            </div>
            <div class="col-md-12">
                <input name="bookID" id="inputBookID" type="text" class="form-control bg-light border-0 small mb-2" aria-label="Search" aria-describedby="basic-addon2" readonly>
            </div>
            <div class="col-md-12">
                <input name="memberID" id="#inputMemberID" type="text" class="form-control bg-light border-0 small mb-2" aria-label="Search" aria-describedby="basic-addon2" readonly>
            </div>
            <div class="col-md-12">
                <input name="bookID" id="inputBookID" type="text" class="form-control bg-light border-0 small mb-2" aria-label="Search" aria-describedby="basic-addon2" value="none" hidden>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">
                <span class="text">Submit</span>
            </button>
        </div>
        </form>
      </div>
    </div>
</div>
@endsection

@section('custom_script')
    <!-- Page level plugins -->
    <script src={{ asset("vendor/datatables/jquery.dataTables.min.js") }}></script>
    <script src={{ asset("vendor/datatables/dataTables.bootstrap4.min.js") }}></script>
    <!-- Page level custom scripts -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>    
        $(document).on('click','.btn-add',function(){
                var book = $(this).data('bookid');
                var member = $(this).data('memberid');
                $('#inputBookID').val(book);
                $('#inputMemberID').val(book);
                $('#modalBorrow').modal('show');
        });
    </script>
    <script>
        // $(document).ready(function() {
        //     $('#dataTable').DataTable({
        //         order: [[4, 'asc']]
        //     });
        // });
    </script>
@endsection