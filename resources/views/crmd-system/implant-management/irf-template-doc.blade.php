@php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            padding: 20px;
            font-size: 12px;
            color: #000;
            margin: 0;
        }

        .header-table {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            border-collapse: collapse;
        }

        .header-logo,
        .header-title,
        .header-info {
            vertical-align: middle;
            padding-bottom: 20px;
        }

        .header-logo {
            width: 25%;
            text-align: left;
        }

        .header-title {
            width: 50%;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin: 0;
        }

        .header-info {
            width: 25%;
            text-align: right;
            font-size: 12px;
        }

        .section-title {
            background-color: #f0f0f0;
            border-left: 4px solid #333;
            padding: 6px 10px;
            font-weight: bold;
            margin: 25px 0 10px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
            text-align: left;
        }

        .table th {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #000;
        }

        .text-muted {
            color: #666;
        }

        /* Enhanced Model Table */
        .model-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .model-table th,
        .model-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
            text-align: left;
        }

        .model-table th {
            background-color: #eaeaea;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <!-- Logo on the left -->
            <td class="header-logo">
                <img src="{{ public_path('assets/images/logo/abbott-logo.png') }}" width="120" alt="Abbott Logo">
            </td>

            <!-- Title in the center -->
            <td class="header-title">
                <div class="title"></div>
                <div style="display:block;">
                    IMPLANT REGISTRATION FORM
                </div>
                <small style="text-align: center; display:block; font-size: 8pt; font-weight: normal;">Cardiac Rythm
                    Management Division</small>
            </td>

            <!-- Ref info on the right -->
            <td class="header-info">
                <div><strong>Implant Date:</strong> {{ $im['implant_date'] }}</div>
                <div><strong>Ref No:</strong> {{ $im['implant_refno'] }}</div>
            </td>
        </tr>
    </table>

    <!-- Patient Information -->
    <div class="section-title">Patient Information</div>
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
    <div class="section-title">Implanting Physician Information</div>
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

    <!-- Generator Information -->
    <div class="section-title">Pulse Generator (Pacemaker / ICD / CRT)</div>
    <table class="table">
        <tr>
            <th>Model Name</th>
            <td>{{ $im['generator_name'] }}</td>
            <th>Model</th>
            <td>{{ $im['generator_code'] }}</td>
            <th>S/N</th>
            <td>{{ $im['implant_generator_sn'] }}</td>
        </tr>
    </table>

    <!-- Updated Model Table -->
    <div class="section-title">Leads / Accessories Information</div>
    <table class="model-table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Model</th>
                <th>S/N</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($im['models'] as $item)
                <tr>
                    <td>{{ $item['model_category'] }}</td>
                    <td>{{ $item['model_code'] }}</td>
                    <td>{{ $item['implant_model_sn'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <div class="text-muted">System Generated Document – No Signature Required</div>
        <div><strong>Date:</strong> {{ $im['today_date'] }}</div>
    </div>
</body>

</html>
