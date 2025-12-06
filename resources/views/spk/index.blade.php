<x-layouts.app>
    <x-slot:title>
        Dashboard SPK
    </x-slot:title>

    <div class="space-y-6">
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r shadow-sm">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Selamat Datang di Sistem Pendukung Keputusan Pemilihan <strong>Facial Wash</strong> menggunakan Metode <strong>Weighted Product (WP)</strong>.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('spk.criteria') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 hover:shadow-md transition">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Data Kriteria</h5>
                <p class="font-normal text-gray-700">Kelola data kriteria seperti Harga, Kandungan, Review, dll beserta bobotnya.</p>
            </a>

            <a href="{{ route('spk.alternatives') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 hover:shadow-md transition">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Data Alternatif</h5>
                <p class="font-normal text-gray-700">Kelola data produk Facial Wash yang akan dianalisa.</p>
            </a>

            <a href="{{ route('spk.analysis') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 hover:shadow-md transition">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Input Analisa</h5>
                <p class="font-normal text-gray-700">Masukkan nilai penilaian untuk setiap alternatif terhadap kriteria.</p>
            </a>

            <a href="{{ route('spk.calculation') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 hover:shadow-md transition">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Hasil Perhitungan</h5>
                <p class="font-normal text-gray-700">Lihat hasil perangkingan metode Weighted Product.</p>
            </a>
        </div>
    </div>
</x-layouts.app>