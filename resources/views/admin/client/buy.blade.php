@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom-1">
                <h5 class="mb-0">Client Sell Property Submission</h5>
                
            </div>
            <div class="card-body  text-nowrap">
                <div class="table-responsive">
                     <table class="table" id="rentInquiryTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Property Address</th>
                                <th>Space (sqft)</th>
                                <th>Bedrooms</th>
                                <th>Clients Estimate Price</th>
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
          <i class="fa-solid fa-circle-info me-2"></i>Submission Details
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
        <button type="button" id="markConfirmBtn" class="btn btn-success d-none">
          <i class="fa-solid fa-check me-1"></i> Mark as Confirmed
        </button>
        <button type="button" id="markCancelBtn" class="btn btn-danger d-none">
          <i class="fa-solid fa-check me-1"></i> Mark as Cancelled
        </button>
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
        ajax: "{{ route('sell.submission') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'phone', name: 'phone' },
            { data: 'address', name: 'address' },
            { data: 'space', name: 'space' },
            { data: 'bedrooms', name: 'bedrooms' },
            { data: 'estimated_price', name: 'estimated_price' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
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
        $('#markConfirmBtn, #markCancelBtn').addClass('d-none');
        $('#inquiryStatus').text('');

        $.ajax({
            url: "{{ route('admin.submission.show') }}",
            type: "GET",
            data: { id: inquiryId },
            success: function(res) {
                $('#inquiryLoader').hide();

                let inquiry = res.inquiry;
                let images = inquiry.property_images ? inquiry.property_images.split(',') : [];

                // ✅ Fix asset path for images
                let basePath = "{{ asset('') }}"; // e.g. http://yourdomain.com/
                let imageGallery = '';

                if (images.length > 0) {
                    imageGallery = `<div class="row g-3 mb-4">`;
                    images.forEach(img => {
                        let imageUrl = basePath + img.trim();
                        imageGallery += `
                            <div class="col-md-4 col-6">
                                <div class="border rounded shadow-sm p-1">
                                    <img src="${imageUrl}" 
                                         alt="Property Image" 
                                         class="img-fluid rounded" 
                                         style="height:160px;object-fit:cover;width:100%;">
                                </div>
                            </div>`;
                    });
                    imageGallery += `</div>`;
                } else {
                    imageGallery = `<p class="text-center text-muted mb-3">No images available.</p>`;
                }

                // ✅ Status mapping (integer → text)
                let statusText = '';
                let statusClass = '';

                switch (parseInt(inquiry.status)) {
                    case 1:
                        statusText = 'Pending';
                        statusClass = 'text-warning';
                        $('#markConfirmBtn, #markCancelBtn').removeClass('d-none').data('id', inquiry.id);
                        break;
                    case 2:
                        statusText = 'Confirmed';
                        statusClass = 'text-success';
                        break;
                    case 3:
                        statusText = 'Cancelled';
                        statusClass = 'text-danger';
                        break;
                    default:
                        statusText = 'Unknown';
                        statusClass = 'text-muted';
                }

                // ✅ Create nicely formatted content
                let html = `
                    ${imageGallery}
                    <div class="border p-3 rounded shadow-sm">
                        <p><strong>Name:</strong> ${inquiry.name || 'N/A'}</p>
                        <p><strong>Phone:</strong> ${inquiry.phone || 'N/A'}</p>
                        <p><strong>Email:</strong> ${inquiry.email || 'N/A'}</p>
                        <p><strong>Address:</strong> ${inquiry.address || 'N/A'}</p>
                        <p><strong>Bedrooms:</strong> ${inquiry.property_bedrooms || 'N/A'}</p>
                        <p><strong>Space:</strong> ${inquiry.property_space ? inquiry.property_space + ' sqft' : 'N/A'}</p>
                        <p><strong>Estimated Price:</strong> ${inquiry.property_estimated_price ? '৳' + inquiry.property_estimated_price : 'N/A'}</p>
                    </div>
                `;

                $('#inquiryContent').html(html);
                $('#inquiryStatus').html(`<span class="${statusClass}">Status: ${statusText}</span>`);
            },
            error: function() {
                $('#inquiryLoader').hide();
                $('#inquiryContent').html('<p class="text-danger text-center">Failed to load inquiry details.</p>');
            }
        });
    });

    // ✅ Confirm Inquiry
    $(document).on('click', '#markConfirmBtn', function() {
        let id = $(this).data('id');
        updateInquiryStatus(id, 2, 'Inquiry marked as Confirmed!', 'Confirmed', 'text-success');
    });

    // ✅ Cancel Inquiry
    $(document).on('click', '#markCancelBtn', function() {
        let id = $(this).data('id');
        updateInquiryStatus(id, 3, 'Inquiry marked as Cancelled!', 'Cancelled', 'text-danger');
    });

    // ✅ Shared update function
    function updateInquiryStatus(id, status, toastMsg, label, labelClass) {
        $.ajax({
            url: "{{ route('admin.submission.updateStatus') }}",
            type: "POST",
            data: {
                id: id,
                status: status,
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function() {
                $('#markConfirmBtn, #markCancelBtn').prop('disabled', true).text('Processing...');
            },
            success: function() {
                toastr.success(toastMsg);
                $('#inquiryStatus').html(`<span class="${labelClass}">Status: ${label}</span>`);
                $('#markConfirmBtn, #markCancelBtn').addClass('d-none');
                $('#rentInquiryTable').DataTable().ajax.reload();
            },
            error: function() {
                toastr.error('Failed to update status.');
                $('#markConfirmBtn').prop('disabled', false).html('<i class="fa-solid fa-check me-1"></i> Mark as Confirmed');
                $('#markCancelBtn').prop('disabled', false).html('<i class="fa-solid fa-xmark me-1"></i> Mark as Cancelled');
            }
        });
    }
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