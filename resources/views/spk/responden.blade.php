<x-layouts.app>
    <x-slot:title>
        Laporan Data Responden
    </x-slot:title>

    <!-- Header Section -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Laporan Detail Responden</h2>
            <p class="text-sm text-gray-500">Melihat riwayat input preferensi dan profil demografi responden.</p>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 font-bold uppercase text-xs border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 w-16 text-center">No</th>
                        <th class="px-6 py-4 min-w-[250px]">Identitas Responden</th>
                        <th class="px-6 py-4 min-w-[350px]">Detail Preferensi (Bobot)</th>
                        <th class="px-6 py-4 min-w-[200px]">Hasil Rekomendasi</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reports as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-center text-gray-400">
                            {{ $reports->firstItem() + $index }}
                        </td>
                        
                        <!-- KOLOM 1: IDENTITAS -->
                        <td class="px-6 py-4 align-top">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm shrink-0">
                                    {{ substr($item->user->name ?? $item->respondent_name ?? 'G', 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800 text-base">
                                        {{ $item->user->name ?? $item->respondent_name }}
                                    </div>
                                    <div class="text-gray-500 text-xs mb-2">
                                        {{ $item->user->email ?? '-' }}
                                    </div>

                                    <div class="flex flex-wrap gap-1">
                                        @if($item->user)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                                {{ $item->user->age }} Tahun
                                            </span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-indigo-100 text-indigo-800 border border-indigo-200">
                                                {{ $item->user->status }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                                Guest / Tamu
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- KOLOM 2: INPUT KRITERIA (YANG DIPERBAIKI) -->
                        <td class="px-6 py-4 align-top">
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                
                                @php
                                    $inputData = $item->input_criteria ?? [];
                                    $weights = $inputData['weights'] ?? [];
                                    $otherData = array_diff_key($inputData, array_flip(['_token', '_method', 'weights']));
                                @endphp

                                <!-- 1. Tampilkan Weights dengan Detail Nama & Arti -->
                                @if(!empty($weights) && is_array($weights))
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-2 mb-2 pb-2 border-b border-gray-200">
                                            <span class="material-symbols-rounded text-gray-400 text-sm">tune</span>
                                            <span class="text-xs font-bold text-gray-600 uppercase tracking-wide">Prioritas Kriteria</span>
                                        </div>

                                        @foreach($weights as $criteriaId => $weightValue)
                                            @php
                                                $criteriaName = $criterias->firstWhere('id', $criteriaId)->name ?? 'Kriteria #'.$criteriaId;                                                
                                                
                                                $labels = [
                                                    1 => 'Tidak Penting',
                                                    2 => 'Kurang Penting',
                                                    3 => 'Cukup Penting',
                                                    4 => 'Penting',
                                                    5 => 'Sangat Penting'
                                                ];
                                                $labelText = $labels[$weightValue] ?? 'Skala '.$weightValue;
                                                
                                                $barColors = [
                                                    1 => 'bg-gray-300',
                                                    2 => 'bg-red-400',
                                                    3 => 'bg-yellow-400',
                                                    4 => 'bg-blue-400',
                                                    5 => 'bg-green-500'
                                                ];
                                                $colorClass = $barColors[$weightValue] ?? 'bg-blue-400';
                                            @endphp

                                            <div class="flex items-center justify-between text-xs group">
                                                <span class="text-gray-600 font-medium min-w-[100px]">{{ $criteriaName }}</span>
                                                
                                                <div class="flex items-center gap-2 flex-1 justify-end">
                                                    <!-- Label Teks -->
                                                    <span class="text-[10px] text-gray-500 italic mr-1 hidden sm:inline-block">
                                                        {{ $labelText }}
                                                    </span>
                                                    
                                                    <!-- Visual Bar & Angka -->
                                                    <div class="flex items-center gap-1 bg-white border border-gray-200 rounded px-1.5 py-0.5 shadow-sm">
                                                        <div class="flex gap-0.5">
                                                            @for($i=1; $i<=5; $i++)
                                                                <div class="w-1 h-2 rounded-full {{ $i <= $weightValue ? $colorClass : 'bg-gray-100' }}"></div>
                                                            @endfor
                                                        </div>
                                                        <span class="font-bold text-gray-800 ml-1">{{ $weightValue }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Data bobot tidak ditemukan.</span>
                                @endif

                                <!-- 2. Tampilkan Input Lain (Jika ada) -->
                                @if(!empty($otherData))
                                    <div class="mt-3 pt-2 border-t border-gray-200 border-dashed">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Input Tambahan:</span>
                                        @foreach($otherData as $key => $value)
                                            <div class="flex justify-between text-xs mt-1">
                                                <span class="text-gray-500 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                                <span class="font-medium text-gray-800">
                                                    {{ is_array($value) ? json_encode($value) : $value }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                            </div>
                        </td>

                        <!-- KOLOM 3: HASIL -->
                        <td class="px-6 py-4 align-top">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="material-symbols-rounded text-yellow-500 text-lg">emoji_events</span>
                                <span class="font-bold text-gray-800">{{ $item->top_product_name }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs">
                                <span class="text-gray-500">Skor:</span>
                                <div class="w-full max-w-[100px] bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $item->score }}%"></div>
                                </div>
                                <span class="font-bold text-green-700">{{ number_format($item->score, 2) }}%</span>
                            </div>
                        </td>

                        <!-- KOLOM 4: WAKTU -->
                        <td class="px-6 py-4 align-top text-gray-500 text-xs">
                            <div class="font-medium text-gray-700">
                                {{ $item->created_at->format('d M Y') }}
                            </div>
                            <div>
                                {{ $item->created_at->format('H:i') }} WIB
                            </div>
                        </td>

                        <!-- KOLOM 5: Detail -->
                        <td class="px-6 py-4 text-center align-top">
                            <a href="{{ route('spk.respondenDetail', $item->id) }}" class="inline-flex items-center gap-1 text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                                <span class="material-symbols-rounded text-sm">visibility</span>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <span class="material-symbols-rounded text-4xl text-gray-300 mb-2">folder_off</span>
                                <p>Belum ada data responden yang masuk.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $reports->links() }}
        </div>
    </div>
</x-layouts.app>