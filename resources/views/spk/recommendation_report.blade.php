<x-layouts.app>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Laporan Hasil Rekomendasi Responden</h1>
                <p class="text-gray-500">Melihat persebaran rekomendasi produk per user.</p>
            </div>

            <!-- Ringkasan Statistik (Opsional) -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                @foreach($stats as $product => $count)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-gray-500 text-sm font-medium uppercase">{{ $product }}</div>
                    <div class="text-3xl font-bold text-indigo-600">{{ $count }} <span class="text-base text-gray-400 font-normal">User</span></div>
                </div>
                @endforeach
            </div>

            <!-- Detail Pengelompokan -->
            <div class="space-y-8">
                @forelse($groupedResults as $productName => $users)
                    <div class="bg-white rounded-2xl shadow-lg border-t-4 border-indigo-500 overflow-hidden">
                        
                        <!-- Header Produk -->
                        <div class="p-6 bg-indigo-50 flex justify-between items-center border-b border-indigo-100">
                            <div>
                                <h3 class="text-xl font-bold text-indigo-900">Produk: {{ $productName }}</h3>
                                <p class="text-sm text-indigo-600">Direkomendasikan kepada {{ count($users) }} Responden</p>
                            </div>
                            <div class="bg-white p-2 rounded-lg shadow-sm">
                                <span class="text-2xl">🏆</span>
                            </div>
                        </div>

                        <!-- Tabel User -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="bg-gray-50 text-gray-500 uppercase font-bold text-xs">
                                    <tr>
                                        <th class="px-6 py-3">Nama User / Responden</th>
                                        <th class="px-6 py-3">Umur</th>
                                        <th class="px-6 py-3">Tanggal Input</th>
                                        <th class="px-6 py-3">Skor Kecocokan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($users as $data)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ $data->user->name ?? $data->respondent_name }}
                                            <div class="text-xs text-gray-400">{{ $data->user ? $data->user->email : 'Guest' }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $data->user->age }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $data->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-bold">
                                                {{ number_format($data->score, 2) }}%
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white rounded-xl shadow-sm">
                        <p class="text-gray-500">Belum ada data rekomendasi tersimpan.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-layouts.app>