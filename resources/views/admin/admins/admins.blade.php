@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Admins</h4>
            @if ($access->control_panel == 3)
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                    <i class="fas fa-plus"></i> Add New Admin
                </button>
            @endif
            
        </div>

        <div class="row">
            @foreach ($admins as $admin)
                @php
                    $currentaccess = $adminAccess->where('admin_id', $admin->id)->first();
                    $imagePath =
                        $admin->image && file_exists(public_path($admin->image))
                            ? asset($admin->image)
                            : asset('admin-assets/img/nophoto1.png');
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm position-relative">
                        @if ($access->control_panel == 3)
                        {{-- Edit + Delete Buttons --}}
                        <div class="position-absolute top-0 end-0 m-2">
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editAdminModal{{ $admin->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            @if ($admin->status == 1)
                                <form action="{{ route('admin.control.status' , $admin->id) }}" method="POST" class="d-inline delete-confirm-form">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-secondary deleteInquiryBtn delete-confirm">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.control.status' , $admin->id) }}" method="POST" class="d-inline delete-confirm-form">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success deleteInquiryBtn delete-confirm">
                                        <i class="fas fa-unlock"></i>
                                    </button>
                                </form>    
                            @endif
                            <form action="{{ route('admin.control.delete' , $admin->id) }}" method="POST" class="d-inline delete-confirm-form">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger deleteInquiryBtn delete-confirm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        @endif

                        <img src="{{ $imagePath }}" class="card-img-top control-image" style="" alt="Admin Image">

                        <div class="card-body">
                            <h5 class="card-title">{{ $admin->name }}</h5>
                            <p class="mb-1"><strong>Email:</strong> {{ $admin->email }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $admin->phone }}</p>
                            <p class="mb-1"><strong>Role:</strong> {{ $admin->role_type }}</p>
                            <p><strong>Status:</strong> <span class="badge {{ $admin->status == 1 ? 'bg-success' : 'bg-danger' }}">{{ $admin->status == 1 ? 'Active' : 'Blocked' }}</span> </p>
                            <hr>

                            <h6 class="text-primary mb-2">Full Access</h6>
                            <div class="mb-2">
                                @if ($currentaccess)
                                    @foreach ($currentaccess->getAttributes() as $key => $val)
                                        @if ($val == 3 && $key !== 'id' && $key !== 'admin_id' && $key !== 'created_at' && $key !== 'updated_at' && $key !== 'seo' && $key !== 'reports' && $key !== 'control_panel')
                                            <span class="badge bg-success">{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-danger">⚠ No Access Data Available</p>
                                @endif
                            </div>

                            <h6 class="text-primary mb-2">View Only</h6>
                            <div class="mb-2">
                                @if ($currentaccess)
                                    @foreach ($currentaccess->getAttributes() as $key => $val)
                                        @if ($val == 1 && $key !== 'id' && $key !== 'admin_id' && $key !== 'created_at' && $key !== 'updated_at' && $key !== 'seo' && $key !== 'reports' && $key !== 'control_panel')
                                            <span class="badge bg-primary">{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-danger">⚠ No Access Data Available</p>
                                @endif
                            </div>

                            <h6 class="text-primary mb-2">No Access</h6>
                            <div class="mb-2">
                                @if ($currentaccess)
                                    @foreach ($currentaccess->getAttributes() as $key => $val)
                                        @if ($val == 2 && $key !== 'id' && $key !== 'admin_id' && $key !== 'created_at' && $key !== 'updated_at' && $key !== 'seo' && $key !== 'reports' && $key !== 'control_panel')
                                            <span class="badge bg-danger">{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-danger">⚠ No Access Data Available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editAdminModal{{ $admin->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <form class="edit-admin-form" data-id="{{ $admin->id }}" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-header bg-warning text-white">
                                    <h5>Edit Admin</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $admin->name }}" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ $admin->email }}" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Phone</label>
                                            <input type="text" class="form-control" name="phone"
                                                value="{{ $admin->phone }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label>Position</label>
                                            <input type="text" class="form-control" name="role_type"
                                                value="{{ $admin->role_type }}" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Image</label>
                                            <input type="file" class="form-control" name="image">
                                            <small class="text-muted">Leave empty to keep existing</small>
                                        </div>

                                        <div class="col-md-6">
                                            <label>New Password (optional)</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>

                                        <div class="col-md-6 password-confirm-box" style="display:none;">
                                            <label>Confirm Your Password</label>
                                            <input type="password" class="form-control" name="confirm_password">
                                        </div>


                                        <hr class="my-3">

                                        <h5>Admin Access</h5>
                                        @if ($currentaccess)
                                            @foreach ($currentaccess->getAttributes() as $key => $val)
                                                @if ($key !== 'id' && $key !== 'admin_id' && $key !== 'created_at' && $key !== 'updated_at' && $key !== 'seo' && $key !== 'reports' && $key !== 'control_panel')
                                                    <div class="col-md-4">
                                                        <label>{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                                                        <select class="form-select" name="{{ $key }}" required>
                                                            <option value="1" {{ $val == 1 ? 'selected' : '' }}>View
                                                                Only</option>
                                                            <option value="2" {{ $val == 2 ? 'selected' : '' }}>No
                                                                Access</option>
                                                            <option value="3" {{ $val == 3 ? 'selected' : '' }}>Full
                                                                Access</option>
                                                        </select>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif

                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-warning">Update Admin</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        {{-- Add Admin Modal --}}
        <div class="modal fade" id="addAdminModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <form action="{{ route('admin.control.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="modal-header bg-primary text-white">
                            <h5>Add New Admin</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>

                                <div class="col-md-6">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>

                                <div class="col-md-6">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>

                                <div class="col-md-6">
                                    <label>Position</label>
                                    <input type="text" class="form-control" name="role_type" required>
                                </div>

                                <div class="col-md-6">
                                    <label>Image</label>
                                    <input type="file" class="form-control" name="image">
                                </div>

                                <hr class="my-3">

                                <h5>Admin Access</h5>

                                @foreach ($adminAccess->first()->getAttributes() as $key => $val)
                                    @if ($key !== 'id' && $key !== 'admin_id' && $key !== 'created_at' && $key !== 'updated_at' && $key !== 'seo' && $key !== 'reports' && $key !== 'control_panel' )
                                        <div class="col-md-4">
                                            <label>{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                                            <select class="form-select" name="{{ $key }}" required>
                                                <option value="1">View Only</option>
                                                <option value="2">No Access</option>
                                                <option value="3">Full Access</option>
                                            </select>
                                        </div>
                                    @endif
                                @endforeach

                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary">Add Admin</button>
                        </div>

                    </form>

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
@endsection


@section('scripts')
<script>
$(document).ready(function () {

    // Submit Add Admin Form via AJAX
    $('#addAdminModal form').submit(function (e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: $(form).attr('action'),
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,

            beforeSend: function () {
                // Optional loader
                $('.btn-primary', form).prop('disabled', true).text('Saving...');
            },

            success: function (response) {

                // Enable button back
                $('.btn-primary', form).prop('disabled', false).text('Add Admin');

                if (response.success) {

                    toastr.success(response.message);

                    // Reset form
                    form.reset();

                    // Hide modal
                    $('#addAdminModal').modal('hide');

                    // Reload page after brief delay
                    setTimeout(() => {
                        location.reload();
                    }, 800);
                }
            },

            error: function (xhr) {

                // Enable button back
                $('.btn-primary', form).prop('disabled', false).text('Add Admin');

                if (xhr.status === 422) {

                    // Validation errors
                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, value) {
                        toastr.error(value[0]);
                    });

                } else {
                    toastr.error("Something went wrong!");
                }
            }
        });
    });

});
</script>
<script>
$(document).on('input', 'input[name="password"]', function () {
    if ($(this).val().length > 0) {
        $(this).closest('form').find('.password-confirm-box').show();
    } else {
        $(this).closest('form').find('.password-confirm-box').hide();
    }
});
</script>
<script>
    $(document).on('submit', '.edit-admin-form', function (e) {
    e.preventDefault();
    let updateRoute = "{{ route('admin.control.update', ':id') }}";
    let form = $(this);
    let id = form.data('id');
    let url = updateRoute.replace(':id', id);
    let formData = new FormData(this);

    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            toastr.info("Updating admin...");
        },
        success: function (res) {

            if (res.success) {
                toastr.success(res.message);

                // Hide modal
                $('#editAdminModal' + id).modal('hide');

                // Reset the form
                form[0].reset();

                // Reload page after 1 second
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                toastr.error("Something went wrong!");
            }
        },
        error: function (xhr) {

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function (key, val) {
                    toastr.error(val[0]);
                });
            } else {
                toastr.error("Error: " + xhr.responseJSON.message);
            }
        }
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
                confirmButtonText: 'Yes, Confirm!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
