<!-- [ Extend Layouts ] -->
@extends('crmd-system.layouts.main')

<!-- [ Main Content ] start -->
<style>
    .card-wrapper {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }

    .card-container {
        width: 3.5in !important;
        height: 2in !important;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-sizing: border-box;
        overflow: hidden;
        border: 2px solid #000;
        border-radius: 10px;
    }

    .card-container-modal {
        width: 3.5in !important;
        height: 2in !important;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-sizing: border-box;
        overflow: hidden;
        border: 2px solid #000;
        border-radius: 10px;
        transform: scale(2);
        transform-origin: center;
        margin: 100px;
    }

    .card-container-btn {
        width: 3.5in !important;
    }

    .dark-card {
        background-color: #2e2e2e;
        color: white;
    }

    .blue-card {
        background-color: #ffffff;
        color: white;
    }

    .header-non-mri {
        background-color: #2e2e2e;
        color: white;
        font-size: 9px;
    }

    .header-mri {
        background-color: #007bff;
        color: white;
        font-size: 9px;
    }

    @media (max-width: 768px) {
        .card-wrapper {
            flex-direction: column;
            align-items: center;
        }
    }
</style>
@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Manage Implant</a></li>
                                <li class="breadcrumb-item" aria-current="page">Generate Patient ID Card</li>
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
                <!-- [ Generate Patient ID Card ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-light-primary text-primary">

                            <h5 class="card-title mb-0">Generate Patient ID Card</h5>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="h5 mb-3">Patient ID Card Selection</div>
                                    <div class="mb-3">
                                        <label for="cardTypeSelect" class="form-label">Card Type</label>
                                        <select id="cardTypeSelect" class="form-select">
                                            <option value="" selected>-- Select Card Type --</option>
                                            <option value="1">Non MRI</option>
                                            <option value="2">1.5T MRI</option>
                                            <option value="3">3.0T MRI</option>
                                        </select>
                                    </div>
                                    <div class="mb-5">
                                        <div class="d-grid">
                                            <button type="button" id="generateCardBtn" class="btn btn-primary">Generate
                                                Card</button>
                                        </div>
                                    </div>

                                    <div id="optionSection" style="display: none;">
                                        <div class="h5 mb-3">Option</div>
                                        <div class="mb-3">
                                            <div class="d-grid mb-3">
                                                <a id="viewCardLink" href="#" target="_blank"
                                                    class="btn btn-light-primary">View Card
                                                    (.pdf)</a>
                                            </div>
                                            <div class="d-grid mb-3">
                                                <a id="downloadCardLink" href="#" target="_blank"
                                                    class="btn btn-light-danger">Download Card (.pdf)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="card-wrapper">
                                        <div class="h5 mb-3">Preview</div>
                                        <div id="cardContainer">
                                            <div class="card-container mb-3">
                                                Front Card
                                            </div>
                                            <div class="card-container mb-3">
                                                Back Card
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ Generate Patient ID Card ] end -->
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

            $('#generateCardBtn').click(function() {
                var selectedOpt = $('#cardTypeSelect').val();

                $.ajax({
                    url: "{{ route('patient-id-card-preview-post', ['id' => $data['id']]) }}", // Pastikan route betul
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}", // Hantar CSRF token untuk keselamatan
                        opt: selectedOpt
                    },
                    success: function(response) {
                        $('#cardContainer').html(response.html); // Update div dengan kad baru
                    },
                    error: function() {
                        alert("Something went wrong!");
                    }
                });
            });

            $("#generateCardBtn").click(function() {
                let selectedOpt = $('#cardTypeSelect').val();
                let optionSection = $("#optionSection");
                let viewCardLink = $("#viewCardLink");
                let downloadCardLink = $("#downloadCardLink");
                let patientId = "{{ $data['id'] }}";
                let baseUrl = "{{ url('staff/view-patient-id-card') }}-" + patientId + "-";

                if (selectedOpt) {
                    optionSection.show();
                    viewCardLink.attr("href", baseUrl + selectedOpt);
                    downloadCardLink.attr("href", baseUrl + selectedOpt);
                } else {
                    optionSection.hide();
                }
            });



        });
    </script>
@endsection
<!-- [ Main Content ] end -->
