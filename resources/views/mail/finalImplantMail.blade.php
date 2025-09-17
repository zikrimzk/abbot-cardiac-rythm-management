<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['email_subject'] }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            color: #2d2d2d;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .container {
            max-width: 650px;
            margin: 40px auto;
            background-color: #ffffff;
            border: 1px solid #e1e4e8;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
            padding: 40px;
            box-sizing: border-box;
        }

        .header {
            border-bottom: 3px solid #000000;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .header h1 {
            color: #000000;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .content {
            font-size: 16px;
            color: #2d2d2d;
            margin-bottom: 25px;
        }

        .content p {
            margin: 0 0 16px 0;
        }
        
        .details-section {
            margin: 25px 0;
            border: 1px solid #e1e4e8;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .details-section h3 {
            background-color: #f0f4f8;
            color: #000000;
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            padding: 15px 20px;
            border-bottom: 1px solid #e1e4e8;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        .details-table td {
            padding: 12px 20px;
            border-bottom: 1px solid #e1e4e8;
            color: #555555;
        }
        
        .details-table tr:last-child td {
            border-bottom: none;
        }

        .details-table td:first-child {
            font-weight: 600;
            color: #333333;
            width: 170px;
            background-color: #fafbfd;
        }
        
        .signature {
            margin-top: 35px;
            font-size: 16px;
            color: #2d2d2d;
        }

        .signature p {
            margin: 2px 0;
        }
        
        .action-btn {
            text-align: center;
            margin: 40px 0 20px 0;
        }

        .action-btn a {
            display: inline-block;
            padding: 14px 32px;
            background-color: #0a1734;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: 0.5px;
            transition: background-color 0.3s ease;
        }

        .action-btn a:hover {
            background-color: #1a2b52;
        }

        .footer {
            margin-top: 35px;
            text-align: center;
            font-size: 13px;
            color: #888888;
            border-top: 1px solid #e1e4e8;
            padding-top: 18px;
            line-height: 1.5;
        }

        .footer a {
            color: #000000;
            text-decoration: none;
            font-weight: 500;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ $data['email_subject'] }}</h1>
        </div>

        <div class="content">
            <p>{!! $data['email_message_1'] !!}</p>

            <div class="details-section">
                <h3>Implant Details</h3>
                <table class="details-table">
                    <tr>
                        <td>Implant Hospital:</td>
                        <td>{{ $data['implant_hospital'] }}</td>
                    </tr>
                    <tr>
                        <td>Implant Date:</td>
                        <td>{{ $data['implant_date'] }}</td>
                    </tr>
                    <tr>
                        <td>Patient Name:</td>
                        <td>{{ $data['implant_pt_name'] }}</td>
                    </tr>
                    <tr>
                        <td>Patient IC:</td>
                        <td>{{ $data['implant_pt_icno'] }}</td>
                    </tr>
                    <tr>
                        <td>Approval Type:</td>
                        <td>{{ $data['implant_approval_type'] }}</td>
                    </tr>
                    <tr>
                        <td>Billing Type (B/R5):</td>
                        <td>{{ $data['implant_billing_type'] }}</td>
                    </tr>
                </table>
            </div>

            <p>{!! $data['email_message_2'] !!}</p>
        </div>
        
        <div class="signature">
            <p>Regards,</p>
            <p><strong>{{ auth()->user()->staff_name }}</strong></p>
        </div>

        <div class="action-btn">
            <a href="{{ $data['download_link'] }}">DOWNLOAD PATIENT IMPLANT</a>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Cardiac Rhythm Management Division. All rights reserved.</p>
            <p>Need help? <a href="mailto:noreply@appnest.my">Contact Support</a></p>
        </div>
    </div>
</body>
</html>