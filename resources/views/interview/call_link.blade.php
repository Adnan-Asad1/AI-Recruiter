<x-app-layout>
    <!-- ✅ Background -->
    <div class="flex bg-gradient-to-br from-blue-100 via-blue-50 to-indigo-100 pt-8 px-8 pb-20 min-h-[91vh] relative">
        
        <!-- Decorative Blobs -->
        <div class="absolute top-20 left-10 w-64 h-64 bg-blue-300/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-20 w-72 h-72 bg-indigo-300/30 rounded-full blur-3xl"></div>

        <div class="flex-1 flex flex-col items-center relative z-10">
            <main class="w-full max-w-3xl">
                <!-- ✅ Heading -->
                <h3 class="text-3xl mt-2 text-center font-bold text-gray-800 drop-shadow-sm">
                    ✨ Your AI Interview is Ready!
                </h3>

                <!-- ✅ Progress Bar -->
                <div class="flex justify-center mt-6 mb-10">
                    <div class="relative w-full h-3 bg-gray-200 rounded-full overflow-hidden shadow-inner max-w-2xl">
                        <div id="progress-bar" 
                             class="absolute top-0 left-0 h-3 bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-1000 ease-in-out rounded-full shadow"
                             style="width: 60%;"></div>
                    </div>
                </div>

                <!-- ✅ Success Icon -->
                <div class="text-center mt-4">
                    <div class="flex justify-center mb-4">
                        <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 text-white rounded-full flex items-center justify-center shadow-lg animate-bounce">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                 class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Interview Link Generated 🎉</h2>
                    <p class="text-gray-600 mt-1">Share it with your candidates to start the interview process</p>
                </div>

                <!-- ✅ Sexy Interview Card -->
                <div class="bg-white/80 backdrop-blur-xl shadow-2xl rounded-2xl mt-12 mx-auto p-8 border border-gray-200 hover:shadow-blue-200/70 transition-all duration-300">
                    
                    <!-- Card Header -->
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Interview Link
                        </h4>
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full shadow-sm animate-pulse">
                            Active
                        </span>
                    </div>

                    @php
                        $Id = $interviewer['id'] ?? 'undefined';
                        $interviewLink = url('/join-call/' . $Id);
                        $duration = $interviewer['duration'] ?? 'N/A';
                        $questions = $interviewer['num_questions'] ?? 'N/A';
                    @endphp

                    <!-- Link + Copy -->
                    <div class="flex items-center gap-3 mb-10">
                        <input
                            id="interview-link"
                            type="text"
                            value="{{ $interviewLink }}"
                            readonly
                            class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 font-medium cursor-not-allowed shadow-inner"
                        />
                        <button onclick="copyLink()" 
                                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-5 py-2 rounded-lg shadow-md transition transform hover:scale-105 text-sm">
                            📋 Copy
                        </button>
                    </div>

                    <!-- Toast -->
                    <div id="copy-toast" class="hidden fixed top-6 right-6 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm animate-fade-in-out">
                        ✅ Link copied to clipboard!
                    </div>

                    <!-- Duration & Questions -->
                    <div class="flex flex-col sm:flex-row sm:gap-8 gap-4 text-gray-700 text-sm mb-10">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 border border-blue-200 shadow-sm w-fit">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-medium text-gray-800"><strong>Duration:</strong> {{ $duration }} mins</span>
                        </div>

                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-50 border border-green-200 shadow-sm w-fit">
                            <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m2 4H7m5-12v16M4 6h16"/>
                            </svg>
                            <span class="font-medium text-gray-800"><strong>Questions:</strong> {{ $questions }}</span>
                        </div>
                    </div>

                    <!-- Divider -->
                    <hr class="my-6 border-gray-300">

                    <!-- Share Section -->
                    <div>
                        <h5 class="text-md font-semibold text-gray-800 mb-6 flex items-center gap-2">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8H3v9a2 2 0 002 2z"/>
                            </svg>
                            Share with Candidate
                        </h5>

                        <button onclick="openShareModal()" 
                                class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-5 py-2 rounded-lg shadow-md transition transform hover:scale-105 text-sm">
                            ✉️ Share via Email
                        </button>
                    </div>
                </div>

                <!-- ✅ Navigation Buttons -->
                <div class="mt-14 flex justify-between">
                    <a href="{{ route('dashboard') }}" 
                       class="px-6 py-2 bg-white text-black rounded-lg transition hover:bg-gray-100 border border-black/20 shadow-sm">
                        ← Dashboard
                    </a>
                    <a href="{{ route('interview.create') }}" 
                       class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 shadow-md transition transform hover:scale-105">
                        + Create New
                    </a>
                </div>
            </main>
        </div>
    </div>

    <!-- ✅ Sexy Share Modal -->
    <div id="share-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-md flex items-center justify-center z-50">
        <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-2xl p-7 w-96 relative border border-gray-200">

            <!-- Close Button -->
            <button onclick="closeShareModal()" 
                    class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-2xl font-bold transition">&times;</button>

            <!-- ✅ Heading with Sexy Icon -->
            <div class="flex flex-col items-center text-center mb-6">
                <div class="w-14 h-14 flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-full shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18V8H3v8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mt-3">Share Interview via Email</h3>
                <p class="text-sm text-gray-500 mt-1">Send a secure interview link directly to the candidate</p>
            </div>

            <!-- ✅ Input Field -->
            <div class="mb-4">
                <input 
                    id="share-email"
                    type="email"
                    placeholder="Enter candidate's email address"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-gray-700 placeholder-gray-400"
                />
            </div>

            <!-- ✅ Sexy Send Button -->
            <button onclick="sendEmail()" 
                    class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white py-3 rounded-xl shadow-lg transition transform hover:scale-[1.02]">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4l16 8-16 8V4z"/>
                </svg>
                <span class="font-medium">Send Invitation</span>
            </button>

            <!-- Success Message -->
            <div id="success-msg" class="hidden mt-4 flex items-center gap-2 justify-center bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded-lg shadow-md text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Link and details sent successfully!</span>
            </div>

            <!-- Error Message -->
            <div id="error-msg" class="hidden mt-4 flex items-center gap-2 justify-center bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded-lg shadow-md text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span>Please enter a valid email address!</span>
            </div>
        </div>
    </div>


    <script>
        function copyLink() {
            const input = document.getElementById('interview-link');
            navigator.clipboard.writeText(input.value).then(() => {
                const toast = document.getElementById('copy-toast');
                toast.classList.remove('hidden');
                toast.classList.add('flex');
                setTimeout(() => {
                    toast.classList.add('hidden');
                    toast.classList.remove('flex');
                }, 2000);
            });
        }

        function openShareModal() {
            document.getElementById("share-modal").classList.remove("hidden");
        }

        function closeShareModal() {
            document.getElementById("share-modal").classList.add("hidden");
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(email).toLowerCase());
        }

        function sendEmail() {
        const emailInput = document.getElementById("share-email");
        const email = emailInput.value.trim();
        const successMsg = document.getElementById("success-msg");
        const errorMsg = document.getElementById("error-msg");

        // Interview link input se nikal lo
        const interviewLink = document.getElementById("interview-link").value;

        successMsg.classList.add("hidden");
        errorMsg.classList.add("hidden");

        if (validateEmail(email)) {
            // ✅ Seedha frontend success show karo
            successMsg.classList.remove("hidden");

            // ✅ Modal close aur input clear kar do
            setTimeout(() => {
                closeShareModal();
                emailInput.value = "";
                successMsg.classList.add("hidden");
            }, 2000);

            // ✅ Background me mail send karo (optional, response ka wait mat karo)
            fetch("/Send-Email", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email: email, link: interviewLink })
            }).catch(error => console.error("Mail sending error:", error));

        } else {
            errorMsg.classList.remove("hidden");
        }
    }


        window.addEventListener('DOMContentLoaded', () => {
            const bar = document.getElementById('progress-bar');
            setTimeout(() => {
                bar.style.width = '100%';
            }, 300);
        });


    </script>


   <style>
        @keyframes fade-in-out {
            0% { opacity: 0; transform: translateY(-10px); }
            10% { opacity: 1; transform: translateY(0); }
            90% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-10px); }
        }
        .animate-fade-in-out { animation: fade-in-out 2s ease-in-out forwards; }
    </style>

</x-app-layout>



