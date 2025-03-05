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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Manage Hospital</a></li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Manage Hospital</h2>
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
                <!-- [ Manage Hospital ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-2"
                                    data-bs-toggle="modal" data-bs-target="#addHospitalModal"><i
                                        class="ti ti-plus f-18"></i>
                                    Add Hospital
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
                                            <th scope="col">Hospital Code</th>
                                            <th scope="col">Hospital Name</th>
                                            <th scope="col">Visibility</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- [ Add Hospital Modal ] start -->
                <form action="{{ route('add-hospital-post') }}" method="POST">
                    @csrf
                    <div class="modal fade" id="addHospitalModal" tabindex="-1" aria-labelledby="addHospitalModal"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Add Hospital</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="hospital_name" class="form-label">Hospital Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="hospital_name"
                                                    class="form-control @error('hospital_name') is-invalid @enderror"
                                                    name="hospital_name" placeholder="Enter Hospital Name"
                                                    value="{{ old('hospital_name') }}" required>
                                                @error('hospital_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="hospital_code" class="form-label">Code <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="hospital_code"
                                                    class="form-control @error('hospital_code') is-invalid @enderror"
                                                    name="hospital_code" placeholder="Enter Hospital Code"
                                                    value="{{ old('hospital_code') }}" required>
                                                @error('hospital_code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="hospital_address" class="form-label">Address</label>
                                                <textarea name="hospital_address" id="hospital_address" rows="4"
                                                    class="form-control @error('hospital_address') is-invalid @enderror" placeholder="Enter Address">{{ old('hospital_address') }}</textarea>
                                                @error('hospital_address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="hospital_phoneno" class="form-label">Phone Number</label>
                                                <input type="text" id="hospital_phoneno"
                                                    class="form-control @error('hospital_phoneno') is-invalid @enderror"
                                                    name="hospital_phoneno" placeholder="Enter Phone Number"
                                                    value="{{ old('hospital_phoneno') }}">
                                                @error('hospital_phoneno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="hospital_visibility" class="form-label">Visibility <span
                                                    class="text-danger">*</span></label>
                                                <select name="hospital_visibility" id="hospital_visibility"
                                                    class="form-select @error('hospital_visibility') is-invalid @enderror"
                                                    required>
                                                    @if (old('hospital_visibility') == 1)
                                                        <option value="1" selected>Show</option>
                                                        <option value="2">Hide</option>
                                                    @elseif(old('hospital_visibility') == 2)
                                                        <option value="1">Show</option>
                                                        <option value="2" selected>Hide</option>
                                                    @else
                                                        <option value="1">Show</option>
                                                        <option value="2">Hide</option>
                                                    @endif
                                                </select>
                                                @error('hospital_visibility')
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
                                                    id="addApplicationBtn">Add Hospital</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <!-- [ Add Hospital Modal ] end -->

                @foreach ($hosp as $hs)
                    <!-- [ Update Hospital Modal ] start -->
                    <form action="{{ route('update-hospital-post', $hs->id) }}" method="POST">
                        @csrf
                        <div class="modal fade" id="updateHospitalModal-{{ $hs->id }}" tabindex="-1"
                            aria-labelledby="updateHospitalModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Hospital</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="hospital_name" class="form-label">Hospital Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="hospital_name"
                                                        class="form-control @error('hospital_name') is-invalid @enderror"
                                                        name="hospital_name" placeholder="Enter Hospital Name"
                                                        value="{{ $hs->hospital_name }}" required>
                                                    @error('hospital_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="hospital_code" class="form-label">Code <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="hospital_code"
                                                        class="form-control @error('hospital_code') is-invalid @enderror"
                                                        name="hospital_code" placeholder="Enter Hospital Code"
                                                        value="{{ $hs->hospital_code }}" required>
                                                    @error('hospital_code')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="hospital_address" class="form-label">Address</label>
                                                    <textarea name="hospital_address" id="hospital_address" rows="4"
                                                        class="form-control @error('hospital_address') is-invalid @enderror" placeholder="Enter Address">{{ $hs->hospital_address }}</textarea>
                                                    @error('hospital_address')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="hospital_phoneno" class="form-label">Phone Number</label>
                                                    <input type="text" id="hospital_phoneno"
                                                        class="form-control @error('hospital_phoneno') is-invalid @enderror"
                                                        name="hospital_phoneno" placeholder="Enter Phone Number"
                                                        value="{{ $hs->hospital_phoneno }}">
                                                    @error('hospital_phoneno')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="hospital_visibility" class="form-label">Visibility <span
                                                        class="text-danger">*</span></label>
                                                    <select name="hospital_visibility" id="hospital_visibility"
                                                        class="form-select @error('hospital_visibility') is-invalid @enderror"
                                                        required>
                                                        @if ($hs->hospital_visibility == 1)
                                                            <option value="1" selected>Show</option>
                                                            <option value="2">Hide</option>
                                                        @elseif($hs->hospital_visibility == 2)
                                                            <option value="1">Show</option>
                                                            <option value="2" selected>Hide</option>
                                                        @endif
                                                    </select>
                                                    @error('hospital_visibility')
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
                                                        id="updateApplicationBtn">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- [ Update Hospital Modal ] end -->

                    <!-- [ Details Hospital Modal ] start -->
                    <div class="modal fade" id="detailsModal-{{ $hs->id }}" tabindex="-1"
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

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="hospital_visibility" class="form-label">Visibility</label>
                                                <select id="hospital_visibility" class="form-select" readonly>
                                                    @if ($hs->hospital_visibility == 1)
                                                        <option value="1" selected>Show</option>
                                                    @elseif($hs->hospital_visibility == 2)
                                                        <option value="2" selected>Hide</option>
                                                    @endif
                                                </select>
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

                    <!-- [ Delete Modal ] start -->
                    <div class="modal fade" id="deleteModal-{{ $hs->id }}" data-bs-keyboard="false"
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
                                                <a href="{{ route('delete-hospital-get', $hs->id) }}"
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

                <!-- [ Manage Hospital ] end -->
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

                // DATATABLE : HOSPITAL
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    autoWidth: false,
                    ajax: {
                        url: "{{ route('manage-hospital-page') }}",
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
                        },
                        {
                            data: 'hospital_code',
                            name: 'hospital_code'
                        },
                        {
                            data: 'hospital_name',
                            name: 'hospital_name',
                            className: "avoid-long-column"

                        },
                        {
                            data: 'hospital_visibility',
                            name: 'hospital_visibility'
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
