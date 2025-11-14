@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
       
    <form id="aboutForm" enctype="multipart/form-data">
        @csrf

        <!-- About Section -->
        <div class="card mb-4">
            <div class="card-header text-white">Work With Us Page</div>
            <div class="card-body row g-3">
                <div class="col-12">
                    <label class="form-label">Content</label>
                    <textarea name="description" class="form-control" id="summernote" rows="4">{!! $agentpage->description ?? '' !!}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Image Upload</label>
                    <input type="file" name="image" class="form-control">
                    @if(!empty($agentpage->image))
                        <img src="{{ asset($agentpage->image) }}" class="img-fluid rounded mt-2" style="max-height:200px;">
                    @endif
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
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
<script>
$(document).ready(function () {
  $('#summernote').summernote({
    placeholder: 'Write your blog here...',
    tabsize: 2,
    height: 300,
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'underline', 'italic', 'clear']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      ['insert', ['link', 'picture', 'video']],
      ['view', ['fullscreen', 'codeview', 'help']]
    ]
  });
});
</script>
<script>
    $('#aboutForm').on('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: '{{ route("admin.agent.update") }}',
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