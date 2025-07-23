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
                    <!-- [ Option ] start -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addHospitalModal"
                                    class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Add Hospital">
                                    <i class="ti ti-plus f-18"></i>
                                    <span class="d-none d-md-inline">Add Hospital</span>
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
                                                    class="form-control input-code @error('hospital_code') is-invalid @enderror"
                                                    name="hospital_code" placeholder="e.g., HSIS, HBM, IJN"
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
                                                    class="form-control input-phone @error('hospital_phoneno') is-invalid @enderror"
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
                                                        class="form-control input-code @error('hospital_code') is-invalid @enderror"
                                                        name="hospital_code" placeholder="e.g., HSIS, HBM, IJN"
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
                                                        class="form-control input-phone @error('hospital_phoneno') is-invalid @enderror"
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
                                        <a href="{{ route('delete-hospital-get', $hs->id) }}"
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

            // DATATABLE : HOSPITAL
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('manage-hospital-page') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        className: "text-start"
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

            $('.input-code').on('input', function() {
                this.value = this.value.toUpperCase();
            });

        });
    </script>
@endsection
<!-- [ Main Content ] end -->
