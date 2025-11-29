@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom-1">
                <h5 class="mb-0">Appointments</h5>

            </div>
            <div class="card-body  text-nowrap">
                <div class="table-responsive">
                    <table class="table" id="rentInquiryTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Appointment For</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Demands</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th width="80">Action</th>
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

    <!-- Inquiry Details Modal -->
    <div class="modal fade" id="inquiryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-circle-info me-2"></i>Appointment Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div id="inquiryContent" class="p-2">
                        <!-- Dynamic content will load here -->
                        <div class="text-center py-5" id="inquiryLoader">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                            <p class="mt-2">Loading details...</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <span id="inquiryStatus" class="fw-bold text-secondary"></span>
                    @if ($access->teams == 3)
                        <div class="w-100 mt-2 d-none" id="change-date">

                            <!-- Change button -->
                            <button type="button" id="changeScheduleBtn" class="btn btn-warning">
                                Change Appointment Date & Time
                            </button>

                            <!-- Hidden form -->
                            <div id="scheduleForm" class="mt-3 d-none">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="fw-bold">New Date</label>
                                        <input type="date" id="newDate" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold">New Time</label>
                                        <input type="time" id="newTime" class="form-control">
                                    </div>
                                </div>

                                <div class="mt-3 d-flex justify-content-end">
                                    <button type="button" id="cancelScheduleBtn"
                                        class="btn btn-secondary me-2">Cancel</button>
                                </div>
                            </div>

                        </div>

                        <button type="button" id="markRepliedBtn" class="btn btn-success d-none">
                            <i class="fa-solid fa-check me-1"></i> Confirm
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            $('#rentInquiryTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('appointment.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'team',
                        name: 'team',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'demands',
                        name: 'demands',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'message',
                        name: 'message',
                        orderable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // When "eye" button clicked
            $(document).on('click', '.viewInquiryBtn', function() {
                let inquiryId = $(this).data('id');
                $('#inquiryModal').modal('show');
                $('#inquiryLoader').show();
                $('#inquiryContent').html('');
                $('#markRepliedBtn').addClass('d-none');
                $('#change-date').addClass('d-none');

                $.ajax({
                    url: "{{ route('admin.appointment.show') }}", // create this route
                    type: "GET",
                    data: {
                        id: inquiryId
                    },
                    success: function(res) {
                        $('#inquiryLoader').hide();

                        let inquiry = res.appointment;
                        let team = res.team;

                        let html = `
                <div class="text-center mb-4">
                    <p>Appointment For :</p>
                    <h4 class="fw-bold">${team.name}</h4>
                    <p class="fw-bold">${team.position}</p>
                </div>
                <div class="border p-3 rounded ">
                    <p><strong>Name:</strong> ${inquiry.name}</p>
                    <p><strong>Phone:</strong> ${inquiry.phone}</p>
                    <p><strong>Email:</strong> ${inquiry.email}</p>
                    <p><strong>Country:</strong> ${inquiry.country_name}</p>
                    <p><strong>Schedule:</strong> ${inquiry.schedule_date} at ${inquiry.schedule_time}</p>
                    <p><strong>Demands:</strong> ${inquiry.demands || 'N/A'}</p>
                    <p><strong>Message:</strong> ${inquiry.message || 'N/A'}</p>
                </div>
                `;

                        $('#inquiryContent').html(html);
                        $('#inquiryStatus').text('Status: ' + inquiry.status);

                        if (inquiry.status.toLowerCase() !== 'confirmed') {
                            $('#markRepliedBtn').removeClass('d-none').data('id', inquiry.id);
                            $('#change-date').removeClass('d-none');
                        }
                    },
                    error: function() {
                        $('#inquiryContent').html(
                            '<p class="text-danger text-center">Failed to load appointment details.</p>'
                            );
                    }
                });
            });

            // Show schedule change form
            $(document).on('click', '#changeScheduleBtn', function() {
                $('#scheduleForm').removeClass('d-none');
            });

            // Cancel schedule change
            $(document).on('click', '#cancelScheduleBtn', function() {
                $('#scheduleForm').addClass('d-none');
                $('#newDate').val('');
                $('#newTime').val('');
            });

            // Override Confirm button logic to also send date/time
            $(document).on('click', '#markRepliedBtn', function() {
                let id = $(this).data('id');
                let newDate = $('#newDate').val();
                let newTime = $('#newTime').val();

                $.ajax({
                    url: "{{ route('admin.appointment.updateStatus') }}",
                    type: "POST",
                    data: {
                        id: id,
                        new_date: newDate,
                        new_time: newTime,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $('#markRepliedBtn').prop('disabled', true).text('Updating...');
                    },
                    success: function(res) {
                        toastr.success('Appointment Confirmed!');

                        // ✅ Get modal instance safely
                        const modalEl = document.getElementById('inquiryModal');
                        const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);

                        // ✅ Hide modal first
                        modalInstance.hide();

                        // ✅ Wait until modal is fully hidden before cleaning up
                        modalEl.addEventListener('hidden.bs.modal', function handler() {
                            // Remove the event listener (to avoid multiple triggers)
                            modalEl.removeEventListener('hidden.bs.modal', handler);

                            // ✅ Ensure no leftover backdrop or scroll lock
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open').css('overflow', 'auto');

                        });

                        $('#inquiryStatus').text('Status: Confirmed');
                        $('#markRepliedBtn').addClass('d-none');
                        $('#scheduleForm').addClass('d-none');
                        $('#newDate').val('');
                        $('#newTime').val('');

                        $('#rentInquiryTable').DataTable().ajax.reload();
                    },
                    error: function() {
                        toastr.error('Failed to update status.');
                        $('#markRepliedBtn').prop('disabled', false).text('Confirm');
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
@endsection
