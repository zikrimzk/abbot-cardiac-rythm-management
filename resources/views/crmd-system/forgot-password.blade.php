<!DOCTYPE html>
<html lang="en">

<head>
    <title>CRM Division System | Reset Password</title>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <meta name="description" content="Abbott - Cardiac Rythm Management Division System" />
    <meta name="keywords" content="abbott, crmd, cardiac, rythm, management, division, system" />
    <meta name="author" content="Muhammad Zikri Kashim | Zeeke Software Solution" />

    <link rel="icon" href="../assets/images/logo-test-white.png" type="image/x-icon" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com/">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --color-primary: #1a6edb;
            --color-primary-dark: #1557b0;
            --color-primary-light: #e8f4ff;
            --color-secondary: #6c757d;
            --color-success: #198754;
            --color-success-light: #d1e7dd;
            --color-danger: #dc3545;
            --color-danger-light: #f8d7da;
            --color-white: #ffffff;
            --color-light-gray: #f8f9fa;
            --color-medium-gray: #e9ecef;
            --color-dark-gray: #2c3e50;
            --shadow-md: 0 4px 12px rgba(26, 110, 219, 0.15);
            --shadow-lg: 0 10px 30px rgba(74, 74, 74, 0.2);
        }

        /* Basic Reset & Typography */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--color-dark-gray);
            background-color: var(--color-light-gray);
            background-attachment: fixed;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 2rem 1rem;
            line-height: 1.6;
        }

        /* Login Card & Layout */
        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: var(--color-white);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            text-align: center;
            position: relative;
            animation: slideUpFadeIn 0.6s ease-out forwards;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 6px;
            width: 100%;
            background: linear-gradient(90deg, #1a6edb, #28a745);
            z-index: 1;
        }

        /* Header */
        .login-header {
            padding: 2.5rem 2rem 1.5rem;
            border-bottom: 1px solid var(--color-medium-gray);
            position: relative;
        }

        .company-logo {
            margin-bottom: 1rem;
        }

        .company-logo img {
            width: 150px;
            height: auto;
            transition: transform 0.3s ease;
        }

        .company-logo img:hover {
            transform: scale(1.05);
        }

        .system-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--color-dark-gray);
            margin-bottom: 0.25rem;
        }

        .system-subtitle {
            font-size: 0.9rem;
            color: var(--color-secondary);
        }

        /* Login Body (Form) */
        .login-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--color-dark-gray);
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid var(--color-medium-gray);
            border-radius: 8px;
            font-size: 0.9rem;
            background: var(--color-white);
            color: var(--color-dark-gray);
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(26, 110, 219, 0.1);
        }

        .form-control::placeholder {
            color: var(--color-secondary);
        }

        /* Button */
        .login-button {
            width: 100%;
            padding: 0.875rem;
            background: var(--color-primary);
            color: var(--color-white);
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out, transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            letter-spacing: 0.5px;
        }

        .login-button:hover {
            background: var(--color-primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 110, 219, 0.3);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-button:disabled {
            background: var(--color-secondary);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Back to login link */
        .back-to-login {
            text-align: center;
            margin-top: 2rem;
        }

        .back-to-login a {
            color: var(--color-primary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.2s ease-in-out;
        }

        .back-to-login a:hover {
            color: var(--color-primary-dark);
            text-decoration: underline;
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            opacity: 0;
            transform: translateY(-10px);
            animation: slideInFadeIn 0.3s ease-out forwards;
            font-weight: 500;
            text-align: left;
        }

        .alert-icon-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 28px;
            height: 28px;
        }

        .alert-icon-wrapper .icon {
            width: 1.5em;
            height: 1.5em;
        }

        .alert-success {
            background-color: #d1e7dd;
            color: var(--color-success);
            border: 1px solid #badbcc;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: var(--color-danger);
            border: 1px solid #f5c2c7;
        }

        .alert-close {
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            font-size: 1.2rem;
            margin-left: auto;
            opacity: 0.7;
            transition: opacity 0.2s ease-in-out;
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* Footer */
        .footer-info {
            background: var(--color-light-gray);
            border-top: 1px solid var(--color-medium-gray);
            padding: 1.5rem 2rem;
            font-size: 0.8rem;
            color: var(--color-secondary);
            line-height: 1.5;
        }

        .footer-info a {
            color: var(--color-primary);
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-top: 0.25rem;
            transition: color 0.2s ease-in-out;
        }

        .footer-info a:hover {
            text-decoration: underline;
            color: var(--color-primary-dark);
        }

        /* Loading State */
        .loading .login-button {
            background: var(--color-secondary);
            cursor: not-allowed;
            position: relative;
            pointer-events: none;
            transform: none !important;
            color: transparent;
        }

        .loading .login-button::after {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%) rotate(0deg);
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid transparent;
            border-top: 2px solid var(--color-white);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        /* Animations */
        @keyframes slideUpFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            body {
                padding: 1.5rem;
                background: var(--color-white);
            }

            .login-card {
                box-shadow: none;
                width: 100%;
            }

            .login-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                height: 6px;
                width: 100%;
                background: linear-gradient(90deg, #ffffff, #ffffff);
                z-index: 1;
            }

            .login-container {
                padding: 0;
            }

            .login-header,
            .login-body,
            .footer-info {
                padding: 1.5rem 1.25rem;
            }

            .company-logo img {
                width: 130px;
            }

            .system-title {
                font-size: 1.2rem;
            }

            .system-subtitle {
                font-size: 0.8rem;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .login-button {
                font-size: 0.95rem;
                padding: 0.75rem;
            }

            .footer-info {
                font-size: 0.75rem;
                background-color: var(--color-white);
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <header class="login-header">
                <div class="company-logo">
                    <img src="../assets/images/logo/abbott-logo.png" alt="Abbott Logo" />
                </div>
                <h1 class="system-title">Reset Password</h1>
                <p class="system-subtitle">Enter your email to receive a temporary password</p>
            </header>

            <main class="login-body">
                <div id="alert-container">
                    @if (session()->has('success'))
                        <div class="alert alert-success" id="success-alert">
                            <span class="alert-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l5 5l10 -10"></path>
                                </svg>
                            </span>
                            <span id="success-message">{{ session('success') }}</span>
                            <button type="button" class="alert-close" onclick="closeAlert('success-alert')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M18 6l-12 12"></path>
                                    <path d="M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger" id="error-alert">
                            <span class="alert-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 9v4"></path>
                                    <path
                                        d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.875h16.214a1.914 1.914 0 0 0 1.636 -2.875l-8.106 -13.534a1.914 1.914 0 0 0 -3.274 0z">
                                    </path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                            </span>
                            <span id="error-message">{{ session('error') }}</span>
                            <button type="button" class="alert-close" onclick="closeAlert('error-alert')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M18 6l-12 12"></path>
                                    <path d="M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>

                <form id="reset-form" action="{{ route('send-email-password-post') }}" method="POST"
                    autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter your email address" value="{{ old('email') }}" required
                            autocomplete="off" />
                    </div>

                    <button type="submit" class="login-button" id="reset-btn">
                        Send Reset Password
                    </button>

                    <div class="back-to-login">
                        <a href="{{ route('login-page') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="20" height="20"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l14 0"></path>
                                <path d="M5 12l6 6"></path>
                                <path d="M5 12l6 -6"></path>
                            </svg>
                            Back to Login
                        </a>
                    </div>
                </form>
            </main>

            <footer class="footer-info">
                <p>
                    <strong>Cardiac Rhythm Management Division</strong><br>
                    For technical support, contact <a href="mailto:crmd-system@appnest.my">crmd-system@appnest.my</a>
                </p>
            </footer>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const resetForm = document.getElementById('reset-form');
            const resetBtn = document.getElementById('reset-btn');

            // Form submission loading state
            if (resetForm) {
                resetForm.addEventListener('submit', function(e) {
                    if (resetBtn) {
                        resetBtn.classList.add('loading');
                        resetBtn.disabled = true;
                    }
                });
            }

            // Auto-focus on email field
            const emailField = document.getElementById('email');
            if (emailField && !emailField.value) {
                emailField.focus();
            }

            // Alert close functionality
            window.closeAlert = function(alertId) {
                const alertElement = document.getElementById(alertId);
                if (alertElement) {
                    alertElement.style.animation = 'none';
                    alertElement.style.opacity = '0';
                    alertElement.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        alertElement.style.display = 'none';
                    }, 300);
                }
            };

            // Auto-close alerts after 5 seconds
            const successAlert = document.getElementById('success-alert');
            const errorAlert = document.getElementById('error-alert');

            if (successAlert) {
                setTimeout(() => closeAlert('success-alert'), 5000);
            }
            if (errorAlert) {
                setTimeout(() => closeAlert('error-alert'), 5000);
            }
        });

        // Prevent zoom on mobile
        document.addEventListener('gesturestart', function(e) {
            e.preventDefault();
        });

        // Prevent double-tap zoom
        let lastTouchEnd = 0;
        document.addEventListener('touchend', function(event) {
            let now = new Date().getTime();
            if (now - lastTouchEnd <= 300) {
                event.preventDefault();
            }
            lastTouchEnd = now;
        }, false);
    </script>
</body>

</html>
