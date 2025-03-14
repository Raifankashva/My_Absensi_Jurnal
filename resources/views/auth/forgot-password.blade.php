<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Sistem Informasi Akademik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#EFF6FF',
                            100: '#DBEAFE',
                            200: '#BFDBFE',
                            300: '#93C5FD',
                            400: '#60A5FA',
                            500: '#3B82F6',
                            600: '#2563EB',
                            700: '#1D4ED8',
                            800: '#1E40AF',
                            900: '#1E3A8A',
                            950: '#172554',
                        },
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'shimmer': 'shimmer 2s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-1000px 0' },
                            '100%': { backgroundPosition: '1000px 0' },
                        },
                    },
                },
            },
        }
    </script>
    <style>
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.85;
                transform: scale(1.02);
            }
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Animated background */
        .animated-bg {
            background: linear-gradient(-45deg, #EFF6FF, #DBEAFE, #BFDBFE, #93C5FD);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        /* Glass morphism */
        .glass-morphism {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
        }

        /* Floating elements */
        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Fade in animation classes */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out forwards;
        }

        .animate-slide-up {
            animation: slideUp 0.5s ease-in-out forwards;
        }

        /* Staggered animations */
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
    </style>
</head>
<body class="font-sans animated-bg min-h-screen flex items-center justify-center p-4">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Top right decorative circle -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full opacity-10 -translate-y-1/2 translate-x-1/2"></div>
        
        <!-- Bottom left decorative circle -->
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-500 rounded-full opacity-10 translate-y-1/2 -translate-x-1/2"></div>
        
        <!-- Floating elements -->
        <div class="absolute top-1/4 left-1/4 w-16 h-16 bg-blue-400 rounded-full opacity-20 floating"></div>
        <div class="absolute top-3/4 right-1/4 w-12 h-12 bg-indigo-400 rounded-full opacity-20 floating" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/3 w-8 h-8 bg-blue-300 rounded-full opacity-20 floating" style="animation-delay: 2s;"></div>
    </div>

    <!-- Main Container -->
    <div class="w-full max-w-md relative z-10 opacity-0 animate-fade-in">
        <!-- Logo and Header -->
        <div class="text-center mb-8 opacity-0 animate-slide-up stagger-1">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl shadow-lg mb-4 transform transition-all duration-300 hover:scale-110">
                <i class='bx bx-lock-open-alt text-3xl text-white'></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Lupa Password?</h1>
            <p class="text-gray-600 mt-2">Masukkan email Anda untuk menerima link reset password</p>
        </div>

        <!-- Form Container -->
        <div class="glass-morphism rounded-2xl shadow-xl overflow-hidden opacity-0 animate-slide-up stagger-2">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 border-b border-white/10">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class='bx bx-envelope mr-2'></i>
                    Reset Password
                </h2>
            </div>

            <div class="p-6">
                @if (session('message'))
                    <div class="p-4 mb-6 rounded-xl bg-gradient-to-r from-green-500/10 to-emerald-500/10 border border-green-200 relative overflow-hidden opacity-0 animate-slide-up stagger-3">
                        <div class="absolute inset-0 bg-green-500/5"></div>
                        <div class="relative flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-r from-green-500 to-emerald-500 text-white p-2 rounded-lg mr-3">
                                <i class='bx bx-check text-xl'></i>
                            </div>
                            <p class="text-green-800">{{ session('message') }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-2 opacity-0 animate-slide-up stagger-3">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class='bx bx-envelope text-gray-400'></i>
                            </div>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl 
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                       transition-all duration-300 bg-white/80 backdrop-blur-sm"
                                placeholder="your.email@example.com"
                            >
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="opacity-0 animate-slide-up stagger-4">
                        <button
                            type="submit"
                            class="w-full flex justify-center items-center px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 
                                   text-white font-medium rounded-xl shadow-md hover:shadow-lg hover:shadow-blue-500/20
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                                   transform transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]"
                        >
                            <i class='bx bx-mail-send mr-2'></i>
                            Kirim Link Reset
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center opacity-0 animate-slide-up" style="animation-delay: 0.5s;">
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-800 transition-colors duration-300 flex items-center justify-center">
                        <i class='bx bx-arrow-back mr-1'></i>
                        Kembali ke halaman login
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 opacity-0 animate-slide-up" style="animation-delay: 0.6s;">
            <p class="text-gray-600 text-sm">
                © {{ date('Y') }} Sistem Informasi Akademik. Hak Cipta Dilindungi.
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show elements with animation
            document.querySelectorAll('.opacity-0').forEach(el => {
                el.classList.remove('opacity-0');
            });
        });
    </script>
</body>
</html>
