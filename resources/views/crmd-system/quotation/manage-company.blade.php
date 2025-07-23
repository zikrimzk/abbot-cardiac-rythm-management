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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Quotation</a></li>
                                <li class="breadcrumb-item" aria-current="page">Manage Company</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Manage Company</h2>
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
                <!-- [ Assign Generator & Model ] start -->

                <!-- [ Option ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                                <button type="button" id="addCompanyBtn" data-bs-toggle="modal"
                                    data-bs-target="#addCompanyModal"
                                    class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Add Company">
                                    <i class="ti ti-plus f-18"></i>
                                    <span class="d-none d-md-inline">Add Company</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ Option ] end -->

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Code</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- [ Add Company Modal ] start -->
                <form action="{{ route('add-company-post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal fade" id="addCompanyModal" tabindex="-1" aria-labelledby="addAssignment"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="addAssignmentLabel">Add Company</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">

                                        <!-- Company Code -->
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="company_code" class="form-label">Company Code <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="company_code"
                                                    class="form-control @error('company_code') is-invalid @enderror uppercase-no-symbols"
                                                    id="company_code" placeholder="Enter Company Code"
                                                    value="{{ old('company_code') }}" required>
                                                @error('company_code')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Company Name -->
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="company_name" class="form-label">Company Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="company_name"
                                                    class="form-control @error('company_name') is-invalid @enderror uppercase"
                                                    id="company_name" placeholder="Enter Company Name"
                                                    value="{{ old('company_name') }}" required>
                                                @error('company_name')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Company Registration No (SSM) -->
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="company_ssm" class="form-label">Company Registration No (SSM)
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" name="company_ssm"
                                                    class="form-control @error('company_ssm') is-invalid @enderror uppercase"
                                                    id="company_ssm" placeholder="Enter Company Registration No"
                                                    value="{{ old('company_ssm') }}" required>
                                                @error('company_ssm')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Company Address -->
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="company_address" class="form-label">Company Address
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <textarea name="company_address" id="company_address"
                                                    class="form-control @error('company_address') is-invalid @enderror" cols="30" rows="4"
                                                    placeholder="Enter Company Address" required>{{ old('company_address') }}</textarea>
                                                @error('company_address')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Company Website -->
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="company_website" class="form-label">Company Website</label>
                                                <input type="text" name="company_website"
                                                    class="form-control @error('company_website') is-invalid @enderror"
                                                    id="company_website" placeholder="Enter Company Website"
                                                    value="{{ old('company_website') }}">
                                                @error('company_website')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Company Email -->
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="company_email" class="form-label">Company Email</label>
                                                <input type="text" name="company_email"
                                                    class="form-control @error('company_email') is-invalid @enderror"
                                                    id="company_email" placeholder="Enter Company Email"
                                                    value="{{ old('company_email') }}">
                                                @error('company_email')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Company Phone No -->
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="company_phoneno" class="form-label">Company Phone No</label>
                                                <input type="text" name="company_phoneno"
                                                    class="form-control input-phone @error('company_phoneno') is-invalid @enderror"
                                                    id="company_phoneno" placeholder="Enter Company Phone No"
                                                    value="{{ old('company_phoneno') }}">
                                                @error('company_phoneno')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Company Fax -->
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="company_fax" class="form-label">Company Fax</label>
                                                <input type="text" name="company_fax"
                                                    class="form-control input-phone @error('company_fax') is-invalid @enderror"
                                                    id="company_fax" placeholder="Enter Company Fax"
                                                    value="{{ old('company_fax') }}">
                                                @error('company_fax')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Company Logo -->
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="company_logo" class="form-label">Company Logo <span
                                                        class="text-danger">*</span></label>
                                                <input type="file" name="company_logo"
                                                    class="form-control @error('company_logo') is-invalid @enderror"
                                                    id="company_logo" accept="image/*" required>

                                                <img id="logoPreview" src="#" alt="Logo Preview"
                                                    style="display:none; margin-top:10px; max-height:150px;" />

                                                @error('company_logo')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
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
                                                    id="addApplicationBtn">Add Company</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <!-- [ Add Company Modal ] end -->


                @foreach ($companies as $comp)
                    <!-- [ Update Company Modal ] start -->
                    <form action="{{ route('update-company-post', ['id' => Crypt::encrypt($comp->id)]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal fade" id="updateCompanyModal-{{ $comp->id }}" tabindex="-1"
                            aria-labelledby="updateCompanyModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addAssignmentLabel">Update Company</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="company_code_up_{{ $comp->id }}"
                                                        class="form-label">Company Code <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="company_code_up"
                                                        id="company_code_up_{{ $comp->id }}"
                                                        class="form-control @error('company_code_up') is-invalid @enderror uppercase-no-symbols"
                                                        placeholder="Enter Company Code"
                                                        value="{{ $comp->company_code }}" required>
                                                    @error('company_code_up')
                                                        <span class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="company_name_up_{{ $comp->id }}"
                                                        class="form-label">Company Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="company_name_up"
                                                        id="company_name_up_{{ $comp->id }}"
                                                        class="form-control @error('company_name_up') is-invalid @enderror uppercase"
                                                        placeholder="Enter Company Name"
                                                        value="{{ $comp->company_name }}" required>
                                                    @error('company_name_up')
                                                        <span class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="company_ssm_up_{{ $comp->id }}"
                                                        class="form-label">Company Registration No (SSM) <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="company_ssm_up"
                                                        id="company_ssm_up_{{ $comp->id }}"
                                                        class="form-control @error('company_ssm_up') is-invalid @enderror uppercase"
                                                        placeholder="Enter Company Registration No"
                                                        value="{{ $comp->company_ssm }}" required>
                                                    @error('company_ssm_up')
                                                        <span class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="company_address_up_{{ $comp->id }}"
                                                        class="form-label">Company Address <span
                                                            class="text-danger">*</span></label>
                                                    <textarea name="company_address_up" id="company_address_up_{{ $comp->id }}"
                                                        class="form-control @error('company_address_up') is-invalid @enderror" placeholder="Enter Company Address"
                                                        rows="4" required>{{ $comp->company_address }}</textarea>
                                                    @error('company_address_up')
                                                        <span class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="company_website_up_{{ $comp->id }}"
                                                        class="form-label">Company Website</label>
                                                    <input type="text" name="company_website_up"
                                                        id="company_website_up_{{ $comp->id }}"
                                                        class="form-control @error('company_website_up') is-invalid @enderror"
                                                        placeholder="Enter Company Website"
                                                        value="{{ $comp->company_website }}">
                                                    @error('company_website_up')
                                                        <span class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="company_email_up_{{ $comp->id }}"
                                                        class="form-label">Company Email</label>
                                                    <input type="text" name="company_email_up"
                                                        id="company_email_up_{{ $comp->id }}"
                                                        class="form-control @error('company_email_up') is-invalid @enderror"
                                                        placeholder="Enter Company Email"
                                                        value="{{ $comp->company_email }}">
                                                    @error('company_email_up')
                                                        <span class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="company_phoneno_up_{{ $comp->id }}"
                                                        class="form-label">Company Phone No</label>
                                                    <input type="text" name="company_phoneno_up"
                                                        id="company_phoneno_up_{{ $comp->id }}"
                                                        class="form-control input-phone @error('company_phoneno_up') is-invalid @enderror"
                                                        placeholder="Enter Company Phone No"
                                                        value="{{ $comp->company_phoneno }}">
                                                    @error('company_phoneno_up')
                                                        <span class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="company_fax_up_{{ $comp->id }}"
                                                        class="form-label">Company Fax</label>
                                                    <input type="text" name="company_fax_up"
                                                        id="company_fax_up_{{ $comp->id }}"
                                                        class="form-control input-phone @error('company_fax_up') is-invalid @enderror"
                                                        placeholder="Enter Company Fax" value="{{ $comp->company_fax }}">
                                                    @error('company_fax_up')
                                                        <span class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="company_logo_up_{{ $comp->id }}"
                                                        class="form-label">Company Logo <span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" name="company_logo_up"
                                                        id="company_logo_up_{{ $comp->id }}"
                                                        class="form-control @error('company_logo_up') is-invalid @enderror"
                                                        accept="image/*" onchange="previewLogo('{{ $comp->id }}')">

                                                    @error('company_logo_up')
                                                        <span class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                    <div class="mt-2">
                                                        <img id="logoPreview_{{ $comp->id }}"
                                                            src="{{ asset(str_replace('public/', 'storage/', $comp->company_logo)) }}"
                                                            alt="Logo Preview" style="max-height: 150px;">
                                                    </div>
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
                                                        id="addApplicationBtn">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- [ Update Company Modal  ] end -->

                    <!-- [ Delete Modal ] start -->
                    <div class="modal fade" id="deleteCompanyModal-{{ $comp->id }}" data-bs-keyboard="false"
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
                                        <a href="{{ route('delete-company-get', ['id' => Crypt::encrypt($comp->id)]) }}"
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

                <!-- [ Assign Generator & Model ] end -->
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


        function previewLogo(id) {
            var input = $('#company_logo_up_' + id)[0];
            var preview = $('#logoPreview_' + id);

            if (input && input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.attr('src', e.target.result);
                    preview.show();
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function() {

            // DATATABLE : QUOTATION GENERATOR MODEL
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('manage-company-page') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        className: "text-start"
                    },
                    {
                        data: 'company_code',
                        name: 'company_code'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]

            });

            $('#company_logo').on('change', function(e) {
                const input = this;
                const preview = $('#logoPreview');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.attr('src', e.target.result).show();
                    };

                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.hide();
                }
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

            $('.uppercase-no-symbols').on('input', function() {
                let val = $(this).val();
                val = val.toUpperCase().replace(/[^A-Z0-9]/g, '');
                $(this).val(val);
            });

            $('.uppercase').on('input', function() {
                let val = $(this).val();
                val = val.toUpperCase();
                $(this).val(val);
            });

        });
    </script>
@endsection
<!-- [ Main Content ] end -->
