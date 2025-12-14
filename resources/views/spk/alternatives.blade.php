<x-layouts.app>
    <x-slot:title>
        Data Alternatif (Produk)
    </x-slot:title>

    <!-- Header & Button (Konsisten dengan Kriteria) -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Alternatif</h2>
            <p class="text-sm text-gray-500">Kelola data produk Facial Wash yang akan dinilai oleh sistem.</p>
        </div>
        <!-- Tombol Tambah -->
        <a href="{{ route('spk.alternatives.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm flex items-center gap-2 transition-colors">
            <span class="material-symbols-rounded">add</span>
            Tambah Alternatif
        </a>
    </div>

    <!-- Alert Sukses -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2 animate-fade-in">
            <span class="material-symbols-rounded">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Data -->
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm bg-white">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th scope="col" class="px-6 py-4 w-24">Kode</th>
                    <th scope="col" class="px-6 py-4">Nama Produk Facial Wash</th>
                    <th scope="col" class="px-6 py-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($alternatives as $alt)
                <tr class="bg-white hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap font-mono">{{ $alt->code }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $alt->name }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <!-- Tombol Edit (Style Konsisten) -->
                            <a href="{{ route('spk.alternatives.edit', $alt->id) }}" class="text-yellow-600 hover:text-yellow-800 p-1.5 hover:bg-yellow-50 rounded transition-colors" title="Edit Data">
                                <span class="material-symbols-rounded">edit</span>
                            </a>
                            
                            <!-- Tombol Hapus (Style Konsisten) -->
                            <form action="{{ route('spk.alternatives.destroy', $alt->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data {{ $alt->name }}? Semua nilai penilaian terkait juga akan terhapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 p-1.5 hover:bg-red-50 rounded transition-colors" title="Hapus Data">
                                    <span class="material-symbols-rounded">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                        <div class="flex flex-col items-center">
                            <span class="material-symbols-rounded text-4xl mb-2 text-gray-300">inbox</span>
                            Belum ada data alternatif produk.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>