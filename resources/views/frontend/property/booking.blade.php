@extends('frontend.master')

@section('title')
{{ $property->name }}
@endsection

@section('content')
<div class="pagesheader" style="height: 100px"></div>
<div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > Property > {{ $property->name }} > Booking</p>
        </div>
    </div>
<div class="container my-5">
    <div class="row g-4">
        <!-- LEFT SIDE — USER & BOOKING DETAILS -->
        <div class="col-lg-7">
            <div class="card shadow-sm p-4">
                <h4 class="mb-3 fw-bold">Guest Information</h4>

                <form id="checkoutForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name ?? '' }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" value="{{ Auth::user()->email ?? '' }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->phone ?? '' }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address</label>
                        <input type="text" class="form-control" name="address" placeholder="Enter your address" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Total Guests</label>
                        <input type="number" min="1" class="form-control" name="total_guests" placeholder="Number of guests" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Notes</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Any additional information"></textarea>
                    </div>
                </form>
            </div>
        </div>

        <!-- RIGHT SIDE — PROPERTY & PAYMENT -->
        <div class="col-lg-5">
            <div class="card shadow-sm p-4 mb-4">
                <h4 class="fw-bold mb-3">Your Booking</h4>

                <div class="d-flex mb-3 align-items-center">
                    <img src="{{ asset('storage/' . $property->featured_image) }}" alt="{{ $property->title }}" class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                    <div>
                        <h6 class="fw-semibold mb-1">{{ $property->title }}</h6>
                        <p class="text-muted small mb-0">{{ $property->city }}, {{ $property->country->name }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fa-regular fa-calendar"></i> Booking Dates</label>
                    <input type="text" id="rentDateRange" class="form-control" placeholder="Select Booking Dates" readonly>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span class="fw-semibold">Total Price:</span>
                    <span class="fw-bold text-primary" id="totalPrice">0 BDT</span>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Coupon Code</label>
                    <div class="input-group">
                        <input type="text" id="couponCode" class="form-control" placeholder="Enter coupon code">
                        <button class="btn btn-outline-primary" type="button" id="applyCoupon">Apply</button>
                    </div>
                </div>
            </div>

            <!-- PAYMENT OPTIONS -->
            <div class="card shadow-sm p-4">
                <h4 class="fw-bold mb-3">Payment Method</h4>

                <div class="form-check mb-2">
                    <input class="form-check-input payment-option" type="radio" name="payment_method" id="bkash" value="Bkash">
                    <label class="form-check-label fw-semibold" for="bkash">Bkash</label>
                    <div class="payment-info mt-2 p-3 bg-light rounded small d-none">
                        Send payment to <strong>017XXXXXXXX</strong> (Bkash Personal).  
                        After payment, please note the transaction ID.
                    </div>
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input payment-option" type="radio" name="payment_method" id="nagad" value="Nagad">
                    <label class="form-check-label fw-semibold" for="nagad">Nagad</label>
                    <div class="payment-info mt-2 p-3 bg-light rounded small d-none">
                        Send payment to <strong>018XXXXXXXX</strong> (Nagad Personal).  
                        Save your transaction ID.
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input payment-option" type="radio" name="payment_method" id="bank" value="Bank">
                    <label class="form-check-label fw-semibold" for="bank">Bank Transfer</label>
                    <div class="payment-info mt-2 p-3 bg-light rounded small d-none">
                        Account Name: <strong>Softdivz Ltd.</strong><br>
                        Account No: <strong>1234-5678-9012</strong><br>
                        Bank: <strong>Sonali Bank</strong>
                    </div>
                </div>

                <button class="btn btn-primary w-100">Confirm Booking</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('customJs')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const bookedDates = @json($bookedDates);
    const pricePerDay = {{ $property->price_per_day ?? 0 }};
    const totalPriceEl = document.getElementById('totalPrice');
    const dateRangeInput = document.getElementById('rentDateRange');

    // ✅ Initialize Flatpickr with booked dates disabled
    flatpickr(dateRangeInput, {
        mode: "range",
        minDate: "today",
        dateFormat: "Y-m-d",
        disable: bookedDates,
        defaultDate: ["{{ $startDate }}", "{{ $endDate }}"],
        onChange: function (selectedDates) {
            if (selectedDates.length === 2) {
                const diffTime = Math.abs(selectedDates[1] - selectedDates[0]);
                const days = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                const total = days * pricePerDay;
                totalPriceEl.textContent = total + " BDT";
            }
        }
    });

    // ✅ Toggle payment info dropdowns
    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('change', function () {
            document.querySelectorAll('.payment-info').forEach(info => info.classList.add('d-none'));
            this.parentElement.querySelector('.payment-info').classList.remove('d-none');
        });
    });
});
</script>
@endsection