<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Inventory Consumption Form</title>
    <style>
        /* Global reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            padding: 20px;
            color: #333;
        }

        /* Landscape container */
        .container {
            width: 297mm;
            min-height: 210mm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
            padding: 20mm;
            position: relative;
        }

        /* Watermark background */
        .watermark {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" viewBox="0 0 400 400"><text x="50%" y="50%" font-family="Arial" font-size="40" fill="rgba(0,100,200,0.05)" text-anchor="middle" dominant-baseline="middle" transform="rotate(-45, 200, 200)">CONFIDENTIAL - INVENTORY FORM</text></svg>');
            background-repeat: repeat;
            opacity: 0.3;
            z-index: -1;
        }

        /* Header section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 2px solid #2c6eb5;
            margin-bottom: 25px;
        }

        .logo-area {
            width: 150px;
            height: 80px;
            background: #f0f8ff;
            border: 1px dashed #2c6eb5;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2c6eb5;
            font-weight: 500;
        }

        .title-area {
            text-align: center;
        }

        .title-area h1 {
            font-size: 24px;
            color: #1a3c6e;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .title-area .subtitle {
            font-size: 18px;
            color: #2c6eb5;
            font-weight: 600;
        }

        .form-meta {
            text-align: right;
            font-size: 12px;
            color: #666;
        }

        /* Patient Information Section */
        .patient-info {
            width: 100%;
            margin: 25px 0;
            border-collapse: collapse;
        }

        .patient-info td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            vertical-align: top;
        }

        .info-label {
            background-color: #e9f0f8;
            font-weight: 600;
            width: 15%;
            color: #1a3c6e;
        }

        /* Stock Location Section */
        .stock-section {
            background: #f8fbff;
            border: 1px solid #cde;
            border-radius: 4px;
            padding: 12px 15px;
            margin: 20px 0;
        }

        .section-title {
            color: #1a3c6e;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #cde;
        }

        .location-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            font-size: 14px;
        }

        .location-item {
            display: flex;
        }

        .location-code {
            font-weight: 700;
            width: 40px;
            color: #2c6eb5;
        }

        /* Products Table */
        .products-section {
            margin: 30px 0;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-top: 10px;
        }

        .products-table th {
            background-color: #1a3c6e;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
        }

        .products-table td {
            padding: 10px 8px;
            border: 1px solid #ddd;
        }

        .products-table tr:nth-child(even) {
            background-color: #f8fbff;
        }

        .products-table tr:hover {
            background-color: #edf5ff;
        }

        /* Payment Section */
        .payment-section {
            margin: 25px 0;
            padding: 15px;
            background: #f0f8ff;
            border-left: 4px solid #2c6eb5;
        }

        .payment-method {
            font-weight: 600;
            color: #1a3c6e;
            margin-bottom: 5px;
        }

        .payment-note {
            font-size: 12px;
            color: #666;
            font-style: italic;
            margin-bottom: 10px;
        }

        .total-invoice {
            font-size: 16px;
            font-weight: 700;
            color: #1a3c6e;
        }

        /* Documents Section */
        .documents-section {
            margin: 25px 0;
            padding: 15px;
            background: #f8fafd;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .documents-section ol {
            padding-left: 25px;
        }

        .documents-section li {
            margin-bottom: 8px;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }

        .form-version {
            font-style: italic;
            text-align: right;
        }

        /* Signature area */
        .signature-area {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
            padding-top: 50px;
            text-align: center;
            border-top: 1px solid #ccc;
            font-size: 14px;
            color: #555;
        }

        /* Print-specific styles */
        @media print {
            body {
                padding: 0;
                background: none;
            }

            .container {
                box-shadow: none;
                margin: 0;
                padding: 15mm;
                width: 100%;
                min-height: 100%;
            }

            .no-print {
                display: none;
            }

            /* Landscape orientation for printing */
            @page {
                size: landscape;
                margin: 10mm;
            }
        }

        /* Print button styling */
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #1a3c6e;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .print-btn:hover {
            background: #2c6eb5;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <button class="print-btn no-print" onclick="window.print()">Generate PDF</button>

    <div class="container">
        <div class="watermark"></div>

        <!-- Header with logo area -->
        <div class="header">
            <div class="logo-area">COMPANY LOGO</div>
            <div class="title-area">
                <h1>INVENTORY CONSUMPTION FORM</h1>
                <div class="subtitle">Abbott Medical Devices</div>
            </div>
            <div class="form-meta">
                Form ID: IC-2025-5306<br>
                Date: 28-Jan-2025
            </div>
        </div>

        <!-- Patient Information -->
        <table class="patient-info">
            <tr>
                <td class="info-label">Bill to :</td>
                <td>NAGAMAL A/P ARAPTTIASAM</td>
                <td class="info-label">Ship to :</td>
                <td>HOSPITAL SULTAN IDRIS SHAH SERDANG</td>
            </tr>
            <tr>
                <td class="info-label">Patient Name :</td>
                <td>NAGAMAL A/P ARAPTTIASAM</td>
                <td class="info-label">Patient HC :</td>
                <td>530714-04-5306</td>
            </tr>
            <tr>
                <td class="info-label">Patient MRN :</td>
                <td>S001372783</td>
                <td class="info-label">Address :</td>
                <td>NO 67, KERONGSANG 10, BANDAR PUTERI, KLANG, 41200 SELANGOR</td>
            </tr>
        </table>

        <!-- Stock Location -->
        <div class="stock-section">
            <div class="section-title">Stock Location Codes</div>
            <div class="location-grid">
                <div class="location-item"><span class="location-code">HC</span> = Hospital Consignment</div>
                <div class="location-item"><span class="location-code">MC</span> = Michael Chuah (Penang)</div>
                <div class="location-item"><span class="location-code">AC</span> = Alan Chee (Sabah)</div>
                <div class="location-item"><span class="location-code">ZA</span> = Zulkhairi Ayop (Johor)</div>
                <div class="location-item"><span class="location-code">KL</span> = Kyle Lee (Central)</div>
                <div class="location-item"><span class="location-code">IDH</span> = Indahaus Resources (Sarawak)</div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="products-section">
            <div class="section-title">Implanted Products</div>
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Implant Date</th>
                        <th>Model No.</th>
                        <th>Serial / Batch No.</th>
                        <th>Stk Loc</th>
                        <th>Product Description</th>
                        <th>Qty</th>
                        <th>Unit Price (MYR)</th>
                        <th>Amount (MYR)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>28-Jan-25</td>
                        <td>PM1172</td>
                        <td>8838983</td>
                        <td>KL</td>
                        <td>ENDURITY MRI</td>
                        <td>1</td>
                        <td>7,000.00</td>
                        <td>7,000.00</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>2088TC/68</td>
                        <td>EEM190133</td>
                        <td>KL</td>
                        <td>TENDRIL STS 86CM</td>
                        <td>1</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>4051L</td>
                        <td>2411011</td>
                        <td>KL</td>
                        <td>DISPOSABLE SURGICAL CABLE</td>
                        <td>1</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>DSN028-59</td>
                        <td>8323158</td>
                        <td>KL</td>
                        <td>CPS AIM UNIVERSAL SUBO8146</td>
                        <td>2</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" style="text-align: right; font-weight: 600;">TOTAL:</td>
                        <td>7,000.00</td>
                        <td>7,000.00</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Payment Section -->
        <div class="payment-section">
            <div class="payment-method">Payment Method : Patient Self-Paid (RM7,000)</div>
            <div class="payment-note">*(Patient self-paid / Welfare Approval / Hospital / Burm Agent)</div>
            <div class="total-invoice">Total Invoice: 7,000.00 MYR</div>
        </div>

        <!-- Documents Section -->
        <div class="documents-section">
            <div class="section-title">Required Supporting Documents:</div>
            <ol>
                <li>Delivery Order (with Stamp and Signature)</li>
                <li>Implant Registration Form (IRF)</li>
                <li>Welfare Approval Letter / GL (if applicable)</li>
                <li>Purchase Order (if applicable)</li>
                <li>Patient Consent Form</li>
            </ol>
        </div>

        <!-- Signature Area -->
        <div class="signature-area">
            <div class="signature-box">
                Prepared by<br>(Sales Representative)
            </div>
            <div class="signature-box">
                Approved by<br>(Hospital Inventory Manager)
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div><strong>Remark from Sales:</strong> All products delivered and implanted as per schedule</div>
            <div class="form-version">Inventory Consumption Form_Ver4.0_23Apr2024</div>
        </div>
    </div>

    <script>
        // Automatically set today's date in form meta
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const formattedDate = today.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            }).replace(/ /g, '-');

            document.querySelector('.form-meta').innerHTML =
                `Form ID: IC-${today.getFullYear()}-${Math.floor(Math.random()*9000)+1000}<br>Date: ${formattedDate}`;
        });
    </script>
</body>

</html>
