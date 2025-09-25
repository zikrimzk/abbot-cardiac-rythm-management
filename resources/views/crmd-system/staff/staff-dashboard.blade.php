<!-- [ Extend Layouts ] -->
@extends('crmd-system.layouts.main')

<!-- [ Main Content ] start -->
@section('content')
    <style>
        .custom-accordion .accordion-body {
            padding: 1.5rem;
        }

        .feature-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-left: 4px solid #3498db;
        }

        .feature-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .alert-warning {
            background-color: rgba(255, 193, 7, 0.1);
            border-left: 4px solid #ffc107;
        }

        .dashboard-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            /* height: 100%; */
            background: #fff;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
            border-left: 4px solid;
        }

        /* Color-specific hover borders */


        .card-icon-container {
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover .card-icon-container {
            transform: scale(1.1);
        }

        .card-count {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            line-height: 1;
        }

        .card-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #6c757d;
        }

        .card-link {
            font-size: 0.85rem;
            transition: all 0.2s ease;
            padding: 0.5rem 0;
            border-top: 1px solid #f1f1f1;
            /* margin-top: 0.5rem; */
        }

        .card-link:hover {
            letter-spacing: 0.5px;
        }

        .card-link:hover .transition-all {
            transform: translateX(3px);
        }

        .transition-all {
            transition: transform 0.2s ease;
        }

        .card-badge {
            font-size: 0.7rem;
        }

        /* Soft background colors */
        .bg-soft-primary {
            background-color: rgba(13, 110, 253, 0.1) !important;
        }

        .bg-soft-warning {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }

        .bg-soft-success {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        .bg-soft-danger {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-count {
                font-size: 1.75rem;
            }

            .card-icon-container {
                padding: 0.75rem !important;
            }

            .card-icon-container i {
                font-size: 1.25rem !important;
            }

            .col-xl-3 {
                margin-bottom: 1rem;
            }
        }
    </style>

    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.html">Main</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Dashboard</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->


            <!-- [ Main Content ] start -->

            <!-- [Startup Alert] start -->
            <div class="dashboard-welcome-container mb-4">
                <div class="accordion custom-accordion" id="systemAccordion">
                    <div class="accordion-item shadow-sm rounded-3">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed p-4" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <div class="d-flex align-items-center w-100">
                                    <i class="fas fa-heartbeat me-3 text-danger fs-5"></i>
                                    <div class="flex-grow-1">
                                        <h4 class="mb-1">Welcome back, {{ auth()->user()->staff_name }}.</h4>
                                        <small class="text-muted">Access your dashboard and system information
                                            below.</small>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                            data-bs-parent="#systemAccordion">
                            <div class="accordion-body">
                                <div class="alert alert-warning d-flex align-items-center mb-4">
                                    <i class="fas fa-user-shield me-3 fs-4"></i>
                                    <div>
                                        <strong>Security Recommendation:</strong> As a first step, it is <strong>highly
                                            recommended that you change your account password</strong> to ensure your
                                        account security.
                                    </div>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="feature-card h-100 p-3 rounded bg-light">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="fas fa-users me-2 text-primary"></i>
                                                <h5 class="mb-0">User & Access Management</h5>
                                            </div>
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-2 d-flex align-items-center">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <span><strong>Manage Designation:</strong> Define staff roles and
                                                        designations.</span>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <span><strong>Manage Staff:</strong> Add and manage user accounts,
                                                        assigning administrator or staff privileges.</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="feature-card h-100 p-3 rounded bg-light">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="fas fa-briefcase-medical me-2 text-primary"></i>
                                                <h5 class="mb-0">Patient Records</h5>
                                            </div>
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-flex align-items-center">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <span><strong>Implant Module:</strong> Add, update, and manage implant
                                                        records; generate patient ID cards.</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="feature-card h-100 p-3 rounded bg-light">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="fas fa-clipboard-list me-2 text-primary"></i>
                                                <h5 class="mb-0">Administrative Functions</h5>
                                            </div>
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-2 d-flex align-items-center">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <span><strong>Manage Hospital:</strong> Maintain detailed records for
                                                        all hospitals.</span>
                                                </li>
                                                <li class="mb-2 d-flex align-items-center">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <span><strong>Manage Doctor:</strong> Manage all doctor
                                                        information.</span>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <span><strong>Manage Region:</strong> Define geographical regions (e.g.,
                                                        Northern, Central, Southern).</span>
                                                </li>
                                                <li class="mb-2 d-flex align-items-center">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <span><strong>Manage Model Category:</strong> Classify devices into
                                                        categories (e.g., RA Leads, RV Leads).</span>
                                                </li>
                                                <li class="mb-2 d-flex align-items-center">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <span><strong>Manage Generator:</strong> Handle details for all
                                                        generator models (e.g., PM3562, PM1262).</span>
                                                </li>
                                                <li class="mb-2 d-flex align-items-center">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <span><strong>Manage Model:</strong> Manage other device models not
                                                        categorized as generators (e.g., 2088TC-52).</span>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <span><strong>Manage Stock Location:</strong> Specify stock locations
                                                        for inventory tracking.</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="feature-card h-100 p-3 rounded bg-light">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="fas fa-chart-line me-2 text-primary"></i>
                                                <h5 class="mb-0">Sales Management</h5>
                                            </div>
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-2 d-flex align-items-center">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <span><strong>Quotation Module:</strong> Create and manage quotations,
                                                        including company and model assignments.</span>
                                                </li>
                                                <li class="mb-2 d-flex align-items-center">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <span><strong>Sales Billing:</strong> Handle ICF details and upload
                                                        billing documents.</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 border-top">
                                    <div class="d-flex align-items-center text-muted small">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <span>*All actions and changes made to implant records are automatically logged for
                                            security and auditing purposes.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [Startup Alert] end -->

            <!-- [Greeting] start [UNUSED FOR A MOMENT] -->
            {{-- @php
                $hour = now()->format('H');

                if ($hour < 12) {
                    $greeting = 'Good Morning';
                    $icon = 'fa-sun text-warning';
                    $message = "Rise and shine! Let's have a great start.";
                } elseif ($hour < 18) {
                    $greeting = 'Good Afternoon';
                    $icon = 'fa-cloud-sun text-warning';
                    $message = "Keep going strong! You're doing great.";
                } elseif ($hour < 21) {
                    $greeting = 'Good Evening';
                    $icon = 'fa-cloud-moon text-info';
                    $message = 'Winding down? Hope your day was productive.';
                } else {
                    $greeting = 'Good Night';
                    $icon = 'fa-moon text-primary';
                    $message = 'Rest well and recharge for tomorrow!';
                }
            @endphp

            <div class="row">
                <div class="col-md-12">
                    <div class="card rounded-4 p-4" style=" background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <div class="d-flex align-items-center">
                            <div class="me-4">
                                <i class="fas {{ $icon }} fa-3x animate__animated animate__fadeInDown"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1">{{ $greeting }}, {{ auth()->user()->staff_name }} !</h4>
                                <p class="mb-0 text-muted">{{ $message }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- [Greeting] end [UNUSED FOR A MOMENT] -->

            <!-- [Quick Access] start -->   
            <div class="mb-4">
                <h5 class="mb-3">⚡ Quick Access</h5>
                <div class="row g-3">
                    <!-- Add Implant -->
                    <div class="col-md-6">
                        <a href="{{ route('add-implant-page') }}" class="card shadow-sm border-0 h-100 text-decoration-none">
                            <div class="card-body d-flex align-items-center">
                                <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 fw-bold text-dark">Add Implant</h6>
                                    <small class="text-muted">Register new implant quickly</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Generate Quotation -->
                    <div class="col-md-6">
                        <a href="{{ route('generate-quotation-page') }}" class="card shadow-sm border-0 h-100 text-decoration-none">
                            <div class="card-body d-flex align-items-center">
                                <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-file-invoice"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 fw-bold text-dark">Generate Quotation</h6>
                                    <small class="text-muted">Create quotation instantly</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- [Quick Access] end -->

            <!-- [Dashboard Cards] start -->
            <div class="row">
                <h5 class="mb-3">📌 Key Metrics</h5>

                @php
                    $cards = [];

                    if (auth()->user()->staff_role == 1) {
                        $cards = [
                            [
                                'label' => 'Total Implants',
                                'icon' => 'fas fa-file-medical-alt',
                                'color' => 'primary',
                                'count' => $totalImplants,
                                'route' => 'manage-implant-page',
                            ],
                            [
                                'label' => 'Total Doctors',
                                'icon' => 'fas fa-user-md',
                                'color' => 'warning',
                                'count' => $totalDoctors,
                                'route' => 'manage-doctor-page',
                            ],
                            [
                                'label' => 'Total Hospital',
                                'icon' => 'fas fa-hospital-alt',
                                'color' => 'success',
                                'count' => $totalHospitals,
                                'route' => 'manage-hospital-page',
                            ],
                            [
                                'label' => 'Total Staff',
                                'icon' => 'fas fa-users',
                                'color' => 'danger',
                                'count' => $totalStaff,
                                'route' => 'manage-staff-page',
                            ],
                            [
                                'label' => 'Total Generators',
                                'icon' => 'fas fa-box',
                                'color' => 'primary',
                                'count' => $totalGenerators,
                                'route' => 'manage-generator-page',
                            ],
                            [
                                'label' => 'Total Models',
                                'icon' => 'fas fa-boxes',
                                'color' => 'danger',
                                'count' => $totalModels,
                                'route' => 'manage-model-page',
                            ],
                            [
                                'label' => 'Total Quotations',
                                'icon' => 'fas fa-file-invoice',
                                'color' => 'warning',
                                'count' => $totalQuotations,
                                'route' => 'manage-quotation-page',
                            ],
                        ];
                    } elseif (auth()->user()->staff_role == 2) {
                        $cards = [
                            [
                                'label' => 'Total Implants',
                                'icon' => 'fas fa-file-medical-alt',
                                'color' => 'primary',
                                'count' => $totalImplants,
                                'route' => 'manage-implant-page',
                            ],
                            [
                                'label' => 'Total Generators',
                                'icon' => 'fas fa-box',
                                'color' => 'primary',
                                'count' => $totalGenerators,
                                'route' => 'manage-generator-page',
                            ],
                            [
                                'label' => 'Total Models',
                                'icon' => 'fas fa-boxes',
                                'color' => 'danger',
                                'count' => $totalModels,
                                'route' => 'manage-model-page',
                            ],
                            [
                                'label' => 'Total Quotations',
                                'icon' => 'fas fa-file-invoice',
                                'color' => 'warning',
                                'count' => $totalQuotations,
                                'route' => 'manage-quotation-page',
                            ],
                        ];
                    }
                @endphp

                @foreach ($cards as $card)
                    <div class="col-xl-3 col-md-6">
                        <div class="card dashboard-card shadow-sm border-0">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="card-icon-container bg-soft-{{ $card['color'] }} rounded-2 p-3">
                                        <i class="{{ $card['icon'] }} text-{{ $card['color'] }} fs-4"></i>
                                    </div>
                                </div>

                                <h3 class="card-count mb-1">{{ $card['count'] }}</h3>
                                <p class="card-label text-muted mb-3">{{ $card['label'] }}</p>

                                <a href="{{ route($card['route']) }}"
                                    class="card-link text-{{ $card['color'] }} text-decoration-none fw-medium d-flex align-items-center">
                                    View Details
                                    <i class="fas fa-arrow-right ms-2 transition-all"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- [Dashboard Cards] end -->

            <!-- [Charts] start -->
            <div class="row">
                <h5 class="mb-3">📊 Analytics & Trends</h5>

                <div class="col-sm-6">
                    <div class="card shadow-sm rounded-lg">
                        <div class="card-body">
                            <canvas id="implantByMonthChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card shadow-sm rounded-lg">
                        <div class="card-body">
                            <canvas id="salesByMonthChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card shadow-sm rounded-lg">
                        <div class="card-body">
                            <canvas id="generatorQtyBarChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card shadow-sm rounded-lg">
                        <div class="card-body">
                            <canvas id="implantModelMonthlyChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [Charts] end -->

            <!-- [Recent Implant Logs] start -->
            @if (auth()->user()->staff_role == 1)
                <div class="row">
                    <h5 class="mb-3">⏱ Recent Implant Activity</h5>

                    <div class="col-lg-12 col-md-12">
                        <div class="card shadow-sm border-0 hover-shadow">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-borderless align-middle data-table w-100">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="small">ID</th>
                                                <th class="small" style="width: 120px;">Date</th>
                                                <th class="small" style="width: 120px;">Implant</th>
                                                <th class="small">Recent Activity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <!-- [Recent Implant Logs] end -->

            <!-- [ Main Content ] end -->
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <script>
        $(document).ready(function() {

            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                ajax: "{{ route('staff-dashboard-page') }}",
                order: [
                    [0, 'desc']
                ],
                pageLength: 5,
                lengthMenu: [
                    [5, 10, 20, 30],
                    [5, 10, 20, 30]
                ],
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false,
                    },
                    {
                        data: 'log_datetime',
                        name: 'log_datetime',
                        className: 'text-nowrap small',
                    },
                    {
                        data: 'implant_refno',
                        name: 'implant_refno',
                        className: 'small',
                    },
                    {
                        data: 'log_activity',
                        name: 'log_activity',
                        className: 'small',
                    }
                ],
            });



        });

        const ctx = document.getElementById('implantByMonthChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($implantsByMonthlabels),
                datasets: [{
                    label: 'Implants per Month',
                    data: @json($implantsByMonthdata),
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        text: 'Monthly Implants Record',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: false,
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Implant Quantity'
                        }
                    }
                }
            }
        });

        const salesCtx = document.getElementById('salesByMonthChart').getContext('2d');

        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: @json($salesLabels),
                datasets: [{
                    label: 'Sales (RM)',
                    data: @json($salesData),
                    fill: true,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 2,
                    tension: 0.3, // smooth curve
                    pointBackgroundColor: 'rgba(153, 102, 255, 1)',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        text: 'Monthly Implant Sales (RM)',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Sales (RM)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                }
            }
        });

        const ctxBar = document.getElementById('generatorQtyBarChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: @json($qtyChartMonths),
                datasets: @json($qtyChartDatasets).map((ds, i) => {
                    const colors = ['#4dc9f6', '#f67019', '#f53794', '#537bc4', '#acc236', '#166a8f',
                        '#00a950', '#58595b', '#8549ba'
                    ];
                    const color = colors[i % colors.length];
                    return {
                        ...ds,
                        backgroundColor: color,
                    };
                })
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Generator Quantities',
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        stacked: false,
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Generator Quantity'
                        }
                    }
                }
            }
        });

        const ctxModelImplant = document.getElementById('implantModelMonthlyChart').getContext('2d');

        const colorSetModelImplant = [
            '#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0',
            '#9966FF', '#FF9F40', '#C9CBCF', '#8BE38A'
        ];

        const chartModelImplant = new Chart(ctxModelImplant, {
            type: 'bar',
            data: {
                labels: @json($modelImplantMonths),
                datasets: @json($modelImplantDatasets).map((dataset, index) => ({
                    ...dataset,
                    backgroundColor: colorSetModelImplant[index % colorSetModelImplant.length],
                }))
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Implant Quantity by Model',
                        font: {
                            size: 18
                        }
                    },
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        stacked: false,
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Quantity'
                        }
                    }
                }
            }
        });
    </script>
@endsection
<!-- [ Main Content ] end -->
