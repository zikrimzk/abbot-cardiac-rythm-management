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
            </div>
            <!-- [Greeting] end -->

            <!-- [Startup Alert] start -->
            <div class="alert alert-light shadow-sm border-0 rounded-3">
                <h4 class="alert-heading mb-3">Welcome to Cardiac Rhythm Management Division System</h4>
                <p class="mb-2">
                    To begin, it is <strong>advisable to change your account password</strong> to secure your account.
                </p>

                <hr>

                <h6 class="fw-bold mt-3">For Administrator</h6>
                <ul class="mb-3">
                    <li>Full access to all system settings</li>
                </ul>

                <h6 class="fw-bold mt-3">User Module</h6>
                <ul class="mb-3">
                    <li><strong>Manage Designation</strong> – Add staff designations before adding new staff</li>
                    <li><strong>Manage Staff</strong> – Add users as administrators or staff</li>
                </ul>

                <h6 class="fw-bold mt-3">Hospital & Doctor Module</h6>
                <ul class="mb-3">
                    <li><strong>Manage Hospital</strong> – Maintain hospital details</li>
                    <li><strong>Manage Doctor</strong> – Maintain doctor details</li>
                </ul>

                <h6 class="fw-bold mt-3">Model Module</h6>
                <ul class="mb-3">
                    <li><strong>Manage Model Category</strong> – Categories such as RA Leads, RV Leads, etc.</li>
                    <li><strong>Manage Generator</strong> – Manage generator details</li>
                    <li><strong>Manage Model</strong> – Manage other models not under generators (e.g., RV leads)</li>
                </ul>

                <h6 class="fw-bold mt-3">Other Settings</h6>
                <ul class="mb-3">
                    <li><strong>Manage Region</strong> – e.g., Northern, Central, Southern</li>
                    <li><strong>Manage Product Group</strong> – e.g., LV SC, LV DC and other combinations</li>
                    <li><strong>Manage Stock Location</strong> – Stock locations used dynamically in inventory forms</li>
                </ul>

                <h6 class="fw-bold mt-3">Implant Module</h6>
                <ul class="mb-3">
                    <li>Add and update implant records</li>
                    <li>Export data and download patient directory</li>
                    <li>Upload implant registration forms (PDF format)</li>
                    <li>Send implant details by email (template provided)</li>
                    <li>Generate patient ID card</li>
                </ul>

                <h6 class="fw-bold mt-3">Sales Billing Module</h6>
                <ul class="mb-3">
                    <li>Update ICF-related details</li>
                    <li>Upload billing documents (approval, delivery order, etc.)</li>
                </ul>

                <h6 class="fw-bold mt-3">Quotation Module</h6>
                <ul class="mb-3">
                    <li>Manage quotations</li>
                    <li>Manage companies to generate quotation templates</li>
                    <li>Assign generator and model</li>
                </ul>

                <p class="mt-4 mb-0 text-muted">
                    <em>Note: All changes and actions related to implants are recorded in the implant logs.</em>
                </p>
            </div>

            <!-- [Startup Alert] end -->

            <!-- [Dashboard Cards] start -->
            <div class="row g-3">
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
                        <div class="card shadow-sm border-0 hover-shadow">
                            <div class="card-body d-flex align-items-center gap-3">
                                <div class="flex-shrink-0">
                                    <div class="avatar bg-light-{{ $card['color'] }} rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="{{ $card['icon'] }} text-{{ $card['color'] }} f-20"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 fw-semibold text-muted">{{ $card['label'] }}</p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h4 class="mb-0">{{ $card['count'] }}</h4>
                                        <a href="{{ route($card['route']) }}"
                                            class="text-{{ $card['color'] }} fw-medium small">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- [Dashboard Cards] end -->

            <!-- [Recent Implant Logs] start -->
            @if (auth()->user()->staff_role == 1)
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card shadow-sm border-0 hover-shadow">
                            <div class="card-body">
                                <h5 class="card-title mb-0 text-muted fw-semibold">
                                    <i class="fas fa-history me-2 text-muted fw-semibold"></i>Recent Implant Logs
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-hover table-borderless align-middle data-table w-100">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-muted small" style="width: 120px;">Date</th>
                                                <th class="text-muted small" style="width: 120px;">Implant</th>
                                                <th class="text-muted small">Recent Activity</th>
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

            <!-- [Charts] start -->
            <div class="row">
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
                {{-- <div class="col-sm-6">
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
                </div> --}}
            </div>
            <!-- [Charts] end -->

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
                paging: false,
                searching: false,
                info: false,
                order: [
                    [0, 'desc']
                ],
                ajax: "{{ route('staff-dashboard-page') }}", // <-- Replace with actual route
                columns: [{
                        data: 'log_datetime',
                        name: 'log_datetime',
                        className: 'text-nowrap text-muted small',
                    },
                    {
                        data: 'implant_refno',
                        name: 'implant_refno',
                        className: 'text-body small',
                    },
                    {
                        data: 'log_activity',
                        name: 'log_activity',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                const cleanText = $('<div>').html(data).text();
                                const shortText = cleanText.length > 80 ? cleanText.substring(0,
                                    80) + '...' : cleanText;
                                return `<span data-bs-toggle="tooltip" title="${cleanText}">${shortText}</span>`;
                            }
                            return data;
                        },
                        className: 'text-body small',
                    }
                ],
                drawCallback: function() {
                    const tooltips = [].slice.call(document.querySelectorAll(
                        '[data-bs-toggle="tooltip"]'));
                    tooltips.map(t => new bootstrap.Tooltip(t));
                }
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
