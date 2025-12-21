<x-layouts.app>
    <x-slot:title>Hasil Rekomendasi Anda</x-slot:title>

    <div class="max-w-4xl mx-auto pb-12">
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('spk.recommendation') }}" class="flex items-center text-gray-600 hover:text-blue-600 transition">
                <span class="material-symbols-rounded mr-1">arrow_back</span>
                Ubah Preferensi
            </a>
        </div>

        <!-- 1. BAGIAN HASIL UTAMA (KARTU REKOMENDASI) -->
        @if(count($recommendations ?? []) > 0)
        <div class="bg-blue-600 bg-linear-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white shadow-xl mb-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 bg-white/10 w-32 h-32 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 text-center">
                <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">Rekomendasi Terbaik #1</span>            
                <h2 class="text-4xl font-bold mb-2">{{ $recommendations[0]['name'] ?? 'Nama Produk' }}</h2>
                <p class="text-blue-100 mb-6">Produk ini memiliki skor tertinggi berdasarkan perhitungan preferensi Anda.</p>
                
                <div class="text-6xl font-bold text-white mb-2">
                    {{ number_format($recommendations[0]['score'] ?? 0, 2) }}<span class="text-2xl">%</span>
                </div>
                <div class="text-sm text-blue-200">Skor Kecocokan</div>
            </div>
        </div>
        @endif

        <!-- 2. BAGIAN LIST ALTERNATIF LAIN -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="p-4 bg-gray-50 border-b border-gray-200 font-semibold text-gray-700 flex items-center gap-2">
                <span class="material-symbols-rounded">list_alt</span> Ranking Lengkap
            </div>
            <ul class="divide-y divide-gray-100">
                @foreach($recommendations as $index => $rec)
                    <li class="p-4 hover:bg-gray-50 transition flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full {{ $index == 0 ? 'bg-yellow-100 text-yellow-700 ring-2 ring-yellow-400' : 'bg-gray-200 text-gray-600' }} flex items-center justify-center font-bold">
                                #{{ $index + 1 }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $rec['name'] }}</h4>
                                <span class="text-xs text-gray-500 font-mono">{{ $rec['code'] }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold {{ $index == 0 ? 'text-blue-600' : 'text-gray-600' }}">{{ number_format($rec['score'], 2) }}%</div>
                            <div class="w-24 bg-gray-200 rounded-full h-1.5 mt-1">
                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $rec['score'] }}%"></div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- 3. BAGIAN DETAIL PERHITUNGAN (ACCORDION) -->
        <details class="group bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <summary class="flex justify-between items-center font-medium cursor-pointer list-none p-5 bg-gray-50 hover:bg-gray-100 transition">
                <div class="flex items-center gap-2 text-gray-800">
                    <span class="material-symbols-rounded text-blue-600">calculate</span>
                    <span class="font-bold">Lihat Detail Proses Perhitungan (Transparansi Sistem)</span>
                </div>
                <span class="transition group-open:rotate-180 material-symbols-rounded text-gray-500">expand_more</span>
            </summary>
            
            <div class="p-6 text-gray-600 space-y-8 border-t border-gray-200">
                
                <!-- STEP 1: Preferensi Kriteria -->
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2 border-l-4 border-yellow-500 pl-3">1. Preferensi Kriteria Anda</h3>
                    <p class="text-sm mb-4">
                        Berikut adalah tingkat kepentingan yang Anda pilih untuk setiap kriteria.
                    </p>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left text-gray-500 border">
                            <thead class="bg-yellow-50 text-yellow-900 uppercase font-bold">
                                <tr>
                                    <th class="px-3 py-2 border">Kode</th>
                                    <th class="px-3 py-2 border">Kriteria</th>
                                    <th class="px-3 py-2 border">Keterangan Pilihan</th>
                                    <th class="px-3 py-2 border text-center">Nilai Bobot (W)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $labels = [
                                        1 => 'Tidak Penting',
                                        2 => 'Kurang Penting',
                                        3 => 'Cukup Penting',
                                        4 => 'Penting',
                                        5 => 'Sangat Penting'
                                    ];
                                @endphp
                                @foreach($criterias as $c)
                                @php 
                                    $bobotAwal = $normalizedWeights[$c->id]['awal']; 
                                    $label = $labels[$bobotAwal] ?? 'Custom';
                                @endphp
                                <tr>
                                    <td class="px-3 py-2 border font-mono">{{ $c->code }}</td>
                                    <td class="px-3 py-2 border font-bold text-gray-700">{{ $c->name }}</td>
                                    <td class="px-3 py-2 border">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] border {{ $bobotAwal >= 4 ? 'bg-yellow-100 text-yellow-800 border-yellow-200' : 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                            {{ $label }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 border text-center font-bold text-yellow-700 text-sm">{{ $bobotAwal }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- STEP 2: MATRIKS KEPUTUSAN (FAKTA) -->
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2 border-l-4 border-gray-500 pl-3">2. Matriks Data Awal (Fakta Produk)</h3>
                    <p class="text-sm mb-4">
                        Ini adalah data spesifikasi produk yang tersimpan di sistem (Skala 1-5). <br>
                        Nilai inilah yang akan dicocokkan dengan keinginan Anda.
                    </p>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left text-gray-500 border">
                            <thead class="bg-gray-100 text-gray-700 uppercase font-bold">
                                <tr>
                                    <th class="px-3 py-2 border w-10">Kode</th>
                                    <th class="px-3 py-2 border min-w-[150px]">Alternatif</th>
                                    @foreach($criterias as $c)
                                        <th class="px-3 py-2 border text-center">{{ $c->name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alternatives as $a)
                                <tr>
                                    <td class="px-3 py-2 border font-mono font-bold">{{ $a->code }}</td>
                                    <td class="px-3 py-2 border">{{ $a->name }}</td>
                                    @foreach($criterias as $c)
                                        @php $val = $matrix[$a->id][$c->id] ?? 0; @endphp
                                        <td class="px-3 py-2 border text-center">
                                            <span class="font-bold text-gray-800">{{ $val }}</span>
                                        </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-2 text-[10px] text-gray-400 italic">
                            * Nilai berupa Skala (1: Sangat Rendah/Buruk s/d 5: Sangat Tinggi/Baik)
                        </div>
                    </div>
                </div>
                
                <!-- STEP 3: MATRIKS & BOBOT -->
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2 border-l-4 border-blue-500 pl-3">3. Normalisasi Bobot</h3>
                    <p class="text-sm mb-4">Bobot yang Anda inputkan dinormalisasi agar totalnya menjadi 1. Jika kriteria adalah COST (Biaya), pangkat menjadi negatif.</p>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left text-gray-500 border">
                            <thead class="bg-gray-100 text-gray-700 uppercase font-bold">
                                <tr>
                                    <th class="px-3 py-2 border">Kode</th>
                                    <th class="px-3 py-2 border">Kriteria</th>
                                    <th class="px-3 py-2 border text-center">Tipe</th>
                                    <th class="px-3 py-2 border text-center">Bobot Input (W)</th>
                                    <th class="px-3 py-2 border text-center">Normalisasi / Pangkat (Wj)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($criterias as $c)
                                <tr>
                                    <td class="px-3 py-2 border font-mono">{{ $c->code }}</td>
                                    <td class="px-3 py-2 border">{{ $c->name }}</td>
                                    <td class="px-3 py-2 border text-center">
                                        <span class="px-1.5 py-0.5 rounded text-[10px] {{ $c->type == 'cost' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                            {{ strtoupper($c->type) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 border text-center font-bold">{{ $normalizedWeights[$c->id]['awal'] }}</td>
                                    <td class="px-3 py-2 border text-center font-mono text-blue-600 font-bold">
                                        {{ number_format($normalizedWeights[$c->id]['pangkat'], 4) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- STEP 4: VEKTOR S -->
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2 border-l-4 border-indigo-500 pl-3">4. Perhitungan Vektor S</h3>
                    <p class="text-sm mb-4">
                        Rumus: <span class="font-mono bg-gray-100 px-1 rounded">S<sub>i</sub> = ∏ (x<sub>ij</sub>)<sup>w<sub>j</sub></sup></span> <span class="text-gray-400 mx-1">atau</span> <span class="font-mono bg-gray-100 px-1 rounded">S = (Nilai C1 <sup>Pangkat C1</sup>) × (Nilai C2 <sup>Pangkat C2</sup>) × ...</span><br>
                        Setiap nilai fakta produk dipangkatkan dengan bobot kriteria, lalu hasilnya dikalikan.
                    </p>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left text-gray-500 border">
                            <thead class="bg-indigo-50 text-indigo-900 uppercase font-bold">
                                <tr>
                                    <th class="px-3 py-2 border w-10">Kode</th>
                                    <th class="px-3 py-2 border min-w-[150px]">Alternatif</th>
                                    <!-- Loop Kriteria Columns -->
                                    @foreach($criterias as $c)
                                        <th class="px-3 py-2 border text-center">{{ $c->code }}</th>
                                    @endforeach
                                    <th class="px-3 py-2 border text-center bg-indigo-100 text-indigo-800">Nilai Vektor S</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alternatives as $a)
                                <tr>
                                    <td class="px-3 py-2 border font-mono font-bold">{{ $a->code }}</td>
                                    <td class="px-3 py-2 border">{{ $a->name }}</td>
                                    
                                    @foreach($criterias as $c)
                                        @php
                                            $val = $matrix[$a->id][$c->id] ?? 0;
                                        @endphp
                                        <td class="px-3 py-2 border text-center">
                                            <!-- Tampilkan Nilai Asli -->
                                            <span class="block text-gray-800 font-bold">{{ $val }}</span>
                                            <!-- Tampilkan Pangkat kecil -->
                                            <span class="block text-[9px] text-gray-400">
                                                ^ {{ number_format($normalizedWeights[$c->id]['pangkat'], 2) }}
                                            </span>
                                        </td>
                                    @endforeach
                                    
                                    <td class="px-3 py-2 border text-center font-mono font-bold text-indigo-700 bg-indigo-50">
                                        {{ number_format($vectorS[$a->id], 4) }}
                                    </td>
                                </tr>
                                @endforeach
                                <!-- Total S -->
                                <tr class="bg-gray-50 font-bold">
                                    <td colspan="{{ count($criterias) + 2 }}" class="px-3 py-2 border text-right">TOTAL VEKTOR S (ΣS) :</td>
                                    <td class="px-3 py-2 border text-center text-indigo-800">{{ number_format($totalS, 4) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- STEP 5: VEKTOR V -->
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2 border-l-4 border-green-500 pl-3">5. Perhitungan Vektor V (Ranking)</h3>
                    <p class="text-sm mb-4">
                        Rumus: <span class="font-mono bg-gray-100 px-1 rounded">V = Nilai S / Total S</span>. <br>
                        Nilai Vektor V kemudian dijadikan persentase untuk menentukan skor akhir.
                    </p>

                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <table class="w-full text-xs text-left text-gray-500">
                            <thead class="bg-green-50 text-green-900 uppercase font-bold">
                                <tr>
                                    <th class="px-4 py-3">Alternatif</th>
                                    <th class="px-4 py-3 text-center">Nilai S</th>
                                    <th class="px-4 py-3 text-center">Rumus (S / ΣS)</th>
                                    <th class="px-4 py-3 text-center">Nilai V (Vektor)</th>
                                    <th class="px-4 py-3 text-right">Skor Akhir (%)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($recommendations as $rec)
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-900">
                                        <span class="font-mono text-gray-400 mr-2">{{ $rec['code'] }}</span> {{ $rec['name'] }}
                                    </td>
                                    <td class="px-4 py-2 text-center font-mono">
                                        {{ number_format($rec['vector_s'], 4) }}
                                    </td>
                                    <td class="px-4 py-2 text-center font-mono text-gray-400">
                                        {{ number_format($rec['vector_s'], 4) }} / {{ number_format($totalS, 4) }}
                                    </td>
                                    <td class="px-4 py-2 text-center font-bold text-green-700 font-mono">
                                        {{ number_format($rec['vector_v'], 4) }}
                                    </td>
                                    <td class="px-4 py-2 text-right font-bold text-blue-600 text-sm">
                                        {{ number_format($rec['score'], 2) }}%
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </details>

    </div>
</x-layouts.app>