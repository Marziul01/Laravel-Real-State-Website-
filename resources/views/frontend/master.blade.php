<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />

    <title>{{ $setting->site_name }} | @yield('title')</title>
    <meta name="description" content="@yield('description')" />

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset($setting->site_favicon) }}" sizes="32x32" />
    <link rel="icon" href="{{ asset($setting->site_favicon) }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset($setting->site_favicon) }}" />

    {{-- Open Graph (Facebook, LinkedIn) --}}
    <meta property="og:type" content="article">
    <meta property="og:title" content="@yield('title', $setting->site_name)">
    <meta property="og:description" content="@yield('description', 'Explore expert insights, property guides, and real estate trends by ' . $setting->site_name . '.')">
    <meta property="og:image" content="@yield('meta_image', asset($setting->site_favicon))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $setting->site_name }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $setting->site_name)">
    <meta name="twitter:description" content="@yield('description', 'Explore expert insights, property guides, and real estate trends by ' . $setting->site_name . '.')">
    <meta name="twitter:image" content="@yield('meta_image', asset($setting->site_favicon))">

    {{-- External Libraries --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />

    {{-- Local Styles --}}
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/style.css') }}">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if($global_setting && $global_setting->gtm_id)
    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id={{ $global_setting->gtm_id }}'+dl;
        f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ $global_setting->gtm_id }}');
    </script>
    @endif

</head>


<body
    class="home wp-singular page-template page-template-front-page page-template-front-page-php page page-id-7 wp-embed-responsive wp-theme-twentytwenty wp-child-theme-twentytwenty-child singular enable-search-modal missing-post-thumbnail has-no-pagination not-showing-comments show-avatars front-page footer-top-hidden">

    <div id="page" class="site position-relative" data-device="desktop">

        @include('frontend.include.header')

        @yield('content')

        @include('frontend.include.footer')


    </div>
    
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

    // ✅ Toggle panel (open/close)
    openBtn.addEventListener("click", function(e) {
        e.preventDefault();
        panel.classList.toggle("active");
        document.body.style.overflow = panel.classList.contains("active") ? "hidden" : "auto";
    });

    // ✅ Close panel (button)
    closeBtn.addEventListener("click", function() {
        panel.classList.remove("active");
        document.body.style.overflow = "auto";
    });

    // ✅ Close when clicking outside (but NOT on intl-tel-input dropdown)
    document.addEventListener("click", function(e) {
        const isClickInside = panel.contains(e.target);
        const isTrigger = e.target.closest(".header_whatsapp");
        const isPhoneDropdown = e.target.closest(".iti__country-list"); // <– ignore this
        const isButtonLogin = e.target.closest(".dont-close"); // <– ignore this

        if (!isClickInside && !isTrigger && !isPhoneDropdown && !isButtonLogin && panel.classList.contains("active")) {
            panel.classList.remove("active");
            document.body.style.overflow = "auto";
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
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
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
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
                        }else {
                            // Only show message when success = false but NOT validation error
                            if (response.message) {
                                $('#passwordError').text(response.message);
                            }
                        }
                    },
                    error: function(xhr) {
                        loader.classList.add('d-none');
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors || {};

                            // For Access Denied and Blocked — they return "email" error
                            if (errors.email) {
                                $('#emailError').text(errors.email[0]);
                            }

                            if (errors.password) {
                                $('#passwordError').text(errors.password[0]);
                            }

                            if (errors.name) {
                                $('#nameError').text(errors.name[0]);
                            }

                            if (errors.phone) {
                                $('#phoneError').text(errors.phone[0]);
                            }

                            return;
                        }else {
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
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
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
<script>
        $(document).on('click', '.logout-confirm', function(e) {
            e.preventDefault();

            const logoutUrl = $(this).attr('href');

            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out from your account.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, log me out'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = logoutUrl;
                }
            });
        });
    </script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ✅ Initialize Select2
    $('#seriveFormModal').on('shown.bs.modal', function() {
        $('#demandsAll').select2({
            dropdownParent: $('#seriveFormModal'),
            width: '100%',
            placeholder: "Select Multiple Demands",
            allowClear: true
        });
    });

    // ✅ Initialize intl-tel-input for phone field
    const phoneInput = document.querySelector("#phoneInquiryservice");
    const iti = window.intlTelInput(phoneInput, {
        initialCountry: "bd",
        preferredCountries: ["bd", "in", "us", "gb"],
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
    });

    // ✅ Handle form submit via AJAX
    $('#seriveFormM').on('submit', function (e) {
        e.preventDefault();

        const phoneError = document.querySelector('#phoneErrorInquiryservice');
        phoneError.textContent = '';

        // ✅ Validate phone number
        if (!iti.isValidNumber()) {
            phoneError.textContent = 'Please enter a valid phone number.';
            return;
        }

        // ✅ Prepare data
        const formData = new FormData(this);
        formData.set('phone', iti.getNumber()); // replace raw phone with full intl format

        const actionUrl = $(this).attr('action');

        const loader = document.getElementById('formLoaderbooking2');
        loader.classList.remove('d-none');
        // ✅ Send AJAX request
        fetch(actionUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(async response => {
            loader.classList.add('d-none');

            if (!response.ok) {
                // If it's a validation error (422)
                if (response.status === 422) {
                    const data = await response.json();
                    Object.values(data.errors).forEach(errorArray => {
                        toastr.error(errorArray[0]); // Show first error of each field
                    });
                    return;
                }

                // Other server error
                toastr.error('Something went wrong.');
                return;
            }

            const data = await response.json();
            if (data.status === 'success') {
                toastr.success(data.message);
                $('#seriveFormM')[0].reset();
                $('#demandsAll').val(null).trigger('change');
                const modal = bootstrap.Modal.getInstance(document.getElementById('seriveFormModal'));
                modal.hide();
            } else {
                toastr.error(data.message || 'Something went wrong.');
            }
        })
        .catch(() => {
            loader.classList.add('d-none');
            toastr.error('An error occurred. Please try again.');
        });
    });
});
</script>

@if($global_setting && $global_setting->gtm_id)
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $global_setting->gtm_id }}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@endif

@if($global_setting && $global_setting->ga4_id)
<!-- Google Analytics 4 -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $global_setting->ga4_id }}"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '{{ $global_setting->ga4_id }}');
</script>
@endif

@if($global_setting && $global_setting->meta_pixel_id)
<!-- Meta Pixel -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{{ $global_setting->meta_pixel_id }}'); 
fbq('track', 'PageView');
</script>

<noscript>
  <img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id={{ $global_setting->meta_pixel_id }}&ev=PageView&noscript=1"/>
</noscript>
@endif



    @yield('customJs')

</body>

</html>
