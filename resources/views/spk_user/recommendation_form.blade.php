<x-layouts.app>
    <x-slot:title>Cari Rekomendasi Facial Wash</x-slot:title>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-50 rounded-full blur-2xl"></div>

            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Data Responden</label>
                    <span class="material-symbols-rounded text-blue-200 text-4xl">account_circle</span>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-800 mb-1">{{ Auth::user()->name }}</h2>
                <div class="flex items-center gap-2 text-gray-500 text-sm mb-4">
                    <span class="material-symbols-rounded text-base">mail</span>
                    {{ Auth::user()->email }}
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100 gap-1.5">
                        <span class="material-symbols-rounded text-sm">badge</span>
                        {{ Auth::user()->status ?? 'Status (-)' }}
                    </span>

                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-bold border border-purple-100 gap-1.5">
                        <span class="material-symbols-rounded text-sm">cake</span>
                        {{ Auth::user()->age ?? '-' }} Tahun
                    </span>
                </div>
            </div>
        </div>
        
        @if(isset($lastPreferences) && $lastPreferences)
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 mb-8 rounded-r-lg flex flex-col sm:flex-row items-start gap-4 shadow-sm animate-fade-in">
                <div class="p-2 bg-yellow-100 rounded-full text-yellow-600 shrink-0">
                    <span class="material-symbols-rounded text-2xl">edit_document</span>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-yellow-800 mb-1">Mode Perbarui Preferensi</h2>
                    <p class="text-yellow-700 text-sm leading-relaxed">
                        Anda sebelumnya sudah pernah mengisi kriteria. <br>
                        Silakan ubah bobot di bawah ini jika preferensi Anda berubah, lalu tekan tombol <strong>"Perbarui Hasil"</strong>.
                    </p>
                </div>
            </div>
        @else
            <div class="bg-blue-50 border-l-4 border-blue-600 p-6 mb-8 rounded-r-lg shadow-sm">
                <h2 class="text-xl font-bold text-blue-800 mb-2">Temukan Produk Tepat Untukmu!</h2>
                <p class="text-blue-700">
                    Sistem ini akan merekomendasikan Facial Wash berdasarkan preferensi Anda. 
                    Silakan tentukan seberapa penting setiap faktor di bawah ini bagi keputusan Anda.
                </p>
            </div>
        @endif

        <form action="{{ route('spk.recommendation.process') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($criterias as $c)
                
                @php
                    $savedValue = 3; 

                    if(old('weights.'.$c->id)) {
                        $savedValue = old('weights.'.$c->id);
                    } elseif(isset($lastPreferences) && $lastPreferences) {
                        $criteriaData = $lastPreferences->input_criteria ?? [];
                        if(isset($criteriaData['weights'][$c->id])) {
                            $savedValue = $criteriaData['weights'][$c->id];
                        }
                    }
                @endphp

                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow group">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg group-hover:text-blue-600 transition-colors">{{ $c->name }}</h3>
                            <span class="text-xs font-semibold px-2 py-1 rounded {{ $c->type == 'cost' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                {{ ucfirst($c->type) }} ({{ $c->type == 'cost' ? 'Makin Rendah Makin Baik' : 'Makin Tinggi Makin Baik' }})
                            </span>
                        </div>
                        <span class="material-symbols-rounded text-blue-500 text-3xl opacity-80 group-hover:opacity-100 transition-opacity">
                            @if(Str::contains(strtolower($c->name), 'harga')) attach_money
                            @elseif(Str::contains(strtolower($c->name), 'kandungan')) science
                            @elseif(Str::contains(strtolower($c->name), 'kemasan')) inventory_2
                            @elseif(Str::contains(strtolower($c->name), 'review')) star
                            @else tune
                            @endif
                        </span>
                    </div>

                    <label class="block text-sm text-gray-600 mb-2 font-medium">Seberapa penting faktor ini?</label>
                    
                    <!-- Input Range / Select Bobot -->
                    <select name="weights[{{ $c->id }}]" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 transition-colors">
                        <option value="1" {{ $savedValue == 1 ? 'selected' : '' }}>1 - Tidak Penting</option>
                        <option value="2" {{ $savedValue == 2 ? 'selected' : '' }}>2 - Kurang Penting</option>
                        <option value="3" {{ $savedValue == 3 ? 'selected' : '' }}>3 - Cukup Penting</option>
                        <option value="4" {{ $savedValue == 4 ? 'selected' : '' }}>4 - Penting</option>
                        <option value="5" {{ $savedValue == 5 ? 'selected' : '' }}>5 - Sangat Penting (Prioritas Utama)</option>
                    </select>
                </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center pb-8">
                <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-blue-700 hover:shadow-xl transform hover:-translate-y-1 transition-all flex items-center gap-2">
                    <span class="material-symbols-rounded">
                        {{ (isset($lastPreferences) && $lastPreferences) ? 'save_as' : 'search' }}
                    </span>
                    {{ (isset($lastPreferences) && $lastPreferences) ? 'Perbarui & Hitung Ulang' : 'Analisa & Cari Rekomendasi' }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>