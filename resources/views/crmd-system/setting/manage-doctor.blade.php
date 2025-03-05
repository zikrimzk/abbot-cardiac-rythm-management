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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Hospital & Doctor</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Manage Doctor</a></li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Manage Doctor</h2>
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
                <!-- [ Manage Doctor ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-2"
                                    data-bs-toggle="modal" data-bs-target="#addDoctorModal"><i class="ti ti-plus f-18"></i>
                                    Add Doctor
                                </button>
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
                                            <th scope="col">Name</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">Hospital</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- [ Add Doctor Modal ] start -->
                <form action="{{ route('add-doctor-post') }}" method="POST">
                    @csrf
                    <div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorModal"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="addStaffModalLabel">Add Doctor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="doctor_name" class="form-label">Doctor Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="doctor_name"
                                                    class="form-control @error('doctor_name') is-invalid @enderror"
                                                    name="doctor_name" placeholder="Enter Doctor Name"
                                                    value="{{ old('doctor_name') }}" required>
                                                @error('doctor_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="doctor_phoneno" class="form-label">Phone Number</label>
                                                <input type="text" id="doctor_phoneno"
                                                    class="form-control @error('doctor_phoneno') is-invalid @enderror"
                                                    name="doctor_phoneno" placeholder="Enter Phone Number"
                                                    value="{{ old('doctor_phoneno') }}">
                                                @error('doctor_phoneno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="hospital_id" class="form-label">Hospital <span
                                                        class="text-danger">*</span></label>
                                                <select name="hospital_id" id="hospital_id"
                                                    class="form-select @error('hospital_id') is-invalid @enderror" required>
                                                    <option value="" selected>Select Hospital</option>
                                                    @foreach ($hosp as $hs)
                                                        @if (old('hospital_id') == $hs->id)
                                                            <option value="{{ $hs->id }}" selected>
                                                                {{ $hs->hospital_name }}</option>
                                                        @else
                                                            <option value="{{ $hs->id }}">{{ $hs->hospital_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('hospital_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="doctor_status" class="form-label">Status <span
                                                        class="text-danger">*</span></label>
                                                <select name="doctor_status" id="doctor_status"
                                                    class="form-select @error('doctor_status') is-invalid @enderror"
                                                    required>
                                                    @if (old('doctor_status') == 1)
                                                        <option value="1" selected>Active</option>
                                                        <option value="2">Inactive</option>
                                                    @elseif(old('doctor_status') == 2)
                                                        <option value="1">Active</option>
                                                        <option value="2" selected>Inactive</option>
                                                    @else
                                                        <option value="1">Active</option>
                                                        <option value="2">Inactive</option>
                                                    @endif
                                                </select>
                                                @error('doctor_status')
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
                                                    id="addApplicationBtn">Add Doctor</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <!-- [ Add Doctor Modal ] end -->

                @foreach ($docs as $doc)
                    <!-- [ Update Doctor Modal ] start -->
                    <form action="{{ route('update-doctor-post', $doc->id) }}" method="POST">
                        @csrf
                        <div class="modal fade" id="updateDoctorModal-{{ $doc->id }}" tabindex="-1"
                            aria-labelledby="updateDoctorModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Doctor Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="doctor_name" class="form-label">Doctor Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="doctor_name"
                                                        class="form-control @error('doctor_name') is-invalid @enderror"
                                                        name="doctor_name" placeholder="Enter Doctor Name"
                                                        value="{{ $doc->doctor_name }}" required>
                                                    @error('doctor_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="doctor_phoneno" class="form-label">Phone Number</label>
                                                    <input type="text" id="doctor_phoneno"
                                                        class="form-control @error('doctor_phoneno') is-invalid @enderror"
                                                        name="doctor_phoneno" placeholder="Enter Phone Number"
                                                        value="{{ $doc->doctor_phoneno }}">
                                                    @error('doctor_phoneno')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="hospital_id" class="form-label">Hospital <span
                                                            class="text-danger">*</span></label>
                                                    <select name="hospital_id" id="hospital_id"
                                                        class="form-select @error('hospital_id') is-invalid @enderror"
                                                        required>
                                                        @foreach ($hosp as $hs)
                                                            @if ($doc->hospital_id == $hs->id)
                                                                <option value="{{ $hs->id }}" selected>
                                                                    {{ $hs->hospital_name }}</option>
                                                            @else
                                                                <option value="{{ $hs->id }}">
                                                                    {{ $hs->hospital_name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('hospital_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="doctor_status" class="form-label">Status <span
                                                            class="text-danger">*</span></label>
                                                    <select name="doctor_status" id="doctor_status"
                                                        class="form-select @error('doctor_status') is-invalid @enderror"
                                                        required>
                                                        @if ($doc->doctor_status == 1)
                                                            <option value="1" selected>Active</option>
                                                            <option value="2">Inactive</option>
                                                        @elseif($doc->doctor_status == 2)
                                                            <option value="1">Active</option>
                                                            <option value="2" selected>Inactive</option>
                                                        @else
                                                            <option value="1">Active</option>
                                                            <option value="2">Inactive</option>
                                                        @endif
                                                    </select>
                                                    @error('doctor_status')
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
                                                        id="updateApplicationBtn">Update Doctor</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- [ Update Doctor Modal ] end -->

                    <!-- [ Delete Modal ] start -->
                    <div class="modal fade" id="deleteModal-{{ $doc->id }}" data-bs-keyboard="false"
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
                                                <a href="{{ route('delete-doctor-get', $doc->id) }}"
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

                @foreach ($hosp as $hs)
                    <!-- [ Details Hospital Modal ] start -->
                    <div class="modal fade" id="detailHospitalModal-{{ $hs->id }}" tabindex="-1"
                        aria-labelledby="updateHospitalModal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Hospital Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="hospital_name" class="form-label">Hospital Name</label>
                                                <input type="text" id="hospital_name" class="form-control"
                                                    value="{{ $hs->hospital_name }}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="hospital_code" class="form-label">Code</label>
                                                <input type="text" id="hospital_code" class="form-control"
                                                    value="{{ $hs->hospital_code }}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="hospital_address" class="form-label">Address</label>
                                                <textarea id="hospital_address" rows="4" class="form-control" placeholder="Empty" readonly>{{ $hs->hospital_address }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="hospital_phoneno" class="form-label">Phone Number</label>
                                                <input type="text" id="hospital_phoneno" class="form-control"
                                                    placeholder="Empty" value="{{ $hs->hospital_phoneno }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer justify-content-end">
                                    <div class="flex-grow-1 text-end">
                                        <div class="col-sm-12">
                                            <div class="d-flex justify-content-between gap-3 align-items-center">
                                                <button type="button" class="btn btn-light btn-pc-default w-100"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- [ Details Hospital Modal ] end -->
                @endforeach


                <!-- [ Manage Doctor ] end -->
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

            $(function() {

                // DATATABLE : DOCTOR
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    autoWidth: false,
                    ajax: {
                        url: "{{ route('manage-doctor-page') }}",
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
                        },
                        {
                            data: 'doctor_name',
                            name: 'doctor_name',
                            className: "avoid-long-column"

                        },
                        {
                            data: 'doctor_phoneno',
                            name: 'doctor_phoneno'

                        },
                        {
                            data: 'hospital_code',
                            name: 'hospital_code'
                        },
                        {
                            data: 'doctor_status',
                            name: 'doctor_status'
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
