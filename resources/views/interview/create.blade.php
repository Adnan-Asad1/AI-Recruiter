<x-app-layout>

  <!-- Notyf CSS & JS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

  <div class="flex bg-gradient-to-br from-blue-100 to-blue-50 pt-6 px-8 pb-24 min-h-[91vh]">

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

      <main>
        <!-- Heading -->
        <h3 class="text-3xl mt-4 text-center font-bold text-gray-800 tracking-tight">
          ✨ Create Interview
        </h3>

        <!-- Progress Bar -->
        <div class="flex justify-center mt-6">
          <div class="relative w-2/3 h-3 bg-gray-200 rounded-full overflow-hidden shadow-inner">
            <div class="absolute top-0 left-0 h-3 bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-500 rounded-full" style="width: 30%;"></div>
          </div>
        </div>
        
        <!-- Form Card -->
        <div class="max-w-3xl mx-auto bg-white p-10 rounded-2xl shadow-xl mt-10 border border-gray-100">
          <h2 class="text-2xl font-bold text-indigo-600 mb-8 flex items-center gap-2">
            📝 Create Interview Details
          </h2>

          <form action="{{ route('generate.questions') }}" method="POST" class="space-y-8" onsubmit="handleSubmit(this)">
            @csrf

            <!-- Job Position -->
            <div>
              <label for="job_position" class="block font-medium text-gray-700 mb-2">💼 Job Position</label>
              <input type="text" id="job_position" name="job_position" placeholder="e.g. Frontend Developer" required
                class="w-full border border-gray-200 rounded-xl px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
            </div>

            <!-- Job Description -->
            <div>
              <label for="job_description" class="block font-medium text-gray-700 mb-2">🖊️ Job Description</label>
              <textarea id="job_description" name="job_description" rows="6" placeholder="Write a detailed description about the role..."
                class="w-full min-h-[140px] border border-gray-200 rounded-xl px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200" required></textarea>
            </div>

            <!-- Number of Questions & Duration -->
            <div class="flex flex-col md:flex-row gap-6">
              <!-- Questions -->
              <div class="w-full md:w-1/2">
                <label for="num_questions" class="block font-medium text-gray-700 mb-2">❓ Number of Questions</label>
                <input type="number" id="num_questions" name="num_questions" placeholder="e.g. 5" min="1" max="25" required
                  class="w-full border border-gray-200 rounded-xl px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
                <p class="text-sm text-gray-500 mt-1">Between 1 and 25 only</p>
              </div>

              <!-- Duration -->
              <div class="w-full md:w-1/2">
                <label for="duration" class="block font-medium text-gray-700 mb-2">⏱️ Max Duration</label>
                <select id="duration" name="duration" required
                  class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
                  <option value="" disabled selected>Select duration</option>
                  <option value="5">5 minutes</option>
                  <option value="10">10 minutes</option>
                  <option value="15">15 minutes</option>
                </select>
              </div>
            </div>

            <!-- Interview Type -->
            <div>
              <label class="block font-medium text-gray-700 mb-3">🧩 Interview Type</label>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach (['Technical','Behavioral','Experience','Problem Solving','Leadership'] as $type)
                  <label class="flex items-center space-x-3 p-3 border border-gray-200 rounded-xl shadow-sm hover:bg-indigo-50 cursor-pointer transition">
                    <input type="checkbox" name="interview_type[]" value="{{ $type }}" class="form-checkbox text-indigo-600 rounded">
                    <span class="text-gray-700 font-medium">{{ $type }}</span>
                  </label>
                @endforeach
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 pt-4">
              <a href="/dashboard"
                class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 transition duration-200 shadow-sm">
                Cancel
              </a>

              <button id="QuestionBtn" type="submit"
                class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2.5 rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200 font-medium">
                🚀 Generate Questions
              </button>
            </div>
          </form>
        </div>
      </main>

    </div>
  </div>

  <!-- JS -->
  <script>
    function handleSubmit(form) {
        let btn = form.querySelector("#QuestionBtn");
        btn.disabled = true;
        btn.innerHTML = `
            <svg class="animate-spin h-5 w-5 text-white inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <span>Generating...</span>
        `;
    }

    document.addEventListener("DOMContentLoaded", () => {
        const notyf = new Notyf({ duration:4000, position:{x:'right', y:'top'} });

        // ✅ Show error message from backend
        @if(session()->has('error'))
            notyf.error(@json(session('error')));
        @endif
    });
  </script>

</x-app-layout>
