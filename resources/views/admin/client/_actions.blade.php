<div class="btn-group">
    <a href="javascript:void(0)" 
        class="btn btn-sm btn-info viewInquiryBtn" 
        data-id="{{ $row->id }}">
        <i class="fa-solid fa-eye"></i>
    </a>
    @if ($access->property_submissions == 3)
        <form action="{{ route('admin.submission.delete', $row->id) }}" method="POST" class="d-inline delete-confirm-form">
            @csrf
        
            <button type="submit" class="btn btn-sm btn-danger deleteInquiryBtn delete-confirm">
                Delete
            </button>
        </form>
    @endif
</div>
