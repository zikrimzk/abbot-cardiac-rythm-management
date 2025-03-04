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
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- [ Add Doctor Modal ] start -->
                <form action="" method="POST">
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
                                                <label for="doctor_name" class="form-label">Doctor Name<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="doctor_name"
                                                    class="form-control @error('doctor_name') is-invalid @enderror"
                                                    name="doctor_name" placeholder="Enter Doctor Name" required>
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
                                                    name="doctor_phoneno" placeholder="Enter Phone Number">
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
                                                </select>
                                                @error('hospital_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="doctor_status" class="form-label">Status</label>
                                                <select name="doctor_status" id="doctor_status"
                                                    class="form-select @error('doctor_status') is-invalid @enderror">
                                                    <option value="1" selected>Active</option>
                                                    <option value="2">Inactive</option>
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

                <!-- [ Manage Doctor ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
<!-- [ Main Content ] end -->
