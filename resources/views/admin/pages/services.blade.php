@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom-1">
                <h5 class="mb-0">Client Rent Submission</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <i class="bi bi-plus-circle"></i> Add New Service
                </button>
            </div>
            <div class="card-body  text-nowrap">
                <div class="table-responsive">
                     <table class="table" id="servicesTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>File Type</th>
                                <th>File / Link</th>
                                <th>Description</th>
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
                    <h5 class="modal-title"><i class="fa-solid fa-plus-circle me-2"></i>Add New Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Service Type</label>
                            <select name="type[]" class="form-control select2" multiple required>
                                <option value="Buy Property Services">Buy Property Services</option>
                                <option value="Property Document Services">Property Document Services</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Select Icon</label>
                            <div class="input-group">
                                <input type="text" id="iconPicker" name="icon" class="form-control" placeholder="Choose icon">
                                {{-- <span class="input-group-text"><i id="iconPreview" class="fa-solid fa-magnifying-glass"></i></span> --}}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">File Type</label>
                            <select name="file_type" id="file_type" class="form-control" required>
                                <option value="">-- Select File Type --</option>
                                <option value="Image">Image</option>
                                <option value="Video File">Video File</option>
                                <option value="Video Link">Video Link</option>
                            </select>
                        </div>

                        <div class="col-md-6" id="fileInputWrapper" style="display:none;">
                            <label class="form-label">File Upload</label>
                            <input type="file" name="file" id="fileInput" class="form-control">
                        </div>

                        <div class="col-md-6" id="linkInputWrapper" style="display:none;">
                            <label class="form-label">Video Link</label>
                            <input type="url" name="file" id="linkInput" class="form-control" placeholder="https://example.com/video">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Service</button>
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
        ajax: '{{ route("admin.services.data") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'icon', name: 'icon', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'type', name: 'type', orderable: false, searchable: false },
            { data: 'file_type', name: 'file_type' },
            { data: 'file_display', name: 'file_display', orderable: false, searchable: false },
            { data: 'description', name: 'description' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    $('.select2').select2({ width: '100%', dropdownParent: $('#addServiceModal') });

    // ==================== FILE TYPE HANDLER ====================
    $('#file_type').on('change', function() {
        const val = $(this).val();
        $('#fileInputWrapper, #linkInputWrapper').hide();
        if (val === 'Image' || val === 'Video File') $('#fileInputWrapper').show();
        else if (val === 'Video Link') $('#linkInputWrapper').show();
    });

    // ==================== FORM SUBMIT ====================
    $('#serviceForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: '{{ route("admin.services.store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                toastr.clear(); // clear old messages
            },
            success: function(res) {
                if(res.success){
                    toastr.success(res.message);
                    $('#addServiceModal').modal('hide');
                    $('#serviceForm')[0].reset();
                    $('.select2').val(null).trigger('change');
                    table.ajax.reload();
                } else {
                    toastr.error(res.message || 'Something went wrong!');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    // Loop through Laravel validation errors
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
$(document).ready(function () {
    // Wait until modal is shown to initialize
    $('#addServiceModal').on('shown.bs.modal', function () {

        // Destroy any previous picker (important if reopening)
        $('#iconPicker').iconpicker('destroy');

        // Initialize again after modal is visible
        $('#iconPicker').iconpicker({
            container: '#addServiceModal', // ensures dropdown is inside modal
            align: 'center',
            arrowClass: 'btn-primary',
            arrowPrevIconClass: 'fa-solid fa-angle-left',
            arrowNextIconClass: 'fa-solid fa-angle-right',
            cols: 10,
            footer: true,
            header: true,
            iconset: 'fontawesome5',
            labelHeader: '{0} of {1} pages',
            placement: 'bottom',
            search: true
        }).on('iconpickerSelected', function (event) {
            $('#iconPreview').attr('class', event.iconpickerValue);
            $('#iconPicker').val(event.iconpickerValue); // store value in input
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
@endsection