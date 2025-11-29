@extends('frontend.master')

@section('title')
User Dashboard
@endsection


@section('content')
<div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm">{{  Auth::user()->name }} > Dashboard</p>
        </div>
    </div>
<div class="container">
    <div class="row dashboard-user">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2  pt-4 height-fit-content">
            <ul class="nav flex-column nav-pills" id="dashboardTabs" role="tablist" aria-orientation="vertical">
                <li class="nav-item mb-2">
                    <a class="nav-link active" id="tab-dashboard" data-bs-toggle="pill" href="#dashboard" role="tab">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" id="tab-profile" data-bs-toggle="pill" href="#profile" role="tab">Update Profile</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="btn btn-danger w-100 logout-confirm" href="{{ route('user.logout') }}" >Logout</a>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <div class="col-md-9 col-lg-10 pt-4">
            <div class="tab-content" id="dashboardTabContent">
                <!-- Dashboard Tab -->
                <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-center p-3">
                                <h5>Total Bookings</h5>
                                <h3 id="totalBookings">{{ $totalBookings }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center p-3">
                                <h5>Pending Bookings</h5>
                                <h3 id="pendingBookings">{{ $pendingBookings }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center p-3">
                                <h5>Visited Bookings</h5>
                                <h3 id="visitedBookings">{{ $visitedBookings }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Bookings Table -->
                    <div class="table-responsive">
                        <table class="table table-striped align-middle" id="bookingsTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>Property</th>
                                    <th>Booking Date</th>
                                    <th>Guests</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>
                                            <a href="{{ $booking->property->type == 'rent' ? route('view.rent.property', $booking->property->slug) : route('view.buy.property', $booking->property->slug) }}" class="text-decoration-none text-dark d-flex align-items-center">
                                                <img src="{{ asset($booking->property->featured_image) }}" 
                                                    alt="{{ $booking->property->name }}" 
                                                    class="rounded me-2" width="60" height="45" style="object-fit: cover;">
                                                <span>{{ $booking->property->name ?? 'N/A' }}</span>
                                            </a>
                                        </td>
                                        @php
                                            $start = \Carbon\Carbon::parse($booking->start_date);
                                            $end = \Carbon\Carbon::parse($booking->end_date);

                                            // Calculate differences
                                            $nights = $start->diffInDays($end);       // per night
                                            $weeks = $start->diffInWeeks($end);       // weekly
                                            $months = ceil($start->diffInMonths($end, false)); // monthly, round up
                                        @endphp
                                        <td>
                                            {{-- Duration based on booking type --}}
                                            @if($booking->booking_type === 'per-night')
                                                <span class="text-primary fw-bold">{{ $nights }} Night{{ $nights > 1 ? 's' : '' }}</span>
                                                <br>
                                            @elseif($booking->booking_type === 'weekly')
                                                <span class="text-success fw-bold">{{ $weeks }} Week{{ $weeks > 1 ? 's' : '' }}</span>
                                                <br>
                                            @elseif($booking->booking_type === 'monthly')
                                                <span class="text-info fw-bold">{{ $months }} Month{{ $months > 1 ? 's' : '' }}</span>
                                                <br>
                                            @endif
                                            
                                            {{ $start->format('M d, Y') }} - {{ $end->format('M d, Y') }}

                                            <br>
                                            (Check In: {{ \Carbon\Carbon::parse($booking->property->check_in)->format('g:i A') }} &  
                                            Check Out: {{ \Carbon\Carbon::parse($booking->property->check_out)->format('g:i A') }})
                                        </td>
                                        <td>{{ $booking->total_guests }}</td>
                                        <td>
                                            @if($booking->status == 1)
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($booking->status == 2)
                                                <span class="badge bg-success">Confirmed</span>
                                            @elseif($booking->status == 3)
                                                <span class="badge bg-primary">Visited</span>
                                            @elseif($booking->status == 4)
                                                <span class="badge bg-danger">Canceled</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 align-items-center">
                                                @if($booking->property->realtor)
                                                    <a class="btn btn-sm btn-primary contact-btn d-flex align-items-center" 
                                                    href="https://wa.me/{{ $booking->property->realtor->phone }}">
                                                        <i class="fa-brands fa-whatsapp"></i> Contact
                                                    </a>
                                                @endif
                                                @if($booking->status != 3)
                                                <a href="{{ route('booking.invoice.show', $booking->id) }}" target="_blank" class="btn btn-sm btn-primary d-flex align-items-center" >
                                                    <i class="fa-solid fa-download"></i> Invoice
                                                </a>
                                                @endif
                                                @if($booking->status == 3 && !$booking->reviews()->where('user_id', auth()->id())->exists())
                                                    <button class="btn btn-sm btn-success review-btn" 
                                                            data-id="{{ $booking->id }}" 
                                                            data-property="{{ $booking->property->name }}">
                                                        <i class="bi bi-star"></i> Give Review
                                                    </button>
                                                @endif
                                            </div>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

                <!-- Update Profile Tab -->
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <form id="updateProfileForm">
                        @csrf
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}">
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}">
                        </div>
                        <div class="mb-3">
                            <label>Password (leave blank to keep current)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <button class="btn btn-primary" type="submit">Update Profile</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="reviewForm">
        @csrf
        <input type="hidden" name="booking_id" id="reviewBookingId">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Review for <span id="reviewPropertyName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Rating</label>
                    <select name="rating" class="form-control">
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Good</option>
                        <option value="3">3 - Average</option>
                        <option value="2">2 - Poor</option>
                        <option value="1">1 - Terrible</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Comment</label>
                    <textarea name="comment" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Submit Review</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection


@section('customJs')


<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
    $('#bookingsTable').DataTable({
        pageLength: 10,
        order: [], // optional: sort by property name
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search bookings..."
        },
        columnDefs: [
            { orderable: false, targets: [4] } // disable sorting for Action column
        ]
    });
});
</script>

<script>
$(document).ready(function(){

    // Update Profile AJAX
    $('#updateProfileForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('user.updateProfile') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(res){
                toastr.success(res.message);
            },
            error: function(err){
                toastr.error('Profile update failed');
            }
        });
    });

    // Open Review Modal
    $(document).on('click', '.review-btn', function(){
        $('#reviewBookingId').val($(this).data('id'));
        $('#reviewPropertyName').text($(this).data('property'));
        $('#reviewModal').modal('show');
    });

    // Submit Review AJAX
    $('#reviewForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('user.submitReview') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(res){
                toastr.success(res.message);
                $('#reviewModal').modal('hide');
            },
            error: function(err){
                toastr.error('Failed to submit review');
            }
        });
    });

    // Contact button
    $(document).on('click', '.contact-btn', function(){
        let bookingId = $(this).data('id');
        toastr.info('Contact action clicked for booking #' + bookingId);
    });

});
</script>
@endsection