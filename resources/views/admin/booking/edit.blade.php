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
                            <input type="text" class="form-control" name="address" id="userAddress" value="{{ $booking->address }}">
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

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Booking Dates</label>
                                <input type="text" id="rentDateRange" class="form-control" placeholder="Select Dates" readonly>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-semibold">Total Price:</span>
                                <span class="fw-bold text-primary" id="totalPrice">{{ $booking->grand_total }} BDT</span>
                            </div>

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
$(document).ready(function() {
    // --- Use the actual property price for this booking ---
    let pricePerNight = {{ $booking->property->price ?? 0 }};
    let bookedDates = [];
    let bookingStartDate = "{{ $booking->property->rent_start ?? '' }}";
    let totalPrice = {{ $booking->total }};
    let discountedPrice = {{ $booking->grand_total }};
    let couponId = {{ $booking->coupon_id ?? 'null' }};

    // --- Property selection ---
    $('#propertySelect').on('change', function() {
        const id = $(this).val();
        if (!id) return;

        const option = $(this).find(':selected');
        $('#propertyName').text(option.text());
        $('#propertyImage').attr('src', option.data('image'));
        $('#propertyLocation').text(`${option.data('city')}, ${option.data('country')}`);
        $('#propertyInfo').removeClass('d-none');

        $.get("{{ route('admin.bookings.propertyDates', ':id') }}".replace(':id', id), function(res) {
            bookedDates = res.bookedDates;
            bookingStartDate = res.rent_start;
            pricePerNight = res.price; // ✅ Update price per night from AJAX
            initDatepicker();
        });
    });

    // --- Format date to YYYY-MM-DD (avoiding timezone issues) ---
    function formatDate(date) {
        const d = new Date(date.getTime());
        const year = d.getFullYear();
        const month = ('0' + (d.getMonth() + 1)).slice(-2);
        const day = ('0' + d.getDate()).slice(-2);
        return `${year}-${month}-${day}`;
    }

    function initDatepicker() {
        $('#propertyInfo').removeClass('d-none');

        setTimeout(function() {
            flatpickr("#rentDateRange", {
                mode: "range",
                minDate: (function() {
                    const today = new Date();
                    const start = new Date(bookingStartDate);
                    return start < today ? today : start;
                })(),
                disable: bookedDates,
                dateFormat: "Y-m-d",
                defaultDate: [
                    "{{ $booking->start_date }}",
                    "{{ $booking->end_date }}"
                ],
                onClose: function(selectedDates) {
                    if (selectedDates.length === 2) {
                        const start = selectedDates[0];
                        const end = selectedDates[1];

                        // ✅ Calculate number of nights correctly (inclusive)
                        const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));

                        // ✅ Calculate total using actual property price
                        totalPrice = days * pricePerNight;

                        // ✅ Set hidden inputs without timezone issues
                        $('#hiddenStartDate').val(formatDate(start));
                        $('#hiddenEndDate').val(formatDate(end));

                        $('#totalPrice').text(totalPrice + ' BDT');
                        $('#hiddenTotalPrice').val(totalPrice);
                        $('#hiddenDiscountedPrice').val(totalPrice);
                        $('#hiddenCouponId').val('');
                    }
                }
            });
        }, 50);
    }

    // --- Initialize on page load using actual property price ---
    initDatepicker();

    // --- User selection autofill ---
    $('#userSelect').on('change', function() {
        const user = $(this).find(':selected');
        $('#userName').val(user.data('name') || '');
        $('#userEmail').val(user.data('email') || '');
        $('#userPhone').val(user.data('phone') || '');
        $('#userAddress').val(user.data('address') || '');
        $('#hiddenUserId').val(user.val());
    });

    // --- Apply Coupon ---
    $('#applyCoupon').on('click', function() {
        const code = $('#couponCode').val().trim();
        if (!code) {
            toastr.error('Please enter a coupon code');
            return;
        }

        $.ajax({
            url: "{{ route('admin.coupon.apply') }}",
            method: 'POST',
            data: {
                code: code,
                total_price: totalPrice,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                if (res.valid) {
                    toastr.success(res.message);
                    discountedPrice = res.discounted_price;
                    couponId = res.coupon_id;

                    $('#hiddenDiscountedPrice').val(discountedPrice);
                    $('#hiddenCouponId').val(couponId);
                    $('#totalPrice').text(discountedPrice + ' BDT');
                } else {
                    toastr.error(res.message);
                }
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
    $('#checkoutFormEdit').on('submit', function(e) {
        e.preventDefault();
        const loader = $('#formLoaderbooking');
        loader.removeClass('d-none');

        const formData = new FormData(this);
        const selectedPayment = $('input[name="payment_method"]:checked');
        if (selectedPayment.length) {
            $('#paymentMethods .form-check').each(function() {
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
            beforeSend: function() {
                toastr.info('Updating booking...');
            },
            success: function(res) {
                loader.addClass('d-none');
                toastr.clear();
                toastr.success(res.message);
                setTimeout(() => window.location.href = "{{ route('booking.pending') }}", 1000);
            },
            error: function(xhr) {
                loader.addClass('d-none');
                toastr.clear();
                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(key, val) {
                        toastr.error(val[0]);
                    });
                } else {
                    toastr.error('Something went wrong. Please try again.');
                }
            }
        });
    });
});

</script>
@endsection
