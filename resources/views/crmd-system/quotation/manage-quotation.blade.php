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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Quotation</a></li>
                                <li class="breadcrumb-item" aria-current="page">Manage Quotation</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Manage Quotation</h2>
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
                <!-- [ Manage Quotation ] start -->

                <!-- [ Option ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                                <a href="{{ route('generate-quotation-page') }}"
                                    class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Generate Quotation">
                                    <i class="ti ti-plus f-18"></i>
                                    <span class="d-none d-md-inline">Generate Quotation</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ Option ] end -->

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">

                            <!-- [ Filter ] start -->
                            <div class="row">

                                <div class="col-sm-3 mb-3">
                                    <input type="text" class="form-control mb-2" id="dateRangeFilter"
                                        placeholder="Start Date to End Date" readonly />
                                    <a href="javascript:void(0)" id="clearDateRangeFilter" class="link-primary">Clear</a>
                                </div>

                                <div class="col-sm-3 mb-3">
                                    <select class="form-select mb-2" id="compFilter">
                                        <option value="">-- Select Company --</option>
                                        @foreach ($comps as $comp)
                                            <option value="{{ $comp->id }}">({{ $comp->company_code }}) -
                                                {{ $comp->company_name }}</option>
                                        @endforeach
                                    </select>
                                    <a href="javascript:void(0)" id="clearCompFilter" class="link-primary">Clear</a>
                                </div>

                                <div class="col-sm-3 mb-3">
                                    <select class="form-select mb-2" id="hospFilter">
                                        <option value="">-- Select Hospital --</option>
                                        @foreach ($hosp as $h)
                                            <option value="{{ $h->id }}">({{ $h->hospital_code }}) -
                                                {{ $h->hospital_name }}</option>
                                        @endforeach
                                    </select>
                                    <a href="javascript:void(0)" id="clearHospFilter" class="link-primary">Clear</a>
                                </div>

                                <div class="col-sm-3 mb-3">
                                    <select class="form-select mb-2" id="generatorFilter">
                                        <option value="">-- Select Generator --</option>
                                        @foreach ($gene as $gn)
                                            <option value="{{ $gn->id }}">({{ $gn->generator_code }}) -
                                                {{ $gn->generator_name }}</option>
                                        @endforeach
                                    </select>
                                    <a href="javascript:void(0)" id="clearGeneratorFilter" class="link-primary">Clear</a>
                                </div>

                            </div>
                            <!-- [ Filter ] end -->
                            
                            <div class="dt-responsive table-responsive">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Company</th>
                                            <th scope="col">Hospital</th>
                                            <th scope="col">Patient</th>
                                            <th scope="col">Quotation</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>



                @foreach ($quotations as $quo)
                    <!-- [ Delete Modal ] start -->
                    <div class="modal fade" id="deleteQuotationModal-{{ $quo->id }}" data-bs-keyboard="false"
                        tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12 mb-4">
                                            <div class="d-flex justify-content-center align-items-center mb-3">
                                                <i class="ti ti-trash text-danger" style="font-size: 100px"></i>
                                            </div>

                                        </div>
                                        <div class="col-sm-12">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <h2>Are you sure ?</h2>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <p class="fw-normal f-18 text-center">This action cannot be undone.</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="d-flex justify-content-between gap-3 align-items-center">
                                                <button type="reset" class="btn btn-light btn-pc-default w-50"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <a href="{{ route('delete-quotation-get', ['id' => Crypt::encrypt($quo->id)]) }}"
                                                    class="btn btn-danger w-100">Delete Anyways</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Delete Modal ] end -->
                @endforeach

                <!-- [ Manage Quotation ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {


            // DATATABLE : QUOTATION
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('manage-quotation-page') }}",
                    data: function(d) {
                        d.date_range = $('#dateRangeFilter')
                            .val();
                        d.company = $('#compFilter')
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
                        data: 'quotation_date',
                        name: 'quotation_date'
                    },

                    {
                        data: 'quotation_company',
                        name: 'quotation_company'
                    },
                    {
                        data: 'quotation_hospital',
                        name: 'quotation_hospital'
                    },
                    {
                        data: 'quotation_pt',
                        name: 'quotation_pt',
                        className: 'avoid-long-column'
                    },
                    {
                        data: 'quotation_file',
                        name: 'quotation_file'
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

            /* Company Filter */
            $('#compFilter').on('change', function() {
                $('.data-table').DataTable().ajax
                    .reload();
            });

            $("#clearCompFilter").click(function() {
                $('#compFilter').val("");
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
