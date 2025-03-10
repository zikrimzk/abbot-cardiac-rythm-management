@php

    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Implant Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
                {{ Carbon::parse($im['implant_date'])->format('d/M/Y') }}</small>
        </div>
    </div>


    <!-- Patient Information -->
    <h6 class="section-title fs-6">Patient Information</h6>
    <table class="table border border-2 border-black table-bordered" style="font-size: 10pt; background:#ffffff;">
        <tr>
            <th>Name</th>
            <td>{{ $im['implant_pt_name'] ?? '-' }}</td>
            <th>IC / Passport No</th>
            <td>{{ $im['implant_pt_icno'] ?? '-' }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $im['implant_pt_address'] ?? '-' }}</td>
            <th>Date of Birth</th>
            <td>{{ $im['implant_pt_dob'] ?? '-' }}</td>
        </tr>
        <tr>
            <th>Telephone / Mobile</th>
            <td>{{ $im['implant_pt_phoneno'] ?? '-' }}</td>
            <th></th>
            <td></td>
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
            <th  colspan="6">Generator</th>
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

</html>
