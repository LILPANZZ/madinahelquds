@extends('layouts.public')

@section('title', 'Berita Terkini')

@section('styles')
<style>
    .berita-hero {
        background-image: linear-gradient(to bottom, rgba(30,58,95,0.3), rgba(30,58,95,0.7)), url('{{ asset('storage/bg/bg2.png') }}');
        background-size: cover;
        background-position: center;
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="berita-hero h-80 md:h-[400px] flex items-end relative">
        <div class="absolute inset-0 bg-gradient-to-t from-[#1e3a5f]/80 to-transparent"></div>
    </section>

    <!-- Content Section -->
    <section class="py-12 bg-[#f0f4f8]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold text-[#1e3a5f] mb-8">Berita Terkini</h1>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($beritas as $berita)
                <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition">
                    <img src="{{ asset('storage/' . (is_array($berita->gambar) && count($berita->gambar) > 0 ? $berita->gambar[0] : '')) }}" alt="{{ $berita->judul }}" class="w-full h-48 object-cover" onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400'">
                    <div class="p-5">
                        <span class="text-xs text-green-600 font-medium bg-green-50 px-2 py-1 rounded">{{ $berita->tanggal->format('d M Y') }}</span>
                        <h3 class="font-bold text-gray-900 mt-2 text-lg">{{ $berita->judul }}</h3>
                        <p class="text-gray-600 text-sm mt-2">{{ Str::limit(strip_tags($berita->deskripsi), 100) }}</p>
                        @if($berita->tempat)
                        <p class="text-xs text-gray-500 mt-3 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $berita->tempat }}
                        </p>
                        @endif
                        <a href="{{ route('berita.detail', $berita->judul) }}" class="inline-block mt-4 text-green-600 text-sm font-medium hover:underline">Baca Selengkapnya →</a>
                    </div>
                </div>
                @empty
                <!-- Fallback if no data -->
                <div class="col-span-full text-center py-12 text-gray-500">
                    <p>Belum ada berita yang tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
