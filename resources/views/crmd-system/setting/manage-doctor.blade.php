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

                    <!-- [ Option ] start -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addDoctorModal"
                                    class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Add Doctor">
                                    <i class="ti ti-plus f-18"></i>
                                    <span class="d-none d-md-inline">Add Doctor</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- [ Option ] end -->

                    <div class="card">
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Doctor Name</th>
                                            <th scope="col">Phone Number</th>
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
                                                    class="form-control input-phone @error('doctor_phoneno') is-invalid @enderror"
                                                    name="doctor_phoneno" placeholder="Enter Phone Number"
                                                    value="{{ old('doctor_phoneno') }}">
                                                @error('doctor_phoneno')
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
                                                        class="form-control input-phone @error('doctor_phoneno') is-invalid @enderror"
                                                        name="doctor_phoneno" placeholder="Enter Phone Number"
                                                        value="{{ $doc->doctor_phoneno }}">
                                                    @error('doctor_phoneno')
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
                                                        id="updateApplicationBtn">Save changes</button>
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
                        tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg rounded-3">
                                <div class="modal-body p-5">
                                    <div class="text-center mb-4">
                                        <i class="ti ti-trash text-danger" style="font-size: 80px;"></i>
                                    </div>
                                    <div class="text-center mb-2">
                                        <h4 class="fw-bold text-dark">Are you sure?</h4>
                                        <p class="text-muted mb-0">This action cannot be undone.</p>
                                    </div>

                                    <div class="d-flex justify-content-center gap-3 mt-4">
                                        <button type="button" class="btn btn-outline-secondary w-50"
                                            data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                        <a href="{{ route('delete-doctor-get', $doc->id) }}"
                                            class="btn btn-danger w-50">
                                            Delete Anyways
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Delete Modal ] end -->
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

            // DATATABLE : DOCTOR
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('manage-doctor-page') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        className: "text-start"
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


            /*********************************************************/
            /********************INPUT FORMATTING*********************/
            /*********************************************************/

            function formatMalaysiaNumber(input) {
                let numbers = input.replace(/\D/g, '');

                if (numbers.startsWith('60')) {
                    numbers = '+' + numbers;
                } else if (numbers.startsWith('0')) {
                    numbers = '+60' + numbers.substring(1);
                } else if (/^1/.test(numbers)) {
                    numbers = '+60' + numbers;
                } else if (numbers.length > 0) {
                    numbers = '+60' + numbers;
                }

                if (numbers.startsWith('+60') && numbers.length > 3) {
                    const digits = numbers.substring(3);
                    if (digits.length >= 2 && digits.length <= 3) {
                        numbers = '+60 ' + digits;
                    } else if (digits.length >= 4 && digits.length <= 7) {
                        numbers = '+60 ' + digits.substring(0, 2) + '-' + digits.substring(2);
                    } else if (digits.length >= 8) {
                        numbers = '+60 ' + digits.substring(0, 2) + '-' + digits.substring(2, 5) + ' ' + digits
                            .substring(5,
                                10);
                    }
                }

                return numbers;
            }

            $('.input-phone').on('input', function() {
                const input = $(this);
                const cursorPos = input[0].selectionStart;
                const originalLength = input.val().length;

                const formatted = formatMalaysiaNumber(input.val());
                input.val(formatted);
                const newLength = formatted.length;
                const cursorOffset = newLength - originalLength;
                input[0].setSelectionRange(cursorPos + cursorOffset, cursorPos + cursorOffset);
            });

            $('.input-phone').on('blur', function() {
                const input = $(this);
                let value = input.val().trim();

                value = value.replace(/\s+$/, '');
                input.val(value);
            });

        });
    </script>
@endsection
<!-- [ Main Content ] end -->
