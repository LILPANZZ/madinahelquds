@extends('layouts.public')

@section('title', $kegiatan->judul)

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Link -->
        <a href="/" class="text-green-600 hover:text-green-700 flex items-center gap-2 mb-6 transition w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Beranda
        </a>

        <!-- Article -->
        <article class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Image -->
            <div class="w-full h-64 md:h-80 overflow-hidden">
                <img src="{{ asset('storage/' . (is_array($kegiatan->foto) && count($kegiatan->foto) > 0 ? $kegiatan->foto[0] : '')) }}" alt="{{ $kegiatan->judul }}" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800'">
            </div>

            <!-- Content -->
            <div class="p-8 md:p-12">
                <!-- Meta -->
                <div class="flex items-center gap-4 mb-4 text-sm text-gray-500">
                    @if($kegiatan->tanggal)
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $kegiatan->tanggal->format('d M Y') }}
                    </span>
                    @endif
                    @if($kegiatan->waktu_mulai)
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $kegiatan->waktu_mulai->format('H:i') }}
                        @if($kegiatan->waktu_selesai) - {{ $kegiatan->waktu_selesai->format('H:i') }}@endif
                    </span>
                    @endif
                    @if($kegiatan->tempat)
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $kegiatan->tempat }}
                    </span>
                    @endif
                </div>

                <!-- Title -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">{{ $kegiatan->judul }}</h1>

                <!-- Description -->
                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($kegiatan->deskripsi)) !!}
                </div>
            </div>
        </article>
    </div>
</div>
@endsection
