<!-- [ Extend Layouts ] -->
@extends('crmd-system.layouts.main')

<!-- [ Main Content ] start -->
@section('content')
    <style>
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
                                <h2 class="mb-0">{{ $im->implant_pt_name }}</h2>
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

                <!-- [ Generate ICF ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{ route('view-icf-document', Crypt::encrypt($im->id)) }}"
                                class="btn btn-light-danger">View ICF</a>

                            <div class="row">

                                <div class="col-sm-12 mb-4">
                                    <div class="h5 mb-3 text-center">Setting</div>
                                    <form action="{{ route('update-implant-post', Crypt::encrypt($im->id)) }}"
                                        method="POST" id="update-implant-form">
                                        @csrf

                                        <div class="row">
                                            <!-- [ Generator Model ] Input -->
                                            <div class="col-sm-3">
                                                <div class="mb-3">
                                                    <label for="generator_id" class="form-label">Model <span
                                                            class="text-danger">*</span></label>
                                                    <select name="generator_id" id="generator_id"
                                                        class="form-select @error('generator_id') is-invalid @enderror"
                                                        required>
                                                        @foreach ($generators as $g)
                                                            @if ($im->generator_id == $g->id)
                                                                <option value="{{ $g->id }}" selected>
                                                                    {{ $g->generator_code }}
                                                                </option>
                                                            @else
                                                                <option value="{{ $g->id }}">
                                                                    {{ $g->generator_code }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('generator_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- [ Generator Serial Number ] Input -->
                                            <div class="col-sm-3">
                                                <div class="mb-3">
                                                    <label for="implant_generator_sn" class="form-label">Serial
                                                        Number <span class="text-danger">*</span></label>
                                                    <input type="text" name="implant_generator_sn"
                                                        id="implant_generator_sn"
                                                        class="form-control sn-input @error('implant_generator_sn') is-invalid @enderror"
                                                        placeholder="Enter Serial Number"
                                                        value="{{ $im->implant_generator_sn }}" required>
                                                    @error('implant_generator_sn')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- [ Generator Price ] Input -->
                                            <div class="col-sm-2">
                                                <div class="mb-3">
                                                    <label for="implant_generator_itemPrice" class="form-label">Price
                                                        (RM)</label>
                                                    <input type="text" name="implant_generator_itemPrice"
                                                        class="form-control price-input @error('implant_generator_sn') is-invalid @enderror"
                                                        placeholder="Enter Generator Price (RM)"
                                                        value="{{ $im->implant_generator_itemPrice }}">
                                                    @error('implant_generator_sn')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- [ Generator Quantity ] Input -->
                                            <div class="col-sm-1">
                                                <div class="mb-3">
                                                    <label for="implant_generator_qty" class="form-label">Quantity</label>
                                                    <input type="text" name="implant_generator_qty"
                                                        class="form-control qty-input @error('implant_generator_qty') is-invalid @enderror"
                                                        placeholder="Enter Quantity"
                                                        value="{{ $im->implant_generator_qty }}">
                                                    @error('implant_generator_qty')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- [ Generator Stock Location ] Input -->
                                            <div class="col-sm-3">
                                                <div class="mb-3">
                                                    <label for="stock_location_id" class="form-label">Stock Location <span
                                                            class="text-danger">*</span></label>
                                                    <select name="stock_location_id" id="stock_location_id"
                                                        class="form-select @error('stock_location_id') is-invalid @enderror"
                                                        required>
                                                        @foreach ($stocklocations as $sl)
                                                            @if ($im->stock_location_id == $sl->id)
                                                                <option value="{{ $sl->id }}" selected>
                                                                    ({{ $sl->stock_location_code }})
                                                                    - {{ $sl->stock_location_name }}</option>
                                                            @else
                                                                <option value="{{ $sl->id }}">
                                                                    ({{ $sl->stock_location_code }})
                                                                    - {{ $sl->stock_location_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('stock_location_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            @foreach ($mcs as $mc)
                                                <h5 class="mt-4">{{ $mc->mcategory_name }}</h5>
                                                @php
                                                    $categoryImplants = $ims->filter(function ($imd) use (
                                                        $abbottmodels,
                                                        $mc,
                                                    ) {
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

                                                @if ($mc->mcategory_ismorethanone == 1)
                                                    @foreach ($categoryImplants as $index => $imd)
                                                        <div id="model_container_{{ $mc->id }}">
                                                            <div class="row col-sm-12 model-loop ">

                                                                <!-- [ Model ] Input -->
                                                                <div class="col-sm-3">
                                                                    <div class="mb-3">
                                                                        <label
                                                                            for="model_ids_{{ $mc->id }}_{{ $index }}"
                                                                            class="form-label">Model</label>
                                                                        <select name="model_ids[]"
                                                                            id="model_ids_{{ $mc->id }}_{{ $index }}"
                                                                            class="form-select @error('model_ids') is-invalid @enderror model-select">
                                                                            <option value="" selected>Select Model
                                                                            </option>
                                                                            @foreach ($abbottmodels->where('mcategory_id', $mc->id) as $am)
                                                                                <option value="{{ $am->id }}"
                                                                                    {{ $imd->model_id == $am->id ? 'selected' : '' }}>
                                                                                    {{ $am->model_code }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('model_ids')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <!-- [ Serial Number ] Input -->
                                                                <div class="col-sm-3">
                                                                    <div class="mb-3">
                                                                        <label
                                                                            for="model_sns_{{ $mc->id }}_{{ $index }}"
                                                                            class="form-label">Serial Number</label>
                                                                        <input type="text" name="model_sns[]"
                                                                            id="model_sns_{{ $mc->id }}_{{ $index }}"
                                                                            class="form-control sn-input @error('model_sns') is-invalid @enderror"
                                                                            placeholder="Enter Serial Number"
                                                                            value="{{ $imd->implant_model_sn }}">
                                                                        @error('model_sns')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <!-- [ Model Price ] Input -->
                                                                <div class="col-sm-2">
                                                                    <div class="mb-3">
                                                                        <label
                                                                            for="model_price_{{ $mc->id }}_{{ $index }}"
                                                                            class="form-label">Price (RM)</label>
                                                                        <input type="text" name="model_price[]"
                                                                            id="model_price_{{ $mc->id }}_{{ $index }}"
                                                                            class="form-control price-input @error('model_price') is-invalid @enderror"
                                                                            placeholder="Enter Model Price (RM)"
                                                                            value="{{ $imd->implant_model_itemPrice }}">
                                                                        @error('model_price')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <!-- [ Model Quantity ] Input -->
                                                                <div class="col-sm-1">
                                                                    <div class="mb-3">
                                                                        <label
                                                                            for="model_qty_{{ $mc->id }}_{{ $index }}"
                                                                            class="form-label">Quantity</label>
                                                                        <input type="text" name="model_qty[]"
                                                                            id="model_qty_{{ $mc->id }}_{{ $index }}"
                                                                            class="form-control qty-input @error('model_qty') is-invalid @enderror"
                                                                            placeholder="Enter Quantity"
                                                                            value="{{ $imd->implant_model_qty }}">
                                                                        @error('model_qty')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <!-- [ Stock Location ] Input -->
                                                                <div class="col-sm-2">
                                                                    <div class="mb-3">
                                                                        <label
                                                                            for="stock_location_ids_{{ $mc->id }}_{{ $index }}"
                                                                            class="form-label">Stock Location</label>
                                                                        <select name="stock_location_ids[]"
                                                                            id="stock_location_ids_{{ $mc->id }}_{{ $index }}"
                                                                            class="form-select @error('stock_location_ids') is-invalid @enderror stock-location-select">
                                                                            <option value="" selected>Select Stock
                                                                                Location
                                                                            </option>
                                                                            @foreach ($stocklocations as $sl)
                                                                                <option value="{{ $sl->id }}"
                                                                                    {{ $imd->stock_location_id == $sl->id ? 'selected' : '' }}>
                                                                                    ({{ $sl->stock_location_code }})
                                                                                    - {{ $sl->stock_location_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('stock_location_ids')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <!-- [ Remove Button ] -->
                                                                <div
                                                                    class="col-sm-1 d-flex align-items-center justify-content-center">
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm shadow-none remove-row">
                                                                        <i class="ti ti-trash f-20"></i>
                                                                    </button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <!-- [ Add Row Button ] -->
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="d-grid">
                                                                <button type="button"
                                                                    class="btn btn-light-primary mt-2 add-row"
                                                                    data-category="{{ $mc->id }}">
                                                                    <i class="ti ti-plus"></i> Add Model
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                @else
                                                    @foreach ($categoryImplants as $index => $imd)
                                                        <div class="row model-loop">

                                                            <!-- [ Model ] Input -->
                                                            <div class="col-sm-3">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="model_ids_{{ $mc->id }}_{{ $index }}"
                                                                        class="form-label">Model</label>
                                                                    <select name="model_ids[]"
                                                                        id="model_ids_{{ $mc->id }}_{{ $index }}"
                                                                        class="form-select @error('model_ids') is-invalid @enderror model-select">
                                                                        <option value="" selected>Select Model
                                                                        </option>
                                                                        @foreach ($abbottmodels->where('mcategory_id', $mc->id) as $am)
                                                                            <option value="{{ $am->id }}"
                                                                                {{ $imd->model_id == $am->id ? 'selected' : '' }}>
                                                                                {{ $am->model_code }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('model_ids')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- [ Serial Number ] Input -->
                                                            <div class="col-sm-3">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="model_sns_{{ $mc->id }}_{{ $index }}"
                                                                        class="form-label">Serial Number</label>
                                                                    <input type="text" name="model_sns[]"
                                                                        id="model_sns_{{ $mc->id }}_{{ $index }}"
                                                                        class="form-control sn-input @error('model_sns') is-invalid @enderror"
                                                                        placeholder="Enter Serial Number"
                                                                        value="{{ $imd->implant_model_sn }}">
                                                                    @error('model_sns')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- [ Model Price ] Input -->
                                                            <div class="col-sm-2">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="model_price_{{ $mc->id }}_{{ $index }}"
                                                                        class="form-label">Price (RM)</label>
                                                                    <input type="text" name="model_price[]"
                                                                        id="model_price_{{ $mc->id }}_{{ $index }}"
                                                                        class="form-control price-input @error('model_price') is-invalid @enderror"
                                                                        placeholder="Enter Model Price (RM)"
                                                                        value="{{ $imd->implant_model_itemPrice }}">
                                                                    @error('model_price')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- [ Model Quantity ] Input -->
                                                            <div class="col-sm-1">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="model_qty_{{ $mc->id }}_{{ $index }}"
                                                                        class="form-label">Quantity</label>
                                                                    <input type="text" name="model_qty[]"
                                                                        id="model_qty_{{ $mc->id }}_{{ $index }}"
                                                                        class="form-control qty-input @error('model_qty') is-invalid @enderror"
                                                                        placeholder="Enter Quantity"
                                                                        value="{{ $imd->implant_model_qty }}">
                                                                    @error('model_qty')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- [ Stock Location ] Input -->
                                                            <div class="col-sm-2">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="stock_location_ids_{{ $mc->id }}_{{ $index }}"
                                                                        class="form-label">Stock Location</label>
                                                                    <select name="stock_location_ids[]"
                                                                        id="stock_location_ids_{{ $mc->id }}_{{ $index }}"
                                                                        class="form-select @error('stock_location_ids') is-invalid @enderror stock-location-select">
                                                                        <option value="" selected>Select Stock
                                                                            Location
                                                                        </option>
                                                                        @foreach ($stocklocations as $sl)
                                                                            <option value="{{ $sl->id }}"
                                                                                {{ $imd->stock_location_id == $sl->id ? 'selected' : '' }}>
                                                                                ({{ $sl->stock_location_code }})
                                                                                - {{ $sl->stock_location_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('stock_location_ids')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- [ Dustbin Button ] -->
                                                            <div
                                                                class="col-sm-1 d-flex align-items-center justify-content-center">
                                                                <button type="button"
                                                                    class="avtar avtar-xs  btn btn-danger shadow-none reset-row"
                                                                    id="reset_{{ $mc->id }}_{{ $index }}"
                                                                    disabled>

                                                                    <i class="ti ti-trash f-20"></i>

                                                                </button>
                                                            </div>

                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endforeach

                                        </div>

                                    </form>
                                </div>

                                <div class="col-sm-12 mb-4">
                                    <div class="card-wrapper">
                                        <div class="h5 mb-3 text-center">Preview</div>
                                        <div id="formContainer"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- [ Generate ICF ] end -->

            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            function getFormData() {
                $.ajax({
                    url: "{{ route('icf-preview-post') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: "{{ $im->id }}",
                    },
                    success: function(response) {
                        $('#formContainer').html(response.html);
                    },
                    error: function() {
                        alert("Something went wrong!");
                    }
                });
            }

            getFormData();

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
