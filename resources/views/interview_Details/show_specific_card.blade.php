<x-app-layout>
    <!-- Full Page Wrapper -->
    <div class="flex flex-col min-h-[91vh] bg-gradient-to-br from-blue-100 to-blue-50 pt-6 px-4">
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <main class="flex-1">
               
                <!-- Heading -->
                 <h3 class="py-2 text-2xl font-bold text-gray-800 ml-28">🎯 Interview Detail</h3>

                <!-- Main Interview Card -->
                <div class="max-w-5xl mx-auto bg-white backdrop-blur-lg rounded-3xl shadow-2xl p-8 mt-6 border border-gray-200/60 hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-all duration-300">
                    
                    <!-- Header -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                        <div>
                            <h2 class="text-3xl font-extrabold text-gray-800 flex items-center gap-3">
                               <span class="bg-gradient-to-r from-purple-700 to-blue-700 bg-clip-text text-transparent drop-shadow-sm">
                                   {{ $interview->job_position ?? 'N/A' }} 
                               </span>
                            </h2>
                            <p class="text-gray-800 mt-2 text-sm">
                                Created on:  
                                <span class="font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($interview->created_at)->format('d M Y') }}
                                </span>
                            </p>
                        </div>
                        
                        <!-- Duration, Questions -->
                        <div class="mt-4 md:mt-0 flex flex-wrap gap-3">
                            <span class="bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full shadow-md text-sm font-semibold border border-blue-200">
                                ⏱ {{ $interview->duration ?? '30' }} min
                            </span>
                            <span class="bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full shadow-md text-sm font-semibold border border-blue-200">
                               ❔ {{ $interview->num_questions ?? 'N/A' }} Questions
                            </span>
                        </div>

                    </div>

                    <!-- Candidate Info (Inline) -->
                    <div class="flex flex-col md:flex-row md:items-center md:gap-8 mb-6">
                        <div class="flex items-center gap-2">
                            <span class="text-indigo-600 text-lg">👨‍💼</span>
                            <p class="text-gray-700 font-semibold">
                                {{ $interview->conversations->name ?? 'N/A' }}
                            </p>
                        </div>
                        
                        <div class="flex items-center gap-2 mt-2 md:mt-0">
                            <span class="text-purple-600 text-lg">📧</span>
                            <p class="text-gray-700 font-semibold">
                                {{ $interview->conversations->email ?? 'N/A' }}
                            </p>
                        </div>
                    </div>


                    <!-- Interview Types -->
                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <span class="font-bold text-lg text-gray-900">Types:</span>
                        
                        @foreach(explode(',', $interview->interview_type ?? '') as $type)
                            @if(!empty(trim($type)))
                                <span  class="bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full shadow-md text-sm font-semibold border border-blue-200">
                                💬 {{ trim($type) }}
                                </span>
                            @endif
                        @endforeach
                    </div>

                    <!-- Job Description -->
                    <div class="mt-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">📝 Job Description</h3>

                        <div class="bg-indigo/60 backdrop-blur-sm border border-purple-200 rounded-xl p-6 shadow-sm hover:shadow-lg transition max-h-28 overflow-y-auto">
                            <p class="text-gray-700 leading-relaxed">
                                {{ $interview->job_description ?? 'No description available.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Questions Section -->
                    <div class="mt-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">📑 Interview Questions</h3>

                        @php
                            $questions = json_decode($interview->question ?? '[]', true);
                        @endphp

                        @if(!empty($questions))
                            <div class="space-y-4 max-h-72 overflow-y-auto pr-2 custom-scroll">
                                @foreach($questions as $q)
                                    @php
                                        $decoded = json_decode($q, true);
                                    @endphp
                                    @if($decoded)
                                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-indigo-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                                            <p class="text-sm text-indigo-600 font-semibold mb-2 flex items-center gap-2">
                                               <span>{{ $decoded['type'] ?? 'General' }}</span>
                                            </p>
                                            <p class="text-gray-800 font-medium leading-relaxed">
                                                {{ $decoded['question'] ?? 'No question text.' }}
                                            </p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic">No questions found for this interview.</p>
                        @endif
                    </div>
                </div>
            </main>
        </div>
        
       <!-- Candidate Report Card (Bottom Stick) -->
<!-- Candidate Report Card (Bottom Stick) -->
<div class="w-full max-w-5xl mx-auto bg-white/80 backdrop-blur-md rounded-2xl shadow-xl p-6 mt-10 mb-10 border border-gray-200 flex flex-col md:flex-row justify-between items-center hover:shadow-2xl transition">
    <div>
        <h3 class="text-2xl font-extrabold flex items-center gap-2 relative w-fit">
            <span>👨‍💼</span>
            <span class="bg-gradient-to-r from-blue-700 to-purple-700 bg-clip-text text-transparent relative">
                {{ $interview->conversations->name ?? 'N/A' }}
                <span class="block h-0.5 bg-gradient-to-r from-blue-700 to-purple-700 rounded-full mt-0.5"></span>
            </span>
        </h3>
        <p class="text-gray-600 text-sm mt-2">
            🗓️ Completed On: <span class="font-medium">{{ $interview->created_at->format('d M Y') }}</span>
        </p>
    </div>

    <form action="{{ route('interview.card.report', $interview->id) }}" method="POST" onsubmit="handleSubmit(this)">
        @csrf
        <button id="reportBtn" type="submit" 
            class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold 
                rounded-full shadow hover:shadow-lg hover:scale-105 transform transition flex items-center gap-2">
            📊 View Report
        </button>
    </form>
</div>


    </div>

    <script>
    function handleSubmit(form) {
        let btn = form.querySelector("#reportBtn");
        btn.disabled = true;
        btn.innerHTML = `
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <span>Generating Report...</span>
        `;
    }
</script>

</x-app-layout>
