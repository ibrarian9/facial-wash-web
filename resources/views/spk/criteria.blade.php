<x-layouts.app>
    <x-slot:title>
        Data Kriteria
    </x-slot:title>

    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th scope="col" class="px-6 py-4">Kode</th>
                    <th scope="col" class="px-6 py-4">Nama Kriteria</th>
                    <th scope="col" class="px-6 py-4 text-center">Bobot</th>
                    <th scope="col" class="px-6 py-4 text-center">Atribut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($criterias as $c)
                <tr class="bg-white hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $c->code }}</td>
                    <td class="px-6 py-4">{{ $c->name }}</td>
                    <td class="px-6 py-4 text-center font-mono">{{ $c->weight }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($c->type == 'benefit')
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">Benefit</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-400">Cost</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-400">Belum ada data kriteria.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>