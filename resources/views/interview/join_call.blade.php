<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <title>Interview — {{ $interview->job_position ?? 'Job' }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>
<body class="bg-gradient-to-br from-blue-100/80 to-indigo-100/80 min-h-screen p-6 relative overflow-x-hidden">

  <div class="max-w-4xl w-full mx-auto bg-white/60 backdrop-blur-xl rounded-3xl shadow-2xl border border-gray-100 overflow-hidden animate-fadeIn hover:shadow-blue-400/40 transition-shadow duration-500">

    <!-- Header Logo -->
    <div class="py-6 text-center border-b border-gray-100 bg-gradient-to-r from-blue-400/80 to-indigo-400">
      <img src="{{ asset('logos.png') }}" alt="Logo" class="mx-auto h-14 w-auto drop-shadow-md hover:scale-105 transition-transform duration-500">
    </div>

    <div class="p-8 grid md:grid-cols-2 gap-12 items-start">

      <!-- Left Side Picture -->
      <div class="rounded-3xl overflow-hidden shadow-lg transform transition-transform hover:scale-105 duration-500 mt-20">
        <img src="{{ asset('inter.png') }}" alt="Interview Illustration" class="w-full h-[340px] object-cover">
      </div>

      <!-- Right Side Content -->
      <div>
        <!-- Job Title -->
        <h2 class="text-4xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent drop-shadow-md">
          {{ $interview->job_position ?? 'Position' }}
        </h2>

        <p class="mt-4 text-gray-700 text-base leading-relaxed line-clamp-2">
          {{ $interview->job_description ?? 'No description provided.' }}
        </p>

        <!-- Info Boxes -->
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-5">
          <div class="flex items-center p-3 bg-blue-100/60  shadow-md rounded-2xl border border-gray-200">
            <span class="p-2 bg-blue-200 rounded-full text-blue-700 shadow-inner">
              <!-- clock icon -->
              <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </span>
            <span class="ml-3 text-gray-800 text-xs font-medium">
              Max Duration: {{ $interview->duration ?? '--' }} minutes
            </span>
          </div>

          <div class="flex items-center p-3 bg-blue-100/60 shadow-md rounded-2xl border border-gray-200">
            <span class="p-2 bg-indigo-200 rounded-full text-purple-700 shadow-inner">
              <!-- questions icon -->
              <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m2 4H7m5-12v16M4 6h16"/>
              </svg>
            </span>
            <span class="ml-3 text-gray-800 text-xs font-medium">
              Questions: {{ $interview->num_questions ?? '--' }}
            </span>
          </div>
        </div>

        <!-- Join Form -->
        <form action="{{ route('interview.call', $interview->id) }}" method="POST" class="mt-8 space-y-5">
          @csrf

          <div>
            <label for="name" class="block text-base font-medium text-gray-800">Your Name</label>
            <input type="text" id="name" name="name" required
              class="mt-1 w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm bg-white/70 backdrop-blur-sm">
          </div>

          <div>
            <label for="email" class="block text-base font-medium text-gray-800">Your Email</label>
            <input type="email" id="email" name="email" required
              class="mt-1 w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm bg-white/70 backdrop-blur-sm">
          </div>

          <!-- Button -->
          <div class="text-center">
            <button type="submit"
              class="px-10 py-3 bg-blue-600  text-white text-lg font-bold rounded-full shadow-xl hover:shadow-blue-400/50 hover:scale-105 transform transition-all duration-300">
              🚀 Join Interview
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>