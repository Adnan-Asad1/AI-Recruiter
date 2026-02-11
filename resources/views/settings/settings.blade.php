<x-app-layout>
  <div class="min-h-[91vh] bg-gradient-to-br from-blue-100 to-blue-50 py-10 px-6" id="settings-app">

    <div class="max-w-5xl mx-auto">

      <!-- Page Heading -->
      <div class="flex justify-between items-center mb-10">
        <x-page-heading>Settings</x-page-heading>
        
        <!-- 🌗 Toggle Theme -->
        <button id="theme-toggle"
          class="px-4 py-2 rounded-xl bg-gray-800 text-white shadow hover:bg-gray-700 transition">
          🌗 Toggle Theme
        </button>
      </div>

      <!-- Success & Errors -->
      @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-md mb-4">
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded-md mb-4">
          {{ $errors->first() }}
        </div>
      @endif

      <!-- Settings Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Account Info -->
        <section class="bg-white border border-gray-200 rounded-2xl shadow-md p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">👨‍💼 Account Information</h3>

          <!-- Profile Photo -->
          <div class="flex items-center mb-4">
            <img src="{{ $user->picture ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" 
                 alt="Profile Photo" 
                 class="w-16 h-16 rounded-full border border-gray-300 shadow mr-4">
            <div>
              <p class="text-gray-800 font-medium">{{ $user->name }}</p>
              <p class="text-gray-500 text-sm">{{ $user->email }}</p>
            </div>
          </div>

          <form action="{{ route('settings.updateAccount') }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
              <label class="block text-gray-700 font-medium mb-1">Name</label>
              <input type="text" name="name" value="{{ $user->name }}" 
                     class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
            </div>

            <div>
              <label class="block text-gray-700 font-medium mb-1">Email</label>
              <input type="email" name="email" value="{{ $user->email }}" 
                     class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
            </div>

            <button type="submit" 
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow hover:bg-indigo-700 transition">
              Update Account
            </button>
          </form>
        </section>

        <!-- Credits -->
        <section class="bg-white border border-gray-200 rounded-2xl shadow-md p-6 flex flex-col justify-between">
          <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">💳 Your Credits</h3>
            <p class="text-gray-700">
              You currently have 
              <span class="font-semibold text-indigo-600">{{ $user->credit ?? 0 }}</span> interview credits.
            </p>
          </div>
          <a href="/billing" 
             class="mt-6 bg-blue-600 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700 transition text-center">
            Buy More
          </a>
        </section>

        <!-- Change Password -->
        <section class="bg-white border border-gray-200 rounded-2xl shadow-md p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">🔒 Change Password</h3>
          <form action="{{ route('settings.updatePassword') }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
              <label class="block text-gray-700 font-medium mb-1">Current Password</label>
              <input type="password" name="current_password" 
                     class="w-full border border-gray-300 rounded-md px-4 py-2" required>
            </div>

            <div>
              <label class="block text-gray-700 font-medium mb-1">New Password</label>
              <input type="password" name="password" 
                     class="w-full border border-gray-300 rounded-md px-4 py-2" required>
            </div>

            <div>
              <label class="block text-gray-700 font-medium mb-1">Confirm Password</label>
              <input type="password" name="password_confirmation" 
                     class="w-full border border-gray-300 rounded-md px-4 py-2" required>
            </div>

            <button type="submit" 
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow hover:bg-indigo-700 transition">
              Change Password
            </button>
          </form>
        </section>

        <!-- Logout Section -->
        <section class="bg-white border border-gray-200 rounded-2xl shadow-md p-6 flex flex-col justify-between">
          <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">🚪 Logout</h3>
            <p class="text-gray-700">Sign out of your account securely.</p>
          </div>
          <form action="{{ route('logout') }}" method="GET">
            @csrf
            <button type="submit" 
                    class="w-full bg-red-600 text-white px-4 py-2 rounded-md shadow hover:bg-red-700 transition">
              Logout
            </button>
          </form>
        </section>

      </div>
    </div>
  </div>

  <!-- ✅ Theme Toggle Script -->
  <script>
    const btn = document.getElementById('theme-toggle');
    const root = document.documentElement;

    // Default = light
    if (localStorage.getItem('theme') === 'dark') {
      root.classList.add('dark');
    } else {
      root.classList.remove('dark');
    }

    btn.addEventListener('click', () => {
      root.classList.toggle('dark');
      if (root.classList.contains('dark')) {
        localStorage.setItem('theme', 'dark');
      } else {
        localStorage.setItem('theme', 'light');
      }
    });
  </script>
</x-app-layout>
