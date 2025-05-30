<style>
    @page {
        margin: 10mm;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 9pt;
        line-height: 1.3;
        color: #000000;
        margin: 0;
        padding: 0;
    }

    .wrapper-form {
        width: 100%;

    }

    .header-table {
        width: 100%;
        border-bottom: 2px solid #000;
        margin-bottom: 3mm;
        table-layout: fixed;
    }

    .header-table td {
        vertical-align: middle;
        padding-bottom: 10px;
    }

    .logo-cell img {
        height: 10mm;
    }

    .title-cell {
        font-size: 11pt;
        font-weight: bold;
        text-align: center;
        text-transform: uppercase;
    }

    .meta-cell {
        text-align: right;
        font-size: 8pt;
    }

    .patient-info {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 3mm;
        font-size: 8pt;
    }

    .patient-info td {
        padding: 1mm;
        border: 1px solid #000;
        vertical-align: top;
    }

    .info-label {
        background: #EEE;
        font-weight: bold;
        width: 15%;
    }

    .products-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 8pt;
        margin-bottom: 3mm;
        table-layout: fixed;
    }

    .products-table th,
    .products-table td {
        border: 1px solid #000;
        padding: 1mm;
        vertical-align: top;
        word-wrap: break-word;
        text-align: center;
    }

    .products-table th {
        background: #EEE;
    }

    .products-table th:nth-child(4),
    .products-table td:nth-child(4),
    .products-table th:nth-child(6),
    .products-table td:nth-child(6) {
        width: 6%;
    }

    .products-table th:nth-child(1),
    .products-table td:nth-child(1) {
        width: 8%;
    }

    .products-table th:nth-child(5),
    .products-table td:nth-child(5) {
        width: 30%;
        text-transform: uppercase;
    }

    .products-table tfoot td {
        background: #EEE;
        font-weight: bold;
        text-align: center;
    }

    .payment-section {
        border-left: 2px solid #000;
        padding-left: 2mm;
        margin-bottom: 3mm;
        font-size: 8pt;
    }

    .payment-method {
        font-weight: bold;
    }

    .payment-note {
        font-style: italic;
        color: #555;
    }

    .bottom-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        font-size: 8pt;
    }

    .bottom-table td {
        vertical-align: top;
        padding: 1mm;
        border: 1px solid #000;
        width: 50%;
    }

    .section-title {
        font-weight: bold;
        margin-bottom: 1mm;
        text-decoration: underline;
    }

    .location-code {
        font-weight: bold;
        display: inline-block;
        width: 9mm;
    }

    .footer {
        margin-top: 3mm;
        padding-top: 2mm;
        border-top: 1px solid #000;
        font-size: 8pt;
    }
</style>

<title>{{ $title }}</title>

<div class="wrapper-form">
    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <img src="assets/images/logo/abbott-logo.png" alt="Abbott Logo">
            </td>
            <td class="title-cell">
                <div style="display:block;">
                    INVENTORY CONSUMPTION FORM
                </div>
                <small style="text-align: center; display:block; font-size: 8pt; font-weight: normal;">Cardiac Rythm Management Division</small>
            </td>
            <td class="meta-cell">
                <strong>Invoice No:</strong> ??<br>
                <strong>Date:</strong> ??<br>
            </td>
        </tr>
    </table>

    <!-- Patient Information -->
    <table class="patient-info">
        <tr>
            <td class="info-label">Bill to:</td>
            <td>{{ $data['implant_pt_name'] }}</td>
            <td class="info-label">Ship to:</td>
            <td>{{ $data['hospital_name'] }}</td>
        </tr>
        <tr>
            <td class="info-label">Patient Name:</td>
            <td>{{ $data['implant_pt_name'] }}</td>
            <td class="info-label">Patient IC:</td>
            <td>{{ $data['implant_pt_icno'] }}</td>
        </tr>
        <tr>
            <td class="info-label">Patient MRN:</td>
            <td>{{ $data['implant_pt_mrn'] }}</td>
            <td class="info-label">Address:</td>
            <td>{{ $data['implant_pt_address'] }}</td>
        </tr>
    </table>

    <!-- Products Table -->
    <table class="products-table">
        <thead>
            <tr>
                <th>Implant Date</th>
                <th>Model No.</th>
                <th>Serial/Batch No.</th>
                <th>Stk Loc</th>
                <th>Product Description</th>
                <th>Qty</th>
                <th>Unit Price (MYR)</th>
                <th>Amount (MYR)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
                $total += $data['implant_generator_qty'] * $data['implant_generator_itemPrice'];
            @endphp
            <tr>
                <td>{{ $data['implant_date'] }}</td>
                <td>{{ $data['generator_code'] }}</td>
                <td>{{ $data['implant_generator_sn'] }}</td>
                <td>{{ $data['stock_location_code'] }}</td>
                <td>{{ $data['generator_name'] }}</td>
                <td>{{ $data['implant_generator_qty'] }}</td>
                <td>{{ $data['implant_generator_itemPrice'] == 0 ? '' : number_format($data['implant_generator_itemPrice'], 2) }}
                </td>
                <td>{{ $data['implant_generator_qty'] * $data['implant_generator_itemPrice'] == 0 ? '' : number_format($data['implant_generator_qty'] * $data['implant_generator_itemPrice'], 2) }}
                </td>
            </tr>
            @foreach ($data['models'] as $item)
                @php
                    $total += $item['implant_model_qty'] * $item['implant_model_itemPrice'];
                @endphp
                @if ($item['model_code'] !== '-')
                    <tr>
                        <td></td>
                        <td>{{ $item['model_code'] }}</td>
                        <td>{{ $item['implant_model_sn'] }}</td>
                        <td>{{ $item['stock_location_code'] }}</td>
                        <td>{{ $item['model_name'] }}</td>
                        <td>{{ $item['implant_model_qty'] }}</td>
                        <td>{{ $item['implant_model_itemPrice'] == 0 ? '' : number_format($item['implant_model_itemPrice'], 2) }}
                        </td>
                        <td>{{ $item['implant_model_qty'] * $item['implant_model_itemPrice'] == 0 ? '' : number_format($item['implant_model_qty'] * $item['implant_model_itemPrice'], 2) }}
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" style="text-align: right;">TOTAL:</td>
                <td>{{ number_format($total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- Payment Section -->
    <div class="payment-section">
        <div class="payment-method">Payment Method: ???? (MYR {{ number_format($total, 2) }})</div>
        <div class="payment-note">*(Patient self-paid / Welfare Approval / Hospital / Bumi Agent)</div>
    </div>

    <!-- Bottom Sections -->
    <table class="bottom-table">
        <tr>
            <td>
                <div class="section-title">Stock Location Codes</div>
                <ul style="margin: 0; padding-left: 3em;">
                    @foreach ($stocklocations->where('stock_location_status', 1) as $sl)
                        <li><strong>{{ $sl->stock_location_code }}</strong> = {{ $sl->stock_location_name }}</li>
                    @endforeach
                </ul>
            </td>
            <td>
                <div class="section-title">Required Supporting Documents</div>
                <ol style="margin: 0; padding-left: 3em;">
                    <li>Delivery Order (with Stamp and Signature)</li>
                    <li>Implant Registration Form (IRF)</li>
                    <li>Welfare Approval Letter / GL (if applicable)</li>
                    <li>Purchase Order (if applicable)</li>
                    <li>Patient Consent Form</li>
                </ol>
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        <div><strong>Remark from Sales:</strong> All products delivered and implanted as per schedule</div>
    </div>
</div>
