<x-layouts.app>
    <x-slot:title>
        Dashboard {{ Auth::user()->role === 1 ? 'Administrator' : 'User' }}
    </x-slot:title>

    <div class="space-y-8">
        
        {{-- ========================================== --}}
        {{-- TAMPILAN KHUSUS ADMIN (ROLE 1)             --}}
        {{-- ========================================== --}}
        @if(Auth::user()->role === 1)
            
            <!-- Welcome Banner Admin -->
            <div class="bg-slate-800 bg-linear-to-r from-slate-800 to-slate-900 p-6 rounded-2xl shadow-lg text-white relative overflow-hidden border border-slate-700">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="p-3 bg-white/10 rounded-xl border border-white/10">
                        <span class="material-symbols-rounded text-3xl text-blue-400">admin_panel_settings</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Selamat Datang, Administrator!</h2>
                        <p class="text-slate-200 text-sm mt-1 leading-relaxed">
                            Anda memiliki akses penuh untuk mengelola Data Kriteria, Produk Alternatif, dan memantau Laporan Responden.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Grid Menu Admin -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Card 1: Kriteria -->
                <a href="{{ route('spk.criteria') }}" class="group bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:border-blue-400 transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-blue-100 text-blue-700 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <span class="material-symbols-rounded text-2xl">tune</span>
                        </div>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-1 group-hover:text-blue-700">Data Kriteria</h3>
                    <p class="text-sm text-gray-600">Atur bobot dan atribut penilaian sistem.</p>
                </a>

                <!-- Card 2: Alternatif -->
                <a href="{{ route('spk.alternatives') }}" class="group bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:border-green-400 transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-green-100 text-green-700 rounded-lg group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <span class="material-symbols-rounded text-2xl">face_3</span>
                        </div>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-1 group-hover:text-green-700">Data Alternatif</h3>
                    <p class="text-sm text-gray-600">Kelola daftar produk Facial Wash.</p>
                </a>

                <!-- Card 3: Input Fakta/Matriks -->
                <a href="{{ route('spk.analysis') }}" class="group bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:border-purple-400 transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-purple-100 text-purple-700 rounded-lg group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <span class="material-symbols-rounded text-2xl">rate_review</span>
                        </div>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-1 group-hover:text-purple-700">Data Penilaian</h3>
                    <p class="text-sm text-gray-600">Input spesifikasi/nilai produk.</p>
                </a>

                <!-- Card 4: Laporan -->
                <a href="{{ route('spk.report') }}" class="group bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:border-orange-400 transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-orange-100 text-orange-700 rounded-lg group-hover:bg-orange-600 group-hover:text-white transition-colors">
                            <span class="material-symbols-rounded text-2xl">assessment</span>
                        </div>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-1 group-hover:text-orange-700">Laporan User</h3>
                    <p class="text-sm text-gray-600">Analisa demografi & preferensi responden.</p>
                </a>
            </div>

        {{-- ========================================== --}}
        {{-- TAMPILAN KHUSUS USER (ROLE 2)              --}}
        {{-- ========================================== --}}
        @else
            
            <!-- Hero Section User -->
            <div class="bg-blue-600 bg-linear-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-xl overflow-hidden text-white relative">
                <!-- Background Decoration -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-16 -mt-16 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-10 rounded-full -ml-10 -mb-10 blur-2xl"></div>
                
                <div class="relative z-10 px-8 py-12 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="max-w-lg">
                        <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-4 inline-block border border-white/30">
                            Sistem Pendukung Keputusan
                        </span>
                        <h1 class="text-3xl md:text-4xl font-bold mb-4 leading-tight text-white drop-shadow-sm">
                            Bingung Memilih <br> Facial Wash yang Cocok?
                        </h1>
                        <p class="text-white text-lg mb-8 leading-relaxed opacity-90">
                            Gunakan sistem cerdas kami berbasis metode <strong>Weighted Product</strong> untuk mendapatkan rekomendasi produk terbaik sesuai kebutuhan, budget, dan preferensi kulit Anda.
                        </p>
                        
                        <a href="{{ route('spk.recommendation') }}" class="inline-flex items-center gap-2 bg-white text-blue-700 font-bold py-3 px-6 rounded-full shadow-lg hover:bg-blue-50 hover:shadow-xl transform hover:-translate-y-1 transition-all">
                            <span class="material-symbols-rounded">search</span>
                            Mulai Cari Rekomendasi
                        </a>
                    </div>
                    
                    <!-- Ilustrasi / Icon Besar -->
                    <div class="hidden md:block">
                        <div class="w-48 h-48 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-2xl">
                            <span class="material-symbols-rounded text-9xl text-white drop-shadow-md">spa</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Steps Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm text-center hover:border-blue-300 transition-colors">
                    <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">1</div>
                    <h3 class="font-bold text-gray-800 mb-2">Tentukan Kriteria</h3>
                    <p class="text-sm text-gray-600">Pilih apa yang paling penting bagi Anda (Harga, Aroma, Kualitas, dll).</p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm text-center hover:border-blue-300 transition-colors">
                    <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">2</div>
                    <h3 class="font-bold text-gray-800 mb-2">Sistem Menganalisa</h3>
                    <p class="text-sm text-gray-600">Metode WP akan menghitung kecocokan preferensi Anda dengan data produk.</p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm text-center hover:border-blue-300 transition-colors">
                    <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">3</div>
                    <h3 class="font-bold text-gray-800 mb-2">Dapatkan Hasil</h3>
                    <p class="text-sm text-gray-600">Lihat rekomendasi produk terbaik urutan #1 khusus untuk Anda.</p>
                </div>
            </div>

        @endif
    </div>
</x-layouts.app>