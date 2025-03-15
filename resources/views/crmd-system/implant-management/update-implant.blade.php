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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Implant</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('manage-implant-page') }}">Manage Implant</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Update Implant</li>
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
            <div class="row">
                <!-- [ Add Implant ] start -->
                <div class="col-sm-12">
                    <form action="{{ route('update-implant-post', Crypt::encrypt($im->id)) }}" method="POST"
                        id="update-implant-form">
                        @csrf
                        <div class="card">
                            <div class="card-header bg-light-primary text-primary">
                                <h5 class="card-title">
                                    Update Implant
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
                                                id="implant_date" value="{{ $im->implant_date }}" required>
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
                                                @foreach ($regions as $rgn)
                                                    @if ($im->region_id == $rgn->id)
                                                        <option value="{{ $rgn->id }}" selected>{{ $rgn->region_name }}
                                                        </option>
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
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="hospital_id" class="form-label">Hospital <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select name="hospital_id" id="hospital_id"
                                                class="form-select @error('hospital_id') is-invalid @enderror" required>
                                                @foreach ($hospitals as $hs)
                                                    @if ($im->hospital_id == $hs->id)
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
                                                    @if ($im->doctor_id == $dr->id)
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
                                                    @php
                                                        $checked = in_array(
                                                            $pg->id,
                                                            $pgslist->pluck('product_group_id')->toArray(),
                                                        );
                                                    @endphp
                                                    <input type="checkbox" class="btn-check" name="product_groups[]"
                                                        value="{{ $pg->id }}" id="pg_{{ $pg->id }}"
                                                        {{ $checked ? 'checked' : '' }}>
                                                    <label class="btn btn-outline-dark"
                                                        for="pg_{{ $pg->id }}">{{ $pg->product_group_name }}</label>
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
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="generator_id" class="form-label">Model <span
                                                    class="text-danger">*</span></label>
                                            <select name="generator_id" id="generator_id"
                                                class="form-select @error('generator_id') is-invalid @enderror" required>
                                                @foreach ($generators as $g)
                                                    @if ($im->generator_id == $g->id)
                                                        <option value="{{ $g->id }}" selected>
                                                            {{ $g->generator_code }}
                                                        </option>
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
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="implant_generator_sn" class="form-label">Serial
                                                Number <span class="text-danger">*</span></label>
                                            <input type="text" name="implant_generator_sn" id="implant_generator_sn"
                                                class="form-control sn-input @error('implant_generator_sn') is-invalid @enderror"
                                                placeholder="Enter Serial Number" value="{{ $im->implant_generator_sn }}"
                                                required>
                                            @error('implant_generator_sn')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Generator Stock Location ] Input -->
                                    <div class="col-sm-4">
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
                                            $categoryImplants = $ims->filter(function ($imd) use ($abbottmodels, $mc) {
                                                $model = $abbottmodels->firstWhere('id', $imd->model_id);
                                                return $model && $model->mcategory_id == $mc->id;
                                            });

                                            if ($categoryImplants->isEmpty()) {
                                                $categoryImplants = collect([
                                                    (object) [
                                                        'model_id' => null,
                                                        'implant_model_sn' => null,
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
                                                        <div class="col-sm-4">
                                                            <div class="mb-3">
                                                                <label
                                                                    for="model_ids_{{ $mc->id }}_{{ $index }}"
                                                                    class="form-label">Model</label>
                                                                <select name="model_ids[]"
                                                                    id="model_ids_{{ $mc->id }}_{{ $index }}"
                                                                    class="form-select @error('model_ids') is-invalid @enderror model-select">
                                                                    <option value="" selected>Select Model</option>
                                                                    @foreach ($abbottmodels->where('mcategory_id', $mc->id) as $am)
                                                                        <option value="{{ $am->id }}"
                                                                            {{ $imd->model_id == $am->id ? 'selected' : '' }}>
                                                                            {{ $am->model_code }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('model_ids')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <!-- [ Serial Number ] Input -->
                                                        <div class="col-sm-4">
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
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <!-- [ Stock Location ] Input -->
                                                        <div class="col-sm-3">
                                                            <div class="mb-3">
                                                                <label
                                                                    for="stock_location_ids_{{ $mc->id }}_{{ $index }}"
                                                                    class="form-label">Stock Location</label>
                                                                <select name="stock_location_ids[]"
                                                                    id="stock_location_ids_{{ $mc->id }}_{{ $index }}"
                                                                    class="form-select @error('stock_location_ids') is-invalid @enderror stock-location-select">
                                                                    <option value="" selected>Select Stock Location
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
                                                                    <div class="invalid-feedback">{{ $message }}</div>
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
                                                        <button type="button" class="btn btn-light-primary mt-2 add-row"
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
                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label
                                                                for="model_ids_{{ $mc->id }}_{{ $index }}"
                                                                class="form-label">Model</label>
                                                            <select name="model_ids[]"
                                                                id="model_ids_{{ $mc->id }}_{{ $index }}"
                                                                class="form-select @error('model_ids') is-invalid @enderror model-select">
                                                                <option value="" selected>Select Model</option>
                                                                @foreach ($abbottmodels->where('mcategory_id', $mc->id) as $am)
                                                                    <option value="{{ $am->id }}"
                                                                        {{ $imd->model_id == $am->id ? 'selected' : '' }}>
                                                                        {{ $am->model_code }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('model_ids')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- [ Serial Number ] Input -->
                                                    <div class="col-sm-4">
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
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- [ Stock Location ] Input -->
                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label
                                                                for="stock_location_ids_{{ $mc->id }}_{{ $index }}"
                                                                class="form-label">Stock Location</label>
                                                            <select name="stock_location_ids[]"
                                                                id="stock_location_ids_{{ $mc->id }}_{{ $index }}"
                                                                class="form-select @error('stock_location_ids') is-invalid @enderror stock-location-select">
                                                                <option value="" selected>Select Stock Location
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
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- [ Dustbin Button ] -->
                                                    <div class="col-sm-1 d-flex align-items-center justify-content-center">
                                                        <button type="button"
                                                            class="avtar avtar-xs  btn btn-danger shadow-none reset-row"
                                                            id="reset_{{ $mc->id }}_{{ $index }}" disabled>

                                                            <i class="ti ti-trash f-20"></i>

                                                        </button>
                                                    </div>

                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach



                                    <hr class="my-4" />

                                    <!-- [ Patient Name ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_pt_name" class="form-label">Patient Name<span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="text" name="implant_pt_name" id="implant_pt_name"
                                                class="form-control @error('implant_pt_name') is-invalid @enderror"
                                                placeholder="Enter Patient Name" value="{{ $im->implant_pt_name }}"
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
                                                Patient IC Number
                                                <span class="text-danger fw-bold">*</span>
                                            </label>
                                            <input type="text" name="implant_pt_icno" id="implant_pt_icno"
                                                class="form-control @error('implant_pt_icno') is-invalid @enderror"
                                                placeholder="Enter Patient IC Number" value="{{ $im->implant_pt_icno }}"
                                                required>
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
                                                value="{{ $im->implant_pt_dob }}">
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
                                                placeholder="Enter Patient MRN Number" value="{{ $im->implant_pt_mrn }}">
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
                                                placeholder="Enter Patient Email" value="{{ $im->implant_pt_email }}">
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
                                                value="{{ $im->implant_pt_phoneno }}">
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
                                                row="4">{{ $im->implant_pt_address }}</textarea>
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
                                                value="{{ $im->implant_invoice_no }}">
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
                                                class="form-control @error('implant_sales') is-invalid @enderror"
                                                placeholder="Enter Sales Amount" value="{{ $im->implant_sales }}"
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
                                                class="form-control @error('implant_remark') is-invalid @enderror" placeholder="Enter Remarks">{{ $im->implant_remark }}</textarea>
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
                                                placeholder="Enter Notes">{{ $im->implant_note }}</textarea>
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
                                                class="form-control @error('implant_approval_type') is-invalid @enderror"
                                                placeholder="Enter Approval Type"
                                                value="{{ $im->implant_approval_type }}">
                                            @error('implant_approval_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary" id="update-implant-btn">Save
                                    changes</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- [ Add Implant ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <script>
        $(document).ready(function() {

            // FORMAT : IC / PASSPORT
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

            // FORMAT : MONEY
            $("#implant_sales").on("input", function() {
                let value = $(this).val().replace(/[^0-9.]/g, "");
                let parts = value.split(".");

                // Pastikan hanya ada satu titik perpuluhan
                if (parts.length > 2) {
                    value = parts[0] + "." + parts[1];
                }

                $(this).val(value);
            });

            $("#implant_sales").on("blur", function() {
                let value = parseFloat($(this).val()).toFixed(2);
                if (!isNaN(value)) {
                    $(this).val(value);
                } else {
                    $(this).val(""); // Kosongkan jika invalid
                }
            });

            // FORMAT : SERIAL NUMBER
            $(".sn-input").on("input", function() {
                $(this).val($(this).val().toUpperCase());
            });

            // FUNCTION : RESET BUTTON
            function checkResetButton(loopContainer) {
                let modelSelected = loopContainer.find(".model-select").val();
                let serialNumber = loopContainer.find(".sn-input").val();
                let stockLocation = loopContainer.find(".stock-location-select").val();
                let dustbinBtn = loopContainer.find(".reset-row");

                // Aktifkan butang jika ada input dalam mana-mana field
                if (modelSelected || serialNumber || stockLocation) {
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

            $(document).on("change", ".stock-location-select", function() {
                checkResetButton($(this).closest(".model-loop"));
            });

            $(document).on("click", ".reset-row", function() {
                let loopContainer = $(this).closest(".model-loop");

                loopContainer.find(".model-select").val("").trigger("change");
                loopContainer.find(".sn-input").val("");
                loopContainer.find(".stock-location-select").val("");

                $(this).prop("disabled", true); // Disable balik bila reset
            });

            $(document).on("click", ".add-row", function() {
                let categoryID = $(this).data("category"); // Ambil ID kategori
                let container = $("#model_container_" + categoryID); // Ambil container yang betul

                if (container.length === 0) {
                    alert("Container tidak ditemui untuk kategori ID: " + categoryID);
                    return;
                }

                let lastRow = container.children(".model-loop").last(); // Cari row terakhir dalam kategori ini
                console.log("Last Row:", lastRow);

                let newRow = lastRow.clone();
                newRow.find("input, select").val(""); // Kosongkan input dalam row baru
                newRow.find(".remove-row").prop("disabled", false); // Pastikan butang boleh digunakan

                lastRow.after(newRow); // Tambah selepas row terakhir
                console.log("Row baru ditambah!", newRow);
            });

            $('.remove-row').each(function() {
                let row = $(this).closest('.model-loop');

                row.find('input, select').on('input', function() {
                    row.find('.remove-row').prop('disabled', false);
                });

                $(this).on('click', function() {
                    row.find('input, select').val('');
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

            $('#update-implant-form').on('submit', function() {
                $('#update-implant-btn').addClass('disabled-a', true).html(
                    '<span class="spinner-border spinner-border-sm me-2"></span> Saving...'
                );
            });
        });
    </script>
@endsection
<!-- [ Main Content ] end -->
