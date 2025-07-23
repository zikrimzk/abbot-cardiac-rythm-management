<!-- [ Extend Layouts ] -->
@extends('crmd-system.layouts.main')

<!-- [ Main Content ] start -->
@section('content')
    <style>
        .form-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            max-width: 1200px;
        }

        .form-header {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .section-title {
            color: #0d6efd;
            border-left: 4px solid #0d6efd;
            padding-left: 12px;
            margin-bottom: 20px;
        }

        .price-input,
        .qty-input,
        .sn-input {
            text-align: right;
        }

        .total-invoice {
            font-size: 1.4rem;
            font-weight: bold;
            color: #0d6efd;
        }

        .input-icon {
            background-color: #f1f5f9;
            border-right: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .required-star {
            color: #dc3545;
        }

        .btn-remove {
            background-color: #ffeded;
            color: #dc3545;
            border: none;
            height: 38px;
            margin-top: 29px;
        }

        .btn-remove:hover {
            background-color: #f8d7da;
        }

        .btn-add {
            background-color: #e8f4ff;
            color: #0d6efd;
            font-weight: 500;
        }

        .btn-add:hover {
            background-color: #d1e7ff;
        }

        button,
        .btn {
            border-radius: 6px !important;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 15px;
            }

            .mobile-spacing {
                margin-bottom: 15px;
            }

            .btn-remove {
                margin-top: 0;
            }
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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Sales Biling</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('manage-sales-billing') }}">Manage Sales
                                        Billing</a></li>
                                <li class="breadcrumb-item" aria-current="page">{{ $im->implant_pt_name }}</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <a href="{{ route('manage-sales-billing') }}" class="btn me-2 d-flex align-items-center">
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
                <!-- [ Update ICF ] start -->
                <div class="col-sm-12">
                    <div class="form-container">
                        <form action="{{ route('confirm-icf-post', Crypt::encrypt($im->id)) }}" method="POST"
                            id="update-implant-form">
                            @csrf

                            <!-- Form Header -->
                            <div class="form-header">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
                                        <img src="../assets/images/logo/abbott-logo.png" width="150" alt="Abbott Logo"
                                            class="img-fluid">
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h4 class="mb-0">INVENTORY CONSUMPTION FORM</h4>
                                    </div>
                                    <div class="col-md-4 text-center text-md-end">
                                        <div class="text-muted">Date: {{ date('d M Y', strtotime($im->implant_date)) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Patient Information Section -->
                            <div class="form-section">
                                <h5 class="section-title">Patient Information</h5>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Bill to:</label>
                                        <div class="input-group">
                                            <span class="input-group-text input-icon"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control" value="{{ $im->implant_pt_name }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ship to:</label>
                                        <div class="input-group">
                                            <span class="input-group-text input-icon"><i class="fas fa-truck"></i></span>
                                            <input type="text" class="form-control" value="{{ $im->implant_pt_name }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Patient IC:</label>
                                        <div class="input-group">
                                            <span class="input-group-text input-icon"><i class="fas fa-id-card"></i></span>
                                            <input type="text" class="form-control" value="{{ $im->implant_pt_icno }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Patient MRN:</label>
                                        <div class="input-group">
                                            <span class="input-group-text input-icon"><i class="fas fa-hospital"></i></span>
                                            <input type="text" class="form-control" value="{{ $im->implant_pt_mrn }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Patient Address:</label>
                                        <div class="input-group">
                                            <span class="input-group-text input-icon"><i
                                                    class="fas fa-map-marker-alt"></i></span>
                                            <textarea name="implant_pt_address" id="implant_pt_address"
                                                class="form-control @error('implant_pt_address') is-invalid @enderror" placeholder="Enter Patient Address"
                                                row="2">{{ $im->implant_pt_address }}</textarea>
                                        </div>
                                        @error('implant_pt_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Generator Section -->
                            <div class="form-section">
                                <h5 class="section-title">Generator</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-6 mb-3">
                                        <label for="generator_id" class="form-label">Model <span
                                                class="required-star">*</span></label>
                                        <select name="generator_id" id="generator_id" class="form-select" required>
                                            @foreach ($generators as $g)
                                                @if ($im->generator_id == $g->id)
                                                    <option value="{{ $g->id }}" selected>{{ $g->generator_code }}
                                                    </option>
                                                @else
                                                    <option value="{{ $g->id }}">{{ $g->generator_code }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-3 col-md-6 mb-3">
                                        <label for="implant_generator_sn" class="form-label">Serial Number <span
                                                class="required-star">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text input-icon"><i
                                                    class="fas fa-barcode"></i></span>
                                            <input type="text" name="implant_generator_sn" id="implant_generator_sn"
                                                class="form-control sn-input" placeholder="Enter Serial Number"
                                                value="{{ $im->implant_generator_sn }}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 mb-3">
                                        <label for="stock_location_id" class="form-label">Stock Location <span
                                                class="required-star">*</span></label>
                                        <select name="stock_location_id" id="stock_location_id" class="form-select"
                                            required>
                                            @foreach ($stocklocations as $sl)
                                                @if ($im->stock_location_id == $sl->id)
                                                    <option value="{{ $sl->id }}" selected>
                                                        ({{ $sl->stock_location_code }})
                                                        - {{ $sl->stock_location_name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $sl->id }}">({{ $sl->stock_location_code }})
                                                        -
                                                        {{ $sl->stock_location_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-1 col-md-2 mb-3">
                                        <label for="implant_generator_qty" class="form-label">Qty</label>
                                        <input type="text" name="implant_generator_qty" class="form-control qty-input"
                                            placeholder="1" value="{{ $im->implant_generator_qty }}">
                                    </div>

                                    <div class="col-lg-2 col-md-4 mb-3">
                                        <label for="implant_generator_itemPrice" class="form-label">Price (RM)</label>
                                        <div class="input-group">
                                            <span class="input-group-text input-icon">RM</span>
                                            <input type="text" name="implant_generator_itemPrice"
                                                class="form-control price-input" placeholder="0.00"
                                                value="{{ $im->implant_generator_itemPrice }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Model Categories -->
                            @foreach ($mcs as $mc)
                                <div class="form-section">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="section-title mb-0">{{ $mc->mcategory_name }}</h5>
                                        @if ($mc->mcategory_ismorethanone == 1)
                                            <button type="button" class="btn btn-sm btn-add add-row"
                                                data-category="{{ $mc->id }}">
                                                <i class="fas fa-plus me-1"></i> Add Model
                                            </button>
                                        @endif
                                    </div>

                                    @php
                                        $categoryImplants = $ims->filter(function ($imd) use ($abbottmodels, $mc) {
                                            $model = $abbottmodels->firstWhere('id', $imd->model_id);
                                            return $model && $model->mcategory_id == $mc->id;
                                        });

                                        if ($categoryImplants->isEmpty()) {
                                            $categoryImplants = collect([
                                                (object) [
                                                    'model_id' => null,
                                                    'implant_model_sn' => null,
                                                    'implant_model_itemPrice' => null,
                                                    'implant_model_qty' => null,
                                                    'stock_location_id' => null,
                                                ],
                                            ]);
                                        }
                                    @endphp

                                    <div id="model_container_{{ $mc->id }}">
                                        @foreach ($categoryImplants as $index => $imd)
                                            <div class="row model-loop mb-3">
                                                <div class="col-lg-3 col-md-6 mb-2 mobile-spacing">
                                                    <label class="form-label">Model</label>
                                                    <select name="model_ids[]" class="form-select model-select">
                                                        <option value="" selected>Select Model</option>
                                                        @foreach ($abbottmodels->where('mcategory_id', $mc->id) as $am)
                                                            <option value="{{ $am->id }}"
                                                                {{ $imd->model_id == $am->id ? 'selected' : '' }}>
                                                                {{ $am->model_code }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-lg-3 col-md-6 mb-2 mobile-spacing">
                                                    <label class="form-label">Serial Number</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text input-icon"><i
                                                                class="fas fa-barcode"></i></span>
                                                        <input type="text" name="model_sns[]"
                                                            class="form-control sn-input"
                                                            placeholder="Enter Serial Number"
                                                            value="{{ $imd->implant_model_sn }}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-4 mb-2 mobile-spacing">
                                                    <label class="form-label">Stock Location</label>
                                                    <select name="stock_location_ids[]"
                                                        class="form-select stock-location-select">
                                                        <option value="" selected>Select Location</option>
                                                        @foreach ($stocklocations as $sl)
                                                            <option value="{{ $sl->id }}"
                                                                {{ $imd->stock_location_id == $sl->id ? 'selected' : '' }}>
                                                                ({{ $sl->stock_location_code }})
                                                                - {{ $sl->stock_location_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-lg-1 col-md-2 mb-2 mobile-spacing">
                                                    <label class="form-label">Qty</label>
                                                    <input type="text" name="model_qty[]"
                                                        class="form-control qty-input" placeholder="1"
                                                        value="{{ $imd->implant_model_qty }}">
                                                </div>

                                                <div class="col-lg-2 col-md-4 mb-2 mobile-spacing">
                                                    <label class="form-label">Price (RM)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text input-icon">RM</span>
                                                        <input type="text" name="model_price[]"
                                                            class="form-control price-input" placeholder="0.00"
                                                            value="{{ $imd->implant_model_itemPrice }}">
                                                    </div>
                                                </div>

                                                <!-- [ Remove Button ] -->
                                                <div
                                                    class="col-lg-1 col-md-2 mb-4 d-flex align-items-center position-relative">
                                                    @if ($mc->mcategory_ismorethanone == 1)
                                                        <button type="button"
                                                            class="btn btn-remove btn-sm remove-row w-100">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @else
                                                        <button type="button"
                                                            class="btn btn-remove btn-sm reset-row w-100" disabled>
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif
                                                    <i class="fas fa-exclamation-circle text-danger position-absolute end-0 me-2 d-none warning-icon"
                                                        title="Please complete required fields"></i>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            <!-- Payment & Remarks -->
                            <div class="form-section">
                                <h5 class="section-title">Payment </h5>

                                <div class="row">

                                    <!-- [ Approval Type ] Dropdown -->
                                    <div class="col-md-6 mb-3">
                                        <label for="approval_type_id" class="form-label">Approval Type / Payment
                                            Method <span class="required-star">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                            <select name="approval_type_id" id="approval_type_id" class="form-control">
                                                <option value="">Select Approval Type</option>
                                            </select>
                                            <button type="button"
                                                class="btn btn-outline-secondary d-flex align-items-center"
                                                id="addApprovalBtn"
                                                style="border-left: none !important; border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;"><i
                                                    class="ti ti-circle-plus"></i>
                                            </button>
                                        </div>
                                        <div id="selectedApprovalWrapper" class="mt-2" style="display: none;">
                                            <a href="javascript:void(0)" class="link-danger" id="deleteApprovalBtn"
                                                aria-label="Remove">
                                                <i class="ti ti-trash"></i>
                                                Delete Type
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Total Invoice Section -->
                            <div class="form-section bg-light p-4 rounded">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <div class="fs-5 fw-semibold">Total Invoice Amount:</div>
                                        <div class="fs-3 fw-bold total-invoice">0.00</div>
                                        <input type="hidden" id="implant_sales_total_price"
                                            name="implant_sales_total_price">
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary btn-submit d-flex align-items-center"
                                    id="generate-icf-btn">
                                    <i class="ti ti-circle-check me-2"></i> Update ICF
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- [ Update ICF ] end -->

                <!-- [ Approval Type Modal ] start -->
                <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModal"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Add Approval Type
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <label for="approval_type_name" class="form-label">Approval Type
                                                <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="approval_type_name"
                                                name="approval_type_name" placeholder="Enter Approval Type">
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
                                            <button type="button" id="approvalFormBtn" class="btn btn-primary w-100">
                                                Add Approval Type
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ Approval Type Modal ] end -->

            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            // === TOAST : ALERT === //
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

            // === FORMAT : IC/PASSPORT === //
            $("#implant_pt_icno").on("input", function() {
                let value = $(this).val().toUpperCase();

                if (/^\d/.test(value)) {
                    value = value.replace(/\D/g, "");

                    if (value.length > 12) {
                        value = value.slice(0, 12); // Hadkan 12 digit sahaja
                    }

                    if (value.length > 6) {
                        value = value.slice(0, 6) + "-" + value.slice(6);
                    }
                    if (value.length > 9) {
                        value = value.slice(0, 9) + "-" + value.slice(9);
                    }
                } else {
                    value = value.replace(/[^A-Za-z0-9]/g, "");
                }

                $(this).val(value);
            });

            // === FORMAT : MONEY === //
            function applyPriceInputFormat($elements) {
                $elements.each(function() {
                    if ($(this).val().trim() === "") {
                        $(this).val("0.00");
                    }
                });

                $elements.off("keydown").on("keydown", function(e) {
                    if ($.inArray(e.keyCode, [8, 9, 46, 37, 39]) !== -1) return;

                    if ((e.keyCode < 48 || e.keyCode > 57) &&
                        (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });

                $elements.off("input").on("input", function() {
                    let raw = $(this).val().replace(/\D/g, "");
                    if (raw === "") raw = "0";
                    let num = parseFloat(raw) / 100;
                    $(this).val(num.toFixed(2));
                });

                $elements.off("blur").on("blur", function() {
                    let val = parseFloat($(this).val());
                    if (isNaN(val)) {
                        $(this).val("0.00");
                    } else {
                        $(this).val(val.toFixed(2));
                    }
                });
            }

            // === FORMAT : SERIAL NUMBER === //
            function applySnInputFormat($elements) {
                $elements.off("input").on("input", function() {
                    $(this).val($(this).val().toUpperCase());
                });
            }

            // === FORMAT : QUANTITY === //
            function applyQtyInputFormat($elements) {
                $elements.each(function() {
                    if ($(this).val().trim() === "") {
                        $(this).val("1");
                    }
                });

                $elements.off("keydown").on("keydown", function(e) {
                    // Allow: backspace, tab, delete, arrows
                    if ($.inArray(e.keyCode, [8, 9, 46, 37, 39]) !== -1) return;

                    // Allow only number keys
                    if ((e.keyCode < 48 || e.keyCode > 57) && // top row
                        (e.keyCode < 96 || e.keyCode > 105)) { // numpad
                        e.preventDefault();
                    }
                });

                $elements.off("input").on("input", function() {
                    let val = $(this).val().replace(/\D/g, ""); // Remove non-digits only
                    val = val.substring(0, 2); // Only two digits

                    // Do not set value if user clears the input (allow empty while typing)
                    if (val === "") return;

                    let num = parseInt(val, 10);
                    if (isNaN(num) || num < 1) num = 1;
                    if (num > 99) num = 99;

                    $(this).val(num);
                });

                $elements.off("blur").on("blur", function() {
                    let val = $(this).val().replace(/\D/g, "");
                    let num = parseInt(val, 10);

                    // If empty or invalid on blur, default to 1
                    if (isNaN(num) || num < 1) {
                        $(this).val("1");
                    } else {
                        $(this).val(num);
                    }
                });
            }

            // === GLOBAL : INITIALIZATION === //
            bindValidationEvents();
            getApprovalTypes();

            applyPriceInputFormat($(".price-input"));
            applySnInputFormat($(".sn-input"));
            applyQtyInputFormat($(".qty-input"));

            // === FUNCTION : CALCULATE TOTAL INVOICE FUNCTION === //
            function calculateTotal() {
                let total = 0;

                // Calculate generator total
                const genQty = parseFloat($('[name="implant_generator_qty"]').val()) || 0;
                const genPrice = parseFloat($('[name="implant_generator_itemPrice"]').val()) || 0;
                total += genQty * genPrice;

                // Calculate model totals
                $('.model-loop').each(function() {
                    const qtyInput = $(this).find('.qty-input');
                    const priceInput = $(this).find('.price-input');

                    const qty = parseFloat(qtyInput.val()) || 0;
                    const price = parseFloat(priceInput.val()) || 0;

                    total += qty * price;
                });

                // Update total display
                $('.total-invoice').text(total.toFixed(2));
                $('#implant_sales_total_price').val(total.toFixed(2));

            }

            calculateTotal();
            $(document).on('input', '.qty-input, .price-input', calculateTotal);


            // === VALIDATION : CHECK EMPTY FIELD === //
            function validateAllModelLoops() {
                let anyInvalid = false;

                $(".model-loop").each(function() {
                    const isInvalid = validateLoopFields($(this));
                    if (isInvalid) anyInvalid = true;
                });

                $("#generate-icf-btn").prop("disabled", anyInvalid);
            }

            // === VALIDATION : CHECK SPECIFIC CONTAINER EMPTY FIELD === //
            function validateLoopFields(loopContainer) {
                let modelSelected = loopContainer.find(".model-select").val();
                let serialNumber = loopContainer.find(".sn-input").val();
                let stockLocation = loopContainer.find(".stock-location-select").val();


                let price = loopContainer.find(".price-input").val();
                let qty = loopContainer.find(".qty-input").val();
                let resetBtn = loopContainer.find(".reset-row");
                let warningIcon = loopContainer.find(".warning-icon");

                // Enable reset if anything is filled
                if (modelSelected || serialNumber || stockLocation || price !== "0.00" || qty !== "1") {
                    resetBtn.prop("disabled", false);
                } else {
                    resetBtn.prop("disabled", true);
                }

                // Validation: If any of the 3 is filled, all must be
                let anyFilled = modelSelected || serialNumber || stockLocation;
                let allFilled = modelSelected && serialNumber && stockLocation;

                if (anyFilled && !allFilled) {
                    warningIcon.removeClass("d-none");
                    return true; // Invalid state
                } else {
                    warningIcon.addClass("d-none");
                    return false; // Valid state
                }
            }

            // === VALIDATION : BIND VALIDATION EVENT === //
            function bindValidationEvents() {
                $(document).on("change input",
                    ".model-select, .sn-input, .stock-location-select, .price-input, .qty-input",
                    function() {
                        validateAllModelLoops();
                    });

                validateAllModelLoops();
            }

            // === FUNCTIONS : ADD ROW RELATED === //
            $(".model-loop").each(function() {
                validateLoopFields($(this));
            });

            $(document).on("change", ".model-select", function() {
                validateLoopFields($(this).closest(".model-loop"));
            });

            $(document).on("input", ".sn-input", function() {
                validateLoopFields($(this).closest(".model-loop"));
            });

            $(document).on("input", ".price-input", function() {
                validateLoopFields($(this).closest(".model-loop"));
            });

            $(document).on("input", ".qty-input", function() {
                validateLoopFields($(this).closest(".model-loop"));
            });

            $(document).on("change", ".stock-location-select", function() {
                validateLoopFields($(this).closest(".model-loop"));
            });

            $(document).on("click", ".reset-row", function() {
                let loopContainer = $(this).closest(".model-loop");
                loopContainer.find(".model-select").val("").trigger("change");
                loopContainer.find(".sn-input").val("");
                loopContainer.find(".price-input").val("0.00");
                loopContainer.find(".qty-input").val("1");
                loopContainer.find(".stock-location-select").val("");
                calculateTotal();
                validateAllModelLoops();
                $(this).prop("disabled", true);
            });

            $(document).on("click", ".add-row", function() {
                let categoryID = $(this).data("category");
                let container = $("#model_container_" + categoryID);

                if (container.length === 0) {
                    alert("Container tidak ditemui untuk kategori ID: " + categoryID);
                    return;
                }

                let lastRow = container.find(".model-loop").last();
                let newRow = lastRow.clone();

                // Clear specific fields in new row
                newRow.find("input.sn-input").val("");
                newRow.find("input.price-input").val("0.00");
                newRow.find("input.qty-input").val("1");
                newRow.find("select.stock-location-select").val("");
                newRow.find("select.model-select").val("").trigger("change");

                // Enable remove/reset buttons
                newRow.find(".remove-row, .reset-row").prop("disabled", false);
                newRow.find(".warning-icon").addClass("d-none");

                // Append the new row
                container.append(newRow);

                // Apply input formatting
                applyPriceInputFormat(newRow.find(".price-input"));
                applySnInputFormat(newRow.find(".sn-input"));
                applyQtyInputFormat(newRow.find(".qty-input"));

                // Re-run validation
                validateAllModelLoops();

                console.log("Row baru ditambah untuk kategori:", categoryID);
            });

            $('.remove-row').each(function() {
                let row = $(this).closest('.model-loop');
                $(this).prop('disabled', true);

                row.find('input, select').on('input', function() {
                    row.find('.remove-row').prop('disabled', false);
                });

                $(this).on('click', function() {
                    row.find('input.sn-input, select.model-select, select.stock-location-select')
                        .val('');
                    row.find('input.price-input').val('0.00');
                    row.find('input.qty-input').val('1');
                    $(this).prop('disabled', true);
                    calculateTotal();
                    validateAllModelLoops();

                });
            });

            $(document).on('click', '.remove-row:not(:first)', function() {
                $(this).closest('.model-loop').remove();
                calculateTotal();
                validateAllModelLoops();
            });


            // === GET : APPROVAL TYPE === //
            function getApprovalTypes() {
                $.get("{{ route('get-approval-type-get') }}", function(res) {

                    var selectData = "{{ $im->approval_type_id }}";
                    if (res.success) {
                        const $select = $('#approval_type_id');
                        $select.empty();
                        res.approvalType.forEach(type => {

                            if (type.id == selectData) {
                                $select.append(
                                    `<option value="${type.id}" selected>${type.approval_type_name}</option>`
                                );

                            } else {
                                $select.append(
                                    `<option value="${type.id}">${type.approval_type_name}</option>`
                                );
                            }

                        });
                        $('#approval_type_id').trigger('change');

                    }
                });
            }

            // === TRIGGER : APPROVAL TYPE MODAL === //
            $('#addApprovalBtn').on('click', function() {
                $('#approvalModal').modal('show');
            });

            // === TRIGGER : DELETE APPROVAL TYPE BUTTON === //
            $('#approval_type_id').on('change', function() {
                const selectedId = $(this).val();
                const selectedName = $(this).find('option:selected').text();

                if (selectedId) {
                    $('#selectedApprovalWrapper').show();
                    $('#selectedApprovalName').text(selectedName);
                    $('#deleteApprovalBtn').data('id', selectedId);
                } else {
                    $('#selectedApprovalWrapper').hide();
                }
            });

            // === AJAX : ADD APPROVAL TYPE === //
            $('#approvalFormBtn').on('click', function(e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "{{ route('add-approval-type-post') }}",
                    data: {
                        approval_type_name: $('#approval_type_name').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.success) {
                            showToast('success', res.message);
                            $('#approvalModal').modal('hide');
                            $('#approval_type_name').val('');
                            getApprovalTypes();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            Object.values(errors).forEach(errArray => {
                                errArray.forEach(err => showToast('error', err));
                            });
                        } else {
                            showToast('error', xhr.responseJSON.message ||
                                'An unexpected error occurred.');
                        }
                    }
                });
            });

            // === AJAX : DELETE APPROVAL TYPE === //
            $('#deleteApprovalBtn').on('click', function() {
                const id = $(this).data('id');

                if (!id) return;

                if (!confirm("Are you sure you want to delete this approval type?")) return;

                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-approval-type-post') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(res) {
                        if (res.success) {
                            showToast('success', res.message);
                            $('#selectedApprovalWrapper').hide();
                            $('#approval_type_id').val('');
                            getApprovalTypes();
                        }
                    },
                    error: function(xhr) {
                        showToast('error', 'Unable to delete approval type.');
                    }
                });
            });
        });
    </script>
@endsection
<!-- [ Main Content ] end -->
