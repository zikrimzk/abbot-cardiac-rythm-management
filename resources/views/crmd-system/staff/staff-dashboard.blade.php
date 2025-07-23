<!-- [ Extend Layouts ] -->
@extends('crmd-system.layouts.main')

<!-- [ Main Content ] start -->
@section('content')
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

            <!-- [Greeting] start -->
            @php
                $hour = now()->format('H');

                if ($hour < 12) {
                    $greeting = 'Good Morning';
                    $icon = 'fa-sun text-warning';
                    $message = "Rise and shine! Let's have a great start.";
                } elseif ($hour < 18) {
                    $greeting = 'Good Afternoon';
                    $icon = 'fa-cloud-sun text-orange';
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
            </div>
            <!-- [Greeting] end -->

            <!-- [Dashboard Cards] start -->
            <div class="row">
                @if (auth()->user()->staff_role == 1)
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar bg-light-primary">
                                            <i class="fas fa-file-medical-alt f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-1">Total Implants</p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4 class="mb-0">{{ $totalImplants }}</h4>
                                            <a href="{{ route('manage-implant-page') }}"
                                                class="text-primary fw-medium">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar bg-light-warning">
                                            <i class="fas fa-user-md f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-1">Total Doctors</p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4 class="mb-0">{{ $totalDoctors }}</h4>
                                            <a href="{{ route('manage-doctor-page') }}"
                                                class="text-warning fw-medium">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar bg-light-success">
                                            <i class="fas fa-hospital-alt f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-1">Total Hospital</p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4 class="mb-0">{{ $totalHospitals }}</h4>
                                            <a href="{{ route('manage-hospital-page') }}"
                                                class="text-success fw-medium">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar bg-light-danger">
                                            <i class="fas fa-users f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-1">Total Staff</p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4 class="mb-0">{{ $totalStaff }}</h4>
                                            <a href="{{ route('manage-staff-page') }}"
                                                class="text-danger fw-medium">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar bg-light-primary">
                                            <i class="fas fa-box f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-1">Total Generators</p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4 class="mb-0">{{ $totalGenerators }}</h4>
                                            <a href="{{ route('manage-generator-page') }}"
                                                class="text-primary fw-medium">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar bg-light-danger">
                                            <i class="fas fa-boxes f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-1">Total Models</p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4 class="mb-0">{{ $totalModels }}</h4>
                                            <a href="{{ route('manage-model-page') }}"
                                                class="text-danger fw-medium">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar bg-light-warning">
                                            <i class="fas fa-file-invoice f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-1">Total Generated Quotations</p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4 class="mb-0">{{ $totalQuotations }}</h4>
                                            <a href="{{ route('manage-quotation-page') }}"
                                                class="text-warning fw-medium">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif(auth()->user()->staff_role == 2)
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar bg-light-primary">
                                            <i class="fas fa-file-medical-alt f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-1">Total Implants</p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4 class="mb-0">{{ $totalImplants }}</h4>
                                            <a href="{{ route('manage-implant-page') }}"
                                                class="text-primary fw-medium">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar bg-light-primary">
                                            <i class="fas fa-box f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-1">Total Generators</p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4 class="mb-0">{{ $totalGenerators }}</h4>
                                            <a href="{{ route('manage-generator-page') }}"
                                                class="text-primary fw-medium">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar bg-light-danger">
                                            <i class="fas fa-boxes f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-1">Total Models</p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4 class="mb-0">{{ $totalModels }}</h4>
                                            <a href="{{ route('manage-model-page') }}"
                                                class="text-danger fw-medium">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar bg-light-warning">
                                            <i class="fas fa-file-invoice f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-1">Total Quotations</p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4 class="mb-0">{{ $totalQuotations }}</h4>
                                            <a href="{{ route('manage-quotation-page') }}"
                                                class="text-warning fw-medium">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <!-- [Dashboard Cards] end -->

            <!-- [Charts] start -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="card shadow-sm rounded-lg">
                        <div class="card-body">
                            <canvas id="implantByMonthChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card shadow-sm rounded-lg">
                        <div class="card-body">
                            <canvas id="salesByMonthChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card shadow-sm rounded-lg">
                        <div class="card-body">
                            <canvas id="generatorQtyBarChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card shadow-sm rounded-lg">
                        <div class="card-body">
                            <canvas id="implantModelMonthlyChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [Charts] end -->

            <!-- [ Main Content ] end -->
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <script>
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
