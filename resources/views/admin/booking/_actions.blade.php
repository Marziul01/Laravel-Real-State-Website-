<div class="d-flex gap-2">
    <button class="btn btn-sm btn-info view-booking" data-id="{{ $row->id }}">
        <i class="bi bi-eye"></i> View
    </button>
    <a href="{{ route('admin.bookings.edits',$row->id  ) }}"  class="btn btn-sm btn-success confirm-booking" >Edit</a>
    <form action="{{ route('booking.delete', $row->id) }}" method="POST" class="d-inline delete-confirm-form">
        @csrf
       
        <button type="submit" class="btn btn-sm btn-danger delete-confirm">
            Delete
        </button>
    </form>
    <a href="{{ route('booking.invoice.show', $row->id) }}" target="_blank"  class="btn btn-sm btn-primary " ><i class="fa-solid fa-download"></i> Invoice</a>
</div>
