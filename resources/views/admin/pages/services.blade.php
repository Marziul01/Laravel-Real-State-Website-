@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom-1">
                <h5 class="mb-0">All Services</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <i class="bi bi-plus-circle"></i> Add New Service
                </button>
            </div>
            <div class="card-body">
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
                                <th width="500">Description</th>
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
                        <label class="form-label">Service Type</label>
                        <select name="type[]" id="edit_type" class="form-control select3" multiple required>
                            <option value="Buy Property Services">Buy Property Services</option>
                            <option value="Property Document Services">Property Document Services</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Select Icon</label>
                        <div class="input-group">
                            <input type="text" id="edit_icon" name="icon" class="form-control" placeholder="Choose icon">
                            <span class="input-group-text"><i id="edit_iconPreview"></i></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">File Type</label>
                        <select name="file_type" id="edit_file_type" class="form-control" required>
                            <option value="">-- Select File Type --</option>
                            <option value="Image">Image</option>
                            <option value="Video File">Video File</option>
                            <option value="Video Link">Video Link</option>
                        </select>
                    </div>

                    <!-- File / Video Upload -->
                    <div class="col-md-6" id="edit_fileInputWrapper" style="display:none;">
                        <label class="form-label">File Upload</label>
                        <input type="file" name="file" id="edit_fileInput" class="form-control">
                    </div>

                    <!-- Video Link -->
                    <div class="col-md-6" id="edit_linkInputWrapper" style="display:none;">
                        <label class="form-label">Video Link</label>
                        <input type="url" name="file" id="edit_linkInput" class="form-control" placeholder="https://example.com/video">
                    </div>

                    <!-- Preview -->
                    <div class="col-12" id="edit_previewWrapper" style="display:none;">
                        <label class="form-label">Current Media</label>
                        <div id="edit_previewContent" class="border rounded p-2 text-center"></div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="5"></textarea>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
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
        ajax: '{{ route("admin.services.data") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'icon', name: 'icon', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'type', name: 'type', orderable: false, searchable: false },
            { data: 'file_type', name: 'file_type' },
            { data: 'file_display', name: 'file_display', orderable: false, searchable: false },
            { 
                data: 'description', 
                name: 'description',
                render: function(data, type, row) {
                    if (!data) return '';
                    // Split by space and limit to 20 words
                    const words = data.split(/\s+/);
                    return words.length > 20 
                        ? words.slice(0, 20).join(' ') + ' ...' 
                        : data;
                }
            },
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


<script>
$(document).ready(function () {

    // ==================== INIT SELECT2 ====================
    $('.select3').select2({
        width: '100%',
        dropdownParent: $('#editServiceModal')
    });

    // ==================== ICON PICKER ====================
    $('#editServiceModal').on('shown.bs.modal', function () {

        // Destroy any previous instance
        $('#edit_icon').iconpicker('destroy');

        // Initialize again
        $('#edit_icon').iconpicker({
            container: '#editServiceModal',
            align: 'center',
            arrowClass: 'btn-warning',
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
            $('#edit_iconPreview').attr('class', event.iconpickerValue);
            $('#edit_icon').val(event.iconpickerValue);
        });
    });

    // ==================== FILE TYPE HANDLER ====================
    $('#edit_file_type').on('change', function () {
        const val = $(this).val();
        $('#edit_fileInputWrapper, #edit_linkInputWrapper, #edit_previewWrapper').hide();
        $('#edit_previewContent').empty();

        if (val === 'Image' || val === 'Video File') {
            $('#edit_fileInputWrapper').show();
        } else if (val === 'Video Link') {
            $('#edit_linkInputWrapper').show();
        }
    });

    // ==================== FETCH SERVICE DATA ====================
    $(document).on('click', '.editServiceBtn', function () {
        let id = $(this).data('id');

        $.ajax({
            url: `{{ route('admin.services.edit', ':id') }}`.replace(':id', id),
            type: 'GET',
            success: function (response) {

                // Fill data
                $('#editServiceId').val(response.id);
                $('#edit_name').val(response.name);
                $('#edit_icon').val(response.icon);
                $('#edit_iconPreview').attr('class', response.icon);
                $('#edit_description').val(response.description);
                $('#edit_file_type').val(response.file_type).trigger('change');

                // Set Select2
                if (response.type) {
                    let types = response.type.split(',');
                    $('#edit_type').val(types).trigger('change');
                }

                // Show preview of current media
                if (response.file) {
                    $('#edit_previewWrapper').show();

                    if (response.file_type === 'Image') {
                        $('#edit_previewContent').html(`<img src="{{  asset('${response.file}') }}" class="img-fluid rounded" style="max-height:200px;">`);
                    } else if (response.file_type === 'Video File') {
                        $('#edit_previewContent').html(`<video src="{{  asset('/${response.file}') }}" controls style="max-height:200px;" class="rounded w-100"></video>`);
                    } else if (response.file_type === 'Video Link') {
                        $('#edit_previewContent').html(`<iframe src="${response.file}" class="w-100 rounded" style="height:200px;" allowfullscreen></iframe>`);
                    }
                }

                // Show modal
                $('#editServiceModal').modal('show');
            },
            error: function () {
                toastr.error('Failed to fetch service details.');
            }
        });
    });

    // ==================== UPDATE SERVICE ====================
    $('#editServiceForm').on('submit', function (e) {
        e.preventDefault();

        let id = $('#editServiceId').val();
        let formData = new FormData(this);

        $.ajax({
            url: `{{ route('admin.services.update', ':id') }}`.replace(':id', id),
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