<!-- [ Extend Layouts ] -->
@extends('crmd-system.layouts.main')

<!-- [ Main Content ] start -->
@section('content')
    {{-- <style>
        /* Landscape wrapper-form */
        .wrapper-form {
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            border: 1px dashed #555;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            padding: 30px;
        }

        /* Watermark background */
        .watermark {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" viewBox="0 0 400 400"><text x="50%" y="50%" font-family="Arial" font-size="40" fill="rgba(0,100,200,0.05)" text-anchor="middle" dominant-baseline="middle" transform="rotate(-45, 200, 200)">CONFIDENTIAL - INVENTORY FORM</text></svg>');
            background-repeat: repeat;
            opacity: 0.3;
            z-index: -1;
        }

        /* Header section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 2px solid #2c6eb5;
            margin-bottom: 25px;
        }

        .logo-area {
            width: 150px;
            height: 80px;
        }

        .title-area {
            text-align: center;
        }

        .title-area h1 {
            font-size: 24px;
            color: #1a3c6e;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .title-area .subtitle {
            font-size: 12px;
            color: #2c6eb5;
            font-weight: 600;
        }

        .form-meta {
            text-align: right;
            font-size: 12px;
            color: #666;
        }

        /* Patient Information Section */
        .patient-info {
            width: 100%;
            margin: 25px 0;
            border-collapse: collapse;
            font-size: 12px;
        }

        .patient-info td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            vertical-align: top;

        }

        .info-label {
            background-color: #e9f0f8;
            font-weight: 600;
            width: 15%;
            color: #1a3c6e;
            font-size: 12px;
        }

        /* Stock Location Section */
        .stock-section {
            background: #f8fbff;
            border: 1px solid #cde;
            border-radius: 4px;
            padding: 12px 15px;
            margin: 20px 0;
        }

        .section-title {
            color: #1a3c6e;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #cde;
        }

        .location-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            font-size: 12px;
        }

        .location-item {
            display: flex;
        }

        .location-code {
            font-weight: 700;
            width: 40px;
            color: #2c6eb5;
        }

        /* Products Table */
        .products-section {
            margin: 30px 0;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 10px;
        }

        .products-table th {
            background-color: #1a3c6e;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
        }

        .products-table td {
            padding: 10px 8px;
            border: 1px solid #ddd;
        }

        .products-table tr:nth-child(even) {
            background-color: #f8fbff;
        }

        .products-table tr:hover {
            background-color: #edf5ff;
        }

        /* Payment Section */
        .payment-section {
            margin: 25px 0;
            padding: 15px;
            background: #f0f8ff;
            border-left: 4px solid #2c6eb5;
        }

        .payment-method {
            font-weight: 600;
            color: #1a3c6e;
            margin-bottom: 5px;
        }

        .payment-note {
            font-size: 12px;
            color: #666;
            font-style: italic;
            margin-bottom: 10px;
        }

        .total-invoice {
            font-size: 12px;
            font-weight: 700;
            color: #1a3c6e;
        }

        /* Documents Section */
        .documents-section {
            margin: 25px 0;
            padding: 15px;
            background: #f8fafd;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .documents-section ol {
            padding-left: 25px;
        }

        .documents-section li {
            margin-bottom: 8px;
            font-size: 12px;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }

        .form-version {
            font-style: italic;
            text-align: right;
        }

        /* Signature area */
        .signature-area {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
            padding-top: 50px;
            text-align: center;
            border-top: 1px solid #ccc;
            font-size: 14px;
            color: #555;
        }

        /* Print-specific styles */
        @media print {
            body {
                padding: 0;
                background: none;
            }

            .wrapper-form {
                box-shadow: none;
                margin: 0;
                padding: 15mm;
                width: 100%;
                min-height: 100%;
            }

            .no-print {
                display: none;
            }

            /* Landscape orientation for printing */
            @page {
                size: landscape;
                margin: 10mm;
            }
        }

        /* Print button styling */
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #1a3c6e;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .print-btn:hover {
            background: #2c6eb5;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
    </style> --}}

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

        .btn-submit {
            padding: 10px 30px;
            font-weight: 500;
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
                                <li class="breadcrumb-item"><a href="{{ route('generate-icf-page') }}">Generate Inventory
                                        Consumption Form (ICF)</a></li>
                                <li class="breadcrumb-item" aria-current="page">{{ $im->implant_pt_name }}</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <a href="{{ route('generate-icf-page') }}" class="btn me-2 d-flex align-items-center">
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
            <!-- [ Alert ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-container">
                        <form action="{{ route('update-implant-post', Crypt::encrypt($im->id)) }}" method="POST"
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
                                        <div class="text-muted">Form ID: IC-2025-5306</div>
                                        <div class="text-muted">Date: 28-Jan-2025</div>
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
                                            <span class="input-group-text input-icon"><i
                                                    class="fas fa-hospital"></i></span>
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
                                            <textarea class="form-control" rows="2" readonly>{{ $im->implant_pt_address }}</textarea>
                                        </div>
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
                                                                {{ $sl->stock_location_code }}
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

                                                <div class="col-lg-1 col-md-2 mb-2 d-flex align-items-end">
                                                    @if ($mc->mcategory_ismorethanone == 1)
                                                        <button type="button"
                                                            class="btn btn-remove btn-sm remove-row w-100">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @else
                                                        <button type="button"
                                                            class="btn btn-remove btn-sm reset-row w-100" disabled>
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            <!-- Total Invoice Section -->
                            <div class="form-section bg-light p-4 rounded">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <div class="fs-5 fw-semibold">Total Invoice Amount:</div>
                                        <div class="fs-3 fw-bold total-invoice">0.00</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment & Remarks -->
                            <div class="form-section">
                                <h5 class="section-title">Payment & Remarks</h5>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="sales_payment_method" class="form-label">Payment Method:</label>
                                        <textarea name="sales_payment_method" id="sales_payment_method" class="form-control" rows="2"
                                            placeholder="Enter payment method"></textarea>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="sales_remark" class="form-label">Remarks from Sales:</label>
                                        <textarea name="sales_remark" id="sales_remark" class="form-control" rows="2"
                                            placeholder="Enter any remarks"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary btn-submit">
                                    <i class="fas fa-check-circle me-2"></i> Confirm & Generate ICF
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            // function getFormData() {
            //     $.ajax({
            //         url: "{{ route('icf-preview-post') }}",
            //         type: "POST",
            //         data: {
            //             _token: "{{ csrf_token() }}",
            //             id: "{{ $im->id }}",
            //         },
            //         success: function(response) {
            //             $('#formContainer').html(response.html);
            //         },
            //         error: function() {
            //             alert("Something went wrong!");
            //         }
            //     });
            // }

            // getFormData();

            // === FORMAT : IC/PASSPORT === //
            $("#implant_pt_icno").on("input", function() {
                let value = $(this).val().toUpperCase(); // Pastikan huruf besar untuk passport

                if (/^\d/.test(value)) {
                    // Jika input bermula dengan nombor (IC), format sebagai IC
                    value = value.replace(/\D/g, ""); // Buang semua bukan nombor

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
                    // Jika input bermula dengan huruf (Passport), benarkan tanpa format
                    value = value.replace(/[^A-Za-z0-9]/g, ""); // Benarkan hanya huruf dan nombor
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

            // === FORMAT : INITIALIZATION === //
            applyPriceInputFormat($(".price-input"));
            applySnInputFormat($(".sn-input"));
            applyQtyInputFormat($(".qty-input"));

            // Calculate total invoice function
            function calculateTotal() {
                let total = 0;

                // Calculate generator total
                const genQty = parseFloat($('#implant_generator_qty').val()) || 0;
                const genPrice = parseFloat($('#implant_generator_itemPrice').val()) || 0;
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
            }

            // Initial calculation
            calculateTotal();

            // Bind calculation to input events
            $(document).on('input', '.qty-input, .price-input', calculateTotal);


            // FUNCTION : RESET BUTTON
            function checkResetButton(loopContainer) {
                let modelSelected = loopContainer.find(".model-select").val();
                let serialNumber = loopContainer.find(".sn-input").val();
                let modelprice = loopContainer.find(".price-input").val();
                let modelqty = loopContainer.find(".qty-input").val();
                let stockLocation = loopContainer.find(".stock-location-select").val();
                let dustbinBtn = loopContainer.find(".reset-row");

                // Aktifkan butang jika ada input dalam mana-mana field
                if (modelSelected || serialNumber || modelprice != "0.00" || modelqty != "1" || stockLocation) {
                    dustbinBtn.prop("disabled", false);
                } else {
                    dustbinBtn.prop("disabled", true);
                }
            }

            $(".model-loop").each(function() {
                checkResetButton($(this));
            });

            $(document).on("change", ".model-select", function() {
                checkResetButton($(this).closest(".model-loop"));
            });

            $(document).on("input", ".sn-input", function() {
                checkResetButton($(this).closest(".model-loop"));
            });

            $(document).on("input", ".price-input", function() {
                checkResetButton($(this).closest(".model-loop"));
            });

            $(document).on("input", ".qty-input", function() {
                checkResetButton($(this).closest(".model-loop"));
            });

            $(document).on("change", ".stock-location-select", function() {
                checkResetButton($(this).closest(".model-loop"));
            });

            $(document).on("click", ".reset-row", function() {
                let loopContainer = $(this).closest(".model-loop");
                loopContainer.find(".model-select").val("").trigger("change");
                loopContainer.find(".sn-input").val("");
                loopContainer.find(".price-input").val("0.00");
                loopContainer.find(".qty-input").val("1");
                loopContainer.find(".stock-location-select").val("");
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

                // Clear input/select values
                newRow.find(
                    "input.sn-input, input.price-input, input.qty-input, select.stock-location-select, select.model-select"
                ).val("");
                newRow.find(".remove-row").prop("disabled", false);

                // Append the row
                lastRow.after(newRow);

                // Apply formatting to the new inputs
                applyPriceInputFormat(newRow.find(".price-input"));
                applySnInputFormat(newRow.find(".sn-input"));
                applyQtyInputFormat(newRow.find(".qty-input"));

                console.log("Row baru ditambah!", newRow);
            });

            $('.remove-row').each(function() {
                let row = $(this).closest('.model-loop');

                row.find('input, select').on('input', function() {
                    row.find('.remove-row').prop('disabled', false);
                });

                $(this).on('click', function() {
                    row.find('input.sn-input, select.model-select, select.stock-location-select')
                        .val('');
                    row.find('input.price-input').val('0.00');
                    row.find('input.qty-input').val('1');

                    $(this).prop('disabled', true);
                });
            });

            $('.model-loop').each(function() {
                let row = $(this);
                let removeBtn = row.find(".remove-row");
                let inputs = row.find("input, select");

                let hasData = inputs.filter(function() {
                    return $(this).val().trim() !== "";
                }).length > 0;

                if (hasData || row.is(":not(:first-child)")) {
                    $(this).prop("disabled", true);
                } else {
                    $(this).prop("disabled", false);
                }
            });

            $(document).on('click', '.remove-row:not(:first)', function() {
                $(this).closest('.model-loop').remove();
            });

        });
    </script>
@endsection
<!-- [ Main Content ] end -->
