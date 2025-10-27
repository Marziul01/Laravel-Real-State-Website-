@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom-1">
                <h5 class="mb-0">Coupons</h5>
                <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNew">Add New Coupon</a>
            </div>
            <div class="card-body  text-nowrap">
                <div class="table-responsive">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Code</th>
                                <th>Coupon Type</th>
                                <th>Amount</th>
                                <th>Max Uses</th>
                                <th>Max User Uses</th>
                                <th>Validity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($coupons->isNotEmpty())
                                @foreach ($coupons as $coupon)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $coupon->code }}</td>
                                        <td>{{ $coupon->discount_type }}</td>
                                        <td>{{ $coupon->discount }}</td>
                                        <td>{{ $coupon->max_uses }}</td>
                                        <td>{{ $coupon->max_user_uses }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($coupon->start_date)->format('d M, Y') }}
                                            - to -
                                            {{ $coupon->expire_date ? \Carbon\Carbon::parse($coupon->expire_date)->format('d M, Y') : 'Continue' }}
                                        </td>
                                        <td class="table-action-td d-flex align-items-center column-gap-3">
                                            <a class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#EditCategoryModal_{{ $coupon->id }}"><i
                                                    class="bi bi-pen-fill"></i> Edit</a>
                                            <form action="{{ route('coupon.destroy', $coupon->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="bi bi-trash-fill"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9"> No coupon found! </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex w-100 align-items-center justify-content-between">
                    <h5>Add New Coupon </h5>
                    <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
                <div class="modal-body">
                    <form id="couponForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label>Coupon Code</label>
                            <input type="text" name="code" class="form-control" placeholder="Enter coupon code">
                        </div>

                        <div class="form-group mb-3">
                            <label>Discount Type</label>
                            <select name="discount_type" class="form-select">
                                <option value="">Select Type</option>
                                <option value="percent">Percentage</option>
                                <option value="amount">Fixed Amount</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Discount Value</label>
                            <input type="number" name="discount" class="form-control" placeholder="Enter discount value">
                        </div>

                        <div class="form-group mb-3">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control myDate">
                        </div>

                        <div class="form-group mb-3">
                            <label>Expire Date</label>
                            <input type="date" name="expire_date" class="form-control myDate">
                        </div>

                        <div class="form-group mb-3">
                            <label>Max Uses</label>
                            <input type="number" name="max_uses" class="form-control" placeholder="(optional)">
                        </div>

                        <div class="form-group mb-3">
                            <label>Max Uses Per User</label>
                            <input type="number" name="max_user_uses" class="form-control" placeholder="(optional)">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Save Coupon</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    @if (isset($coupon))
        @foreach ($coupons as $coupon)
            <div class="modal fade" id="EditCategoryModal_{{ $coupon->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <!-- Modal content goes here, make sure to customize it for each category -->
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex w-100 align-items-center justify-content-between">
                            Edit Coupon
                            <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                        <div class="modal-body">
                            <form id="editCouponForm">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="id" value="{{ $coupon->id }}">

                                <div class="form-group mb-3">
                                    <label>Coupon Code</label>
                                    <input type="text" name="code" class="form-control" value="{{ $coupon->code }}" placeholder="Enter coupon code">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Discount Type</label>
                                    <select name="discount_type" class="form-select">
                                        <option value="percent" {{ $coupon->discount_type == 'percent' ? 'selected' : '' }}>Percentage</option>
                                        <option value="amount" {{ $coupon->discount_type == 'amount' ? 'selected' : '' }}>Fixed Amount</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Discount Value</label>
                                    <input type="number" name="discount" class="form-control" value="{{ $coupon->discount }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Start Date</label>
                                    <input type="date" name="start_date" class="form-control myDate" value="{{ $coupon->start_date }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Expire Date</label>
                                    <input type="date" name="expire_date" class="form-control myDate" value="{{ $coupon->expire_date }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Max Uses</label>
                                    <input type="number" name="max_uses" class="form-control" value="{{ $coupon->max_uses }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Max Uses Per User</label>
                                    <input type="number" name="max_user_uses" class="form-control" value="{{ $coupon->max_user_uses }}">
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Update Coupon</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

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

@endsection


@section('scripts')
@if ($coupons->isNotEmpty())
<script>
    $('#myTable').DataTable({
        pageLength: 25, // default rows per page
        lengthMenu: [ [25, 50, 100], [25, 50, 100] ], // options in dropdown
        dom: 'Blfrtip', // added 'l' so the length menu appears
        buttons: [
            {
                extend: 'csv',
                text: 'Export CSV',
                className: 'btn btn-sm my-custom-table-btn',
                exportOptions: {
                    columns: ':not(:last-child)' // exclude the last column
                }
            },
            {
                extend: 'print',
                text: 'Print Table',
                className: 'btn btn-sm my-custom-table-btn',
                exportOptions: {
                    columns: ':not(:last-child)' // exclude the last column
                }
            }
        ]
    });
</script>
    
@endif
    <script>
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();

            const form = $(this).closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
    <script>
$(document).ready(function() {
    $('#couponForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('coupon.store') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                toastr.info('Saving coupon...', 'Please wait');
            },
            success: function(response) {
                toastr.clear();
                toastr.success(response.message, 'Success');
                $('#couponModal').modal('hide');
                $('#couponForm')[0].reset();

                setTimeout(() => location.reload(), 800);
            },
            error: function(xhr) {
                toastr.clear();
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('Something went wrong. Please try again.');
                }
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {
    $('#editCouponForm').on('submit', function(e) {
        e.preventDefault();

        let couponId = $('input[name="id"]').val();
        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('coupon.update', ':id') }}".replace(':id', couponId),
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                toastr.info('Updating coupon...', 'Please wait');
            },
            success: function(response) {
                toastr.clear();
                toastr.success(response.message, 'Success');
                setTimeout(() => location.reload(), 800);
            },
            error: function(xhr) {
                toastr.clear();
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
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
