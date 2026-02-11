<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- ✅ Laravel CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Smart Hire - AI Recruitment</title>

  @vite(['resources/css/app.css', 'resources/js/app.js']) 
</head>

<body class="bg-gradient-to-br from-blue-100 to-blue-50 text-gray-800 font-sans">

  {{-- ✅ Top Header --}}
  <header class="fixed top-0 left-0 w-full border-b bg-white z-20">
    <div class="px-6 md:px-10 flex h-16 items-center justify-between">
      <!-- 🔸 Logo -->
      <div class="flex items-center gap-2">
        <img 
          src="{{ asset('logos.png') }}" 
          alt="Smart Hire Logo" 
          width="160" 
          class="h-auto object-contain"
        />
      </div>

      <!-- 🔸 Navbar Links for Guests -->
      <nav class="hidden md:flex items-center gap-6">
        @guest
          <a class="text-sm font-medium hover:underline" href="#features">Features</a>
          <a class="text-sm font-medium hover:underline" href="#how-it-works">How It Works</a>
          <a class="text-sm font-medium hover:underline" href="#our-clients">Our Clients Feedback</a>
        @endguest
      </nav> 

      <!-- 🔸 Auth Buttons -->
      <div class="flex items-center gap-4">
        @guest
          <a href="/login">
            <button class="bg-[#0377FC] text-white hover:bg-indigo-700 h-9 px-4 py-2 rounded-md shadow text-sm font-medium">
              Login
            </button>
          </a>
          <a href="/register">
            <button class="bg-[#0377FC] text-white hover:bg-indigo-700 h-9 px-4 py-2 rounded-md shadow text-sm font-medium">
              Register
            </button>
          </a> 
        @endguest

        @auth
          <a href="/logout">
            <button class="bg-[#0377FC] text-white hover:bg-indigo-700 h-9 px-4 py-2 rounded-md shadow text-sm font-medium">
              Log Out
            </button>
          </a>  
        @endauth
      </div>
    </div>
  </header>

  <div class="pt-16 flex">

    {{-- ✅ Sidebar for Authenticated Users --}}
    @auth
    <aside class="fixed top-16 left-0 w-64 h-[calc(100vh-4rem)] bg-gray-50 border-r shadow-2xl p-4 z-10 pt-12 ">

        {{-- 🔵 Create Interview Button --}}
        <div class="mb-8">
            <a href="/interview/create" 
              class="block bg-[#0377FC] text-white text-center py-2 px-4 rounded-md font-semibold hover:bg-indigo-700 transition">
                + Create New Interview
            </a>
        </div>

        {{-- 🔵 Sidebar Navigation --}}
        <ul class="space-y-3">

            @php
                $links = [
                    ['name'=>'Dashboard', 'url'=>'dashboard', 'icon'=>'M3 12l9-9 9 9M4 10v10a1 1 0 001 1h3m10-11v11a1 1 0 01-1 1h-3m-4 0h4'],
                    ['name'=>'Scheduled Interviews', 'url'=>'Interviews-Details', 'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['name'=>'All Interviews', 'url'=>'All-Interviews', 'icon'=>'M17 20h5v-2a4 4 0 00-3-3.87M9 20h6M4 20h5v-2a4 4 0 013-3.87M15 7a4 4 0 11-8 0 4 4 0 018 0z'],
                    ['name'=>'Feed Resume', 'url'=>'feed-resume', 'icon'=>'M12 16v-8m0 8l-4-4m4 4l4-4M4 6a2 2 0 012-2h6l6 6v10a2 2 0 01-2 2H6a2 2 0 01-2-2z'],
                    ['name'=>'Billing', 'url'=>'billing', 'icon'=>'M9 12h6m-6 0v3m6-3v3M6 16h12a2 2 0 002-2V8a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zM9 6V4a1 1 0 011-1h4a1 1 0 011 1v2'],
                    ['name'=>'Settings', 'url'=>'settings', 'icon'=>'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z']
                ];
            @endphp

            @foreach($links as $link)
                @php
                    $isActive = request()->is($link['url']) ? true : false;
                @endphp
                <li>
                    <a href="{{ url($link['url']) }}"
                      class="flex items-center gap-3 px-3 py-2 rounded-md text-base font-medium transition
                      {{ $isActive ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-100 hover:text-indigo-700' }}">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}"/>
                        </svg>
                        {{ $link['name'] }}
                    </a>
                </li>
            @endforeach

        </ul>
    </aside>
    @endauth

    {{-- ✅ Main Page Content --}}
    <main class="flex-1 bg-white @auth pl-64 @endauth min-h-[calc(100vh-4rem)]">
      {{ $slot }}
    </main>

  </div>

</body>
</html>
