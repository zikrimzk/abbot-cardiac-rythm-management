<!-- [ Extend Layouts ] -->
@extends('crmd-system.layouts.main')

<!-- [ Main Content ] start -->
@section('content')
    <style>
        .form-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin: 20px auto;
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
            font-weight: 600;
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
            font-size: 0.8em;
            vertical-align: super;
        }

        .price-input,
        .qty-input,
        .sn-input {
            text-align: right;
        }

        .product-group-container {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 15px;
            background-color: #f8f9fa;
            max-height: 150px;
            overflow-y: auto;
        }

        .model-loop {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #e9ecef;
        }

        .btn-check:checked+.btn-outline-dark {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Implant</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('manage-implant-page') }}">Manage Implant</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Add Implant</li>
                            </ul>
                        </div>
                        <div class="col-md-12 mt-2 mb-2">
                            <div class="d-flex">
                                <a href="{{ route('manage-implant-page') }}"
                                    class="btn btn-primary btn-sm d-flex align-items-center">
                                    <i class="fas fa-arrow-circle-left me-2"></i>
                                    Back to Manage Implant
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
            {{-- <div class="row">
                <!-- [ Add Implant ] start -->
                <div class="col-sm-12">
                    <form action="{{ route('add-implant-post') }}" method="POST" id="add-implant-form">
                        @csrf
                        <div class="card">
                            <div class="card-header bg-light-primary text-primary">
                                <h5 class="card-title">
                                    Add Implant
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <!-- [ Date of Implant ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_date" class="form-label">Date of
                                                Implant <span class="text-danger fw-bold">*</span></label>
                                            <input type="date" name="implant_date"
                                                class="form-control @error('implant_date') is-invalid @enderror"
                                                id="implant_date" required>
                                            @error('implant_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Region ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="region_id" class="form-label">Region <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select name="region_id" id="region_id"
                                                class="form-select @error('region_id') is-invalid @enderror" required>
                                                <option value="">Select Region</option>
                                                @foreach ($regions as $rgn)
                                                    @if (old('region_id') == $rgn->id)
                                                        <option value="{{ $rgn->id }}" selected>{{ $rgn->region_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $rgn->id }}">{{ $rgn->region_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('region_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Hospital ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="hospital_id" class="form-label">Hospital <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select name="hospital_id" id="hospital_id"
                                                class="form-select @error('hospital_id') is-invalid @enderror" required>
                                                <option value="" selected>Select Hospital</option>
                                                @foreach ($hospitals as $hs)
                                                    @if (old('hospital_id') == $hs->id)
                                                        <option value="{{ $hs->id }}" selected>
                                                            {{ $hs->hospital_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $hs->id }}">{{ $hs->hospital_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('hospital_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Doctor ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_doctor_id"
                                                class="form-label @error('doctor_id') is-invalid @enderror">Doctor <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select name="doctor_id" id="implant_doctor_id" class="form-select" required>
                                                <option value="" selected>Select Doctor</option>
                                                @foreach ($doctors as $dr)
                                                    @if (old('doctor_id') == $dr->id)
                                                        <option value="{{ $dr->id }}" selected>
                                                            {{ $dr->doctor_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $dr->id }}">{{ $dr->doctor_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('doctor_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr class="my-4" />

                                    <!-- [ Product Group ] Input -->
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="pgroup_id" class="form-label">Product Group <span
                                                    class="text-danger">*</span></label>
                                            <div class="d-flex flex-wrap gap-2 border rounded p-2 overflow-auto"
                                                style="max-height: 150px;">
                                                @foreach ($pgs as $pg)
                                                    <input type="checkbox" class="btn-check" name="product_groups[]"
                                                        value="{{ $pg->product_group_name }}" id="{{ $pg->id }}">
                                                    <label class="btn btn-outline-dark"
                                                        for="{{ $pg->id }}">{{ $pg->product_group_name }}</label>
                                                @endforeach
                                            </div>
                                            @error('product_groups')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr class="my-4" />

                                    <h5>Generator</h5>

                                    <!-- [ Generator Model ] Input -->
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="generator_id" class="form-label">Model <span
                                                    class="text-danger">*</span></label>
                                            <select name="generator_id" id="generator_id"
                                                class="form-select @error('generator_id') is-invalid @enderror" required>
                                                <option value="" selected>Select Model</option>
                                                @foreach ($generators as $g)
                                                    @if (old('generator_id') == $g->id)
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
                                            <input type="text" name="implant_generator_sn" id="implant_generator_sn"
                                                class="form-control sn-input @error('implant_generator_sn') is-invalid @enderror"
                                                placeholder="Enter Serial Number"
                                                value="{{ old('implant_generator_sn') }}" required>
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
                                                placeholder="Enter Generator Price (RM)">
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
                                                placeholder="Enter Quantity" value="1">
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
                                                <option value="" selected>Select Stock Location</option>
                                                @foreach ($stocklocations as $sl)
                                                    @if (old('stock_location_id') == $sl->id)
                                                        <option value="{{ $sl->id }}" selected>
                                                            ({{ $sl->stock_location_code }})
                                                            - {{ $sl->stock_location_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $sl->id }}">
                                                            ({{ $sl->stock_location_code }})
                                                            - {{ $sl->stock_location_name }}
                                                        </option>
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
                                        @if ($mc->mcategory_ismorethanone == 1)
                                            <div id="model_container_{{ $mc->id }}">
                                                <div class="row col-sm-12 model-loop ">
                                                    <!-- [ Model ] Input -->
                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="model_ids_{{ $mc->id }}"
                                                                class="form-label">Model</label>
                                                            <select name="model_ids[]" class="form-select model-select">
                                                                <option value="" selected>Select Model</option>
                                                                @foreach ($abbottmodels->where('mcategory_id', $mc->id) as $am)
                                                                    <option value="{{ $am->id }}">
                                                                        {{ $am->model_code }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- [ Serial Number ] Input -->
                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="model_sns_{{ $mc->id }}"
                                                                class="form-label">Serial Number</label>
                                                            <input type="text" name="model_sns[]"
                                                                class="form-control sn-input"
                                                                placeholder="Enter Serial Number">
                                                        </div>
                                                    </div>

                                                    <!-- [ Model Price ] Input -->
                                                    <div class="col-sm-2">
                                                        <div class="mb-3">
                                                            <label for="model_price_{{ $mc->id }}"
                                                                class="form-label">Price (RM)</label>
                                                            <input type="text" name="model_price[]"
                                                                class="form-control price-input"
                                                                placeholder="Enter Model Price (RM)">
                                                        </div>
                                                    </div>

                                                    <!-- [ Model Quantity ] Input -->
                                                    <div class="col-sm-1">
                                                        <div class="mb-3">
                                                            <label for="model_qty_{{ $mc->id }}"
                                                                class="form-label">Quantity</label>
                                                            <input type="text" name="model_qty[]"
                                                                class="form-control qty-input"
                                                                placeholder="Enter Quantity" value="1">
                                                        </div>
                                                    </div>

                                                    <!-- [ Stock Location ] Input -->
                                                    <div class="col-sm-2">
                                                        <div class="mb-3">
                                                            <label for="stock_location_ids_{{ $mc->id }}"
                                                                class="form-label">Stock Location</label>
                                                            <select name="stock_location_ids[]"
                                                                class="form-select stock-location-select">
                                                                <option value="" selected>Select Stock Location
                                                                </option>
                                                                @foreach ($stocklocations as $sl)
                                                                    <option value="{{ $sl->id }}">
                                                                        ({{ $sl->stock_location_code }})
                                                                        -
                                                                        {{ $sl->stock_location_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- [ Remove Button ] -->
                                                    <div class="col-sm-1 d-flex align-items-center justify-content-center">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm shadow-none remove-row">
                                                            <i class="ti ti-trash f-20"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- [ Add Row Button ] -->
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="d-grid">
                                                        <button type="button" class="btn btn-light-primary mt-2 add-row"
                                                            data-category="{{ $mc->id }}">
                                                            <i class="ti ti-plus"></i> Add Model
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        @else
                                            <div class="row model-loop">

                                                <!-- [ Model ] Input -->
                                                <div class="col-sm-3">
                                                    <div class="mb-3">
                                                        <label for="model_ids_{{ $mc->id }}"
                                                            class="form-label">Model</label>
                                                        <select name="model_ids[]" class="form-select model-select">
                                                            <option value="" selected>Select Model</option>
                                                            @foreach ($abbottmodels->where('mcategory_id', $mc->id) as $am)
                                                                <option value="{{ $am->id }}">{{ $am->model_code }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- [ Serial Number ] Input -->
                                                <div class="col-sm-3">
                                                    <div class="mb-3">
                                                        <label for="model_sns_{{ $mc->id }}"
                                                            class="form-label">Serial Number</label>
                                                        <input type="text" name="model_sns[]"
                                                            class="form-control sn-input"
                                                            placeholder="Enter Serial Number">
                                                    </div>
                                                </div>

                                                <!-- [ Model Price ] Input -->
                                                <div class="col-sm-2">
                                                    <div class="mb-3">
                                                        <label for="model_price_{{ $mc->id }}"
                                                            class="form-label">Price (RM)</label>
                                                        <input type="text" name="model_price[]"
                                                            class="form-control price-input"
                                                            placeholder="Enter Model Price (RM)">
                                                    </div>
                                                </div>

                                                <!-- [ Model Quantity ] Input -->
                                                <div class="col-sm-1">
                                                    <div class="mb-3">
                                                        <label for="model_qty_{{ $mc->id }}"
                                                            class="form-label">Quantity</label>
                                                        <input type="text" name="model_qty[]"
                                                            class="form-control qty-input" placeholder="Enter Quantity"
                                                            value="1">
                                                    </div>
                                                </div>

                                                <!-- [ Stock Location ] Input -->
                                                <div class="col-sm-2">
                                                    <div class="mb-3">
                                                        <label for="stock_location_ids_{{ $mc->id }}"
                                                            class="form-label">Stock Location</label>
                                                        <select name="stock_location_ids[]"
                                                            class="form-select stock-location-select">
                                                            <option value="" selected>Select Stock Location</option>
                                                            @foreach ($stocklocations as $sl)
                                                                <option value="{{ $sl->id }}">
                                                                    ({{ $sl->stock_location_code }})
                                                                    -
                                                                    {{ $sl->stock_location_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-1 d-flex align-items-center justify-content-center">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm shadow-none reset-row" disabled>
                                                        <i class="ti ti-trash f-20"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    <hr class="my-4" />

                                    <!-- [ Patient Name ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_pt_name" class="form-label">Patient Name <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="text" name="implant_pt_name" id="implant_pt_name"
                                                class="form-control @error('implant_pt_name') is-invalid @enderror"
                                                placeholder="Enter Patient Name" value="{{ old('implant_pt_name') }}"
                                                required>
                                            @error('implant_pt_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Patient IC Number ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_pt_icno" class="form-label">
                                                Patient IC/Passport Number
                                                <span class="text-danger fw-bold">*</span>
                                            </label>
                                            <input type="text" name="implant_pt_icno" id="implant_pt_icno"
                                                class="form-control @error('implant_pt_icno') is-invalid @enderror"
                                                placeholder="Enter Patient IC/Passport Number"
                                                value="{{ old('implant_pt_icno') }}" required>
                                            @error('implant_pt_icno')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Patient DOB ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_pt_dob" class="form-label">Patient Date of Birth</label>
                                            <input type="date" name="implant_pt_dob" id="implant_pt_dob"
                                                class="form-control @error('implant_pt_dob') is-invalid @enderror"
                                                placeholder="Enter Patient Phone Number"
                                                value="{{ old('implant_pt_dob') }}">
                                            @error('implant_pt_dob')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Patient MRN ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_pt_mrn" class="form-label">Patient MRN</label>
                                            <input type="text" name="implant_pt_mrn" id="implant_pt_mrn"
                                                class="form-control @error('implant_pt_mrn') is-invalid @enderror"
                                                placeholder="Enter Patient MRN Number"
                                                value="{{ old('implant_pt_mrn') }}">
                                            @error('implant_pt_mrn')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Patient Email ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_pt_email" class="form-label">Patient Email</label>
                                            <input type="email" name="implant_pt_email" id="implant_pt_email"
                                                class="form-control @error('implant_pt_email') is-invalid @enderror"
                                                placeholder="Enter Patient Email" value="{{ old('implant_pt_email') }}">
                                            @error('implant_pt_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Patient Phone No ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_pt_phoneno" class="form-label">Patient Phone
                                                Number</label>
                                            <input type="text" name="implant_pt_phoneno" id="implant_pt_phoneno"
                                                class="form-control @error('implant_pt_phoneno') is-invalid @enderror"
                                                placeholder="Enter Patient Phone Number"
                                                value="{{ old('implant_pt_phoneno') }}">
                                            @error('implant_pt_phoneno')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Patient Address ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_pt_address" class="form-label">Patient Address</label>
                                            <textarea name="implant_pt_address" id="implant_pt_address"
                                                class="form-control @error('implant_pt_address') is-invalid @enderror" placeholder="Enter Patient Address"
                                                row="6">{{ old('implant_pt_address') }}</textarea>
                                            @error('implant_pt_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr class="my-4" />

                                    <!-- [ Invoice Number ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_invoice_no" class="form-label">Invoice Number</label>
                                            <input type="text" name="implant_invoice_no" id="implant_invoice_no"
                                                class="form-control @error('implant_invoice_no') is-invalid @enderror"
                                                placeholder="Enter Invoice Number"
                                                value="{{ old('implant_pt_mrn') != null ? old('implant_pt_mrn') : 'To Bill' }}">
                                            @error('implant_invoice_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Sales Amount ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_sales" class="form-label">
                                                Sales Amount
                                                <span class="text-danger fw-bold">*</span>
                                            </label>
                                            <input type="text" name="implant_sales" id="implant_sales"
                                                class="form-control price-input @error('implant_sales') is-invalid @enderror"
                                                placeholder="Enter Sales Amount" value="{{ old('implant_sales') }}"
                                                required>
                                            @error('implant_sales')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Remarks ] Input -->
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="implant_remark" class="form-label">
                                                Remarks
                                            </label>
                                            <textarea name="implant_remark" id="implant_remark"
                                                class="form-control @error('implant_remark') is-invalid @enderror" placeholder="Enter Remarks">{{ old('implant_remark') }}</textarea>
                                            @error('implant_remark')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Notes ] Input -->
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="implant_note" class="form-label">
                                                Notes
                                            </label>
                                            <textarea name="implant_note" id="implant_note" class="form-control @error('implant_note') is-invalid @enderror"
                                                placeholder="Enter Notes">{{ old('implant_note') }}</textarea>
                                            @error('implant_note')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Approval Type ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_approval_type" class="form-label">
                                                Approval Type
                                            </label>
                                            <input type="text" name="implant_approval_type" id="implant_approval_type"
                                                class="form-control @error('implant_approve_type') is-invalid @enderror"
                                                placeholder="Enter Approval Type"
                                                value="{{ old('implant_approval_type') }}">
                                            @error('implant_approval_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary" id="add-implant-btn">Add Implant</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- [ Add Implant ] end -->
            </div> --}}

            <div class="row">
                <!-- [ Add Implant ] start -->
                <div class="col-sm-12">
                    <form action="{{ route('add-implant-post') }}" method="POST" id="add-implant-form">
                        @csrf
                        <div class="card border-0">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-plus-circle me-2"></i>Add Implant
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Implant Details Section -->
                                <div class="form-section">
                                    <h5 class="section-title">Implant Details</h5>

                                    <div class="row">
                                        <!-- [ Date of Implant ] Input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="implant_date" class="form-label">Date of Implant <span
                                                    class="required-star">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-calendar-alt"></i></span>
                                                <input type="date" name="implant_date"
                                                    class="form-control @error('implant_date') is-invalid @enderror"
                                                    id="implant_date" required>
                                                @error('implant_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- [ Region ] Input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="region_id" class="form-label">Region <span
                                                    class="required-star">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-globe-asia"></i></span>
                                                <select name="region_id" id="region_id"
                                                    class="form-select @error('region_id') is-invalid @enderror" required>
                                                    <option value="">Select Region</option>
                                                    @foreach ($regions as $rgn)
                                                        @if (old('region_id') == $rgn->id)
                                                            <option value="{{ $rgn->id }}" selected>
                                                                {{ $rgn->region_name }}</option>
                                                        @else
                                                            <option value="{{ $rgn->id }}">{{ $rgn->region_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('region_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- [ Hospital ] Input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="hospital_id" class="form-label">Hospital <span
                                                    class="required-star">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-hospital"></i></span>
                                                <select name="hospital_id" id="hospital_id"
                                                    class="form-select @error('hospital_id') is-invalid @enderror" required>
                                                    <option value="" selected>Select Hospital</option>
                                                    @foreach ($hospitals as $hs)
                                                        @if (old('hospital_id') == $hs->id)
                                                            <option value="{{ $hs->id }}" selected>
                                                                {{ $hs->hospital_name }}</option>
                                                        @else
                                                            <option value="{{ $hs->id }}">{{ $hs->hospital_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('hospital_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- [ Doctor ] Input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="implant_doctor_id" class="form-label">Doctor <span
                                                    class="required-star">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-user-md"></i></span>
                                                <select name="doctor_id" id="implant_doctor_id"
                                                    class="form-select @error('doctor_id') is-invalid @enderror" required>
                                                    <option value="" selected>Select Doctor</option>
                                                    @foreach ($doctors as $dr)
                                                        @if (old('doctor_id') == $dr->id)
                                                            <option value="{{ $dr->id }}" selected>
                                                                {{ $dr->doctor_name }}</option>
                                                        @else
                                                            <option value="{{ $dr->id }}">{{ $dr->doctor_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('doctor_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Group Section -->
                                <div class="form-section">
                                    <h5 class="section-title">Product Group</h5>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="product-group-container">
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach ($pgs as $pg)
                                                        <input type="checkbox" class="btn-check" name="product_groups[]"
                                                            value="{{ $pg->product_group_name }}"
                                                            id="{{ $pg->id }}">
                                                        <label class="btn btn-outline-dark" for="{{ $pg->id }}">
                                                            {{ $pg->product_group_name }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                                @error('product_groups')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Generator Section -->
                                <div class="form-section">
                                    <h5 class="section-title">Generator</h5>

                                    <div class="row">
                                        <!-- [ Generator Model ] Input -->
                                        <div class="col-md-3 mb-3">
                                            <label for="generator_id" class="form-label">Model <span
                                                    class="required-star">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-microchip"></i></span>
                                                <select name="generator_id" id="generator_id"
                                                    class="form-select @error('generator_id') is-invalid @enderror"
                                                    required>
                                                    <option value="" selected>Select Model</option>
                                                    @foreach ($generators as $g)
                                                        @if (old('generator_id') == $g->id)
                                                            <option value="{{ $g->id }}" selected>
                                                                {{ $g->generator_code }}</option>
                                                        @else
                                                            <option value="{{ $g->id }}">{{ $g->generator_code }}
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
                                        <div class="col-md-3 mb-3">
                                            <label for="implant_generator_sn" class="form-label">Serial Number <span
                                                    class="required-star">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-barcode"></i></span>
                                                <input type="text" name="implant_generator_sn"
                                                    id="implant_generator_sn"
                                                    class="form-control sn-input @error('implant_generator_sn') is-invalid @enderror"
                                                    placeholder="Enter Serial Number" required>
                                                @error('implant_generator_sn')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- [ Generator Stock Location ] Input -->
                                        <div class="col-md-3 mb-3">
                                            <label for="stock_location_id" class="form-label">Stock Location <span
                                                    class="required-star">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-warehouse"></i></span>
                                                <select name="stock_location_id" id="stock_location_id"
                                                    class="form-select @error('stock_location_id') is-invalid @enderror"
                                                    required>
                                                    <option value="" selected>Select Stock Location</option>
                                                    @foreach ($stocklocations as $sl)
                                                        @if (old('stock_location_id') == $sl->id)
                                                            <option value="{{ $sl->id }}" selected>
                                                                ({{ $sl->stock_location_code }})
                                                                -
                                                                {{ $sl->stock_location_name }}</option>
                                                        @else
                                                            <option value="{{ $sl->id }}">
                                                                ({{ $sl->stock_location_code }}) -
                                                                {{ $sl->stock_location_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('stock_location_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- [ Generator Quantity ] Input -->
                                        <div class="col-md-1 mb-3">
                                            <label for="implant_generator_qty" class="form-label">Quantity</label>
                                            <input type="text" name="implant_generator_qty"
                                                class="form-control qty-input @error('implant_generator_qty') is-invalid @enderror"
                                                placeholder="Qty" value="1">
                                            @error('implant_generator_qty')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- [ Generator Price ] Input -->
                                        <div class="col-md-2 mb-3">
                                            <label for="implant_generator_itemPrice" class="form-label">Price (RM)</label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon">RM</span>
                                                <input type="text" name="implant_generator_itemPrice"
                                                    class="form-control price-input @error('implant_generator_sn') is-invalid @enderror"
                                                    placeholder="0.00">
                                                @error('implant_generator_sn')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Model Categories Section -->
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

                                        @if ($mc->mcategory_ismorethanone == 1)
                                            <div id="model_container_{{ $mc->id }}">
                                                <div class="model-loop">
                                                    <div class="row">
                                                        <!-- [ Model ] Input -->
                                                        <div class="col-md-3 mb-3">
                                                            <label class="form-label">Model</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text input-icon"><i
                                                                        class="fas fa-microchip"></i></span>
                                                                <select name="model_ids[]"
                                                                    class="form-select model-select @error('model_ids') is-invalid @enderror">
                                                                    <option value="" selected>Select Model</option>
                                                                    @foreach ($abbottmodels->where('mcategory_id', $mc->id) as $am)
                                                                        <option value="{{ $am->id }}">
                                                                            {{ $am->model_code }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('model_ids')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <!-- [ Serial Number ] Input -->
                                                        <div class="col-md-3 mb-3">
                                                            <label class="form-label">Serial Number</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text input-icon"><i
                                                                        class="fas fa-barcode"></i></span>
                                                                <input type="text" name="model_sns[]"
                                                                    class="form-control sn-input @error('model_sns') is-invalid @enderror"
                                                                    placeholder="Enter Serial Number">
                                                                @error('model_sns')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <!-- [ Stock Location ] Input -->
                                                        <div class="col-md-2 mb-3">
                                                            <label class="form-label">Stock Location</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text input-icon"><i
                                                                        class="fas fa-warehouse"></i></span>
                                                                <select name="stock_location_ids[]"
                                                                    class="form-select stock-location-select @error('stock_location_ids') is-invalid @enderror">
                                                                    <option value="" selected>Select Location
                                                                    </option>
                                                                    @foreach ($stocklocations as $sl)
                                                                        <option value="{{ $sl->id }}">
                                                                            ({{ $sl->stock_location_code }})
                                                                            -
                                                                            {{ $sl->stock_location_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('stock_location_ids')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <!-- [ Model Quantity ] Input -->
                                                        <div class="col-md-1 mb-3">
                                                            <label class="form-label">Quantity</label>
                                                            <input type="text" name="model_qty[]"
                                                                class="form-control qty-input @error('model_qty') is-invalid @enderror"
                                                                placeholder="Qty" value="1">
                                                            @error('model_qty')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <!-- [ Model Price ] Input -->
                                                        <div class="col-md-2 mb-3">
                                                            <label class="form-label">Price (RM)</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text input-icon">RM</span>
                                                                <input type="text" name="model_price[]"
                                                                    class="form-control price-input @error('model_price') is-invalid @enderror"
                                                                    placeholder="0.00">
                                                                @error('model_price')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <!-- [ Remove Button ] -->
                                                        <div class="col-lg-1 col-md-2 mb-4 d-flex align-items-end">
                                                            <button type="button"
                                                                class="btn btn-remove btn-sm remove-row w-100">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="model-loop">
                                                <div class="row">
                                                    <!-- [ Model ] Input -->
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Model</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text input-icon"><i
                                                                    class="fas fa-microchip"></i></span>
                                                            <select name="model_ids[]"
                                                                class="form-select model-select @error('model_ids') is-invalid @enderror">
                                                                <option value="" selected>Select Model</option>
                                                                @foreach ($abbottmodels->where('mcategory_id', $mc->id) as $am)
                                                                    <option value="{{ $am->id }}">
                                                                        {{ $am->model_code }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('model_ids')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- [ Serial Number ] Input -->
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Serial Number</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text input-icon"><i
                                                                    class="fas fa-barcode"></i></span>
                                                            <input type="text" name="model_sns[]"
                                                                class="form-control sn-input @error('model_sns') is-invalid @enderror"
                                                                placeholder="Enter Serial Number">
                                                            @error('model_sns')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- [ Stock Location ] Input -->
                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label">Stock Location</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text input-icon"><i
                                                                    class="fas fa-warehouse"></i></span>
                                                            <select name="stock_location_ids[]"
                                                                class="form-select stock-location-select @error('stock_location_ids') is-invalid @enderror">
                                                                <option value="" selected>Select Location</option>
                                                                @foreach ($stocklocations as $sl)
                                                                    <option value="{{ $sl->id }}">
                                                                        ({{ $sl->stock_location_code }})
                                                                        -
                                                                        {{ $sl->stock_location_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('stock_location_ids')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <!-- [ Model Quantity ] Input -->
                                                    <div class="col-md-1 mb-3">
                                                        <label class="form-label">Quantity</label>
                                                        <input type="text" name="model_qty[]"
                                                            class="form-control qty-input @error('model_qty') is-invalid @enderror"
                                                            placeholder="Qty" value="1">
                                                        @error('model_qty')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>


                                                    <!-- [ Model Price ] Input -->
                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label">Price (RM)</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text input-icon">RM</span>
                                                            <input type="text" name="model_price[]"
                                                                class="form-control price-input @error('model_price') is-invalid @enderror"
                                                                placeholder="0.00">
                                                            @error('model_price')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-1 col-md-2 mb-4 d-flex align-items-center">
                                                        <button type="button"
                                                            class="btn btn-remove btn-sm reset-row w-100" disabled>
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach

                                <!-- Patient Information Section -->
                                <div class="form-section">
                                    <h5 class="section-title">Patient Information</h5>

                                    <div class="row">
                                        <!-- [ Patient Name ] Input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="implant_pt_name" class="form-label">Patient Name <span
                                                    class="required-star">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-user"></i></span>
                                                <input type="text" name="implant_pt_name" id="implant_pt_name"
                                                    class="form-control @error('implant_pt_name') is-invalid @enderror"
                                                    placeholder="Enter Patient Name" required>
                                                @error('implant_pt_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- [ Patient IC Number ] Input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="implant_pt_icno" class="form-label">Patient IC/Passport Number
                                                <span class="required-star">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-id-card"></i></span>
                                                <input type="text" name="implant_pt_icno" id="implant_pt_icno"
                                                    class="form-control @error('implant_pt_icno') is-invalid @enderror"
                                                    placeholder="Enter Patient IC/Passport Number" required>
                                                @error('implant_pt_icno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- [ Patient DOB ] Input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="implant_pt_dob" class="form-label">Patient Date of Birth</label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-birthday-cake"></i></span>
                                                <input type="date" name="implant_pt_dob" id="implant_pt_dob"
                                                    class="form-control @error('implant_pt_dob') is-invalid @enderror">
                                                @error('implant_pt_dob')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- [ Patient MRN ] Input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="implant_pt_mrn" class="form-label">Patient MRN</label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-hospital"></i></span>
                                                <input type="text" name="implant_pt_mrn" id="implant_pt_mrn"
                                                    class="form-control @error('implant_pt_mrn') is-invalid @enderror"
                                                    placeholder="Enter Patient MRN Number">
                                                @error('implant_pt_mrn')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- [ Patient Email ] Input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="implant_pt_email" class="form-label">Patient Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-envelope"></i></span>
                                                <input type="email" name="implant_pt_email" id="implant_pt_email"
                                                    class="form-control @error('implant_pt_email') is-invalid @enderror"
                                                    placeholder="Enter Patient Email">
                                                @error('implant_pt_email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- [ Patient Phone No ] Input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="implant_pt_phoneno" class="form-label">Patient Phone
                                                Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-phone"></i></span>
                                                <input type="text" name="implant_pt_phoneno" id="implant_pt_phoneno"
                                                    class="form-control @error('implant_pt_phoneno') is-invalid @enderror"
                                                    placeholder="Enter Patient Phone Number">
                                                @error('implant_pt_phoneno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- [ Patient Address ] Input -->
                                        <div class="col-md-12 mb-3">
                                            <label for="implant_pt_address" class="form-label">Patient Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-map-marker-alt"></i></span>
                                                <textarea name="implant_pt_address" id="implant_pt_address"
                                                    class="form-control @error('implant_pt_address') is-invalid @enderror" placeholder="Enter Patient Address"
                                                    rows="3"></textarea>
                                                @error('implant_pt_address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Invoice & Sales Information Section -->
                                <div class="form-section">
                                    <h5 class="section-title">Invoice & Sales Information</h5>

                                    <div class="row">
                                        <!-- [ Invoice Number ] Input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="implant_invoice_no" class="form-label">Invoice Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-file-invoice"></i></span>
                                                <input type="text" name="implant_invoice_no" id="implant_invoice_no"
                                                    class="form-control @error('implant_invoice_no') is-invalid @enderror"
                                                    placeholder="Enter Invoice Number">
                                                @error('implant_invoice_no')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- [ Sales Amount ] Input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="implant_sales" class="form-label">Sales Amount <span
                                                    class="required-star">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon">RM</span>
                                                <input type="text" name="implant_sales" id="implant_sales"
                                                    class="form-control price-input @error('implant_sales') is-invalid @enderror"
                                                    placeholder="Enter Sales Amount" required>
                                                @error('implant_sales')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- [ Approval Type ] Input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="implant_approval_type" class="form-label">Approval Type</label>
                                            <div class="input-group">
                                                <span class="input-group-text input-icon"><i
                                                        class="fas fa-check-circle"></i></span>
                                                <input type="text" name="implant_approval_type"
                                                    id="implant_approval_type"
                                                    class="form-control @error('implant_approval_type') is-invalid @enderror"
                                                    placeholder="Enter Approval Type">
                                                @error('implant_approval_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information Section -->
                                <div class="form-section">
                                    <h5 class="section-title">Additional Information</h5>

                                    <div class="row">
                                        <!-- [ Remarks ] Input -->
                                        <div class="col-md-12 mb-3">
                                            <label for="implant_remark" class="form-label">Remarks</label>
                                            <textarea name="implant_remark" id="implant_remark"
                                                class="form-control @error('implant_remark') is-invalid @enderror" placeholder="Enter Remarks" rows="3"></textarea>
                                            @error('implant_remark')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- [ Notes ] Input -->
                                        <div class="col-md-12 mb-3">
                                            <label for="implant_note" class="form-label">Notes</label>
                                            <textarea name="implant_note" id="implant_note" class="form-control @error('implant_note') is-invalid @enderror"
                                                placeholder="Enter Notes" rows="3"></textarea>
                                            @error('implant_note')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer  d-flex align-items-center justify-content-end">
                                <button type="submit" class="btn btn-primary btn-submit  d-flex align-items-center" id="add-implant-btn">
                                    <i class="ti ti-circle-plus me-2"></i> Add Implant
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <script>
        $(document).ready(function() {

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
                });
            });

            $(document).on('click', '.remove-row:not(:first)', function() {
                $(this).closest('.model-loop').remove();
            });

            $('#add-implant-form').on('submit', function() {
                $('#add-implant-btn').addClass('disabled-a', true).html(
                    '<span class="spinner-border spinner-border-sm me-2"></span> Adding...'
                );
            });
        });
    </script>
@endsection
<!-- [ Main Content ] end -->
