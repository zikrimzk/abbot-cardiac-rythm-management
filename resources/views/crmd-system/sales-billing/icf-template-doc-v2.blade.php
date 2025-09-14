<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Inventory Consumption Form</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* @page {
            margin: 20mm 15mm;
        } */

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 8pt;
            line-height: 1.5;
            color: #000;
            background: white;
        }

        /* Main container */
        .container {
            width: 100%;
            max-width: 250mm;
            margin: 0 auto;
        }

        /* Header section */
        .header {
            width: 100%;
            margin-bottom: 25px;
            margin-top: 25px;
            display: table;
            table-layout: fixed;
        }

        /* Logo section - Left */
        .logo-section {
            display: table-cell;
            width: 5%;
            vertical-align: top;
            /* border: 1px solid #000; */
        }

        /* .logo {
            width: 65px;
            height: 42px;
        } */

        .logo img {
            width: 80px;
        }

        /* Title section - Center */
        .title-section {
            display: table-cell;
            width: 25%;
            vertical-align: middle;
            padding: 0 25px;
            /* border: 1px solid #000; */
        }

        .form-title {
            /* text-align: center; */
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 12px;
            color: #000;
            letter-spacing: 0.5px;
            /* border: 1px solid #000; */
        }

        .division {
            font-size: 8pt;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .division-label {
            display: inline-block;
            margin-right: 8px;
            font-weight: bold;
            font-size: 8pt;
        }

        .division-box {
            display: inline-block;
            border: 1px solid #000;
            padding: 0 10px;
            font-weight: bold;
            font-size: 8pt;
        }

        /* Empty right section for balance */
        .empty-section {
            display: table-cell;
            width: 35%;
        }

        /* Combined patient info and stock locations section */
        .info-locations-wrapper {
            width: 100%;
            margin-bottom: 20px;
            display: table;
            table-layout: fixed;
        }

        /* Patient Information Section - Left side */
        .info-section {
            display: table-cell;
            width: 62%;
            vertical-align: top;
            padding-right: 15px;
        }

        .info-row {
            margin-bottom: 7px;
            font-size: 8pt;
            display: block;
            clear: both;
        }

        .info-label {
            display: inline-block;
            width: 95px;
            font-weight: bold;
            vertical-align: bottom;
            font-size: 8pt;
            text-align: right
        }

        .info-value {
            display: inline-block;
            border-bottom: 1px solid #000;
            width: 320px;
            padding-left: 5px;
            padding-bottom: 1px;
            font-size: 8pt;
            vertical-align: bottom;
            text-transform: uppercase;
        }

        .info-row.address-continuation .info-label {
            visibility: hidden;
        }

        /* Stock Locations Section - Right side */
        .locations-section {
            display: table-cell;
            width: 38%;
            vertical-align: top;
        }

        .locations-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }

        .locations-table .header-cell {
            padding: 5px 8px;
            font-weight: bold;
            text-align: start;
            font-size: 8pt;
            text-decoration: underline
        }

        .locations-table td {
            padding: 3px 8px;
            font-size: 8pt;
            height: 10px;
            vertical-align: middle;
            background-color: white;
        }

        /* Main table */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .main-table thead th {
            background-color: #ffffff;
            border: 2px solid #000;
            padding: 7px 5px;
            font-size: 8pt;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            line-height: 1.0;
        }

        .main-table tbody td {
            border: 2px solid #000;
            padding: 5px 5px;
            font-size: 8pt;
            text-align: center;
            vertical-align: middle;
            height: 10px;
        }

        .main-table tbody td.product-desc {
            padding-left: 10px;
            font-size: 10px;
            text-transform: uppercase
        }

        .main-table tbody td.amount {
            text-align: right;
            padding-right: 10px;
            font-size: 10px;
        }

        .main-table tbody td.date-cell {
            font-size: 10px;
        }

        .empty-row td {
            height: 26px;
        }

        /* Footer section */
        /* ----- Bottom split row (table-based, DOMPDF friendly) ----- */
        .bottom-split {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            page-break-inside: avoid;
        }

        .bottom-split td {
            vertical-align: top;
            padding: 0;
        }

        .bottom-left {
            width: 75%;
            padding-right: 12px;
        }

        /* tweak % as needed */
        .bottom-right {
            width: 25%;
        }

        /* Payment + remark (left column) */
        .payment-section {
            margin: 0 0 10px;
            font-size: 8pt;
        }

        .payment-label {
            font-weight: bold;
            display: inline-block;
        }

        .payment-options {
            display: inline-block;
            margin-left: 8px;
            font-size: 8pt;
            text-transform: uppercase
        }

        .remark-table {
            width: 100%;
            border-collapse: collapse;
            padding: 8px 0;
        }

        .remark-table .remark-label {
            width: 140px;
            font-weight: bold;
            font-size: 8pt;
            white-space: nowrap;
            text-align: right;
        }

        .remark-table .remark-line {
            border-bottom: 1px solid #000;
            height: 14px;
        }

        /* Supporting docs box (right column) */
        .supporting-docs {
            background: #fffc04;
            margin: 0;
            font-size: 8pt;
            page-break-inside: avoid;
            width: 100%;
        }

        .supporting-docs-title {
            font-weight: bold;
            margin-bottom: 6px;
            font-size: 10px;
        }

        .doc-list {
            margin-left: 0;
            font-size: 10px;
            line-height: 1.0;
        }

        .doc-item {
            margin-bottom: 3px;
            padding-left: 5px;
        }

        /* Total invoice */
        .total-section {
            text-align: right;
            margin: 20px 0;
            padding-right: 30px;
            border: 1px solid #000;
        }

        .total-label {
            font-weight: bold;
            font-size: 11px;
            text-align: right
        }

        .total-value {
            font-weight: bold;
            font-size: 11px;
            text-align: right;
        }

        /* Print optimization */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .container {
                page-break-after: avoid;
            }

            .supporting-docs {
                background-color: #fffc04 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section with Logo and Title -->
        <div class="header">
            <!-- Left: Logo -->
            <div class="logo-section">
                <div class="logo">
                    <img src="assets/images/logo/abbott-logo-v2.jpg" alt="Abbott Logo">
                </div>
                {{-- <div class="company-name">Abbott</div> --}}
            </div>

            <!-- Center: Title and Division -->
            <div class="title-section">
                <div class="form-title">Inventory Consumption Form</div>
                <div class="division">
                    <span class="division-label">Division :</span>
                    <span class="division-box">CRM</span> 
                </div>
            </div>

            <!-- Right: Empty for balance -->
            <div class="empty-section"></div>
        </div>

        <!-- Combined Patient Info and Stock Locations Section -->
        <div class="info-locations-wrapper">
            <!-- Left: Patient Information -->
            <div class="info-section">
                <div class="info-row">
                    <span class="info-label">*Bill to :</span>
                    <span class="info-value">{{ $data['implant_pt_name'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">*Ship to :</span>
                    <span class="info-value">{{ $data['hospital_name'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">*Patient Name :</span>
                    <span class="info-value">{{ $data['implant_pt_name'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">*Patient I/C :</span>
                    <span class="info-value">{{ $data['implant_pt_icno'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">*Patient MRN :</span>
                    <span class="info-value">{{ $data['implant_pt_mrn'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">*Address :</span>
                    <span class="info-value">{{ $data['implant_pt_address'] }}</span>
                </div>
            </div>

            @php
                // only active + limit to 16
                $active = $stocklocations->where('stock_location_status', 1)->values()->take(16);
                $cols = $active->chunk(8); // 8 per column
                $colspan = max(1, $cols->count());
            @endphp

            <div class="locations-section">
                <table class="locations-table">
                    <tr>
                        <td colspan="{{ $colspan }}" class="header-cell">
                            <span style="font-weight:bold;color:red;">**</span>Stock Locations
                        </td>
                    </tr>
                    <tr>
                        @forelse ($cols as $ci => $col)
                            <td>
                                <ol class="stock-col-ol" start="{{ $ci * 8 + 1 }}">
                                    @foreach ($col as $sl)
                                        <li><strong>{{ $sl->stock_location_code }}</strong> =
                                            {{ $sl->stock_location_name }}</li>
                                    @endforeach
                                </ol>
                            </td>
                        @empty
                            <td>&nbsp;</td>
                        @endforelse
                    </tr>
                </table>
            </div>
        </div>

        <!-- Main Products Table -->
        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 12%;">Implant Date</th>
                    <th style="width: 11%;">Model No.</th>
                    <th style="width: 14%;">Serial / Batch No.</th>
                    <th style="width: 10%;">**Stk Location</th>
                    <th style="width: 33%;">Product Description</th>
                    <th style="width: 8%;">Qty</th>
                    <th style="width: 12%;">Amount (MYR)</th>
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
                    <td class="product-desc">{{ $data['generator_name'] }}</td>
                    <td>{{ $data['implant_generator_qty'] }}</td>
                    <td class="amount">
                        {{ $data['implant_generator_qty'] * $data['implant_generator_itemPrice'] == 0 ? '' : number_format($data['implant_generator_qty'] * $data['implant_generator_itemPrice'], 2) }}
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
                            <td class="product-desc">{{ $item['model_name'] }}</td>
                            <td>{{ $item['implant_model_qty'] }}</td>
                            <td class="amount">
                                {{ $item['implant_model_qty'] * $item['implant_model_itemPrice'] == 0 ? '' : number_format($item['implant_model_qty'] * $item['implant_model_itemPrice'], 2) }}
                            </td>
                        </tr>
                    @endif
                @endforeach

                <tr>
                    <td colspan="6" style="text-align: right; font-weight: bold;">
                        *Total Invoice:
                    </td>
                    <td class="amount">
                        {{ number_format($total, 2) }}
                    </td>
                </tr>


            </tbody>
        </table>

        <!-- One-row, two-column layout -->
        <table class="bottom-split">
            <tr>
                <!-- LEFT: Payment & Remark -->
                <td class="bottom-left">
                    {{-- <div class="payment-section">
                        <span class="payment-label">*Payment Method :</span>
                        
                    </div> --}}

                     <table class="remark-table">
                        <tr>
                            <td class="remark-label">*Payment Method :</td>
                            <td class="remark-line"><span class="payment-options">{{ $data['implant_approval_type'] }} (MYR {{ number_format($total, 2) }})</span></td>
                        </tr>
                    </table>

                    <table class="remark-table">
                        <tr>
                            <td class="remark-label">Remark from Sales :</td>
                            <td class="remark-line">&nbsp;</td>
                        </tr>
                    </table>
                </td>

                <!-- RIGHT: Supporting documents -->
                <td class="bottom-right">
                    <div class="supporting-docs">
                        <div class="supporting-docs-title">**Supporting documents:</div>
                        <div class="doc-list">
                            <div class="doc-item">1. Delivery Order (with Stamp and Signature)</div>
                            <div class="doc-item">2. Implant Registration Form (IRF)</div>
                            <div class="doc-item">3. Welfare Approval Letter / GL (if available)</div>
                            <div class="doc-item">4. Purchase Order (if available)</div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
