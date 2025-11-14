@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
       
    <form id="aboutForm" enctype="multipart/form-data">
        @csrf

        <!-- About Section -->
        <div class="card mb-4">
            <div class="card-header text-white">About Section</div>
            <div class="card-body row g-3">
                <div class="col-12">
                    <label class="form-label">About Content</label>
                    <textarea name="about_content" class="form-control" rows="4">{{ $about->about_content ?? '' }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Image Upload</label>
                    <input type="file" name="image" class="form-control">
                    @if(!empty($about->image))
                        <img src="{{ asset($about->image) }}" class="img-fluid rounded mt-2" style="max-height:200px;">
                    @endif
                </div>
            </div>
        </div>

        <!-- Mission & Vision -->
        <div class="card mb-4">
            <div class="card-header  text-white">Mission & Vision</div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label class="form-label">Mission</label>
                    <textarea name="mission" class="form-control" rows="3">{{ $about->mission ?? '' }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Vision</label>
                    <textarea name="vision" class="form-control" rows="3">{{ $about->vision ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Why Buy Section -->
        {{-- ==================== WHY BUY SECTION ==================== --}}
<div class="card mb-4">
    <div class="card-header text-white">
        <h5 class="mb-0"><i class="fa-solid fa-cart-shopping me-2"></i>Why Buy</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach (range(1, 9) as $i)
                @php
                    $value = $about->{'why_buy_' . $i} ?? '';
                    $parts = explode(',', $value);
                    $icon = $parts[0] ?? '';
                    $text = $parts[1] ?? '';
                @endphp
                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <label class="form-label fw-bold">Why Buy {{ $i }}</label>
                        <div class="row g-2 align-items-start">
                            <div class="col-md-5 d-flex align-items-center gap-2">
                                <input type="text" 
                                    id="iconPicker_buy_{{ $i }}" 
                                    name="why_buy_{{ $i }}_icon"
                                    class="form-control icon-input"
                                    value="{{ $icon }}"
                                    placeholder="Select icon">
                                <div class="mt-2 text-center">
                                    <i id="iconPreview_buy_{{ $i }}" class="{{ $icon }} fs-4"></i>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <input type="text" 
                                    name="why_buy_{{ $i }}_name"
                                    class="form-control"
                                    placeholder="Enter title"
                                    value="{{ $text }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ==================== WHY SELL SECTION ==================== --}}
<div class="card mb-4">
    <div class="card-header text-white">
        <h5 class="mb-0"><i class="fa-solid fa-tags me-2"></i>Why Sell</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach (range(1, 9) as $i)
                @php
                    $value = $about->{'why_sell_' . $i} ?? '';
                    $parts = explode(',', $value);
                    $icon = $parts[0] ?? '';
                    $text = $parts[1] ?? '';
                @endphp
                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <label class="form-label fw-bold">Why Sell {{ $i }}</label>
                        <div class="row g-2 align-items-center">
                            <div class="col-md-5 d-flex align-items-center gap-2">
                                <input type="text" 
                                    id="iconPicker_sell_{{ $i }}" 
                                    name="why_sell_{{ $i }}_icon"
                                    class="form-control icon-input"
                                    value="{{ $icon }}"
                                    placeholder="Select icon">
                                <div class="mt-2 text-center">
                                    <i id="iconPreview_sell_{{ $i }}" class="{{ $icon }} fs-4"></i>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <input type="text" 
                                    name="why_sell_{{ $i }}_name"
                                    class="form-control"
                                    placeholder="Enter title"
                                    value="{{ $text }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
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
$(document).ready(function () {
    // Initialize iconpickers for all icon inputs
    $('[id^="iconPicker_buy_"], [id^="iconPicker_sell_"]').each(function () {
        const input = $(this);
        const previewId = input.attr('id').replace('iconPicker', 'iconPreview');

        // Destroy if already exists (safe re-init)
        input.iconpicker('destroy');

        // Initialize iconpicker
        input.iconpicker({
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
            // Update preview
            $('#' + previewId).attr('class', event.iconpickerValue + ' fs-4');
            input.val(event.iconpickerValue);
        });
    });
});
</script>


<script>
    $('#aboutForm').on('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: '{{ route("admin.about.update") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
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
                toastr.error(res.message || 'Something went wrong.');
            }
        },
        error: function(xhr) {
            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                $.each(xhr.responseJSON.errors, function (key, value) {
                    toastr.error(value[0]);
                });
            } else {
                toastr.error('An unexpected error occurred.');
            }
        }
    });
});

</script>
@endsection