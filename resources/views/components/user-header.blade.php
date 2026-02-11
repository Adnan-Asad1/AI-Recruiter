<section class="bg-white border-b shadow-sm p-5 shadow-xl mb-4 flex items-center justify-between rounded-xl">
  <div>
      <h3 class="text-3xl font-extrabold text-gray-800">
          Welcome back, <span class="bg-gradient-to-r from-purple-700 to-blue-700 bg-clip-text text-transparent">{{ Auth::user()->name }} </span>

      </h3>
      <p class="text-base text-gray-500 mt-1">AI-Driven Interviews, Hassle-Free Hiring</p>
  </div>

  <div class="flex items-center space-x-4">
      <img src="{{ asset('storage/' . Auth::user()->picture) }}" class="w-12 h-12 rounded-full object-cover" alt="User Avatar">
  </div>
</section>
