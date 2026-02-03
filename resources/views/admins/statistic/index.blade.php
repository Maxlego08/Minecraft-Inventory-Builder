@extends('admins.layouts.app')

@section('title', 'Statistiques')

@section('content')

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Statistiques</h1>
        </div>

        {{-- ========== SECTION UTILISATEURS ========== --}}
        <h5 class="text-gray-600 font-weight-bold mb-3"><i class="fas fa-users mr-1"></i> Utilisateurs</h5>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total utilisateurs</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalUsers) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Utilisateurs vérifiés</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($verifiedUsers) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-user-check fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Utilisateurs Premium</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($premiums) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-star fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Utilisateurs Pro</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($pros) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-crown fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== SECTION RESSOURCES ========== --}}
        <h5 class="text-gray-600 font-weight-bold mb-3"><i class="fas fa-puzzle-piece mr-1"></i> Ressources</h5>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total ressources</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalResources) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-puzzle-piece fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">En attente</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($pendingResources) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-pause-circle fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Gratuites</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($freeResources) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-gift fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Payantes</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($paidResources) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== SECTION INVENTAIRES & BUILDER ========== --}}
        <h5 class="text-gray-600 font-weight-bold mb-3"><i class="fas fa-folder mr-1"></i> Builder</h5>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total inventaires</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalInventories) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-th fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Avec boutons</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($inventoriesWithButtons) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-mouse-pointer fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Dossiers</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalFolders) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-folder-open fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total downloads</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalDownloads) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-download fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== SECTION PAIEMENTS ========== --}}
        <h5 class="text-gray-600 font-weight-bold mb-3"><i class="fas fa-euro-sign mr-1"></i> Paiements</h5>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Revenu total</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalRevenue, 2) }}&euro;</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-coins fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Paiements</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPayments) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-credit-card fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Remboursements</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($refundedPayments) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-undo fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Litiges</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($disputedPayments) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== SECTION SIGNALEMENTS ========== --}}
        <h5 class="text-gray-600 font-weight-bold mb-3"><i class="fas fa-flag mr-1"></i> Signalements</h5>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Total signalements</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalReports) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-flag fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Non résolus</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($openReports) }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-exclamation-circle fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== GRAPHIQUES ========== --}}
        <h5 class="text-gray-600 font-weight-bold mb-3"><i class="fas fa-chart-line mr-1"></i> Graphiques</h5>

        {{-- Utilisateurs --}}
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Nouveaux utilisateurs</h6>
                    </div>
                    <div class="card-body">
                        <div class="tab-content mb-3">
                            <div class="tab-pane fade show active" id="usersMonthly" role="tabpanel">
                                <div class="chart-area"><canvas id="usersPerMonthChart"></canvas></div>
                            </div>
                            <div class="tab-pane fade" id="usersDaily" role="tabpanel">
                                <div class="chart-area"><canvas id="usersPerDayChart"></canvas></div>
                            </div>
                        </div>
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#usersMonthly">Par mois</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#usersDaily">Par jour (30j)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Revenus & Paiements --}}
        <div class="row">
            <div class="col-xl-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Revenus par mois</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area"><canvas id="revenuePerMonthChart"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Paiements par mois</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area"><canvas id="paymentsPerMonthChart"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ressources & Inventaires --}}
        <div class="row">
            <div class="col-xl-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">Nouvelles ressources par mois</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area"><canvas id="resourcesPerMonthChart"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">Nouveaux inventaires par mois</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area"><canvas id="inventoriesPerMonthChart"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Downloads --}}
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-secondary">Downloads par mois</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area"><canvas id="downloadsPerMonthChart"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Camemberts --}}
        <h5 class="text-gray-600 font-weight-bold mb-3"><i class="fas fa-chart-pie mr-1"></i> Répartitions</h5>
        <div class="row">
            <div class="col-xl-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Paiements par type</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2"><canvas id="paymentsByTypeChart"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Paiements par gateway</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2"><canvas id="paymentsByGatewayChart"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Ressources par catégorie</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2"><canvas id="resourcesByCategoryChart"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau répartition paiements --}}
        <div class="row">
            <div class="col-xl-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Détail par type de paiement</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Nombre</th>
                                        <th>Revenu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($paymentsByType as $label => $data)
                                    <tr>
                                        <td>{{ $label }}</td>
                                        <td>{{ number_format($data['total']) }}</td>
                                        <td>{{ number_format($data['revenue'], 2) }}&euro;</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Ressources par catégorie</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Catégorie</th>
                                        <th>Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($resourcesByCategory as $name => $count)
                                    <tr>
                                        <td>{{ $name }}</td>
                                        <td>{{ number_format($count) }}</td>
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

@endsection

@section('script')
    <script>
        // --- Fonctions utilitaires ---
        const CHART_COLORS = [
            'rgba(78, 115, 223, 1)',
            'rgba(28, 200, 138, 1)',
            'rgba(246, 194, 62, 1)',
            'rgba(231, 74, 59, 1)',
            'rgba(54, 185, 204, 1)',
            'rgba(133, 135, 150, 1)',
            'rgba(105, 70, 200, 1)',
            'rgba(255, 128, 66, 1)',
        ];

        const CHART_COLORS_BG = CHART_COLORS.map(c => c.replace(', 1)', ', 0.6)'));

        Chart.defaults.global.defaultFontFamily = 'Nunito';
        Chart.defaults.global.defaultFontColor = '#858796';

        function createLineChart(elementId, data, labelName, borderColor) {
            borderColor = borderColor || 'rgba(78, 115, 223, 1)';
            const bgColor = borderColor.replace(', 1)', ', 0.05)');
            new Chart(document.getElementById(elementId), {
                type: 'line',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        label: labelName,
                        lineTension: 0.3,
                        backgroundColor: bgColor,
                        borderColor: borderColor,
                        pointRadius: 3,
                        pointBackgroundColor: borderColor,
                        pointBorderColor: borderColor,
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: borderColor,
                        pointHoverBorderColor: borderColor,
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: Object.values(data),
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [{gridLines: {display: false, drawBorder: false}, ticks: {maxTicksLimit: 12}}],
                        yAxes: [{ticks: {maxTicksLimit: 5, padding: 10, beginAtZero: true}, gridLines: {color: "rgb(234, 236, 244)", zeroLineColor: "rgb(234, 236, 244)", drawBorder: false, borderDash: [2], zeroLineBorderDash: [2]}}],
                    },
                    legend: {display: false},
                    tooltips: {backgroundColor: "rgb(255,255,255)", bodyFontColor: "#858796", titleMarginBottom: 10, titleFontColor: '#6e707e', titleFontSize: 14, borderColor: '#dddfeb', borderWidth: 1, xPadding: 15, yPadding: 15, displayColors: false, intersect: false, mode: 'index', caretPadding: 10}
                }
            });
        }

        function createBarChart(elementId, data, labelName, bgColor) {
            bgColor = bgColor || 'rgba(78, 115, 223, 0.7)';
            new Chart(document.getElementById(elementId), {
                type: 'bar',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        label: labelName,
                        backgroundColor: bgColor,
                        borderColor: bgColor.replace('0.7)', '1)'),
                        borderWidth: 1,
                        data: Object.values(data),
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [{gridLines: {display: false, drawBorder: false}, ticks: {maxTicksLimit: 12}}],
                        yAxes: [{ticks: {maxTicksLimit: 5, padding: 10, beginAtZero: true}, gridLines: {color: "rgb(234, 236, 244)", zeroLineColor: "rgb(234, 236, 244)", drawBorder: false, borderDash: [2], zeroLineBorderDash: [2]}}],
                    },
                    legend: {display: false},
                    tooltips: {backgroundColor: "rgb(255,255,255)", bodyFontColor: "#858796", titleMarginBottom: 10, titleFontColor: '#6e707e', titleFontSize: 14, borderColor: '#dddfeb', borderWidth: 1, xPadding: 15, yPadding: 15, displayColors: false, intersect: false, mode: 'index', caretPadding: 10}
                }
            });
        }

        function createDoughnutChart(elementId, data) {
            const labels = Object.keys(data);
            const values = Object.values(data);
            new Chart(document.getElementById(elementId), {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: CHART_COLORS_BG.slice(0, labels.length),
                        borderColor: CHART_COLORS.slice(0, labels.length),
                        borderWidth: 1,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    cutoutPercentage: 60,
                    legend: {position: 'bottom', labels: {padding: 15}},
                    tooltips: {backgroundColor: "rgb(255,255,255)", bodyFontColor: "#858796", borderColor: '#dddfeb', borderWidth: 1, xPadding: 15, yPadding: 15, displayColors: true}
                }
            });
        }

        // --- Graphiques ligne ---
        createLineChart('usersPerMonthChart', @json($usersPerMonth), 'Utilisateurs', 'rgba(78, 115, 223, 1)');
        createLineChart('usersPerDayChart', @json($usersPerDay), 'Utilisateurs', 'rgba(78, 115, 223, 1)');
        createBarChart('revenuePerMonthChart', @json($revenuePerMonth), 'Revenu', 'rgba(28, 200, 138, 0.7)');
        createLineChart('paymentsPerMonthChart', @json($paymentsPerMonth), 'Paiements', 'rgba(78, 115, 223, 1)');
        createLineChart('resourcesPerMonthChart', @json($resourcesPerMonth), 'Ressources', 'rgba(246, 194, 62, 1)');
        createLineChart('inventoriesPerMonthChart', @json($inventoriesPerMonth), 'Inventaires', 'rgba(54, 185, 204, 1)');
        createLineChart('downloadsPerMonthChart', @json($downloadsPerMonth), 'Downloads', 'rgba(133, 135, 150, 1)');

        // --- Graphiques camembert ---
        createDoughnutChart('paymentsByTypeChart', @json($paymentsByType->map(fn($d) => $d['total'])));
        createDoughnutChart('paymentsByGatewayChart', @json($paymentsByGateway));
        createDoughnutChart('resourcesByCategoryChart', @json($resourcesByCategory));
    </script>
@endsection
