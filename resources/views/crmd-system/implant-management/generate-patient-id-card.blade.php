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
        /* transform: scale(1.2);
        transform-origin: center; */
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
        transform: scale(1.6);
        transform-origin: center;
        margin: 50px;
    }

    .dark-card {
        background-color: #2e2e2e;
        color: white;
    }

    .blue-card {
        background-color: #ffffff;
        color: white;
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
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Generate Patient ID Card</h2>
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
                        <div class="card-body">

                            <div class="card-wrapper">

                                <!-- [ Front ] start -->
                                <div class="card-container dark-card mb-3 mb-md-0">
                                    <table width="100%" style="color: white; font-size: 12pt; letter-spacing:0.5pt;">
                                        <tr>
                                            <td colspan="2"
                                                style="padding-top: 20px; padding-left: 30px; font-weight:700; font-family: Times New Roman;">
                                                THIS PATIENT HAS A
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"
                                                style="padding-top: 5px; padding-left: 30px; font-weight:700; font-family: Times New Roman; color: #4d9cf0;">
                                                MRI CONDITIONAL DEVICES
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 5px; padding-left: 30px; width:50%;">
                                                <img src="../assets/images/card/MR_icon.png" width="80"
                                                    alt="Abbott Logo">
                                            </td>
                                            <td style="padding-top: 5px; padding-left: 30px; width:50%;">
                                                <img src="../assets/images/logo/abbott-logo-white.png" width="100"
                                                    alt="Abbott Logo">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- [ Front ] end -->

                                <a href="javascript: void(0)" class="link-primary mt- mb-3 d-none d-md-block" data-bs-toggle="modal"
                                    data-bs-target="#viewFrontCard">View Fullscreen (Front)</a>

                                <!-- [ Back ] start -->
                                <div class="card-container blue-card mb-3 mb-md-0">
                                    <!-- [ Header ] start -->
                                    <table width="100%" style="background-color: #007bff; color: white; font-size: 9px;"
                                        border="1">
                                        <tr>
                                            <td style="padding: 10px; padding-left: 15px;">
                                                <img src="../assets/images/logo/abbott-logo-white.png" width="60"
                                                    alt="Abbott Logo">
                                            </td>
                                            <td
                                                style="text-align: right;padding: 10px;padding-right: 15px;  font-weight:700; ">
                                                Patient Identification Card
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- [ Header ] end -->

                                    <!-- [ Patient details ] start -->
                                    <table width="100%" style="color: rgb(0, 0, 0); font-size: 5pt;">
                                        <tr>
                                            <th
                                                style="padding-left: 15px; padding-top: 10px; padding-bottom: 2px; font-weight:700; width:30%;">
                                                PATIENT
                                            </th>
                                            <td style="padding-top: 10px; padding-bottom: 2px; font-weight:700;">
                                                {{ $data['implant_pt_name'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                                                I/C / MRN
                                            </th>
                                            <td style="padding-bottom: 2px; font-weight:700;">
                                                {{ $data['implant_pt_icno'] }}
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- [ Patient details ] end -->

                                    <!-- [ Pacemake & Model details ] start -->
                                    <table width="100%" style="color: rgb(0, 0, 0); font-size: 5pt;">
                                        <tr>
                                            <th
                                                style="padding-left: 15px; padding-top: 5px; padding-bottom: 2px; font-weight:700; width:30%;">
                                            </th>
                                            <th style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                                                MODEL NO
                                            </th>
                                            <th style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                                                SERIAL NO
                                            </th>
                                            <th style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                                                IMPLANT DATE
                                            </th>
                                        </tr>
                                        <tr>
                                            <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                                                PACEMAKER
                                            </th>
                                            <td style="padding-bottom: 2px; font-weight:700;">
                                                {{ $data['generator_code'] }}
                                            </td>
                                            <td style="padding-bottom: 2px; font-weight:700;">
                                                {{ $data['implant_generator_sn'] }}
                                            </td>
                                            <td style="padding-bottom: 2px; font-weight:700;">
                                                {{ $data['implant_date'] }}
                                            </td>
                                        </tr>
                                        @foreach (array_chunk($data['models'], 3) as $modelRow)
                                            @foreach ($modelRow as $item)
                                                <tr>
                                                    <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                                                        {{ $item['model_category'] }}
                                                    </th>
                                                    <td style="padding-bottom: 2px; font-weight:700;">
                                                        {{ $item['model_code'] }}
                                                    </td>
                                                    <td style="padding-bottom: 2px; font-weight:700;">
                                                        {{ $item['implant_model_sn'] }}
                                                    </td>
                                                    <td style="padding-bottom: 2px; font-weight:700;">
                                                        @if (($item['model_code'] ?? '-') === '-')
                                                            -
                                                        @else
                                                            {{ $data['implant_date'] }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </table>
                                    <!-- [ Pacemake & Model details ] end -->

                                    <!-- [ Physician details ] start -->
                                    <table width="100%" style="color: rgb(0, 0, 0); font-size: 5pt;">
                                        <tr>
                                            <th
                                                style="padding-left: 15px; padding-top: 5px; padding-bottom: 2px; font-weight:700; width:30%;">
                                                PHYSICIAN
                                            </th>
                                            <td style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                                                {{ $data['doctor_name'] }}
                                            </td>
                                            <td rowspan="3"
                                                style="padding-bottom: 2px; font-weight:700;text-align: center;width:20%;padding-right: 15px;">
                                                <img src="../assets/images/card/1.5T_icon.JPG" width="60"
                                                    alt="Abbott Logo">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                                                HOSPITAL
                                            </th>
                                            <td style="padding-bottom: 2px; font-weight:700;">
                                                {{ $data['hospital_name'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                                                CONTACT NO
                                            </th>
                                            <td style="padding-bottom: 2px; font-weight:700;">
                                                {{ $data['hospital_phoneno'] }}
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- [ Physician details ] end -->
                                </div>
                                <!-- [ Back ] end -->

                                <a href="javascript: void(0)" class="link-primary mt- mb-3 d-none d-md-block" data-bs-toggle="modal"
                                    data-bs-target="#viewBackCard">View Fullscreen (Back)</a>

                            </div>

                            {{-- <form action="">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Patient Email Address</label>
                                            <input type="email" class="form-control"
                                                placeholder="Enter Patient Email Address">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">Sent</button>
                                </div>
                            </form> --}}

                        </div>
                    </div>
                </div>
                <!-- [ Generate Patient ID Card ] end -->
            </div>

            <div class="modal fade" id="viewFrontCard" tabindex="-1" role="dialog" aria-labelledby="viewFrontCard"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" >
                    <div class="modal-content border-0" style="background: transparent;">
                        <div class="modal-header border-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card-wrapper">
                                <!-- [ Front ] start -->
                                <div class="card-container-modal dark-card">
                                    <table width="100%" style="color: white; font-size: 12pt; letter-spacing:0.5pt;">
                                        <tr>
                                            <td colspan="2"
                                                style="padding-top: 20px; padding-left: 30px; font-weight:700; font-family: Times New Roman;">
                                                THIS PATIENT HAS A
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"
                                                style="padding-top: 5px; padding-left: 30px; font-weight:700; font-family: Times New Roman; color: #4d9cf0;">
                                                MRI CONDITIONAL DEVICES
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 5px; padding-left: 30px; width:50%;">
                                                <img src="../assets/images/card/MR_icon.png" width="80"
                                                    alt="Abbott Logo">
                                            </td>
                                            <td style="padding-top: 5px; padding-left: 30px; width:50%;">
                                                <img src="../assets/images/logo/abbott-logo-white.png" width="100"
                                                    alt="Abbott Logo">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- [ Front ] end -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="viewBackCard" tabindex="-1" role="dialog" aria-labelledby="viewBackCard"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" >
                    <div class="modal-content border-0" style="background: transparent;">
                        <div class="modal-header border-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card-wrapper">
                                 <!-- [ Back ] start -->
                                 <div class="card-container-modal blue-card">
                                    <!-- [ Header ] start -->
                                    <table width="100%" style="background-color: #007bff; color: white; font-size: 9px;"
                                        border="1">
                                        <tr>
                                            <td style="padding: 10px; padding-left: 15px;">
                                                <img src="../assets/images/logo/abbott-logo-white.png" width="60"
                                                    alt="Abbott Logo">
                                            </td>
                                            <td
                                                style="text-align: right;padding: 10px;padding-right: 15px;  font-weight:700; ">
                                                Patient Identification Card
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- [ Header ] end -->

                                    <!-- [ Patient details ] start -->
                                    <table width="100%" style="color: rgb(0, 0, 0); font-size: 5pt;">
                                        <tr>
                                            <th
                                                style="padding-left: 15px; padding-top: 10px; padding-bottom: 2px; font-weight:700; width:30%;">
                                                PATIENT
                                            </th>
                                            <td style="padding-top: 10px; padding-bottom: 2px; font-weight:700;">
                                                {{ $data['implant_pt_name'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                                                I/C / MRN
                                            </th>
                                            <td style="padding-bottom: 2px; font-weight:700;">
                                                {{ $data['implant_pt_icno'] }}
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- [ Patient details ] end -->

                                    <!-- [ Pacemake & Model details ] start -->
                                    <table width="100%" style="color: rgb(0, 0, 0); font-size: 5pt;">
                                        <tr>
                                            <th
                                                style="padding-left: 15px; padding-top: 5px; padding-bottom: 2px; font-weight:700; width:30%;">
                                            </th>
                                            <th style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                                                MODEL NO
                                            </th>
                                            <th style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                                                SERIAL NO
                                            </th>
                                            <th style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                                                IMPLANT DATE
                                            </th>
                                        </tr>
                                        <tr>
                                            <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                                                PACEMAKER
                                            </th>
                                            <td style="padding-bottom: 2px; font-weight:700;">
                                                {{ $data['generator_code'] }}
                                            </td>
                                            <td style="padding-bottom: 2px; font-weight:700;">
                                                {{ $data['implant_generator_sn'] }}
                                            </td>
                                            <td style="padding-bottom: 2px; font-weight:700;">
                                                {{ $data['implant_date'] }}
                                            </td>
                                        </tr>
                                        @foreach (array_chunk($data['models'], 3) as $modelRow)
                                            @foreach ($modelRow as $item)
                                                <tr>
                                                    <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                                                        {{ $item['model_category'] }}
                                                    </th>
                                                    <td style="padding-bottom: 2px; font-weight:700;">
                                                        {{ $item['model_code'] }}
                                                    </td>
                                                    <td style="padding-bottom: 2px; font-weight:700;">
                                                        {{ $item['implant_model_sn'] }}
                                                    </td>
                                                    <td style="padding-bottom: 2px; font-weight:700;">
                                                        @if (($item['model_code'] ?? '-') === '-')
                                                            -
                                                        @else
                                                            {{ $data['implant_date'] }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </table>
                                    <!-- [ Pacemake & Model details ] end -->

                                    <!-- [ Physician details ] start -->
                                    <table width="100%" style="color: rgb(0, 0, 0); font-size: 5pt;">
                                        <tr>
                                            <th
                                                style="padding-left: 15px; padding-top: 5px; padding-bottom: 2px; font-weight:700; width:30%;">
                                                PHYSICIAN
                                            </th>
                                            <td style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                                                {{ $data['doctor_name'] }}
                                            </td>
                                            <td rowspan="3"
                                                style="padding-bottom: 2px; font-weight:700;text-align: center;width:20%;padding-right: 15px;">
                                                <img src="../assets/images/card/1.5T_icon.JPG" width="60"
                                                    alt="Abbott Logo">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                                                HOSPITAL
                                            </th>
                                            <td style="padding-bottom: 2px; font-weight:700;">
                                                {{ $data['hospital_name'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="padding-left: 15px; padding-bottom: 2px; font-weight:700;">
                                                CONTACT NO
                                            </th>
                                            <td style="padding-bottom: 2px; font-weight:700;">
                                                {{ $data['hospital_phoneno'] }}
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- [ Physician details ] end -->
                                </div>
                                <!-- [ Back ] end -->
                            </div>

                        </div>
                    </div>
                </div>
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

            $(function() {

                // DATATABLE : IMPLANT [TO BE IMPLEMENTED]
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    autoWidth: false,
                    ajax: {
                        url: "{{ route('manage-designation-page') }}",
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
                        },
                        {
                            data: 'department_name',
                            name: 'department_name'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            searchable: false

                        },
                    ]

                });

            });

        });
    </script>
@endsection
<!-- [ Main Content ] end -->
