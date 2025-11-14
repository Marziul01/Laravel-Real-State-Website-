@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
            <div class="card shadow-sm">
                <div class="card-header text-white">
                    <h5 class="mb-0">User Management</h5>
                </div>
                <div class="card-body">
                    <table class="table" id="users-table" width="100%">
                        <thead class="text-white">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Total Bookings</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
    </div>
@endsection


@section('scripts')
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
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
<script>
$(document).ready(function () {
    let table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.users.data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'total_bookings', name: 'total_bookings' },
            { data: 'status_display', name: 'status_display', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // 🧾 Confirm Delete
    $(document).on('submit', '.delete-confirm-form', function(e) {
        e.preventDefault();
        let form = this;

        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: form.action,
                    method: "POST",
                    data: $(form).serialize(),
                    success: function(response) {
                        toastr.success(response.message);
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        toastr.error("An error occurred while deleting user.");
                    }
                });

            }
        });
    });


    // 🔄 Toggle Status
    $(document).on('submit', '.update-status-form', function(e) {
        e.preventDefault();
        let form = this;
        $.ajax({
            url: form.action,
            method: "POST",
            data: $(form).serialize(),
            success: function(response) {
                toastr.success(response.message);
                table.ajax.reload();
            },
            error: function() {
                toastr.error("Failed to update user status.");
            }
        });
    });
});
</script>
@endsection