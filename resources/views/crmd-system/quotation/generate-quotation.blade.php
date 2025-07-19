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
                                <li class="breadcrumb-item"><a href="{{ route('manage-quotation-page') }}">Manage
                                        Quotation</a></li>
                                <li class="breadcrumb-item" aria-current="page">Generate Quotation</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <a href="{{ route('manage-quotation-page') }}" class="btn me-2 d-flex align-items-center">
                                    <span class="f-18">
                                        <i class="ti ti-arrow-left me-2"></i>
                                    </span>
                                    Back
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
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
                <div id="toastContainer"></div>
            </div>
            <!-- [ Alert ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">

                <!-- [ Evaluation Student ] start -->
                <div class="col-sm-12">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card p-3">
                            <div class="card-body">
                                <div class="container">
                                    <div id="formContainer"></div>
                                </div>
                            </div>
                            <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-light-danger">Reset</button>
                                <button type="submit" id= "submitBtn" class="btn btn-primary">Generate Quotation</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- [ Evaluation Student ] end -->

            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>



    <script type="text/javascript">

        /*********************************************************
         ***************GLOBAL FUNCTION & VARIABLES***************
         *********************************************************/
        function showToast(type, message) {
            const toastId = 'toast-' + Date.now();
            const iconClass = type === 'success' ? 'fas fa-check-circle' : 'fas fa-info-circle';
            const bgClass = type === 'success' ? 'bg-light-success' : 'bg-light-danger';
            const txtClass = type === 'success' ? 'text-success' : 'text-danger';
            const colorClass = type === 'success' ? 'success' : 'danger';
            const title = type === 'success' ? 'Success' : 'Error';

            const toastHtml = `
                    <div id="${toastId}" class="toast border-0 shadow-sm mb-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                        <div class="toast-body text-white ${bgClass} rounded d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0 ${txtClass}">
                                    <i class="${iconClass} me-2"></i> ${title}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <p class="mb-0 ${txtClass}">${message}</p>
                        </div>
                    </div>
                `;

            $('#toastContainer').append(toastHtml);
            const toastEl = new bootstrap.Toast(document.getElementById(toastId));
            toastEl.show();
        }

        /*********************************************************/
        /***************GLOBAL FUNCTION & VARIABLES***************/
        /*********************************************************/
        getNominationForm();


        /*********************************************************/
        /**********************GETTERS FUNCTION*******************/
        /*********************************************************/
        function getNominationForm() {
            $.ajax({
                url: "{{ route('view-editable-quotation-document-get') }}",
                type: "GET",
                data: {
                    _token: "{{ csrf_token() }}",
                    company: "1",
                    afid: "",
                    studentid: "",
                    mode: ""
                },
                beforeSend: function() {
                    $('#formContainer').html(
                        '<div class="text-center py-4"><i class="ti ti-loader spin me-2"></i>Loading form...</div>'
                    );
                },
                success: function(response) {
                    $('#formContainer').html(response.html);
                },
                error: function() {
                    $('#formContainer').html(
                        '<div class="alert alert-danger">Error loading form</div>');
                }
            });
        }


        /*********************************************************/
        /******************FORM SUBMIT FUNCTION*******************/
        /*********************************************************/

        $('#submitBtn').on('click', function(e) {
            e.preventDefault();
            $('#opt-hidden').val(1);
            $('form').submit();
        });
    </script>
@endsection
<!-- [ Main Content ] end -->
