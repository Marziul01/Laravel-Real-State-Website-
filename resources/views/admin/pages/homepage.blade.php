@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom-1">
                <h5 class="mb-0">All Sliders</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <i class="bi bi-plus-circle"></i> Add New Slider
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="servicesTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Desc</th>
                                <th>Product</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div> 

        <form id="homePageForm" enctype="multipart/form-data">
            @csrf
            <div class="card mb-4">
                <div class="card-header text-white">Home Page Image</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Upload Image</label>
                        <input type="file" name="image" id="home_image" class="form-control" accept="image/*">
                    </div>

                    @if (!empty($homepage->image))
                        <div id="imagePreviewWrapper" class="text-center mb-3">
                            <label class="form-label">Current Image:</label>
                            <div id="imagePreviewContent" class="border rounded p-2">
                                <img src="{{ asset($homepage->image) }}" class="img-fluid rounded" style="max-height:200px;">
                            </div>
                        </div>
                    @else
                        <div id="imagePreviewWrapper" style="display:none;"></div>
                    @endif
                </div>
            </div>

            {{-- ✅ Results Section --}}
            <div class="card">
                <div class="card-header text-white">Home Page Results</div>
                <div class="card-body">
                    <div class="row">
                        @for ($i = 1; $i <= 5; $i++)
                            @php
                                $field = 'result_' . $i;
                                $parts = !empty($homepage->$field) ? explode(',', $homepage->$field) : ['', '', ''];
                            @endphp
                            <div class="col-md-4 mb-3">
                                <div class="card border shadow-sm">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3">Result {{ $i }}</h6>

                                        <div class="mb-2 text-center d-flex align-items-center gap-2">
                                            
                                            <input type="text"
                                                name="result_{{ $i }}_icon"
                                                id="iconPicker_result_{{ $i }}"
                                                class="form-control"
                                                placeholder="Select icon"
                                                readonly
                                                value="{{ $parts[0] }}">
                                            <i id="iconPreview_result_{{ $i }}" class="{{ $parts[0] }} fs-4 d-block mb-2"></i>
                                        </div>

                                        <input type="text"
                                            name="result_{{ $i }}_name"
                                            id="result_name_{{ $i }}"
                                            class="form-control mb-2"
                                            placeholder="Name"
                                            value="{{ $parts[1] }}">
                                        <input type="number"
                                            name="result_{{ $i }}_number"
                                            id="result_number_{{ $i }}"
                                            class="form-control"
                                            placeholder="Number"
                                            value="{{ $parts[2] }}">
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success px-4">Save All</button>
                    </div>
                </div>
            </div>
        </form>

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
                    <h5 class="modal-title"><i class="fa-solid fa-plus-circle me-2"></i>Add New Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Select Property</label>
                            <select name="property_id" class="form-select" id="">
                                @foreach ($properties as $property )
                                    <option value="{{ $property->id }}">{{ $property->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Description</label>
                            <input type="text" name="desc" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Upload Slider Image</label>
                            <input type="file" name="image" id="" class="form-control" required accept="image/*">
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
                <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Slider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Select Property</label>
                        <select name="property_id" id="edit_property_id" class="form-select">
                            @foreach ($properties as $property)
                                <option value="{{ $property->id }}">{{ $property->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <input type="text" name="desc" id="edit_desc" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Upload Slider Image</label>
                        <input type="file" name="image" id="edit_image" class="form-control" required accept="image/*">
                    </div>

                    <div class="col-12" id="edit_previewWrapper" style="display:none;">
                        <label class="form-label">Current Image</label>
                        <div id="edit_previewContent" class="border rounded p-2 text-center"></div>
                    </div>

                    <input type="hidden" name="id" id="editServiceId">

                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Update Slider</button>
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
            ajax: "{{ route('admin.homeslider.data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'file_display', name: 'file_display' },
                { data: 'title', name: 'title' },
                { data: 'description', name: 'description' },
                { data: 'property', name: 'property' , orderable: false, searchable: false},
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
            url: '{{ route("admin.homeslider.store") }}',
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
            url: `{{ route('admin.homeslider.edit', ':id') }}`.replace(':id', id),
            type: 'GET',
            success: function (response) {

                // Fill form fields
                $('#editServiceId').val(response.id);
                $('#edit_property_id').val(response.property_id);
                $('#edit_title').val(response.title);
                $('#edit_desc').val(response.description);

                // Show current image preview if exists
                if (response.image) {
                    $('#edit_previewWrapper').show();
                    $('#edit_previewContent').html(`
                        <img src="{{ asset('') }}/${response.image}" 
                            class="img-fluid rounded" 
                            style="max-height:200px;">
                    `);
                } else {
                    $('#edit_previewWrapper').hide();
                    $('#edit_previewContent').html('');
                }

                // Open modal
                $('#editServiceModal').modal('show');
            },
            error: function () {
                toastr.error('Failed to fetch slider details.');
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
            url: `{{ route('admin.homeslider.update', ':id') }}`.replace(':id', id),
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

<script>
$(document).ready(function () {
    // ✅ Initialize all icon pickers
    $('[id^="iconPicker_result_"]').each(function () {
        const input = $(this);
        const previewId = input.attr('id').replace('iconPicker', 'iconPreview');

        input.iconpicker('destroy').iconpicker({
            container: 'body',
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
            search: true,
        }).on('iconpickerSelected', function (event) {
            $('#' + previewId).attr('class', event.iconpickerValue + ' fs-4');
            input.val(event.iconpickerValue);
        });
    });

    // ✅ Handle form submit
    $('#homePageForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        for (let i = 1; i <= 5; i++) {
            const icon = $('#iconPicker_result_' + i).val() || '';
            const name = $('#result_name_' + i).val() || '';
            const number = $('#result_number_' + i).val() || '';
            formData.append(`result_${i}`, `${icon},${name},${number}`);
        }

        $.ajax({
            url: `{{ route('admin.homepage.update') }}`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                toastr.info('Saving home page data...');
            },
            success: function (res) {
                if (res.success) {
                    toastr.success(res.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    toastr.error(res.message || 'Something went wrong.');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.values(errors).forEach(err => toastr.error(err[0]));
                } else {
                    toastr.error('Failed to update home page data.');
                }
            }
        });
    });
});
</script>




@endsection