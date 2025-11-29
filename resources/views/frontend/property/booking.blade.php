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
                        <input type="hidden" id="hiddenBookingType" value="{{ $bookingType }}">
                        <input type="hidden" name="total_price" id="hiddenTotalPrice" value="0">
                        <input type="hidden" name="discounted_price" id="hiddenDiscountedPrice" value="0">
                        <input type="hidden" name="coupon_id" id="hiddenCouponId" value="">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name ?? '' }}"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="{{ Auth::user()->email ?? '' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" class="form-control" name="phone"
                                value="{{ Auth::user()->phone ?? '' }}" readonly>
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

                        {{-- <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-regular fa-calendar"></i> Booking
                                Dates</label>
                            <input type="text" id="rentDateRange" class="form-control" placeholder="Select Booking Dates"
                                readonly>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-semibold">Total Price:</span>
                            <span class="fw-bold text-primary" id="totalPrice">0 BDT</span>
                        </div> --}}

                        <!-- TABS -->
                        <ul class="nav nav-tabs mb-3 border-0 booking-navs" id="bookingTabs">
                            @if ($property->price)
                                <li class="nav-item mb-2">
                                    <button type="button" class="nav-link" data-type="per-night">Per Night</button>
                                </li>
                            @endif

                            @if ($property->weekly_price)
                                <li class="nav-item">
                                    <button type="button" class="nav-link" data-type="weekly">Weekly</button>
                                </li>
                            @endif

                            @if ($property->monthly_price)
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
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Coupon Code</label>
                            <div class="input-group">
                                <input type="text" id="couponCode" class="form-control"
                                    placeholder="Enter coupon code">
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
                                        <input type="hidden" name="payment_method_type"
                                            value="{{ $payment->payment_method_type }}" id="">
                                        @if ($payment->payment_method_type == 'mobile_banking')
                                            <p> Please Send Total Money to number given below and Provide the correct
                                                Transaction Id carefully. Othewise your booking won't be accepted . </p>
                                            {{-- Pass the copy icon as a reference to the JavaScript function --}}
                                            <p>Number : <b> {{ $payment->account_number }} </b> <span class="copy-icon"
                                                    onclick="copyText(this)"> <i class="fa-solid fa-copy"></i> </span></p>
                                            Transaction ID: <input type="text" name="transaction_id"
                                                class="form-control mt-1">
                                        @else
                                            <p> Please Send Total Money to the Bank Account number given below and Provide
                                                the correct Account Details carefully. Othewise your booking won't be
                                                accepted . </p>
                                            {{-- Pass the copy icon as a reference to the JavaScript function --}}
                                            <p>Account Number :<b> {{ $payment->account_number }} </b> <span
                                                    class="copy-icon" onclick="copyText(this)"> <i
                                                        class="fa-solid fa-copy"></i> </span> </p>
                                            <p>Account Name :<b> {{ $payment->account_name }} </b> <span class="copy-icon"
                                                    onclick="copyText(this)"> <i class="fa-solid fa-copy"></i> </span>
                                            </p>
                                            <p>Brach Name :<b> {{ $payment->branch_name }} </b> <span class="copy-icon"
                                                    onclick="copyText(this)"> <i class="fa-solid fa-copy"></i> </span>
                                            </p>
                                            Your Account Number: <input type="number" name="bank_account_number"
                                                class="form-control mt-1">
                                            Your Account Name: <input type="text" name="bank_account_name"
                                                class="form-control mt-1">
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

            // ---------- CONFIG ----------
    // ---------- CONFIG ----------
    const nightlyPrice = {{ $property->price ?? 0 }};
    const weeklyPrice = {{ $property->weekly_price ?? 0 }};
    const monthlyPrice = {{ $property->monthly_price ?? 0 }};

    let bookingType = $('#hiddenBookingType').val() || 'per-night';
    let currentTotal = 0;

    if(!$('#hiddenBookingType').attr('name')){
        $('#hiddenBookingType').attr('name','booking_type');
    }

    const bookedDates = @json($bookedDates);
    const bookingStartDate = "{{ $property->rent_start }}";
    const today = new Date().toISOString().split('T')[0];
    const minSelectableDate = (bookingStartDate && bookingStartDate < today) ? today : bookingStartDate || today;

    // ---------- UTILITIES ----------
    function formatLocalDate(date){
        const y = date.getFullYear();
        const m = String(date.getMonth()+1).padStart(2,'0');
        const d = String(date.getDate()).padStart(2,'0');
        return `${y}-${m}-${d}`;
    }

    function updateTotals(type, start, end){
    if(!start || !end){
        $('#hiddenTotalPrice').val(0);
        $('#hiddenDiscountedPrice').val(0);
        currentTotal = 0;
        return 0;
    }

    let total = 0;
    const diffMs = end - start;
    const diffDays = Math.ceil(diffMs / (1000*60*60*24));

    if(type === 'per-night'){
        total = diffDays * nightlyPrice;
        $('#totalPricePerNight').text(total.toLocaleString() + ' BDT');
        $('#weeklyError, #monthlyError').addClass('d-none'); // hide other errors
    }
    else if(type === 'weekly'){
        const weeklyError = $('#weeklyError');
        if(diffDays % 7 !== 0){
            weeklyError.text("Please select exact weekly dates (7, 14, 21...)").removeClass('d-none');
            $('#totalPriceWeekly').text('0 BDT');
            $('#hiddenTotalPrice').val(0);
            $('#hiddenDiscountedPrice').val(0); // reset discounted price
            currentTotal = 0;
            return 0;
        }
        weeklyError.addClass('d-none');
        total = (diffDays/7) * weeklyPrice;
        $('#totalPriceWeekly').text(total.toLocaleString() + ' BDT');
        $('#monthlyError').addClass('d-none'); // hide monthly error
    }
    else if(type === 'monthly'){
        const monthlyError = $('#monthlyError');
        const lastDayOfEndMonth = new Date(end.getFullYear(), end.getMonth()+1, 0).getDate();
        if(start.getDate() !== 1 || end.getDate() !== lastDayOfEndMonth){
            monthlyError.text("Please select full month dates (start on 1st, end on last day)").removeClass('d-none');
            $('#totalPriceMonthly').text('0 BDT');
            $('#hiddenTotalPrice').val(0);
            $('#hiddenDiscountedPrice').val(0); // reset discounted price
            currentTotal = 0;
            return 0;
        }
        monthlyError.addClass('d-none');
        const months = (end.getFullYear()-start.getFullYear())*12 + (end.getMonth()-start.getMonth()) + 1;
        total = months * monthlyPrice;
        $('#totalPriceMonthly').text(total.toLocaleString() + ' BDT');
        $('#weeklyError').addClass('d-none'); // hide weekly error
    }

    // Update hidden inputs
    $('#hiddenStartDate').val(formatLocalDate(start));
    $('#hiddenEndDate').val(formatLocalDate(end));
    $('#hiddenTotalPrice').val(total);
    $('#hiddenDiscountedPrice').val(total); // always sync discounted price with current valid total
    currentTotal = total;

    return total;
}


    function resetCoupon(){
        $('#couponCode').val('');
        $('#hiddenCouponId').val('');
        $('#hiddenDiscountedPrice').val(currentTotal);
    }

    // ---------- FLATPICKR ----------
    function initFlatpickr(selector, type){
        flatpickr(selector,{
            mode:"range",
            dateFormat:"Y-m-d",
            minDate:minSelectableDate,
            disable: bookedDates,
            defaultDate: ($('#hiddenStartDate').val() && $('#hiddenEndDate').val()) ? 
                         [$('#hiddenStartDate').val(), $('#hiddenEndDate').val()] : null,
            onClose:function(selectedDates){
                if(selectedDates.length === 2){
                    updateTotals(type, selectedDates[0], selectedDates[1]);
                } else {
                    $('#hiddenTotalPrice').val(0);
                    $('#hiddenDiscountedPrice').val(0);
                }
            },
            onReady:function(selectedDates){
                if(selectedDates && selectedDates.length === 2){
                    updateTotals(type, selectedDates[0], selectedDates[1]);
                }
            }
        });
    }

    initFlatpickr("#rentDateRange",'per-night');
    initFlatpickr("#weeklyDateRange",'weekly');
    initFlatpickr("#monthlyDateRange",'monthly');

    // ---------- TAB HANDLING ----------
    function setActiveTab(type){
        bookingType = type;
        $('#hiddenBookingType').val(type);

        $('#bookingTabs .nav-link').removeClass('active');
        $(`#bookingTabs .nav-link[data-type="${type}"]`).addClass('active');

        $('.booking-section').addClass('d-none');
        $(`#section-${type}`).removeClass('d-none');

        // Recompute total for current tab
        let inputSelector = type==='per-night' ? '#rentDateRange' : type==='weekly' ? '#weeklyDateRange' : '#monthlyDateRange';
        const dates = $(inputSelector).val();
        if(dates && dates.includes(' to ')){
            const [s,e] = dates.split(' to ').map(d=>new Date(d));
            updateTotals(type, s, e);
        } else {
            $('#hiddenTotalPrice').val(0);
            $('#hiddenDiscountedPrice').val(0);
        }

        resetCoupon(); // reset coupon when switching tab
    }

    $('#bookingTabs .nav-link').on('click',function(){
        setActiveTab($(this).data('type'));
    });

    // ---------- COUPON ----------
    $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    $('#applyCoupon').on('click', function(){
        const code = $('#couponCode').val().trim();
        if(!code){ toastr.error('Please enter a coupon code'); return; }

        $.ajax({
            url:"{{ route('coupon.apply') }}",
            method:'POST',
            data:{code:code,total_price:currentTotal},
            success:function(res){
                if(res.valid){
                    toastr.success(res.message);
                    $('#hiddenDiscountedPrice').val(res.discounted_price);
                    $('#hiddenCouponId').val(res.coupon_id);
                    if(bookingType==='per-night') $('#totalPricePerNight').text(res.discounted_price.toLocaleString() + ' BDT');
                    else if(bookingType==='weekly') $('#totalPriceWeekly').text(res.discounted_price.toLocaleString() + ' BDT');
                    else $('#totalPriceMonthly').text(res.discounted_price.toLocaleString() + ' BDT');
                } else {
                    toastr.error(res.message);
                    $('#hiddenDiscountedPrice').val(currentTotal);
                    $('#hiddenCouponId').val('');
                }
            },
            error:function(){ toastr.error('Something went wrong while applying coupon'); }
        });
    });

    // ---------- PAYMENT TOGGLE ----------
    $(document).on('change','.payment-option',function(){
        $('.payment-info').addClass('d-none').find('input,textarea').prop('disabled',true);
        let infoDiv = $(this).closest('.form-check').find('.payment-info');
        infoDiv.removeClass('d-none').find('input,textarea').prop('disabled',false);
        $('.payment-info').not(infoDiv).find('input,textarea').val('');
    });
    $('.payment-info.d-none input, .payment-info.d-none textarea').prop('disabled',true);


    // ---------- INITIAL TAB ----------
    setActiveTab(bookingType);

            // ---------- FORM SUBMIT ----------
            $("#checkoutForm").on("submit", function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                let selectedPayment = $('input[name="payment_method"]:checked');
                if (selectedPayment.length) {
                    $("#paymentMethods .form-check").each(function() {
                        if (!$(this).find('input[name="payment_method"]').is(":checked")) {
                            $(this).find("input").prop("disabled", true);
                        }
                    });
                }

                const loader = $("#formLoaderbooking");
                loader.removeClass("d-none");

                $.ajax({
                    url: "{{ route('booking.store') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,

                    success: function(res) {
                        loader.addClass("d-none");
                        toastr.success(res.message);
                        setTimeout(() => window.location.href =
                            "{{ route('user.dashboard') }}", 1000);
                    },

                    error: function(xhr) {
                        loader.addClass("d-none");

                        if (xhr.status === 422) {
                            let res = xhr.responseJSON;

                            // 1. Laravel validation errors (array)
                            if (res.errors) {
                                $.each(res.errors, function(key, val) {
                                    toastr.error(val[0]);
                                });
                            }

                            // 2. Custom message errors
                            if (res.message) {
                                toastr.error(res.message);
                            }

                        } else {
                            toastr.error("Something went wrong");
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
