<x-layouts.app>
    <x-slot:title>
        {{ isset($alternative) ? 'Edit Alternatif' : 'Tambah Alternatif Baru' }}
    </x-slot:title>

    <div class="max-w-2xl">
        <div class="flex items-center gap-2 mb-6 text-sm text-gray-500">
            <a href="{{ route('spk.alternatives') }}" class="hover:text-blue-600 flex items-center gap-1">
                <span class="material-symbols-rounded text-lg">arrow_back</span>
                Kembali
            </a>
            <span>/</span>
            <span>Form Data</span>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
            <form action="{{ isset($alternative) ? route('spk.alternatives.update', $alternative->id) : route('spk.alternatives.store') }}" method="POST">
                @csrf
                @if(isset($alternative))
                    @method('PUT')
                @endif

                <div class="grid gap-6 mb-6">
                    <!-- Input Kode -->
                    <div>
                        <label for="code" class="block mb-2 text-sm font-medium text-gray-900">Kode Alternatif</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                <span class="material-symbols-rounded text-lg">tag</span>
                            </div>
                            <input type="text" id="code" name="code" 
                                value="{{ old('code', $alternative->code ?? '') }}" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" 
                                placeholder="Contoh: A1, A2" required>
                        </div>
                        @error('code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Nama -->
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Produk</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                <span class="material-symbols-rounded text-lg">inventory_2</span>
                            </div>
                            <input type="text" id="name" name="name" 
                                value="{{ old('name', $alternative->name ?? '') }}" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" 
                                placeholder="Contoh: Cetaphil Gentle Cleanser" required>
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('spk.alternatives') }}" class="text-gray-700 bg-white border border-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center flex items-center gap-2 justify-center">
                        <span class="material-symbols-rounded text-lg">save</span>
                        {{ isset($alternative) ? 'Update Data' : 'Simpan Data' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>