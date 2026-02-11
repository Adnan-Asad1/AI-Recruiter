<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Live Interview — {{ $interview->job_position }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-blue-300 min-h-screen flex flex-col text-black" 
data-candidate-name="{{ $userData['name'] }}"
data-candidate-email="{{ $userData['email'] }}"
>

    
    <header class="bg-gradient-to-r from-blue-600/90 to-blue-500/90 shadow-lg px-8 py-2 flex flex-col sm:flex-row justify-between items-start sm:items-center rounded-b-3xl border-b border-white/25">
    <div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white drop-shadow-md tracking-wide">
            Live Interview — <span class="underline decoration-white/50">{{ $interview->job_position }}</span>
        </h1>
        <p class="text-md sm:text-lg text-white/90 mt-2">
            Candidate: <span class="font-semibold">{{ $userData['name'] }}</span> — <span class="italic">{{ $userData['email'] }}</span>
        </p>
    </div>
    <div class="mt-3 sm:mt-0 flex gap-3">
        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium shadow-sm">Live</span>
    </div>
</header>

    <main class="flex-1 flex flex-col lg:flex-row p-6 gap-6">

        <!-- Left: Video/Call Area -->
        <section class="flex-1 bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg p-8 flex flex-col items-center text-center border border-gray-300">
                <!-- Timer -->
            <div class="absolute top-2 right-3 bg-black/80 text-white text-sm px-3 py-1 rounded-full shadow" id="timer1">
                00:00
            </div>

        <!-- Top 2 cards -->
            <div class="flex gap-16 mb-8">
                <!-- Card 1 -->
                <div class="bg-white/90 rounded-lg shadow-lg p-8 w-[420px] h-60 flex flex-col items-center justify-center border border-gray-200">
                    <img  id="ai-photo" src="{{ asset('lego.avif') }}" 
                        class="w-28 h-32 rounded-full  shadow-md object-cover object-center" 
                        alt="Profile 1">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">AI Interviewer</h3>
                    <p class="text-base text-gray-500">Active</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white/90 rounded-lg shadow-lg p-8 w-[420px] h-60 flex flex-col items-center justify-center border border-gray-200">
                    <img id="candidate-photo" src="{{ asset('person.png') }}" 
                        class="w-28 h-32 rounded-full shadow-md object-cover object-center" 
                        alt="Profile 2">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">Candidate</h3>
                    <p class="text-base text-gray-500">{{ $userData['name'] }}</p>
                </div>
        </div>


        <p class="mt-2">Say Hi and start your conversation with AI Interviewer ...</p>

        <!-- Live transcription -->
        <div id="live-transcript" class="mt-6 w-full max-w-2xl bg-white p-4 rounded-lg shadow-inner border border-gray-200 text-left">
            <div id="transcript-partial" class="text-gray-600 italic">No speech yet...</div>
            <div id="transcript-final" class="mt-3 text-black font-medium"></div>
        </div>

        <div class="mt-8 flex gap-8">
            <button id="end-call-btn" class="p-4 bg-red-500 text-black rounded-full shadow-md hover:bg-red-600"> 📞 </button>
            <button id="mic-toggle-btn" class=" p-4 bg-gray-200 rounded-full shadow-md hover:bg-gray-300"></button>
        </div>
    
    </section>

  </main>

    <style>

        @keyframes pulse { 0%,100%{transform:scale(1);opacity:1}50%{transform:scale(1.05);opacity:0.9} }
        .animate-pulse { animation: pulse 1.5s infinite; }

        /* Padding Pulse Animation */
        @keyframes photoPulse {
            0%, 100% {
                padding: 0px;
                box-shadow: 0 0 0px rgba(0, 150, 255, 0.4);
            }
            50% {
                padding: 8px;
                box-shadow: 0 0 20px rgba(0, 150, 255, 0.6);
            }
        }

        .photo-speaking {
            animation: photoPulse 1s infinite ease-in-out;
            border-radius: 9999px; /* keep it circular */
        }

        /* Wave Around Image */
        @keyframes photoWave {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 150, 255, 0.6),
                            0 0 0 10px rgba(0, 150, 255, 0.3),
                            0 0 0 20px rgba(0, 150, 255, 0.1);
            }
            100% {
                box-shadow: 0 0 0 10px rgba(0, 150, 255, 0.3),
                            0 0 0 20px rgba(0, 150, 255, 0.1),
                            0 0 0 30px rgba(0, 150, 255, 0);
            }
        }

        .photo-wave {
            animation: photoWave 1.5s infinite ease-out;
            border-radius: 9999px;
        }

    </style>
    

    <script>
        
        let timerInterval;
        let seconds = 0;
        
    
        window.addEventListener("load", () => {
            const timerEl = document.getElementById("timer1");

            let startTime = localStorage.getItem("interviewStartTime");
            if (startTime) startTime = parseInt(startTime);
            else {
                startTime = Date.now();
                localStorage.setItem("interviewStartTime", startTime);
            }

            function updateTimer() {
                const now = Date.now();
                const secondsElapsed = Math.floor((now - startTime) / 1000);
                timerEl.textContent = formatTime(secondsElapsed);
            }

            updateTimer();
            setInterval(updateTimer, 1000);
        });

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${mins.toString().padStart(2,"0")}:${secs.toString().padStart(2,"0")}`;
        }

        function getCurrentTimer() {
            const startTime = parseInt(localStorage.getItem("interviewStartTime") || Date.now());
            const secondsElapsed = Math.floor((Date.now() - startTime) / 1000);
            return formatTime(secondsElapsed);
        }

        function stopTimer() {
            localStorage.removeItem("interviewStartTime");
        }
                
        // End Call Button
        document.getElementById("end-call-btn").addEventListener("click", () => {
            stopTimer();
            // 🔹 Replace instead of href, so no back history
            window.location.replace("{{ route('end-call') }}");
        });

       // Back Button handle
        window.addEventListener("popstate", () => {
            stopTimer();
        });


        window.addEventListener("beforeunload", (event) => {
            // Only remove timer if the user is closing the tab, not refreshing
            const navType = performance.getEntriesByType("navigation")[0].type;
            if (navType === "back_forward" || navType === "navigate") return; // normal navigation, keep timer
            // if tab is closed, localStorage will stay anyway — optional to remove
        });


        document.addEventListener("DOMContentLoaded", () => {
        // Elements
        const micBtn = document.getElementById("mic-toggle-btn");
        const transcriptPartial = document.getElementById("transcript-partial");
        const transcriptFinal = document.getElementById("transcript-final");
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // State
        let recognition;
        let recognizing = false;      // speech API internal running state
        let micOn = false;            // user-level mic toggle (true = want mic on)
        let processing = false;       // when we're sending transcript / playing TTS
        let suppressAutoRestart = false; // prevent onend auto-restart during processing
        let currentTranscript = "";   // accumulated final transcript
        let lastSpeechTime = Date.now();

        // Silence detection
        const SILENCE_MS = 2000; // 2 second of silence triggers send
        const CHECK_INTERVAL = 250; // how often to check for silence


        // Safe id conversion
        const interviewId = "{{ $interview->id ?? '' }}";

        //data or interviwer
        const candidateName = document.body.dataset.candidateName || '';
        const candidateEmail = document.body.dataset.candidateEmail || '';


        // Feature detect
        if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
            alert("Speech Recognition not supported. Please use Chrome or Edge.");
            return;
        }

        const SpeechRecognitionAPI = window.SpeechRecognition || window.webkitSpeechRecognition;
        recognition = new SpeechRecognitionAPI();
        recognition.continuous = true;
        recognition.interimResults = true;
        recognition.lang = 'en-US'; // change as needed

        // --- Recognition event handlers ---
        recognition.onstart = () => {
            recognizing = true;
            updateMicButtonUI(true);
            console.log("Recognition started");
            
            // Animate candidate photo while speaking
            document.getElementById("candidate-photo").classList.add("photo-speaking", "photo-wave");
        };

        recognition.onerror = (evt) => {
            console.warn("Recognition error", evt);
            // do not flip micOn here — user intent remains
        };

        recognition.onend = () => {
            recognizing = false;
            console.log("Recognition ended");

            // Stop animation when STT ends
            document.getElementById("candidate-photo").classList.remove("photo-speaking", "photo-wave");

            // If we're processing (sending / TTS), do not auto-restart until processing done
            if (micOn && !suppressAutoRestart) {
                // small delay to avoid immediate loop
                setTimeout(() => {
                    try {
                        recognition.start();
                    } catch (e) {
                        console.error("Failed to restart recognition:", e);
                    }
                }, 200);
            } else {
                updateMicButtonUI(false);
            }
        };

        recognition.onresult = (event) => {
            let interim = '';
            // keep previous final text
            let finalText = currentTranscript;

            for (let i = event.resultIndex; i < event.results.length; ++i) {
                const res = event.results[i];
                const t = res[0].transcript;
                if (res.isFinal) {
                    finalText += t + ' ';
                    lastSpeechTime = Date.now();
                } else {
                    interim += t;
                }
            }

            // Update UI
            transcriptPartial.textContent = interim || "…";
            transcriptFinal.textContent = finalText;

            // Update internal transcript and last speech timestamp
            if (finalText.trim() !== "") {
                currentTranscript = finalText;
                lastSpeechTime = Date.now();
            }
        };

        // --- Mic button handling ---
        micBtn.addEventListener("click", () => {
            micOn = !micOn;
            if (micOn) {
                // allow auto restarts now
                suppressAutoRestart = false;
                startRecognitionSafe();
            } else {
                // user turned mic off
                suppressAutoRestart = true;
                stopRecognitionSafe();
            }
            updateMicButtonUI(micOn);
        });

        

        function updateMicButtonUI(isOn) {
            if (isOn) {
                micBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                <path d="M12 14c1.654 0 3-1.346 3-3V5c0-1.654-1.346-3-3-3S9 3.346 9 5v6c0 1.654 1.346 3 3 3z"/>
                <path d="M19 11v-1h-2v1c0 2.757-2.243 5-5 5s-5-2.243-5-5v-1H5v1c0 3.519 2.613 6.432 6 6.92V21H9v2h6v-2h-2v-3.08c3.387-.488 6-3.401 6-6.92z"/>
                </svg>
                `;
                micBtn.classList.remove('bg-gray-300/60');
                micBtn.classList.add('bg-green-400');
                micBtn.classList.remove('hover:bg-gray-300');
            }
            
            else {
            micBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="red" viewBox="0 0 24 24">
            <!-- Mic shape -->
            <path d="M12 14c1.654 0 3-1.346 3-3V5c0-1.654-1.346-3-3-3S9 3.346 9 5v6c0 1.654 1.346 3 3 3z"/>
            <path d="M19 11v-1h-2v1c0 2.757-2.243 5-5 5s-5-2.243-5-5v-1H5v1c0 3.519 2.613 6.432 6 6.92V21H9v2h6v-2h-2v-3.08c3.387-.488 6-3.401 6-6.92z"/>
            
            <!-- Slash line -->
            <line x1="4" y1="4" x2="20" y2="20" stroke="red" stroke-width="2"/>
            </svg>
            `;

                micBtn.classList.remove('bg-green-400');
                micBtn.classList.add('bg-gray-300/60');
            }
        }

        function startRecognitionSafe() {
            if (recognizing) return;
            try {
                recognition.start();
            } catch (e) {
                // sometimes start throws if called too quickly; try after short delay
                console.warn("startRecognitionSafe: start() threw, retrying...", e);
                setTimeout(() => {
                    try { recognition.start(); } catch (err) { console.error(err); }
                }, 300);
            }
        }

        function stopRecognitionSafe() {
            if (!recognizing) return;
            try {
                recognition.stop();
            } catch (e) {
                console.warn("stopRecognitionSafe error:", e);
            }
        }

        // --- Silence checker: sends transcript after SILENCE_MS inactivity ---
        setInterval(() => {
            if (!micOn) return;
            if (processing) return;
            if (!currentTranscript || currentTranscript.trim() === "") return;

            const now = Date.now();
            if (now - lastSpeechTime >= SILENCE_MS) {
                // Detected silence; send transcript
                sendTranscriptToServer(currentTranscript.trim());
            }
        }, CHECK_INTERVAL);

        


        // --- Send transcript to backend ---
        function sendTranscriptToServer(text) {
            if (processing) return;
            processing = true;
            suppressAutoRestart = true; // temporarily prevent onend from auto restarting
            console.log("Sending transcript to server:", text);

            // stop recognition while we send and wait for TTS (so we don't capture TTS)
            stopRecognitionSafe();
                            
            let timeToSend = getCurrentTimer(); // ← use this helper


            fetch('/process-transcript', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ 
                transcript: text,
                interview_id: interviewId,
                Time : timeToSend,
                name: candidateName,
                email: candidateEmail
            })
            })
            .then(async res => {
                if (!res.ok) throw new Error("Server error: " + res.status);
                const data = await res.json();

                // Get question & evaluation from backend
                const Question = data.question || "";

                // Reset current transcript so new speech starts fresh
                currentTranscript = "";
                transcriptFinal.textContent = "";
                transcriptPartial.textContent = "";

                // Play the question
                if (Question.trim()) {
                    await playTTS(Question);
                }

            })
            .catch(err => {
                console.error("Failed to send transcript:", err);
            })
            .finally(() => {
                processing = false;
                suppressAutoRestart = false;
                if (micOn) {
                    setTimeout(() => startRecognitionSafe(), 300);
                }
            });

        }

        // --- TTS playback using SpeechSynthesis; returns a Promise resolved when finished ---
        function playTTS(text) {
            return new Promise((resolve, reject) => {
                if (!text || text.trim() === "") return resolve();

                // create utterance
                const u = new SpeechSynthesisUtterance(text);
                u.lang = 'en-US';
                u.rate = 1;
                u.pitch = 1;

                u.onstart = () => {
                    console.log("TTS started");
                    document.getElementById("ai-photo").classList.add("photo-speaking", "photo-wave");
                };
                u.onerror = (e) => {
                    console.error("TTS error", e);
                    resolve(); // don't block flow
                };
                u.onend = () => {
                    console.log("TTS finished");
                    document.getElementById("ai-photo").classList.remove("photo-speaking", "photo-wave");
                    resolve();
                };

                // speak
                try {
                    window.speechSynthesis.cancel(); // cancel any existing
                    window.speechSynthesis.speak(u);
                } catch (e) {
                    console.error("speechSynthesis.speak error", e);
                    resolve();
                }
            });
        }

        // Optional: keyboard shortcut M to toggle mic
        document.addEventListener('keydown', (ev) => {
            if (ev.key.toLowerCase() === 'm') {
                micBtn.click();
            }
        });

        // Initialize UI (mic initially off)
        updateMicButtonUI(false);
    });

</script>


</body>
</html>