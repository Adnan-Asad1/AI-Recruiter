<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Interview Already Completed</title>
  <meta name="robots" content="noindex"/>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-sky-100 via-sky-50 to-white flex items-center justify-center p-6">
  
  <article class="w-full max-w-5xl bg-white shadow-2xl rounded-2xl overflow-hidden border border-slate-200">
    
    <!-- Header -->
    <header class="flex items-center gap-4 px-6 py-5 bg-gradient-to-r from-emerald-50 to-sky-50 border-b">
      <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-emerald-100 text-emerald-700 shadow-inner">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
      </div>
      <div>
        <h1 class="text-lg md:text-xl font-extrabold text-slate-800">Interview Already Completed</h1>
        <p class="text-sm text-slate-500">You’ve already submitted this interview.</p>
      </div>
    </header>

    <!-- Content -->
    <section class="grid md:grid-cols-[1.4fr,0.9fr] gap-6 p-6">
      
      <!-- Left -->
      <div>
        <p class="text-slate-600 text-base leading-relaxed mb-5">
          Our system shows this interview has already been completed.  
          If this looks incorrect, please reach out to support.
        </p>

        <!-- Details -->
        <div class="bg-slate-50 border rounded-xl p-6 space-y-4 shadow-sm">
          <h2 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Interview Details</h2>
          <div class="flex gap-4">
            <div class="w-28 text-slate-500">Position</div>
            <div class="font-semibold">{{ $interview->job_position ?? '—' }}</div>
          </div>
          <div class="flex gap-4">
            <div class="w-28 text-slate-500">Candidate</div>
            <div class="font-semibold">
              {{ $interview->conversations->name ?? '—' }}
              <span class="text-slate-400"> · </span>
              <span class="font-mono text-slate-400">{{  $interview->conversations->email ?? '—' }}</span>
            </div>
          </div>
          <div class="flex gap-4">
        <div class="w-28 text-slate-500">Duration</div>
        <div class="font-semibold">
            @php
                $conversations = json_decode($interview->conversations->conversation ?? '[]', true);
                $lastTime = count($conversations) ? end($conversations)['time'] : '—';
            @endphp

            {{ $lastTime }} minutes
        </div>
         </div>

          <div class="flex gap-4">
            <div class="w-28 text-slate-500">Total Questions</div>
            <div class="font-semibold">{{ $interview->num_questions ?? '—' }}</div>
          </div>
        </div>

        <!-- Note -->
        <div class="mt-6 flex gap-3 bg-amber-50 border border-amber-300 text-amber-800 rounded-xl p-4 text-sm">
          <svg class="w-5 h-5 flex-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 3a9 9 0 100 18 9 9 0 000-18z"/>
          </svg>
          <p>
            You can view your summary (if available) or wait for the results.  
            For corrections (wrong email etc.), please contact support.
          </p>
        </div>

        <!-- Actions -->
        <div class="flex flex-wrap gap-3 mt-7">
          

          @isset($interview->id)
          <a href="#" class="inline-flex items-center gap-2 px-4 py-2 font-semibold rounded-lg bg-slate-900 text-slate-100 shadow hover:bg-slate-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.567-3 3.5S10.343 15 12 15s3-1.567 3-3.5S13.657 8 12 8z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.4 15A7.963 7.963 0 0120 12a8 8 0 10-8 8 7.963 7.963 0 003-.6"/>
            </svg>
            View Summary
          </a>
          @endisset

          <a href="#" 
             class="inline-flex items-center gap-2 px-4 py-2 font-semibold rounded-lg border border-slate-200 text-blue-600 hover:bg-slate-50 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 12H8m8 0l4-4m-4 4l4 4M4 6h16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z"/>
            </svg>
            Contact Support
          </a>
        </div>
      </div>

      <!-- Right Panel -->
      <aside class="bg-slate-50 border rounded-xl p-6 shadow-sm">
        <h2 class="font-bold text-slate-800 text-sm mb-4 uppercase tracking-wide">Next Steps</h2>
        <ol class="list-decimal list-inside text-slate-600 space-y-2 text-sm leading-relaxed">
          <li>Review your interview summary and outcomes.</li>
          <li>Think this is an error? Contact support with details.</li>
        </ol>
        <hr class="my-5 border-slate-200"/>
        <p class="text-xs text-slate-500">
          Want to attempt again with another email? Please request permission from HR first.
        </p>
      </aside>
    </section>

    <!-- Footer -->
    <footer class="flex items-center justify-between px-6 py-4 border-t text-xs text-slate-500 bg-gradient-to-r from-slate-50 to-slate-100">
      <div>Ref: <span class="font-mono font-medium">INT-{{ $interview->id ?? '—' }}</span></div>
      <div>&copy; {{ date('Y') }} Smart Hire — All rights reserved.</div>
    </footer>
  </article>
</body>
</html>
