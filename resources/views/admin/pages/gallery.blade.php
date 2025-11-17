@extends('admin.master')

@section('content')
<style>
    
</style>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Gallery</h4>
        @if ($access->pages_management == 3)
        <div>
            <button id="saveAllBtn" class="btn btn-primary">Save Selected</button>
        </div>
        @endif
    </div>

    <p class="hint">Click the <strong>+</strong> box to add images (multiple). Remove preview before saving by clicking the top-right ×. After saving, saved images can also be removed.</p>

    <div id="galleryArea" class="gallery-wrapper mb-3">
        {{-- Render saved images from DB first --}}
        @foreach($images as $img)
            <div class="gallery-item saved" data-id="{{ $img->id }}" data-path="{{ $img->image }}">
                <div class="remove-btn delete-saved" title="Delete saved image">&times;</div>
                <img src="{{ asset($img->image) }}">
                <div class="saved-badge">Saved</div>
            </div>
        @endforeach

        {{-- Previews (unsaved) will be appended here by JS (they have class preview) --}}
        @if ($access->pages_management == 3)
        <!-- Add button always at the end -->
        <div id="addBox" class="gallery-add" title="Add images">
            <div class="plus">+</div>
        </div>
        @endif
    </div>

    <div class="controls">
        <div class="text-muted small">Selected (unsaved) images are shown without "Saved" badge. Click Save Selected to upload them.</div>
    </div>

    <!-- hidden file input -->
    <input type="file" id="imagePicker" accept="image/*" multiple style="display:none;">
</div>
@endsection

@section('scripts')

<script>
// CSRF token setup for fetch
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

// DOM elements
const addBox = document.getElementById('addBox');
const imagePicker = document.getElementById('imagePicker');
const galleryArea = document.getElementById('galleryArea');
const saveAllBtn = document.getElementById('saveAllBtn');

// We'll keep an array of selected files (File objects) and their ids in previews
let selectedFiles = []; // {id: previewId, file: File}
let previewCounter = 0;

// click plus -> open file picker
addBox.addEventListener('click', () => imagePicker.click());

imagePicker.addEventListener('change', (e) => {
    const files = Array.from(e.target.files || []);
    if (!files.length) return;

    files.forEach(file => {
        // basic client-side validation
        if (!file.type.startsWith('image/')) {
            toastr.error('Only image files are allowed.');
            return;
        }
        // limit check example: 5MB
        if (file.size > 2 * 1024 * 1024) {
            toastr.error(file.name + ' is larger than 5MB.');
            return;
        }

        const reader = new FileReader();
        const previewId = 'preview-' + (++previewCounter);
        reader.onload = function(ev) {
            // create preview element
            const div = document.createElement('div');
            div.className = 'gallery-item preview';
            div.setAttribute('data-preview-id', previewId);

            // remove button
            const rem = document.createElement('div');
            rem.className = 'remove-btn remove-preview';
            rem.title = 'Remove';
            rem.innerHTML = '&times;';
            rem.addEventListener('click', () => {
                // remove from DOM and selectedFiles
                div.remove();
                selectedFiles = selectedFiles.filter(s => s.id !== previewId);
            });

            // image
            const img = document.createElement('img');
            img.src = ev.target.result;
            img.alt = file.name;

            div.appendChild(rem);
            div.appendChild(img);

            // insert before the addBox (which should be last)
            galleryArea.insertBefore(div, addBox);

            // save reference
            selectedFiles.push({ id: previewId, file });
        };
        reader.readAsDataURL(file);
    });

    // reset input so selecting same files again works
    e.target.value = '';
});

// Save Selected via AJAX
saveAllBtn.addEventListener('click', async () => {
    if (!selectedFiles.length) {
        toastr.info('No new images selected to upload.');
        return;
    }

    const fd = new FormData();
    selectedFiles.forEach((s, idx) => {
        fd.append('images[]', s.file);
    });

    saveAllBtn.disabled = true;
    saveAllBtn.innerText = 'Uploading...';

    try {
        const res = await fetch("{{ route('admin.gallery.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            body: fd
        });

        const data = await res.json();
        if (!res.ok || data.status !== 'success') {
            // show validation errors if any
            if (data.errors) {
                const errs = Object.values(data.errors).flat().join('<br>');
                toastr.error(errs);
            } else {
                toastr.error(data.message || 'Upload failed.');
            }
            saveAllBtn.disabled = false;
            saveAllBtn.innerText = 'Save Selected';
            return;
        }

        // Clear selectedFiles and convert previews into saved items using returned data
        const saved = data.data || [];

        // For each saved record, find a preview in DOM (by matching file name or order)
        // We'll just append saved items at end (before addBox) and remove corresponding previews
        // Simpler: remove all previews and then add saved images returned by server
        document.querySelectorAll('.gallery-item.preview').forEach(el => el.remove());
        selectedFiles = [];

        saved.forEach(item => {
            const div = document.createElement('div');
            div.className = 'gallery-item saved';
            div.setAttribute('data-id', item.id);
            div.setAttribute('data-path', item.relative);

            const rem = document.createElement('div');
            rem.className = 'remove-btn delete-saved';
            rem.title = 'Delete';
            rem.innerHTML = '&times;';
            rem.addEventListener('click', handleDeleteSaved);

            const img = document.createElement('img');
            img.src = item.image;
            img.alt = item.original_name || 'image';

            const badge = document.createElement('div');
            badge.className = 'saved-badge';
            badge.innerText = 'Saved';

            div.appendChild(rem);
            div.appendChild(img);
            div.appendChild(badge);

            galleryArea.insertBefore(div, addBox);
        });

        toastr.success(data.message || 'Uploaded successfully.');
    } catch (err) {
        console.error(err);
        toastr.error('An error occurred while uploading.');
    } finally {
        saveAllBtn.disabled = false;
        saveAllBtn.innerText = 'Save Selected';
    }
});

// Delete saved image handler (attached to elements)
function handleDeleteSaved(e) {
    const target = e.currentTarget;
    const item = target.closest('.gallery-item.saved');
    if (!item) return;

    const id = item.getAttribute('data-id');
    if (!confirm('Are you sure you want to delete this image?')) return;

    // send AJAX delete
    fetch(`{{ url('admin/gallery') }}/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
    }).then(r => r.json()).then(data => {
        if (data.status === 'success') {
            item.remove();
            toastr.success(data.message || 'Deleted.');
        } else {
            toastr.error(data.message || 'Could not delete image.');
        }
    }).catch(err => {
        console.error(err);
        toastr.error('An error occurred.');
    });
}

// attach delete handlers to initial saved images
document.querySelectorAll('.delete-saved').forEach(btn => {
    btn.addEventListener('click', handleDeleteSaved);
});
</script>
@endsection