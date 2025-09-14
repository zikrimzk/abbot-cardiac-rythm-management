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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">User</a></li>
                                <li class="breadcrumb-item" aria-current="page">Manage Staff</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Manage Staff</h2>
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
                <!-- [ Manage Staff ] start -->

                <div class="col-sm-12">

                    <!-- [ Option ] start -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addStaffModal"
                                    class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Add Staff">
                                    <i class="ti ti-plus f-18"></i>
                                    <span class="d-none d-md-inline">Add Staff</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- [ Option ] end -->


                    <!-- [ Filter ] start -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <select class="form-select" id="designationFilter">
                                        <option value="">-- Select Designation --</option>
                                        @foreach ($des as $dep)
                                            <option value="{{ $dep->id }}">{{ $dep->designation_name }}</option>
                                        @endforeach
                                    </select>
                                    <small>
                                        <a href="javascript:void(0)" id="clearDesignationFilter"
                                            class="link-primary">Clear</a>
                                    </small>
                                </div>

                                <div class="col-md-4">
                                    <select class="form-select" id="roleFilter">
                                        <option value="">-- Select Role --</option>
                                        <option value="1">Administrator</option>
                                        <option value="2">Staff</option>
                                    </select>
                                    <small>
                                        <a href="javascript:void(0)" id="clearRoleFilter" class="link-primary">Clear</a>
                                    </small>
                                </div>

                                <div class="col-md-4">
                                    <select class="form-select" id="statusFilter">
                                        <option value="">-- Select Status --</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                    <small>
                                        <a href="javascript:void(0)" id="clearStatusFilter" class="link-primary">Clear</a>
                                    </small>
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
                                            <th scope="col">#</th>
                                            <th scope="col">Fullname</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Designation</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- [ Add Staff Modal ] start -->
                <form action="{{ route('add-staff-post') }}" method="POST">
                    @csrf
                    <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModal"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="addStaffModalLabel">Add Staff</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="staffName" class="form-label">Fullname <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="staffName"
                                                    class="form-control @error('staff_name') is-invalid @enderror"
                                                    name="staff_name" placeholder="Fullname"
                                                    value="{{ old('staff_name') }}" required>
                                                @error('staff_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="staffIdno" class="form-label">IC Number <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="staffIdno"
                                                    class="form-control ic-input @error('staff_idno') is-invalid @enderror"
                                                    name="staff_idno" placeholder="IC Number"
                                                    value="{{ old('staff_idno') }}" maxlength="14"
                                                    pattern="\d{6}-\d{2}-\d{4}" required>
                                                @error('staff_idno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="email" id="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" placeholder="Email" value="{{ old('email') }}"
                                                    required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="des" class="form-label">Designation <span
                                                        class="text-danger">*</span></label>
                                                <select name="designation_id" id="des"
                                                    class="form-select @error('designation_id') is-invalid @enderror"
                                                    required>
                                                    <option value="">Select Designation</option>
                                                    @foreach ($des as $dep)
                                                        @if (old('designation_id') == $dep->id)
                                                            <option value="{{ $dep->id }}" selected>
                                                                {{ $dep->designation_name }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $dep->id }}">
                                                                {{ $dep->designation_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('designation_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="role" class="form-label">Role <span
                                                        class="text-danger">*</span></label>
                                                <select name="staff_role" id="role"
                                                    class="form-select @error('staff_role') is-invalid @enderror" required>
                                                    <option value="">Select Role</option>
                                                    @if (old('staff_role') == 1)
                                                        <option value="1" selected>Administrator</option>
                                                        <option value="2">Staff</option>
                                                    @elseif(old('staff_role') == 2)
                                                        <option value="1">Administrator</option>
                                                        <option value="2" selected>Staff</option>
                                                    @else
                                                        <option value="1">Administrator</option>
                                                        <option value="2">Staff</option>
                                                    @endif
                                                </select>
                                                @error('staff_role')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status <span
                                                        class="text-danger">*</span></label>
                                                <select name="staff_status" id="status"
                                                    class="form-select @error('staff_status') is-invalid @enderror"
                                                    required>
                                                    @if (old('staff_status') == 1)
                                                        <option value="1" selected>Active</option>
                                                        <option value="2">Inactive</option>
                                                    @elseif(old('staff_status') == 2)
                                                        <option value="1">Active</option>
                                                        <option value="2" selected>Inactive</option>
                                                    @else
                                                        <option value="1">Active</option>
                                                        <option value="2">Inactive</option>
                                                    @endif
                                                </select>
                                                @error('staff_status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="modal-footer justify-content-end">
                                    <div class="flex-grow-1 text-end">
                                        <div class="col-sm-12">
                                            <div class="d-flex justify-content-between gap-3 align-items-center">
                                                <button type="button" class="btn btn-light btn-pc-default w-100"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary w-100"
                                                    id="addApplicationBtn">Add Staff</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <!-- [ Add Staff Modal ] end -->

                @foreach ($sts as $st)
                    <!-- [ Update Staff Modal ] start -->
                    <form action="{{ route('update-staff-post', $st->id) }}" method="POST">
                        @csrf
                        <div class="modal fade" id="updateStaffModal-{{ $st->id }}" tabindex="-1"
                            aria-labelledby="updateStaffModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Staff</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="staffName" class="form-label">Fullname <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="staffName"
                                                        class="form-control @error('staff_name') is-invalid @enderror"
                                                        name="staff_name" placeholder="Fullname"
                                                        value="{{ $st->staff_name }}" required>
                                                    @error('staff_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="staffIdno" class="form-label">IC Number <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="staffIdno"
                                                        class="form-control ic-input @error('staff_idno') is-invalid @enderror"
                                                        name="staff_idno" placeholder="IC Number"
                                                        value="{{ $st->staff_idno }}" maxlength="14"
                                                        pattern="\d{6}-\d{2}-\d{4}" required>
                                                    @error('staff_idno')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" id="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" placeholder="Email" value="{{ $st->email }}"
                                                        required>
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="des" class="form-label">Designation <span
                                                            class="text-danger">*</span></label>
                                                    <select name="designation_id" id="des"
                                                        class="form-select @error('designation_id') is-invalid @enderror"
                                                        required>
                                                        @foreach ($des as $dep)
                                                            @if ($st->designation_id == $dep->id)
                                                                <option value="{{ $dep->id }}" selected>
                                                                    {{ $dep->designation_name }}</option>
                                                            @else
                                                                <option value="{{ $dep->id }}">
                                                                    {{ $dep->designation_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('designation_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="role" class="form-label">Role <span
                                                            class="text-danger">*</span></label>
                                                    <select name="staff_role" id="role"
                                                        class="form-select @error('staff_role') is-invalid @enderror"
                                                        required>
                                                        @if ($st->staff_role == 1)
                                                            <option value="1" selected>Administrator</option>
                                                            <option value="2">Staff</option>
                                                        @elseif($st->staff_role == 2)
                                                            <option value="1">Administrator</option>
                                                            <option value="2" selected>Staff</option>
                                                        @endif
                                                    </select>
                                                    @error('staff_role')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status <span
                                                            class="text-danger">*</span></label>
                                                    <select name="staff_status" id="status"
                                                        class="form-select @error('staff_status') is-invalid @enderror"
                                                        required>
                                                        @if ($st->staff_status == 1)
                                                            <option value="1" selected>Active</option>
                                                            <option value="2">Inactive</option>
                                                        @elseif ($st->staff_status == 2)
                                                            <option value="1">Active</option>
                                                            <option value="2" selected>Inactive</option>
                                                        @endif
                                                    </select>
                                                    @error('staff_status')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer justify-content-end">
                                        <div class="flex-grow-1 text-end">
                                            <div class="col-sm-12">
                                                <div class="d-flex justify-content-between gap-3 align-items-center">
                                                    <button type="button" class="btn btn-light btn-pc-default w-100"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary w-100"
                                                        id="addApplicationBtn">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- [ Update Staff Modal ] end -->

                    <!-- [ Delete Modal ] start -->
                    <div class="modal fade" id="deleteModal-{{ $st->id }}" data-bs-keyboard="false"
                        tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg rounded-3">
                                <div class="modal-body p-5">
                                    <!-- Icon -->
                                    <div class="text-center mb-4">
                                        <i class="ti ti-user-off text-danger" style="font-size: 80px;"></i>
                                    </div>

                                    <!-- Title -->
                                    <div class="text-center mb-3">
                                        <h4 class="fw-bold text-dark">Account Inactivation</h4>
                                        <p class="text-muted mb-0">
                                            This won't permanently delete the account. You can always set it back to active
                                            later.
                                        </p>
                                    </div>

                                    <!-- User Info -->
                                    <div class="text-center mt-3 mb-3">
                                        <p class="fw-normal text-dark">
                                            Are you sure you want to inactivate <strong>{{ $st->staff_name }}</strong>'s
                                            account?
                                        </p>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-center gap-3 mt-4">
                                        <button type="button" class="btn btn-outline-secondary w-50"
                                            data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                        <a href="{{ route('delete-staff-get', $st->id) }}" class="btn btn-danger w-50">
                                            Inactivate
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Delete Modal ] end -->
                @endforeach

                <!-- [ Manage Staff ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

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

            // DATATABLE : STAFF
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('manage-staff-page') }}",
                    data: function(d) {
                        d.designation = $('#designationFilter')
                            .val();
                        d.role = $('#roleFilter')
                            .val();
                        d.status = $('#statusFilter')
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
                        data: 'staff_name',
                        name: 'staff_name',
                        className: "avoid-long-column"
                    },
                    {
                        data: 'email',
                        name: 'email',
                        className: "avoid-long-column"

                    },
                    {
                        data: 'designation',
                        name: 'designation'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]

            });

            /* Region Filter */
            $('#designationFilter').on('change', function() {
                $('.data-table').DataTable().ajax
                    .reload();
            });

            $("#clearDesignationFilter").click(function() {
                $('#designationFilter').val("");
                $('.data-table').DataTable().ajax.reload();
            });

            /* Hospital Filter */
            $('#roleFilter').on('change', function() {
                $('.data-table').DataTable().ajax
                    .reload();
            });

            $("#clearRoleFilter").click(function() {
                $('#roleFilter').val("");
                $('.data-table').DataTable().ajax.reload();
            });

            /* Generator Filter */
            $('#statusFilter').on('change', function() {
                $('.data-table').DataTable().ajax
                    .reload();
            });

            $("#clearStatusFilter").click(function() {
                $('#statusFilter').val("");
                $('.data-table').DataTable().ajax.reload();
            });

            $(".ic-input").on("input", function() {
                let val = $(this).val().replace(/\D/g, ""); // remove non-digits
                if (val.length > 12) val = val.slice(0, 12); // max 12 digits only

                let formatted = "";
                if (val.length > 6) {
                    formatted = val.substring(0, 6) + "-" + val.substring(6);
                } else {
                    formatted = val;
                }
                if (val.length > 8) {
                    formatted = formatted.substring(0, 9) + "-" + formatted.substring(9);
                }

                $(this).val(formatted);
            });

        });
    </script>
@endsection
<!-- [ Main Content ] end -->
