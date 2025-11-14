@extends('frontend.master')

@section('title')
   Galley
@endsection

@section('content')
<style>
    
    .gallery-thumb {
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    .gallery-thumb:hover {
        transform: scale(1.05);
    }
    .lightbox-overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }
    .lightbox-overlay img {
        max-width: 90%;
        max-height: 85%;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(255,255,255,0.2);
    }
    .lightbox-close {
        position: absolute;
        top: 30px; right: 40px;
        font-size: 40px;
        color: white;
        cursor: pointer;
        transition: 0.3s;
    }
    .lightbox-prev, .lightbox-next {
        position: absolute;
        top: 50%;
        font-size: 50px;
        color: white;
        cursor: pointer;
        transform: translateY(-50%);
        user-select: none;
        padding: 10px;
    }
    .lightbox-prev { left: 30px; }
    .lightbox-next { right: 30px; }
    .lightbox-prev:hover, .lightbox-next:hover, .lightbox-close:hover {
        color: #ddd;
    }
</style>
    <div class="pagesheader" style="height: 100px"></div>
    <div class="breadcramb">
        <div class="container">
            <p class="mb-0 text-sm"> Home > Galley</p>
        </div>
    </div>
    <div class="container py-5">
    <h2 class="text-center fw-bold text-uppercase text-dark mb-5">Gallery</h2>

    <div class="row g-3">
        @foreach($galleryImages as $index => $image)
            <div class="col-6 col-md-3">
                <div class="gallery-item position-relative overflow-hidden rounded-3 shadow-sm">
                    <img src="{{ asset($image->image) }}" 
                         class="img-fluid w-100 gallery-thumb" 
                         data-index="{{ $index }}" 
                         alt="Gallery Image">
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Lightbox Overlay -->
<div id="lightbox" class="lightbox-overlay d-none">
    <span class="lightbox-close">&times;</span>
    <img class="lightbox-image" id="lightbox-image" src="">
    <span class="lightbox-prev">&#10094;</span>
    <span class="lightbox-next">&#10095;</span>
</div>
@endsection

@section('customJs')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const images = Array.from(document.querySelectorAll('.gallery-thumb'));
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        const closeBtn = document.querySelector('.lightbox-close');
        const nextBtn = document.querySelector('.lightbox-next');
        const prevBtn = document.querySelector('.lightbox-prev');
        let currentIndex = 0;

        function showImage(index) {
            currentIndex = index;
            lightboxImage.src = images[index].src;
            lightbox.classList.remove('d-none');
        }

        images.forEach((img, index) => {
            img.addEventListener('click', () => showImage(index));
        });

        closeBtn.addEventListener('click', () => {
            lightbox.classList.add('d-none');
        });

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % images.length;
            showImage(currentIndex);
        });

        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            showImage(currentIndex);
        });

        // Close on overlay click
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) {
                lightbox.classList.add('d-none');
            }
        });

        // Keyboard support
        document.addEventListener('keydown', (e) => {
            if (lightbox.classList.contains('d-none')) return;
            if (e.key === 'Escape') lightbox.classList.add('d-none');
            if (e.key === 'ArrowRight') nextBtn.click();
            if (e.key === 'ArrowLeft') prevBtn.click();
        });
    });
</script>
@endsection
