@extends('layouts.main')

@section('custom_style')
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
@endsection

@section('container')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Peminjaman
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBorrow }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-suitcase fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Jumlah Buku (Judul)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBooks }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sedang Dipinjam
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $onBorrow }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: {{ $borrowPercentage }}%" aria-valuenow="{{ $borrowPercentage }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-luggage-cart fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Sedang Terlambat</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOverdue }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-hourglass-end fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7 mb-4">
                <div class="card shadow">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Peminjaman Bulanan</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="monthlyChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5 mb-4">
                <div class="card shadow">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Terbanyak Dipinjam (Kategori)</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="categoryChart" style="width:100%;max-width:700px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Content Column -->
            {{-- <div class="col-lg-6 mb-4">
                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Buku Teratas</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="topChart"></canvas>
                    </div>
                </div>
                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Top Book</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="toptable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th scope="col">Book</th>
                                    <th scope="col">Borrow</th>
                                    <th scope="col">Extended</th>
                                    <th scope="col">Waiting</th>
                                    <th scope="col">Overall</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topBooks as $book)
                                        <tr>
                                            <td>{{ $book->title }}</td>
                                            <td>{{ $book->count }}</td>
                                            <td>{{ $book->extended }}</td>
                                            <td>{{ $book->waiting }}</td>
                                            <td>{{ $book->count + $book->extended + $book->waiting }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="col-lg-12 mb-4">

                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Terbanyak Dipinjam (Buku)</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($books as $book)
                                        <tr>
                                            <td>{{ $book->title }}</td>
                                            <td>{{ $book->count }}</td>
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
@endsection

@section('custom_script')
    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script src={{ asset("vendor/datatables/jquery.dataTables.min.js") }}></script>
    <script src={{ asset("vendor/datatables/dataTables.bootstrap4.min.js") }}></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script> --}}
    <script type="text/javascript" src="Chart.js"></script>
    <script>
        // define the chart data

        var catName = <?php echo json_encode($catName); ?>;
        var catCount = <?php echo json_encode($catCount); ?>;
        var color = [];

        var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
        };

        for (var i in catCount) {
            color.push(dynamicColors());
        }

        var data = {
            labels: catName,
            datasets: [{
                label: 'Most Borrowed Category',
                data: catCount,
                backgroundColor: color,
                hoverOffset: 4
            }]
        };
      
        // get the canvas element
        var ctx = document.getElementById("categoryChart").getContext("2d");

        // create the chart using the Chart constructor
        var myChart = new Chart(ctx, {
          type: "doughnut", // the type of chart to create
          data: data, // the data for the chart
          options: {
          } // options for the chart
        });
    </script>
    
    <script>
        // define the chart data
        var month = <?php echo json_encode($monthlyLabel); ?>;
        var count = <?php echo json_encode($monthlyData); ?>;

        var data = {
            labels: month, // the labels for the x-axis
            datasets: [
            {
                label: "Borrowing", // the label for the data set
                data: count, // the data for the chart
                borderColor: "#3e95cd", // the color of the line
                fill: false // don't fill the area under the line
            }
            ]
        };

        // get the canvas element
        var ctx = document.getElementById("monthlyChart").getContext("2d");

        // create the chart using the Chart constructor
        var myChart = new Chart(ctx, {
            type: 'line',
            data: data
        });
    </script>

    <script>
        const books = <?php echo json_encode($topBooks); ?>;;

        const dataset = [];
        const backgroundColor = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 205, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)'
        ];

        const mainColor = [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)'
        ];

        for (let i = 0; i < books.length; i++) {
            dataset[i] = {
                label: books[i].title,
                backgroundColor: backgroundColor[i],
                borderColor: mainColor[i],
                pointBackgroundColor: mainColor[i],
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: mainColor[i],
                borderWidth: 1,
                data: [
                    books[i].count,
                    books[i].extended,
                    books[i].waiting
                ]
            };
        };

        var marksData = {
            labels: ["Borrow", "Extended", "Waiting"],
            datasets: dataset
        };
        
        var chartOptions = {
        plugins: {
            title: {
            display: true,
            align: "start",
            text: "Comparing Student Performance"
            },
            legend: {
            align: "start"
            }
        },
        scales: {
            r: {
            pointLabels: {
                font: {
                size: 20
                }
            }
            }
        }
        };

        var marksCanvas = document.getElementById("topChart").getContext("2d");

        var radarChart = new Chart(marksCanvas, {
            type: "radar",
            data: marksData,
            options: chartOptions
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#toptable').DataTable({
                order: [[4, 'desc']]
            });
        });
    </script>
@endsection