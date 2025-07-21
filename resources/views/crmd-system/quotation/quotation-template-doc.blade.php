<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #333;
            margin: 20px;
        }

        h1, h2, h3, p {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .section {
            margin: 20px 0;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #999;
            padding: 6px;
            vertical-align: top;
        }

        .items-table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        ul {
            margin: 5px 0 5px 15px;
            padding: 0;
        }

        .small-text {
            font-size: 10pt;
        }

        .signature {
            margin: 40px 0;
        }

        .prepared-by p {
            margin: 3px 0;
        }

        .letterhead {
            border-bottom: 1px solid #3e3e3e;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .box-sender {
            border: 1px solid #3e3e3e;
            padding: 5px;
        }

        .align-right {
            text-align: right;
        }

        .company-info {
            text-align: right;
            font-size: 9pt;
            color: #767676;
        }

        .auth-header {
            font-weight: bold;
            margin: 20px 0 40px;
            font-size: 10pt;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

    {{-- Page 1: Quotation --}}
    <table class="letterhead">
        <tr>
            <td width="20%" valign="top">
                <img src="{{ public_path(str_replace('public/', 'storage/', $data['company_logo'])) }}" alt="Company Logo" style="width:150px;">
            </td>
            <td width="55%" valign="top" class="small-text">
                <strong>{{ $data['company_name'] }}</strong> ({{ $data['company_ssm'] }})<br>
                {!! nl2br(e($data['company_address'])) !!}<br>
                @if ($data['company_email'] != '-') <strong>Email:</strong> {{ $data['company_email'] }}<br> @endif
                @if ($data['company_website'] != '-') <strong>Website:</strong> {{ $data['company_website'] }}<br> @endif
                @if ($data['company_phoneno'] != '-') <strong>Tel:</strong> {{ $data['company_phoneno'] }} @endif
                @if ($data['company_fax'] != '-') &nbsp;&nbsp;&nbsp;<strong>Fax:</strong> {{ $data['company_fax'] }} @endif
            </td>
        </tr>
    </table>

    <div class="section small-text">
        <table>
            <tr>
                <td width="50%" valign="top">
                    <strong>Date:</strong> {{ date('d F Y', strtotime($data['quotation_date'])) }}<br><br>
                    Cardiology Department<br>
                    {{ $data['hospital_name'] }}<br>
                    {!! nl2br(e($data['hospital_address'])) !!}<br>
                    Attn: {{ $data['quotation_attn'] }}
                </td>
                <td width="50%" valign="top" align="left">
                    <div class="align-right">
                        <strong>Our ref:</strong> {{ $data['quotation_refno'] }}
                    </div><br>
                    <div class="box-sender">
                        <strong>No. Pendaftaran Syarikat (SSM):</strong> {{ $data['company_ssm'] }}<br>
                        <strong>Email:</strong> {{ $data['sender_email'] }}<br>
                        <strong>Tel:</strong> {{ $data['sender_telno'] }}<br>
                        <strong>Fax:</strong> {{ $data['sender_fax'] }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section small-text">
        <p>Dear Sir/Madam,</p><br>
        <p style="text-decoration: underline;"><strong>Subject: {{ $data['quotation_subject'] }}</strong></p>
        <p>Enclosed please find our quotation for your kind perusal.</p>
    </div>

    <div class="section">
        <table class="items-table small-text">
            <thead>
                <tr>
                    <th>Model</th>
                    <th>Description</th>
                    <th>Unit Price (RM)</th>
                    <th>Qty</th>
                    <th>Total Price (RM)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data['generator_code'] }}</td>
                    <td>
                        Brand: Abbott Medical<br>
                        Product: {{ $data['generator_name'] }}
                        <ul>
                            @foreach ($data['generator_model'] as $model)
                                <li>{{ $model->model_name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-right">{{ number_format($data['quotation_unitprice'], 2) }}</td>
                    <td class="text-center">{{ $data['quotation_qty'] }}</td>
                    <td class="text-right">{{ number_format($data['quotation_totalprice'], 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section small-text">
        <strong>System Features:</strong> Rate Modulation, Auto Capture Pacing System, Extended Hysteresis, Rest Rate,
        AF Suppression, Auto Mode Switch, Ventricle Intrinsic Preference, 14 mins EGM Recording and MRI Compatible.
    </div>

    <div class="section small-text">
        <strong>Patient:</strong> {{ $data['quotation_pt_name'] }}<br>
        <strong>I/C no:</strong> {{ $data['quotation_pt_icno'] }}<br>
    </div>

    <div class="section small-text">
        <strong>Terms and Conditions:</strong><br><br>
        <strong>Delivery:</strong> Subject to prior sales otherwise 8–12 weeks upon receipt of confirmed order<br>
        <strong>Validity:</strong> {{ date('d F Y', strtotime($data['quotation_date'])) }} - {{ date('d F Y', strtotime('+1 year', strtotime($data['quotation_date']))) }} (1 year)<br>
        <strong>Payment:</strong> By bank draft made payable to "{{ $data['company_name'] }}"
    </div>

    <div class="signature small-text">
        <p>Thank you.<br>Yours sincerely,</p>
    </div>

    <div class="prepared-by small-text">
        <p>Prepared By</p>
        <p>{{ $data['user_name'] }}</p>
        <p>({{ $data['designation_name'] }})</p>
    </div>

    {{-- Page 2: Authorisation Letter --}}
    <div class="page-break"></div>

    <table>
        <tr>
            <td width="50%">
                <img src="{{ public_path('assets/images/logo/abbott-logo.png') }}" alt="Abbott Logo" style="width: 120px;">
            </td>
            <td width="50%" class="company-info">
                <strong>Abbott Medical (Malaysia) Sdn. Bhd.</strong><br>
                27-02, Level 27 Imazium,<br>
                No. 8, Jalan SS21/37,<br>
                Damansara Uptown, 47400<br>
                Petaling Jaya, Selangor, Malaysia.<br>
                T: +603 79887000
            </td>
        </tr>
    </table>

    <div class="section">
        <strong>Date:</strong> {{ date('d F Y', strtotime($data['quotation_date'])) }}
    </div>

    <div class="section">
        <p class="auth-header">LETTER OF AUTHORISATION FOR AUTHORISED REPRESENTATIVE</p>
    </div>

    <div class="section">
        <p>
            We, the undersigned a company whose registered office is at 27-02, Level 27 Imazium, No 8, Jalan SS21/37,
            Damansara Uptown, 47400, Petaling Jaya, Selangor, Malaysia declares to have appointed
            <strong style="text-transform: capitalize;">{{ $data['company_name'] }}</strong> whose registered office is at {{ $data['company_address'] }} as our agent to supply Cardiac Rhythm Management
            (CRM) products to all MOH hospitals in Malaysia.
        </p>
        <br>
        <p>
            <strong style="text-transform: capitalize;">{{ $data['company_name'] }}</strong> is therefore authorized by Abbott Medical (Malaysia) Sdn Bhd
            to distribute Abbott Medical’s CRM products.
        </p>
    </div>

    <div class="signature small-text">
        <p>Yours sincerely,</p>
    </div>

    <div class="prepared-by small-text">
        Michael Chuah<br>
        Regional Business Manager Malaysia<br>
        Cardiac Rhythm Management Division<br>
        Abbott Medical (Malaysia) Sdn Bhd
    </div>

</body>
</html>
