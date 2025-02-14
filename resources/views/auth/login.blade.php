<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.7);
        }
        
        .animated-bg {
            background: linear-gradient(-45deg, #4F46E5, #60A5FA, #818CF8, #3B82F6);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="animated-bg min-h-screen flex items-center justify-center p-4">
@if ($errors->any())
<div class="bg-red-500 text-white px-4 py-3 rounded-lg mb-4 flex items-center shadow-lg">
            <i class='bx bxs-error text-2xl mr-2'></i>
            <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
        </div>
    @endif
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 -left-4 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <div class="container mx-auto flex flex-col lg:flex-row items-center justify-center gap-12 relative z-10">
        <!-- Left Side - Welcome Section -->
        <div class="w-full lg:w-1/2 text-center lg:text-left" data-aos="fade-right">
            <div class="floating">
                <div class="bg-white/30 backdrop-blur-lg rounded-2xl p-8 shadow-2xl">
                    <div class="flex justify-center lg:justify-start">
                        <div class="bg-blue-600 p-4 rounded-2xl shadow-lg mb-6">
                            <i class='bx bxs-graduation text-4xl text-white'></i>
                        </div>
                    </div>
                    <h1 class="text-4xl font-bold text-white mb-4">Welcome Back!</h1>
                    <p class="text-blue-100 text-lg mb-6">Manage your school activities efficiently with our comprehensive system.</p>
                    <div class="grid grid-cols-2 gap-4 max-w-sm mx-auto lg:mx-0">
                        <div class="bg-white/20 backdrop-blur-md rounded-xl p-4">
                            <i class='bx bxs-user-check text-2xl text-white mb-2'></i>
                            <p class="text-white font-medium">Easy Tracking</p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-md rounded-xl p-4">
                            <i class='bx bxs-time-five text-2xl text-white mb-2'></i>
                            <p class="text-white font-medium">Real-time Data</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 max-w-md" data-aos="fade-left">
            <div class="glass-effect rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-center">
                    <h2 class="text-3xl font-bold text-white">Login to Your Account</h2>
                    <p class="text-blue-100 mt-2">Please enter your credentials</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="p-8 space-y-6">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-blue-900 font-semibold mb-2">Email Address</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-blue-500 group-hover:text-blue-600">
                                    <i class='bx bxs-envelope text-xl'></i>
                                </span>
                                <input type="email" 
                                       name="email" 
                                       required 
                                       class="w-full pl-10 pr-4 py-3 border-2 border-blue-100 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300"
                                       placeholder="Enter your email">
                            </div>
                        </div>

                        <div>
                            <label class="block text-blue-900 font-semibold mb-2">Password</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-blue-500 group-hover:text-blue-600">
                                    <i class='bx bxs-lock-alt text-xl'></i>
                                </span>
                                <input type="password" 
                                       name="password" 
                                       required 
                                       class="w-full pl-10 pr-4 py-3 border-2 border-blue-100 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300"
                                       placeholder="Enter your password">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   class="w-4 h-4 border-2 border-blue-500 rounded text-blue-600 focus:ring-blue-500 transition-colors duration-200">
                            <span class="ml-2 text-blue-900">Remember me</span>
                        </label>
                        <a href="#" class="text-blue-600 hover:text-blue-800 transition-colors duration-200">
                            Forgot Password?
                        </a>
                    </div>

                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl
                                   hover:from-blue-700 hover:to-indigo-700 transform hover:scale-[1.02] 
                                   active:scale-[0.98] transition-all duration-200 font-semibold shadow-lg 
                                   hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Sign in to Account
                    </button>

                </form>
            </div>
        </div>
    </div>

    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>
</html>