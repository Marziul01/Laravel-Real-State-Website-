@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-6 mb-4 order-0">
                <div class="card contact-card">
                    <div class="d-flex align-items-start row">
                        <div class="col-md-6">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">Hello, Welcome again <span
                                        class="text-uppercase">{{ Auth::user()->name }}</span>! 🎉</h5>
                                <h6 class="text-secondary mb-3">
                                    @php
                                        use Carbon\Carbon;

                                        $now = Carbon::now();
                                        $hour = $now->format('H');

                                        if ($hour >= 3 && $hour < 12) {
                                            $greeting = 'Good Morning';
                                        } elseif ($hour >= 12 && $hour < 18) {
                                            $greeting = 'Good Afternoon';
                                        } elseif ($hour >= 18 && $hour < 20) {
                                            $greeting = 'Good Evening';
                                        } else {
                                            $greeting = 'Good Night';
                                        }
                                    @endphp

                                    <p>{{ $greeting }}. Today {{ $now->format('d F Y, l') }}</p>
                                </h6>
                                <a href="" class="btn btn-sm btn-outline-primary">View Profile</a>
                            </div>
                        </div>
                        <div class="col-md-6 text-center text-sm-left d-none d-md-block">
                            <div class="card-body pb-0 px-0 px-md-6">
                                <img src="{{ asset('admin-assets') }}/assets/img/illustrations/man.png" height="230px"
                                    class="scaleX-n1-rtl" alt="View Badge User" />
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card h-100 contact-card">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div>
                                        <p class="mb-0">All Time Booking</p>
                                        <h4 class="card-title ttoalsamount mb-0">{{ $allTimeBooking }} BDT
                                        </h4>
                                    </div>
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/chart-success.png"
                                            alt="chart success" class="rounded" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card h-100 contact-card">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div>
                                        <p class="mb-0">This Year Booking</p>
                                        <h4 class="card-title ttoalsamount mb-0">
                                           {{ $thisYearBooking }} BDT</h4>
                                    </div>
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/wallet-info.png"
                                            alt="wallet info" class="rounded" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card h-100 contact-card">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div>
                                        <p class="mb-0">This Months Booking</p>
                                        <h4 class="card-title ttoalsamount mb-0">{{ $thisMonthBooking }} BDT</h4>
                                    </div>
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/chart-success.png"
                                            alt="chart success" class="rounded" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card h-100 contact-card">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div>
                                        <p class="mb-0">Pending Bookings</p>
                                        <h4 class="card-title ttoalsamount mb-0">{{ $pendingBookings }}</h4>
                                    </div>
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/wallet-info.png"
                                            alt="wallet info" class="rounded" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-12 mb-3 mt-1">
                <div class="row">
                    <div class="col-md-3 col-6 mb-4">
                        <div class="card h-100 contact-card">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div>
                                        <p class="mb-0">Visited Bookings</p>
                                        <h4 class="card-title ttoalsamount mb-0">{{ $visitedBookings }}</h4>
                                    </div>
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/chart-success.png"
                                            alt="chart success" class="rounded" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="card h-100 contact-card">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div>
                                        <p class="mb-0">Canceled Bookings</p>
                                        <h4 class="card-title ttoalsamount mb-0"> {{ $cancelledBookings }} </h4>
                                    </div>
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/wallet-info.png"
                                            alt="wallet info" class="rounded" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="card h-100 contact-card">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div>
                                        <p class="mb-0">Rent Properties</p>
                                        <h4 class="card-title ttoalsamount mb-0"> {{ $rentProperties }} </h4>
                                    </div>
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/chart-success.png"
                                            alt="chart success" class="rounded" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="card h-100 contact-card">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div>
                                        <p class="mb-0">Buy Properties</p>
                                        <h4 class="card-title ttoalsamount mb-0">{{ $buyProperties }}</h4>
                                    </div>
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/wallet-info.png"
                                            alt="wallet info" class="rounded" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 order-0 mb-6">
                <div class="card contact-card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-1 me-2">Pending Bookings</h5>

                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="table-responsive text-nowrap">
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Property</th>
                                        <th>Booking Name</th>
                                        <th>Time</th>
                                        <th>Guests</th>
                                        <th>Phone</th>
                                        <th>Discount</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($bookings->isNotEmpty())
                                        @foreach ($bookings as $booking)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $booking->property->name }}</td>
                                                <td>{{ $booking->user->name ?? 'User Not Found' }}</td>

                                                <td>{{ Carbon::parse($booking->start_date)->format('d M, Y') }}
                                                    -to-
                                                    {{ Carbon::parse($booking->end_date)->format('d M, Y') }}
                                                </td>

                                                <td>{{ $booking->total_guests }}</td>
                                                <td>{{ $booking->user->phone ?? 'User Not Found' }}</td>
                                                <td>{{ number_format($booking->discount, 2) }}</td>
                                                <td>{{ number_format($booking->grand_total, 2) }}</td>

                                                <td>
                                                    <button class="btn btn-sm btn-info view-booking" data-id="{{ $booking->id }}">
                                                        <i class="bi bi-eye"></i> View
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9">No booking found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center flex-column align-items-center auth-success-modal">
                    <img src="{{ asset('admin-assets/img/double-check.gif') }}" width="25%" alt="">
                    <h5 class="modal-title text-center" id="successModalLabel">Success</h5>
                    <p id="successMessage" class="text-center">Login successful!</p>
                </div>
            </div>
        </div>
    </div>

    <div id="fullscreenLoader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">
        <div style="display:flex; justify-content:center; align-items:center; width:100%; height:100%;">
            <div class="loader-custom"></div>
        </div>
    </div>

        <!-- Booking Details Modal -->
<div class="modal fade" id="bookingDetailsModal" tabindex="-1" aria-labelledby="bookingDetailsLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="bookingDetailsLabel"><i class="bi bi-journal-text me-2"></i> Booking Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div id="booking-details-loader" class="text-center py-4 d-none">
          <div class="spinner-border text-primary" role="status"></div>
          <p class="mt-2">Loading booking details...</p>
        </div>

        <div id="booking-details-content" class="d-none">
          <div class="row">
            <div class="col-md-6">
              <h6 class="fw-bold text-muted mb-2">Customer Information</h6>
              <p><strong>Name:</strong> <span id="booking_name"></span></p>
              <p><strong>Phone:</strong> <span id="booking_phone"></span></p>
              <p><strong>Email:</strong> <span id="booking_email"></span></p>
              <p><strong>Address:</strong> <span id="booking_address"></span></p>
            </div>

            <div class="col-md-6">
              <h6 class="fw-bold text-muted mb-2">Property Information</h6>
              <p><strong>Property:</strong> <span id="property_name"></span></p>
              <p><strong>Dates:</strong> <span id="booking_dates"></span></p>
              <p><strong>Total Guests:</strong> <span id="booking_guests"></span></p>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-md-6">
              <h6 class="fw-bold text-muted mb-2">Payment Information</h6>
              <p><strong>Payment Method:</strong> <span id="payment_method"></span></p>
              <p><strong>Transaction ID:</strong> <span id="transaction_id"></span></p>
              <p><strong>Bank Account:</strong> <span id="bank_account"></span></p>
            </div>

            <div class="col-md-6">
              <h6 class="fw-bold text-muted mb-2">Amounts</h6>
              <p><strong>Total:</strong> ৳<span id="total"></span></p>
              <p><strong>Discount:</strong> ৳<span id="discount"></span></p>
              <p><strong>Grand Total:</strong> ৳<span id="grand_total"></span></p>
            </div>
          </div>

          <hr>
          <h6 class="fw-bold text-muted mb-2">Notes</h6>
          <p id="booking_notes" class="fst-italic"></p>
        </div>
      </div>
      @if ($access->booking == 3)
      <div class="modal-footer">
        <button id="pendingBookingBtn" class="btn btn-primary">Pending Booking</button>
        <button id="confirmBookingBtn" class="btn btn-primary">Confirm Booking</button>
        <button id="visitedBookingBtn" class="btn btn-success">Visited Booking</button>
        <button id="cancelBookingBtn" class="btn btn-danger">Cancel Booking</button>
      </div>
        @endif
    </div>
  </div>
</div>


@endsection

@section('scripts')
@if ($bookings->isNotEmpty())
<script>
    $('#myTable').DataTable({
        pageLength: 10, // default rows per page
        lengthMenu: [ [10, 50, 100], [10, 50, 100] ], // options in dropdown
       
    });
</script>
    
@endif
<script>
$(document).on('click', '.view-booking', function() {
    const bookingId = $(this).data('id');
    const modal = $('#bookingDetailsModal');
    const loader = $('#booking-details-loader');
    const content = $('#booking-details-content');

    loader.removeClass('d-none');
    content.addClass('d-none');
    modal.modal('show');

    $.ajax({
        url: `{{ route('booking.show', ':id') }}`.replace(':id', bookingId),
        method: 'GET',
        success: function(response) {
            loader.addClass('d-none');
            content.removeClass('d-none');

            $('#booking_name').text(response.name ?? 'N/A');
            $('#booking_phone').text(response.phone ?? 'N/A');
            $('#booking_email').text(response.email ?? 'N/A');
            $('#booking_address').text(response.address ?? 'N/A');
            $('#property_name').text(response.property?.name ?? 'N/A');
            $('#booking_dates').text(`${response.start_date} to ${response.end_date}`);
            $('#booking_guests').text(response.total_guests ?? 'N/A');
            $('#payment_method').text(response.payment?.name ?? 'N/A');
            $('#transaction_id').text(response.transaction_id ?? 'N/A');
            $('#bank_account').text(response.bank_account_number
                ? `${response.bank_account_name} (${response.bank_account_number})`
                : 'N/A');
            $('#total').text(response.total ?? '0');
            $('#discount').text(response.discount ?? '0');
            $('#grand_total').text(response.grand_total ?? '0');
            $('#booking_notes').text(response.notes ?? 'No notes.');

            // store id for confirm/cancel
            $('#confirmBookingBtn').data('id', response.id);
            $('#cancelBookingBtn').data('id', response.id);
            $('#visitedBookingBtn').data('id', response.id);
            $('#pendingBookingBtn').data('id', response.id);

            // hide all first
            $('#confirmBookingBtn, #cancelBookingBtn, #visitedBookingBtn, #pendingBookingBtn').addClass('d-none');

            // ✅ Show buttons based on booking status
            if (response.status == 1) {
                // Pending → show Confirm + Cancel
                $('#confirmBookingBtn, #cancelBookingBtn').removeClass('d-none');
            } 
            else if (response.status == 2) {
                // Confirmed → show Visited + Cancel + Pending
                $('#visitedBookingBtn, #cancelBookingBtn, #pendingBookingBtn').removeClass('d-none');
            } 
            else if (response.status == 3) {
                // Visited → show Cancel
                $('#cancelBookingBtn').removeClass('d-none');
            } 
            else if (response.status == 4) {
                // Cancelled → show Pending
                $('#pendingBookingBtn').removeClass('d-none');
            }
        },
        error: function() {
            loader.addClass('d-none');
            toastr.error('Failed to load booking details.');
        }
    });
});
</script>
<script>
$(document).on('click', '#confirmBookingBtn', function() {
    const id = $(this).data('id');

    Swal.fire({
        title: 'Confirm Booking?',
        text: "This will mark the booking as confirmed.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, confirm it!',
        confirmButtonColor: '#198754'
    }).then(result => {
        if (result.isConfirmed) {
            const url = `{{ route('booking.confirm', ':id') }}`.replace(':id', id);

            $.post(url, { _token: '{{ csrf_token() }}' })
                .done(res => {
                    toastr.success('Booking confirmed successfully!');
                    $('#bookingDetailsModal').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                })
                .fail(() => toastr.error('Something went wrong.'));
        }
    });
});

$(document).on('click', '#cancelBookingBtn', function() {
    const id = $(this).data('id');

    Swal.fire({
        title: 'Cancel Booking?',
        text: "This booking will be cancelled permanently.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, cancel it!',
        confirmButtonColor: '#dc3545'
    }).then(result => {
        if (result.isConfirmed) {
            const url = `{{ route('booking.canceled', ':id') }}`.replace(':id', id);

            $.post(url, { _token: '{{ csrf_token() }}' })
                .done(res => {
                    toastr.success('Booking cancelled.');
                    $('#bookingDetailsModal').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                })
                .fail(() => toastr.error('Something went wrong.'));
        }
    });
});

$(document).on('click', '#visitedBookingBtn', function() {
    const id = $(this).data('id');

    Swal.fire({
        title: 'Guest Visited Booking?',
        text: "This booking will be marked as visited permanently.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, update it!',
        confirmButtonColor: '#dc3545'
    }).then(result => {
        if (result.isConfirmed) {
            const url = `{{ route('booking.visitedBooking', ':id') }}`.replace(':id', id);

            $.post(url, { _token: '{{ csrf_token() }}' })
                .done(res => {
                    toastr.success('Booking Visited.');
                    $('#bookingDetailsModal').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                })
                .fail(() => toastr.error('Something went wrong.'));
        }
    });
});

$(document).on('click', '#pendingBookingBtn', function() {
    const id = $(this).data('id');

    Swal.fire({
        title: 'Booking Status Pending ?',
        text: "This booking will be marked as back to pending.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, update it!',
        confirmButtonColor: '#dc3545'
    }).then(result => {
        if (result.isConfirmed) {
            const url = `{{ route('booking.pendingBooking', ':id') }}`.replace(':id', id);

            $.post(url, { _token: '{{ csrf_token() }}' })
                .done(res => {
                    toastr.success('Booking Status Pending updated.');
                    $('#bookingDetailsModal').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                })
                .fail(() => toastr.error('Something went wrong.'));
        }
    });
});
</script>
@endsection
