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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Quotation</a></li>
                                <li class="breadcrumb-item" aria-current="page">Manage Quotation</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Manage Quotation</h2>
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
                <!-- [ Manage Quotation ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-2">
                                <a href="{{ route('generate-quotation-page') }}"
                                    class="btn btn-primary d-inline-flex align-items-center gap-2"><i
                                        class="ti ti-plus f-18"></i>
                                    Add Quotation
                                </a>
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
                                            <th scope="col">Patient Name</th>
                                            <th scope="col">Hospital</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Quotation</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- [ Add Quotation Modal ] start -->
                <form action="{{ route('generate-quotation-page') }}" method="POST">
                    @csrf
                    <div class="modal fade" id="addQuotationModal" tabindex="-1" aria-labelledby="addQuotationModal"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title" id="addModalLabel">Add Quotation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="mb-3">
                                                <label for="template_id" class="form-label">Quotation Template</label>
                                                <select name="template_id" class="form-select" id="template_id" required>
                                                    <option value="">-- Select Template --</option>
                                                    <option value="1">DCH Auriga (Malaysia) Sdn Bhd</option>
                                                    <option value="2">Tamasetia Resources Sdn Bhd</option>
                                                    <option value="3">Medico Sdn Bhd</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="hospital_id" class="form-label">Hospital</label>
                                                <select name="hospital_id" class="form-select" id="hospital_id" required>
                                                    <option value="">-- Select Hospital --</option>
                                                    @foreach ($hospitals as $hs)
                                                        @if ($hs->hospital_visibility == 1)
                                                            <option value="{{ $hs->id }}">{{ $hs->hospital_name }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $hs->id }}" disabled
                                                                class="bg-light-danger">
                                                                {{ $hs->hospital_name }} [Inactive]</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="generator_id" class="form-label">Generator</label>
                                                <select name="generator_id" class="form-select" id="generator_id" required>
                                                    <option value="">-- Select Generator --</option>
                                                    @foreach ($generators as $gene)
                                                        @if ($gene->generator_status == 1)
                                                            <option value="{{ $gene->id }}">
                                                                [{{ $gene->generator_code }}]{{ $gene->generator_name }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $gene->id }}" disabled
                                                                class="bg-light-danger">
                                                                [{{ $gene->generator_code }}]{{ $gene->generator_name }}
                                                                [Inactive]
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="refno" class="form-label">Quotation Ref No</label>
                                                <input type="text" name="refno" id="refno"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light justify-content-end">
                                    <div class="flex-grow-1 text-end">
                                        <div class="col-sm-12">
                                            <div class="d-flex justify-content-between gap-3 align-items-center">
                                                <button type="reset"
                                                    class="btn btn-outline-secondary btn-pc-default w-100"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary w-100">
                                                    Add Quotation
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- [ Add Quotation Modal ] end -->

                <!-- [ Manage Quotation ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            $(function() {

                // DATATABLE : QUOTATION
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('manage-quotation-page') }}",
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false,
                            className: "text-start"
                        },
                        {
                            data: 'quotation_pt',
                            name: 'quotation_pt'
                        },
                        {
                            data: 'quotation_hospital',
                            name: 'quotation_hospital'
                        },
                        {
                            data: 'quotation_date',
                            name: 'quotation_date'
                        },
                        {
                            data: 'quotation_file',
                            name: 'quotation_file'
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
