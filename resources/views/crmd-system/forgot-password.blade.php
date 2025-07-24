<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <link rel="icon" href="../assets/images/logo-test-white.png" type="image/x-icon" />

    <link rel="stylesheet" href="../assets/fonts/inter/inter.css" id="main-font-link" />
    <link rel="stylesheet" href="../assets/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="../assets/fonts/feather.css" />
    <link rel="stylesheet" href="../assets/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../assets/fonts/material.css" />

    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/style-preset.css" />
    <link rel="stylesheet" href="../assets/css/landing.css" />

    <style>
        /* Medical-themed customizations */
        :root {
            --medical-blue: #1a6edb;
            --medical-blue-light: #e8f4ff;
            --medical-blue-dark: #1557b0;
            --medical-green: #198754;
            --medical-green-light: #d1e7dd;
            --medical-red: #dc3545;
            --medical-red-light: #f8d7da;
            --medical-red-dark: #58151c;
            --medical-gray: #f8f9fa;
            --medical-text: #2c3e50;
        }

        .medical-login body.landing-page {
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f7ff 100%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .medical-login .auth-main {
            width: 100%;
        }

        .medical-login .auth-wrapper.v1 {
            max-width: 500px;
            margin: 0 auto;
        }

        .medical-login .auth-form {
            position: relative;
        }

        /* Gradient top bar */
        .medical-login .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .medical-login .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 6px;
            width: 100%;
            background: linear-gradient(90deg, var(--medical-blue), var(--medical-green));
            z-index: 1;
        }

        .medical-login .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 123, 255, 0.18);
        }

        .medical-login .card-body {
            padding: 2.5rem;
        }

        .medical-login h3 {
            color: var(--medical-text);
            font-weight: 700;
            margin-bottom: 0.5rem !important;
        }

        .medical-login .text-muted {
            color: #6c757d !important;
            font-size: 1rem;
            margin-bottom: 2rem;
            display: block;
        }

        .medical-login .form-floating {
            margin-bottom: 1.5rem;
        }

        .medical-login .form-control {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1rem 1.25rem;
            height: auto;
            transition: all 0.3s;
        }

        .medical-login .form-control:focus {
            border-color: var(--medical-blue);
            box-shadow: 0 0 0 0.2rem rgba(26, 110, 219, 0.25);
        }

        .medical-login .btn-lg {
            padding: 0.85rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            background: var(--medical-blue);
            border: none;
        }

        .medical-login .btn-lg:hover {
            background: var(--medical-blue-dark);
            transform: translateY(-2px);
        }

        .medical-login .link-primary {
            color: var(--medical-blue);
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s;
        }

        .medical-login .link-primary:hover {
            color: var(--medical-blue-dark);
            text-decoration: underline;
        }

        /* Refined Alert Styles */
        .medical-login .alert {
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            border: 1px solid transparent;
            border-left-width: 5px;
            font-weight: 500;
        }

        .medical-login .alert .btn-close {
            padding: 1rem;
            display: none;
        }

        .medical-login .alert-success {
            background-color: var(--medical-green-light);
            border-color: var(--medical-green);
            color: var(--medical-green);
        }

        .medical-login .alert-danger {
            background-color: var(--medical-red-light);
            border-color: var(--medical-red);
            color: var(--medical-red-dark);
        }

        .medical-login .alert i {
            font-size: 1.2rem;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .medical-login .logo-container {
            margin-bottom: 2rem;
            position: relative;
        }

        .medical-login .medical-icon {
            position: absolute;
            right: 0px;
            top: -10px;
            color: var(--medical-blue);
            opacity: 0.07;
            font-size: 6rem;
            z-index: 0;
            pointer-events: none;
            transform: rotate(-15deg);
        }

        @media (max-width: 575.98px) {
            .medical-login .auth-wrapper.v1 {
                padding: 1rem;
            }

            .medical-login .card-body {
                padding: 2rem 2rem;
                margin-top: 1rem;
                margin-bottom: 1rem
            }

            .medical-login .alert .message {
                font-size: 9pt;
            }
        }
    </style>
</head>

<body class="medical-login" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr"
    data-pc-theme_contrast="" data-pc-theme="light">
    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="text-center logo-container">
                    <a href=""><img src="../assets/images/logo/abbott-logo.png" alt="Abbott Logo"
                            class="img-fluid" width="150" height="100" /></a>
                </div>

                <div class="card shadow-lg">
                    <form action="{{ route('send-email-password-post') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h4>Reset Password</h4>
                                <div class="text-muted"><small>Enter your email to receive a temporary password.</small>
                                </div>
                            </div>

                            @if (session()->has('success'))
                                <div class="alert alert-success d-flex align-items-center alert-dismissible fade show"
                                    role="alert">
                                    <i class="fas fa-check-circle"></i>
                                    <div class="message">
                                        {{ session('success') }}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session()->has('error'))
                                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show"
                                    role="alert">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <div class="message">
                                        {{ session('error') }}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" placeholder="Email"
                                    name="email" value="{{ old('email') }}" autocomplete="off" required />
                                <label for="email">Email Address</label>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Send Reset Link</button>
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('login-page') }}" class="link-primary">
                                    <i class="ti ti-arrow-left me-1"></i>Go Back to Login
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Prevent pinch-to-zoom
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
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/fonts/custom-font.js"></script>
    <script src="../assets/js/pcoded.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>
</body>

</html>
