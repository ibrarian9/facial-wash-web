<x-layouts.app>
    <x-slot:title>
        {{ isset($criteria) ? 'Edit Kriteria' : 'Tambah Kriteria' }}
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">
                    {{ isset($criteria) ? 'Edit Data Kriteria' : 'Tambah Kriteria Baru' }}
                </h2>
                <a href="{{ route('spk.criteria.store') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 font-medium">
                    <span class="material-symbols-rounded text-lg">arrow_back</span> Kembali
                </a>
            </div>

            <!-- Form Action dinamis: Jika ada data maka UPDATE, jika tidak maka STORE -->
            <form action="{{ isset($criteria) ? route('spk.criteria.update', $criteria->id) : route('spk.criteria.store') }}" method="POST" class="p-6">
                @csrf
                @if(isset($criteria))
                    @method('PUT')
                @endif

                <!-- Kode Kriteria -->
                <div class="mb-5">
                    <label for="code" class="block mb-2 text-sm font-bold text-gray-700">Kode Kriteria</label>
                    <input type="text" id="code" name="code" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 uppercase font-mono tracking-wider" 
                        placeholder="Contoh: C1" 
                        value="{{ old('code', $criteria->code ?? '') }}" required>
                    @error('code') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Nama Kriteria -->
                <div class="mb-5">
                    <label for="name" class="block mb-2 text-sm font-bold text-gray-700">Nama Kriteria</label>
                    <input type="text" id="name" name="name" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        placeholder="Contoh: Harga Produk" 
                        value="{{ old('name', $criteria->name ?? '') }}" required>
                    @error('name') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Bobot -->
                    <div>
                        <label for="weight" class="block mb-2 text-sm font-bold text-gray-700">Bobot Preferensi</label>
                        <input type="number" step="0.01" id="weight" name="weight" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                            placeholder="Contoh: 0.25" 
                            value="{{ old('weight', $criteria->weight ?? '') }}" required>
                        <p class="mt-1 text-xs text-gray-500">Nilai kepentingan (Total bobot tidak harus 1).</p>
                        @error('weight') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Atribut (Benefit/Cost) -->
                    <div>
                        <label for="type" class="block mb-2 text-sm font-bold text-gray-700">Atribut (Type)</label>
                        <select id="type" name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <option value="" disabled selected>-- Pilih Atribut --</option>
                            <option value="benefit" {{ old('type', $criteria->type ?? '') == 'benefit' ? 'selected' : '' }}>Benefit (Makin Tinggi Makin Bagus)</option>
                            <option value="cost" {{ old('type', $criteria->type ?? '') == 'cost' ? 'selected' : '' }}>Cost (Makin Rendah Makin Bagus)</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Contoh: Harga = Cost, Kualitas = Benefit.</p>
                        @error('type') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-3 text-center flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    <span class="material-symbols-rounded">save</span>
                    {{ isset($criteria) ? 'Simpan Perubahan' : 'Simpan Data Baru' }}
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>