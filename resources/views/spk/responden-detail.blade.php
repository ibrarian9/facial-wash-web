<x-layouts.app>
    <x-slot:title>Detail Perhitungan Responden</x-slot:title>

    <div class="max-w-5xl mx-auto pb-12">
        
        <!-- Header & Tombol Kembali -->
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('spk.responden') }}" class="flex items-center text-gray-600 hover:text-blue-600 transition font-medium">
                <span class="material-symbols-rounded mr-1">arrow_back</span>
                Kembali ke Laporan
            </a>
            <span class="text-sm text-gray-400">ID Transaksi: #{{ $history->id }}</span>
        </div>

        <!-- 1. INFO RESPONDEN (HEADER) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8 flex flex-col sm:flex-row items-start gap-4">
            <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-2xl shrink-0">
                {{ substr($history->user->name ?? $history->respondent_name, 0, 1) }}
            </div>
            <div class="flex-1 w-full">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $history->user->name ?? $history->respondent_name }}</h2>
                        <p class="text-gray-500 text-sm mb-3">{{ $history->user->email ?? 'Guest' }}</p>
                    </div>
                    <div class="text-right sm:hidden">
                        <div class="text-xs text-gray-500 uppercase tracking-wide font-bold mb-1">Rekomendasi #1</div>
                        <div class="text-lg font-bold text-blue-600">{{ $history->top_product_name }}</div>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                        Usia: {{ $history->user->age ?? '-' }} Thn
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800 border border-indigo-200">
                        Status: {{ $history->user->status ?? '-' }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                        <span class="material-symbols-rounded text-[14px] mr-1">calendar_today</span>
                        {{ $history->created_at->format('d M Y, H:i') }}
                    </span>
                </div>
            </div>
            <div class="text-right hidden sm:block min-w-[150px]">
                <div class="text-xs text-gray-500 uppercase tracking-wide font-bold mb-1">Rekomendasi #1</div>
                <div class="text-xl font-bold text-blue-600">{{ $history->top_product_name }}</div>
                <div class="text-sm font-bold text-green-600">Skor: {{ number_format($history->score, 2) }}%</div>
            </div>
        </div>

        <!-- 2. HASIL RANKING FINAL -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="p-4 bg-gray-50 border-b border-gray-200 font-bold text-gray-700 flex items-center gap-2">
                <span class="material-symbols-rounded text-yellow-600">emoji_events</span> Hasil Ranking Final
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
                            <div class="w-24 bg-gray-200 rounded-full h-1.5 mt-1 ml-auto">
                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $rec['score'] }}%"></div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- 3. DETAIL 5 TAHAPAN PROSES (SAMA SEPERTI USER VIEW) -->
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <span class="material-symbols-rounded text-blue-600">calculate</span> Detail Proses Perhitungan
        </h3>

        <div class="space-y-8">

            <!-- STEP 1: PREFERENSI USER (INPUT BOBOT) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-4 bg-gray-50 border-b font-bold text-gray-700 border-l-4 border-yellow-500">
                    1. Preferensi Kriteria User
                </div>
                <div class="p-4 text-sm text-gray-600 border-b border-gray-100">
                    Tingkat kepentingan yang dipilih user untuk setiap kriteria.
                </div>
                <div class="overflow-x-auto p-4">
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

              <!-- STEP 2 MATRIKS KEPUTUSAN -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-4 bg-gray-50 border-b font-bold text-gray-700 border-l-4 border-gray-500">
                    2. Data Fakta (Nilai Produk)
                </div>
                <div class="p-4 text-sm text-gray-600 border-b border-gray-100">
                    Data spesifikasi asli produk yang tersimpan di sistem (Skala 1-5) saat user melakukan pencarian.
                </div>
                <div class="overflow-x-auto p-4">
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
                                    <td class="px-3 py-2 border text-center font-bold text-gray-800">{{ $val }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- STEP 3: NORMALISASI BOBOT -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-4 bg-gray-50 border-b font-bold text-gray-700 border-l-4 border-blue-500">
                    3. Normalisasi Bobot
                </div>
                <div class="p-4 text-sm text-gray-600 border-b border-gray-100">
                    Bobot dinormalisasi agar total menjadi 1. Pangkat negatif untuk Cost, positif untuk Benefit.
                </div>
                <div class="overflow-x-auto p-4">
                    <table class="w-full text-xs text-left text-gray-500 border">
                        <thead class="bg-blue-50 text-blue-900 uppercase font-bold">
                            <tr>
                                <th class="px-3 py-2 border">Kriteria</th>
                                <th class="px-3 py-2 border text-center">Tipe</th>
                                <th class="px-3 py-2 border text-center">Bobot Awal</th>
                                <th class="px-3 py-2 border text-center">Rumus (W / ΣW)</th>
                                <th class="px-3 py-2 border text-center">Pangkat Akhir (Wj)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalBobot = 0; foreach($criterias as $c) $totalBobot += $normalizedWeights[$c->id]['awal']; @endphp
                            @foreach($criterias as $c)
                            <tr>
                                <td class="px-3 py-2 border">{{ $c->name }}</td>
                                <td class="px-3 py-2 border text-center">
                                    <span class="px-1.5 py-0.5 rounded text-[10px] {{ $c->type == 'cost' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ strtoupper($c->type) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 border text-center">{{ $normalizedWeights[$c->id]['awal'] }}</td>
                                <td class="px-3 py-2 border text-center text-gray-400 font-mono">
                                    {{ $normalizedWeights[$c->id]['awal'] }} / {{ $totalBobot }}
                                </td>
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
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-4 bg-gray-50 border-b font-bold text-gray-700 border-l-4 border-indigo-500">
                    4. Perhitungan Vektor S
                </div>
                <div class="p-4 text-sm text-gray-600 border-b border-gray-100">
                    Rumus: S = ∏ (Nilai Fakta)<sup>Pangkat Wj</sup>.
                </div>
                <div class="overflow-x-auto p-4">
                    <table class="w-full text-xs text-left text-gray-500 border">
                        <thead class="bg-indigo-50 text-indigo-900 uppercase font-bold">
                            <tr>
                                <th class="px-3 py-2 border">Alternatif</th>
                                @foreach($criterias as $c)
                                    <th class="px-3 py-2 border text-center">{{ $c->code }}</th>
                                @endforeach
                                <th class="px-3 py-2 border text-center bg-indigo-100 text-indigo-800">Vektor S</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alternatives as $a)
                            <tr>
                                <td class="px-3 py-2 border font-medium">{{ $a->name }}</td>
                                @foreach($criterias as $c)
                                    @php $val = $matrix[$a->id][$c->id] ?? 0; @endphp
                                    <td class="px-3 py-2 border text-center">
                                        <span class="block text-gray-800">{{ $val }}<span class="text-[9px] text-gray-400">^ {{ number_format($normalizedWeights[$c->id]['pangkat'], 2) }}</span></span>
                                    </td>
                                @endforeach
                                <td class="px-3 py-2 border text-center font-mono font-bold text-indigo-700 bg-indigo-50">
                                    {{ number_format($vectorS[$a->id], 4) }}
                                </td>
                            </tr>
                            @endforeach
                            <tr class="bg-gray-50 font-bold">
                                <td colspan="{{ count($criterias) + 1 }}" class="px-3 py-2 border text-right">TOTAL (ΣS) :</td>
                                <td class="px-3 py-2 border text-center text-indigo-800">{{ number_format($totalS, 4) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- STEP 5: VEKTOR V -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-4 bg-gray-50 border-b font-bold text-gray-700 border-l-4 border-green-500">
                    5. Perhitungan Vektor V (Ranking)
                </div>
                <div class="p-4 text-sm text-gray-600 border-b border-gray-100">
                    Rumus: V = Nilai S / Total ΣS.
                </div>
                <div class="overflow-x-auto p-4">
                    <table class="w-full text-xs text-left text-gray-500">
                        <thead class="bg-green-50 text-green-900 uppercase font-bold">
                            <tr>
                                <th class="px-4 py-3">Alternatif</th>
                                <th class="px-4 py-3 text-center">Nilai S</th>
                                <th class="px-4 py-3 text-center">Rumus (S / ΣS)</th>
                                <th class="px-4 py-3 text-center">Nilai V</th>
                                <th class="px-4 py-3 text-right">Skor Akhir (%)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 border">
                            @foreach($recommendations as $rec)
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-900">
                                    <span class="font-mono text-gray-400 mr-2">{{ $rec['code'] }}</span> {{ $rec['name'] }}
                                </td>
                                <td class="px-4 py-2 text-center font-mono">{{ number_format($rec['vector_s'], 4) }}</td>
                                <td class="px-4 py-2 text-center font-mono text-gray-400">
                                    {{ number_format($rec['vector_s'], 4) }} / {{ number_format($totalS, 4) }}
                                </td>
                                <td class="px-4 py-2 text-center font-bold text-green-700 font-mono">{{ number_format($rec['vector_v'], 4) }}</td>
                                <td class="px-4 py-2 text-right font-bold text-blue-600 text-sm">{{ number_format($rec['score'], 2) }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</x-layouts.app>