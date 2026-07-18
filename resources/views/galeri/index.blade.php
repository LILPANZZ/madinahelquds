@extends('layouts.public')

@section('title', 'Galeri')

@section('styles')
<style>
    .galeri-hero {
        background-image: linear-gradient(to bottom, rgba(30,58,95,0.3), rgba(30,58,95,0.7)), url('{{ asset('storage/bg/bg2.png') }}');
        background-size: cover;
        background-position: center;
    }

    /* Lightbox styles */
    .lightbox-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.85);
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        backdrop-filter: blur(4px);
    }
    .lightbox-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .lightbox-content {
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        transform: scale(0.9) translateY(20px);
        transition: transform 0.3s ease;
    }
    .lightbox-overlay.active .lightbox-content {
        transform: scale(1) translateY(0);
    }
    .lightbox-img {
        max-height: 65vh;
        width: 100%;
        object-fit: contain;
        border-radius: 12px 12px 0 0;
    }
    .lightbox-close {
        position: absolute;
        top: -12px;
        right: -12px;
        width: 36px;
        height: 36px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        transition: transform 0.2s ease;
        z-index: 10;
    }
    .lightbox-close:hover {
        transform: scale(1.1);
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="galeri-hero h-80 md:h-[400px] flex items-end relative">
        <div class="absolute inset-0 bg-gradient-to-t from-[#1e3a5f]/80 to-transparent"></div>
    </section>

    <!-- Content Section -->
    <section class="py-12 bg-[#f0f4f8]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold text-[#1e3a5f] mb-8">Galeri dan Dokumentasi</h1>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($galeris as $galeri)
                <div class="relative group overflow-hidden rounded-xl aspect-square cursor-pointer"
                     onclick="openLightbox(this)"
                     data-images="{{ implode(',', array_map(function($f) { return asset('storage/' . $f); },  (is_array($galeri->gambar) ? $galeri->gambar : (is_string($galeri->gambar) && $galeri->gambar ? [$galeri->gambar] : [])))) }}"
                     data-judul="{{ $galeri->judul }}"
                     data-deskripsi="{{ $galeri->deskripsi }}">
                    <img src="{{ asset('storage/' . ((is_array($galeri->gambar) && count($galeri->gambar) > 0 ? $galeri->gambar[0] : (is_string($galeri->gambar) && $galeri->gambar ? $galeri->gambar : '')))) }}" alt="{{ $galeri->judul }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=300'">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1e3a5f]/80 to-transparent opacity-70 hover:opacity-100 transition duration-300 flex items-end p-4">
                        <div>
                            <h3 class="text-white font-medium text-sm">{{ $galeri->judul }}</h3>
                            <p class="text-white text-xs mt-1 line-clamp-2">{{ $galeri->deskripsi }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Fallback if no data -->
                <div class="col-span-full text-center py-12 text-gray-500">
                    <p>Belum ada data galeri yang tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div id="galeri-lightbox" class="lightbox-overlay" onclick="closeLightbox(event)">
        <div class="lightbox-content relative">
            <button class="lightbox-close" onclick="closeLightbox(event, true)">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="relative bg-[#1e3a5f] rounded-xl overflow-hidden flex flex-col shadow-2xl">
                <div class="w-full bg-gray-900 flex items-center justify-center h-[45vh] sm:h-[55vh]">
                    <div class="relative w-full h-64 sm:h-80 group bg-gray-100">
            <div id="lightbox-img-container" class="flex overflow-x-auto snap-x snap-mandatory w-full h-full scroll-smooth" style="scrollbar-width: none;"></div>
            <button type="button" onclick="document.getElementById('lightbox-img-container').scrollBy({left: -document.getElementById('lightbox-img-container').clientWidth, behavior: 'smooth'})" class="absolute left-2 top-1/2 -translate-y-1/2 text-white w-10 h-10 shadow-lg   flex items-center justify-center rounded-full opacity-70 hover:opacity-100 transition-opacity hover:bg-black/70 slider-btn slider-btn-left">&#10094;</button>
            <button type="button" onclick="document.getElementById('lightbox-img-container').scrollBy({left: document.getElementById('lightbox-img-container').clientWidth, behavior: 'smooth'})" class="absolute right-2 top-1/2 -translate-y-1/2 text-white w-10 h-10 shadow-lg   flex items-center justify-center rounded-full opacity-70 hover:opacity-100 transition-opacity hover:bg-black/70 slider-btn slider-btn-right">&#10095;</button>
        </div>
                </div>
                <div class="p-6 max-h-[35vh] overflow-y-auto">
                    <h3 id="lightbox-judul" class="text-xl font-bold text-white mb-2"></h3>
                    <p id="lightbox-deskripsi" class="text-gray-200 text-sm leading-relaxed whitespace-pre-wrap"></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
function openLightbox(element) {
        const container = document.getElementById('lightbox-img-container');
    if (container) {
        container.innerHTML = '';
        let imagesAttr = element.getAttribute('data-images');
        let images = imagesAttr ? imagesAttr.split(',').filter(i => i.trim() !== '') : [];
        if (images.length === 0) {
            images.push('https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600');
        }
        images.forEach(imgUrl => {
            let fullImg = imgUrl.startsWith('http') || imgUrl.startsWith('/storage') ? imgUrl : '/storage/' + imgUrl;
            let objectClass = element.getAttribute('onclick') && element.getAttribute('onclick').includes('Galeri') ? 'object-contain' : 'object-cover';
            container.innerHTML += '<div class="w-full h-full flex-shrink-0 snap-center" style="min-width: 100%;"><img src="' + fullImg + '" class="w-full h-full ' + objectClass + '" onerror="this.src=\'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600\'"></div>';
        });
    }
    document.getElementById('lightbox-judul').textContent = element.getAttribute('data-judul');
    document.getElementById('lightbox-deskripsi').textContent = element.getAttribute('data-deskripsi');
    document.getElementById('galeri-lightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox(event, forceClose = false) {
    if (forceClose || event.target === document.getElementById('galeri-lightbox')) {
        document.getElementById('galeri-lightbox').classList.remove('active');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.getElementById('galeri-lightbox').classList.remove('active');
        document.body.style.overflow = '';
    }
});
</script>
@endsection

