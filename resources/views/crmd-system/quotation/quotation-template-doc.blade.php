<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 9pt;
            color: #333;
            margin: 15px;
            line-height: 1.3;
        }
        .letterhead {
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
        }
        .items-table th, 
        .items-table td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        .items-table th {
            /* background-color: #2c3e50;
            color: white; */
            font-weight: bold;
            font-size: 9pt;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .section { margin: 15px 0; }
        .box-sender {
            border: 1px solid #2c3e50;
            background-color: #f8f9fa;
            padding: 8px;
            border-radius: 2px;
            font-size: 8.5pt;
        }
        .patient-info {
            background-color: #f0f8ff;
            padding: 8px;
            border-left: 2px solid #3498db;
            margin: 10px 0;
            font-size: 8.5pt;
        }
        .terms-list {
            padding-left: 12px;
            margin: 5px 0;
            font-size: 8.5pt;
        }
        .terms-list li {
            margin-bottom: 4px;
            list-style-type: square;
        }
        .signature-section {
            margin-top: 25px;
            padding-top: 10px;
            border-top: 1px dashed #ccc;
        }
        .page-break {
            page-break-before: always;
            margin-top: 20px;
        }
        .company-info {
            font-size: 8.5pt;
            color: #555;
        }
        .auth-header {
            font-weight: bold;
            margin: 15px 0;
            font-size: 10pt;
        }
        .compact { margin: 8px 0; }
        .smaller { font-size: 8.5pt; }
        .medium { font-size: 10pt; }

        .no-margin { margin: 0; }
        .subject-line {
            font-weight: bold;
            margin: 10px 0;
            text-decoration: underline;
            font-size: 10pt;
        }
    </style>
</head>
<body>

    {{-- Page 1: Quotation --}}
    <table class="letterhead">
        <tr>
            <td width="25%">
                <img src="{{ public_path(str_replace('public/', 'storage/', $data['company_logo'])) }}" 
                     alt="Company Logo" style="height:50px;">
            </td>
            <td width="75%" class="text-right smaller">
                <strong style="font-size:10pt;">{{ $data['company_name'] }}</strong><br>
                <span class="company-info">
                    {{ $data['company_ssm'] }}<br>
                    {!! nl2br(e($data['company_address'])) !!}<br>
                    @if ($data['company_email'] != '-')Email: {{ $data['company_email'] }}<br>@endif
                    @if ($data['company_website'] != '-')Website: {{ $data['company_website'] }}<br>@endif
                    @if ($data['company_phoneno'] != '-')Tel: {{ $data['company_phoneno'] }}@endif
                    @if ($data['company_fax'] != '-')&nbsp;Fax: {{ $data['company_fax'] }}@endif
                </span>
            </td>
        </tr>
    </table>

    <div class="compact">
        <table>
            <tr>
                <td width="50%" valign="top">
                    <strong>Date:</strong> {{ date('d F Y', strtotime($data['quotation_date'])) }}<br>
                    <strong>To:</strong> Cardiology Department<br>
                    {{ $data['hospital_name'] }}<br>
                    <span class="smaller">{!! nl2br(e($data['hospital_address'])) !!}</span><br>
                    <strong>Attn:</strong> {{ $data['quotation_attn'] }}
                </td>
                <td width="50%" valign="top">
                    <div class="text-right">
                        <strong>Our Ref:</strong> {{ $data['quotation_refno'] }}
                    </div>
                    <div class="box-sender">
                        <strong>Supplier Information</strong><br>
                        No. Pendaftaran Syarikat (SSM): {{ $data['company_ssm'] }}<br>
                        Email: {{ $data['sender_email'] }}<br>
                        Tel: {{ $data['sender_telno'] }}<br>
                        Fax: {{ $data['sender_fax'] }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="compact">
        <p class="no-margin medium">Dear Sir/Madam,</p>
        <div class="subject-line medium">
            Subject: {{ $data['quotation_subject'] }}
        </div>
        <p class="no-margin medium">Enclosed please find our quotation for your kind perusal.</p>
    </div>

    <div class="compact">
        <table class="items-table">
            <thead>
                <tr>
                    <th width="15%">Model</th>
                    <th width="45%">Description</th>
                    <th width="15%">Unit Price (RM)</th>
                    <th width="10%">Qty</th>
                    <th width="15%">Total Price (RM)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data['generator_code'] }}</td>
                    <td>
                        <strong>Brand:</strong> Abbott Medical<br>
                        <strong>Product:</strong> {{ $data['generator_name'] }}
                        <ul class="no-margin" style="margin-left:15px;">
                            @foreach ($data['generator_model'] as $model)
                                <li>{{ $model->model_name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-right">{{ number_format($data['quotation_unitprice'], 2) }}</td>
                    <td class="text-center">{{ $data['quotation_qty'] }}</td>
                    <td class="text-right">{{ number_format($data['quotation_totalprice'], 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                    <td class="text-right"><strong>{{ number_format($data['quotation_totalprice'], 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="compact medium">
        <p>System Features: Rate Modulation, Auto Capture Pacing System, Extended Hysteresis, Rest Rate, AF Suppression, Auto Mode Switch, Ventricle Intrinsic Preference, 14 mins EGM Recording and MRI Compatible.</p>
    </div>

    <div class="medium">
        <strong>Patient:</strong> {{ $data['quotation_pt_name'] }} <br>
        <strong>I/C no:</strong> {{ $data['quotation_pt_icno'] }}
    </div>

    <div class="compact">
        <p class="medium">Terms and Conditions:</p>
        <ul class="terms-list medium">
            <li>Delivery: Subject to prior sales otherwise 8–12 weeks upon receipt of confirmed order</li>
            <li>Validity: {{ date('d F Y', strtotime($data['quotation_date'])) }} - 
                {{ date('d F Y', strtotime('+1 year', strtotime($data['quotation_date']))) }} (1 year)</li>
            <li>Payment: By bank draft made payable to "{{ $data['company_name'] }}"</li>
        </ul>
    </div>

    <div class="signature-section medium">
        <p class="no-margin">Thank you for your consideration.</p>
        <p class="no-margin">Yours sincerely,</p>
        
        <div style="margin-top: 15px;">
            <p class="no-margin"><strong>{{ $data['user_name'] }}</strong></p>
            <p class="no-margin">{{ $data['designation_name'] }}</p>
        </div>
    </div>

    {{-- Page 2: Authorisation Letter --}}
    <div class="page-break"></div>

    <table>
        <tr>
            <td width="40%">
                <img src="{{ public_path('assets/images/logo/abbott-logo.png') }}" 
                     alt="Abbott Logo" style="height:40px;">
            </td>
            <td width="60%" class="company-info text-right">
                <strong>Abbott Medical (Malaysia) Sdn. Bhd.</strong><br>
                27-02, Level 27 Imazium,<br>
                No. 8, Jalan SS21/37,<br>
                Damansara Uptown, 47400<br>
                Petaling Jaya, Selangor, Malaysia.<br>
                T: +603 79887000
            </td>
        </tr>
    </table>

    <div class="compact medium">
        <p><strong>Date:</strong> {{ date('d F Y', strtotime($data['quotation_date'])) }}</p>
    </div>

    <div class="section">
        <p class="auth-header">LETTER OF AUTHORISATION FOR AUTHORISED REPRESENTATIVE</p>
    </div>

    <div class="medium">
        <p>
            We, the undersigned a company whose registered office is at 27-02, Level 27 Imazium, No 8, Jalan SS21/37,
            Damansara Uptown, 47400, Petaling Jaya, Selangor, Malaysia declares to have appointed
            <strong>{{ $data['company_name'] }}</strong> whose registered office is
            at {{ $data['company_address'] }} as our agent to supply Cardiac Rhythm Management
            (CRM) products to all MOH hospitals in Malaysia.
        </p>
        <p>
            <strong>{{ $data['company_name'] }}</strong> is therefore authorized by
            Abbott Medical (Malaysia) Sdn Bhd to distribute Abbott Medical's CRM products.
        </p>
    </div>

    <div class="signature-section medium">
        <p class="no-margin">Yours sincerely,</p>
        
        <div style="margin-top: 25px;" class="medium">
            <p class="no-margin"><strong>Michael Chuah</strong></p>
            <p class="no-margin">Regional Business Manager Malaysia</p>
            <p class="no-margin">Cardiac Rhythm Management Division</p>
            <p class="no-margin">Abbott Medical (Malaysia) Sdn Bhd</p>
        </div>
    </div>

</body>
</html>