<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPK Facial Wash</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden md:max-w-lg">
        <div class="md:flex">
            <div class="w-full p-8 px-10">
                <div class="text-center mb-8">
                    <h1 class="font-bold text-2xl text-blue-600">SPK Facial Wash</h1>
                    <p class="text-gray-500 text-sm mt-2">Masuk untuk mengelola data keputusan</p>
                </div>

                <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="admin@example.com">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" id="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="••••••••">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 shadow-md">
                        Masuk Sistem
                    </button>
                </form>

                <!-- BUTTON REGISTER ADDED HERE -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:text-blue-800 hover:underline transition">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
                
                <div class="mt-8 text-center text-xs text-gray-400">
                    &copy; {{ date('Y') }} Skripsi SPK Metode Weighted Product
                </div>
            </div>
        </div>
    </div>

</body>
</html>