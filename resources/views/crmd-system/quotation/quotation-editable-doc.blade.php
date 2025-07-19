<style>
    .container-doc {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 10pt;
        color: #333;
        margin: 20px;
        max-width: 100%;
        background-color: #fff;
    }

    .container-doc h1,
    .container-doc h2,
    .container-doc h3,
    .container-doc p {
        margin: 0;
        padding: 0;
    }

    .letterhead {
        border-bottom: 2px solid #444;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }

    .container-doc table {
        width: 100%;
        border-collapse: collapse;
    }

    .container-doc .section {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .input-doc,
    .input-doc-subject,
    .input-doc-price,
    textarea {
        padding: 6px 10px;
        font-size: 9pt;
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        transition: border-color 0.2s;
    }

    .input-doc:focus,
    .input-doc-subject:focus,
    .input-doc-price:focus,
    textarea:focus {
        border-color: #007bff;
        outline: none;
    }

    textarea {
        resize: vertical;
        min-height: 80px;
        background-color: #f9f9f9;
    }

    .items-table th,
    .items-table td {
        border: 1px solid #999;
        padding: 8px;
        vertical-align: top;
    }

    .items-table th {
        background-color: #f0f0f0;
        text-align: center;
        font-weight: 600;
    }

    .items-table td.text-center {
        text-align: center;
    }

    .items-table td.text-right {
        text-align: right;
    }

    .small-text {
        font-size: 9pt;
        line-height: 1.5;
    }

    .signature {
        margin-top: 40px;
    }

    .prepared-by {
        margin-top: 30px;
    }

    .prepared-by p {
        margin: 3px 0;
    }

    @media screen and (max-width: 768px) {
        .letterhead td,
        .section td {
            display: block;
            width: 100%;
        }

        .letterhead td img {
            margin-bottom: 10px;
            max-width: 100%;
        }

        .items-table thead {
            display: none;
        }

        .items-table tr {
            display: block;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 10px;
            background-color: #fefefe;
        }

        .items-table td {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border: none;
            border-bottom: 1px solid #eee;
        }

        .items-table td:last-child {
            border-bottom: none;
        }

        .items-table td::before {
            content: attr(data-label);
            font-weight: bold;
            width: 50%;
            color: #555;
        }

        .items-table td input {
            width: 48%;
            font-size: 9pt;
        }
    }
</style>

<div class="container-doc">

    <!-- Header / Letterhead -->

    @if ($company == 1)
        <table class="letterhead">
            <tr>
                <td width="20%" valign="top">
                    <img src="{{ asset('assets/images/quotation/dch-auriga.png') }}" alt="Company Logo"
                        style="width:250px;">
                </td>
                <td width="55%" valign="top" class="small-text">
                    <strong>DCH AURIGA (MALAYSIA) SDN BHD</strong> (193101000021)<br>
                    LOT 6, Persiaran Perusahaan Seksyen 23<br>
                    Kawasan Perusahaan Shah Alam<br>
                    40300 Shah Alam, Selangor Darul Ehsan<br>
                    Malaysia<br>
                    <strong>Website:</strong> www.dchauriga.com<br>
                    <strong>Tel:</strong> +603 5541 7748 &nbsp;&nbsp;&nbsp; <strong>Fax:</strong> +603 5542 1486
                    <br><br>
                </td>
                <td width="25%" valign="top" align="right" class="small-text">
                    <strong>Our ref:</strong><br> <input type="text" name="quotation_refno"
                        value="DCH/HSNZ/PM2172+CSP/2025/001" class="input-doc start-right" readonly>
                    <br><br>
                    <strong>Date:</strong><br> <input type="text" name="quotation_date" value="{{ date('d F Y') }}"
                        class="input-doc start-right" readonly>
                </td>
            </tr>
        </table>
    @elseif($company == 2)
        <table class="letterhead">
            <tr>
                <td width="20%" valign="top">
                    <img src="{{ asset('assets/images/quotation/tsr.png') }}" alt="Company Logo" style="width:150px;">
                </td>
                <td width="55%" valign="top" class="small-text">
                    <strong>TAMASETIA RESOURCES SDN BHD</strong> (199701019150)<br>
                    Wisma KGMB, No. 88-4<br>
                    Jalan Dato Haji Eusoff, Damai Kompleks<br>
                    50400, Kuala Lumpur, Wilayah Persekutuan<br>
                    Malaysia<br>
                    <br><br>
                </td>
                <td width="25%" valign="top" align="right" class="small-text">
                    <strong>Our ref:</strong><br> <input type="text" name="quotation_refno"
                        value="DCH/HSNZ/PM2172+CSP/2025/001" class="input-doc start-right" readonly>
                    <br><br>
                    <strong>Date:</strong><br> <input type="text" name="quotation_date" value="{{ date('d F Y') }}"
                        class="input-doc start-right" readonly>
                </td>
            </tr>
        </table>
    @elseif($company == 3)
        <table class="letterhead">
            <tr>
                <td width="20%" valign="top">
                    <img src="{{ asset('assets/images/quotation/medico.png') }}" alt="Company Logo"
                        style="width:170px;">
                </td>
                <td width="55%" valign="top" class="small-text">
                    <strong>MEDICO SDN BHD</strong> (842014-M)<br>
                    B-1-15, Blok B<br>
                    Jalan PJU 1A/5A, Siera-Park<br>
                    Ara Damansara, 47301 Petaling Jaya<br>
                    Selangor Darul Ehsan.<br>
                    <strong>Email:</strong> medico_01@yahoo.com<br>
                    <strong>Website:</strong> www.medico-sb.com<br>
                    <strong>Tel:</strong> +603-7734 4164 &nbsp;&nbsp;&nbsp; <strong>Fax:</strong> +603-7734 4315
                     <br><br>
                </td>
                <td width="25%" valign="top" align="right" class="small-text">
                    <strong>Our ref:</strong><br> <input type="text" name="quotation_refno"
                        value="DCH/HSNZ/PM2172+CSP/2025/001" class="input-doc start-right" readonly>
                    <br><br>
                    <strong>Date:</strong><br> <input type="text" name="quotation_date" value="{{ date('d F Y') }}"
                        class="input-doc start-right" readonly>
                </td>
            </tr>
        </table>
    @endif



    <!-- Recipient and Sender Details -->
    <div class="section small-text">
        <table>
            <tr>
                <td width="50%" valign="top">
                    Cardiology Department<br>
                    Hospital Sultanah Nur Zahirah<br>
                    20400 Kuala Terengganu<br>
                    Terengganu<br>
                    Attn: <input type="text" name="attn_name" placeholder="Enter attn name" class="input-doc">
                </td>

                @if ($company == 1)
                    <td width="50%" valign="top" align="right">
                        <strong>No. Pendaftaran Syarikat (SSM):</strong> <input type="text" name="company_ssm"
                            value="193101000021 (38809-V)" class="input-doc"><br>
                        <strong>Email:</strong> <input type="text" name="company_email"
                            value="wmnyarcc@dchauriga.com" class="input-doc"><br>
                        <strong>Tel:</strong> <input type="text" name="company_tel" value="+6017-331 0053"
                            class="input-doc"><br>
                        <strong>Fax:</strong> <input type="text" name="company_fax" value="+603-5566 3366"
                            class="input-doc">
                    </td>
                @elseif($company == 2)
                    <td width="50%" valign="top" align="right">
                        <strong>No. Pendaftaran Syarikat (SSM):</strong> <input type="text" name="company_ssm"
                            value="199701019150 (434647-T) " class="input-doc"><br>
                        <strong>Email:</strong> <input type="text" name="company_email" value="alan.chewl@gmail.com"
                            class="input-doc"><br>
                        <strong>Tel:</strong> <input type="text" name="company_tel" value="+6016-476 5161"
                            class="input-doc"><br>
                        <strong>Fax:</strong> <input type="text" name="company_fax" value="+603-5624 1326"
                            class="input-doc">
                    </td>
                @elseif($company == 3)
                    <td width="50%" valign="top" align="right">
                        <strong>No. Pendaftaran Syarikat (SSM):</strong> <input type="text" name="company_ssm"
                            value="842014-M" class="input-doc"><br>
                        <strong>Email:</strong> <input type="text" name="company_email" value="mykle83@gmail.com"
                            class="input-doc"><br>
                        <strong>Tel:</strong> <input type="text" name="company_tel" value="+6017-407 7170"
                            class="input-doc"><br>
                        <strong>Fax:</strong> <input type="text" name="company_fax" value="+603-7734 4315"
                            class="input-doc">
                    </td>
                @endif
            </tr>
        </table>
    </div>

    <!-- Subject -->
    <div class="section">
        <p class="small-text">Dear Sir/Madam,</p><br>
        <p style="text-decoration: underline;" class="small-text"><strong>Subject: <input type="text"
                    name="quotation_subject" placeholder="Enter subject" class="input-doc-subject"></strong> </p>
        <p class="small-text">Enclosed please find our quotation for your kind perusal.</p>
    </div>

    <!-- Quotation Table -->
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
                    <td>PM2172</td>
                    <td>
                        Brand: Abbott Medical<br>
                        Product: Endurity DR MRI pacemaker
                        <ul>
                            <li>Pacemaker model PM2172</li>
                            <li>Tendril 2088TC atrial Lead</li>
                            <li>Tendril 2088TC ventricular Lead</li>
                            <li>CPS Locator 3D</li>
                        </ul>
                    </td>
                    <td class="text-right"><input type="text" name="quotation_unit_price"
                            placeholder="Enter Unit Price" class="input-doc-price" id="quotation_unit_price"></td>
                    <td class="text-center">
                        <input type="text" name="quotation_quantity" placeholder="Enter Qty"
                            class="input-doc-price" id="quotation_quantity">
                    </td>
                    <td class="text-right">
                        <input type="text" name="quotation_totalprice" class="input-doc-price"
                            id="quotation_totalprice">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- System Features -->
    <div class="section small-text">
        <strong>System Features:</strong>
        <textarea name="system_features" cols="30" rows="4" placeholder="Enter System Features">Rate Modulation, Auto Capture Pacing System, Extended Hysteresis, Rest Rate, AF Suppression, Auto Mode Switch, Ventricle Intrinsic Preference, 14 mins EGM Recording and MRI Compatible.</textarea>
    </div>

    <!-- Patient Info -->
    <div class="section small-text">
        <strong>Patient:</strong> <input type="text" name="quotation_pt_name" class="input-doc"
            id="quotation_pt_name" placeholder="Enter Patient Name"><br>
        <strong>I/C no:</strong> <input type="text" name="quotation_pt_icno" class="input-doc"
            id="quotation_pt_icno" placeholder="Enter Patient I/C no">
    </div>

    <!-- Terms and Conditions -->
    <div class="section small-text">
        <strong>Terms and Conditions:</strong><br><br>
        <strong>Delivery:</strong> Subject to prior sales otherwise 8–12 weeks upon receipt of confirmed order<br>
        <strong>Validity:</strong>
        <input type="text" name="quotation_valid_startdate" class="input-doc"
            placeholder="Enter Valid Start Date" value="{{ date('d F Y') }}">
        -
        <input type="text" name="quotation_valid_startdate" class="input-doc"
            placeholder="Enter Valid Start Date" value="{{ date('d F Y', strtotime('+1 year')) }}">
        (1 year)
        <br>
        @if ($company == 1)
            <strong>Payment:</strong> By bank draft made payable to "DCH Auriga (Malaysia) Sdn Bhd"
        @elseif($company == 2)
            <strong>Payment:</strong> By bank draft made payable to "Tamasetia Resources Sdn Bhd"
        @elseif($company == 3)
            <strong>Payment:</strong> By bank draft made payable to "Medico Sdn Bhd"
        @endif

    </div>

    <!-- Signature -->
    <div class="signature">
        <p class="small-text">Thank you.<br>Yours sincerely,</p>
    </div>

    <div class="prepared-by">
        <p class="small-text">Prepared By</p>
        <p class="small-text">{{ auth()->user()->staff_name }}</p>
        <p class="small-text">( {{ auth()->user()->designation->designation_name }} )</p>
    </div>
</div>
<script>
    $(document).ready(function() {
        function calculateTotal() {
            let price = parseFloat($('#quotation_unit_price').val().replace(/,/g, '')) || 0;
            let qty = parseInt($('#quotation_quantity').val()) || 0;
            let total = (price * qty).toFixed(2);
            $('#quotation_totalprice').val(total);
        }

        $('#quotation_unit_price, #quotation_quantity').on('input', calculateTotal);

        $('#quotation_pt_icno').on('input', function() {
            let value = $(this).val().replace(/[^a-zA-Z0-9]/g, '');

            // Malaysian IC Format: xxxxxx-xx-xxxx
            if (/^\d{12}$/.test(value)) {
                value = value.replace(/(\d{6})(\d{2})(\d{4})/, '$1-$2-$3');
            } else {
                value = value.toUpperCase();
            }

            $(this).val(value);
        });
    });
</script>
