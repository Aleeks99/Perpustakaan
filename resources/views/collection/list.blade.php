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
                <h6 class="m-0 font-weight-bold text-primary">Daftar Buku</h6>
            </div>
            <div class="card-body">
                @role('admin')
                <div class="float-right ml-4">
                    <div class="input-group mb-2">
                        <select name="export" id="selectExport"
                            class="form-select custom-select item-select bg-light border-0 bigh @error('classroom') is-invalid @enderror"
                            onchange="exportChange();">
                            <option value="books" selected>Buku</option>
                            <option value="items">Item Buku</option>
                            </option>
                        </select>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-success btn-icon-split" onclick="exportPDF();">
                                <span class="icon text-white-50">
                                    <i class="fas fa-file-export"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="float-right">
                    <a href="/books/create" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah</span>
                    </a>
                </div>
                @endrole

                <div class="table-responsive">
                    <table class="table table-bordered" id="booksTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Judul</th>
                                <th>ISBN</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th hidden>Ketersediaan</th>
                                <th>Ketersediaan</th>
                                @role('admin')
                                    <th>Aksi</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($books as $book)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->ISBN }}</td>
                                    <td>{{ $categories->find($book->category_id)->name ?? 'Category not found' }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td>{{ $book->publisher }}</td>
                                    <td>{{ $book->published_at }}</td>
                                    <td hidden>
                                        {{ $book->item->where('status', 'available')->count() . '/' . $book->item->count() }}
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $book->item->where('status', 'available')->count() === 0 ? 'text-danger' : '' }}">
                                            {{ $book->item->where('status', 'available')->count() . '/' . $book->item->count() }}
                                        </span>
                                    </td>
                                    @role('admin')
                                        <td>
                                            {{-- <a href="/books/{{ $book->id }}/edit" class="btn btn-light btn-icon-split">
                                        <span class="icon text-gray-600">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </a> --}}

                                            <a href="/books/{{ $book->id }}" class="btn btn-primary btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-chevron-right"></i>
                                                </span>
                                            </a>

                                            {{-- <form action="/books/{{ $book->id }}" method="POST" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </form> --}}
                                        </td>
                                    @endrole
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
    <script src={{ asset('vendor/datatables/jquery.dataTables.min.js') }}></script>
    <script src={{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.10/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.10/vfs_fonts.js"></script>

    <!-- Page level custom scripts -->
    <script src={{ asset('js/demo/datatables-demo.js') }}></script>
    <script>
        let table;
        @role('admin')
            var selectedExport = document.getElementById("selectExport").value;
        @endrole

        $(document).ready(function() {
            table = $('#booksTable').DataTable({
                order: [],
                columns: [{ width: '5%' }, null, null, null, null, null, null, null, @role('admin') null @else { width: '5%' } @endrole, @role('admin') { width: '5%' } @endrole]
            });

            pdfMake.tableLayouts = {
                defaultLayout: {
                    hLineWidth: function(i, node) {
                        return (i === 0 || i === node.table.body.length) ? 0.1 : 0.1;
                    },
                    vLineWidth: function(i, node) {
                        return (i === 0 || i === node.table.widths.length) ? 0.1 : 0.1;
                    }
                }
            };
        });

        function exportChange() {
            selectedExport = document.getElementById("selectExport").value;
        }
    </script>
    <script>
        var book_items = JSON.parse('{!! $items !!}');

        function exportPDF() {
            if (selectedExport === 'books') {
                var data = table.rows().data();
                filterBookData(data);
                var docDefinition = {
                    content: [{
                        text: 'Laporan Inventaris Buku\n\n',
                        style: {
                            fontSize: 15,
                            bold: true,
                            alignment: 'center'
                        }
                    }, {
                        text: 'Dicetak pada tanggal: ' + getTodayDate() + '\n\n',
                        style: {
                            fontSize: 12,
                            alignment: 'left'
                        }
                    }, {
                        layout: 'defaultLayout',
                        table: {
                            headerRows: 1,
                            widths: ['auto', 'auto', 'auto', 'auto', 'auto', 'auto', 'auto', 'auto'],
                            body: data
                        }
                    }],
                    defaultStyle: {
                        fontSize: 12,
                    }
                };
                pdfMake.createPdf(docDefinition).print({}, window.open('', '_blank'));
            }
            if (selectedExport === 'items') {
                var data = filterItemData(book_items);
                var docDefinition = {
                    content: [{
                        text: 'Laporan Inventaris Item Buku\n\n',
                        style: {
                            fontSize: 15,
                            bold: true,
                            alignment: 'center'
                        }
                    }, {
                        text: 'Dicetak pada tanggal: ' + getTodayDate() + '\n\n',
                        style: {
                            fontSize: 12,
                            alignment: 'left'
                        }
                    }, {
                        layout: 'defaultLayout',
                        table: {
                            headerRows: 1,
                            widths: ['auto', 'auto', 'auto', 'auto', 'auto'],
                            body: data
                        }
                    }],
                    defaultStyle: {
                        fontSize: 12,
                    }
                };
                pdfMake.createPdf(docDefinition).print({}, window.open('', '_blank'));
            }
        }
    </script>
    <script>
        function getTodayDate() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            today = dd + '/' + mm + '/' + yyyy;
            return today;
        }

        function filterBookData(data) {
            data.map(function(value) {
                value.pop();
                value.pop();
            });
            data.unshift(['No.', 'Judul', 'ISBN', 'Kategori', 'Penulis', 'Penerbit', 'Tahun', 'Ketersediaan']);
        }

        function filterItemData(data) {
            var i = 1;
            var result = Object.values(data).map(function(value) {
                var row = Object.values(value);
                row.unshift(i++);
                return Object.values(row);
            });
            result.unshift(['No.', 'No. Inventaris', 'ISBN', 'Judul Buku', 'Keterangan']);
            return result;
        }
    </script>
    <script>
        @if (Session::has('message'))
            {
                toastr.{{ Session::get('alert') }}("{{ Session::get('message') }}");
            }
        @endif
    </script>
@endsection
