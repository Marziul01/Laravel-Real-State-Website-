@extends('admin.master')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="d-flex mb-2 justify-content-between align-items-center">
            <h3>Edit Booking</h3>
            <a href="{{ route('booking.pending') }}" class="btn btn-primary">Back</a>
        </div>

        <form id="checkoutFormEdit">
            @csrf
            
            <input type="hidden" id="hiddenUserId" name="user_id" value="{{ $booking->user_id }}">
            <input type="hidden" id="hiddenStartDate" name="start_date" value="{{ $booking->start_date }}">
            <input type="hidden" id="hiddenEndDate" name="end_date" value="{{ $booking->end_date }}">
            <input type="hidden" id="hiddenBookingType" name="booking_type" value="{{ $booking->booking_type }}">
            <input type="hidden" id="hiddenTotalPrice" name="total" value="{{ $booking->total }}">
            <input type="hidden" id="hiddenDiscountedPrice" name="grand_total" value="{{ $booking->grand_total }}">
            <input type="hidden" id="hiddenCouponId" name="coupon_id" value="{{ $booking->coupon_id }}">

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
                                    <option value="{{ $user->id }}" 
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-phone="{{ $user->phone }}"
                                        data-address="{{ $user->address }}"
                                        {{ $booking->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Auto-filled User Info -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" class="form-control" name="name" id="userName" value="{{ $booking->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" name="email" id="userEmail" value="{{ $booking->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" class="form-control" name="phone" id="userPhone" value="{{ $booking->phone }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Address</label>
                            <input type="text" class="form-control" name="address" value="{{ $booking->address }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Total Guests</label>
                            <input type="number" min="1" class="form-control" name="total_guests" value="{{ $booking->total_guests }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-2"> Update Booking </button>
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
                                        data-country="{{ $property->country->name }}"
                                        {{ $booking->property_id == $property->id ? 'selected' : '' }}>
                                        {{ $property->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="propertyInfo">
                            <div class="d-flex mb-3 align-items-center">
                                <img id="propertyImage" src="{{ asset($booking->property->featured_image ?? '') }}" class="rounded me-3" style="width:80px;height:80px;object-fit:cover;">
                                <div>
                                    <h6 id="propertyName" class="fw-semibold mb-1">{{ $booking->property->name ?? '' }}</h6>
                                    <p id="propertyLocation" class="text-muted small mb-0">{{ $booking->property->city ?? '' }}, {{ $booking->property->country->name ?? '' }}</p>
                                </div>
                            </div>

                            {{-- <div class="mb-3">
                                <label class="form-label fw-semibold">Booking Dates</label>
                                <input type="text" id="rentDateRange" class="form-control" placeholder="Select Dates" readonly>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-semibold">Total Price:</span>
                                <span class="fw-bold text-primary" id="totalPrice">{{ $booking->grand_total }} BDT</span>
                            </div> --}}
                            {{-- <ul class="nav nav-tabs mb-3 border-0 booking-navs" id="bookingTabs">
                                @if ($booking->property->price)
                                    <li class="nav-item mb-2">
                                        <button type="button" class="nav-link" data-type="per-night">Per Night</button>
                                    </li>
                                @endif

                                @if ($booking->property->weekly_price)
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" data-type="weekly">Weekly</button>
                                    </li>
                                @endif

                                @if ($booking->property->monthly_price)
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" data-type="monthly">Monthly</button>
                                    </li>
                                @endif
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
                                    <input type="text" id="couponCode" class="form-control" value="{{ $booking->coupon->code ?? '' }}" placeholder="Enter coupon code">
                                    <button class="btn btn-outline-primary" type="button" id="applyCoupon">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payments -->
                    <div class="card shadow-sm p-4">
                        <h4 class="fw-bold mb-3">Payment Method</h4>

                        <div id="paymentMethods">
                            @foreach ($payments as $payment)
                                @php
                                    $isChecked = $booking->payment_id == $payment->id;
                                @endphp
                                <div class="form-check mb-2">
                                    <input class="form-check-input payment-option" type="radio"
                                        name="payment_method" id="payment_{{ $payment->id }}"
                                        value="{{ $payment->id }}" {{ $isChecked ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="payment_{{ $payment->id }}">{{ $payment->name }}</label>

                                    <div class="payment-info mt-2 p-3 rounded small {{ $isChecked ? '' : 'd-none' }}" id="paymentInfo_{{ $payment->id }}">
                                        <input type="hidden" name="payment_method_type" value="{{ $payment->payment_method_type }}">

                                        @if ($payment->payment_method_type == 'mobile_banking')
                                            <p>Send total amount to: <b>{{ $payment->account_number }}</b></p>
                                            <label>Transaction ID:</label>
                                            <input type="text" name="transaction_id" class="form-control mt-1" value="{{ $booking->transaction_id }}">
                                        @else
                                            <p>Send payment to bank account:</p>
                                            <p><b>Account Number:</b> {{ $payment->account_number }}</p>
                                            <p><b>Account Name:</b> {{ $payment->account_name }}</p>
                                            <p><b>Branch:</b> {{ $payment->branch_name }}</p>

                                            <label>Your Account Number:</label>
                                            <input type="number" name="bank_account_number" class="form-control mt-1" value="{{ $booking->bank_account_number }}">
                                            <label>Your Account Name:</label>
                                            <input type="text" name="bank_account_name" class="form-control mt-1" value="{{ $booking->bank_account_name }}">
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

<div id="formLoaderbooking" class="form-loader booking d-none">
    <div class="spinner-border text-primary" role="status"></div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // --- Server-provided values ---
        let bookingType = @json($booking->booking_type); // "per-night" | "weekly" | "monthly"
        let initialStart = @json($booking->start_date);  // e.g. "2025-12-01"
        let initialEnd = @json($booking->end_date);      // e.g. "2025-12-05"
        let initialTotal = Number(@json($booking->total ?? 0)); // full total (before coupon)
        let initialDiscounted = Number(@json($booking->grand_total ?? ($booking->total ?? 0)));
        let initialCouponId = @json($booking->coupon_id ?? null);

        // Use property prices from booking->property if available
        let pricePerNight = Number(@json($booking->property->price ?? 0));
        let priceWeekly = Number(@json($booking->property->weekly_price ?? 0));
        let priceMonthly = Number(@json($booking->property->monthly_price ?? 0));
        let bookingStartDate = @json($booking->property->rent_start ?? '');

        // booking id for update route usage if needed (we kept route in AJAX)
        const bookingId = @json($booking->id);

        // runtime / UI variables
        let bookedDates = []; // dates we will disable in datepickers (strings "YYYY-MM-DD")
        let minSelectableDate = bookingStartDate ? new Date(bookingStartDate) : new Date();
        let totalPrice = initialTotal;
        let discountedPrice = initialDiscounted;
        let couponId = initialCouponId;

        let rentDatePicker, weeklyDatePicker, monthlyDatePicker;

        // Helper: format Date -> YYYY-MM-DD
        function formatDateObj(d) {
            if (!d) return '';
            const date = new Date(d);
            return date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);
        }
        function formatDateString(date) {
            // accept Date or string parseable by Date
            if (!date) return '';
            const d = new Date(date);
            return formatDateObj(d);
        }

        // Helper: produce array of YYYY-MM-DD between two dates inclusive
        function datesBetween(startStr, endStr) {
            if (!startStr || !endStr) return [];
            const start = new Date(startStr);
            const end = new Date(endStr);
            const arr = [];
            for (let dt = new Date(start); dt <= end; dt.setDate(dt.getDate() + 1)) {
                arr.push(formatDateObj(new Date(dt)));
            }
            return arr;
        }

        // Remove current booking's own dates from server-supplied bookedDates so edit keeps its dates
        function excludeCurrentBookingRange(disabledArray) {
            if (!initialStart || !initialEnd) return disabledArray;
            const currentRange = datesBetween(initialStart, initialEnd);
            return disabledArray.filter(d => currentRange.indexOf(d) === -1);
        }

        // --- Build dynamic tabs & sections, then init sections ---
        function buildTabsAndSections() {
            // --- Build tabs dynamically ---
            let tabsHtml = '<ul class="nav nav-tabs mb-3 border-0 booking-navs">';
            if (pricePerNight) tabsHtml += `<li class="nav-item mb-2"><button type="button" class="nav-link" data-type="per-night">Per Night</button></li>`;
            if (priceWeekly) tabsHtml += `<li class="nav-item"><button type="button" class="nav-link ${pricePerNight ? '' : 'active'}" data-type="weekly">Weekly</button></li>`;
            if (priceMonthly) tabsHtml += `<li class="nav-item"><button type="button" class="nav-link ${!pricePerNight && !priceWeekly ? 'active' : ''}" data-type="monthly">Monthly</button></li>`;
            tabsHtml += '</ul>';
            $('#bookingTabsContainer').html(tabsHtml);

            // --- Build sections dynamically ---
            let sectionsHtml = '';
            if (pricePerNight) {
                sectionsHtml += `<div class="booking-section" id="section-per-night">
                    <label class="form-label fw-semibold">Select Per-Night Dates</label>
                    <input type="text" id="rentDateRange" class="form-control" readonly>
                    <div class="d-flex justify-content-between mt-2"><span class="fw-semibold">Total:</span> <span class="fw-bold text-primary" id="totalPricePerNight">0 BDT</span></div>
                </div>`;
            }
            if (priceWeekly) {
                sectionsHtml += `<div class="booking-section ${pricePerNight ? 'd-none' : ''}" id="section-weekly">
                    <label class="form-label fw-semibold">Select Weekly Dates</label>
                    <input type="text" id="weeklyDateRange" class="form-control" readonly>
                    <small class="text-danger d-none" id="weeklyError">Please select full weekly dates (multiples of 7 days).</small>
                    <div class="d-flex justify-content-between mt-2"><span class="fw-semibold">Total:</span> <span class="fw-bold text-primary" id="totalPriceWeekly">0 BDT</span></div>
                </div>`;
            }
            if (priceMonthly) {
                sectionsHtml += `<div class="booking-section ${!pricePerNight && !priceWeekly ? '' : 'd-none'}" id="section-monthly">
                    <label class="form-label fw-semibold">Select Monthly Dates</label>
                    <input type="text" id="monthlyDateRange" class="form-control" readonly>
                    <small class="text-danger d-none" id="monthlyError">Please select a full month range.</small>
                    <div class="d-flex justify-content-between mt-2"><span class="fw-semibold">Total:</span> <span class="fw-bold text-primary" id="totalPriceMonthly">0 BDT</span></div>
                </div>`;
            }
            $('#bookingSectionsContainer').html(sectionsHtml);

            // Set hidden booking type
            $('#hiddenBookingType').val(bookingType);

            // --- Initialize sections & pickers ---
            initBookingSections();

            // --- Activate correct tab and show saved dates ---
            setActiveTabFromBookingType();
        }

        // Set active tab and show corresponding section based on bookingType
        function setActiveTabFromBookingType() {
            if (!bookingType) return;
            const tabBtn = $('.booking-navs button[data-type="' + bookingType + '"]');
            if (tabBtn.length) {
                $('.booking-navs button').removeClass('active');
                tabBtn.addClass('active');
                $('.booking-section').addClass('d-none');
                $('#section-' + bookingType.replace('_','-')).removeClass('d-none'); // id: section-per-night etc
                // <-- ADD THIS BLOCK BELOW -->
                if (bookingType === 'per-night' && rentDatePicker) {
                    rentDatePicker.setDate([initialStart, initialEnd], true);
                }
                if (bookingType === 'weekly' && weeklyDatePicker) {
                    weeklyDatePicker.setDate([initialStart, initialEnd], true);
                }
                if (bookingType === 'monthly' && monthlyDatePicker) {
                    monthlyDatePicker.setDate([initialStart, initialEnd], true);
                }

                // show relevant total display
                if (bookingType === 'per-night') $('#totalPricePerNight').text((discountedPrice || totalPrice).toLocaleString() + ' BDT');
                if (bookingType === 'weekly') $('#totalPriceWeekly').text((discountedPrice || totalPrice).toLocaleString() + ' BDT');
                if (bookingType === 'monthly') $('#totalPriceMonthly').text((discountedPrice || totalPrice).toLocaleString() + ' BDT');
            } else {
                // fallback: activate first tab
                $('.booking-navs button').first().addClass('active');
                $('.booking-section').first().removeClass('d-none');
            }
        }

        // Update visible price UI elements & hidden inputs
        function updatePricesUI() {
            $('#hiddenTotalPrice').val(totalPrice);
            $('#hiddenDiscountedPrice').val(discountedPrice);
            $('#hiddenCouponId').val(couponId || '');
            let displayPrice = (discountedPrice && discountedPrice > 0) ? discountedPrice : totalPrice;

            if ($('#section-per-night').is(':visible')) $('#totalPricePerNight').text(displayPrice.toLocaleString() + ' BDT');
            if ($('#section-weekly').is(':visible')) $('#totalPriceWeekly').text(displayPrice.toLocaleString() + ' BDT');
            if ($('#section-monthly').is(':visible')) $('#totalPriceMonthly').text(displayPrice.toLocaleString() + ' BDT');

            // also update the small summary total if you have one
            $('#totalPrice').text(displayPrice.toLocaleString() + ' BDT');
        }

        function initBookingSections() {
            // convert saved dates to Date objects
            let initialStartDate = initialStart ? new Date(initialStart) : null;
            let initialEndDate = initialEnd ? new Date(initialEnd) : null;

            // --- Tab click logic ---
            $(document).off('click', '.booking-navs button').on('click', '.booking-navs button', function () {
                const type = $(this).data('type');
                $('.booking-section').addClass('d-none');
                $('#section-' + type).removeClass('d-none');
                $('.booking-navs button').removeClass('active');
                $(this).addClass('active');

                // Reset hidden fields
                $('#hiddenStartDate').val('');
                $('#hiddenEndDate').val('');
                $('#hiddenTotalPrice').val('0');
                $('#hiddenDiscountedPrice').val('0');
                $('#hiddenCouponId').val('');
                $('#hiddenBookingType').val(type);

                // Reset total display
                if (type === 'per-night') $('#totalPricePerNight').text('0 BDT');
                if (type === 'weekly') $('#totalPriceWeekly').text('0 BDT');
                if (type === 'monthly') $('#totalPriceMonthly').text('0 BDT');
            });

            // --- PER NIGHT Picker ---
            if (pricePerNight && $('#section-per-night').length) {
                rentDatePicker = flatpickr("#rentDateRange", {
                    mode: "range",
                    minDate: minSelectableDate,
                    disable: bookedDates,
                    dateFormat: "Y-m-d",
                    defaultDate: null, // don't rely on defaultDate
                    onChange: function (selectedDates) {
                        let total = 0;
                        if (selectedDates.length === 2) {
                            const diffDays = Math.ceil((selectedDates[1] - selectedDates[0]) / (1000 * 60 * 60 * 24));
                            total = diffDays * pricePerNight;
                            $('#hiddenStartDate').val(formatDateObj(selectedDates[0]));
                            $('#hiddenEndDate').val(formatDateObj(selectedDates[1]));
                        } else {
                            $('#hiddenStartDate').val('');
                            $('#hiddenEndDate').val('');
                        }
                        totalPrice = total;
                        discountedPrice = total;
                        couponId = null;
                        updatePricesUI();
                    }
                });

                // --- SET SAVED DATES AFTER INITIALIZATION ---
                if (initialStartDate && initialEndDate) {
                    rentDatePicker.setDate([initialStartDate, initialEndDate], true); // true = trigger onChange
                }
            }


            // --- WEEKLY Picker ---
            if (priceWeekly && $('#section-weekly').length) {
                const weeklyError = $('#weeklyError');
                weeklyDatePicker = flatpickr("#weeklyDateRange", {
                    mode: "range",
                    minDate: minSelectableDate,
                    disable: bookedDates,
                    dateFormat: "Y-m-d",
                    defaultDate: initialStartDate && initialEndDate ? [initialStartDate, initialEndDate] : null,
                    onChange: function (selectedDates) {
                        weeklyError.text('').addClass('d-none');
                        let total = 0;
                        if (selectedDates.length === 2) {
                            const diffDays = Math.ceil((selectedDates[1] - selectedDates[0]) / (1000 * 60 * 60 * 24));
                            if (diffDays % 7 !== 0) {
                                weeklyError.text("Please select exact weekly dates (7, 14, 21...).").removeClass('d-none');
                                $('#totalPriceWeekly').text('0 BDT');
                                $('#hiddenStartDate').val('');
                                $('#hiddenEndDate').val('');
                                return;
                            }
                            total = (diffDays / 7) * priceWeekly;
                            $('#hiddenStartDate').val(formatDateObj(selectedDates[0]));
                            $('#hiddenEndDate').val(formatDateObj(selectedDates[1]));
                        } else {
                            $('#hiddenStartDate').val('');
                            $('#hiddenEndDate').val('');
                        }
                        totalPrice = total;
                        discountedPrice = total;
                        couponId = null;
                        updatePricesUI();
                    }
                });
            }

            // --- MONTHLY Picker ---
            if (priceMonthly && $('#section-monthly').length) {
                const monthlyError = $('#monthlyError');
                monthlyDatePicker = flatpickr("#monthlyDateRange", {
                    mode: "range",
                    minDate: minSelectableDate,
                    disable: bookedDates,
                    dateFormat: "Y-m-d",
                    defaultDate: initialStartDate && initialEndDate ? [initialStartDate, initialEndDate] : null,
                    onChange: function (selectedDates) {
                        monthlyError.text('').addClass('d-none');
                        let total = 0;
                        if (selectedDates.length === 2) {
                            const start = selectedDates[0];
                            const end = selectedDates[1];
                            const lastDay = new Date(end.getFullYear(), end.getMonth() + 1, 0).getDate();
                            if (start.getDate() !== 1) {
                                monthlyError.text("Start date must be the 1st of the month.").removeClass('d-none');
                                $('#totalPriceMonthly').text('0 BDT');
                                $('#hiddenStartDate').val('');
                                $('#hiddenEndDate').val('');
                                return;
                            }
                            if (end.getDate() !== lastDay) {
                                monthlyError.text("End date must be the last day of the month.").removeClass('d-none');
                                $('#totalPriceMonthly').text('0 BDT');
                                $('#hiddenStartDate').val('');
                                $('#hiddenEndDate').val('');
                                return;
                            }
                            const months = (end.getFullYear() - start.getFullYear()) * 12 + (end.getMonth() - start.getMonth()) + 1;
                            total = months * priceMonthly;
                            $('#hiddenStartDate').val(formatDateObj(start));
                            $('#hiddenEndDate').val(formatDateObj(end));
                        } else {
                            $('#hiddenStartDate').val('');
                            $('#hiddenEndDate').val('');
                        }
                        totalPrice = total;
                        discountedPrice = total;
                        couponId = null;
                        updatePricesUI();
                    }
                });
            }
        }

        // --- Fetch booked dates for initially selected property on page load and remove current booking's dates ---
        function fetchPropertyBookedDates(propertyId, doneCallback) {
            if (!propertyId) {
                bookedDates = [];
                doneCallback && doneCallback();
                return;
            }
            $.get("{{ route('admin.bookings.propertyDates', ':id') }}".replace(':id', propertyId), function (res) {
                let serverBooked = res.bookedDates || [];
                // Remove the current booking's dates from serverBooked so edit can keep its own range
                serverBooked = excludeCurrentBookingRange(serverBooked);
                bookedDates = serverBooked;
                // Update minimum selectable date if property has different rent_start
                if (res.rent_start) bookingStartDate = res.rent_start;
                if (res.price) pricePerNight = parseFloat(res.price) || pricePerNight;
                if (res.weekly_price) priceWeekly = parseFloat(res.weekly_price) || priceWeekly;
                if (res.monthly_price) priceMonthly = parseFloat(res.monthly_price) || priceMonthly;
                doneCallback && doneCallback();
            }).fail(function () {
                // fallback: no disable list
                bookedDates = [];
                doneCallback && doneCallback();
            });
        }

        // --- On property change: re-fetch dates/prices and rebuild sections to reflect property prices ---
        $('#propertySelect').on('change', function () {
            const id = $(this).val();
            if (!id) return;
            const option = $(this).find(':selected');
            $('#propertyName').text(option.text());
            $('#propertyImage').attr('src', option.data('image') || $('#propertyImage').attr('src'));
            $('#propertyLocation').text((option.data('city') || '') + ', ' + (option.data('country') || ''));
            $('#propertyInfo').removeClass('d-none');

            fetchPropertyBookedDates(id, function () {
                // rebuild tabs/sections using updated prices & bookedDates
                buildTabsAndSections();
            });
        });

        // If propertySelect already chosen on edit page, trigger fetching bookedDates & build section
        const initialPropertyId = $('#propertySelect').val() || null;
        if (initialPropertyId) {
            fetchPropertyBookedDates(initialPropertyId, function () {
                buildTabsAndSections();
            });
        } else {
            // nothing selected, still build UI with whatever prices available
            buildTabsAndSections();
        }

        // --- Pre-fill user selection fields if userSelect is present (maintain your existing behavior) ---
        $('#userSelect').on('change', function () {
            const user = $(this).find(':selected');
            $('#userName').val(user.data('name') || '');
            $('#userEmail').val(user.data('email') || '');
            $('#userPhone').val(user.data('phone') || '');
            $('#userAddress').val(user.data('address') || '');
            $('#hiddenUserId').val(user.val());
        });
        // if a user is already selected in select, trigger fill once
        if ($('#userSelect').val()) $('#userSelect').trigger('change');

        // --- Coupon apply (same as create) ---
        $('#applyCoupon').on('click', function () {
            const code = $('#couponCode').val().trim();
            if (!code) { toastr.error('Please enter a coupon code'); return; }
            let currentTotal = Number($('#hiddenTotalPrice').val()) || totalPrice;
            if (currentTotal <= 0) { toastr.error('Please select dates first'); return; }

            $.ajax({
                url: "{{ route('admin.coupon.apply') }}",
                method: "POST",
                data: { code: code, total_price: currentTotal, _token: "{{ csrf_token() }}" },
                success: function (res) {
                    if (res.valid) {
                        toastr.success(res.message);
                        couponId = res.coupon_id;
                        discountedPrice = res.discounted_price;
                        // ensure hidden inputs reflect coupon
                        $('#hiddenDiscountedPrice').val(discountedPrice);
                        $('#hiddenCouponId').val(couponId);
                        updatePricesUI();
                    } else {
                        toastr.error(res.message);
                        couponId = null;
                        discountedPrice = totalPrice;
                        $('#hiddenDiscountedPrice').val(discountedPrice);
                        $('#hiddenCouponId').val('');
                        updatePricesUI();
                    }
                },
                error: function () {
                    toastr.error('Something went wrong while applying coupon');
                }
            });
        });

        // --- Payment option UI logic (same as create) ---
        $(document).on('change', '.payment-option', function () {
            $('.payment-info').addClass('d-none').find('input').prop('disabled', true);
            const infoDiv = $(this).closest('.form-check').find('.payment-info');
            infoDiv.removeClass('d-none').find('input').prop('disabled', false);
            $('.payment-info').not(infoDiv).find('input').val('');
        });
        $('.payment-info.d-none input').prop('disabled', true);

        // If on load a payment method is checked, show its inputs
        const checkedPayment = $('input[name="payment_method"]:checked');
        if (checkedPayment.length) {
            checkedPayment.trigger('change');
        }

        // --- Submit Edit Form via AJAX (same as your existing edit handler) ---
        $('#checkoutFormEdit').on('submit', function (e) {
            e.preventDefault();
            const loader = $('#formLoaderbooking');
            loader.removeClass('d-none');
            const formData = new FormData(this);

            // Disable unused payment inputs before send
            const selectedPayment = $('input[name="payment_method"]:checked');
            if (selectedPayment.length) {
                $('#paymentMethods .form-check').each(function () {
                    if (!$(this).find('input[name="payment_method"]').is(':checked')) {
                        $(this).find('input').prop('disabled', true);
                    }
                });
            }

            $.ajax({
                url: "{{ route('admin.bookings.update', $booking->id) }}",
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    toastr.info('Updating booking...');
                },
                success: function (res) {
                    loader.addClass('d-none');
                    toastr.clear();
                    toastr.success(res.message);
                    setTimeout(() => window.location.href = "{{ route('booking.pending') }}", 1000);
                },
                error: function (xhr) {
                    loader.addClass('d-none');
                    toastr.clear();
                    if (xhr.status === 422) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function (key, val) {
                                toastr.error(val[0]);
                            });
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
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
