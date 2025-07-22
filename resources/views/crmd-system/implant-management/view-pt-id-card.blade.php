<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title }}</title>
    <link href="{{ public_path('assets/css/plugins/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        @page {
            size: 3.5in 2in;
            margin: 0;
        }

        .card-container {
            width: 3.5in;
            height: 2in;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 16px;
            font-family: Arial, sans-serif;
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
    </style>
</head>

<body>
    @if ($opt == 1 || $opt == 2 || $opt == 3)
        <div class="card-container" style="background-color: #2e2e2e;">
            <!-- [ Front-Card ] start -->
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
                        <img src="{{ public_path('assets/images/card/MR_icon.png') }}" width="80" alt="Abbott Logo">
                    </td>
                    <td style="padding-top: 5px; padding-left: 30px; width:50%;">
                        <img src="{{ public_path('assets/images/logo/abbott-logo-white.png') }}" width="100"
                            alt="Abbott Logo">
                    </td>
                </tr>
            </table>
            <!-- [ Front-Card ] end -->
        </div>

        <div class="card-container">
            <!-- [ Header ] start -->
            <table width="100%" class=" @if ($opt == 1) header-non-mri @else header-mri @endif">
                <tr>
                    <td style="padding: 8px; padding-left: 15px;">
                        <img src="{{ public_path('assets/images/logo/abbott-logo-white.png') }}" width="60"
                            alt="Abbott Logo">
                    </td>
                    <td style="text-align: right;padding: 8px;padding-right: 15px;  font-weight:700; font-size: 8px;">
                        Patient Identification Card
                    </td>
                </tr>
            </table>
            <!-- [ Header ] end -->

            <!-- [ Patient details ] start -->
            <table width="100%" style="color: rgb(0, 0, 0); font-size: 4.5pt;">
                <tr>
                    <th style="padding-left: 15px; padding-top: 10px; padding-bottom: 2px; font-weight:700; width:30%;">
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
            <table width="100%" style="color: rgb(0, 0, 0); font-size: 4.5pt;">
                <tr>
                    <th style="padding-left: 15px; padding-top: 5px; padding-bottom: 2px; font-weight:700; width:30%;">
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
            <table width="100%" style="color: rgb(0, 0, 0); font-size: 4.5pt;">
                <tr>
                    <th style="padding-left: 15px; padding-top: 5px; padding-bottom: 2px; font-weight:700; width:30%;">
                        PHYSICIAN
                    </th>
                    <td style="padding-top: 5px; padding-bottom: 2px; font-weight:700;">
                        {{ $data['doctor_name'] }}
                    </td>
                    <td rowspan="3"
                        style="padding-bottom: 2px; font-weight:700;text-align: center;width:20%;padding-right: 15px;">
                        @if ($opt == 2)
                            <img src="{{ public_path('assets/images/card/1.5T_icon.JPG') }}" width="60"
                                alt="1.5TLogo">
                        @elseif($opt == 3)
                            <img src="{{ public_path('assets/images/card/3.0T_icon.jpeg') }}" width="60"
                                alt="3.0TLogo">
                        @endif
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
    @endif
</body>

</html>
