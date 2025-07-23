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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Others</a></li>
                                <li class="breadcrumb-item" aria-current="page">Manage Product Group</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Manage Product Group</h2>
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
                <!-- [ Manage Product Group ] start -->

                <div class="col-sm-12">
                    <!-- [ Option ] start -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addProductGroupModal"
                                    class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Add Product Group">
                                    <i class="ti ti-plus f-18"></i>
                                    <span class="d-none d-md-inline">Add Product Group</span>
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
                                            <th scope="col">Product Group Name</th>
                                            <th scope="col">Visibility</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- [ Add Product Group Modal ] start -->
                <form action="{{ route('add-product-group-post') }}" method="POST">
                    @csrf
                    <div class="modal fade" id="addProductGroupModal" tabindex="-1" aria-labelledby="addProductGroupModal"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Add Product Group</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="product_group_name" class="form-label">Product Group Name
                                                    <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control input-code @error('product_group_name') is-invalid @enderror"
                                                    id="product_group_name" name="product_group_name"
                                                    placeholder="Enter Product Group Name"
                                                    value="{{ old('product_group_name') }}" required>
                                                @error('product_group_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="product_group_visibility" class="form-label">Visibility
                                                    <span class="text-danger">*</span></label>
                                                <select name="product_group_visibility" id="product_group_visibility"
                                                    class="form-select @error('product_group_visibility') is-invalid @enderror"
                                                    required>
                                                    @if (old('product_group_visibility') == 1)
                                                        <option value="1" selected>Show</option>
                                                        <option value="2">Hide</option>
                                                    @elseif(old('product_group_visibility') == 2)
                                                        <option value="1">Show</option>
                                                        <option value="2" selected>Hide</option>
                                                    @else
                                                        <option value="1">Show</option>
                                                        <option value="2">Hide</option>
                                                    @endif
                                                </select>
                                                @error('product_group_visibility')
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
                                                    Product Group</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <!-- [ Add Product Group Modal ] end -->

                @foreach ($pgs as $pg)
                    <!-- [ Update Product Group Modal ] start -->
                    <form action="{{ route('update-product-group-post', $pg->id) }}" method="POST">
                        @csrf
                        <div class="modal fade" id="updateProductGroupModal-{{ $pg->id }}" tabindex="-1"
                            aria-labelledby="updateProductGroupModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Product Group</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="product_group_name" class="form-label">Product Group Name
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control input-code @error('product_group_name') is-invalid @enderror"
                                                        id="product_group_name" name="product_group_name"
                                                        placeholder="Enter Product Group Name"
                                                        value="{{ $pg->product_group_name }}" required>
                                                    @error('product_group_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="product_group_visibility" class="form-label">Visibility
                                                        <span class="text-danger">*</span></label>
                                                    <select name="product_group_visibility" id="product_group_visibility"
                                                        class="form-select @error('product_group_visibility') is-invalid @enderror"
                                                        required>
                                                        @if ($pg->product_group_visibility == 1)
                                                            <option value="1" selected>Show</option>
                                                            <option value="2">Hide</option>
                                                        @elseif($pg->product_group_visibility == 2)
                                                            <option value="1">Show</option>
                                                            <option value="2" selected>Hide</option>
                                                        @else
                                                            <option value="1">Show</option>
                                                            <option value="2">Hide</option>
                                                        @endif
                                                    </select>
                                                    @error('product_group_visibility')
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
                    <!-- [ Update Product Group Modal ] end -->

                    <!-- [ Delete Modal ] start -->
                    <div class="modal fade" id="deleteModal-{{ $pg->id }}" data-bs-keyboard="false"
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
                                        <a href="{{ route('delete-product-group-get', $pg->id) }}"
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


                <!-- [ Manage Product Group ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var modalToShow = "{{ session('modal') }}"; // Ambil modal yang perlu dibuka dari session
            if (modalToShow) {
                var modalElement = document.getElementById(modalToShow);
                if (modalElement) {
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            }
        });

        $(document).ready(function() {

            // DATATABLE : PRODUCT GROUP
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('manage-product-group-page') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        className: "text-start"
                    },
                    {
                        data: 'product_group_name',
                        name: 'product_group_name'
                    },
                    {
                        data: 'product_group_visibility',
                        name: 'product_group_visibility'
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
