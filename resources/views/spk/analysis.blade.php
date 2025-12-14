<x-layouts.app>
    <x-slot:title>
        Data Penilaian
    </x-slot:title>

    <!-- Header Section -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Matriks Penilaian Alternatif</h2>
        <p class="text-sm text-gray-500">Input spesifikasi/fakta untuk setiap produk (Alternatif).</p>
    </div>

    <!-- KONSEP ALUR SISTEM (PENJELASAN VISUAL) -->
    <!-- Bagian ini ditambahkan untuk menjawab kebingungan tentang korelasi Admin vs User -->
    <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- 1. Peran Admin -->
        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm relative overflow-hidden group hover:border-indigo-300 transition-colors">
            <div class="absolute top-0 right-0 -mt-2 -mr-2 w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center">
                <span class="material-symbols-rounded text-indigo-400 text-lg font-bold">1</span>
            </div>
            <div class="flex items-center gap-2 mb-2 text-indigo-700 font-bold text-sm uppercase tracking-wide">
                <span class="material-symbols-rounded">admin_panel_settings</span>
                Admin (Anda)
            </div>
            <p class="text-xs text-gray-600 leading-relaxed">
                Anda bertugas mengisi <strong>Fakta/Spesifikasi</strong> produk di halaman ini. <br>
                <em class="text-gray-400">(Contoh: Produk A harganya Rp 50.000)</em>
            </p>
        </div>

        <!-- 2. Peran User -->
        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm relative overflow-hidden group hover:border-green-300 transition-colors">
            <div class="absolute top-0 right-0 -mt-2 -mr-2 w-12 h-12 bg-green-50 rounded-full flex items-center justify-center">
                <span class="material-symbols-rounded text-green-400 text-lg font-bold">2</span>
            </div>
            <div class="flex items-center gap-2 mb-2 text-green-700 font-bold text-sm uppercase tracking-wide">
                <span class="material-symbols-rounded">person_search</span>
                User (Responden)
            </div>
            <p class="text-xs text-gray-600 leading-relaxed">
                User nanti menginput <strong>Keinginan/Preferensi</strong> mereka. <br>
                <em class="text-gray-400">(Contoh: "Saya memprioritaskan Harga Murah")</em>
            </p>
        </div>

        <!-- 3. Hasil Sistem -->
        <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-200 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-2 -mr-2 w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                <span class="material-symbols-rounded text-indigo-500 text-lg font-bold">3</span>
            </div>
            <div class="flex items-center gap-2 mb-2 text-indigo-800 font-bold text-sm uppercase tracking-wide">
                <span class="material-symbols-rounded">fact_check</span>
                Hasil Rekomendasi
            </div>
            <p class="text-xs text-indigo-800 leading-relaxed">
                Sistem akan mencocokkan <strong>Keinginan User</strong> dengan <strong>Data Fakta</strong> yang Anda isi di sini untuk menemukan produk terbaik.
            </p>
        </div>
    </div>

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

    <!-- Kartu Informasi Panduan -->
    <div class="mb-6 p-5 text-sm text-blue-900 rounded-xl bg-blue-50 border border-blue-200 shadow-sm">
        <div class="flex items-start gap-3">
            <span class="material-symbols-rounded text-blue-600 mt-0.5">info</span>
            <div class="space-y-2">
                <strong class="text-base block text-blue-800">Panduan Pengisian Data:</strong>
                <ul class="list-disc list-inside ml-1 space-y-1 text-blue-800/80">
                    <li><strong>Kolom Harga (C1):</strong> Input harga dalam Rupiah (Contoh: 75000). Sistem otomatis mengkonversi ke Skala 1-5.</li>
                    <li><strong>Kolom Kriteria Lain (C2-C5):</strong> Isi langsung dengan nilai skala prioritas (1 s/d 5).</li>
                    <li>Pastikan semua kolom terisi sebelum menekan tombol simpan.</li>
                </ul>
                <div class="mt-3 inline-flex items-center gap-2 text-xs font-mono bg-white px-3 py-1.5 rounded border border-blue-200 text-blue-700">
                    <span class="material-symbols-rounded text-[14px]">calculate</span>
                    <span>Rumus Harga: &lt; 50rb = <strong>1</strong> | 50rb-100rb = <strong>3</strong> | &gt; 100rb = <strong>5</strong></span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('spk.storeAnalysis') }}" method="POST">
        @csrf
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-lg mb-8 bg-white">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 sticky left-0 bg-gray-100 border-r border-gray-200 z-10 min-w-[220px]">
                                Nama Alternatif Produk
                            </th>
                            @foreach($criterias as $c)
                                <th class="px-4 py-4 text-center min-w-[160px] group relative">
                                    <div class="flex flex-col items-center">
                                        <span class="font-bold text-gray-800">{{ $c->name }}</span>
                                        <span class="text-[10px] px-2 py-0.5 bg-gray-200 rounded-full mt-1 text-gray-600 font-mono">
                                            {{ $c->code }}
                                        </span>
                                    </div>
                                    <!-- Tooltip atribut -->
                                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap">
                                        Atribut: {{ ucfirst($c->attribute) }}
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($alternatives as $alt)
                        <tr class="bg-white hover:bg-gray-50 transition-colors group">
                            <td class="px-6 py-4 font-medium text-gray-900 sticky left-0 bg-white group-hover:bg-gray-50 border-r border-gray-100 shadow-[4px_0_8px_-4px_rgba(0,0,0,0.05)]">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 text-xs font-bold ring-2 ring-white">
                                        {{ $alt->code }}
                                    </span>
                                    <span>{{ $alt->name }}</span>
                                </div>
                            </td>
                            @foreach($criterias as $c)
                                <td class="px-4 py-3 text-center align-middle p-4">
                                    @php
                                        $rawValue = $matrix[$alt->id][$c->id] ?? 0;
                                    @endphp

                                    @if($c->code == 'C1')
                                        {{-- LOGIKA DISPLAY SKALA C1: Cegah angka jutaan muncul sebagai skala --}}
                                        @php
                                            $displayScale = '-';
                                            $inputValue = ''; // Default kosong agar user input ulang jika perlu, atau bisa diisi $rawValue jika ingin edit harga lama
                                            
                                            // Jika data ada (bukan 0)
                                            if ($rawValue > 0) {
                                                if ($rawValue > 5) {
                                                    // Jika di DB tersimpan Harga Rupiah (misal 75000)
                                                    $inputValue = $rawValue; // Tampilkan harga di input
                                                    if ($rawValue < 50000) $displayScale = 1;
                                                    elseif ($rawValue <= 100000) $displayScale = 3;
                                                    else $displayScale = 5;
                                                } else {
                                                    // Jika di DB sudah tersimpan Skala (1-5), berarti harga asli tidak tersimpan/hilang
                                                    $displayScale = $rawValue;
                                                }
                                            }
                                        @endphp

                                        <div class="relative w-full max-w-[140px] mx-auto bg-gray-50 rounded-lg p-1.5 border border-gray-200 transition-colors focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 focus-within:bg-white">
                                            <!-- Label Skala Otomatis -->
                                            <div class="flex justify-between items-center mb-1 px-1">
                                                <span class="text-[10px] text-gray-500 uppercase font-bold tracking-wider">Skala</span>
                                                <span class="text-xs font-bold px-2 py-0.5 rounded bg-white border shadow-sm scale-display {{ $displayScale != '-' ? 'text-blue-600 border-blue-100' : 'text-gray-300 border-gray-100' }}" id="scale-display-{{ $alt->id }}">
                                                    {{ $displayScale }}
                                                </span>
                                            </div>
                                            
                                            <!-- Input Harga Rupiah -->
                                            <div class="relative">
                                                <span class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-medium">Rp</span>
                                                <input type="number" 
                                                    name="nilai[{{ $alt->id }}][{{ $c->id }}]" 
                                                    class="price-input w-full pl-7 pr-2 py-1.5 bg-white border border-gray-300 text-gray-800 text-sm font-semibold text-right rounded focus:outline-none focus:border-blue-500 transition-all placeholder-gray-300"
                                                    placeholder="0"
                                                    value="{{ $inputValue }}"
                                                    data-alt-id="{{ $alt->id }}"
                                                    required
                                                    min="1">
                                            </div>
                                        </div>
                                    @else
                                        <!-- Input Biasa (C2-C5) -->
                                        <div class="relative w-24 mx-auto">
                                            <input type="number" step="0.01" required
                                                name="nilai[{{ $alt->id }}][{{ $c->id }}]"
                                                value="{{ $rawValue > 0 ? $rawValue : '' }}"
                                                class="w-full text-center font-bold text-gray-700 bg-white border border-gray-300 rounded-lg py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all shadow-sm hover:border-gray-400"
                                                placeholder="-"
                                                min="1"
                                                max="5">
                                            
                                            <!-- Helper text skala -->
                                            <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none opacity-0 focus-within:opacity-100 transition-opacity">
                                                <span class="text-[10px] text-gray-400">/5</span>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Footer Form -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-xs text-gray-500 italic">
                    * Data akan otomatis memperbarui perhitungan rekomendasi.
                </div>
                <button type="submit" class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-bold rounded-lg text-sm px-8 py-3 transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                    <span class="material-symbols-rounded">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const priceInputs = document.querySelectorAll('.price-input');
            
            priceInputs.forEach(input => {
                // Trigger event saat load agar warna/nilai sesuai jika ada old value
                if(input.value) updateScale(input);

                input.addEventListener('input', function() {
                    updateScale(this);
                });
            });

            function updateScale(inputElement) {
                const price = parseInt(inputElement.value) || 0; 
                const altId = inputElement.getAttribute('data-alt-id'); 
                const displayElement = document.getElementById(`scale-display-${altId}`); 
                
                let scale = '-';
                
                // Logika Konversi:
                // < 50.000       = 1
                // 50.000 - 100.000 = 3
                // > 100.000      = 5
                
                if (price > 0) {
                    if (price < 50000) scale = 1;
                    else if (price <= 100000) scale = 3;
                    else scale = 5; 
                }

                if(displayElement) {
                    displayElement.textContent = scale;
                    if(scale !== '-') {
                        displayElement.classList.remove('text-gray-300', 'border-gray-100');
                        displayElement.classList.add('text-blue-600', 'border-blue-100');
                    } else {
                        displayElement.classList.remove('text-blue-600', 'border-blue-100');
                        displayElement.classList.add('text-gray-300', 'border-gray-100');
                    }
                }
            }
        });
    </script>
</x-layouts.app>