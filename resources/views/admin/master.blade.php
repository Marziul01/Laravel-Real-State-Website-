<!doctype html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('admin-assets') }}/assets/" data-template="vertical-menu-template-free" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title> {{ $setting->site_name }} | Admin Dashboard </title>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
    </script>
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset($setting->site_favicon) }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('admin-assets') }}/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets') }}/assets/vendor/css/core.css"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin-assets') }}/assets/vendor/css/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('admin-assets') }}/assets/css/demo.css" />
    <link href="https://fonts.googleapis.com/css2?family=Tiro+Bangla&display=swap" rel="stylesheet">


    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('admin-assets') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('admin-assets') }}/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Helpers -->
    <script src="{{ asset('admin-assets') }}/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('admin-assets') }}/assets/js/config.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.2.0/css/fontawesome-iconpicker.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


    <link rel="stylesheet" href="{{ asset('admin-assets') }}/css/style.css" />
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('admin.include.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                @include('admin.include.header')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    @yield('content')
                    

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
    
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <div id="fullscreenLoader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999999999;">
            <div style="display:flex; justify-content:center; align-items:center; width:100%; height:100%;">
                <div id="custom-onlyloading"></div>
            </div>
        </div>

        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex justify-content-center flex-column align-items-center auth-success-modal" >
                        <img src="{{ asset('admin-assets/img/Check Mark - Success.gif') }}" width="25%" alt="">
                        <h5 class="modal-title text-center" id="successModalLabel">Success</h5>
                        <p id="successMessage" class="text-center">Login successful!</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="{{ asset('admin-assets') }}/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('admin-assets') }}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('admin-assets') }}/assets/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('admin-assets') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{ asset('admin-assets') }}/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('admin-assets') }}/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('admin-assets') }}/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="{{ asset('admin-assets') }}/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- jQuery -->
    

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Buttons extension -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
   <!-- Icon Picker -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.2.0/js/fontawesome-iconpicker.min.js"></script>
   <script>
document.querySelectorAll('.myDate').forEach(function(el) {
    let placeholderText = el.getAttribute('placeholder') || 'YY-MM-DD';
    let value = el.value?.trim();

    // Determine the effective placeholder
    if (!value) {
        // if input has a placeholder use that, else fallback
        el.setAttribute('placeholder', placeholderText);
    }

    // Initialize flatpickr
    flatpickr(el, {
        dateFormat: "Y-m-d",
        defaultDate: value || null, // show existing date if available
        disableMobile: false, // allow native picker for mobile
        onReady: function(selectedDates, dateStr, instance) {
            // If no value selected, show placeholder visually
            if (!value) {
                instance.input.placeholder = placeholderText;
            }
        },
        onChange: function(selectedDates, dateStr, instance) {
            // When user picks a date, remove placeholder
            if (dateStr) {
                instance.input.placeholder = '';
            }
        },
        onClose: function(selectedDates, dateStr, instance) {
            // If cleared, restore placeholder
            if (!dateStr) {
                instance.input.placeholder = placeholderText;
            }
        }
    });
});
</script>

    <script>
        const toggleCheckbox = document.getElementById('themeToggle');
        const root = document.documentElement;

        // Load theme from localStorage
        if (localStorage.getItem('theme') === 'dark') {
            root.setAttribute('data-theme', 'dark');
            toggleCheckbox.checked = true; // show ball on right side
        } else {
            toggleCheckbox.checked = false;
        }

        // Toggle theme on change
        toggleCheckbox.addEventListener('change', () => {
            if (toggleCheckbox.checked) {
                root.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            } else {
                root.removeAttribute('data-theme');
                localStorage.setItem('theme', 'light');
            }
        });
    </script>

    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif
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

    {{-- <script>
        const timeApiUrl = "{{ route('get.time') }}"; // Laravel route URL

        async function fetchDhakaTime() {
            const response = await fetch(timeApiUrl);
            const data = await response.json();
            return new Date(data.time.replace(' ', 'T'));
        }

        function format12Hour(date) {
            let hours = date.getHours();
            const minutes = date.getMinutes();
            const seconds = date.getSeconds();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            return `${pad(hours)}:${pad(minutes)}:${pad(seconds)} ${ampm}`;
        }

        function pad(num) {
            return num < 10 ? '0' + num : num;
        }

        async function startClock() {
            let serverTime = await fetchDhakaTime();
            setInterval(() => {
                serverTime.setSeconds(serverTime.getSeconds() + 1);
                document.getElementById('clock').textContent = format12Hour(serverTime);
            }, 1000);
        }

        startClock();
    </script> --}}


    @yield('scripts')
    
    {{-- <script>
        // Disable right-click context menu
        document.addEventListener('contextmenu', event => event.preventDefault());

        // Disable certain key combinations
        document.addEventListener('keydown', event => {
            // Disable F12
            if (event.key === "F12") {
                event.preventDefault();
            }

            // Disable Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U, Ctrl+S, Ctrl+Shift+C
            if (event.ctrlKey && (event.shiftKey && ['I', 'J', 'C'].includes(event.key.toUpperCase()) || ['U', 'S']
                    .includes(event.key.toUpperCase()))) {
                event.preventDefault();
            }
        });

        // Disable dragging images
        document.addEventListener('dragstart', event => event.preventDefault());

        // Try to detect if DevTools is open (basic check)
        setInterval(function() {
            const start = performance.now();
            debugger;
            if (performance.now() - start > 100) {
                window.location.href = "about:blank"; // Redirect or show warning
            }
        }, 1000);
    </script> --}}

</body>

</html>
