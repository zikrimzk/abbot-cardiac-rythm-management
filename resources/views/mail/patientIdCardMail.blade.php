<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patient ID Card Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #ddd;
        }

        .header {
            color: #ffffff;
            padding: 20px 20px 10px 20px;
        }

        .header h2 {
            color: #333;
            margin: 0;
        }

        .content {
            padding: 20px;
            font-size: 14px;
            line-height: 1.6;
        }

        .details {
            margin-top: 20px;
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #0a1734;
            border-radius: 4px;
        }

        .details p {
            margin: 6px 0;
            color: #555;
        }

        .action-btn {
            text-align: center;
            margin-top: 20px;
        }

        .action-btn a {
            display: inline-block;
            padding: 12px 20px;
            background-color: #0a1734;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 12px;
        }

        .action-btn a:hover {
            background-color: #8ba1ce;
        }

        .footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #6c757d;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>Notification: Your Digital Patient ID Card is Ready !</h2>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Dear <strong>{{ $data['patient_name'] }}</strong>,</p>
            <p>We are pleased to inform you that your Digital Patient ID Card has been successfully generated and is now
                available for download.</p>
            <p>You can download your card by clicking the button below:</p>

            <div class="action-btn">
                <a href="{{ route('guest-view-patient-id-card-page', ['id' => Crypt::encrypt($data['implant_id']),'opt'=> $data['opt'],'type'=> 2]) }}">DOWNLOAD PATIENT ID CARD</a>
            </div>

            <p>If you encounter any issues or require further assistance, please do not hesitate to contact our support
                team.</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Cardiac Rhythm Management Division. All rights reserved.</p>
            <p>Need help? <a href="mailto:support@abbot.com">Contact Support</a></p>
        </div>
    </div>
</body>

</html>
