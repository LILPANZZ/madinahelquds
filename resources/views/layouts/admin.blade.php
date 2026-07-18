<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Ponpes Madinah El-Quds')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#1e3a5f] text-white flex flex-col h-screen fixed left-0 top-0 z-40 overflow-y-auto" style="width: 256px; height: 100vh;">
            <!-- Logo -->
            <div class="p-4 flex items-center gap-3 border-b border-blue-800">
                <div class="w-10 h-10 rounded-full flex items-center justify-center overflow-hidden bg-gray-200">
                    <img src="{{ asset('images/logo-admin.jpg') }}" alt="Logo Madinah El-Quds" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.innerHTML='<span class=\'text-[#1e3a5f] font-bold text-lg\'>M</span>'">
                </div>
                <div>
                    <h1 class="font-bold text-sm leading-tight">Madinah El-Quds</h1>
                    <p class="text-xs text-gray-300">Ponpes Modern</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.berita.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.berita.*') ? 'bg-[#2d5a3d] text-white' : 'text-gray-300 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                            <span>Berita</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.prestasi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.prestasi.*') ? 'bg-[#2d5a3d] text-white' : 'text-gray-300 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8a2 2 0 002-2v-1H6v1a2 2 0 002 2zM12 3c-2.5 0-4.5 2-4.5 4.5V8h9v-.5C16.5 5 14.5 3 12 3zm-6 5v2a6 6 0 006 6h0a6 6 0 006-6V8"/>
                            </svg>
                            <span>Prestasi</span>
                        </a>
                    </li>
                      <li>
                        <a href="{{ route('admin.galeri.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.galeri.*') ? 'bg-[#2d5a3d] text-white' : 'text-gray-300 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Galeri dan Dokumentasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.kegiatan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.kegiatan.*') ? 'bg-[#2d5a3d] text-white' : 'text-gray-300 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Kegiatan Ekstrakurikuler</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.fasilitas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.fasilitas.*') ? 'bg-[#2d5a3d] text-white' : 'text-gray-300 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span>Fasilitas</span>
                        </a>
                    </li>
                      <li>
                        <a href="{{ route('admin.pengumuman.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.pengumuman.*') ? 'bg-[#2d5a3d] text-white' : 'text-gray-300 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                            <span>Pengumuman</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.profil.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.profil.*') ? 'bg-[#2d5a3d] text-white' : 'text-gray-300 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Profil</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.komentar.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.komentar.*') ? 'bg-[#2d5a3d] text-white' : 'text-gray-300 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            <span>Komentar</span>
                        </a>
                    </li>
                  
                    <li class="border-t border-white/30 pt-2 mt-2">
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#f43f5e] hover:bg-blue-800 w-full text-left">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col ml-64" style="margin-left: 256px;">
            <!-- Header -->
            <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>

        
        </div>
    </div>

    <script>
    function addFileInput(containerId, inputName, mainPreviewId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2 mt-2';
        div.innerHTML = `
            <img src="" class="w-10 h-10 hidden object-cover rounded shadow-sm border border-gray-200">
            <input type="file" name="${inputName}" accept="image/*"
                class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                onchange="previewMulti(this, '${mainPreviewId}')">
            <button type="button" onclick="this.parentElement.remove(); updateMainPreview('${containerId}', '${mainPreviewId}')" class="bg-pink-50 p-2 rounded text-pink-500 font-bold hover:bg-pink-100 flex-shrink-0">x</button>
        `;
        container.appendChild(div);
    }

    function removeImage(imageName, btnElement) {
        const container = btnElement.closest('.relative');
        const form = container.closest('form');
        
        // Buat input hidden untuk menandai gambar ini akan dihapus
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'delete_gambar[]';
        hiddenInput.value = imageName;
        form.appendChild(hiddenInput);
        
        // Sembunyikan elemen secara visual
        container.style.display = 'none';
    }

    function previewMulti(input, mainPreviewId) {
        const img = input.parentElement.querySelector('img');
        if (img && input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                img.classList.remove('hidden');
                // Update main preview if we just loaded the first image and main is empty or we are the first input
                updateMainPreview(input.closest('.space-y-2').id, mainPreviewId);
            };
            reader.readAsDataURL(input.files[0]);
        } else if (img) {
            img.classList.add('hidden');
            img.src = '';
            updateMainPreview(input.closest('.space-y-2') ? input.closest('.space-y-2').id : '', mainPreviewId);
        }
    }

    function updateMainPreview(containerId, mainPreviewId) {
        if(!containerId || !mainPreviewId) return;
        const container = document.getElementById(containerId);
        const mainPreview = document.getElementById(mainPreviewId);
        if(!container || !mainPreview) return;
        
        const inputs = container.querySelectorAll('input[type="file"]');
        let found = false;
        for (let i = 0; i < inputs.length; i++) {
            if (inputs[i].files && inputs[i].files[0]) {
                const reader = new FileReader();
                reader.onload = e => mainPreview.src = e.target.result;
                reader.readAsDataURL(inputs[i].files[0]);
                found = true;
                break; // Stop at first valid image
            }
        }
        if (!found) {
            mainPreview.src = 'https://placehold.co/600x300/e5e7eb/9ca3af?text=Preview+Gambar';
        }
    }
    </script>
    @yield('scripts')
</body>
</html>
