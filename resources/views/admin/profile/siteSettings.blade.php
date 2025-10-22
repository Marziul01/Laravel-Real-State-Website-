@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="card card-body">
            <div class="row m-0 p-0">
            <form id="siteSettingForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label>Site Name</label>
                        <input type="text" class="form-control" name="site_name" value="{{ $setting->site_name }}">
                        <span class="text-danger error-text site_name_error"></span>
                    </div>
                    
                    <div class="form-group col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="site_email" value="{{ $setting->site_email }}">
                        <span class="text-danger error-text site_email_error"></span>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="site_phone" value="{{ $setting->site_phone }}">
                        <span class="text-danger error-text site_phone_error"></span>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label>Address</label>
                        <input type="text" class="form-control" name="site_address" value="{{ $setting->site_address }}">
                        <span class="text-danger error-text site_address_error"></span>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label>Facebook Link</label>
                        <input type="text" class="form-control" name="facebook" value="{{ $setting->facebook }}">
                        <span class="text-danger error-text site_link_error"></span>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label>Twitter Link</label>
                        <input type="text" class="form-control" name="twitter" value="{{ $setting->twitter }}">
                        <span class="text-danger error-text twitter_error"></span>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label>Whatsapp Link</label>
                        <input type="text" class="form-control" name="whatsapp" value="{{ $setting->whatsapp }}">
                        <span class="text-danger error-text linkedin_error"></span>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label>Instagram Link</label>
                        <input type="text" class="form-control" name="instagram" value="{{ $setting->instagram }}">
                        <span class="text-danger error-text linkedin_error"></span>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label>Site Logo</label>
                        <input type="file" class="form-control" name="site_logo">
                        @if($setting->site_logo)
                            <p class="my-2">Previous Image :</p>
                            <img src="{{ asset($setting->site_logo) }}" alt="Logo" class="mt-2" width="120">
                        @endif
                        <span class="text-danger error-text site_logo_error"></span>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label>Site Favicon</label>
                        <input type="file" class="form-control" name="site_favicon">
                        @if($setting->site_favicon)
                            <p class="my-2">Previous Image :</p>
                            <img src="{{ asset($setting->site_favicon) }}" alt="Favicon" class="mt-2" width="120">
                        @endif
                        <span class="text-danger error-text site_favicon_error"></span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
            </form>
        </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.getElementById('siteSettingForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    // Clear previous errors
    document.querySelectorAll('.error-text').forEach(el => el.innerText = '');

    fetch("{{ route('admin.site-settings.update') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': formData.get('_token'),
        },
        body: formData
    })
    .then(async res => {
        const data = await res.json();

        if (!res.ok) {
            if (data.errors) {
                for (const [key, messages] of Object.entries(data.errors)) {
                    const errorSpan = document.querySelector(`.${key}_error`);
                    if (errorSpan) errorSpan.innerText = messages[0];
                    messages.forEach(msg => toastr.error(msg));
                }
            } else {
                toastr.error('Something went wrong.');
            }
        } else {
            toastr.success(data.message);
            setTimeout(() => location.reload(), 1500);
        }
    })
    .catch(() => toastr.error('Something went wrong.'));
});
</script>



@endsection
