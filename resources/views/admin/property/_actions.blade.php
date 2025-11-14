@if ( ( $row->type == 'rent' && $access->rent_property == 3 ) || ( $row->type == 'sell' && $access->sell_property == 3 ) )
    <div class="d-flex align-items-center gap-1 cursor-pointer">

        <a href="{{ route('property.edit', $row->id) }}" class="btn btn-sm btn-secondary">
            <i class="bx bx-edit-alt me-1"></i> Edit
        </a>

        <form action="{{ route('property.destroy', $row->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger delete-confirm">
                <i class="bx bx-trash me-1"></i> Delete
            </button>
        </form>

    </div>
@endif
