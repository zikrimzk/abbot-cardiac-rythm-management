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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Model</a></li>
                                <li class="breadcrumb-item" aria-current="page">Manage Model</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Manage Model</h2>
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
                <!-- [ Manage Model ] start -->

                <div class="col-sm-12">
                    <!-- [ Option ] start -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addModelModal"
                                    class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Add Model">
                                    <i class="ti ti-plus f-18"></i>
                                    <span class="d-none d-md-inline">Add Model</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- [ Option ] end -->

                    <div class="card">
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Model Code</th>
                                            <th scope="col">Model Name</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- [ Add Model Modal ] start -->
                <form action="{{ route('add-model-post') }}" method="POST">
                    @csrf
                    <div class="modal fade" id="addModelModal" tabindex="-1" aria-labelledby="addModelModal"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Add Model</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="model_name" class="form-label">Model Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('model_name') is-invalid @enderror"
                                                    id="model_name" name="model_name" placeholder="Enter Model Name"
                                                    value="{{ old('model_name') }}" required>
                                                @error('model_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="model_code" class="form-label">Model Code <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control input-code @error('model_code') is-invalid @enderror"
                                                    id="model_code" name="model_code" placeholder="Enter Model Code"
                                                    value="{{ old('model_code') }}" required>
                                                @error('model_code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="mcategory_id" class="form-label">Model Category <span
                                                        class="text-danger">*</span></label>
                                                <select name="mcategory_id" id="mcategory_id"
                                                    class="form-select @error('mcategory_id') is-invalid @enderror"
                                                    required>
                                                    <option value="" selected>Select Model Category</option>
                                                    @foreach ($mcs as $mc)
                                                        @if (old('mcategory_id') == $mc->id)
                                                            <option value="{{ $mc->id }}" selected>
                                                                {{ $mc->mcategory_name }}</option>
                                                        @else
                                                            <option value="{{ $mc->id }}">
                                                                {{ $mc->mcategory_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('mcategory_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="model_status" class="form-label">Model Status <span
                                                        class="text-danger">*</span></label>
                                                <select name="model_status" id="model_status"
                                                    class="form-select @error('model_status') is-invalid @enderror"
                                                    required>
                                                    <option value="" selected>Select Model Status</option>
                                                    @if (old('model_status') == 1)
                                                        <option value="1" selected>In Use</option>
                                                        <option value="2">Not In Use</option>
                                                    @elseif(old('model_status') == 2)
                                                        <option value="1">In Use</option>
                                                        <option value="2" selected>Not In Use</option>
                                                    @else
                                                        <option value="1">In Use</option>
                                                        <option value="2">Not In Use</option>
                                                    @endif
                                                </select>
                                                @error('model_status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
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
                                                    id="addApplicationBtn">Add
                                                    Modal</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <!-- [ Add Model Modal ] end -->

                @foreach ($ms as $m)
                    <!-- [ Update Model Modal ] start -->
                    <form action="{{ route('update-model-post', $m->id) }}" method="POST">
                        @csrf
                        <div class="modal fade" id="updateModelModal-{{ $m->id }}" tabindex="-1"
                            aria-labelledby="updateModelModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Model</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="model_name" class="form-label">Model Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('model_name') is-invalid @enderror"
                                                        id="model_name" name="model_name" placeholder="Enter Model Name"
                                                        value="{{ $m->model_name }}" required>
                                                    @error('model_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="model_code" class="form-label">Model Code <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control input-code @error('model_code') is-invalid @enderror"
                                                        id="model_code" name="model_code" placeholder="Enter Model Code"
                                                        value="{{ $m->model_code }}" required>
                                                    @error('model_code')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="mcategory_id" class="form-label">Model Category <span
                                                            class="text-danger">*</span></label>
                                                    <select name="mcategory_id" id="mcategory_id"
                                                        class="form-select @error('mcategory_id') is-invalid @enderror"
                                                        required>
                                                        @foreach ($mcs as $mc)
                                                            @if ($m->mcategory_id == $mc->id)
                                                                <option value="{{ $mc->id }}" selected>
                                                                    {{ $mc->mcategory_name }}</option>
                                                            @else
                                                                <option value="{{ $mc->id }}">
                                                                    {{ $mc->mcategory_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('mcategory_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="model_status" class="form-label">Model Status <span
                                                            class="text-danger">*</span></label>
                                                    <select name="model_status" id="model_status"
                                                        class="form-select @error('model_status') is-invalid @enderror"
                                                        required>
                                                        @if ($m->model_status == 1)
                                                            <option value="1" selected>In Use</option>
                                                            <option value="2">Not In Use</option>
                                                        @elseif($m->model_status == 2)
                                                            <option value="1">In Use</option>
                                                            <option value="2" selected>Not In Use</option>
                                                        @else
                                                            <option value="1">In Use</option>
                                                            <option value="2">Not In Use</option>
                                                        @endif
                                                    </select>
                                                    @error('model_status')
                                                        <div class="invalid-feedback">{{ $message }}</div>
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
                                                        id="updateApplicationBtn">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- [ Update Model Modal ] end -->

                    <!-- [ Delete Modal ] start -->
                    <div class="modal fade" id="deleteModal-{{ $m->id }}" data-bs-keyboard="false"
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
                                        <a href="{{ route('delete-model-get', $m->id) }}" class="btn btn-danger w-50">
                                            Delete Anyways
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Delete Modal ] end -->
                @endforeach


                <!-- [ Manage Model ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var modalToShow = "{{ session('modal') }}";
            if (modalToShow) {
                var modalElement = document.getElementById(modalToShow);
                if (modalElement) {
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            }
        });

        $(document).ready(function() {

            // DATATABLE : MODEL
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('manage-model-page') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        className: "text-start"
                    },
                    {
                        data: 'model_code',
                        name: 'model_code'
                    },
                    {
                        data: 'model_name',
                        name: 'model_name',
                        className: "avoid-long-column"
                    },
                    {
                        data: 'mcategory_name',
                        name: 'mcategory_name'
                    },
                    {
                        data: 'model_status',
                        name: 'model_status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]

            });

            /*********************************************************/
            /********************INPUT FORMATTING*********************/
            /*********************************************************/

            $('.input-code').on('input', function() {
                this.value = this.value.toUpperCase();
            });


        });
    </script>
@endsection
<!-- [ Main Content ] end -->
