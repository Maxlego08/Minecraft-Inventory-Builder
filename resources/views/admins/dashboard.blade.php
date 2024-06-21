@extends('admins.layouts.app')

@section('content')

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Utilisateurs
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ressources
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $resources }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-paperclip fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Inventaires
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $inventories }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-folder fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Estimations
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $payments }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-euro-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Utilisateurs récents</h6>
                    </div>
                    <div class="card-body">
                        <div class="tab-content mb-3">
                            <div class="tab-pane fade show active" id="monthlyChart" role="tabpanel"
                                 aria-labelledby="monthlyChartTab">
                                <div class="chart-area">
                                    <canvas id="newUsersPerMonthsChart"></canvas>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="dailyChart" role="tabpanel" aria-labelledby="dailyChartTab">
                                <div class="chart-area">
                                    <canvas id="newUsersPerDaysChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="monthlyChartTab" data-toggle="pill" href="#monthlyChart"
                                   role="tab" aria-controls="monthlyChart" aria-selected="true">
                                    Par mois
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="dailyChartTab" data-toggle="pill" href="#dailyChart" role="tab"
                                   aria-controls="dailyChart" aria-selected="false">
                                    Par jours
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')
    <script>
        window.createLineChartAdmin = function (elementId, data, labelName) {
            Chart.defaults.global.defaultFontFamily = 'Nunito';
            Chart.defaults.global.defaultFontColor = '#858796';

            new Chart(document.getElementById(elementId), {
                type: 'line',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        label: labelName,
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "rgba(78, 115, 223, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointBorderColor: "rgba(78, 115, 223, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: Object.values(data),
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 7
                            },
                        }],
                        yAxes: [{
                            ticks: {
                                maxTicksLimit: 5,
                                padding: 10,
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2],
                            },
                        }],
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                        caretPadding: 10,
                    }
                }
            })
        }
    </script>
    <script>
        createLineChartAdmin('newUsersPerMonthsChart', @json($newUsersPerMonths), 'Utilisateurs');
        createLineChartAdmin('newUsersPerDaysChart', @json($newUsersPerDays), 'Utilisateurs');
    </script>
@endsection
