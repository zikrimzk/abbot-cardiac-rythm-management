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
                                <li class="breadcrumb-item" aria-current="page">Assign Generator & Model</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Assign Generator & Model</h2>
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
                <!-- [ Assign Generator & Model ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-2"
                                    data-bs-toggle="modal" data-bs-target="#addAssignmentModal"><i
                                        class="ti ti-plus f-18"></i>
                                    Assign Generator & Model
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
                                            <th scope="col">Generator</th>
                                            <th scope="col">Model</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- [ Assign Generator & Model Modal ] start -->
                <form action="{{ route('add-assign-generator-model-post') }}" method="POST">
                    @csrf
                    <div class="modal fade" id="addAssignmentModal" tabindex="-1" aria-labelledby="addAssignment"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="addAssignmentLabel">Assign Generator & Model</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="designationName" class="form-label">Generator <span
                                                        class="text-danger">*</span></label>
                                                <select name="generator_id" id="generator_id"
                                                    class="form-control  @error('generator_id') is-invalid @enderror"
                                                    required>
                                                    <option value="" disabled selected>Select Generator</option>
                                                    @foreach ($generators as $generator)
                                                        <option value="{{ $generator->id }}">
                                                            [{{ $generator->generator_code }}] -
                                                            {{ $generator->generator_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">

                                            @foreach ($mcs as $mc)
                                                <h5 class="mt-4">{{ $mc->mcategory_name }}</h5>
                                                @if ($mc->mcategory_ismorethanone == 1)
                                                    <div id="model_container_{{ $mc->id }}">
                                                        <div class="row col-sm-12 model-loop ">
                                                            <!-- [ Model ] Input -->
                                                            <div class="col-sm-11">
                                                                <div class="mb-3">
                                                                    <label for="model_ids_{{ $mc->id }}"
                                                                        class="form-label">Model</label>
                                                                    <select name="model_ids[]"
                                                                        class="form-select model-select">
                                                                        <option value="" selected>Select Model
                                                                        </option>
                                                                        @foreach ($abbottmodels->where('mcategory_id', $mc->id) as $am)
                                                                            <option value="{{ $am->id }}">
                                                                                {{ $am->model_code }}</option>
                                                                        @endforeach
                                                                    </select>
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
                                                    <div class="col-sm-12 row model-loop">

                                                        <!-- [ Model ] Input -->
                                                        <div class="col-sm-11">
                                                            <div class="mb-3">
                                                                <label for="model_ids_{{ $mc->id }}"
                                                                    class="form-label">Model</label>
                                                                <select name="model_ids[]"
                                                                    class="form-select model-select">
                                                                    <option value="" selected>Select Model</option>
                                                                    @foreach ($abbottmodels->where('mcategory_id', $mc->id) as $am)
                                                                        <option value="{{ $am->id }}">
                                                                            {{ $am->model_code }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- [ Remove Button ] -->
                                                        <div
                                                            class="col-sm-1 d-flex align-items-center justify-content-center">
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm shadow-none reset-row"
                                                                disabled>
                                                                <i class="ti ti-trash f-20"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
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
                                                    id="addApplicationBtn">Assign</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <!-- [ Assign Generator & Model Modal  ] end -->

                @foreach ($qgms as $qgm)
                    <!-- [ Update Assign Generator & Model Modal ] start -->
                    <form
                        action="{{ route('update-assign-generator-model-post', ['generator_id' => Crypt::encrypt($qgm->generator_id)]) }}"
                        method="POST">
                        @csrf
                        <div class="modal fade" id="updateGeneratorModelModal-{{ $qgm->generator_id }}" tabindex="-1"
                            aria-labelledby="updateGeneratorModelModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addAssignmentLabel">Update Generator & Model
                                            Assignment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="designationName" class="form-label">Generator <span
                                                            class="text-danger">*</span></label>
                                                    <select name="generator_id" id="generator_id"
                                                        class="form-control  @error('generator_id') is-invalid @enderror"
                                                        required disabled>
                                                        <option value="" disabled>Select Generator</option>
                                                        @foreach ($generators as $generator)
                                                            @if ($qgm->generator_id == $generator->id)
                                                                <option value="{{ $generator->id }}" selected>
                                                                    [{{ $generator->generator_code }}] -
                                                                    {{ $generator->generator_name }}</option>
                                                            @else
                                                                <option value="{{ $generator->id }}">
                                                                    [{{ $generator->generator_code }}] -
                                                                    {{ $generator->generator_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">

                                                @foreach ($mcs as $mc)
                                                    <h5 class="mt-4">{{ $mc->mcategory_name }}</h5>
                                                    @php
                                                        // Filter only implants for this generator and this category
                                                        $categoryImplants = $qgmtwo->filter(function ($row) use (
                                                            $qgm,
                                                            $mc,
                                                        ) {
                                                            return $row->generator_id == $qgm->generator_id &&
                                                                $row->mcategory_id == $mc->id;
                                                        });

                                                        // If nothing found and it's multi-model, show at least 1 empty row
if (
    $categoryImplants->isEmpty() &&
    $mc->mcategory_ismorethanone == 1
) {
    $categoryImplants = collect([
        (object) ['model_id' => null],
                                                            ]);
                                                        }
                                                    @endphp
                                                    @if ($mc->mcategory_ismorethanone == 1)
                                                        @foreach ($categoryImplants as $index => $imd)
                                                            <div
                                                                id="model_containers_{{ $qgm->generator_id }}_{{ $mc->id }}">
                                                                <div class="row col-sm-12 model-loops">
                                                                    <!-- [ Model ] Input -->
                                                                    <div class="col-sm-11">
                                                                        <div class="mb-3">
                                                                            <label for="model_ids_{{ $mc->id }}"
                                                                                class="form-label">Model</label>
                                                                            <select name="model_ids[]"
                                                                                class="form-select model-selects">
                                                                                <option value="">Select Model
                                                                                </option>
                                                                                @foreach ($abbottmodels->where('mcategory_id', $mc->id) as $am)
                                                                                    <option value="{{ $am->id }}"
                                                                                        {{ $imd->model_id == $am->id ? 'selected' : '' }}>
                                                                                        {{ $am->model_code }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <!-- [ Remove Button ] -->
                                                                    <div
                                                                        class="col-sm-1 d-flex align-items-center justify-content-center">
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm shadow-none remove-rows">
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
                                                                        class="btn btn-light-primary mt-2 add-rows"
                                                                        data-category="{{ $mc->id }}"
                                                                        data-generator="{{ $qgm->generator_id }}">
                                                                        <i class="ti ti-plus"></i> Add Model
                                                                    </button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-sm-12 row model-loop">

                                                            <!-- [ Model ] Input -->
                                                            <div class="col-sm-11">
                                                                <div class="mb-3">
                                                                    <label for="model_ids_{{ $mc->id }}"
                                                                        class="form-label">Model</label>
                                                                    <select name="model_ids[]"
                                                                        class="form-select model-select">
                                                                        <option value="">Select Model
                                                                        </option>
                                                                        @foreach ($abbottmodels->where('mcategory_id', $mc->id) as $am)
                                                                            @if (in_array($am->id, $qgm->model_ids))
                                                                                <option value="{{ $am->id }}"
                                                                                    selected>{{ $am->model_code }}
                                                                                </option>
                                                                            @else
                                                                                <option value="{{ $am->id }}">
                                                                                    {{ $am->model_code }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- [ Remove Button ] -->
                                                            <div
                                                                class="col-sm-1 d-flex align-items-center justify-content-center">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm shadow-none reset-row"
                                                                    disabled>
                                                                    <i class="ti ti-trash f-20"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
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
                                                        id="addApplicationBtn">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- [ Update Assign Generator & Model Modal  ] end -->

                    <!-- [ Delete Modal ] start -->
                    <div class="modal fade" id="deleteGeneratorModelModal-{{ $qgm->generator_id }}"
                        data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
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
                                                <a href="{{ route('delete-assign-generator-model-get', ['generator_id' => Crypt::encrypt($qgm->generator_id)]) }}"
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


                <!-- [ Assign Generator & Model ] end -->
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

            // DATATABLE : QUOTATION GENERATOR MODEL
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('assign-generator-model-page') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        className: "text-start"
                    },
                    {
                        data: 'generator_name',
                        name: 'generator_name'
                    },
                    {
                        data: 'model_name',
                        name: 'model_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]

            });

            // FUNCTION : RESET BUTTON
            function checkResetButton(loopContainer) {
                let modelSelected = loopContainer.find(".model-select").val();
                let dustbinBtn = loopContainer.find(".reset-row");

                // Aktifkan butang jika ada input dalam mana-mana field
                if (modelSelected) {
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

            $(document).on("click", ".reset-row", function() {
                let loopContainer = $(this).closest(".model-loop");
                loopContainer.find(".model-select").val("").trigger("change");
                $(this).prop("disabled", true);
            });

            $(document).on("click", ".reset-rows", function() {
                let loopContainer = $(this).closest(".model-loops");
                loopContainer.find(".model-selects").val("").trigger("change");
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
                    "select.model-select"
                ).val("");
                newRow.find(".remove-row").prop("disabled", false);

                // Append the row
                lastRow.after(newRow);
            });

            $(document).on("click", ".add-rows", function() {
                let categoryID = $(this).data("category");
                let generatorID = $(this).data("generator");

                let containerID = `#model_containers_${generatorID}_${categoryID}`;
                let container = $(containerID);

                let lastRow = container.find(".model-loops").last();
                let newRow = lastRow.clone();

                // Clear select and enable remove button
                newRow.find("select.model-selects").val("");
                newRow.find(".remove-rows").prop("disabled", false);

                container.append(newRow);
            });

            $('.remove-row').each(function() {
                let row = $(this).closest('.model-loop');

                $(this).prop('disabled', true);

                row.find('input, select').on('input', function() {
                    row.find('.remove-row').prop('disabled', false);
                });

                $(this).on('click', function() {
                    row.find('select.model-select').val('');
                    $(this).prop('disabled', true);
                });
            });

            $(document).on('click', '.remove-row:not(:first)', function() {
                $(this).closest('.model-loop').remove();
            });

            $('.remove-rows').each(function() {
                let allRows = $(this).closest("#model_containers_" + $(this).data("generator") + "_" + $(
                    this).data("category")).find(".model-loops");
                let currentRow = $(this).closest(".model-loops");

                $(this).prop('disabled', true);

                if (currentRow.find('select').val() != "") {
                    $(this).prop('disabled', false);
                }

                currentRow.find('select').on('input', function() {
                    currentRow.find('.remove-rows').prop('disabled', false);
                });

                $(this).on('click', function() {
                    currentRow.find('select.model-selects').val('');
                    $(this).prop('disabled', true);
                });
            });

            $(document).on('click', '.remove-rows:not(:first)', function() {
                $(this).closest('.model-loops').remove();
            });

        });
    </script>
@endsection
<!-- [ Main Content ] end -->
