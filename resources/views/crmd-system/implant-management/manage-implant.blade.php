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
                    <div class="card">
                        <div class="card-body">
                            <div class="d-grid gap-2 gap-md-3 d-md-flex flex-wrap">
                                <a href="{{ route('add-implant-page') }}" id="addImplantBtn"
                                    class="btn btn-primary d-inline-flex align-items-center gap-2">
                                    <i class="ti ti-plus f-18"></i>
                                    Add Implant
                                </a>
                                <a href="{{ route('export-implant-data-excel') }}" id="exportExcelBtn"
                                    class="btn btn-primary d-inline-flex align-items-center gap-2">
                                    <i class="ti ti-file-export f-18"></i>
                                    Export Data
                                </a>
                                <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-2"
                                    id="downloadMultipleDirBtn" disabled>
                                    <i class="ti ti-download f-18"></i>
                                    Download Directory (.zip)
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- [ Filter ] start -->
                            <div class="row">

                                <div class="col-sm-3 mb-3">
                                    <input type="text" class="form-control mb-2" id="dateRangeFilter"
                                        placeholder="-- Select date range --" readonly />
                                    <a href="javascript:void(0)" id="clearDateRangeFilter" class="link-primary">Clear</a>
                                </div>

                                <div class="col-sm-3 mb-3">
                                    <select class="form-select mb-2" id="regionFilter">
                                        <option value="">-- Select Region --</option>
                                        @foreach ($region as $rn)
                                            <option value="{{ $rn->id }}">{{ $rn->region_name }}</option>
                                        @endforeach
                                    </select>
                                    <a href="javascript:void(0)" id="clearRegionFilter" class="link-primary">Clear</a>
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
                                            <th><input type="checkbox" id="select-all" class="form-check-input"></th>
                                            <th scope="col">Code</th>
                                            <th scope="col">Implant Date</th>
                                            <th scope="col">Patient</th>
                                            <th scope="col">IC Number</th>
                                            <th scope="col">Implant Form</th>
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
    @endforeach

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var modalToShow = "{{ session('modal') }}"; // Ambil modal yang perlu dibuka dari session
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

            // Handle "Select All" checkbox
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

            // Handle individual checkbox selection
            $(document).on("change", ".implant-checkbox", function() {
                let id = $(this).val();
                if ($(this).prop("checked")) {
                    selectedIds.add(id);
                } else {
                    selectedIds.delete(id);
                }
                toggleDownloadButton();
            });

            // Restore checkbox states after DataTables refresh
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

            // Enable/disable the download button based on selections
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

                // Convert selected IDs to a JSON string and encode for URL
                let idsParam = encodeURIComponent(JSON.stringify(selectedIds));

                // Redirect the browser to download ZIP directly
                window.location.href = "{{ route('download-multiple-implant-directory') }}?ids=" +
                    idsParam;
            });

        });
    </script>
@endsection
<!-- [ Main Content ] end -->
