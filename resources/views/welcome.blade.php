<x-app-layout>

<section 
  class="bg-gradient-to-br from-indigo-100 to-white flex min-h-[85vh] items-center overflow-x-hidden">
  
  <div 
    class="max-w-7x3 mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-6 md:gap-12 items-center">

    <!-- 🔸 Left Content -->
    <div 
      class="space-y-6 opacity-0 translate-x-[-40px] animate-fade-in-left"
    >
      <h2 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
        AI-Powered Interview Platform for Hiring 
      </h2>
      <p class="text-lg text-gray-600">
        Conduct voice-based interviews, generate AI questions, and get instant feedback — all in one platform.
      </p>
      <a 
        href="/login" 
        class="inline-block bg-[#0377FC] text-white px-6 py-3 rounded-md hover:bg-indigo-700 text-sm font-semibold">
        Get Started
      </a>
    </div>

    <!-- 🔸 Right Image -->
    <div 
      class="flex justify-center items-center opacity-0 translate-x-[40px] animate-fade-in-right"
    >
      <img 
        src="{{ asset('Ai.jpeg') }}" 
        alt="AI Interview Illustration" 
        class="w-full max-w-[700px] h-full object-contain rounded-xl"
      />
    </div>

  </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-white mt-12 mb-12">
  <div class="max-w-5xl mx-auto px-6">
    
    <!-- 🔹 Animated Heading -->
    <h1 
      class="text-3xl font-bold text-center text-gray-900 mb-2"
      data-aos="fade-up"
      data-aos-duration="700"
    >
      Automate your Hiring Process
    </h1>

    <!-- 🔹 Animated Subheading -->
    <span 
      class="block text-center text-gray-600 mb-12 text-sm md:text-base"
      data-aos="fade-up"
      data-aos-delay="100"
      data-aos-duration="700"
    >
      Save time, reduce bias, and streamline interviews with our smart, voice-enabled hiring platform.<br>
      From AI question generation to instant evaluations — we’ve got it all.
    </span>

    <!-- 🔹 Feature Cards -->
    <div class="grid md:grid-cols-3 gap-8">
      
      <!-- Feature 1 -->
      <div 
        class="text-center border border-gray-300 rounded-xl p-8 transition-all duration-300 hover:shadow-md hover:border-indigo-500 hover:scale-105"
        data-aos="fade-up" 
        data-aos-delay="200"
      >
        <div class="text-indigo-600 text-4xl mb-4">🎙️</div>
        <h4 class="text-lg font-semibold mb-2">Voice Interviews</h4>
        <p class="text-sm text-gray-600">Conduct live or automated voice interviews in real-time.</p>
      </div>

      <!-- Feature 2 -->
      <div 
        class="text-center border border-gray-300 rounded-xl p-8 transition-all duration-300 hover:shadow-md hover:border-indigo-500 hover:scale-105"
        data-aos="fade-up" 
        data-aos-delay="300"
      >
        <div class="text-indigo-600 text-4xl mb-4">🧠</div>
        <h4 class="text-lg font-semibold mb-2">AI Questions</h4>
        <p class="text-sm text-gray-600">Let our GPT-powered system generate smart interview questions.</p>
      </div>

      <!-- Feature 3 -->
      <div 
        class="text-center border border-gray-300 rounded-xl p-8 transition-all duration-300 hover:shadow-md hover:border-indigo-500 hover:scale-105"
        data-aos="fade-up" 
        data-aos-delay="400"
      >
        <div class="text-indigo-600 text-4xl mb-4">📈</div>
        <h4 class="text-lg font-semibold mb-2">Instant Insights</h4>
        <p class="text-sm text-gray-600">Get performance feedback and evaluation instantly after each session.</p>
      </div>

    </div>
  </div>
</section>


<!-- How it works Section -->
<section id="how-it-works" class="py-20 bg-gray-50 mt-12">
  <div class="max-w-5xl mx-auto px-6">

    <!-- 🔹 Animated Heading -->
    <h1 
      class="text-3xl font-bold text-center text-gray-900 mb-2"
      data-aos="fade-up"
      data-aos-duration="700"
    >
      How It Works
    </h1>

    <!-- 🔹 Animated Subheading -->
    <span 
      class="block text-center text-gray-600 mb-12 text-sm md:text-base"
      data-aos="fade-up"
      data-aos-delay="100"
      data-aos-duration="700"
    >
      Simple steps to get started with Smart Hire. From setting up to reviewing interviews,<br>
      everything is streamlined for your ease.
    </span>

    <!-- 🔹 Steps -->
    <div class="grid md:grid-cols-3 gap-8">
      
      <!-- Step 1 -->
      <div 
        class="text-center border border-gray-300 rounded-xl p-8 transition-all duration-300 hover:shadow-md hover:border-indigo-500 hover:scale-105"
        data-aos="fade-up" 
        data-aos-delay="200"
      >
        <div class="text-indigo-600 text-4xl mb-4">📝</div>
        <h4 class="text-lg font-semibold mb-2">Create a Job</h4>
        <p class="text-sm text-gray-600">Start by setting up your job post with role-specific details and requirements.</p>
      </div>

      <!-- Step 2 -->
      <div 
        class="text-center border border-gray-300 rounded-xl p-8 transition-all duration-300 hover:shadow-md hover:border-indigo-500 hover:scale-105"
        data-aos="fade-up" 
        data-aos-delay="300"
      >
        <div class="text-indigo-600 text-4xl mb-4">🎤</div>
        <h4 class="text-lg font-semibold mb-2">Conduct Interviews</h4>
        <p class="text-sm text-gray-600">Invite candidates for voice-based AI interviews and collect responses automatically.</p>
      </div>

      <!-- Step 3 -->
      <div 
        class="text-center border border-gray-300 rounded-xl p-8 transition-all duration-300 hover:shadow-md hover:border-indigo-500 hover:scale-105"
        data-aos="fade-up" 
        data-aos-delay="400"
      >
        <div class="text-indigo-600 text-4xl mb-4">📊</div>
        <h4 class="text-lg font-semibold mb-2">Review Results</h4>
        <p class="text-sm text-gray-600">Access performance analytics and AI-generated feedback for quick decision-making.</p>
      </div>

    </div>
  </div>
</section>


<!-- Smart Hire Branding Outro -->
<section class="bg-[#F4F7FE] py-32 mt-24 min-h-[75vh]">
  <div 
    class="flex justify-center items-center"
    data-aos="fade-up"
    data-aos-duration="1200"
  >
    <h1 class="text-[80px] md:text-[120px] font-extrabold text-gray-900 tracking-tight">
      Smart <span class="text-[#0377FC]">Hire</span>
    </h1>
  </div>
</section>


<!-- ⭐ user say  Section -->
<section id="our-clients"  class="bg-white py-20 border-t border-gray-200 mb-11">
  <div class="max-w-6xl mx-auto px-6 text-center">
    <h2 
      class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"
      data-aos="fade-up"
    >
      What Our Users Say
    </h2>
    <p 
      class="text-gray-600 mb-12 max-w-2xl mx-auto text-sm md:text-base"
      data-aos="fade-up"
      data-aos-delay="100"
    >
      Hear from HR managers and recruiters who transformed their hiring process using Smart Hire.
    </p>

    <div class="grid md:grid-cols-3 gap-8">
      
      <!-- Testimonial 1 -->
      <div 
        class="p-6 border rounded-xl shadow-sm hover:shadow-md transition"
        data-aos="zoom-in"
        data-aos-delay="200"
      >
        <p class="text-gray-700 mb-4 italic">“Smart Hire completely changed the way we conduct technical interviews. The voice AI is shockingly effective.”</p>
        <h4 class="font-semibold text-gray-900">Sarah A.</h4>
        <span class="text-sm text-gray-500">HR Lead, TechCore</span>
      </div>

      <!-- Testimonial 2 -->
      <div 
        class="p-6 border rounded-xl shadow-sm hover:shadow-md transition"
        data-aos="zoom-in"
        data-aos-delay="300"
      >
        <p class="text-gray-700 mb-4 italic">“The instant evaluation reports are a lifesaver. We reduced hiring time by 40%.”</p>
        <h4 class="font-semibold text-gray-900">Jason M.</h4>
        <span class="text-sm text-gray-500">Recruiter, HireFlow</span>
      </div>

      <!-- Testimonial 3 -->
      <div 
        class="p-6 border rounded-xl shadow-sm hover:shadow-md transition"
        data-aos="zoom-in"
        data-aos-delay="400"
      >
        <p class="text-gray-700 mb-4 italic">“Impressed by the AI-generated questions. It's like having an intelligent co-interviewer.”</p>
        <h4 class="font-semibold text-gray-900">Ayesha K.</h4>
        <span class="text-sm text-gray-500">Talent Manager, NexHire</span>
      </div>

    </div>
  </div>
</section>


<!-- Smart Hire Get started -->
<section class="bg-white py-24">
  <div 
    class="max-w-6xl mx-auto px-6 text-center"
    data-aos="zoom-in"
    data-aos-duration="700"
  >
    <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 tracking-tight mb-4">
      Start With <span class="text-[#0377FC]">Smart Hire</span>
    </h1>
    <p class="text-lg text-gray-600 max-w-2xl mx-auto mt-4">
      Revolutionizing interviews with AI-powered automation, real-time voice interaction, and smart evaluations.
    </p>

    <a 
      href="/login" 
      class="inline-block mt-10 px-8 py-3 bg-[#0377FC] text-white rounded-lg font-semibold hover:bg-indigo-700 transition duration-300"
    >
      Get Started
    </a>
  </div>
</section>


  <!-- 🔹 Footer -->
<footer class="py-10 text-center text-sm text-gray-500 border-t">

    &copy; 2025 Smart Hire. All rights reserved.
</footer>


</x-app-layout>