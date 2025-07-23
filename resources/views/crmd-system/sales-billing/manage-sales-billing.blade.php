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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Sales Biling</a></li>
                                <li class="breadcrumb-item" aria-current="page">Manage Sales Billing
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Manage Sales Billing</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Alert ] start -->
            <div>
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="alert-heading">
                                <i class="fas fa-check-circle"></i>
                                Success
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="alert-heading">
                                <i class="fas fa-info-circle"></i>
                                Error
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <p class="mb-0">{{ session('error') }}</p>
                    </div>
                @endif
            </div>
            <!-- [ Alert ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">

                <!-- [ Generate ICF ] start -->
                <div class="col-sm-12">
                    <!-- [ Filter ] start -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Date Range Filter -->
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="dateRangeFilter"
                                        placeholder="Start Date to End Date" readonly>
                                    <div><a href="javascript:void(0)" id="clearDateRangeFilter"
                                            class="small text-primary">Clear</a></div>
                                </div>

                                <!-- Region Filter -->
                                <div class="col-md-3">
                                    <select class="form-select" id="regionFilter">
                                        <option value="">-- Select Region --</option>
                                        @foreach ($region as $rn)
                                            <option value="{{ $rn->id }}">{{ $rn->region_name }}</option>
                                        @endforeach
                                    </select>
                                    <div><a href="javascript:void(0)" id="clearRegionFilter"
                                            class="small text-primary">Clear</a></div>
                                </div>

                                <!-- Hospital Filter -->
                                <div class="col-md-3">
                                    <select class="form-select" id="hospFilter">
                                        <option value="">-- Select Hospital --</option>
                                        @foreach ($hosp as $h)
                                            <option value="{{ $h->id }}">({{ $h->hospital_code }}) -
                                                {{ $h->hospital_name }}</option>
                                        @endforeach
                                    </select>
                                    <div><a href="javascript:void(0)" id="clearHospFilter"
                                            class="small text-primary">Clear</a></div>
                                </div>

                                <!-- Generator Filter -->
                                <div class="col-md-3">
                                    <select class="form-select" id="generatorFilter">
                                        <option value="">-- Select Generator --</option>
                                        @foreach ($gene as $gn)
                                            <option value="{{ $gn->id }}">({{ $gn->generator_code }}) -
                                                {{ $gn->generator_name }}</option>
                                        @endforeach
                                    </select>
                                    <div><a href="javascript:void(0)" id="clearGeneratorFilter"
                                            class="small text-primary">Clear</a></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- [ Filter ] end -->

                    <div class="card">
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th scope="col">Implant Date</th>
                                            <th scope="col">Patient</th>
                                            <th scope="col">IC Number</th>
                                            <th scope="col">Inventory Consumption Form (ICF)</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- [ Generate ICF ] end -->

            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            // DATATABLE : IMPLANT
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('manage-sales-billing') }}",
                    data: function(d) {
                        d.date_range = $('#dateRangeFilter')
                            .val();
                        d.region = $('#regionFilter')
                            .val();
                        d.hospital = $('#hospFilter')
                            .val();
                        d.generator = $('#generatorFilter')
                            .val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        className: "text-start"
                    },
                    {
                        data: 'implant_date',
                        name: 'implant_date'
                    },
                    {
                        data: 'implant_pt_name',
                        name: 'implant_pt_name',
                        className: 'avoid-long-column'
                    },
                    {
                        data: 'implant_pt_icno',
                        name: 'implant_pt_icno',
                        className: 'avoid-long-column'
                    },
                    {
                        data: 'inventory_consumption_form',
                        name: 'inventory_consumption_form',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]

            });

            /* Date Range Picker Filter */
            let datePicker = flatpickr("#dateRangeFilter", {
                mode: "range",
                dateFormat: "d M Y",
                allowInput: true,
                locale: {
                    rangeSeparator: " to "
                },
                onClose: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        $('.data-table').DataTable().ajax
                            .reload();
                    }
                }
            });

            $("#clearDateRangeFilter").click(function() {
                datePicker.clear();
                $('.data-table').DataTable().ajax.reload();
            });

            /* Region Filter */
            $('#regionFilter').on('change', function() {
                $('.data-table').DataTable().ajax
                    .reload();
            });

            $("#clearRegionFilter").click(function() {
                $('#regionFilter').val("");
                $('.data-table').DataTable().ajax.reload();
            });

            /* Hospital Filter */
            $('#hospFilter').on('change', function() {
                $('.data-table').DataTable().ajax
                    .reload();
            });

            $("#clearHospFilter").click(function() {
                $('#hospFilter').val("");
                $('.data-table').DataTable().ajax.reload();
            });

            /* Generator Filter */
            $('#generatorFilter').on('change', function() {
                $('.data-table').DataTable().ajax
                    .reload();
            });

            $("#clearGeneratorFilter").click(function() {
                $('#generatorFilter').val("");
                $('.data-table').DataTable().ajax.reload();
            });

        });
    </script>
@endsection
<!-- [ Main Content ] end -->
