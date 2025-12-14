<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - SPK Facial Wash</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 antialiased min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

    <!-- Logo / Brand -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-blue-600">
            <span class="material-symbols-rounded text-4xl font-bold">spa</span>
            <span class="text-2xl font-bold tracking-wide text-gray-800">SPK <span class="text-blue-600">Wash</span></span>
        </div>
    </div>

    <!-- Card Container -->
    <div class="w-full sm:max-w-md mt-2 px-8 py-8 bg-white shadow-lg overflow-hidden sm:rounded-xl border border-gray-100">
        
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Akun Baru</h2>
            <p class="text-sm text-gray-500">Lengkapi data diri Anda untuk memulai.</p>
        </div>

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
                <input id="name" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2 border" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Contoh: Budi Santoso" />
                @error('name')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="email" class="block font-medium text-sm text-gray-700">Email Address</label>
                <input id="email" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2 border" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com" />
                @error('email')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Grid untuk Usia dan Status -->
            <div class="grid grid-cols-2 gap-4 mt-4">
                <!-- Usia -->
                <div>
                    <label for="age" class="block font-medium text-sm text-gray-700">Usia (Tahun)</label>
                    <input id="age" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2 border" type="number" name="age" value="{{ old('age') }}" required min="10" max="100" placeholder="22" />
                    @error('age')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block font-medium text-sm text-gray-700">Status Saat Ini</label>
                    <!-- UI Updated: Ditambahkan class styling lengkap agar seragam -->
                    <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2 border text-sm bg-white" required>
                        <option value="" disabled selected>-- Pilih --</option>
                        @foreach(\App\Models\User::getStatuses() as $status)
                            <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                <input id="password" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2 border" type="password" name="password" required autocomplete="new-password" />
                @error('password')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Konfirmasi Password</label>
                <input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2 border" type="password" name="password_confirmation" required autocomplete="new-password" />
                @error('password_confirmation')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('login') }}">
                    Sudah punya akun?
                </a>

                <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Daftar Sekarang
                </button>
            </div>
        </form>
    </div>
    
    <!-- Link Icon Google -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />

</body>
</html>