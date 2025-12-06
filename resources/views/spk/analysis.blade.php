<x-layouts.app>
    <x-slot:title>
        Menu Analisa
    </x-slot:title>

    <!-- Notifikasi Error Validasi -->
    @if ($errors->any() || session('error'))
        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 animate-pulse">
            <div class="flex items-center gap-2 mb-2">
                <span class="material-symbols-rounded text-xl">warning</span>
                <span class="font-bold text-lg">Gagal Menyimpan!</span>
            </div>
            <ul class="list-disc list-inside text-sm ml-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-6 p-4 text-sm text-blue-800 rounded-lg bg-blue-50 border border-blue-200">
        <strong class="block mb-2 text-base"><span class="material-symbols-rounded align-bottom text-lg">info</span> Panduan Pengisian:</strong>
        <ul class="list-disc list-inside space-y-1 ml-1">
            <li><strong>Kolom Harga (C1):</strong> Input harga Rupiah (Contoh: 75000). Skala 1-5 akan terhitung otomatis.</li>
            <li><strong>Kolom Lain (C2-C5):</strong> Isi dengan nilai skala 1-5.</li>
            <li>Semua kolom wajib diisi ulang jika melakukan perubahan.</li>
        </ul>
        <div class="mt-3 text-xs bg-white p-2 rounded border border-blue-100 inline-block">
            <strong>Rumus Konversi:</strong> &lt; 50rb = <strong>Skala 1</strong> | 50rb-100rb = <strong>Skala 3</strong> | &gt; 100rb = <strong>Skala 5</strong>
        </div>
    </div>

    <form action="{{ route('spk.storeAnalysis') }}" method="POST">
        @csrf
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm mb-6">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-3 sticky left-0 bg-gray-100 border-r z-10 min-w-[200px]">Alternatif</th>
                        @foreach($criterias as $c)
                            <th class="px-4 py-3 text-center min-w-[140px]">
                                {{ $c->name }} <br> 
                                <span class="text-[10px] text-gray-500 font-normal">({{ $c->code }})</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($alternatives as $alt)
                    <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 font-medium text-gray-900 sticky left-0 bg-white border-r shadow-sm">
                            <span class="font-bold text-blue-600 mr-2">{{ $alt->code }}</span> {{ $alt->name }}
                        </td>
                        @foreach($criterias as $c)
                            <td class="px-4 py-2 text-center align-middle">
                                @php
                                    $rawValue = $matrix[$alt->id][$c->id] ?? 0;
                                @endphp

                                @if($c->code == 'C1')
                                    {{-- LOGIKA DISPLAY SKALA C1: Cegah angka jutaan muncul sebagai skala --}}
                                    @php
                                        $displayScale = '-';
                                        if ($rawValue > 0) {
                                            if ($rawValue > 5) {
                                                // Jika di DB masih tersimpan Harga (misal 75000), kita konversi visualnya saja
                                                if ($rawValue < 50000) $displayScale = 1;
                                                elseif ($rawValue <= 100000) $displayScale = 3;
                                                else $displayScale = 5;
                                            } else {
                                                // Jika sudah skala (1-5), tampilkan apa adanya
                                                $displayScale = $rawValue;
                                            }
                                        }
                                    @endphp

                                    <div class="relative max-w-[150px] mx-auto p-1 rounded hover:bg-yellow-50 transition border border-transparent focus-within:border-yellow-300">
                                        <!-- Label Skala -->
                                        <div class="text-[11px] text-gray-500 mb-1 text-left flex justify-between items-center bg-gray-50 px-2 py-1 rounded">
                                            <span>Skala:</span>
                                            <strong class="text-lg font-bold leading-none scale-display {{ $displayScale != '-' ? 'text-blue-600' : 'text-gray-400' }}" id="scale-display-{{ $alt->id }}">
                                                {{ $displayScale }}
                                            </strong>
                                        </div>
                                        
                                        <!-- Input Harga Rupiah -->
                                        <div class="relative mt-1">
                                            <span class="absolute left-3 top-2 text-gray-400 text-xs font-bold">Rp</span>
                                            <input type="number" 
                                                name="nilai[{{ $alt->id }}][{{ $c->id }}]" 
                                                class="price-input w-full pl-8 pr-2 py-2 bg-white border border-gray-300 text-gray-900 text-sm rounded shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 block transition-all font-mono"
                                                placeholder="Input Harga"
                                                data-alt-id="{{ $alt->id }}"
                                                required
                                                min="1"
                                                title="Wajib isi harga baru dalam Rupiah">
                                        </div>
                                    </div>
                                @else
                                    <!-- Input Biasa (C2-C5) -->
                                    <input type="number" step="0.01" required
                                        name="nilai[{{ $alt->id }}][{{ $c->id }}]"
                                        value="{{ $rawValue > 0 ? $rawValue : '' }}"
                                        class="w-20 mx-auto bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block p-2 text-center"
                                        placeholder="0"
                                        min="1"
                                        max="5">
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end pt-4 border-t border-gray-200">
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 transition-colors shadow-sm flex items-center gap-2">
                <span class="material-symbols-rounded text-lg">calculate</span>
                Simpan & Proses
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const priceInputs = document.querySelectorAll('.price-input');
            priceInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const price = parseInt(this.value) || 0; 
                    const altId = this.getAttribute('data-alt-id'); 
                    const displayElement = document.getElementById(`scale-display-${altId}`); 
                    
                    let scale = '-';
                    // Hitung real-time saat ngetik
                    if (price > 0) {
                        if (price < 50000) scale = 1;
                        else if (price <= 100000) scale = 3;
                        else scale = 5; 
                    }

                    if(displayElement) {
                        displayElement.textContent = scale;
                        if(scale !== '-') {
                            displayElement.classList.remove('text-gray-400');
                            displayElement.classList.add('text-blue-600');
                        } else {
                            displayElement.classList.remove('text-blue-600');
                            displayElement.classList.add('text-gray-400');
                        }
                    }
                });
            });
        });
    </script>
</x-layouts.app>