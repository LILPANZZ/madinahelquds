<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Madinah El-Quds') - Pondok Pesantren Tahfidz</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-bg {
            background-image: linear-gradient(to bottom, rgba(30,58,95,0.3), rgba(30,58,95,0.7)), url('{{ asset('storage/bg/bg.png') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
    @yield('styles')

    
    <style>
        .slider-btn {
            position: absolute !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            background-color: rgba(31, 41, 55, 0.8) !important; /* gray-800 */
            color: white !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 9999px !important;
            opacity: 0.8 !important;
            width: 2.5rem !important;
            height: 2.5rem !important;
            z-index: 50 !important;
            cursor: pointer !important;
            border: none !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        }
        .slider-btn:hover {
            background-color: rgba(17, 24, 39, 1) !important; /* gray-900 */
            opacity: 1 !important;
        }
        .slider-btn-left {
            left: 0.5rem !important;
        }
        .slider-btn-right {
            right: 0.5rem !important;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50" x-data="{ mobileMenuOpen: false, searchOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('storage/bg/logo.png') }}" alt="Logo" class="h-12 w-auto" onerror="this.style.display='none'">
                    </a>
                </div>
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center gap-8 text-sm">
                    <a href="{{ route('welcome') }}#beranda" class="text-gray-700 hover:text-green-600 font-medium {{ request()->routeIs('welcome') && !request()->has('section') ? 'text-green-600' : '' }}">Tentang Kami</a>
                    <a href="{{ route('berita.public.index') }}" class="text-gray-700 hover:text-green-600 font-medium {{ request()->routeIs('berita.public.index') ? 'text-green-600' : '' }}">Berita Terkini</a>
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button @click="open = !open" class="flex items-center gap-1 font-medium {{ request()->routeIs('jogja.*') ? 'text-green-600' : 'text-gray-700 hover:text-green-600' }} py-2">
                            Kehidupan Pesantren
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute top-full left-0 pt-2 w-56 z-50">
                            <div class="bg-white rounded-lg shadow-lg border border-gray-100 py-2">
                                <a href="{{ route('fasilitas.public.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('fasilitas.public.index') ? 'text-green-600 bg-green-50 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">Fasilitas Sekolah</a>
                                <a href="{{ route('ekstrakurikuler.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('ekstrakurikuler.index') ? 'text-green-600 bg-green-50 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">Kegiatan Ekstrakurikuler</a>
                                <a href="{{ route('prestasi.public.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('prestasi.public.index') ? 'text-green-600 bg-green-50 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">Prestasi Siswa</a>
                                <a href="{{ route('jogja.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('jogja.index') ? 'text-green-600 bg-green-50 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">Tentang Jogja</a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('galeri.public.index') }}" class="text-gray-700 hover:text-green-600 font-medium {{ request()->routeIs('galeri.public.index') ? 'text-green-600' : '' }}">Galeri dan Dokumentasi</a>
                    <button @click="searchOpen = !searchOpen" class="text-gray-700 hover:text-green-600 transition p-2" aria-label="Search">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </nav>
                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-md text-gray-700 hover:text-green-600 hover:bg-gray-100 focus:outline-none">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <!-- Search Dropdown -->
            <div x-show="searchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="absolute top-full left-0 right-0 bg-white shadow-lg border-t border-gray-100 py-4 px-4 sm:px-6 lg:px-8 z-50">
                <form action="{{ route('search') }}" method="GET" class="max-w-2xl mx-auto flex gap-2">
                    <input type="text" name="q" placeholder="Cari berita, kegiatan, fasilitas..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-medium">Cari</button>
                    <button type="button" @click="searchOpen = false" class="text-gray-500 hover:text-gray-700 px-3 py-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </form>
            </div>
            <!-- Mobile Navigation -->
            <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden border-t border-gray-100 py-4">
                <nav class="flex flex-col space-y-3">
                    <a href="{{ route('welcome') }}#beranda" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-green-600 font-medium py-2 {{ request()->routeIs('welcome') && !request()->has('section') ? 'text-green-600' : '' }}">Tentang Kami</a>
                    <a href="{{ route('berita.public.index') }}" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-green-600 font-medium py-2 {{ request()->routeIs('berita.public.index') ? 'text-green-600' : '' }}">Berita Terkini</a>
                    <div class="space-y-2" x-data="{ subOpen: {{ request()->routeIs('jogja.*') ? 'true' : 'false' }} }">
                        <button @click="subOpen = !subOpen" class="flex items-center justify-between w-full font-medium py-2 {{ request()->routeIs('jogja.*') ? 'text-green-600' : 'text-gray-700 hover:text-green-600' }}">
                            Kehidupan Pesantren
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': subOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="subOpen" class="pl-4 space-y-2">
                            <a href="{{ route('fasilitas.public.index') }}" @click="mobileMenuOpen = false" class="block {{ request()->routeIs('fasilitas.public.index') ? 'text-green-600 font-medium' : 'text-gray-600 hover:text-green-600' }} text-sm py-1">Fasilitas Sekolah</a>
                            <a href="{{ route('ekstrakurikuler.index') }}" @click="mobileMenuOpen = false" class="block {{ request()->routeIs('ekstrakurikuler.index') ? 'text-green-600 font-medium' : 'text-gray-600 hover:text-green-600' }} text-sm py-1">Kegiatan Ekstrakurikuler</a>
                            <a href="{{ route('prestasi.public.index') }}" @click="mobileMenuOpen = false" class="block {{ request()->routeIs('prestasi.public.index') ? 'text-green-600 font-medium' : 'text-gray-600 hover:text-green-600' }} text-sm py-1">Prestasi Siswa</a>
                            <a href="{{ route('jogja.index') }}" @click="mobileMenuOpen = false" class="block {{ request()->routeIs('jogja.index') ? 'text-green-600 font-medium' : 'text-gray-600 hover:text-green-600' }} text-sm py-1">Tentang Jogja</a>
                        </div>
                    </div>
                    <a href="{{ route('galeri.public.index') }}" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-green-600 font-medium py-2 {{ request()->routeIs('galeri.public.index') ? 'text-green-600' : '' }}">Galeri dan Dokumentasi</a>
                    <form action="{{ route('search') }}" method="GET" class="flex gap-2 mt-2">
                        <input type="text" name="q" placeholder="Cari..." class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </form>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#1e3a5f] text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo & Name -->
                <div class="md:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('storage/bg/logo.png') }}" alt="Logo" class="h-12 w-auto" onerror="this.style.display='none'">
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Pondok pesantren modern yang mengintegrasikan pendidikan tahfidz Al-Quran dengan teknologi dan bahasa asing.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold mb-4 text-green-400">Tautan Cepat</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('welcome') }}" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('welcome') }}#tentang" class="hover:text-white transition">Profil</a></li>
                        <li><a href="{{ route('welcome') }}#program" class="hover:text-white transition">Program</a></li>
                        <li><a href="{{ route('welcome') }}#berita" class="hover:text-white transition">Berita</a></li>
                        <li><a href="#" class="hover:text-white transition">PPDB Online</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                @php $globalProfil = \App\Models\Profil::first(); @endphp
                <div>
                    <h4 class="font-semibold mb-4 text-green-400">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $globalProfil ? $globalProfil->alamat : 'Sebokarang, Wates, Kulon Progo, DIY' }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $globalProfil ? $globalProfil->telepon : '(0274) 773146' }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ $globalProfil ? $globalProfil->email : 'info@madinahelquds.sch.id' }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Service Hours -->
                <div>
                    <h4 class="font-semibold mb-4 text-green-400">Jam Layanan</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li class="flex justify-between">
                            <span>Senin - Jumat</span>
                            <span>07:00 - 16:00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Sabtu</span>
                            <span>07:00 - 14:00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Minggu / Libur</span>
                            <span>Tutup</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-white/20 mt-12 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} Pondok Pesantren Madinah El-Quds. Semua Hak Dilindungi.</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
