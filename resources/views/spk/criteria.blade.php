<x-layouts.app>
    <x-slot:title>
        Data Kriteria
    </x-slot:title>

    <!-- Header & Button -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Kriteria</h2>
            <p class="text-sm text-gray-500">Atur kriteria penilaian, bobot, dan atribut (Benefit/Cost).</p>
        </div>
        <!-- Tombol Tambah -->
        <a href="{{ route('spk.criteria.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm flex items-center gap-2 transition-colors">
            <span class="material-symbols-rounded">add</span>
            Tambah Kriteria
        </a>
    </div>

    <!-- Alert Sukses -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2 animate-fade-in">
            <span class="material-symbols-rounded">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm bg-white">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th scope="col" class="px-6 py-4">Kode</th>
                    <th scope="col" class="px-6 py-4">Nama Kriteria</th>
                    <th scope="col" class="px-6 py-4 text-center">Bobot</th>
                    <th scope="col" class="px-6 py-4 text-center">Atribut</th>
                    <th scope="col" class="px-6 py-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($criterias as $c)
                <tr class="bg-white hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap font-mono">{{ $c->code }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $c->name }}</td>
                    <td class="px-6 py-4 text-center font-bold text-gray-700">{{ $c->weight }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($c->type == 'benefit')
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded border border-green-200 uppercase tracking-wide">Benefit</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded border border-red-200 uppercase tracking-wide">Cost</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <!-- Tombol Edit -->
                            <a href="{{ route('spk.criteria.edit', $c->id) }}" class="text-yellow-600 hover:text-yellow-800 p-1.5 hover:bg-yellow-50 rounded transition-colors" title="Edit Data">
                                <span class="material-symbols-rounded">edit</span>
                            </a>
                            
                            <!-- Tombol Hapus -->
                            <form action="{{ route('spk.criteria.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kriteria {{ $c->name }}?');">
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
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <div class="flex flex-col items-center">
                            <span class="material-symbols-rounded text-4xl mb-2 text-gray-300">folder_off</span>
                            Belum ada data kriteria.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>