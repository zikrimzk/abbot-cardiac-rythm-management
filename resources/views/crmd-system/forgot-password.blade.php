<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <!-- Favicon -->
    <link rel="icon" href="../assets/images/logo-test-white.png" type="image/x-icon" />

    <!-- Fonts -->
    <link rel="stylesheet" href="../assets/fonts/inter/inter.css" id="main-font-link" />
    <link rel="stylesheet" href="../assets/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="../assets/fonts/feather.css" />
    <link rel="stylesheet" href="../assets/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../assets/fonts/material.css" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/style-preset.css" />
    <link rel="stylesheet" href="../assets/css/landing.css" />

    <style>
        /* Medical-themed customizations */
        .medical-login {
            --medical-blue: #1a6edb;
            --medical-blue-light: #e8f4ff;
            --medical-blue-dark: #1557b0;
            --medical-green: #28a745;
            --medical-gray: #f8f9fa;
            --medical-text: #2c3e50;
        }

        .medical-login body.landing-page {
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f7ff 100%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .medical-login .auth-main {
            width: 100%;
        }

        .medical-login .auth-wrapper.v1 {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }

        .medical-login .auth-form {
            position: relative;
        }

        .medical-login .auth-form::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--medical-blue), var(--medical-green));
            border-radius: 4px 4px 0 0;
        }

        .medical-login .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* .medical-login .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 123, 255, 0.2);
        } */

        .medical-login .card-body {
            padding: 2rem;
        }

        .medical-login h3 {
            color: var(--medical-blue);
            font-weight: 600;
            margin-bottom: 1.5rem !important;
            position: relative;
            display: inline-block;
            padding-bottom: 0.5rem;
        }

        .medical-login h3::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: var(--medical-blue);
            border-radius: 2px;
        }

        .medical-login .text-muted {
            color: #6c757d !important;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
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
            padding: 0.75rem 1.5rem;
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

        .medical-login .alert {
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .medical-login .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            border-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .medical-login .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            border-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }

        .medical-login .alert-heading {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .medical-login .logo-container {
            margin-bottom: 2rem;
            position: relative;
        }

        .medical-login .logo-container::after {
            content: "";
            display: block;
            width: 60px;
            height: 4px;
            background: var(--medical-blue);
            margin: 1rem auto 0;
            border-radius: 2px;
        }

        .medical-login .medical-icon {
            position: absolute;
            right: 30px;
            top: 20px;
            color: var(--medical-blue);
            opacity: 0.1;
            font-size: 5rem;
            z-index: 0;
            pointer-events: none;
        }

        .medical-login .show-password {
            top: 50%;
            transform: translateY(-50%);
            right: 12px;
            background: transparent;
            border: none;
            color: #6c757d;
            z-index: 5;
        }

        @media (max-width: 575.98px) {
            .medical-login .auth-wrapper.v1 {
                padding: 15px;
            }

            .medical-login .card-body {
                padding: 1.5rem;
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
                    <i class="fas fa-heartbeat medical-icon"></i>
                </div>

                <div class="d-flex mt-3 mb-3 justify-content-start align-items-center">
                    <h6 class="f-w-400 mb-0">
                        <a href="{{ route('login-page') }}" class="link-primary">
                            <i class="ti ti-arrow-left me-2"></i>
                            Go Back to Login
                        </a>
                    </h6>
                </div>

                <div class="card shadow-lg">
                    <form action="{{ route('send-email-password-post') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h3>Reset Password</h3>
                                <div class="text-muted">Please enter your email address to request a password reset.
                                </div>
                            </div>

                            <!-- Start Alert -->
                            <div>
                                @if (session()->has('success'))
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="alert-heading">
                                                <i class="fas fa-check-circle"></i>
                                                Success
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        <p class="mb-0">{{ session('success') }}</p>
                                    </div>
                                @endif
                                @if (session()->has('error'))
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="alert-heading">
                                                <i class="fas fa-info-circle"></i>
                                                Error
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        <p class="mb-0">{{ session('error') }}</p>
                                    </div>
                                @endif
                            </div>
                            <!-- End Alert -->

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" placeholder="Email"
                                    name="email" value="{{ old('email') }}" autocomplete="off" required />
                                <label for="email">Email Address</label>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Request Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Js -->
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
