@extends('layouts.public')

@section('title', 'Tentang Jogja')

@section('styles')
<style>
    .jogja-hero {
        background-image: linear-gradient(to bottom, rgba(30,58,95,0.3), rgba(30,58,95,0.7)), url('{{ asset('storage/bg/bg2.png') }}');
        background-size: cover;
        background-position: center;
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="jogja-hero h-80 md:h-[400px] flex items-end relative">
        <div class="absolute inset-0 bg-gradient-to-t from-[#1e3a5f]/80 to-transparent"></div>
    </section>

    <!-- Content Section -->
    <section class="py-12 bg-[#f0f4f8]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold text-[#1e3a5f] mb-8">Tentang Jogja</h1>
            
            <div class="grid md:grid-cols-2 gap-8 items-start">
                <!-- Image -->
                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/jogja/tugu.jpg') }}" alt="Tugu Jogja" class="w-full h-64 md:h-80 object-cover" onerror="this.src='https://images.unsplash.com/photo-1588090377272-aacbf804f3d3?w=600'">
                </div>
                
                <!-- Text Content -->
                <div class="text-gray-700 leading-relaxed space-y-4">
                    <p>
                        Yogyakarta, atau yang akrab disebut Jogja, merupakan kota pelajar yang kaya akan nilai-nilai budaya dan pendidikan. Sebagai salah satu kota tertua di Indonesia, Jogja memiliki atmosfer akademis yang kuat dengan kehadiran berbagai perguruan tinggi terkemuka.
                    </p>
                    <p>
                        Bagi santri Madinah El-Quds, kehidupan di Jogja menawarkan pengalaman unik memadukan tradisi pesantren dengan dinamika kota modern. Lingkungan yang kondusif mendukung proses belajar mengajar, sementara nilai-nilai keIslaman yang kental di masyarakat Yogyakarta semakin memperkuat pembentukan karakter santri.
                    </p>
                    <p>
                        Lokasi pesantren yang berada di daerah Wates, Kulon Progo, memberikan suasana yang tenang dan jauh dari hiruk pikuk kota, namun tetap mudah dijangkau. Santri dapat menikmati udara segar pedesaan sambil tetap memiliki akses ke berbagai fasilitas penting di Yogyakarta.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
