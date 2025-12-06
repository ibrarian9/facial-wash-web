<x-layouts.app>
    <x-slot:title>
        Hasil Perhitungan Metode WP
    </x-slot:title>

    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
        <span class="font-medium">Sukses!</span> {{ session('success') }}
    </div>
    @endif

    <div class="mb-10">
        <div class="flex items-center gap-2 mb-4 border-b pb-2 border-gray-100">
            <div class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm">1</div>
            <h2 class="text-lg font-semibold text-gray-800">Normalisasi Bobot Kriteria (W)</h2>
        </div>
        
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border-b">Kode</th>
                        <th class="px-6 py-3 border-b">Kriteria</th>
                        <th class="px-6 py-3 border-b">Tipe</th>
                        <th class="px-6 py-3 border-b text-center">Bobot Awal</th>
                        <th class="px-6 py-3 border-b text-center">Normalisasi (Wj)</th>
                        <th class="px-6 py-3 border-b text-center">Pangkat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($criterias as $c)
                    <tr class="bg-white hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $c->code }}</td>
                        <td class="px-6 py-4">{{ $c->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $c->type == 'cost' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst($c->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center font-mono">{{ $c->weight }}</td>
                        <td class="px-6 py-4 text-center font-mono">{{ number_format($normalizedWeights[$c->id]['value'], 4) }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-mono font-bold {{ $normalizedWeights[$c->id]['pangkat'] < 0 ? 'text-red-600' : 'text-blue-600' }}">
                                {{ number_format($normalizedWeights[$c->id]['pangkat'], 4) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    <tr class="bg-gray-50 font-bold text-gray-900">
                        <td colspan="3" class="px-6 py-4 text-right uppercase text-xs tracking-wider">Total Sigma Bobot:</td>
                        <td class="px-6 py-4 text-center font-mono text-base">{{ $totalWeight }}</td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <div class="flex items-center gap-2 mb-4 border-b pb-2 border-gray-100">
            <div class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm">2</div>
            <h2 class="text-lg font-semibold text-gray-800">Hasil Perangkingan (Vektor V)</h2>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-sm text-blue-800">
            <p><strong>Rumus:</strong></p>
            <ul class="list-disc list-inside mt-1 ml-2 space-y-1">
                <li>Vektor S = Perkalian dari (Nilai Kriteria ^ Pangkat Bobot)</li>
                <li>Vektor V = Nilai S / Total semua nilai S</li>
            </ul>
        </div>
        
        <div class="overflow-x-auto rounded-lg shadow-sm border border-gray-200">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-white uppercase bg-slate-800">
                    <tr>
                        <th class="px-6 py-3">Ranking</th>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Nama Produk Alternatif</th>
                        <th class="px-6 py-3 text-right">Nilai Vektor S</th>
                        <th class="px-6 py-3 text-right">Nilai Akhir (V)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($vectorV as $index => $row)
                    <tr class="bg-white border-b transition-colors {{ $index == 0 ? 'bg-yellow-50 hover:bg-yellow-100' : 'hover:bg-gray-50' }}">
                        <td class="px-6 py-4 font-bold text-lg">
                            <div class="flex items-center gap-2">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full {{ $index == 0 ? 'bg-yellow-400 text-white shadow-md' : ($index == 1 ? 'bg-gray-300 text-gray-600' : ($index == 2 ? 'bg-orange-200 text-orange-700' : 'bg-gray-100 text-gray-400')) }}">
                                    {{ $index + 1 }}
                                </span>
                                @if($index == 0) 
                                    <span class="text-xs text-yellow-600 font-bold uppercase tracking-wider ml-1">Terbaik</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $row['code'] }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $row['name'] }}</td>
                        <td class="px-6 py-4 text-right font-mono">{{ number_format($row['s_val'], 6) }}</td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-lg font-bold font-mono {{ $index == 0 ? 'text-green-600' : 'text-blue-600' }}">
                                {{ number_format($row['v_val'], 6) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>