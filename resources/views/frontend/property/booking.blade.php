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
        <form id="checkoutForm">
            @csrf
            <div class="row g-4">
                <!-- LEFT SIDE — USER & BOOKING DETAILS -->
                <div class="col-lg-7">
                    <div class="card shadow-sm p-4">
                        <h4 class="mb-3 fw-bold">Guest Information</h4>


                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                        <input type="hidden" name="start_date" id="hiddenStartDate" value="{{ $startDate }}">
                        <input type="hidden" name="end_date" id="hiddenEndDate" value="{{ $endDate }}">
                        <input type="hidden" name="total_price" id="hiddenTotalPrice" value="0">
                        <input type="hidden" name="discounted_price" id="hiddenDiscountedPrice" value="0">
                        <input type="hidden" name="coupon_id" id="hiddenCouponId" value="">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name ?? '' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ Auth::user()->email ?? '' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone ?? '' }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Enter your address"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Total Guests</label>
                            <input type="number" min="1" class="form-control" name="total_guests"
                                placeholder="Number of guests" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea class="form-control" name="notes" rows="3" placeholder="Any additional information"></textarea>
                        </div>

                    </div>
                </div>

                <!-- RIGHT SIDE — PROPERTY & PAYMENT -->
                <div class="col-lg-5">
                    <div class="card shadow-sm p-4 mb-4">
                        <h4 class="fw-bold mb-3">Your Booking</h4>

                        <div class="d-flex mb-3 align-items-center">
                            <img src="{{ asset($property->featured_image) }}" alt="{{ $property->title }}"
                                class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                            <div>
                                <h6 class="fw-semibold mb-1">{{ $property->name }}</h6>
                                <p class="text-muted small mb-0">{{ $property->city }}, {{ $property->country->name }}</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-regular fa-calendar"></i> Booking
                                Dates</label>
                            <input type="text" id="rentDateRange" class="form-control" placeholder="Select Booking Dates"
                                readonly>
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

                        <div id="paymentMethods">
                            @foreach ($payments as $payment)
                                <div class="form-check mb-2">
                                    <input class="form-check-input payment-option" type="radio" name="payment_method"
                                        id="payment_{{ $payment->id }}" value="{{ $payment->id }}">
                                    <label class="form-check-label fw-semibold"
                                        for="payment_{{ $payment->id }}">{{ $payment->name }}</label>

                                    <div class="payment-info mt-2 p-3 bg-light rounded small d-none"
                                        id="paymentInfo_{{ $payment->id }}">
                                        <input type="hidden" name="payment_method_type" value="{{ $payment->payment_method_type }}" id="">
                                        @if ($payment->payment_method_type == 'mobile_banking')
                                            <p> Please Send Total Money to number given below and Provide the correct Transaction Id carefully. Othewise your booking won't be accepted .  </p>
                                            {{-- Pass the copy icon as a reference to the JavaScript function --}}
                                            <p>Number : <b> {{ $payment->account_number }} </b> <span class="copy-icon" onclick="copyText(this)"> <i class="fa-solid fa-copy"></i> </span></p>
                                            Transaction ID: <input type="text" name="transaction_id" class="form-control mt-1">
                                        @else
                                            <p> Please Send Total Money to the Bank Account number given below and Provide the correct Account Details carefully. Othewise your booking won't be accepted .  </p>
                                            {{-- Pass the copy icon as a reference to the JavaScript function --}}
                                            <p>Account Number :<b> {{ $payment->account_number }} </b> <span class="copy-icon" onclick="copyText(this)"> <i class="fa-solid fa-copy"></i> </span> </p>
                                            <p>Account Name :<b> {{ $payment->account_name }} </b> <span class="copy-icon" onclick="copyText(this)"> <i class="fa-solid fa-copy"></i> </span> </p>
                                            <p>Brach Name :<b> {{ $payment->branch_name }} </b> <span class="copy-icon" onclick="copyText(this)"> <i class="fa-solid fa-copy"></i> </span> </p>
                                            Your Account Number: <input type="number" name="bank_account_number" class="form-control mt-1" >
                                            Your Account Name: <input type="text" name="bank_account_name" class="form-control mt-1" >
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button class="btn btn-primary w-100 booking-confirm">Confirm Booking</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <div id="formLoaderbooking" class="form-loader booking d-none">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
@endsection

@section('customJs')
    <script>
$(document).ready(function() {

    const pricePerNight = {{ $property->price }};
    let startDate = $('#hiddenStartDate').val();
    let endDate = $('#hiddenEndDate').val();
    let totalPrice = 0;

    const bookedDates = @json($bookedDates); // Example: ["2025-10-25", "2025-10-26", "2025-11-01"]
    const bookingStartDate = "{{ $property->rent_start }}"; // e.g. "2025-10-23"

    // Initialize flatpickr or your datepicker
    flatpickr("#rentDateRange", {
        mode: "range",
        minDate: (function() {
            const today = new Date();
            const start = new Date(bookingStartDate);
            return start < today ? today : start;
        })(),
        dateFormat: "Y-m-d",
        disable: bookedDates,
        defaultDate: [startDate, endDate],
        onClose: function(selectedDates, dateStr, instance) {
            if(selectedDates.length === 2){
                startDate = selectedDates[0].toISOString().split('T')[0];
                endDate = selectedDates[1].toISOString().split('T')[0];
                $('#hiddenStartDate').val(startDate);
                $('#hiddenEndDate').val(endDate);
                calculateTotalPrice();
                $('#hiddenCouponId').val(''); // reset coupon
            }
        }
    });

    // Calculate total price
    function calculateTotalPrice() {
        if(startDate && endDate){
            let start = new Date(startDate);
            let end = new Date(endDate);
            let diffTime = Math.abs(end - start);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) || 1;
            totalPrice = diffDays * pricePerNight;
            $('#totalPrice').text(totalPrice + ' BDT');
            $('#hiddenTotalPrice').val(totalPrice);
            $('#hiddenDiscountedPrice').val(totalPrice); // initially same
        }
    }

    // Initial total price calculation on page load
    calculateTotalPrice();

    // Apply Coupon

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#applyCoupon').on('click', function(){
        let code = $('#couponCode').val().trim();
        if(!code){ 
            toastr.error('Please enter a coupon code'); 
            return; 
        }

        $.ajax({
            url: "{{ route('coupon.apply') }}",
            method: 'POST',
            data: {
                code: code,
                total_price: totalPrice
            },
            success: function(res){
                if(res.valid){
                    toastr.success(res.message);
                    $('#hiddenDiscountedPrice').val(res.discounted_price);
                    $('#hiddenCouponId').val(res.coupon_id);
                    $('#totalPrice').text(res.discounted_price + ' BDT');
                } else {
                    toastr.error(res.message);
                    $('#hiddenDiscountedPrice').val(totalPrice);
                    $('#hiddenCouponId').val('');
                    $('#totalPrice').text(totalPrice + ' BDT');
                }
            },
            error: function(xhr){
                toastr.error('Something went wrong while applying coupon');
            }
        });
    });

    // Show Payment Inputs
    $(document).on('change', '.payment-option', function(){
        // Hide all payment-info and disable their inputs
        $('.payment-info').addClass('d-none').find('input').prop('disabled', true);

        // Show the selected one and enable its inputs
        let infoDiv = $(this).closest('.form-check').find('.payment-info');
        infoDiv.removeClass('d-none').find('input').prop('disabled', false);

        // Clear values of hidden inputs
        $('.payment-info').not(infoDiv).find('input').val('');
    });

    // On page load, disable all hidden payment inputs (for safety)
    $('.payment-info.d-none input').prop('disabled', true);


    // Submit Booking Form
    $('#checkoutForm').on('submit', function(e){
        e.preventDefault();
        let formData = new FormData(this);

        // Disable all non-selected payment fields
        let selectedPayment = $('input[name="payment_method"]:checked');
        if(selectedPayment.length){
            $('#paymentMethods .form-check').each(function(){
                if(!$(this).find('input[name="payment_method"]').is(':checked')){
                    $(this).find('input').prop('disabled', true);
                }
            });
        }
        const loader = document.getElementById('formLoaderbooking');
        loader.classList.remove('d-none');
        $.ajax({
            url: "{{ route('booking.store') }}",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function(){ toastr.info('Processing booking...'); },
            success: function(res){
                loader.classList.add('d-none');
                toastr.clear();
                toastr.success(res.message);
                setTimeout(() => window.location.href = "{{ route('user.dashboard') }}", 1000);
            },
            error: function(xhr){
                loader.classList.add('d-none');
                toastr.clear();

                if(xhr.status === 422){
                    if(xhr.responseJSON.errors){
                        // Validation errors
                        $.each(xhr.responseJSON.errors, function(key, val){
                            toastr.error(val[0]);
                        });
                    } else if(xhr.responseJSON.message){
                        // Custom errors
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
<script>
    function copyText(copyIconElement) {
    // 1. Get the parent <p> element of the copy icon
    // The structure is: <p>... <b>TEXT</b> <span class="copy-icon" onclick="copyText(this)">...</span></p>
    const parentParagraph = copyIconElement.parentNode;

    // 2. Find the <b> element inside the parent <p>
    const textElement = parentParagraph.querySelector('b');

    if (textElement) {
        // 3. Get the text content and use .trim() to remove whitespace
        const textToCopy = textElement.textContent.trim();

        // 4. Use the modern Clipboard API to copy the text
        navigator.clipboard.writeText(textToCopy).then(() => {
            // Optional: Provide visual feedback to the user
            console.log('Text successfully copied: ' + textToCopy);
            
            // Example of a quick visual change:
            // You might change the icon temporarily to a checkmark for success
            const originalIcon = copyIconElement.innerHTML;
            copyIconElement.innerHTML = '<i class="fa-solid fa-check"></i>'; // Change to a checkmark icon
            
            // Revert the icon back after a short delay
            setTimeout(() => {
                copyIconElement.innerHTML = originalIcon;
            }, 1000); 

        }).catch(err => {
            console.error('Could not copy text: ', err);
            // Fallback for older browsers or if the Clipboard API is not available/allowed
            fallbackCopyTextToClipboard(textToCopy);
        });
    }
}

// Optional: A fallback function for older browsers
function fallbackCopyTextToClipboard(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;
    
    // Avoid scrolling to bottom
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";

    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
        console.log('Fallback: Copying text command was ' + msg);
    } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
    }

    document.body.removeChild(textArea);
}
</script>
<script>
$(document).on('click', '.booking-confirm', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "You want to confirm this booking?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1f526b',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Confirm'
    }).then((result) => {
        if (result.isConfirmed) {
            // ✅ Submit the form after confirmation
            $('#checkoutForm').submit();
        }
    });
});
</script>
@endsection
