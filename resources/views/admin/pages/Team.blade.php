@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom-1">
                <h5 class="mb-0">All Team Member</h5>
                @if ($access->teams == 3)
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <i class="bi bi-plus-circle"></i> Add Team Member
                </button>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                     <table class="table" id="servicesTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th >Image</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th width="400">Bio</th>
                                <th>Number</th>
                                <th>Email</th>
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
                            <label class="form-label">Position</label>
                            <input type="text" name="position" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Image Upload</label>
                            <input type="file" name="image" class="form-control">
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

<!-- Edit Service Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form id="editServiceForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="editServiceId">

            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">

                    <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Position</label>
                            <input type="text" name="position" id="position" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" id="editemail" name="email" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" class="form-control" id="bio" rows="3"></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Image Upload</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="col-12" id="edit_previewWrapper" style="display:none;">
                            <label class="form-label">Current Image</label>
                            <div id="edit_previewContent" class="border rounded p-2 text-center"></div>
                        </div>
                </div>
            </div>

            <div class="modal-footer">
               
                <button type="submit" class="btn btn-warning">Update Service</button>
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
        ajax: '{{ route("admin.teams.data") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' }, // SL
            { data: 'file_display', name: 'file_display', orderable: false, searchable: false }, // Image
            { data: 'name', name: 'name' }, // Name
            { data: 'position', name: 'position' },
            { 
                data: 'bio', 
                name: 'bio',
                render: function(data, type, row) {
                    if (!data) return '';
                    // Limit to 20 words
                    const words = data.split(/\s+/);
                    return words.length > 20 
                        ? words.slice(0, 20).join(' ') + ' ...' 
                        : data;
                }
            }, // Bio
            { data: 'phone', name: 'phone' }, // Number
            { data: 'email', name: 'email' }, // Email
            { data: 'action', name: 'action', orderable: false, searchable: false }, // Action
        ]
    });


    // ==================== FORM SUBMIT ====================
    $('#serviceForm').on('submit', function(e) {
        e.preventDefault();

        // ✅ Remove focus first to avoid the aria-hidden issue
        document.activeElement.blur();

        let formData = new FormData(this);

        $.ajax({
            url: '{{ route("admin.teams.store") }}',
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
    // ==================== FETCH SERVICE DATA ====================
    $(document).on('click', '.editServiceBtn', function () {
        let id = $(this).data('id');

        $.ajax({
            url: `{{ route('admin.teams.edit', ':id') }}`.replace(':id', id),
            type: 'GET',
            success: function (response) {

                // Fill form fields
                $('#editServiceId').val(response.id);
                $('#name').val(response.name);
                $('#editemail').val(response.email);
                $('#phone').val(response.phone);
                $('#position').val(response.position);
                $('#bio').val(response.bio);

                // Show image preview if image exists
                if (response.image) {
                    $('#edit_previewWrapper').show();
                    $('#edit_previewContent').html(`
                        <img src="{{ asset('${response.image}') }}" 
                            class="img-fluid rounded" 
                            style="max-height:200px;">
                    `);
                } else {
                    $('#edit_previewWrapper').hide();
                    $('#edit_previewContent').html('');
                }

                // Show modal
                $('#editServiceModal').modal('show');
            },
            error: function () {
                toastr.error('Failed to fetch team member details.');
            }
        });
    });


    // ==================== UPDATE SERVICE ====================
    $('#editServiceForm').on('submit', function (e) {
        e.preventDefault();

        let id = $('#editServiceId').val();
        let formData = new FormData(this);

        $.ajax({
            url: `{{ route('admin.teams.update', ':id') }}`.replace(':id', id),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                $('#editServiceModal').modal('hide');
                toastr.success('Service updated successfully!');
                $('#servicesTable').DataTable().ajax.reload(null, false); // if DataTable used
            },
            error: function () {
                toastr.error('Update failed. Please check inputs.');
            }
        });
    });

});
</script>



@endsection