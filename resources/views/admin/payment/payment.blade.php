@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom-1">
                <h5 class="mb-0">Payment Methods</h5>
                @if ($access->payment_methods == 3)
                <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNew" >Add New Payment Methods</a>
                @endif
            </div>
            <div class="card-body  text-nowrap">
                <div class="table-responsive">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Payment Method Type</th>
                                <th>Name</th>
                                <th>Account Number</th>
                                <th>Account Holder</th>
                                <th>Branch Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($payments->isNotEmpty())
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $payment->payment_method_type }}</td>
                                        <td>{{ $payment->name }}</td>
                                        <td>{{ $payment->account_number }}</td>
                                        <td>{{ $payment->account_name }}</td>
                                        <td>{{ $payment->branch_name }}</td>
                                        <td class="table-action-td d-flex align-items-center column-gap-3">
                                            @if ($access->payment_methods == 3)
                                            <a class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#EditCategoryModal_{{ $payment->id }}"><i
                                                    class="bi bi-pen-fill"></i> Edit</a>
                                            <form action="{{ route('payment_method.destroy', $payment->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this payment method?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="bi bi-trash-fill"></i> Delete</button>
                                            </form>
                                            @else
                                            <span class="text-muted">No Actions Available</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9"> No payment found! </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
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

    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex w-100 align-items-center justify-content-between">
                    <h5>Add New Coupon </h5>
                    <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
                <div class="modal-body">
                    <form id="paymentMethodForm">
                        @csrf

                        {{-- Payment Type --}}
                        <div class="form-group mb-3">
                            <label>Payment Method Type</label>
                            <select name="payment_method_type" id="payment_method_type" class="form-select" required>
                                <option value="">Select Type</option>
                                <option value="bank">Bank</option>
                                <option value="mobile_banking">Mobile Banking</option>
                            </select>
                        </div>

                        {{-- Common Field (shown in both types) --}}
                        <div class="form-group mb-3">
                            <label>Payment Method Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., bKash, Nagad, City Bank, etc.">
                        </div>

                        {{-- Account Number (Always visible) --}}
                        <div class="form-group mb-3">
                            <label>Account Number</label>
                            <input type="number" name="account_number" class="form-control" placeholder="Enter account number">
                        </div>

                        {{-- Bank-specific fields --}}
                        <div id="bankFields" style="display: none;">
                            <div class="form-group mb-3">
                                <label>Account Name</label>
                                <input type="text" name="account_name" class="form-control" placeholder="Account holder name">
                            </div>

                            <div class="form-group mb-3">
                                <label>Branch Name</label>
                                <input type="text" name="branch_name" class="form-control" placeholder="Enter branch name">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Save Payment Method</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    @if (isset($payment))
        @foreach ($payments as $method)
            <div class="modal fade" id="EditCategoryModal_{{ $method->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <!-- Modal content goes here, make sure to customize it for each category -->
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex w-100 align-items-center justify-content-between">
                            Edit Payment
                            <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                        <div class="modal-body">
                             <form id="editPaymentForm_{{ $method->id }}">
                                @csrf
                                @method('PUT')
                                    <div class="form-group mb-3">
                                        <label>Payment Method Type</label>
                                        <select name="payment_method_type" class="form-select payment_type_select" data-id="{{ $method->id }}">
                                            <option value="bank" {{ $method->payment_method_type == 'bank' ? 'selected' : '' }}>Bank</option>
                                            <option value="mobile_banking" {{ $method->payment_method_type == 'mobile_banking' ? 'selected' : '' }}>Mobile Banking</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Payment Method Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $method->name }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Account Number</label>
                                        <input type="number" name="account_number" class="form-control" value="{{ $method->account_number }}">
                                    </div>

                                    <!-- Bank Fields -->
                                    <div class="bankFields" id="bankFields_{{ $method->id }}" style="{{ $method->payment_method_type == 'bank' ? '' : 'display: none;' }}">
                                        <div class="form-group mb-3">
                                            <label>Account Name</label>
                                            <input type="text" name="account_name" class="form-control" value="{{ $method->account_name }}">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Branch Name</label>
                                            <input type="text" name="branch_name" class="form-control" value="{{ $method->branch_name }}">
                                        </div>
                                    </div>
                               

                                <button type="submit" class="btn btn-primary w-100">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection


@section('scripts')
    @if ($payments->isNotEmpty())
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

    // ✅ Toggle fields based on type
    $('#payment_method_type').on('change', function() {
        let type = $(this).val();

        if (type === 'bank') {
            $('#bankFields').slideDown(200);
        } else {
            $('#bankFields').slideUp(200);
        }
    });

    // ✅ Submit form using AJAX
    $('#paymentMethodForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let id = form.attr('id').split('_')[1];
        let type = form.find('select[name="payment_method_type"]').val();

        // ✅ Disable bank-only fields if type is mobile_banking
        if (type === 'mobile_banking') {
            form.find('input[name="account_name"]').prop('disabled', true);
            form.find('input[name="branch_name"]').prop('disabled', true);
        } else {
            form.find('input[name="account_name"]').prop('disabled', false);
            form.find('input[name="branch_name"]').prop('disabled', false);
        }
        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('payment_method.store') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                toastr.info('Saving payment method...', 'Please wait');
            },
            success: function(response) {
                toastr.clear();
                toastr.success(response.message, 'Success');
                $('#paymentMethodForm')[0].reset();
                $('#bankFields').hide();
                setTimeout(() => location.reload(), 1000); // fallback for static table
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

    // ✅ Toggle bank fields dynamically per modal
    $(document).on('change', '.payment_type_select', function() {
        let id = $(this).data('id');
        let type = $(this).val();

        if (type === 'bank') {
            $('#bankFields_' + id).slideDown(200);
        } else {
            $('#bankFields_' + id).slideUp(200);
        }
    });

    // ✅ Handle Update via AJAX
    $(document).on('submit', '[id^="editPaymentForm_"]', function(e) {
        e.preventDefault();

        let form = $(this);
        let id = form.attr('id').split('_')[1];
        let type = form.find('select[name="payment_method_type"]').val();

        // ✅ Disable bank-only fields if type is mobile_banking
        if (type === 'mobile_banking') {
            form.find('input[name="account_name"]').prop('disabled', true);
            form.find('input[name="branch_name"]').prop('disabled', true);
        } else {
            form.find('input[name="account_name"]').prop('disabled', false);
            form.find('input[name="branch_name"]').prop('disabled', false);
        }
        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('payment_method.update', ':id') }}".replace(':id', id),
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                toastr.info('Updating payment method...', 'Please wait');
            },
            success: function(response) {
                toastr.clear();
                toastr.success(response.message, 'Success');
                $('#EditPaymentModal_' + id).modal('hide');

                setTimeout(() => location.reload(), 1000); // fallback for static table
            },
            error: function(xhr) {
                toastr.clear();
                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
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
