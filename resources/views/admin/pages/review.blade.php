@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom-1">
                <h5 class="mb-0">All Reviews</h5>
                @if ($access->reviews == 3)
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <i class="bi bi-plus-circle"></i> Add Review
                </button>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="servicesTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Review For</th>
                                <th>Name</th>
                                <th>Rating</th>
                                <th width="400">Review</th>
                                <th>Status</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
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

    {{-- ==================== ADD SERVICE MODAL ==================== --}}
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="serviceForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fa-solid fa-plus-circle me-2"></i>Add New Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Select Service</label>
                            <select name="service_id" class="form-select" id="">
                                @foreach ($services as $service )
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Rating</label>
                            <input type="number" name="rating" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Comment</label>
                            <textarea name="comment" id="" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Service</button>
                </div>
            </form>
        </div>
    </div>
</div>  

<!-- Edit Review Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form id="editServiceForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="editServiceId">

            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Select Service</label>
                        <select name="service_id" id="edit_service_id" class="form-select">
                            <option value="">-- Select Service --</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Rating</label>
                        <input type="number" name="rating" id="edit_rating" class="form-control" required min="1" max="5">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Comment</label>
                        <textarea name="comment" id="edit_comment" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="col-md-6 d-none" id="statusWrapper">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit_status" class="form-select">
                            <option value="2">Active</option>
                            <option value="1">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Update Review</button>
            </div>
        </form>
        </div>
    </div>
</div>




@endsection


@section('scripts')
<script>
$(document).ready(function () {
    // ==================== DATATABLE ====================
        let table = $('#servicesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.reviews.data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'review_for', name: 'review_for' },
                { data: 'reviewer_name', name: 'reviewer_name' },
                { data: 'rating_display', name: 'rating_display', orderable: false, searchable: false },
                { data: 'comment_display', name: 'comment_display' },
                { data: 'status_display', name: 'status_display', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });



    // ==================== FORM SUBMIT ====================
    $('#serviceForm').on('submit', function(e) {
        e.preventDefault();

        // ✅ Remove focus first to avoid the aria-hidden issue
        document.activeElement.blur();

        let formData = new FormData(this);

        $.ajax({
            url: '{{ route("admin.reviews.store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                toastr.clear();
            },
            success: function(res) {
                if (res.success) {
                    toastr.success(res.message);

                    // ✅ Ensure focus is released first
                    document.activeElement.blur();

                    // ✅ Get or create the correct modal instance
                    let modalEl = document.getElementById('addServiceModal');
                    let addModal = bootstrap.Modal.getInstance(modalEl);

                    if (!addModal) {
                        // If no instance exists (because it was opened via data-bs-toggle), create one
                        addModal = new bootstrap.Modal(modalEl);
                    }

                    // ✅ Properly hide the modal
                    addModal.hide();

                    // ✅ Remove leftover backdrop (in case Bootstrap failed to)
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open').css('padding-right', '');

                    // ✅ Reset form and reload table
                    $('#serviceForm')[0].reset();
                    table.ajax.reload();
                } else {
                    toastr.error(res.message || 'Something went wrong!');
                }
            }
            ,
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('An unexpected error occurred.');
                }
            }
        });
    });



});
</script>


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
$(document).ready(function () {

    // ==================== FETCH REVIEW DATA ====================
    $(document).on('click', '.editReviewBtn', function () {
        let id = $(this).data('id');

        $.ajax({
            url: `{{ route('admin.reviews.edit', ':id') }}`.replace(':id', id),
            type: 'GET',
            success: function (res) {
                // Fill data
                $('#editServiceId').val(res.id);
                $('#edit_name').val(res.name);
                $('#edit_service_id').val(res.service_id);
                $('#edit_rating').val(res.rating);
                $('#edit_comment').val(res.comment);

                // Reset readonly + status
                $('#editServiceForm input, #editServiceForm textarea, #editServiceForm select').prop('readonly', false).prop('disabled', false);
                $('#statusWrapper').addClass('d-none');

                if (res.property_id) {
                    // Property review => make all readonly
                    $('#editServiceForm input, #editServiceForm textarea, #editServiceForm select').prop('readonly', true).prop('disabled', true);

                    // Enable status select only
                    $('#statusWrapper').removeClass('d-none');
                    $('#edit_status').prop('disabled', false).prop('readonly', false);
                    $('#edit_status').val(res.status);
                } else {
                    // Service review => always active
                    $('#edit_status').val(2);
                }

                // Show modal
                $('#editServiceModal').modal('show');
            },
            error: function () {
                toastr.error('Failed to fetch review details.');
            }
        });
    });


    // ==================== UPDATE REVIEW ====================
    $('#editServiceForm').on('submit', function (e) {
        e.preventDefault();

        let id = $('#editServiceId').val();
        let formData = new FormData(this);

        // If property_id not present => always send status = 2
        if ($('#statusWrapper').hasClass('d-none')) {
            formData.set('status', 2);
        }

        $.ajax({
            url: `{{ route('admin.reviews.update', ':id') }}`.replace(':id', id),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.success) {
                    $('#editServiceModal').modal('hide');
                    toastr.success(res.message || 'Review updated successfully!');
                    $('#servicesTable').DataTable().ajax.reload(null, false);
                } else {
                    toastr.error(res.message || 'Update failed.');
                }
            },
            error: function () {
                toastr.error('Update failed. Please check inputs.');
            }
        });
    });

});
</script>




@endsection