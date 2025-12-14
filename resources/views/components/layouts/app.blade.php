<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SPK Facial Wash' }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Inter -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <!-- Google Fonts: Material Symbols Rounded (Icons) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <style>
        .material-symbols-rounded {
          font-variation-settings:
          'FILL' 0,
          'wght' 400,
          'GRAD' 0,
          'opsz' 24;
          vertical-align: middle;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col fixed h-full z-20 shadow-xl transition-all duration-300">
            <!-- Brand Logo -->
            <div class="h-16 flex items-center px-6 border-b border-slate-800 bg-slate-900">
                <div class="flex items-center gap-3 text-blue-400">
                    <span class="material-symbols-rounded text-3xl">spa</span>
                    <span class="text-lg font-bold tracking-wide text-white">SPK <span class="text-blue-400">Wash</span></span>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto no-scrollbar">
                
                <!-- MENU UMUM (DASHBOARD) -->
                <a href="{{ route('spk.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('spk.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <span class="material-symbols-rounded {{ request()->routeIs('spk.index') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}">dashboard</span>
                    Dashboard
                </a>

                <!-- MENU KHUSUS ADMIN (ROLE 1) -->
                @if(Auth::check() && Auth::user()->role === 1)
                    <div class="pt-6 pb-2 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        Admin Master
                    </div>

                    <a href="{{ route('spk.criteria') }}" 
                       class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('spk.criteria*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <span class="material-symbols-rounded {{ request()->routeIs('spk.criteria*') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}">tune</span>
                        Data Kriteria
                    </a>

                    <a href="{{ route('spk.alternatives') }}" 
                       class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('spk.alternatives*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <span class="material-symbols-rounded {{ request()->routeIs('spk.alternatives*') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}">face_3</span>
                        Data Alternatif
                    </a>

                    <a href="{{ route('spk.analysis') }}" 
                       class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('spk.analysis*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <span class="material-symbols-rounded {{ request()->routeIs('spk.analysis*') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}">edit_note</span>
                        Input Matriks (Fakta)
                    </a>

                    <!-- MENU BARU: LAPORAN RESPONDEN -->
                    <div class="pt-6 pb-2 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        Laporan
                    </div>

                    <a href="{{ route('spk.responden') }}" 
                       class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.report*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <span class="material-symbols-rounded {{ request()->routeIs('spk.responden*') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}">assessment</span>
                        Data Responden
                    </a>

                    <a href="{{ route('spk.report') }}" 
                       class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.report*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <span class="material-symbols-rounded {{ request()->routeIs('spk.report*') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}">assessment</span>
                        Laporan Responden
                    </a>
                @endif

                <!-- MENU KHUSUS USER (ROLE 2) -->
                @if(Auth::check() && Auth::user()->role === 2)
                    <div class="pt-6 pb-2 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        User Area
                    </div>

                    <a href="{{ route('spk.recommendation') }}" 
                       class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('spk.recommendation*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <span class="material-symbols-rounded {{ request()->routeIs('spk.recommendation*') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}">search</span>
                        Cari Rekomendasi
                    </a>
                @endif

            </nav>

            <!-- Footer Sidebar (LOGOUT BUTTON) -->
            <div class="p-4 border-t border-slate-800 bg-slate-900">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-2 w-full text-red-400 hover:text-red-300 hover:bg-slate-800 rounded-lg transition-all text-sm font-medium group">
                        <span class="material-symbols-rounded group-hover:animate-pulse">logout</span>
                        Keluar Sistem
                    </button>
                </form>

                <div class="mt-4 flex items-center gap-3 px-2">
                     <div class="h-8 w-8 rounded-full bg-slate-700 flex items-center justify-center text-xs font-bold text-slate-300 border border-slate-600">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                     </div>
                     <div class="text-xs text-slate-400">
                         <p class="font-semibold text-white">{{ Auth::user()->name ?? 'Guest' }}</p>
                         <p>{{ (Auth::user()->role ?? 0) === 1 ? 'Administrator' : 'User' }}</p>
                     </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <main class="ml-64 flex-1 flex flex-col min-h-screen transition-all duration-300">
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8 sticky top-0 z-10">
                <div class="flex items-center gap-2">
                    <span class="text-gray-400 material-symbols-rounded">sort</span>
                    <h1 class="text-xl font-bold text-gray-800 ml-2">{{ $title ?? 'Dashboard' }}</h1>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-sm text-right hidden sm:block">
                        <p class="text-gray-900 font-medium">{{ Auth::user()->name ?? 'Pengguna' }}</p>
                        <p class="text-gray-500 text-xs">
                            @if(Auth::check())
                                {{ Auth::user()->role === 1 ? 'Administrator' : 'User' }}
                            @endif
                        </p>
                    </div>
                    <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 border border-blue-200">
                        <span class="material-symbols-rounded">person</span>
                    </div>
                </div>
            </header>

            <!-- Content Body -->
            <div class="p-8">
                {{ $slot }}
            </div>
            
            <!-- Footer Content -->
            <footer class="mt-auto px-8 py-6 border-t border-gray-200 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} SPK Facial Wash Metode Weighted Product.
            </footer>
        </main>
    </div>

</body>
</html>