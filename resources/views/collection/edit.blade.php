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
                        <h6 class="m-0 font-weight-bold text-primary">Edit</h6>
                    </div>
                    <div class="card-body">
                        <form action="/books/{{ $book->id }}" method="POST">
                            @method('put')
                            @csrf
                            <input name="id" id="inputID" type="text"
                                class="form-control bg-light border-0 small mb-2" value="{{ old('id', $book->id) }}" hidden>
                            <div class="form-group">
                                <label for="inputTitle">Judul<span class="text-danger">*</span></label>
                                <input name="title" id="inputTitle" type="text"
                                    class="form-control bg-light border-0 small mb-2 @error('title') is-invalid @enderror"
                                    placeholder="Masukan judul buku" value="{{ old('title', $book->title) }}">
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('title') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="inputAuthor">Penulis</label>
                                    <input name="author" id="inputAuthor" type="text"
                                        class="form-control bg-light border-0 small mb-2 @error('author') is-invalid @enderror"
                                        placeholder="Masukan penulis buku" value="{{ old('author', $book->author) }}">
                                    @error('author')
                                        <div class="invalid-feedback">
                                            {{ $errors->first('author') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPublisher">Penerbit</label>
                                    <input name="publisher" id="inputPublisher" type="text"
                                        class="form-control bg-light border-0 small mb-2 @error('publisher') is-invalid @enderror"
                                        placeholder="Masukan penerbit buku"
                                        value="{{ old('publisher', $book->publisher) }}">
                                    @error('publisher')
                                        <div class="invalid-feedback">
                                            {{ $errors->first('publisher') }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="inputCategory" class="form-label">Kategori<span
                                            class="text-danger">*</span></label>
                                    <select name="category" id="inputCategory"
                                        class="form-select custom-select item-select bg-light border-0 bigh mb-2 @error('category') is-invalid @enderror">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $book->category_id === $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">
                                            {{ $errors->first('category') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputYear">Tahun terbit</label>
                                    <input name="year" id="inputYear" type="number"
                                        class="form-control bg-light border-0 small mb-2 @error('year') is-invalid @enderror"
                                        placeholder="Masukan tahun" value="{{ old('year', $book->published_at) }}">
                                    @error('year')
                                        <div class="invalid-feedback">
                                            {{ $errors->first('year') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputISBN">ISBN<span class="text-danger">*</span></label>
                                    <input name="isbn" id="inputISBN" type="text"
                                        class="form-control bg-light border-0 small mb-2 @error('isbn') is-invalid @enderror"
                                        placeholder="Masukan ISBN buku" value="{{ old('isbn', $book->ISBN) }}">
                                    @error('isbn')
                                        <div class="invalid-feedback">
                                            {{ $errors->first('isbn') }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputDesc">Deskripsi</label>
                                <textarea name="description" class="form-control bg-light border-0 small mb-2" id="inputAddress" rows="4"
                                    placeholder="Masukan deskripsi buku">{{ old('description', $book->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('description') }}
                                    </div>
                                @enderror
                            </div>
                            <br>
                            <small><span class="text-danger">*</span> Pastikan semua telah terisi</small>
                            <hr>
                            <button type="submit" class="btn btn-primary float-right">
                                Selesai
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
    <script src={{ asset('vendor/datatables/jquery.dataTables.min.js') }}></script>
    <script src={{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Page level custom scripts -->
    <script src={{ asset('js/demo/datatables-demo.js') }}></script>
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

        @if (old('category'))
            {
                $("#inputCategory").val("{{ old('category') }}");
            }
        @endif
    </script>
@endsection
