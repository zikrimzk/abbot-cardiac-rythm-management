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
            <div class="row">
                <!-- [ Add Implant ] start -->
                <div class="col-sm-12">
                    <form action="">
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
                                            <label for="implant_region_id" class="form-label">Region <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select name="implant_region_id" id="implant_region_id"
                                                class="form-select @error('implant_region_id') is-invalid @enderror"
                                                required>
                                                <option value="">Select Region</option>
                                                @foreach ($regions as $rgn)
                                                    @if (old('implant_region_id') == $rgn->id)
                                                        <option value="{{ $rgn->id }}" selected>{{ $rgn->region_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $rgn->id }}">{{ $rgn->region_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('implant_region_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Hospital ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_hospital_id" class="form-label">Hospital <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select name="implant_hospital_id" id="implant_hospital_id"
                                                class="form-select @error('implant_hospital_id') is-invalid @enderror"
                                                required>
                                                <option value="" selected>Select Hospital</option>
                                                @foreach ($hospitals as $hs)
                                                    @if (old('implant_hospital_id') == $hs->id)
                                                        <option value="{{ $hs->id }}" selected>
                                                            {{ $hs->hospital_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $hs->id }}">{{ $hs->hospital_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('implant_hospital_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Doctor ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_doctor_id" class="form-label">Doctor <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select name="implant_doctor_id" id="implant_doctor_id" class="form-select"
                                                required>
                                                <option value="" selected>Select Doctor</option>
                                                @foreach ($doctors as $dr)
                                                    @if (old('implant_doctor_id') == $dr->id)
                                                        <option value="{{ $dr->id }}" selected>
                                                            {{ $dr->doctor_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
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
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="generator_id" class="form-label">Model</label>
                                            <select name="generator_id" id="generator_id"
                                                class="form-select @error('generator_id') is-invalid @enderror" required>
                                                <option value="" selected>Select Model</option>
                                                @foreach ($generators as $g)
                                                    <option value="{{ $g->id }}">{{ $g->generator_code }}</option>
                                                @endforeach
                                            </select>
                                            @error('generator_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- [ Generator Serial Number ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_generator_sn" class="form-label">Serial
                                                Number</label>

                                            <input type="text" name="implant_generator_sn" id="implant_generator_sn"
                                                class="form-control @error('implant_generator_sn') is-invalid @enderror"
                                                placeholder="Enter Serial Number" required>
                                            @error('implant_generator_sn')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    @foreach ($mcs as $mc)
                                        <h5 class="mt-4">{{ $mc->mcategory_name }}</h5>

                                        <!-- [ Model ] Input -->
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Model</label>
                                                <select name="" id=""
                                                    class="form-select @error('') is-invalid @enderror">
                                                    <option value="" selected>Select Model</option>
                                                    @foreach ($abbottmodels->where('mcategory_id', $mc->id) as $am)
                                                        <option value="{{ $am->id }}">{{ $am->model_code }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- [ Generator Serial Number ] Input -->
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Serial
                                                    Number</label>

                                                <input type="text" name="" id=""
                                                    class="form-control @error('') is-invalid @enderror"
                                                    placeholder="Enter Serial Number">
                                                @error('')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach

                                    <hr class="my-4" />

                                    <!-- [ Patient Name ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_pt_name" class="form-label">Patient Name<span
                                                    class="text-danger fw-bold">*</span></label>

                                            <input type="text" name="implant_pt_name" id="implant_pt_name"
                                                class="form-control @error('implant_pt_name') is-invalid @enderror"
                                                placeholder="Patient Name" required>
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
                                                placeholder="Patient IC Number" required>
                                            @error('implant_pt_icno')
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
                                                placeholder="Patient MRN Number">
                                            @error('implant_pt_mrn')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr class="my-4" />

                                    <!-- [ Invoice Number ] Input -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="implant_inv_no" class="form-label">Invoice Number</label>

                                            <input type="text" name="implant_inv_no" id="implant_inv_no"
                                                class="form-control @error('implant_inv_no') is-invalid @enderror"
                                                placeholder="Invoice Number" value="To Bill">
                                            @error('implant_inv_no')
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
                                                placeholder="Sales Amount">
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
                                                class="form-control @error('implant_remark') is-invalid @enderror" placeholder="Remarks"></textarea>
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
                                                placeholder="Notes"></textarea>
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
                                                placeholder="Approval Type">
                                            @error('implant_approval_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="reset" class="btn btn-light-danger">Reset</button>
                                <button type="submit" class="btn btn-primary">Add Implant</button>
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

            // AJAX : Get Doctors by Hospital
            $('#implant_hospital_id').on('change', function() {
                let hospital_id = $(this).val();
                $('#implant_doctor_id').empty().append('<option value="">Loading...</option>');

                if (hospital_id) {
                    $.ajax({
                        url: '{{ route('doctorbyhospital-get') }}',
                        type: 'GET',
                        data: {
                            hospital_id: hospital_id
                        },
                        success: function(response) {
                            $('#implant_doctor_id').empty().append(
                                '<option value="">Select Doctor</option>');
                            $.each(response, function(key, doctor) {
                                $('#implant_doctor_id').append('<option value="' +
                                    doctor.id + '">' + doctor.doctor_name +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#implant_doctor_id').empty().append('<option value="">Select Doctor</option>');
                }
            });
        });
    </script>
@endsection
<!-- [ Main Content ] end -->
