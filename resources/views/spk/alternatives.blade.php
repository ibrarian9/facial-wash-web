<x-layouts.app>
    <x-slot:title>
        Data Alternatif (Produk)
    </x-slot:title>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 flex items-center gap-2" role="alert">
            <span class="material-symbols-rounded">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">Kelola data produk Facial Wash yang akan menjadi objek penilaian.</p>
        <a href="{{ route('spk.alternatives.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-all shadow-sm">
            <span class="material-symbols-rounded text-sm">add</span>
            Tambah Data
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th scope="col" class="px-6 py-4 w-24">Kode</th>
                    <th scope="col" class="px-6 py-4">Nama Produk Facial Wash</th>
                    <th scope="col" class="px-6 py-4 text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($alternatives as $alt)
                <tr class="bg-white hover:bg-gray-50 group transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50/50 group-hover:bg-gray-50">{{ $alt->code }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $alt->name }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <!-- Tombol Edit -->
                            <a href="{{ route('spk.alternatives.edit', $alt->id) }}" class="text-yellow-600 hover:text-white hover:bg-yellow-500 p-2 rounded-lg transition-all" title="Edit">
                                <span class="material-symbols-rounded text-lg">edit</span>
                            </a>
                            
                            <!-- Tombol Hapus -->
                            <form action="{{ route('spk.alternatives.destroy', $alt->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini? Semua nilai penilaian terkait juga akan terhapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-white hover:bg-red-500 p-2 rounded-lg transition-all" title="Hapus">
                                    <span class="material-symbols-rounded text-lg">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <span class="material-symbols-rounded text-4xl text-gray-300">inbox</span>
                            <p>Belum ada data alternatif.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>