<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Notification</title>
    <style>
        /* General Styles */
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

        h2 {
            color: #333;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .header {
            /* background-color: #0a1734; */
            color: #ffffff;
            /* text-align: center; */
            padding: 20px 20px 10px 20px;
        }

        .header h2 {
            /* font-size: 22px; */
            margin: 0;
            /* font-weight: bold; */
            /* letter-spacing: 1px; */
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

        .password-box {
            text-align: center;
        }

        .password {
            font-size: 16px;
            font-weight: bold;
            font-family: "Courier New", monospace;
            background: #f8f9fa;
            padding: 8px 12px;
            display: inline-block;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-top: 10px;
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
            <h2>Welcome to Cardiac Rhythm Management Division System</h2>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Dear <strong>{{ $data['name'] }}</strong>,</p>
            <p>Your account has been successfully registered by the system administrator. Below is your temporary
                password:</p>
            <div class="password-box">
                <p class="password">{{ $data['password'] }}</p>
            </div>
            <p>Please log in and change your password immediately for security reasons.</p>

            <div class="action-btn">
                <a href="{{ route('login-page') }}">LOGIN TO YOUR ACCOUNT</a>
            </div>

        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Cardiac Rythm Management Division. All rights reserved.</p>
            <p>Need help? <a href="mailto:support@abbot.com">Contact Support</a></p>
        </div>
    </div>
</body>

</html>
