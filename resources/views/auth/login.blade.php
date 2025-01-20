<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center">
    <div 
        data-aos="zoom-in" 
        class="w-full max-w-md bg-white shadow-2xl rounded-2xl overflow-hidden">
        <div class="bg-blue-600 p-6 text-center">
            <h2 class="text-3xl font-bold text-white">Login</h2>
        </div>
        <form 
            method="POST" 
            action="{{ route('login') }}" 
            class="p-8 space-y-6">
            @csrf
            
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <input 
                        type="email" 
                        name="email" 
                        required 
                        class="w-full pl-10 pr-4 py-2 border-2 border-blue-200 rounded-lg focus:outline-none focus:border-blue-500 transition duration-300"
                        placeholder="Masukkan email anda"
                    >
                </div>
            </div>

            <div>
                <label class="block text-blue-700 font-semibold mb-2">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </span>
                    <input 
                        type="password" 
                        name="password" 
                        required 
                        class="w-full pl-10 pr-4 py-2 border-2 border-blue-200 rounded-lg focus:outline-none focus:border-blue-500 transition duration-300"
                        placeholder="Masukkan password anda"
                    >
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input 
                        type="checkbox" 
                        class="form-checkbox h-4 w-4 text-blue-600"
                    >
                    <span class="ml-2 text-gray-700">Ingat Saya</span>
                </label>
                <a href="#" class="text-blue-500 hover:text-blue-700 transition">Lupa Password?</a>
            </div>

            <button 
                type="submit" 
                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition duration-300 transform hover:scale-105 shadow-lg"
            >
                Login
            </button>

            <div class="text-center mt-4">
                <p class="text-gray-600">
                    Belum punya akun? 
                    <a href="#" class="text-blue-500 hover:text-blue-700">Daftar Sekarang</a>
                </p>
            </div>
        </form>
    </div>

    <script>
        AOS.init();
    </script>
</body>
</html>