<x-layouts.app>
    <x-slot:title>Hasil Rekomendasi Anda</x-slot:title>

    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('spk.recommendation') }}" class="flex items-center text-gray-600 hover:text-blue-600 transition">
                <span class="material-symbols-rounded mr-1">arrow_back</span>
                Ubah Preferensi
            </a>
        </div>

        <!-- JUARA 1 -->
        @if(count($recommendations ?? []) > 0)
        <div class="bg-blue-600 bg-linear-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white shadow-xl mb-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 bg-white/10 w-32 h-32 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 text-center">
            <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">Rekomendasi Terbaik #1</span>            
            <h2 class="text-4xl font-bold mb-2">{{ $recommendations[0]['name'] ?? 'Nama Produk' }}</h2>
            
            <p class="text-blue-100 mb-6">Produk ini paling sesuai dengan preferensi bobot yang Anda inputkan.</p>
            
            <div class="text-6xl font-bold text-white mb-2">
                {{ number_format($recommendations[0]['score'] ?? 0, 2) }}<span class="text-2xl">%</span>
            </div>
            <div class="text-sm text-blue-200">Skor Kecocokan</div>
        </div>
    </div>
        @endif

        <!-- List Ranking Lainnya -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 bg-gray-50 border-b border-gray-200 font-semibold text-gray-700">
                Alternatif Lainnya
            </div>
            <ul class="divide-y divide-gray-100">
                @foreach($recommendations as $index => $rec)
                    @if($index > 0) <!-- Skip Juara 1 karena sudah di atas -->
                    <li class="p-4 hover:bg-gray-50 transition flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-600">
                                #{{ $index + 1 }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $rec['name'] }}</h4>
                                <span class="text-xs text-gray-500">{{ $rec['code'] }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-blue-600">{{ number_format($rec['score'], 2) }}%</div>
                            <div class="w-24 bg-gray-200 rounded-full h-1.5 mt-1">
                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $rec['score'] }}%"></div>
                            </div>
                        </div>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
        
    </div>
</x-layouts.app>