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
                                        <div class="text-muted">Invoice No: IC-2025-5306</div>
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

                                                <div class="col-lg-1 col-md-2 mb-2 d-flex align-items-end">
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
                                        <small>*(Patient self-paid / Welfare Approval / Hospital / Bumi Agent)</small>
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
                                    <i class="fas fa-check-circle me-2"></i> Generate ICF
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

            // === FORMAT : INITIALIZATION === //
            applyPriceInputFormat($(".price-input"));
            applySnInputFormat($(".sn-input"));
            applyQtyInputFormat($(".qty-input"));

            // === ICF : CALCULATE TOTAL INVOICE FUNCTION === //
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
            }

            calculateTotal();
            $(document).on('input', '.qty-input, .price-input', calculateTotal);


            // FUNCTION : RESET BUTTON
            function checkResetButton(loopContainer) {
                let modelSelected = loopContainer.find(".model-select").val();
                let serialNumber = loopContainer.find(".sn-input").val();
                let modelprice = loopContainer.find(".price-input").val();
                let modelqty = loopContainer.find(".qty-input").val();
                let stockLocation = loopContainer.find(".stock-location-select").val();
                let dustbinBtn = loopContainer.find(".reset-row");
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
                calculateTotal();

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

                let modelSelected = row.find(".model-select").val();
                let serialNumber = row.find(".sn-input").val();
                let modelprice = row.find(".price-input").val();
                let modelqty = row.find(".qty-input").val();
                let stockLocation = row.find(".stock-location-select").val();

                if (modelSelected || serialNumber || modelprice != "0.00" || modelqty != "1" ||
                    stockLocation) {
                    $(this).prop("disabled", false);
                } else {
                    $(this).prop("disabled", true);
                }

                $(this).on('click', function() {
                    row.find('input.sn-input, select.model-select, select.stock-location-select')
                        .val('');
                    row.find('input.price-input').val('0.00');
                    row.find('input.qty-input').val('1');
                    $(this).prop('disabled', true);
                    calculateTotal();

                });
            });

            $('.model-loop').each(function() {
                let row = $(this);
                let removeBtn = row.find(".remove-row");
                let inputs = row.find("input.sn-input, select.model-select, select.stock-location-select");

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
                calculateTotal();
            });
        });
    </script>
@endsection
<!-- [ Main Content ] end -->
