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

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <style>
        .material-symbols-rounded {
          font-variation-settings:
          'FILL' 0,
          'wght' 400,
          'GRAD' 0,
          'opsz' 24;
          vertical-align: middle; /* Agar icon sejajar dengan teks */
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
                    <span class="material-symbols-rounded text-3xl">spa</span> <!-- Icon Daun/Spa untuk Facial Wash -->
                    <span class="text-lg font-bold tracking-wide text-white">SPK <span class="text-blue-400">Facial Wash</span></span>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto no-scrollbar">
                
                <a href="{{ route('spk.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('spk.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <span class="material-symbols-rounded {{ request()->routeIs('spk.index') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}">dashboard</span>
                    Dashboard
                </a>

                <div class="pt-6 pb-2 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    Data Master
                </div>

                <a href="{{ route('spk.criteria') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('spk.criteria') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <span class="material-symbols-rounded {{ request()->routeIs('spk.criteria') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}">tune</span> <!-- Icon Sliders -->
                    Data Kriteria
                </a>

                <a href="{{ route('spk.alternatives') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('spk.alternatives') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <span class="material-symbols-rounded {{ request()->routeIs('spk.alternatives') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}">face_3</span> <!-- Icon Wajah -->
                    Data Alternatif
                </a>
                
                <div class="pt-6 pb-2 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    Proses SPK
                </div>

                <a href="{{ route('spk.analysis') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('spk.analysis') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <span class="material-symbols-rounded {{ request()->routeIs('spk.analysis') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}">edit_note</span> <!-- Icon Edit -->
                    Input Analisa
                </a>

                <a href="{{ route('spk.calculation') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('spk.calculation') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <span class="material-symbols-rounded {{ request()->routeIs('spk.calculation') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}">calculate</span> <!-- Icon Kalkulator -->
                    Hasil Perhitungan
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800 bg-slate-900">
                <div class="flex items-center gap-3 px-4 py-2 bg-slate-800 rounded-lg border border-slate-700">
                    <span class="material-symbols-rounded text-slate-400">code</span>
                    <div class="text-xs text-slate-300">
                        <p class="font-semibold">Laravel 12</p>
                        <p class="text-slate-500">Tailwind CSS</p>
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
                        <p class="text-gray-900 font-medium">Administrator</p>
                        <p class="text-gray-500 text-xs">Admin SPK</p>
                    </div>
                    <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 border border-blue-200">
                        <span class="material-symbols-rounded">person</span>
                    </div>
                </div>
            </header>

            <div class="p-8">
                {{ $slot }}
            </div>
            
            <footer class="mt-auto px-8 py-6 border-t border-gray-200 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} SPK Facial Wash Metode Weighted Product.
            </footer>
        </main>
    </div>

</body>
</html>