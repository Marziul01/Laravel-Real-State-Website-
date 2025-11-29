@extends('admin.master')

@section('content')
    <section class="content">

        <div class="container-fluid">
            <div class="d-flex mb-2 justify-content-between align-items-center">
                <h3>Add New Booking</h3>
                <a href="{{ route('booking.pending') }}" class="btn btn-primary">Back</a>
            </div>
            <form id="checkoutForm">
                @csrf
                <input type="hidden" id="hiddenUserId" name="user_id">
                <input type="hidden" id="hiddenStartDate" name="start_date">
                <input type="hidden" id="hiddenEndDate" name="end_date">
                <input type="hidden" id="hiddenBookingType" name="booking_type">
                <input type="hidden" id="hiddenTotalPrice" name="total">
                <input type="hidden" id="hiddenDiscountedPrice" name="grand_total">
                <input type="hidden" id="hiddenCouponId" name="coupon_id">

                <div class="row">
                    <!-- LEFT SIDE — USER & BOOKING DETAILS -->
                    <div class="col-lg-7">
                        <div class="card shadow-sm p-4">
                            <h4 class="mb-3 fw-bold">Booking Details</h4>

                            <!-- Select User -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Select User</label>
                                <select id="userSelect" name="user_id" class="form-select">
                                    <option value="">-- Select User --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}" data-phone="{{ $user->phone }}"
                                            data-address="{{ $user->address }}">
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Auto-filled User Info -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" class="form-control" name="name" id="userName" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" name="email" id="userEmail" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" class="form-control" name="phone" id="userPhone">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Address</label>
                                <input type="text" class="form-control" name="address" id="userAddress">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Total Guests</label>
                                <input type="number" min="1" class="form-control" name="total_guests" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-2"> Confirm </button>
                    </div>


                    <!-- RIGHT SIDE — PROPERTY & PAYMENT -->
                    <div class="col-lg-5">
                        <div class="card shadow-sm p-4 mb-4">
                            <h4 class="fw-bold mb-3">Property Selection</h4>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Select Property</label>
                                <select id="propertySelect" name="property_id" class="form-select" required>
                                    <option value="">-- Select Property --</option>
                                    @foreach ($properties as $property)
                                        <option value="{{ $property->id }}"
                                            data-image="{{ asset($property->featured_image) }}"
                                            data-city="{{ $property->city }}"
                                            data-country="{{ $property->country->name }}">
                                            {{ $property->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="propertyInfo" class="d-none">
                                <div class="d-flex mb-3 align-items-center">
                                    <img id="propertyImage" src="" class="rounded me-3"
                                        style="width:80px;height:80px;object-fit:cover;">
                                    <div>
                                        <h6 id="propertyName" class="fw-semibold mb-1"></h6>
                                        <p id="propertyLocation" class="text-muted small mb-0"></p>
                                    </div>
                                </div>

                                {{-- <div class="mb-3">
                                    <label class="form-label fw-semibold">Booking Dates</label>
                                    <input type="text" id="rentDateRange" class="form-control"
                                        placeholder="Select Dates" readonly>

                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="fw-semibold">Total Price:</span>
                                    <span class="fw-bold text-primary" id="totalPrice">0 BDT</span>
                                </div> --}}
                                {{-- <ul class="nav nav-tabs mb-3 border-0 booking-navs" id="bookingTabs">
                                    
                                        <li class="nav-item mb-2">
                                            <button type="button" class="nav-link" data-type="per-night">Per Night</button>
                                        </li>
                                    

                                    
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" data-type="weekly">Weekly</button>
                                        </li>
                                   
                                    
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" data-type="monthly">Monthly</button>
                                        </li>
                                   
                                </ul>

                                <!-- PER NIGHT SECTION -->
                                <div class="booking-section d-none" id="section-per-night">
                                    <label class="form-label fw-semibold">Select Per-Night Dates</label>
                                    <input type="text" id="rentDateRange" class="form-control" readonly>

                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="fw-semibold">Total:</span>
                                        <span class="fw-bold text-primary" id="totalPricePerNight">0 BDT</span>
                                    </div>
                                </div>

                                <!-- WEEKLY SECTION -->
                                <div class="booking-section d-none" id="section-weekly">
                                    <label class="form-label fw-semibold">Select Weekly Dates</label>
                                    <input type="text" id="weeklyDateRange" class="form-control" readonly>

                                    <small class="text-danger d-none" id="weeklyError">Please select full weekly dates (multiples
                                        of 7 days).</small>

                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="fw-semibold">Total:</span>
                                        <span class="fw-bold text-primary" id="totalPriceWeekly">0 BDT</span>
                                    </div>
                                </div>

                                <!-- MONTHLY SECTION -->
                                <div class="booking-section d-none" id="section-monthly">
                                    <label class="form-label fw-semibold">Select Monthly Dates</label>
                                    <input type="text" id="monthlyDateRange" class="form-control" readonly>

                                    <small class="text-danger d-none" id="monthlyError">Please select a full month range.</small>

                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="fw-semibold">Total:</span>
                                        <span class="fw-bold text-primary" id="totalPriceMonthly">0 BDT</span>
                                    </div>
                                </div> --}}

                                <div id="bookingTabsContainer" class="admin-booking-tabs"></div>
                                <div id="bookingSectionsContainer"></div>

                                <!-- Coupon -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Coupon Code</label>
                                    <div class="input-group">
                                        <input type="text" id="couponCode" class="form-control"
                                            placeholder="Enter coupon code">
                                        <button class="btn btn-outline-primary" type="button"
                                            id="applyCoupon">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payments (same as before) -->
                        <div class="card shadow-sm p-4">
                            <h4 class="fw-bold mb-3">Payment Method</h4>

                            <div id="paymentMethods">
                                @foreach ($payments as $payment)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input payment-option" type="radio"
                                            name="payment_method" id="payment_{{ $payment->id }}"
                                            value="{{ $payment->id }}">
                                        <label class="form-check-label fw-semibold"
                                            for="payment_{{ $payment->id }}">{{ $payment->name }}</label>

                                        <div class="payment-info mt-2 p-3 rounded small d-none"
                                            id="paymentInfo_{{ $payment->id }}">
                                            <input type="hidden" name="payment_method_type"
                                                value="{{ $payment->payment_method_type }}">

                                            @if ($payment->payment_method_type == 'mobile_banking')
                                                <p>Send total amount to: <b>{{ $payment->account_number }}</b></p>
                                                <label>Transaction ID:</label>
                                                <input type="text" name="transaction_id" class="form-control mt-1">
                                            @else
                                                <p>Send payment to bank account:</p>
                                                <p><b>Account Number:</b> {{ $payment->account_number }}</p>
                                                <p><b>Account Name:</b> {{ $payment->account_name }}</p>
                                                <p><b>Branch:</b> {{ $payment->branch_name }}</p>

                                                <label>Your Account Number:</label>
                                                <input type="number" name="bank_account_number"
                                                    class="form-control mt-1">
                                                <label>Your Account Name:</label>
                                                <input type="text" name="bank_account_name" class="form-control mt-1">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>


                </div>


            </form>
        </div>
    </section>

    </div>

    <div id="formLoaderbooking" class="form-loader booking d-none">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            let pricePerNight = 0;
            let bookedDates = [];
            let bookingStartDate = null;
            let totalPrice = 0;
            let discountedPrice = 0;
            let couponId = null;

            // --- Property selection ---
            $('#propertySelect').on('change', function() {
                const id = $(this).val();
                if (!id) return;

                const option = $(this).find('option:selected');
                $('#propertyName').text(option.text());
                $('#propertyImage').attr('src', option.data('image'));
                $('#propertyLocation').text(`${option.data('city')}, ${option.data('country')}`);
                $('#propertyInfo').removeClass('d-none');

                // Get property data + booked dates
                $.get("{{ route('admin.bookings.propertyDates', ':id') }}".replace(':id', id), function(
                    res) {
                    bookedDates = res.bookedDates;
                    bookingStartDate = res.rent_start;
                    pricePerNight = res.price;
                    initDatepicker();
                });
            });

            function formatDate(date) {
                const d = new Date(date.getTime());
                const year = d.getFullYear();
                const month = ('0' + (d.getMonth() + 1)).slice(-2);
                const day = ('0' + d.getDate()).slice(-2);
                return `${year}-${month}-${day}`;
            }

            // --- Datepicker setup ---
            $(document).ready(function() {
                let bookedDates = [];
                let minSelectableDate = null;
                let pricePerNight = 0;
                let priceWeekly = 0;
                let priceMonthly = 0;

                $('#propertySelect').on('change', function() {
                    const id = $(this).val();
                    if (!id) return;

                    const option = $(this).find('option:selected');
                    $('#propertyName').text(option.text());
                    $('#propertyImage').attr('src', option.data('image'));
                    $('#propertyLocation').text(`${option.data('city')}, ${option.data('country')}`);
                    $('#propertyInfo').removeClass('d-none');

                    $.get("{{ route('admin.bookings.propertyDates', ':id') }}".replace(':id', id), function(res) {
                        bookedDates = res.bookedDates;
                        minSelectableDate = new Date(res.rent_start);
                        pricePerNight = parseFloat(res.price) || 0;
                        priceWeekly = parseFloat(res.weekly_price) || 0;
                        priceMonthly = parseFloat(res.monthly_price) || 0;

                        // --- Generate tabs dynamically ---
                        let tabsHtml = '<ul class="nav nav-tabs mb-3 border-0 booking-navs">';
                        if(pricePerNight) tabsHtml += `<li class="nav-item mb-2"><button type="button" class="nav-link" data-type="per-night">Per Night</button></li>`;
                        if(priceWeekly) tabsHtml += `<li class="nav-item"><button type="button" class="nav-link ${pricePerNight ? '' : 'active'}" data-type="weekly">Weekly</button></li>`;
                        if(priceMonthly) tabsHtml += `<li class="nav-item"><button type="button" class="nav-link ${!pricePerNight && !priceWeekly ? 'active' : ''}" data-type="monthly">Monthly</button></li>`;
                        tabsHtml += '</ul>';
                        $('#bookingTabsContainer').html(tabsHtml);

                        // --- Generate booking sections dynamically ---
                        let sectionsHtml = '';
                        if(pricePerNight) {
                            sectionsHtml += `
                                <div class="booking-section" id="section-per-night">
                                    <label class="form-label fw-semibold">Select Per-Night Dates</label>
                                    <input type="text" id="rentDateRange" class="form-control" readonly>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="fw-semibold">Total:</span>
                                        <span class="fw-bold text-primary" id="totalPricePerNight">0 BDT</span>
                                    </div>
                                </div>
                            `;
                        }
                        if(priceWeekly) {
                            sectionsHtml += `
                                <div class="booking-section ${!pricePerNight ? '' : 'd-none'}" id="section-weekly">
                                    <label class="form-label fw-semibold">Select Weekly Dates</label>
                                    <input type="text" id="weeklyDateRange" class="form-control" readonly>
                                    <small class="text-danger d-none" id="weeklyError">Please select full weekly dates (multiples of 7 days).</small>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="fw-semibold">Total:</span>
                                        <span class="fw-bold text-primary" id="totalPriceWeekly">0 BDT</span>
                                    </div>
                                </div>
                            `;
                        }
                        if(priceMonthly) {
                            sectionsHtml += `
                                <div class="booking-section ${!pricePerNight && !priceWeekly ? '' : 'd-none'}" id="section-monthly">
                                    <label class="form-label fw-semibold">Select Monthly Dates</label>
                                    <input type="text" id="monthlyDateRange" class="form-control" readonly>
                                    <small class="text-danger d-none" id="monthlyError">Please select a full month range.</small>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="fw-semibold">Total:</span>
                                        <span class="fw-bold text-primary" id="totalPriceMonthly">0 BDT</span>
                                    </div>
                                </div>
                            `;
                        }
                        $('#bookingSectionsContainer').html(sectionsHtml);

                        // --- Initialize Flatpickr and tab click logic ---
                        initBookingSections();
                    });

                });

                let appliedDiscount = 0;   // percentage %
                let couponId = null;

                // Update hidden fields + visible price
            

                function initBookingSections() {
                    // Hide all first
                    $('.booking-section').addClass('d-none');

                    // Tab click to show section
                    $('.booking-navs button').on('click', function() {
                        const type = $(this).data('type');
                        $('.booking-section').addClass('d-none');
                        $(`#section-${type}`).removeClass('d-none');

                        $('.booking-navs button').removeClass('active');
                        $(this).addClass('active');
                    });

                    // Tab click to show section
                    $('.booking-navs button').on('click', function() {
                        const type = $(this).data('type');

                        // --- Show selected section ---
                        $('.booking-section').addClass('d-none');
                        $(`#section-${type}`).removeClass('d-none');

                        // --- Update active tab ---
                        $('.booking-navs button').removeClass('active');
                        $(this).addClass('active');

                        // --- Clear hidden inputs for new selection ---
                        $('#hiddenStartDate').val('');
                        $('#hiddenEndDate').val('');
                        $('#hiddenTotalPrice').val('0');
                        $('#hiddenDiscountedPrice').val('0');
                        $('#hiddenCouponId').val('');
                        
                        // --- Set the booking type ---
                        $('#hiddenBookingType').val(type);

                        // Optional: reset total display for the section
                        if(type === 'per-night') $('#totalPricePerNight').text('0 BDT');
                        if(type === 'weekly') $('#totalPriceWeekly').text('0 BDT');
                        if(type === 'monthly') $('#totalPriceMonthly').text('0 BDT');
                    });


                    // --- PER NIGHT ---
                    if (pricePerNight && $('#section-per-night').length) {
                        flatpickr("#rentDateRange", {
                            mode: "range",
                            minDate: minSelectableDate,
                            disable: bookedDates,
                            dateFormat: "Y-m-d",
                            onChange: function(selectedDates) {
                                let total = 0;
                                if (selectedDates.length === 2) {
                                    const diffDays = Math.ceil((selectedDates[1] - selectedDates[0]) / (1000*60*60*24));
                                    total = diffDays * pricePerNight;
                                }
                                totalPrice = total;   // full price
                                discountedPrice = total;  // reset coupon
                                updatePricesUI();
                               

                                $('#hiddenStartDate').val(formatDate(selectedDates[0]));
                                $('#hiddenEndDate').val(formatDate(selectedDates[1]));
                            }
                        });
                    }

                    // --- WEEKLY ---
                    if (priceWeekly && $('#section-weekly').length) {
                        const weeklyError = $('#weeklyError');
                        flatpickr("#weeklyDateRange", {
                            mode: "range",
                            minDate: minSelectableDate,
                            disable: bookedDates,
                            dateFormat: "Y-m-d",
                            onChange: function(selectedDates) {
                                weeklyError.text('').addClass('d-none');
                                let total = 0;
                                if (selectedDates.length === 2) {
                                    const diffDays = Math.ceil((selectedDates[1]-selectedDates[0])/(1000*60*60*24));
                                    if (diffDays % 7 !== 0) {
                                        weeklyError.text("Please select exact weekly dates (7, 14, 21...).").removeClass('d-none');
                                        $('#totalPriceWeekly').text('0 BDT');
                                        return;
                                    }
                                    const weeks = diffDays / 7;
                                    total = weeks * priceWeekly;
                                }
                                 totalPrice = total;   // full price
                                discountedPrice = total;  // reset coupon
                                updatePricesUI();

                                $('#hiddenStartDate').val(formatDate(selectedDates[0]));
                                $('#hiddenEndDate').val(formatDate(selectedDates[1]));
                            }
                        });
                    }

                    // --- MONTHLY ---
                    if (priceMonthly && $('#section-monthly').length) {
                        const monthlyError = $('#monthlyError');
                        flatpickr("#monthlyDateRange", {
                            mode: "range",
                            minDate: minSelectableDate,
                            disable: bookedDates,
                            dateFormat: "Y-m-d",
                            onChange: function(selectedDates) {
                                monthlyError.text('').addClass('d-none');
                                let total = 0;
                                if (selectedDates.length === 2) {
                                    const start = selectedDates[0];
                                    const end = selectedDates[1];
                                    const lastDayOfEndMonth = new Date(end.getFullYear(), end.getMonth()+1, 0).getDate();

                                    if (start.getDate() !== 1) {
                                        monthlyError.text("Start date must be the 1st of the month.").removeClass('d-none');
                                        $('#totalPriceMonthly').text('0 BDT');
                                        return;
                                    }
                                    if (end.getDate() !== lastDayOfEndMonth) {
                                        monthlyError.text("End date must be the last day of the month.").removeClass('d-none');
                                        $('#totalPriceMonthly').text('0 BDT');
                                        return;
                                    }

                                    const months = (end.getFullYear()-start.getFullYear())*12 + (end.getMonth()-start.getMonth()) + 1;
                                    total = months * priceMonthly;
                                }
                                 totalPrice = total;   // full price
                                discountedPrice = total;  // reset coupon
                                updatePricesUI();

                                $('#hiddenStartDate').val(formatDate(selectedDates[0]));
                                $('#hiddenEndDate').val(formatDate(selectedDates[1]));
                            }
                        });
                    }
                }

                function formatDate(d) {
                    if (!d) return '';
                    const date = new Date(d);
                    return date.getFullYear() + '-' + ('0'+(date.getMonth()+1)).slice(-2) + '-' + ('0'+date.getDate()).slice(-2);
                }
            });

            function updatePricesUI() {

                    $('#hiddenTotalPrice').val(totalPrice);
                    $('#hiddenDiscountedPrice').val(discountedPrice);

                    let displayPrice = discountedPrice > 0 ? discountedPrice : totalPrice;

                    if ($('#section-per-night').is(':visible')) {
                        $('#totalPricePerNight').text(displayPrice.toLocaleString() + ' BDT');
                    }
                    if ($('#section-weekly').is(':visible')) {
                        $('#totalPriceWeekly').text(displayPrice.toLocaleString() + ' BDT');
                    }
                    if ($('#section-monthly').is(':visible')) {
                        $('#totalPriceMonthly').text(displayPrice.toLocaleString() + ' BDT');
                    }
                }
            // --- User selection autofill ---
            $('#userSelect').on('change', function() {
                const user = $(this).find(':selected');
                $('#userName').val(user.data('name') || '');
                $('#userEmail').val(user.data('email') || '');
                $('#userPhone').val(user.data('phone') || '');
                $('#userAddress').val(user.data('address') || '');
                $('#hiddenUserId').val(user.val());
            });

            // --- APPLY COUPON ---
            $('#applyCoupon').on('click', function() {
                
                const code = $('#couponCode').val().trim();

                if (!code) {
                    toastr.error('Please enter a coupon code');
                    return;
                }

                let totalPrice = Number($('#hiddenTotalPrice').val());

                if (totalPrice <= 0) {
                    toastr.error('Please select dates first');
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.coupon.apply') }}",
                    method: "POST",
                    data: {
                        code: code,
                        total_price: totalPrice,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.valid) {
                            toastr.success(res.message);

                            couponId = res.coupon_id;
                            discountedPrice = res.discounted_price; // FINAL PRICE
                            totalPrice = totalPrice;   // full price
                            updatePricesUI();
                            $('#hiddenCouponId').val(couponId);
                        } 
                        else {
                            toastr.error(res.message);

                            couponId = null;
                            totalPrice = totalPrice;   // full price
                            discountedPrice = totalPrice;  // reset coupon
                            updatePricesUI();
                            $('#hiddenCouponId').val('');
                        }

                        updatePricesUI();
                    },
                    error: function() {
                        toastr.error('Something went wrong while applying coupon');
                    }
                });
            });


            // --- Payment option selection ---
            $(document).on('change', '.payment-option', function() {
                $('.payment-info').addClass('d-none').find('input').prop('disabled', true);
                const infoDiv = $(this).closest('.form-check').find('.payment-info');
                infoDiv.removeClass('d-none').find('input').prop('disabled', false);
                $('.payment-info').not(infoDiv).find('input').val('');
            });

            $('.payment-info.d-none input').prop('disabled', true);

            // --- Submit Booking Form ---
            $('#checkoutForm').on('submit', function(e) {
                e.preventDefault();

                const loader = $('#formLoaderbooking');
                loader.removeClass('d-none');

                const formData = new FormData(this);

                // Disable unused payment inputs
                const selectedPayment = $('input[name="payment_method"]:checked');
                if (selectedPayment.length) {
                    $('#paymentMethods .form-check').each(function() {
                        if (!$(this).find('input[name="payment_method"]').is(':checked')) {
                            $(this).find('input').prop('disabled', true);
                        }
                    });
                }

                $.ajax({
                    url: "{{ route('admin.bookings.store') }}",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        toastr.info('Processing booking...');
                    },
                    success: function(res) {
                        loader.addClass('d-none');
                        toastr.clear();
                        toastr.success(res.message);
                        setTimeout(() => window.location.href =
                            "{{ route('booking.pending') }}", 1000);
                    },
                    error: function(xhr) {
                        loader.addClass('d-none');
                        toastr.clear();

                        if (xhr.status === 422) {
                            if (xhr.responseJSON.errors) {
                                $.each(xhr.responseJSON.errors, function(key, val) {
                                    toastr.error(val[0]);
                                });
                            } else if (xhr.responseJSON.message) {
                                toastr.error(xhr.responseJSON.message);
                            }
                        } else {
                            toastr.error('Something went wrong. Please try again.');
                        }
                    }
                });
            });
        });
    </script>
@endsection
