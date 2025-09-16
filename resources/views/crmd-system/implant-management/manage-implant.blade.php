<!-- [ Extend Layouts ] -->
@extends('crmd-system.layouts.main')

<!-- [ Main Content ] start -->
@section('content')
    <style>
        button,
        .btn {
            border-radius: 6px !important;
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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Implant</a></li>
                                <li class="breadcrumb-item" aria-current="page">Manage Implant</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Manage Implant</h2>
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
                <!-- [ Manage Implant ] start -->

                <div class="col-sm-12">

                </div>

                <div class="col-sm-12">
                    <!-- [ Option ] start -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                                <a href="{{ route('add-implant-page') }}" id="addImplantBtn"
                                    class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Add Implant">
                                    <i class="ti ti-plus f-18"></i>
                                    <span class="d-none d-md-inline">Add Implant</span>
                                </a>
                                <a href="{{ route('export-implant-data-excel') }}" id="exportExcelBtn"
                                    class="btn btn-outline-primary d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Export Data">
                                    <i class="ti ti-file-export f-18"></i>
                                    <span class="d-none d-md-inline">Export Data</span>
                                </a>
                                <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-2"
                                    id="downloadMultipleDirBtn" disabled data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Download Directory">
                                    <i class="ti ti-download f-18"></i>
                                    <span class="d-none d-md-inline">Download Directory (.zip)</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- [ Option ] end -->


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
                                            <th><input type="checkbox" id="select-all" class="form-check-input"></th>
                                            <th scope="col">Code</th>
                                            <th scope="col">Implant Date</th>
                                            <th scope="col">Patient</th>
                                            <th scope="col">IC Number</th>
                                            <th scope="col">Implant Registration Form (IRF)</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- [ Manage Implant ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    @foreach ($ims as $im)
        <!-- [ Upload Implant Form Modal ] start -->
        <form action="{{ route('upload-imbackupform-post', $im->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal fade" id="uploadBackupFormModal-{{ $im->id }}" tabindex="-1"
                aria-labelledby="updateDesignationModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Upload Implant Backup Form</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="implant_backup_form" class="form-label">Upload Implant Backup Form <span
                                        class="text-danger">*</span></label>
                                <input type="file" name="implant_backup_form"
                                    class="form-control @error('implant_backup_form') is-invalid @enderror"
                                    accept="application/pdf" required id="implant_file">
                                @error('implant_backup_form')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer justify-content-end">
                            <div class="flex-grow-1 text-end">
                                <div class="col-sm-12">
                                    <div class="d-flex justify-content-between gap-3 align-items-center">
                                        <button type="button" class="btn btn-light btn-pc-default w-100"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary w-100">Upload Form</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
        <!-- [ Upload Implant Form Modal ] end -->

        <!-- [ View Implant Log Modal ] start -->
        <div class="modal fade" id="viewImplantLogModal-{{ $im->id }}" tabindex="-1"
            aria-labelledby="implantLogModalLabel-{{ $im->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg modal-fullscreen-sm-down">
                <div class="modal-content border-0 shadow-lg">

                    <div class="modal-header bg-light border-bottom">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="modal-title mb-1" id="implantLogModalLabel-{{ $im->id }}">
                                        <i class="fas fa-history me-2"></i>
                                        <span class="d-none d-sm-inline">Implant Activity Log</span>
                                        <span class="d-sm-none">Activity Log</span>
                                    </h5>
                                    <div class="text-muted small">
                                        Ref: <strong>{{ $im->implant_refno }}</strong>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>

                    <div class="modal-body p-0">
                        @forelse($implogs->where('implant_id', $im->id)->sortByDesc('log_datetime') as $index => $implog)
                            <div class="border-bottom {{ $index === 0 ? 'bg-light' : '' }}">
                                <div class="p-3 p-md-4">
                                    <div class="row align-items-start">
                                        <div class="col-12">
                                            <div class="d-flex align-items-start mb-2">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2 me-md-3 flex-shrink-0"
                                                    style="width: 28px; height: 28px; min-width: 28px;">
                                                    <i class="fas fa-user text-white" style="font-size: 10px;"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div
                                                        class="d-flex flex-column flex-sm-row justify-content-between align-items-start">
                                                        <div class="mb-1 mb-sm-0">
                                                            <h6 class="mb-0 fw-semibold text-dark">
                                                                {{ $implog->staff_name }}</h6>
                                                            <small class="text-muted">{{ $implog->email }}</small>
                                                        </div>
                                                        <div class="text-muted text-end">
                                                            <div class="small fw-medium">
                                                                {{ \Carbon\Carbon::parse($implog->log_datetime)->format('d M Y') }}
                                                            </div>
                                                            <div class="small">
                                                                {{ \Carbon\Carbon::parse($implog->log_datetime)->format('h:i A') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ms-4 ms-md-5 ps-1 ps-md-2">
                                        <div class="card bg-white border rounded">
                                            <div class="card-body">
                                                <p class="mb-0 text-dark lh-base">{!! $implog->log_activity !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                                </div>
                                <h6 class="text-muted mb-2">No Activity Logs</h6>
                                <p class="text-muted small mb-0">No activity logs have been recorded for this implant yet.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    @if ($implogs->where('implant_id', $im->id)->count() > 0)
                        <div class="modal-footer bg-light border-top">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing {{ $implogs->where('implant_id', $im->id)->count() }} activity log(s)
                                • Most recent first
                            </small>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <!-- [ View Implant Log Modal ] end -->

        <!-- [ Send Email Modal ] start -->
        <form action="{{ route('send-implant-email-post', Crypt::encrypt($im->id)) }}" method="POST">
            @csrf
            <div class="modal fade" id="sendEmailModal-{{ $im->id }}" tabindex="-1"
                aria-labelledby="updateDesignationModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Send Email</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="email_send_to" class="form-label">Send To <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="email_send_to"
                                    class="form-control @error('email_send_to') is-invalid @enderror" required
                                    id="email_send_to" placeholder="Enter email address">
                                @error('email_send_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email_subject" class="form-label">Subject <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="email_subject"
                                    class="form-control @error('email_subject') is-invalid @enderror" required
                                    id="email_subject" placeholder="Enter email subject">
                                @error('email_subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email_message_1" class="form-label">Message <span
                                        class="text-danger">*</span></label>
                                <textarea name="email_message_1" rows="8" class="form-control @error('email_message_1') is-invalid @enderror"
                                    required id="email_message_1">
Dear DCH team,

Correction: amendment made to the device's cost.

Please assist with the SF billing for the following case. Attached are the DO, IRF, and all relevant documents for your further action.</textarea>
                                @error('email_message_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Implant Hospital</th>
                                            <td>{{ $hosp->where('id', $im->hospital_id)->first()->hospital_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Implant Date</th>
                                            <td>{{ $im->implant_date }}</td>
                                        </tr>
                                        <tr>
                                            <th>Patient Name</th>
                                            <td>{{ $im->implant_pt_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Patient IC</th>
                                            <td>{{ $im->implant_pt_icno }}</td>
                                        </tr>
                                        <tr>
                                            <th>Approval Type</th>
                                            <td>
                                                <input type="text" name="email_approval_type"
                                                    class="form-control @error('email_approval_type') is-invalid @enderror"
                                                    required id="email_approval_type"
                                                    placeholder="eg: Waiting for Teraju Farma PO">
                                                @error('email_approval_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Billing Type (B/R5)</th>
                                            <td>
                                                <input type="text" name="email_billing_type"
                                                    class="form-control @error('email_billing_type') is-invalid @enderror"
                                                    required id="email_billing_type" placeholder="eg: B or R5">
                                                @error('email_billing_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="mb-3">
                                <textarea name="email_message_2" rows="4" class="form-control @error('email_message_2') is-invalid @enderror"
                                    id="email_message_2">Dear Teraju Farma,

Kindly send the PO to DCH Auriga to proceed with SF Billing.</textarea>
                                @error('email_message_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer justify-content-end">
                            <div class="flex-grow-1 text-end">
                                <div class="col-sm-12">
                                    <div class="d-flex justify-content-between gap-3 align-items-center">
                                        <button type="button" class="btn btn-light btn-pc-default w-100"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary w-100">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
        <!-- [ Send Email Modal ] end -->
    @endforeach

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var modalToShow = "{{ session('modal') }}";
            if (modalToShow) {
                var modalElement = document.getElementById(modalToShow);
                if (modalElement) {
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            }
        });

        $(document).ready(function() {

            // DATATABLE : IMPLANT
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('manage-implant-page') }}",
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
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false,

                    },
                    {
                        data: 'implant_refno',
                        name: 'implant_refno',
                        visible: false
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
                        data: 'implant_backup_form',
                        name: 'implant_backup_form',
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

            $('#implant_file').on('change', function() {
                let file = this.files[0];

                if (file) {
                    let fileType = file.type;
                    if (fileType !== "application/pdf") {
                        alert("Only PDF files are allowed!");
                        $(this).val('');
                    }
                }
            });

            /* SELECT : MULTIPLE IMPLANT DOWNLOAD */
            const addImpBtn = $("#addImplantBtn");
            const exportExcelBtn = $("#exportExcelBtn");
            const downloadBtn = $("#downloadMultipleDirBtn");
            let selectedIds = new Set();

            $("#select-all").on("change", function() {
                let isChecked = $(this).prop("checked");

                $(".implant-checkbox").each(function() {
                    let id = $(this).val();
                    this.checked = isChecked;

                    if (isChecked) {
                        selectedIds.add(id);
                    } else {
                        selectedIds.delete(id);
                    }
                });
                toggleDownloadButton();
            });

            $(document).on("change", ".implant-checkbox", function() {
                let id = $(this).val();
                if ($(this).prop("checked")) {
                    selectedIds.add(id);
                } else {
                    selectedIds.delete(id);
                }
                toggleDownloadButton();
            });

            $('.data-table').on("draw.dt", function() {
                $(".implant-checkbox").each(function() {
                    let id = $(this).val();
                    this.checked = selectedIds.has(id);
                });

                // If all checkboxes are selected, keep "Select All" checked
                $("#select-all").prop(
                    "checked",
                    $(".implant-checkbox").length === $(".implant-checkbox:checked").length
                );

                toggleDownloadButton();
            });

            function toggleDownloadButton() {
                downloadBtn.prop("disabled", selectedIds.size === 0);
                addImpBtn.toggleClass("disabled-a", selectedIds.size !== 0);

            }

            exportExcelBtn.click(function(e) {
                e.preventDefault();

                let selectedIds = $(".implant-checkbox:checked").map(function() {
                    return $(this).val();
                }).get();

                let url = "{{ route('export-implant-data-excel') }}";

                if (selectedIds.length > 0) {
                    url += "?ids=" + selectedIds.join(",");
                }

                window.location.href = url;
            });

            downloadBtn.on("click", function() {
                let selectedIds = $(".implant-checkbox:checked")
                    .map(function() {
                        return $(this).val();
                    })
                    .get();

                if (selectedIds.length === 0) {
                    alert("Please select at least one implant.");
                    return;
                }

                let idsParam = encodeURIComponent(JSON.stringify(selectedIds));

                window.location.href = "{{ route('download-multiple-implant-directory') }}?ids=" +
                    idsParam;
            });

        });
    </script>
@endsection
<!-- [ Main Content ] end -->
