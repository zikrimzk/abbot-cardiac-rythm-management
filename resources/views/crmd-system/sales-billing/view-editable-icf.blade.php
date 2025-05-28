<!-- [ Extend Layouts ] -->
@extends('crmd-system.layouts.main')

<!-- [ Main Content ] start -->
@section('content')
    <style>
        /* Landscape wrapper-form */
        .wrapper-form {
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            border: 1px dashed #555;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            padding: 30px;
        }

        /* Watermark background */
        .watermark {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" viewBox="0 0 400 400"><text x="50%" y="50%" font-family="Arial" font-size="40" fill="rgba(0,100,200,0.05)" text-anchor="middle" dominant-baseline="middle" transform="rotate(-45, 200, 200)">CONFIDENTIAL - INVENTORY FORM</text></svg>');
            background-repeat: repeat;
            opacity: 0.3;
            z-index: -1;
        }

        /* Header section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 2px solid #2c6eb5;
            margin-bottom: 25px;
        }

        .logo-area {
            width: 150px;
            height: 80px;
        }

        .title-area {
            text-align: center;
        }

        .title-area h1 {
            font-size: 24px;
            color: #1a3c6e;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .title-area .subtitle {
            font-size: 12px;
            color: #2c6eb5;
            font-weight: 600;
        }

        .form-meta {
            text-align: right;
            font-size: 12px;
            color: #666;
        }

        /* Patient Information Section */
        .patient-info {
            width: 100%;
            margin: 25px 0;
            border-collapse: collapse;
            font-size: 12px;
        }

        .patient-info td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            vertical-align: top;

        }

        .info-label {
            background-color: #e9f0f8;
            font-weight: 600;
            width: 15%;
            color: #1a3c6e;
            font-size: 12px;
        }

        /* Stock Location Section */
        .stock-section {
            background: #f8fbff;
            border: 1px solid #cde;
            border-radius: 4px;
            padding: 12px 15px;
            margin: 20px 0;
        }

        .section-title {
            color: #1a3c6e;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #cde;
        }

        .location-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            font-size: 12px;
        }

        .location-item {
            display: flex;
        }

        .location-code {
            font-weight: 700;
            width: 40px;
            color: #2c6eb5;
        }

        /* Products Table */
        .products-section {
            margin: 30px 0;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 10px;
        }

        .products-table th {
            background-color: #1a3c6e;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
        }

        .products-table td {
            padding: 10px 8px;
            border: 1px solid #ddd;
        }

        .products-table tr:nth-child(even) {
            background-color: #f8fbff;
        }

        .products-table tr:hover {
            background-color: #edf5ff;
        }

        /* Payment Section */
        .payment-section {
            margin: 25px 0;
            padding: 15px;
            background: #f0f8ff;
            border-left: 4px solid #2c6eb5;
        }

        .payment-method {
            font-weight: 600;
            color: #1a3c6e;
            margin-bottom: 5px;
        }

        .payment-note {
            font-size: 12px;
            color: #666;
            font-style: italic;
            margin-bottom: 10px;
        }

        .total-invoice {
            font-size: 12px;
            font-weight: 700;
            color: #1a3c6e;
        }

        /* Documents Section */
        .documents-section {
            margin: 25px 0;
            padding: 15px;
            background: #f8fafd;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .documents-section ol {
            padding-left: 25px;
        }

        .documents-section li {
            margin-bottom: 8px;
            font-size: 12px;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }

        .form-version {
            font-style: italic;
            text-align: right;
        }

        /* Signature area */
        .signature-area {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
            padding-top: 50px;
            text-align: center;
            border-top: 1px solid #ccc;
            font-size: 14px;
            color: #555;
        }

        /* Print-specific styles */
        @media print {
            body {
                padding: 0;
                background: none;
            }

            .wrapper-form {
                box-shadow: none;
                margin: 0;
                padding: 15mm;
                width: 100%;
                min-height: 100%;
            }

            .no-print {
                display: none;
            }

            /* Landscape orientation for printing */
            @page {
                size: landscape;
                margin: 10mm;
            }
        }

        /* Print button styling */
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #1a3c6e;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .print-btn:hover {
            background: #2c6eb5;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Sales Biling</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('generate-icf-page') }}">Generate Inventory
                                        Consumption Form (ICF)</a></li>
                                <li class="breadcrumb-item" aria-current="page">{{ $ims->implant_pt_name }}</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">{{ $ims->implant_pt_name }}</h2>
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

                <!-- [ Generate ICF ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{ route('view-icf-document', Crypt::encrypt($ims->implant_id)) }}"
                                class="btn btn-light-danger">View ICF</a>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-wrapper">
                                        <div class="h5 mb-3 text-center">Preview</div>
                                        <div id="formContainer"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- [ Generate ICF ] end -->

            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            function getFormData() {
                $.ajax({
                    url: "{{ route('icf-preview-post') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: "{{ $ims->implant_id }}",
                    },
                    success: function(response) {
                        $('#formContainer').html(response.html);
                    },
                    error: function() {
                        alert("Something went wrong!");
                    }
                });
            }

            getFormData();

        });
    </script>
@endsection
<!-- [ Main Content ] end -->
