@extends('layouts.public')

@section('title', 'Tentang Kami - Sejarah')

@section('content')
    <!-- Hero Section -->
    <section class="bg-[#1e3a5f] text-white py-20 relative">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-green-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Tentang Kami</h1>
            <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto">
                Mengenal lebih dekat visi, misi, dan sejarah berdirinya Pondok Pesantren Tahfidz Madinah El-Quds.
            </p>
        </div>
    </section>

    <!-- Sejarah Lengkap Section -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <img src="{{ asset('images/building.jpg') }}" alt="Gedung Madinah El-Quds" class="w-full h-auto md:h-[500px] object-cover rounded-2xl shadow-xl mb-10" onerror="this.src='https://images.unsplash.com/photo-1562774053-701939374585?w=1200'">
            </div>
            
            <div class="prose prose-lg max-w-none text-gray-700">
                <h2 class="text-3xl font-bold text-[#1e3a5f] mb-6">Sejarah Berdirinya {{ $profil ? $profil->nama_pondok : 'Madinah El-Quds' }}</h2>
                @if($profil && $profil->sejarah)
                    {!! nl2br(e($profil->sejarah)) !!}
                @else
                    <p>
                        Yayasan Madinah El-Quds merupakan pondok pesantren tahfidz al-quran yang berlokasi di Ds. Sebokarang Kec. Wates Kulon Progo dan dipimpin oleh Prof. Dr. KH. Nuruddin Ali Muhtarom.
                    </p>
                    <p>
                        Didirikan dengan semangat untuk mencetak generasi penghafal Al-Quran yang tidak hanya kuat dalam hafalan dan pemahaman agama, tetapi juga unggul dalam bidang akademik umum, penguasaan bahasa asing, serta cakap dalam memanfaatkan teknologi informasi di era modern.
                    </p>
                    <p>
                        Madinah El-Quds terus berkembang menjadi institusi pendidikan Islam modern yang memadukan kurikulum pesantren salaf (klasik) seperti pengajian kitab kuning, dengan kurikulum nasional dan metode pembelajaran mutakhir.
                    </p>
                @endif
            </div>
        </div>
    </section>

    <!-- Visi Misi Section -->
    <section class="py-16 bg-gray-50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Visi -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Visi Kami</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Menjadi lembaga pendidikan Islam yang unggul dalam menghasilkan generasi Qur'ani yang berakhlak mulia, berilmu luas, dan berkemampuan teknologi untuk kemaslahatan umat.
                    </p>
                </div>
                
                <!-- Misi -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Misi Kami</h3>
                    </div>
                    <ul class="space-y-4 text-gray-600">
                        <li class="flex items-start gap-3">
                            <span class="text-green-500 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span>Menyelenggarakan pendidikan tahfidz Al-Quran dengan metode modern</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-green-500 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span>Membekali santri dengan ilmu syar'i dan umum yang berimbang</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-green-500 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span>Mengembangkan kemampuan bahasa asing dan teknologi informasi</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-green-500 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span>Membentuk akhlak dan kepribadian Islami yang paripurna</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
