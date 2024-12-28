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
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Buku</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputTitle">Judul</label>
                            <input name="title" id="inputTitle" type="text"
                                class="form-control bg-light border-0 small mb-2" value="{{ $book->title }}" disabled>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputAuthor">Penulis</label>
                                <input name="author" id="inputAuthor" type="text"
                                    class="form-control bg-light border-0 small mb-2" value="{{ $book->author }}" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPublisher">Penerbit</label>
                                <input name="publisher" id="inputPublisher" type="text"
                                    class="form-control bg-light border-0 small mb-2" value="{{ $book->publisher }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="form-group col-md-5">
                                <label for="inputCategory" class="form-label">Kategori</label>
                                <select name="category" id="inputCategory"
                                    class="form-select custom-select item-select bg-light border-0 bigh mb-2" disabled>
                                    <option selected>Choose...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $book->category_id === $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group col-md-5">
                                <label for="inputCategory">Kategori</label>
                                <input name="category" id="inputCategory"
                                    class="form-control bg-light border-0 small mb-2" value="{{ $book->category->name }}"
                                    disabled>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputYear">Tahun terbit</label>
                                <input name="year" id="inputYear" type="number"
                                    class="form-control bg-light border-0 small mb-2" value="{{ $book->published_at }}"
                                    disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputISBN">ISBN</label>
                                <input name="isbn" id="inputISBN" type="text"
                                    class="form-control bg-light border-0 small mb-2" value="{{ $book->ISBN }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDesc">Deskripsi</label>
                            <textarea name="description" class="form-control bg-light border-0 small mb-2" id="inputAddress" rows="4"
                                disabled>{{ $book->description }}</textarea>
                        </div>
                        <br>
                        <hr>
                        <form action="/books/{{ $book->id }}" method="POST" class="d-inline">
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
                        <a href="/books/{{ $book->id }}/edit" class="btn btn-light btn-icon-split float-right mr-2">
                            <span class="icon text-gray-600">
                                <i class="fas fa-edit"></i>
                            </span>
                            <span class="text text-gray-600">Edit</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Inventaris Buku</h6>
                    </div>
                    <div class="card-body">
                        <a id="btn-create-item" class="btn btn-primary btn-icon-split float-right">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah</span>
                        </a>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="itemTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>No. Inventaris</th>
                                        <th>Ketersediaan</th>
                                        @role('admin')
                                            <th>Aksi</th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1 ?>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->inv_id }}</td>
                                            <td
                                                class="font-weight-bold {{ $item->status === 'available' ? 'text-success' : 'text-danger' }}">
                                                {{ $item->status === 'available' ? 'tersedia' : 'tidak tersedia' }}</td>
                                            <td>
                                                <a href="#" class="btn btn-light btn-icon-split btn-edit-item"
                                                    data-id="{{ $item->id }}" data-inv_id="{{ $item->inv_id }}">
                                                    <span class="icon text-gray-600">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                </a>

                                                <form action="/items/{{ $item->id }}" method="POST" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn btn-danger"
                                                        onclick="return confirm('Are you sure?')">
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
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal Create Item -->
    <div class="modal fade" id="modalCreateItem" tabindex="-1" role="dialog" aria-labelledby="modalCreateItemTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Item Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="extendform" action="/items" method="POST" class="d-inline">
                    @method('post')
                    @csrf
                    <div class="modal-body">
                        <input name="id" id="inputCreateID" type="text"
                            class="form-control bg-light border-0 small mb-2" value="{{ $book->id }}" hidden>
                        <div class="form-group">
                            <label for="inputCreateItem">Nomor inventaris<span class="text-danger">*</span></label>
                            <input name="inv_number" id="inputCreateItem" type="text"
                                class="form-control bg-light border-0 small mb-2 @error('inv_number') is-invalid @enderror"
                                placeholder="Masukan nomor inventaris" value="{{ old('inv_number') }}">
                            @error('inv_number')
                                <div class="invalid-feedback">
                                    Nomor inventaris harus diisi
                                </div>
                            @enderror
                        </div>
                        <small><span class="text-danger">*</span> Wajib diisi</small>
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

    <!-- Modal Edit Item -->
    <div class="modal fade" id="modalEditItem" tabindex="-1" role="dialog" aria-labelledby="modalEditItemTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Item Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="extendform" action="/items/{{ $book->id }}" method="POST" class="d-inline">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <input name="book_id" id="inputEditID" type="text"
                            class="form-control bg-light border-0 small mb-2" value="{{ $book->id }}" hidden>
                        <input name="id" id="inputItemID" type="text"
                            class="form-control bg-light border-0 small mb-2" hidden>
                        <div class="form-group">
                            <label for="inputEditItem">Nomor inventaris<span class="text-danger">*</span></label>
                            <input name="inv_number" id="inputEditItem" type="text"
                                class="form-control bg-light border-0 small mb-2 @error('inv_number') is-invalid @enderror"
                                placeholder="Masukan nomor inventaris" value="{{ old('inv_number') }}">
                            @error('inv_number')
                                <div class="invalid-feedback">
                                    Nomor inventaris harus diisi
                                </div>
                            @enderror
                        </div>
                        <small><span class="text-danger">*</span> Wajib diisi</small>
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
    <script src={{ asset('vendor/datatables/jquery.dataTables.min.js') }}></script>
    <script src={{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Page level custom scripts -->
    <script src={{ asset('js/demo/datatables-demo.js') }}></script>
    <script>
        $(document).ready(function() {
            $('#itemTable').DataTable({
                order: [],
                columns: [{ width: '5%' }, null, null,{ width: '140px' }]
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
    <script>
        $(document).on('click', '#btn-create-item', function() {
            $('#modalCreateItem').modal('show');
        });
        $(document).on('click', '.btn-edit-item', function() {
            var id = $(this).data('id');
            var inv_id = $(this).data('inv_id');
            document.getElementById("inputItemID").value = id;
            document.getElementById("inputEditItem").value = inv_id;

            $('#modalEditItem').modal('show');
        });
    </script>
@endsection
