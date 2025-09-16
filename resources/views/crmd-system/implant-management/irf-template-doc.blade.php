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
            border: 1px solid #e0e0e0;
            padding: 8px 10px;
            vertical-align: top;
            text-align: left;
        }

        .table th {
            background-color: #f9f9f9;
            font-weight: bold;
            color: #444;
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

        .model-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .model-table th,
        .model-table td {
            border: 1px solid #e0e0e0;
            padding: 8px 10px;
            vertical-align: top;
            text-align: left;
        }

        .model-table th {
            background-color: #eaeaea;
            font-weight: bold;
        }

        .model-table .sub-table-header th {
            font-weight: normal;
            background-color: #f9f9f9;
            color: #444;
        }

        .model-table .sub-table-row td {
            border-top: none;
        }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td class="header-logo">
                <img src="{{ public_path('assets/images/logo/abbott-logo.png') }}" width="120" alt="Abbott Logo">
            </td>

            <td class="header-title">
                <div style="display:block;">
                    IMPLANT REGISTRATION FORM
                </div>
                <small style="text-align: center; display:block; font-size: 8pt; font-weight: normal;">Cardiac Rhythm
                    Management Division</small>
            </td>

            <td class="header-info">
                <div><strong>Implant Date:</strong> {{ $im['implant_date'] }}</div>
                <div><strong>Ref No:</strong> {{ $im['implant_refno'] }}</div>
            </td>
        </tr>
    </table>

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
            @php
                $grouped_models = collect($im['models'])->groupBy('model_category');
            @endphp
            @foreach ($grouped_models as $category => $items)
                <tr>
                    <td rowspan="{{ count($items) }}">{{ $category }}</td>
                    <td>{{ $items[0]['model_code'] }}</td>
                    <td>{{ $items[0]['implant_model_sn'] }}</td>
                </tr>
                @for ($i = 1; $i < count($items); $i++)
                    <tr>
                        <td>{{ $items[$i]['model_code'] }}</td>
                        <td>{{ $items[$i]['implant_model_sn'] }}</td>
                    </tr>
                @endfor
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="text-muted">System Generated Document – No Signature Required</div>
        <div><strong>Date:</strong> {{ $im['today_date'] }}</div>
    </div>
</body>

</html>