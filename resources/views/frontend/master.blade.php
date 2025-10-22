<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">


    <link rel='icon' href='{{ asset($setting->site_favicon) }}' type='image/x-icon' />

    <title>{{ $setting->site_name }} | @yield('title')</title>
    <meta name="description" content="@yield('description')" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset($setting->site_favicon) }}" sizes="32x32" />
    <link rel="icon" href="{{ asset($setting->site_favicon) }}" sizes="192x192" />
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />
    <link rel="apple-touch-icon" href="{{ asset($setting->site_favicon) }}" />
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/style.css') }}">

</head>

<body
    class="home wp-singular page-template page-template-front-page page-template-front-page-php page page-id-7 wp-embed-responsive wp-theme-twentytwenty wp-child-theme-twentytwenty-child singular enable-search-modal missing-post-thumbnail has-no-pagination not-showing-comments show-avatars front-page footer-top-hidden">

    <div id="page" class="site position-relative" data-device="desktop">

        @include('frontend.include.header')

        @yield('content')

        @include('frontend.include.footer')


    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const widget = document.querySelector('.chat-widget');
        const mainBtn = widget.querySelector('.main-btn');
        const closeBtn = widget.querySelector('.close-btn');

        mainBtn.addEventListener('click', () => {
            widget.classList.add('active');
        });

        closeBtn.addEventListener('click', () => {
            widget.classList.remove('active');
        });
    </script>
    <script>
        document.addEventListener("scroll", function() {
            const header = document.getElementById("masthead");
            if (window.scrollY > 200) {
                header.classList.add("fixed");
            } else {
                header.classList.remove("fixed");
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const openBtn = document.querySelector(".header_whatsapp");
            const panel = document.getElementById("sideLoginModal");
            const closeBtn = panel.querySelector(".close-panel");

            // ✅ Toggle panel (open or close)
            openBtn.addEventListener("click", function(e) {
                e.preventDefault();
                panel.classList.toggle("active");
            });

            // ✅ Close panel (button)
            closeBtn.addEventListener("click", function() {
                panel.classList.remove("active");
            });

            // ✅ Close when clicking outside
            document.addEventListener("click", function(e) {
                const isClickInside = panel.contains(e.target);
                const isTrigger = e.target.closest(".header_whatsapp");
                if (!isClickInside && !isTrigger && panel.classList.contains("active")) {
                    panel.classList.remove("active");
                }
            });
        });
    </script>
    <script>
        let iti;

        function initPhoneInput() {
            const phoneInput = document.querySelector("#phone");
            if (!phoneInput) return;

            if (!iti) {
                iti = window.intlTelInput(phoneInput, {
                    initialCountry: "bd",
                    separateDialCode: true,
                    nationalMode: false,
                    formatOnDisplay: true,
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.21/js/utils.js"
                });

                phoneInput.addEventListener('blur', () => {
                    const phoneError = document.querySelector('#phoneError');
                    if (phoneInput.value.trim()) {
                        if (iti.isValidNumber()) {
                            phoneError.textContent = '';
                        } else {
                            phoneError.textContent = 'Please enter a valid phone number.';
                        }
                    }
                });
            }
        }

        $(document).ready(function() {

            $('#togglePassword').on('click', function() {
                const input = $('#password');
                const icon = $(this).find('i');
                input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
                icon.toggleClass('fa-eye fa-eye-slash');
            });

            $('#toggleFormBtn').on('click', function() {
                const isLogin = $('#submitBtn').text().trim().startsWith('Login');
                if (isLogin) {
                    $('#submitBtn').html('<i class="fa-solid fa-arrow-right-to-bracket"></i> Sign Up');
                    $(this).html('<i class="fa-solid fa-arrow-right-to-bracket"></i> Login');
                    $('#nameField, #phoneField').removeClass('d-none');
                    initPhoneInput();
                } else {
                    $('#submitBtn').html('<i class="fa-solid fa-arrow-right-to-bracket"></i> Login');
                    $(this).html('<i class="fa-regular fa-circle-user"></i> Sign Up');
                    $('#nameField, #phoneField').addClass('d-none');
                }
                $('#formAuthentication')[0].reset();
                $('.text-danger').text('');
            });


            const loader = document.getElementById('formLoader');

            $('#formAuthentication').on('submit', function(e) {
                e.preventDefault();
                $('.text-danger').text('');
                const isSignup = $('#submitBtn').text().trim().startsWith('Sign Up');
                let formDataArray = $(this).serializeArray();

                if (isSignup && iti) {
                    const phoneInput = document.querySelector("#phone");
                    const phoneError = document.querySelector('#phoneError');

                    if (!iti.isValidNumber()) {
                        phoneError.textContent = 'Please enter a valid phone number.';
                        return;
                    }

                    const fullPhone = iti.getNumber();
                    let phoneFound = false;
                    formDataArray = formDataArray.map(f => {
                        if (f.name === 'phone') {
                            phoneFound = true;
                            return {
                                name: 'phone',
                                value: fullPhone
                            };
                        }
                        return f;
                    });
                    if (!phoneFound) {
                        formDataArray.push({
                            name: 'phone',
                            value: fullPhone
                        });
                    }
                }

                const url = isSignup ? "{{ route('user.register') }}" : "{{ route('user.authenticate') }}";

                loader.classList.remove('d-none');
                $.ajax({
                    url: url,
                    method: "POST",
                    data: $.param(formDataArray),
                    dataType: 'json',
                    success: function(response) {
                        loader.classList.add('d-none');
                        if (response.success) {
                            if (isSignup) {
                                $('#formAuthentication, #toggleFormBtn').addClass('d-none');
                                $('#verifyEmailForm').removeClass('d-none');
                                toastr.success('Verification code sent to your email!');
                            } else {
                                toastr.success('Login successful!');
                                setTimeout(() => location.reload(), 1000);
                            }
                        } else {
                            if (!isSignup) $('#passwordError').text(response.message ||
                                'Invalid credentials.');
                        }
                    },
                    error: function(xhr) {
                        loader.classList.add('d-none');
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            if (errors.email) $('#emailError').text(errors.email[0]);
                            if (errors.password) $('#passwordError').text(errors.password[0]);
                            if (errors.name) $('#nameError').text(errors.name[0]);
                            if (errors.phone) $('#phoneError').text(errors.phone[0]);
                        } else {
                            $('#passwordError').text("Something went wrong. Please try again.");
                        }
                    }
                });
            });

            $('#verifyEmailForm').on('submit', function(e) {
                e.preventDefault();
                $('#verificationError').text('');
                const formData = $(this).serialize();
                loader.classList.remove('d-none');

                $.ajax({
                    url: "{{ route('user.verifyEmail') }}",
                    method: "POST",
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        loader.classList.add('d-none');
                        if (response.success) {
                            toastr.success('Email verified successfully!');
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            $('#verificationError').text(response.message ||
                                'Invalid verification code.');
                        }
                    },
                    error: function(xhr) {
                        loader.classList.add('d-none');
                        if (xhr.status === 422 && xhr.responseJSON.errors?.verification_code) {
                            $('#verificationError').text(xhr.responseJSON.errors
                                .verification_code[0]);
                        } else {
                            $('#verificationError').text(
                                'Something went wrong. Please try again.');
                        }
                    }
                });
            });

        });
    </script>

    <script>
        // Hide all forms except login
        function showForm(formId) {
            ['formAuthentication', 'verifyEmailForm', 'forgotPasswordForm', 'verifyForgotCodeForm', 'resetPasswordForm',
                'toggleFormBtn', 'forget-toogle', 'toggleBACK'
            ].forEach(id => {
                document.getElementById(id).classList.add('d-none');
            });
            document.getElementById(formId).classList.remove('d-none');
        }

        const loader = document.getElementById('formLoader');

        // 👉 Forgot password click event
        document.getElementById('forget-toogle').addEventListener('click', function(e) {
            e.preventDefault();
            showForm('forgotPasswordForm');
            document.getElementById('toggleBACK').classList.remove('d-none');
        });

        document.getElementById('toggleBACK').addEventListener('click', function(e) {
            e.preventDefault();

            // Hide all forgot/reset forms
            const formsToHide = ['forgotPasswordForm', 'verifyForgotCodeForm', 'resetPasswordForm'];
            formsToHide.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.add('d-none');
            });

            // Hide the back button itself
            this.classList.add('d-none');

            // Show default login/signup form and toggle button
            document.getElementById('formAuthentication').classList.remove('d-none');
            document.getElementById('toggleFormBtn').classList.remove('d-none');
            document.getElementById('forget-toogle').classList.remove('d-none');
            // Reset all forms and error messages
            document.getElementById('formAuthentication').reset();
            document.getElementById('forgotPasswordForm')?.reset();
            document.getElementById('verifyForgotCodeForm')?.reset();
            document.getElementById('resetPasswordForm')?.reset();

            ['emailError', 'passwordError', 'nameError', 'phoneError', 'verificationError', 'forgotEmailError',
                'forgotCodeError', 'resetPasswordError'
            ].forEach(errId => {
                const el = document.getElementById(errId);
                if (el) el.textContent = '';
            });
        });


        // Step 1: Send verification email
        document.getElementById('forgotPasswordForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            loader.classList.remove('d-none');

            const email = document.getElementById('forgotEmail').value;
            document.getElementById('forgotEmailError').innerText = '';

            const res = await fetch("{{ route('password.sendCode') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json', // ✅ Add this
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    email
                })
            });

            const data = await res.json();
            loader.classList.add('d-none');

            if (res.status === 422 && data.errors?.email) {
                document.getElementById('forgotEmailError').innerText = data.errors.email[0];
            } else if (!data.success) {
                toastr.error(data.message);
            } else {
                toastr.success(data.message);
                showForm('verifyForgotCodeForm');
            }
        });

        // Step 2: Verify code
        document.getElementById('verifyForgotCodeForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            loader.classList.remove('d-none');

            const code = document.getElementById('forgotVerificationCode').value;
            document.getElementById('forgotVerificationError').innerText = '';

            const res = await fetch("{{ route('password.verifyCode') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json', // ✅ Add this
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    verification_code: code
                })
            });

            const data = await res.json();
            loader.classList.add('d-none');

            if (res.status === 422 && data.errors?.verification_code) {
                document.getElementById('forgotVerificationError').innerText = data.errors.verification_code[0];
            } else if (!data.success) {
                document.getElementById('forgotVerificationError').innerText = data.message;
            } else {
                toastr.success(data.message);
                showForm('resetPasswordForm');
            }
        });

        // Step 3: Reset password
        document.getElementById('resetPasswordForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            loader.classList.remove('d-none');

            const password = document.getElementById('newPassword').value;
            const confirm_password = document.getElementById('confirmPassword').value;

            document.getElementById('newPasswordError').innerText = '';
            document.getElementById('confirmPasswordError').innerText = '';

            const res = await fetch("{{ route('user.password.reset') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json', // ✅ Add this
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    password,
                    confirm_password
                })
            });

            const data = await res.json();
            loader.classList.add('d-none');

            if (res.status === 422 && data.errors) {
                if (data.errors.password) document.getElementById('newPasswordError').innerText = data.errors
                    .password[0];
                if (data.errors.confirm_password) document.getElementById('confirmPasswordError').innerText =
                    data.errors.confirm_password[0];
            } else if (!data.success) {
                toastr.error(data.message);
            } else {
                toastr.success(data.message);
                showForm('formAuthentication');
                $('#nameField, #phoneField').addClass('d-none');
                $('#submitBtn').html('<i class="fa-solid fa-arrow-right-to-bracket"></i> Login');
                $('#toggleFormBtn').html('<i class="fa-regular fa-circle-user"></i> Sign Up');
                $('#formAuthentication')[0].reset();
                $('.text-danger').text('');
                document.getElementById('toggleFormBtn').classList.remove('d-none');
                document.getElementById('forget-toogle').classList.remove('d-none');
            }
        });
    </script>

    <script>
    $(document).ready(function() {
        let addedFixedByMenu = false; // track if menu added 'fixed'

        // Function to open menu
        function openMenu() {
            $('#main-nav').addClass('show');
            $('body').addClass('no-scroll'); // stop page scroll

            // Only add 'fixed' if not already present
            if (!$('#masthead').hasClass('fixed')) {
                $('#masthead').addClass('fixed');
                addedFixedByMenu = true; // track that it was added by menu
            }
        }

        // Function to close menu
        function closeMenu() {
            $('#main-nav').removeClass('show');
            $('body').removeClass('no-scroll'); // re-enable page scroll

            // Remove 'fixed' only if it was added by the menu and scroll < 200px
            if (addedFixedByMenu && $(window).scrollTop() < 200) {
                $('#masthead').removeClass('fixed');
            }

            addedFixedByMenu = false;
        }

        // Toggle open/close when hamburger is clicked
        $('.hamburger-menu').on('click', function(e) {
            e.preventDefault();
            if ($('#main-nav').hasClass('show')) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        // Close when clicking close icon
        $('.close-menu').on('click', function() {
            closeMenu();
        });

        // Close when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#main-nav, .hamburger-menu').length) {
                closeMenu();
            }
        });
    });
</script>



    @yield('customJs')

</body>

</html>
