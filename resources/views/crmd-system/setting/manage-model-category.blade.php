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
                                <li class="breadcrumb-item" aria-current="page">Manage Model Category</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Manage Model Category</h2>
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
                <!-- [ Manage Model Category ] start -->

                <div class="col-sm-12">
                    <!-- [ Option ] start -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addModelCategoryModal"
                                    class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Add Model Category">
                                    <i class="ti ti-plus f-18"></i>
                                    <span class="d-none d-md-inline">Add Model Category</span>
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
                                            <th scope="col">Category Name</th>
                                            <th scope="col">Abbreviation</th>
                                            <th scope="col">Support Multiple Input</th>
                                            <th scope="col">Appear in Patient ID Card</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- [ Add Model Category Modal ] start -->
                <form action="{{ route('add-model-category-post') }}" method="POST">
                    @csrf
                    <div class="modal fade" id="addModelCategoryModal" tabindex="-1"
                        aria-labelledby="addModelCategoryModal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Add Model Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="mcategory_name" class="form-label">Category Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('mcategory_name') is-invalid @enderror"
                                                    id="mcategory_name" name="mcategory_name"
                                                    placeholder="Enter Category Name" value="{{ old('mcategory_name') }}"
                                                    required>
                                                @error('mcategory_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="mcategory_abbreviation" class="form-label">Category
                                                    Abbreviation <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('mcategory_abbreviation') is-invalid @enderror"
                                                    id="mcategory_abbreviation" name="mcategory_abbreviation"
                                                    placeholder="Enter Category Abbreviation"
                                                    value="{{ old('mcategory_abbreviation') }}" required>
                                                <small class="text-muted form-text">This will be displayed in the
                                                    generated Patient ID Card</small>
                                                @error('mcategory_abbreviation')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="mcategory_ismorethanone" class="form-label">Multiple Input
                                                    <span class="text-danger">**</span></label>
                                                <select name="mcategory_ismorethanone" id="mcategory_ismorethanone"
                                                    class="form-select @error('mcategory_ismorethanone') is-invalid @enderror"
                                                    required>
                                                    @if (old('mcategory_ismorethanone') == 1)
                                                        <option value="1" selected>Yes</option>
                                                        <option value="0">No</option>
                                                    @elseif(old('mcategory_ismorethanone') == 0)
                                                        <option value="1">Yes</option>
                                                        <option value="0" selected>No</option>
                                                    @else
                                                        <option value="">Select Option</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    @endif
                                                </select>
                                                <small class="text-muted form-text">Select Yes if the category can have
                                                    multiple models</small>

                                                @error('mcategory_ismorethanone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="mcategory_isappear_incard" class="form-label">Appear in
                                                    Patient ID Card
                                                    <span class="text-danger">*</span></label>
                                                <select name="mcategory_isappear_incard" id="mcategory_isappear_incard"
                                                    class="form-select @error('mcategory_isappear_incard') is-invalid @enderror"
                                                    required>
                                                    @if (old('mcategory_isappear_incard') == 1)
                                                        <option value="1" selected>Yes</option>
                                                        <option value="0">No</option>
                                                    @elseif(old('mcategory_isappear_incard') == 0)
                                                        <option value="1">Yes</option>
                                                        <option value="0" selected>No</option>
                                                    @else
                                                        <option value="">Select Option</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    @endif
                                                </select>
                                                <small class="text-muted form-text">Select Yes if the category should
                                                    appear in the Patient ID Card</small>
                                                @error('mcategory_isappear_incard')
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
                                                    Modal Category</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <!-- [ Add Model Category Modal ] end -->

                @foreach ($mcs as $mc)
                    <!-- [ Update Model Category Modal ] start -->
                    <form action="{{ route('update-model-category-post', $mc->id) }}" method="POST">
                        @csrf
                        <div class="modal fade" id="updateModelCategoryModal-{{ $mc->id }}" tabindex="-1"
                            aria-labelledby="updateModalCategoryModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Model Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="mcategory_name" class="form-label">Category Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('mcategory_name') is-invalid @enderror"
                                                        id="mcategory_name" name="mcategory_name"
                                                        placeholder="Enter Category Name"
                                                        value="{{ $mc->mcategory_name }}" required>
                                                    @error('mcategory_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="mcategory_abbreviation" class="form-label">Category
                                                        Abbreviation <span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('mcategory_abbreviation') is-invalid @enderror"
                                                        id="mcategory_abbreviation" name="mcategory_abbreviation"
                                                        placeholder="Enter Category Abbreviation"
                                                        value="{{ $mc->mcategory_abbreviation }}" required>
                                                    <small class="text-muted form-text">This will be displayed in the
                                                        generated Patient ID Card</small>
                                                    @error('mcategory_abbreviation')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="mcategory_ismorethanone" class="form-label">
                                                        Multiple Input
                                                        <span class="text-danger">*</span>
                                                    </label>

                                                    <select name="mcategory_ismorethanone" id="mcategory_ismorethanone"
                                                        class="form-select @error('mcategory_ismorethanone') is-invalid @enderror"
                                                        required>
                                                        @if ($mc->mcategory_ismorethanone == 1)
                                                            <option value="1" selected>Yes</option>
                                                            <option value="0">No</option>
                                                        @elseif($mc->mcategory_ismorethanone == 0)
                                                            <option value="1">Yes</option>
                                                            <option value="0" selected>No</option>
                                                        @else
                                                            <option value="" selected>Select Option</option>
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        @endif
                                                    </select>
                                                    <small class="text-muted form-text">Select Yes if the category can have
                                                        multiple models</small>
                                                    @error('mcategory_ismorethanone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="mcategory_isappear_incard" class="form-label">Appear in
                                                        Patient ID Card
                                                        <span class="text-danger">*</span></label>
                                                    <select name="mcategory_isappear_incard"
                                                        id="mcategory_isappear_incard"
                                                        class="form-select @error('mcategory_isappear_incard') is-invalid @enderror"
                                                        required>
                                                        @if ($mc->mcategory_isappear_incard == 1)
                                                            <option value="1" selected>Yes</option>
                                                            <option value="0">No</option>
                                                        @elseif($mc->mcategory_isappear_incard == 0)
                                                            <option value="1">Yes</option>
                                                            <option value="0" selected>No</option>
                                                        @else
                                                            <option value="" selected>Select Option</option>
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        @endif
                                                    </select>
                                                    <small class="text-muted form-text">Select Yes if the category should
                                                        appear in the Patient ID Card</small>
                                                    @error('mcategory_isappear_incard')
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
                    <!-- [ Update Model Category Modal ] end -->

                    <!-- [ Delete Modal ] start -->
                    <div class="modal fade" id="deleteModal-{{ $mc->id }}" data-bs-keyboard="false"
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
                                        <a href="{{ route('delete-model-category-get', $mc->id) }}"
                                            class="btn btn-danger w-50">
                                            Delete Anyways
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Delete Modal ] end -->
                @endforeach


                <!-- [ Manage Model Category ] end -->
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

            // DATATABLE : MODEL CATEGORY
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('manage-model-category-page') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        className: "text-start"
                    },
                    {
                        data: 'mcategory_name',
                        name: 'mcategory_name'
                    },
                    {
                        data: 'mcategory_abbreviation',
                        name: 'mcategory_abbreviation'
                    },
                    {
                        data: 'mcategory_ismorethanone',
                        name: 'mcategory_ismorethanone'
                    },
                    {
                        data: 'mcategory_isappear_incard',
                        name: 'mcategory_isappear_incard'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]

            });

        });
    </script>
@endsection
<!-- [ Main Content ] end -->
