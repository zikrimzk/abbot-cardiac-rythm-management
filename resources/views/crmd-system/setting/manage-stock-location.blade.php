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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Others</a></li>
                                <li class="breadcrumb-item" aria-current="page">Manage Stock Location</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Manage Stock Location</h2>
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
                <!-- [ Manage Stock Location ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-2"
                                    data-bs-toggle="modal" data-bs-target="#addStockLocationModal"><i
                                        class="ti ti-plus f-18"></i>
                                    Add Stock Location
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Stock Location Code</th>
                                            <th scope="col">Stock Location Name</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- [ Add Stock Location Modal ] start -->
                <form action="{{ route('add-stock-location-post') }}" method="POST">
                    @csrf
                    <div class="modal fade" id="addStockLocationModal" tabindex="-1" aria-labelledby="addStockLocationModal"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Add Stock Location</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="stock_location_name" class="form-label">Stock Location Name
                                                    <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('stock_location_name') is-invalid @enderror"
                                                    id="stock_location_name" name="stock_location_name"
                                                    placeholder="Enter Stock Location Name"
                                                    value="{{ old('stock_location_name') }}" required>
                                                @error('stock_location_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="stock_location_code" class="form-label">Stock Location Code
                                                    <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('stock_location_code') is-invalid @enderror"
                                                    id="stock_location_code" name="stock_location_code"
                                                    placeholder="Enter Stock Location Code"
                                                    value="{{ old('stock_location_code') }}" required>
                                                @error('stock_location_code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="stock_location_status" class="form-label">Status
                                                    <span class="text-danger">*</span></label>
                                                <select name="stock_location_status" id="stock_location_status"
                                                    class="form-select @error('stock_location_status') is-invalid @enderror"
                                                    required>
                                                    @if (old('stock_location_status') == 1)
                                                        <option value="1" selected>Active</option>
                                                        <option value="2">Inactive</option>
                                                    @elseif(old('stock_location_status') == 2)
                                                        <option value="1">Active</option>
                                                        <option value="2" selected>Inactive</option>
                                                    @else
                                                        <option value="1">Active</option>
                                                        <option value="2">Inactive</option>
                                                    @endif
                                                </select>
                                                @error('stock_location_status')
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
                                                    Stock Location</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <!-- [ Add Stock Location Modal ] end -->

                @foreach ($sls as $sl)
                    <!-- [ Update Stock Location Modal ] start -->
                    <form action="{{ route('update-stock-location-post', $sl->id) }}" method="POST">
                        @csrf
                        <div class="modal fade" id="updateStockLocationModal-{{ $sl->id }}" tabindex="-1"
                            aria-labelledby="updateStockLocationModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Stock Location</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="stock_location_name" class="form-label">Stock Location Name
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('stock_location_name') is-invalid @enderror"
                                                        id="stock_location_name" name="stock_location_name"
                                                        placeholder="Enter Stock Location Name"
                                                        value="{{ $sl->stock_location_name }}" required>
                                                    @error('stock_location_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="stock_location_code" class="form-label">Stock Location Code
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('stock_location_code') is-invalid @enderror"
                                                        id="stock_location_code" name="stock_location_code"
                                                        placeholder="Enter Stock Location Code"
                                                        value="{{ $sl->stock_location_code }}" required>
                                                    @error('stock_location_code')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="stock_location_status" class="form-label">Status
                                                        <span class="text-danger">*</span></label>
                                                    <select name="stock_location_status" id="stock_location_status"
                                                        class="form-select @error('stock_location_status') is-invalid @enderror"
                                                        required>
                                                        @if ($sl->stock_location_status == 1)
                                                            <option value="1" selected>Active</option>
                                                            <option value="2">Inactive</option>
                                                        @elseif($sl->stock_location_status == 2)
                                                            <option value="1">Active</option>
                                                            <option value="2" selected>Inactive</option>
                                                        @else
                                                            <option value="1">Active</option>
                                                            <option value="2">Inactive</option>
                                                        @endif
                                                    </select>
                                                    @error('stock_location_status')
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
                    <!-- [ Update Stock Location Modal ] end -->

                    <!-- [ Delete Modal ] start -->
                    <div class="modal fade" id="deleteModal-{{ $sl->id }}" data-bs-keyboard="false"
                        tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12 mb-4">
                                            <div class="d-flex justify-content-center align-items-center mb-3">
                                                <i class="ti ti-trash text-danger" style="font-size: 100px"></i>
                                            </div>

                                        </div>
                                        <div class="col-sm-12">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <h2>Are you sure ?</h2>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <p class="fw-normal f-18 text-center">This action cannot be undone.</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="d-flex justify-content-between gap-3 align-items-center">
                                                <button type="reset" class="btn btn-light btn-pc-default w-50"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <a href="{{ route('delete-stock-location-get', $sl->id) }}"
                                                    class="btn btn-danger w-100">Delete Anyways</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Delete Modal ] end -->
                @endforeach


                <!-- [ Manage Stock Location ] end -->
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

            $(function() {

                // DATATABLE : STOCK LOCATION
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('manage-stock-location-page') }}",
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false,
                            className: "text-start"
                        },
                        {
                            data: 'stock_location_code',
                            name: 'stock_location_code'
                        },
                        {
                            data: 'stock_location_name',
                            name: 'stock_location_name'
                        },
                        {
                            data: 'stock_location_status',
                            name: 'stock_location_status'
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

        });
    </script>
@endsection
<!-- [ Main Content ] end -->
