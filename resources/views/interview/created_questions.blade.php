<x-app-layout>
    <div class="flex bg-gradient-to-br from-blue-100/80 via-white to-blue-50 pt-8 px-8 pb-24 min-h-[91vh]">
        <div class="flex-1 flex flex-col items-center">
            <main class="w-full max-w-4xl"> <!-- Wider than progress bar -->
                
                <!-- Heading -->
                <h3 class="text-3xl mt-4 text-center font-bold text-gray-800 tracking-tight">
                    ✨ Create Interview
                </h3>
                
                <!-- Progress bar -->
                <div class="flex justify-center mt-6 mb-10">
                    <div class="relative w-full max-w-3xl h-3 bg-gray-200 rounded-full overflow-hidden shadow-inner">
                        <div id="progress-bar" class="absolute top-0 left-0 h-3 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-1000 ease-in-out" style="width: 30%;"></div>
                    </div>
                </div>

                <!-- Questions Card -->
                <form action="{{ route('interview.store') }}" method="POST">
                    @csrf
                    <div class="bg-white/90 backdrop-blur-lg border border-gray-200 p-5 shadow-xl rounded-2xl w-full max-w-4xl mx-auto">
                        <h3 class="font-bold text-gray-800 mb-5 text-lg">Interview Questions</h3>
                        
                        <ul class="space-y-8">
                            @foreach ($questions as $index => $item)
                                <li class="border border-gray-200 rounded-lg p-7 shadow-sm hover:shadow-md transition bg-blue-50 flex justify-between items-start gap-4 w-full text-sm">
                                    
                                    <!-- Left: Question Text -->
                                    <div class="flex-1">
                                        <!-- Question Type -->
                                        <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide mb-1 block">
                                            {{ $item['type'] ?? 'General' }}
                                        </span>

                                        <!-- Question Text (font bigger) -->
                                        <p id="question-text-{{ $index }}"
                                           data-type="{{ $item['type'] ?? 'General' }}"
                                           class="text-gray-800 font-medium leading-snug text-base"> <!-- changed from text-base to text-lg -->
                                            {{ $item['question'] ?? $item }}
                                        </p>

                                        <!-- Editable Textarea -->
                                        <textarea
                                            name="edited_questions[{{ $index }}]"
                                            id="question-input-{{ $index }}"
                                            class="hidden w-full mt-2 p-3 border rounded-lg text-sm bg-gray-50 focus:ring-2 focus:ring-blue-500"
                                            rows="2"
                                        >{{ $item['question'] ?? $item }}</textarea>

                                        <!-- Hidden JSON input -->
                                        <input type="hidden" name="questions[]" id="hidden-question-{{ $index }}" value="{{ json_encode($item) }}">
                                    </div>

                                    <!-- Right: Edit Button (inline) -->
                                    <button type="button"
                                            class="text-sm font-medium text-blue-600 hover:text-blue-800 transition self-start"
                                            onclick="toggleEdit('{{ $index }}', this)">
                                        ✏️ Edit
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Hidden Job Info -->
                    <input type="hidden" name="job_position" value="{{ $jobData['job_position'] }}">
                    <input type="hidden" name="job_description" value="{{ $jobData['job_description'] }}">
                    <input type="hidden" name="duration" value="{{ $jobData['duration'] }}">
                    <input type="hidden" name="interview_type" value="{{ implode(',', $jobData['interview_type']) }}">
                    <input type="hidden" name="num_questions" value="{{ $jobData['num_questions'] }}">

                    <!-- Navigation -->
                    <div class="flex justify-between mt-8">
                        <a href="/interview/create"
                           class="bg-white/80 border border-gray-200 text-gray-700 hover:bg-gray-100 font-semibold py-2 px-6 rounded-xl shadow">
                            ← Back
                        </a>
                        <button type="submit"
                                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-xl shadow-lg transition">
                            Finish & Create →
                        </button>
                    </div>
                </form>

            </main>
        </div>
    </div>

    <!-- Questions JSON -->
    <span id="questions-data" data-questions='@json($questions)' class="hidden"></span>

    <script>
        function toggleEdit(index, btn) {
            const text = document.getElementById(`question-text-${index}`);
            const input = document.getElementById(`question-input-${index}`);
            const hidden = document.getElementById(`hidden-question-${index}`);

            if (input.classList.contains('hidden')) {
                input.classList.remove('hidden');
                text.classList.add('hidden');
                btn.textContent = "💾 Save";
            } else {
                input.classList.add('hidden');
                text.classList.remove('hidden');
                text.textContent = input.value.trim();

                const updated = {
                    type: text.dataset.type ?? 'General',
                    question: input.value.trim()
                };
                hidden.value = JSON.stringify(updated);

                btn.textContent = "✏️ Edit";
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            const bar = document.getElementById('progress-bar');
            setTimeout(() => {
                bar.style.width = '60%';
            }, 400);
        });
    </script>
</x-app-layout>
