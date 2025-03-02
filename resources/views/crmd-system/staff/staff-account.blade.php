<!-- [ Extend Layouts ] -->
@php
    use App\Models\Department;
@endphp
@extends('crmd-system.layouts.main')

<!-- [ Main Content ] start -->
@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript: void(0)">My Account</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="javascript: void(0)"
                                        class="text-uppercase">{{ Auth::user()->staff_name }}</a></li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">My Account</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->


            <!-- [ Main Content ] start -->
            <div class="row">

                <!-- [ Alert ] start -->
                <div class="col-sm-12">
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
                <!-- [ Alert ] end -->

                <!-- [ Tab Menu ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body py-0">
                            <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ session('active_tab', 'profile-1') == 'profile-1' ? 'active' : '' }}"
                                        id="profile-tab-1" data-bs-toggle="tab" href="#profile-1" role="tab">
                                        <i class="ti ti-file-text me-2"></i>Account Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ session('active_tab') == 'profile-2' ? 'active' : '' }}"
                                        id="profile-tab-2" data-bs-toggle="tab" href="#profile-2" role="tab">
                                        <i class="ti ti-lock me-2"></i>Change Password
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- [ Tab Menu ] end -->

                <!-- [ Tab Content ] start -->
                <div class="col-sm-12">
                    <div class="tab-content">

                        <!-- [ Account Details ] Tab Start -->
                        <div class="tab-pane fade {{ session('active_tab', 'profile-1') == 'profile-1' ? 'show active' : '' }} "
                            id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                            <form action="{{ route('staff-account-update-post', Auth::user()->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Account Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">

                                                    <!-- Name -->
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label">Name</label>
                                                        <input type="text"
                                                            class="form-control @error('staff_name') is-invalid @enderror"
                                                            name="staff_name" value="{{ Auth::user()->staff_name }}">
                                                        @error('staff_name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Staff ID Number-->
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Staff ID Number</label>
                                                        <input type="text"
                                                            class="form-control @error('staff_idno') is-invalid @enderror"
                                                            name="staff_idno" placeholder="Staff ID Number"
                                                            value="{{ Auth::user()->staff_idno }}">
                                                        @error('staff_idno')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Email -->
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ Auth::user()->email }}" readonly />
                                                    </div>

                                                    <!-- Department -->
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Department</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ Department::find(Auth::user()->department_id)->department_name }}"
                                                            readonly />
                                                    </div>

                                                    <!-- Role -->
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Role</label>
                                                        <input type="text" class="form-control"
                                                            value="@if (Auth::user()->staff_role == 1) Administrator @else Staff @endif"
                                                            readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-end">
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <!-- [ Account Details ] Tab End -->


                        <!-- [ Change Password ] Tab Start -->
                        <div class="tab-pane fade {{ session('active_tab') == 'profile-2' ? 'show active' : '' }}"
                            id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                            <form action="{{ route('staff-password-update-post', Auth::user()->id) }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Change Password</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Current Password</label>
                                                    <div class="input-group mb-3">
                                                        <input type="password"
                                                            class="form-control @error('oldPass') is-invalid @enderror"
                                                            name="oldPass" id="oldpassword" placeholder="Current Password" required />
                                                        <button class="btn btn-light border border-1 border-secondary"
                                                            type="button" id="show-old-password">
                                                            <i id="toggle-icon-old-password" class="ti ti-eye"></i>
                                                        </button>
                                                        @error('oldPass')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">New Password</label>
                                                    <div class="input-group mb-3">
                                                        <input type="password"
                                                            class="form-control @error('newPass') is-invalid @enderror"
                                                            id="passwords" name="newPass" placeholder="New Password" required/>
                                                        <button class="btn btn-light border border-1 border-secondary"
                                                            type="button" id="show-password">
                                                            <i id="toggle-icon-password" class="ti ti-eye"></i>
                                                        </button>
                                                        @error('newPass')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Confirm Password</label>
                                                    <div class="input-group mb-3">
                                                        <input type="password"
                                                            class="form-control @error('cpassword') is-invalid @enderror"
                                                            name="renewPass" id="cpassword" placeholder="Confirm Password" required />
                                                        <button class="btn btn-light border border-1 border-secondary"
                                                            type="button" id="show-password-confirm">
                                                            <i id="toggle-icon-confirm-password" class="ti ti-eye"></i>
                                                        </button>
                                                        @error('cpassword')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <h5>New password must contain:</h5>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item" id="min-char"><i></i> At least
                                                        8
                                                        characters</li>
                                                    <li class="list-group-item" id="lower-char"><i></i> At least
                                                        1
                                                        lower letter (a-z)</li>
                                                    <li class="list-group-item" id="upper-char"><i></i> At least
                                                        1
                                                        uppercase letter(A-Z)</li>
                                                    <li class="list-group-item" id="number-char"><i></i> At least
                                                        1
                                                        number (0-9)</li>
                                                    <li class="list-group-item" id="special-char"><i></i> At least
                                                        1
                                                        special characters</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end btn-page">
                                        <button type="submit" class="btn btn-primary disabled" id="submit-btn">Update
                                            Password</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                        <!-- [ Change Password ] Tab End -->

                    </div>
                </div>
                <!-- [ Tab Content ] start -->

            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>


    <script>
        document.getElementById('passwords').addEventListener('input', function() {
            const password = this.value;
            const submitbtn = document.getElementById('submit-btn');
            const confirmPasswordInput = document.getElementById('cpassword');


            // Regular expressions for each requirement
            const minChar = /.{8,}/;
            const lowerChar = /[a-z]/;
            const upperChar = /[A-Z]/;
            const numberChar = /[0-9]/;
            const specialChar = /[!@#$%^&*(),.?":{}|<>]/;


            // Function to update each requirement's status
            function validateRequirement(regex, elementId) {
                const element = document.getElementById(elementId);
                if (regex.test(password)) {
                    element.classList.remove('ti', 'ti-circle-x', 'text-danger', 'f-16', 'me-2');
                    element.classList.add('ti', 'ti-circle-check', 'text-success', 'f-16', 'me-2');
                } else {
                    element.classList.remove('ti', 'ti-circle-check', 'text-success', 'f-16', 'me-2');
                    element.classList.add('ti', 'ti-circle-x', 'text-danger', 'f-16', 'me-2');
                }
            }

            // Validate each requirement
            validateRequirement(minChar, 'min-char');
            validateRequirement(lowerChar, 'lower-char');
            validateRequirement(upperChar, 'upper-char');
            validateRequirement(numberChar, 'number-char');
            validateRequirement(specialChar, 'special-char');

            // Check if all requirements are met
            const allRequirementsMet = (
                minChar.test(password) &&
                lowerChar.test(password) &&
                upperChar.test(password) &&
                numberChar.test(password) &&
                specialChar.test(password)
            );

            // Only check the confirm password if all new password requirements are met
            if (allRequirementsMet) {
                confirmPasswordInput.disabled = false;
                checkPasswordsMatch();
            } else {
                submitbtn.classList.add('disabled');
                confirmPasswordInput.disabled =
                    true;
            }

            // Function to check if passwords match
            function checkPasswordsMatch() {
                const confirmPassword = confirmPasswordInput.value;
                if (password === confirmPassword) {
                    submitbtn.classList.remove(
                        'disabled');
                } else {
                    submitbtn.classList.add(
                        'disabled');
                }
            }
        });

        // Confirm Password Match Check
        document.getElementById('cpassword').addEventListener('input', function() {
            const newPassword = document.getElementById('passwords').value;
            const confirmPassword = this.value;
            const submitbtn = document.getElementById('submit-btn');

            function checkPasswordsMatch() {
                if (newPassword === confirmPassword) {
                    submitbtn.classList.remove('disabled');
                } else {
                    submitbtn.classList.add('disabled');
                }
            }

            checkPasswordsMatch();
        });

        function showpassword(buttonName, txtName, iconName) {
            document.getElementById(buttonName).addEventListener('click', function() {
                const passwordInput = document.getElementById(txtName);
                const icon = document.getElementById(iconName);

                // Toggle password visibility
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text'; // Change to text to show password
                    icon.classList.remove('ti-eye'); // Remove eye icon
                    icon.classList.add('ti-eye-off'); // Add eye-slash icon
                } else {
                    passwordInput.type = 'password'; // Change to password to hide it
                    icon.classList.remove('ti-eye-off'); // Remove eye-slash icon
                    icon.classList.add('ti-eye'); // Add eye icon
                }
            });
        }

        showpassword('show-old-password', 'oldpassword', 'toggle-icon-old-password');
        showpassword('show-password', 'passwords', 'toggle-icon-password');
        showpassword('show-password-confirm', 'cpassword', 'toggle-icon-confirm-password');

        $(document).ready(function() {

            var activeTab = "{{ session('active_tab', 'profile-1') }}";
            $('.nav-link[href="#' + activeTab + '"]').tab('show');

        });
        
    </script>
@endsection
<!-- [ Main Content ] end -->
