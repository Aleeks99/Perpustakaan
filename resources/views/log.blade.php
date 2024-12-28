@extends('layouts.main')

@section('custom_style')
    <!-- Custom styles for this template -->
    <link href={{ asset('css/sb-admin-2.min.css') }} rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"> --}}
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
                <h6 class="m-0 font-weight-bold text-primary">Daftar Riwayat Transaksi</h6>
            </div>
            <div class="card-body">
                @role('admin')
                    <div class="float-right ml-4">
                        <button type="button" class="btn btn-success btn-icon-split" onclick="exportPDF();">
                            <span class="icon text-white-50">
                                <i class="fas fa-file-export"></i>
                            </span>
                            <span class="text">Ekspor</span>
                        </button>
                    </div>
                    <div class="float-right">
                        <form action="/log" method="get">
                            @method('get')
                            @csrf
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span id="due-day-info" class="input-group-text border-0"><i
                                            class="fas fa-filter text-gray-600"></i></span>
                                </div>
                                <select name="filter" id="inputFilter"
                                    class="form-select custom-select item-select bg-light border-0 bigh @error('classroom') is-invalid @enderror"
                                    onchange="filterChange();">
                                    <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Semua</option>
                                    <option value="today" {{ $filter === 'today' ? 'selected' : '' }}>Hari ini</option>
                                    <option value="this_month" {{ $filter === 'this_month' ? 'selected' : '' }}>Bulan ini
                                    </option>
                                </select>
                            </div>
                            <button id="refreshButton" type="submit" class="btn btn-primary btn-icon-split" hidden></button>
                        </form>
                    </div>
                @endrole

                <div class="table-responsive">
                    <table class="table table-bordered" id="logTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Peminjam</th>
                                <th>No. Inventaris</th>
                                <th>Buku</th>
                                <th>Tanggal dan Waktu</th>
                                <th hidden>Keterangan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $transaction->user->name ?? 'User not found' }}</td>
                                    <td>{{ $transaction->item->inv_id ?? 'Book not found' }}</td>
                                    <td>{{ $transaction->item->book->title ?? 'Book not found' }}</td>
                                    <td>{{ date('d-m-Y / h:i:s', strtotime($transaction->date_time)) }}</td>
                                    <td hidden>
                                        {{ $transaction->detail === 'borrow' ? 'Pinjam' : ($transaction->detail === 'return' ? 'Kembali' : '') }}
                                    </td>
                                    <td><strong
                                            class={{ $transaction->detail === 'borrow' ? 'text-primary' : 'text-success' }}>{{ $transaction->detail === 'borrow' ? 'Pinjam' : ($transaction->detail === 'return' ? 'Kembali' : '') }}</strong>
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
    <script src={{ asset('vendor/datatables/jquery.dataTables.min.js') }}></script>
    <script src={{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.10/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.10/vfs_fonts.js"></script>

    <!-- Page level custom scripts -->

    <script>
        let table;
        var refreshButton = document.getElementById("refreshButton");

        $(document).ready(function() {
            table = $('#logTable').DataTable({
                order: [],
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
    </script>

    <script>
        function filterChange() {
            var refreshButton = document.getElementById("refreshButton");
            refreshButton.click();
        }
    </script>

    <script>
        function exportPDF() {
            var data = table.rows().data();
            filterData(data);
            var docDefinition = {
                content: [{
                    text: 'Laporan Riwayat Transaksi\n\n',
                    style: {
                        fontSize: 15,
                        bold: true,
                        alignment: 'center'
                    }
                }, {
                    text: "Jenis Laporan: {{ $filter == 'all' ? 'Keseluruhan' : '' }}{{ $filter == 'today' ? 'Harian (' . date('d-m-Y') . ')' : '' }}{{ $filter == 'this_month' ? 'Bulanan (' . date('m-Y') . ')' : '' }}",
                    style: {
                        fontSize: 12,
                        alignment: 'left'
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
                        widths: ['auto', 'auto', 'auto', 'auto', 'auto', 'auto'],
                        body: data
                    }
                }],
                defaultStyle: {
                    fontSize: 12,
                }
            };
            pdfMake.createPdf(docDefinition).print({}, window.open('', '_blank'));
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

        function filterData(data) {
            data.map(function(value) {
                value.pop();
            });
            data.unshift(['No.', 'Peminjam', 'No. Inv.', 'Buku', 'Tanggal & Waktu', 'Keterangan']);
        }
    </script>
@endsection
