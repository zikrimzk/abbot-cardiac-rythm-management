{{-- @php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }

            body {
                width: 210mm;
                /* A4 width */
                height: 297mm;
                /* A4 height */
            }
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            padding: 20px;
        }

        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .header {
            /* border-bottom: 3px solid #000; */
            padding-top: 10px;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            /* background: #000000; */
            /* color: white; */
            padding: 5px;
            /* border-radius: 5px; */
        }

        .table-fixed {
            table-layout: fixed;
            width: 100%;
        }

        .table-fixed th,
        .table-fixed td {
            width: {{ 100 / count($im['models']) }}%;
            /* Bahagi sama rata ikut bilangan model */
            text-align: center;
            /* Pusatkan teks */
            vertical-align: middle;
            /* Pusatkan kandungan */
        }

        .table-fixed td .row {
            margin: 0;
            /* Buang margin supaya kemas */
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="row header align-items-center">
        <div class="col-6">
            <img src="../assets/images/logo/abbott-logo.png" class="img-fluid" width="180" height="90"
                alt="Abbott Logo" />
        </div>
        <div class="col-6 text-end">
            <h3 class="fw-bold mb-2">Implant Registration Form</h3>
        </div>
        <div class="col-12 text-end">
            <small><strong>Implant Date (dd/mm/yyyy) :</strong>
                {{ $im['implant_date'] }}</small>
        </div>
    </div>


    <!-- Patient Information -->
    <h6 class="section-title fs-6">Patient Information</h6>
    <table class="table border border-2 border-black table-bordered" style="font-size: 10pt; background:#ffffff;">
        <tr>
            <th>Name</th>
            <td>{{ $im['implant_pt_name'] }}</td>
            <th>IC / Passport No</th>
            <td>{{ $im['implant_pt_icno'] }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td>{{ $im['implant_pt_dob'] }}</td>
            <th>MRN</th>
            <td>{{ $im['implant_pt_mrn'] }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td colspan="3">{{ $im['implant_pt_address'] }}</td>
        </tr>
        <tr>
            <th>Telephone</th>
            <td>{{ $im['implant_pt_phoneno'] }}</td>
            <th>Email</th>
            <td>{{ $im['implant_pt_email'] }}</td>
        </tr>
    </table>

    <!-- Physician Information -->
    <h6 class="section-title fs-6">Implanting Physician Information</h6>
    <table class="table border border-2 border-black table-bordered" style="font-size: 10pt; background:#ffffff;">
        <tr>
            <th>Name of Implanter</th>
            <td>{{ $im['doctor_name'] ?? '-' }}</td>
            <th>Telephone</th>
            <td>{{ $im['hospital_phoneno'] ?? '-' }}</td>
        </tr>
        <tr>
            <th>Hospital</th>
            <td>{{ $im['hospital_name'] ?? '-' }}</td>
            <th>Telephone</th>
            <td>{{ $im['doctor_phoneno'] ?? '-' }}</td>
        </tr>
    </table>

    <!-- Pulse Generator Information -->
    <h6 class="section-title fs-6">Pulse Generator (Pacemaker/ICD/CRT)</h6>
    <table class="table table-fixed border border-2 border-black table-bordered"
        style="font-size: 10pt; background:#ffffff;">
        <tr>
            <th colspan="6">Generator</th>
        </tr>
        <tr>
            <th>
                Model Name
            </th>
            <td>
                {{ $im['generator_name'] }}
            </td>
            <th>
                Model
            </th>
            <td>
                {{ $im['generator_code'] }}
            </td>
            <th>
                S/N
            </th>
            <td>
                {{ $im['implant_generator_sn'] }}
            </td>
        </tr>
    </table>
    <table class="table table-fixed border border-2 border-black table-bordered"
        style="font-size: 10pt; background:#ffffff;">

        @foreach (array_chunk($im['models'], 2) as $modelRow)
            <tr>
                @foreach ($modelRow as $item)
                    <th>{{ $item['model_category'] }}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($modelRow as $item)
                    <td>
                        <div class="row">
                            <div class="col-5 fw-bold">Model</div>
                            <div class="col-1 fw-bold">:</div>
                            <div class="col-6 fw-normal">{{ $item['model_code'] }}</div>
                        </div>

                        <div class="row">
                            <div class="col-5 fw-bold">S/N</div>
                            <div class="col-1 fw-bold">:</div>
                            <div class="col-6 fw-normal">{{ $item['implant_model_sn'] }}</div>
                        </div>
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>

    <!-- Signature -->
    <div class="row mt-4">
        <div class="col-8" style="font-size: 10pt;">
            <p class="fw-normal text-muted">System Generated Document – No Signature Required</p>
        </div>
        <div class="col-4 text-end" style="font-size: 10pt;">
            <p><strong>Date:</strong> {{ Carbon::parse($im['implant_date'])->format('d/M/Y') }}</p>
        </div>
    </div>
</body>

</html> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Test</title>

    {{-- Bootstrap CSS (Only works if "isRemoteEnabled" is true in dompdf.php) --}}
    {{-- <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <link href="{{ public_path('assets/css/plugins/bootstrap.min.css') }}" rel="stylesheet" type="text/css">


    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            padding: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #256bec;
            font-weight: bold;
        }

        .section-title {
            font-weight: bold;
            padding: 5px;
        }

        .table-fixed {
            table-layout: fixed;
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .text-muted {
            color: #6c757d;
        }

        .footer {
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #000;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="mb-2">
            <img src="{{ public_path('assets/images/logo/abbott-logo.png') }}" width="180" alt="Abbott Logo">
        </div>
        <div>
            <h3 class="fw-bold text-center">Implant Registration Form</h3>
        </div>
        <div class="text-end">
            <small><strong>Implant Date :</strong> {{ $im['implant_date'] }}</small>
        </div>
        <div class="text-end">
            <small><strong>Ref No :</strong> ##</small>
        </div>
    </div>

    <!-- Patient Information -->
    <h6 class="section-title fs-6">Patient Information</h6>
    <table class="table">
        <tr>
            <th>Name</th>
            <td>{{ $im['implant_pt_name'] }}</td>
            <th>IC / Passport No</th>
            <td>{{ $im['implant_pt_icno'] }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td>{{ $im['implant_pt_dob'] }}</td>
            <th>MRN</th>
            <td>{{ $im['implant_pt_mrn'] }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td colspan="3">{{ $im['implant_pt_address'] }}</td>
        </tr>
        <tr>
            <th>Telephone</th>
            <td>{{ $im['implant_pt_phoneno'] }}</td>
            <th>Email</th>
            <td>{{ $im['implant_pt_email'] }}</td>
        </tr>
    </table>

    <!-- Physician Information -->
    <h6 class="section-title fs-6">Implanting Physician Information</h6>
    <table class="table">
        <tr>
            <th>Name of Implanter</th>
            <td>{{ $im['doctor_name'] }}</td>
            <th>Telephone</th>
            <td>{{ $im['doctor_phoneno'] }}</td>
        </tr>
        <tr>
            <th>Hospital</th>
            <td>{{ $im['hospital_name'] }}</td>
            <th>Telephone</th>
            <td>{{ $im['hospital_phoneno'] }}</td>
        </tr>
    </table>

    <!-- Pulse Generator Information -->
    <h6 class="section-title fs-6">Pulse Generator (Pacemaker/ICD/CRT)</h6>
    <table class="table">
        <tr>
            <th colspan="6" style="background-color: #ffff; font-weight: bold; padding: 8px; text-align:center;">Generator</th>
        </tr>
        <tr>
            <th>Model Name</th>
            <td>{{ $im['generator_name'] }}</td>
            <th>Model</th>
            <td>{{ $im['generator_code'] }}</td>
            <th>S/N</th>
            <td>{{ $im['implant_generator_sn'] }}</td>
        </tr>
    </table>

    <table class="table">
        @foreach (array_chunk($im['models'], 2) as $modelRow)
            @foreach ($modelRow as $item)
                <tr>
                    <th colspan="4" style="background-color: #ffff; font-weight: bold; padding: 8px; text-align:center;">
                        {{ $item['model_category'] }}
                    </th>
                </tr>
                <tr>
                    <th>Model</th>
                    <td>{{ $item['model_code'] }}</td>
                    <th>S/N</th>
                    <td>{{ $item['implant_model_sn'] }}</td>
                </tr>
            @endforeach
        @endforeach
    </table>

    <!-- Footer -->
    <div class="footer">
        <div class="text-muted">System Generated Document – No Signature Required</div>
        <div><strong>Date:</strong> ##</div>
    </div>
</body>

</html>
