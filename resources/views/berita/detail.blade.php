@extends('layouts.public')

@section('title', $berita->judul)

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Article Content -->
            <article class="lg:col-span-2">
                <!-- Breadcrumb -->
                <nav class="text-sm text-gray-500 mb-4">
                    <a href="/" class="hover:text-green-600">Beranda</a>
                    <span class="mx-2">></span>
                    <a href="{{ route('berita.public.index') }}" class="hover:text-green-600">Berita</a>
                    <span class="mx-2">></span>
                    <span class="text-gray-700">{{ $berita->judul }}</span>
                </nav>

                <!-- Title -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">{{ $berita->judul }}</h1>

                <!-- Meta Info -->
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6 pb-6 border-b border-gray-200">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $berita->tanggal->format('d F Y') }}
                    </span>
                    <span>|</span>
                    <span>Editor: Admin</span>
                    <span>|</span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        120 views
                    </span>
                </div>

                <!-- Main Image -->
                @php
                    $rawImages = is_array($berita->gambar) ? $berita->gambar : (is_string($berita->gambar) && $berita->gambar ? [$berita->gambar] : []);
                    $images = array_values(array_filter($rawImages, fn($img) => !empty($img)));
                @endphp
                
                @if(count($images) > 0)
                <div class="relative w-full h-64 md:h-96 overflow-hidden rounded-xl mb-6 group bg-gray-100" x-data='{ currentIndex: 0, images: {!! json_encode($images) !!} }'>
                    <!-- Images -->
                    <template x-for="(img, index) in images" :key="index">
                        <img 
                            x-show="currentIndex === index"
                            x-transition:enter="transition ease-in-out duration-500"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in-out duration-500"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            :src="'/storage/' + img" 
                            alt="{{ $berita->judul }}" 
                            class="absolute inset-0 w-full h-full object-cover" 
                            onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800'">
                    </template>

                    <!-- Navigation Arrows -->
                    <template x-if="images.length > 1">
                        <div>
                            <!-- Prev Button -->
                            <button @click="currentIndex = currentIndex === 0 ? images.length - 1 : currentIndex - 1" class="absolute top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/75 text-white p-2.5 rounded-full transition duration-300 focus:outline-none" style="left: 1rem; z-index: 10;">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <!-- Next Button -->
                            <button @click="currentIndex = currentIndex === images.length - 1 ? 0 : currentIndex + 1" class="absolute top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/75 text-white p-2.5 rounded-full transition duration-300 focus:outline-none" style="right: 1rem; z-index: 10;">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                            
                            <!-- Indicators -->
                            <div class="absolute flex justify-center gap-2" style="bottom: 1rem; left: 0; right: 0; z-index: 10;">
                                <template x-for="(img, index) in images" :key="index">
                                    <button @click="currentIndex = index" :class="{'bg-green-500 w-4': currentIndex === index, 'bg-white/70 w-2': currentIndex !== index}" class="h-2 rounded-full transition-all duration-300 focus:outline-none shadow-sm"></button>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
                @else
                <div class="w-full h-64 md:h-96 overflow-hidden rounded-xl mb-6 bg-gray-100">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
                </div>
                @endif

                <!-- Description/Content -->
                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed mb-8">
                    {!! nl2br(e($berita->deskripsi)) !!}
                </div>

                <!-- Penulis -->
                <div class="text-sm text-gray-500 mb-8">
                    <p>Penulis: Admin | Editor: Admin</p>
                </div>

                <!-- Comments List -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8" x-data="{ replyTo: null }">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Komentar ({{ $berita->komentars()->count() }})</h3>
                    
                    @if($komentars->count() > 0)
                        <div class="space-y-6">
                            @foreach($komentars as $komentar)
                            <div class="border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold flex-shrink-0">
                                        {{ strtoupper(substr($komentar->nama, 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <h4 class="font-semibold text-gray-900">{{ $komentar->nama }}</h4>
                                            <span class="text-xs text-gray-500">{{ $komentar->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-700 text-sm mb-2">{{ $komentar->komentar }}</p>
                                        <button @click="replyTo = replyTo === {{ $komentar->id }} ? null : {{ $komentar->id }}" class="text-xs text-green-600 font-medium hover:underline flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                            Balas
                                        </button>

                                        <!-- Reply Form -->
                                        <div x-show="replyTo === {{ $komentar->id }}" x-transition class="mt-4 bg-gray-50 p-4 rounded-lg" style="display: none;">
                                            <form action="{{ route('berita.komentar', $berita->judul) }}" method="POST" class="space-y-3">
                                                @csrf
                                                <input type="hidden" name="parent_id" value="{{ $komentar->id }}">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                    <div>
                                                        <input type="text" name="nama" placeholder="Nama" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none text-sm" required>
                                                    </div>
                                                    <div>
                                                        <input type="email" name="email" placeholder="Email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none text-sm" required>
                                                    </div>
                                                </div>
                                                <div>
                                                    <textarea name="komentar" rows="2" placeholder="Tulis balasan Anda..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none resize-none text-sm" required></textarea>
                                                </div>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" @click="replyTo = null" class="text-xs px-3 py-2 text-gray-600 hover:text-gray-900 font-medium transition">Batal</button>
                                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-xs px-4 py-2 rounded-md transition font-medium">Kirim Balasan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Replies -->
                                @if($komentar->replies->count() > 0)
                                <div class="mt-4 ml-14 space-y-4">
                                    @foreach($komentar->replies as $reply)
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold flex-shrink-0 text-sm">
                                            {{ strtoupper(substr($reply->nama, 0, 1)) }}
                                        </div>
                                        <div class="flex-1 bg-gray-50 p-3 rounded-lg">
                                            <div class="flex items-center justify-between mb-1">
                                                <h5 class="font-medium text-gray-900 text-sm">{{ $reply->nama }}</h5>
                                                <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-gray-700 text-sm">{{ $reply->komentar }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm text-center py-4">Belum ada komentar. Jadilah yang pertama memberikan komentar!</p>
                    @endif
                </div>

                <!-- Comment Section -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Tinggalkan Komentar</h3>
                    
                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('berita.komentar', $berita->judul) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <input type="text" name="nama" placeholder="Nama" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none" required>
                            </div>
                            <div>
                                <input type="email" name="email" placeholder="Email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none" required>
                            </div>
                        </div>
                        <div>
                            <textarea name="komentar" rows="4" placeholder="Komentar" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none resize-none" required></textarea>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="notify" id="notify" class="w-4 h-4 text-green-600 rounded focus:ring-green-500">
                            <label for="notify" class="text-sm text-gray-600">Beritahu saya tentang tindak lanjut komentar melalui email</label>
                        </div>
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-lg transition font-medium">Kirim Komentar</button>
                    </form>
                </div>
            </article>

            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200">Berita Terkini</h3>
                    <div class="space-y-4">
                        @foreach($beritaTerbaru as $item)
                        @if($item->id != $berita->id)
                        <a href="{{ route('berita.detail', $item->judul) }}" class="flex gap-3 group">
                            <div class="w-20 h-16 flex-shrink-0 rounded-lg overflow-hidden">
                                <img src="{{ '/storage/' . (is_array($item->gambar) && count($item->gambar) > 0 ? $item->gambar[0] : '') }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition" onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=100'">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900 group-hover:text-green-600 transition line-clamp-2">{{ $item->judul }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ Str::limit(strip_tags($item->deskripsi), 50) }}</p>
                            </div>
                        </a>
                        @endif
                        @endforeach
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-xl shadow-md p-6 mt-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200">Kategori</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('berita.public.index', ['kategori' => 'Pendidikan']) }}" class="text-gray-600 hover:text-green-600 transition flex items-center gap-2"><span class="w-2 h-2 bg-green-500 rounded-full"></span>Pendidikan</a></li>
                        <li><a href="{{ route('berita.public.index', ['kategori' => 'Prestasi']) }}" class="text-gray-600 hover:text-green-600 transition flex items-center gap-2"><span class="w-2 h-2 bg-green-500 rounded-full"></span>Prestasi</a></li>
                        <li><a href="{{ route('berita.public.index', ['kategori' => 'Kegiatan']) }}" class="text-gray-600 hover:text-green-600 transition flex items-center gap-2"><span class="w-2 h-2 bg-green-500 rounded-full"></span>Kegiatan</a></li>
                        <li><a href="{{ route('berita.public.index', ['kategori' => 'Pengumuman']) }}" class="text-gray-600 hover:text-green-600 transition flex items-center gap-2"><span class="w-2 h-2 bg-green-500 rounded-full"></span>Pengumuman</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
