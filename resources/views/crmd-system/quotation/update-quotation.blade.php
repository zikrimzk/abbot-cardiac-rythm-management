@php
    $metadata = json_decode($quotation->quotation_metadata);
@endphp

<!-- [ Extend Layouts ] -->
@extends('crmd-system.layouts.main')

<!-- [ Main Content ] start -->
@section('content')
    <style>
        .section-header {
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
            margin-top: 1rem;
        }

        .form-label {
            font-size: 0.85rem;
            margin-bottom: 0.3rem;
        }

        .bg-light-primary {
            background-color: #e8f4ff;
        }

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
                                <li class="breadcrumb-item"><a href="{{ route('manage-quotation-page') }}">Manage
                                        Quotation</a></li>
                                <li class="breadcrumb-item" aria-current="page">Update Quotation</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <a href="{{ route('manage-quotation-page') }}" class="btn me-2 d-flex align-items-center">
                                    <span class="f-18">
                                        <i class="ti ti-arrow-left me-2"></i>
                                    </span>
                                    Back
                                </a>
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
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
                <div id="toastContainer"></div>
            </div>
            <!-- [ Alert ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">

                <!-- [ Update Quotation ] start -->
                <div class="col-sm-12">
                    <form action="{{ route('update-quotation-post', ['id' => Crypt::encrypt($quotation->id)]) }}"
                        method="POST">
                        @csrf
                        <div class="card border-0 shadow-sm">
                            <div class="card-header border-bottom py-3">
                                <h5 class="mb-0">Update Quotation Details</h5>
                            </div>
                            <div class="card-body">
                                <!-- Required fields note -->
                                <div class="alert alert-light border mb-4">
                                    <div class="text-muted"><i class="fas fa-info-circle me-2"></i>Fields marked with
                                        <span class="text-danger">*</span> are required
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Sender Details -->
                                    <div class="col-sm-12">
                                        <div class="section-header mb-3">
                                            <h6 class="fw-semibold mb-0 text-primary">
                                                <i class="fas fa-user-md me-2"></i>Sender Details
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="company_id" class="form-label fw-medium">Company <span
                                                    class="text-danger">*</span></label>
                                            <select name="company_id" id="company_id"
                                                class="form-select @error('company_id') is-invalid @enderror" required>
                                                <option value="" disabled>- Select Company -</option>
                                                @foreach ($companies as $company)
                                                    @if ($company->id == $quotation->company_id)
                                                        <option value="{{ $company->id }}" selected>
                                                            {{ $company->company_name }}</option>
                                                    @else
                                                        <option value="{{ $company->id }}" disabled>
                                                            {{ $company->company_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('company_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sender_email" class="form-label fw-medium">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                                <input type="email" name="sender_email" id="sender_email"
                                                    class="form-control @error('sender_email') is-invalid @enderror"
                                                    placeholder="email@company.com" value="{{ $metadata->sender_email }}">
                                            </div>
                                            @error('sender_email')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sender_telno" class="form-label fw-medium">Phone</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                <input type="text" name="sender_telno" id="sender_telno"
                                                    class="form-control @error('sender_telno') is-invalid @enderror"
                                                    placeholder="+60 12-3456789" value="{{ $metadata->sender_telno }}">
                                            </div>
                                            @error('sender_telno')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sender_fax" class="form-label fw-medium">Fax</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-fax"></i></span>
                                                <input type="text" name="sender_fax" id="sender_fax"
                                                    class="form-control @error('sender_fax') is-invalid @enderror"
                                                    placeholder="+60 3-12345678" value="{{ $metadata->sender_fax }}">
                                            </div>
                                            @error('sender_fax')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Receiver Details -->
                                    <div class="col-sm-12">
                                        <div class="section-header mb-3 mt-4">
                                            <h6 class="fw-semibold mb-0 text-primary">
                                                <i class="fas fa-hospital me-2"></i>Receiver Details
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="hospital_id" class="form-label fw-medium">Hospital <span
                                                    class="text-danger">*</span></label>
                                            <select name="hospital_id" id="hospital_id"
                                                class="form-select @error('hospital_id') is-invalid @enderror" required>
                                                <option value="" disabled>- Select Hospital -</option>
                                                @foreach ($hospitals as $hosp)
                                                    @if ($hosp->id == $quotation->hospital_id)
                                                        <option value="{{ $hosp->id }}" selected>
                                                            [{{ $hosp->hospital_code }}] - {{ $hosp->hospital_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $hosp->id }}" disabled>
                                                            [{{ $hosp->hospital_code }}]
                                                            - {{ $hosp->hospital_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('hospital_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="quotation_attn" class="form-label fw-medium">Attention
                                                Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                                <input type="text" name="quotation_attn" id="quotation_attn"
                                                    class="form-control @error('quotation_attn') is-invalid @enderror"
                                                    placeholder="Dr. John Smith" value="{{ $metadata->quotation_attn }}">
                                            </div>
                                            @error('quotation_attn')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Quotation Details -->
                                    <div class="col-sm-12">
                                        <div class="section-header mb-3 mt-4">
                                            <h6 class="fw-semibold mb-0 text-primary">
                                                <i class="fas fa-file-contract me-2"></i>Quotation Details
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="quotation_date" class="form-label fw-medium">Quotation
                                                Date</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="far fa-calendar"></i></span>
                                                <input type="date" name="quotation_date" id="quotation_date"
                                                    class="form-control @error('quotation_date') is-invalid @enderror"
                                                    value="{{ date('Y-m-d', strtotime($quotation->quotation_date)) }}"
                                                    readonly>
                                            </div>
                                            @error('quotation_date')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="quotation_subject" class="form-label fw-medium">Subject <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="quotation_subject" id="quotation_subject"
                                                class="form-control @error('quotation_subject') is-invalid @enderror"
                                                placeholder="Cardiac Device Quotation Details"
                                                value="{{ $metadata->quotation_subject }}" required>
                                            @error('quotation_subject')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Generator Details -->
                                    <div class="col-sm-12">
                                        <div class="section-header mb-3 mt-4">
                                            <h6 class="fw-semibold mb-0 text-primary">
                                                <i class="fas fa-heartbeat me-2"></i>Generator Details
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="generator_id" class="form-label fw-medium">Generator <span
                                                    class="text-danger">*</span></label>
                                            <select name="generator_id" id="generator_id"
                                                class="form-select @error('generator_id') is-invalid @enderror" required>
                                                <option value="" disabled>- Select Generator -</option>
                                                @foreach ($generators as $gene)
                                                    @if ($gene->id == $metadata->generator_id)
                                                        <option value="{{ $gene->id }}" selected>
                                                            [{{ $gene->generator_code }}] - {{ $gene->generator_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $gene->id }}" disabled>
                                                            [{{ $gene->generator_code }}]
                                                            - {{ $gene->generator_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('generator_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="model" class="form-label fw-medium">Generator Models</label>
                                            <textarea id="model" cols="10" rows="4" class="form-control bg-light" readonly
                                                placeholder="Select generator to view assigned models"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label for="quotation_unitprice" class="form-label fw-medium">Unit Price (RM)
                                                <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">RM</span>
                                                <input type="text" name="quotation_unitprice" id="quotation_unitprice"
                                                    class="form-control text-end @error('quotation_unitprice') is-invalid @enderror"
                                                    placeholder="0.00" value="{{ $metadata->quotation_unitprice }}"
                                                    required>
                                            </div>
                                            @error('quotation_unitprice')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="quotation_qty" class="form-label fw-medium">Quantity <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="quotation_qty" id="quotation_qty"
                                                class="form-control text-center @error('quotation_qty') is-invalid @enderror"
                                                placeholder="1" value="{{ $metadata->quotation_qty }}" required>
                                            @error('quotation_qty')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label for="quotation_totalprice" class="form-label fw-medium">Total Price
                                                (RM) <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">RM</span>
                                                <input type="text" name="quotation_totalprice"
                                                    id="quotation_totalprice"
                                                    class="form-control text-end bg-light @error('quotation_totalprice') is-invalid @enderror"
                                                    placeholder="0.00" value="{{ $quotation->quotation_price }}"
                                                    readonly>
                                            </div>
                                            @error('quotation_totalprice')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Patient Details -->
                                    <div class="col-sm-12">
                                        <div class="section-header mb-3 mt-4">
                                            <h6 class="fw-semibold mb-0 text-primary">
                                                <i class="fas fa-user-injured me-2"></i>Patient Details
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="quotation_pt_name" class="form-label fw-medium">Patient Name <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                <input type="text" name="quotation_pt_name" id="quotation_pt_name"
                                                    class="form-control @error('quotation_pt_name') is-invalid @enderror"
                                                    placeholder="Patient Full Name"
                                                    value="{{ $quotation->quotation_pt_name }}" required>
                                            </div>
                                            @error('quotation_pt_name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="quotation_pt_icno" class="form-label fw-medium">Patient ID <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                <input type="text" name="quotation_pt_icno" id="quotation_pt_icno"
                                                    class="form-control @error('quotation_pt_icno') is-invalid @enderror"
                                                    placeholder="IC or Passport Number"
                                                    value="{{ $quotation->quotation_pt_icno }}" required>
                                            </div>
                                            <small class="form-text text-muted">Format: 123456-78-9012 or A1234567</small>
                                            @error('quotation_pt_icno')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-3 d-grid gap-2 d-md-flex justify-content-md-end border-top">
                                <button type="reset"
                                    class="btn btn-light btn-outline-secondary d-flex align-items-center justify-content-center">
                                    <i class="ti ti-rotate-clockwise me-2"></i>Reset
                                </button>
                                <button type="submit" id="submitBtn"
                                    class="btn btn-primary d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle-check me-2"></i> Update Quotation
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- [ Update Quotation ] end -->

            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>



    <script type="text/javascript">
        /*********************************************************
         ***************GLOBAL FUNCTION & VARIABLES***************
         *********************************************************/
        function showToast(type, message) {
            const toastId = 'toast-' + Date.now();
            const iconClass = type === 'success' ? 'fas fa-check-circle' : 'fas fa-info-circle';
            const bgClass = type === 'success' ? 'bg-light-success' : 'bg-light-danger';
            const txtClass = type === 'success' ? 'text-success' : 'text-danger';
            const colorClass = type === 'success' ? 'success' : 'danger';
            const title = type === 'success' ? 'Success' : 'Error';

            const toastHtml = `
                    <div id="${toastId}" class="toast border-0 shadow-sm mb-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                        <div class="toast-body text-white ${bgClass} rounded d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0 ${txtClass}">
                                    <i class="${iconClass} me-2"></i> ${title}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <p class="mb-0 ${txtClass}">${message}</p>
                        </div>
                    </div>
                `;

            $('#toastContainer').append(toastHtml);
            const toastEl = new bootstrap.Toast(document.getElementById(toastId));
            toastEl.show();
        }

        /*********************************************************/
        /**********************AJAX: FUNCTIONS********************/
        /*********************************************************/

        $('#generator_id').on('change', function() {
            const generatorId = $(this).val();

            if (generatorId) {
                $.ajax({
                    url: 'get-model-list-' + generatorId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            let modelText = '';
                            response.data.forEach(function(item) {
                                modelText += '• ' + item.model_name + ' (' + item.model_code +
                                    ')\n';
                            });
                            $('#model').val(modelText);
                        } else {
                            $('#model').val('No models found.');
                        }
                    },
                    error: function() {
                        $('#model').val('Error fetching model list.');
                    }
                });
            } else {
                $('#model').val('');
            }
        });

        $('#generator_id').trigger('change');

        /*********************************************************/
        /*****************CALCULATE FUNCTION**********************/
        /*********************************************************/

        function calculateTotal() {
            let unitPrice = parseFloat($('#quotation_unitprice').val());
            let quantity = parseInt($('#quotation_qty').val());

            // Handle invalid values
            unitPrice = isNaN(unitPrice) ? 0 : unitPrice;
            quantity = isNaN(quantity) ? 0 : quantity;

            let total = unitPrice * quantity;

            $('#quotation_totalprice').val(total.toFixed(2));
        }

        $('#quotation_unitprice, #quotation_qty').on('input', calculateTotal);

        $('#quotation_pt_icno').on('input', function() {
            let input = $(this).val();

            if (/^[a-zA-Z]/.test(input)) {
                return;
            }

            let numbersOnly = input.replace(/[^0-9]/g, '');
            let formatted = '';

            if (numbersOnly.length <= 6) {
                formatted = numbersOnly;
            } else if (numbersOnly.length <= 8) {
                formatted = numbersOnly.slice(0, 6) + '-' + numbersOnly.slice(6);
            } else if (numbersOnly.length <= 12) {
                formatted = numbersOnly.slice(0, 6) + '-' + numbersOnly.slice(6, 8) + '-' + numbersOnly.slice(8);
            } else {
                formatted = numbersOnly.slice(0, 6) + '-' + numbersOnly.slice(6, 8) + '-' + numbersOnly.slice(8,
                    12);
            }

            $(this).val(formatted);
        });


        /*********************************************************/
        /********************PHONE/FORMATTING*********************/
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
                    numbers = '+60 ' + digits.substring(0, 2) + '-' + digits.substring(2, 5) + ' ' + digits.substring(5,
                        10);
                }
            }

            return numbers;
        }

        $('#sender_telno, #sender_fax').on('input', function() {
            const input = $(this);
            const cursorPos = input[0].selectionStart;
            const originalLength = input.val().length;

            const formatted = formatMalaysiaNumber(input.val());
            input.val(formatted);
            const newLength = formatted.length;
            const cursorOffset = newLength - originalLength;
            input[0].setSelectionRange(cursorPos + cursorOffset, cursorPos + cursorOffset);
        });

        $('#sender_telno, #sender_fax').on('blur', function() {
            const input = $(this);
            let value = input.val().trim();

            value = value.replace(/\s+$/, '');
            input.val(value);
        });

        /*********************************************************/
        /******************VALIDATION FUNCTION*******************/
        /*********************************************************/

        $('#submitBtn').on('click', function() {
            let isValid = true;

            // Validate input fields
            $('input[required]').each(function() {
                const value = $(this).val();
                if (!value || value.trim() === '') {
                    isValid = false;
                    $(this).css('border-color', 'red');
                } else {
                    $(this).css('border-color', '#ccc');
                }
            });

            // Validate textarea fields
            $('textarea[required]').each(function() {
                const value = $(this).val();
                if (!value || value.trim() === '') {
                    isValid = false;
                    $(this).css('border-color', 'red');
                } else {
                    $(this).css('border-color', '#ccc');
                }
            });

            // Validate select fields
            $('select[required]').each(function() {
                const value = $(this).val();
                if (!value || value === '') {
                    isValid = false;
                    $(this).css('border-color', 'red');
                } else {
                    $(this).css('border-color', '#ccc');
                }
            });

            if (!isValid) {
                showToast('error', 'Please fill in all required fields.');
                return;
            }
        });
    </script>
@endsection
<!-- [ Main Content ] end -->
