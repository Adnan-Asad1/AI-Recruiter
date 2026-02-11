<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-200 via-white to-blue-100 overflow-hidden relative p-6">

    {{-- Animated background orbs --}}
    <div class="absolute top-10 left-10 w-40 h-40 bg-blue-200/30 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-20 w-60 h-60 bg-blue-300/20 rounded-full blur-3xl animate-spin-slow"></div>

    {{-- Glass Card --}}
    <div class="relative bg-white/30 backdrop-blur-2xl p-12 rounded-3xl shadow-2xl max-w-lg w-full text-center border border-blue-100 transition-all duration-500 hover:scale-105 hover:shadow-blue-400/40">
        
        {{-- Floating success icon --}}
        <div class="flex justify-center">
            <svg class="text-blue-500 w-20 h-20 mb-6 drop-shadow-lg animate-float" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0C5.371 0 0 5.372 0 12c0 6.627 5.371 12 12 12s12-5.373 12-12c0-6.628-5.371-12-12-12zm-1.2 17.4l-5.4-5.4 1.8-1.8 3.6 3.6 7.2-7.2 1.8 1.8-9 9z"/>
            </svg>
        </div>

        {{-- Title --}}
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-blue-700 via-blue-500 to-blue-300 bg-clip-text text-transparent drop-shadow-lg mb-4">
            Thank You!
        </h1>

        {{-- Subtitle --}}
        <p class="text-gray-700 text-lg leading-relaxed mb-10">
            Your interview has been <span class="font-semibold text-blue-600">successfully completed</span>.  
            We truly appreciate your time and effort. Our team will reach out soon with the next steps.
        </p>

    </div>

    {{-- Floating background accents --}}
    <div class="absolute -top-16 -left-16 w-72 h-72 bg-blue-300/30 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>

    {{-- Optional custom animations --}}
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-float {
            animation: float 2s ease-in-out infinite;
        }

        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 20s linear infinite;
        }
    </style>

    {{-- Clear interview timer --}}
    <script>
        localStorage.removeItem('interviewStartTime');
    </script>

</body>
</html>
