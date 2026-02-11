<x-guest-layout>

<!-- ✅ Register Section -->

    <div 
      class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg">
      <h2 class="text-3xl font-bold text-center text-indigo-800 mb-6">Create Your Account</h2>

      <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Full Name</label>
          <input type="text" name="name" value="{{ old('name') }}"
            placeholder="Enter your full name"
            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none"
            required>
          @error('name')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Email -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Email Address</label>
          <input type="email" name="email" value="{{ old('email') }}"
            placeholder="Enter your email"
            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none"
            required>
          @error('email')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Picture Upload -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
          <input type="file" name="picture"
            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none"
            accept="image/*">
          @error('picture')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Password</label>
          <input type="password" name="password"
            placeholder="Minimum 8 Characters"
            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none"
            required>
          @error('password')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Confirm Password -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <input type="password" name="password_confirmation"
            placeholder="Re-enter your password"
            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none"
            required>
          @error('password_confirmation')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Submit -->
        <div>
          <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
            Register
          </button>
        </div>

        <!-- Login Link -->
        <p class="text-center text-sm text-gray-600 mt-4">
          Already have an account?
          <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-medium">Login</a>
        </p>
      </form>
    </div>
 


</x-guest-layout>
