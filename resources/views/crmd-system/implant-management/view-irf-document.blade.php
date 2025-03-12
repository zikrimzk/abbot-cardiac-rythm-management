@php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title }}</title>
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
            background-color: #FFFF;
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
            <small><strong>Ref No :</strong> {{ $im['implant_code'] }}</small>
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
            <th colspan="6" style="text-align:center;">Generator</th>
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
                    <th colspan="4" style="text-align:center;">
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
        <div><strong>Date:</strong> {{ $im['today_date'] }}</div>
    </div>
</body>

</html>
