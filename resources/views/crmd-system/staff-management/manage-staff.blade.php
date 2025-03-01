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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">System</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Staff</a></li>
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
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-2"
                                    data-bs-toggle="modal" data-bs-target="#addStaffModal"><i class="ti ti-plus f-18"></i>
                                    Add Staff</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Fullname</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Department</th>
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
                                                <label for="staffName" class="form-label">Fullname<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="staffName"
                                                    class="form-control @error('staff_name') is-invalid @enderror"
                                                    name="staff_name" placeholder="Fullname">
                                                @error('staff_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="staffIdno" class="form-label">ID Number</label>
                                                <input type="text" id="staffIdno"
                                                    class="form-control @error('staff_idno') is-invalid @enderror"
                                                    name="staff_idno" placeholder="ID Number">
                                                @error('staff_idno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email<span
                                                        class="text-danger">*</span></label>
                                                <input type="email" id="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" placeholder="Email">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="deps" class="form-label">Department<span
                                                        class="text-danger">*</span></label>
                                                <select name="department_id" id="deps"
                                                    class="form-select @error('department_id') is-invalid @enderror">
                                                    <option value="">Select Department</option>
                                                    @foreach ($deps as $dep)
                                                        <option value="{{ $dep->id }}">{{ $dep->department_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('department_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="role" class="form-label">Role<span
                                                        class="text-danger">*</span></label>
                                                <select name="staff_role" id="role"
                                                    class="form-select @error('staff_role') is-invalid @enderror">
                                                    <option value="">Select Role</option>
                                                    <option value="1">Administrator</option>
                                                    <option value="2">Staff</option>
                                                </select>
                                                @error('staff_role')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="staff_status" id="status"
                                                    class="form-select @error('staff_status') is-invalid @enderror">
                                                    <option value="1" selected>Active</option>
                                                    <option value="2">Inactive</option>
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
                    <!-- [ Edit Staff Modal ] start -->
                    <form action="{{ route('update-staff-post', $st->id) }}" method="POST">
                        @csrf
                        <div class="modal fade" id="updateStaffModal-{{ $st->id }}" tabindex="-1"
                            aria-labelledby="updateStaffModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateStaffModalLabel">Update Staff Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="staffName" class="form-label">Fullname<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="staffName"
                                                        class="form-control @error('staff_name') is-invalid @enderror"
                                                        name="staff_name" placeholder="Fullname"
                                                        value="{{ $st->staff_name }}">
                                                    @error('staff_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="staffIdno" class="form-label">ID Number</label>
                                                    <input type="text" id="staffIdno"
                                                        class="form-control @error('staff_idno') is-invalid @enderror"
                                                        name="staff_idno" placeholder="ID Number"
                                                        value="{{ $st->staff_idno }}">
                                                    @error('staff_idno')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email<span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" id="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" placeholder="Email" value="{{ $st->email }}">
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="deps" class="form-label">Department<span
                                                            class="text-danger">*</span></label>
                                                    <select name="department_id" id="deps"
                                                        class="form-select @error('department_id') is-invalid @enderror">
                                                        @foreach ($deps as $dep)
                                                            @if ($st->department_id == $dep->id)
                                                                <option value="{{ $dep->id }}" selected>
                                                                    {{ $dep->department_name }}</option>
                                                            @else
                                                                <option value="{{ $dep->id }}">
                                                                    {{ $dep->department_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('department_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="role" class="form-label">Role<span
                                                            class="text-danger">*</span></label>
                                                    <select name="staff_role" id="role"
                                                        class="form-select @error('staff_role') is-invalid @enderror">
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
                                                    <label for="status" class="form-label">Status</label>
                                                    <select name="staff_status" id="status"
                                                        class="form-select @error('staff_status') is-invalid @enderror">
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
                    <!-- [ Edit Staff Modal ] end -->

                    <!-- [ Delete Modal ] start -->
                    <div class="modal fade" id="deleteModal-{{ $st->id }}" data-bs-keyboard="false"
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
                                                <h2>Account Deletion</h2>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <p class="fw-normal f-18 text-center">
                                                    This action will not permanently delete the user. You can always change
                                                    the
                                                    status back to active if needed. Are you sure you want to inactive
                                                    {{ $st->staff_name }} account?
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="d-flex justify-content-center gap-3 align-items-center">
                                                <button type="reset" class="btn btn-light btn-pc-default w-50"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <a href="{{ route('delete-staff-get', $st->id) }}"
                                                    class="btn btn-danger w-100">Inactive</a>
                                            </div>
                                        </div>
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

            $(function() {

                // DATATABLE : STAFF
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    autoWidth: false, 
                    ajax: {
                        url: "{{ route('manage-staff-page') }}",
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
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
                            data: 'department',
                            name: 'department'
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

            });

        });
    </script>
@endsection
<!-- [ Main Content ] end -->
