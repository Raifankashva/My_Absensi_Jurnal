<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Absensi Jurnal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .floating { 
            animation: float 6s ease-in-out infinite;
        }
        .gradient-text {
            background: linear-gradient(45deg, #3B82F6, #1E40AF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    <div class="container mx-auto px-4">
        <!-- Navigation -->
        <nav class="py-4">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold gradient-text">Absensi Jurnal</div>
                
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="flex flex-col-reverse lg:flex-row items-center justify-between py-20">
            <div class="lg:w-1/2 mt-10 lg:mt-0">
                <h1 class="text-5xl font-bold mb-6 gradient-text">Selamat Datang di Absensi Jurnal</h1>
                <p class="text-xl text-gray-600 mb-8">Aplikasi absensi jurnal untuk sekolah</p>
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-300 inline-block">Login</a>
                    <a href="#features" class="border-2 border-blue-600 text-blue-600 px-8 py-3 rounded-lg hover:bg-blue-50 transition duration-300 inline-block">Learn More</a>
                </div>
            </div>
            <div class="lg:w-1/2 relative">
                <!-- 3D-like Elements -->
                <div class="floating">
                    <div class="relative">
                        <!-- Main Circle -->
                        <div class="w-64 h-64 bg-blue-500 rounded-full absolute top-0 left-0 transform -translate-x-1/2 -translate-y-1/2 opacity-10"></div>
                        <!-- Decorative Elements -->
                        <div class="w-48 h-48 bg-blue-600 rounded-lg transform rotate-45 absolute top-10 right-10 opacity-20"></div>
                        <div class="w-32 h-32 bg-blue-700 rounded-full absolute bottom-0 right-0 opacity-15"></div>
                        <!-- Central Icon -->
                        <div class="w-96 h-96 bg-white rounded-2xl shadow-2xl p-8 transform rotate-3 relative z-10">
                            <div class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                