@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
       
    <form id="seoSettingsForm">
    @csrf

    <div class="card mb-4">
        <div class="card-header">
            <h3>Meta & Google Settings</h3>
        </div>

        <div class="card-body row g-3">

            <label>Google Tag Manager ID (GTM-XXXXXX)</label>
            <input type="text" name="gtm_id" value="{{ $global_setting->gtm_id ?? '' }}" class="form-control">

            <label>Google Analytics 4 ID (G-XXXXXXX)</label>
            <input type="text" name="ga4_id" value="{{ $global_setting->ga4_id ?? '' }}" class="form-control">

            <label>Meta Pixel ID</label>
            <input type="text" name="meta_pixel_id" value="{{ $global_setting->meta_pixel_id ?? '' }}" class="form-control">

            <label>Meta Access Token</label>
            <input type="text" name="meta_access_token" value="{{ $global_setting->meta_access_token ?? '' }}" class="form-control">

            <label>Meta Test Event Code</label>
            <input type="text" name="meta_test_event_code" value="{{ $global_setting->meta_test_event_code ?? '' }}" class="form-control">

        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
</form>

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

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#seoSettingsForm').on('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('admin.seo.settings.update') }}",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,

        beforeSend: function () {
            toastr.clear();
        },

        success: function(res) {
            if (res.success) {
                toastr.success(res.message);
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                toastr.error(res.message || "Something went wrong.");
            }

        },

        error: function(xhr) {
            toastr.error("Error: " + (xhr.responseJSON?.message || "Unexpected error"));
        }
    });

});
</script>


@endsection