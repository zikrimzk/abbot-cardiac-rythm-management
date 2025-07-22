@php
    $metadata = json_decode($quotation->quotation_metadata);
@endphp

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

                <!-- [ Generate Quotation ] start -->
                <div class="col-sm-12">
                    <form action="{{ route('update-quotation-post', ['id' => Crypt::encrypt($quotation->id)]) }}" method="POST">
                        @csrf
                        <div class="card p-3">
                            <div class="card-header">
                                <h5>Update Quotation</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <h5>Sender Details</h5>
                                    <!-- Company Select -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="company_id" class="form-label">Company <span
                                                    class="text-danger">*</span></label>
                                            <select name="company_id" id="company_id"
                                                class="form-select @error('company_id') is-invalid @enderror" required>
                                                <option value="">- Select Company -</option>
                                                @foreach ($companies as $company)
                                                    @if ($company->id == $quotation->company_id)
                                                        <option value="{{ $company->id }}" selected>
                                                            {{ $company->company_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $company->id }}">{{ $company->company_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('company_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Sender Email Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="sender_email" class="form-label">Sender Email</label>
                                            <input type="email" name="sender_email" id="sender_email"
                                                class="form-control @error('sender_email') is-invalid @enderror"
                                                placeholder="Enter Sender Email" value="{{ $metadata->sender_email }}">
                                            @error('sender_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Sender Tel Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="sender_telno" class="form-label">Sender Phone No</label>
                                            <input type="text" name="sender_telno" id="sender_telno"
                                                class="form-control @error('sender_telno') is-invalid @enderror"
                                                placeholder="Enter Sender Phone No" value="{{ $metadata->sender_telno }}">
                                            @error('sender_telno')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Sender Fax Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="sender_fax" class="form-label">Sender Fax</label>
                                            <input type="text" name="sender_fax" id="sender_fax"
                                                class="form-control @error('sender_fax') is-invalid @enderror"
                                                placeholder="Enter Sender Fax" value="{{ $metadata->sender_fax }}">
                                            @error('sender_fax')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr>

                                    <h5>Receiver Details</h5>
                                    <!-- Hospital Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="hospital_id" class="form-label">Hospital <span
                                                    class="text-danger">*</span></label>
                                            <select name="hospital_id" id="hospital_id"
                                                class="form-select @error('hospital_id') is-invalid @enderror" required>
                                                <option value="">- Select Hospital -</option>
                                                @foreach ($hospitals as $hosp)
                                                    @if ($hosp->id == $quotation->hospital_id)
                                                        <option value="{{ $hosp->id }}" selected>
                                                            [{{ $hosp->hospital_code }}] -
                                                            {{ $hosp->hospital_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $hosp->id }}">[{{ $hosp->hospital_code }}]
                                                            -
                                                            {{ $hosp->hospital_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('hospital_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Attn Name Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="quotation_attn" class="form-label">Attn Name</label>
                                            <input type="text" name="quotation_attn" id="quotation_attn"
                                                class="form-control @error('quotation_attn') is-invalid @enderror"
                                                placeholder="Enter Attn Name" value="{{ $metadata->quotation_attn }}">
                                            @error('quotation_attn')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr>

                                    <h5>Quotation Details</h5>

                                    <!-- Quotation Date Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="company_id" class="form-label">Quotation Date</label>
                                            <input type="date" name="quotation_date" id="quotation_date"
                                                class="form-control @error('quotation_date') is-invalid @enderror"
                                                value="{{ date('Y-m-d', strtotime($quotation->quotation_date)) }}"
                                                readonly>
                                            @error('quotation_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Subject Input -->
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="quotation_subject" class="form-label">Subject <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="quotation_subject" id="quotation_subject"
                                                class="form-control @error('quotation_subject') is-invalid @enderror"
                                                placeholder="Enter Subject" value="{{ $metadata->quotation_subject }}"
                                                required>
                                            @error('quotation_subject')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr />

                                    <h5>Generator Details</h5>
                                    <!-- Generator Select -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="generator_id" class="form-label">Generator <span
                                                    class="text-danger">*</span></label>
                                            <select name="generator_id" id="generator_id"
                                                class="form-select @error('generator_id') is-invalid @enderror" required>
                                                <option value="">- Select Generator -</option>
                                                @foreach ($generators as $gene)
                                                    @if ($gene->id == $metadata->generator_id)
                                                        <option value="{{ $gene->id }}" selected>
                                                            [{{ $gene->generator_code }}] -
                                                            {{ $gene->generator_name }}</option>
                                                    @else
                                                        <option value="{{ $gene->id }}">
                                                            [{{ $gene->generator_code }}] -
                                                            {{ $gene->generator_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('generator_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Model Textarea -->
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="model" class="form-label">Model</label>
                                            <textarea id="model" cols="10" rows="6" class="form-control" readonly></textarea>
                                        </div>
                                    </div>

                                    <!-- Unit Price Input -->
                                    <div class="col-sm-5">
                                        <div class="mb-3">
                                            <label for="quotation_unitprice" class="form-label">Unit Price (RM) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="quotation_unitprice" id="quotation_unitprice"
                                                class="form-control @error('quotation_unitprice') is-invalid @enderror"
                                                placeholder="Enter Unit Price (RM)"
                                                value="{{ $metadata->quotation_unitprice }}" required>
                                            @error('quotation_unitprice')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Qty Input -->
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="quotation_qty" class="form-label">Qty <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="quotation_qty" id="quotation_qty"
                                                class="form-control @error('quotation_qty') is-invalid @enderror"
                                                placeholder="0" value="{{ $metadata->quotation_qty }}" required>
                                            @error('quotation_qty')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Total Price Input -->
                                    <div class="col-sm-5">
                                        <div class="mb-3">
                                            <label for="quotation_totalprice" class="form-label">Total Price (RM) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="quotation_totalprice" id="quotation_totalprice"
                                                class="form-control @error('quotation_totalprice') is-invalid @enderror"
                                                placeholder="Enter Total Price (RM)"
                                                value="{{ $quotation->quotation_price }}" readonly>
                                            @error('quotation_totalprice')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr />

                                    <h5>Patient Details</h5>

                                    <!-- Patient Name Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="quotation_pt_name" class="form-label">Patient Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="quotation_pt_name" id="quotation_pt_name"
                                                class="form-control @error('quotation_pt_name') is-invalid @enderror"
                                                placeholder="Enter Patient Name" value="{{ $quotation->quotation_pt_name }}"
                                                required>
                                            @error('quotation_pt_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Patient IC/Passport Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="quotation_pt_icno" class="form-label">Patient IC / Passport
                                                No <span class="text-danger">*</span></label>
                                            <input type="text" name="quotation_pt_icno" id="quotation_pt_icno"
                                                class="form-control @error('quotation_pt_icno') is-invalid @enderror"
                                                placeholder="Enter Patient IC / Passport No"
                                                value="{{ $quotation->quotation_pt_icno }}" required>
                                            @error('quotation_pt_icno')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-light-danger">Reset</button>
                                <button type="submit" id= "submitBtn" class="btn btn-primary">Update Quotation</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- [ Generate Quotation ] end -->

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
        /**********************GETTERS FUNCTION*******************/
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

        // Trigger calculation when unit price or qty changes
        $('#quotation_unitprice, #quotation_qty').on('input', calculateTotal);

        $('#quotation_pt_icno').on('input', function() {
            let input = $(this).val();

            // If it starts with a letter, treat it as passport — allow as-is
            if (/^[a-zA-Z]/.test(input)) {
                return;
            }

            // Format numeric-only input into IC format
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
        /******************FORM SUBMIT FUNCTION*******************/
        /*********************************************************/

        $('#submitBtn').on('click', function() {
            let isValid = true;

            $('input[required]').each(function() {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).css('border-color', 'red'); // Optional: add visual cue
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
