<x-app-layout>

  <div class="flex bg-gradient-to-br from-blue-100 to-blue-50 pt-6 px-8 pb-18 min-h-[91vh] h-[91vh] overflow-hidden">
    <div class="flex-1 flex flex-col">
        
      <x-user-header />

      <main class="flex-1 flex flex-col overflow-hidden">
        <x-page-heading> All Created Interviews </x-page-heading>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6 mt-6 overflow-y-auto pr-4" style="max-height: calc(60vh - 62px);">

          @forelse($interviews as $interview)
              @php $currentInterviewLink = url('/join-call/'.$interview->id); @endphp
              <div class="max-w-sm bg-white rounded-xl p-4 border shadow-xl transition-all duration-300 hover:shadow-2xl hover:scale-[1.02]">
                  <div class="flex justify-between mb-4">
                      <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                          <svg class="w-8 h-8 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                              <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.6"/> 
                              <circle cx="12" cy="10" r="3" fill="currentColor"/>
                              <path d="M6 18c1.5-3 10.5-3 12 0" stroke="currentColor" stroke-width="1.6" fill="none"/>
                          </svg>
                          {{ $interview->job_position }}
                      </h2>
                      <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($interview->created_at)->format('d M Y') }}</span>
                  </div>

                  <p class="text-gray-700 mb-2">🕒 {{ $interview->duration ?? '30' }} minutes</p>
                  <p class="text-gray-700 font-semibold mb-4">Number of Questions: {{ $interview->num_questions ?? 'N/A' }}</p>

                  <div class="flex justify-around gap-4 pt-2">
                      <button onclick="copyLink('{{ $currentInterviewLink }}')" class="flex-1 flex items-center justify-center gap-2 bg-blue-600 text-white px-1 py-2 rounded-lg shadow hover:bg-blue-700 text-sm font-medium transition">
                          📋 Copy Link
                      </button>
                      <button onclick="openShareModal('{{ $currentInterviewLink }}')" class="flex-1 flex items-center justify-center gap-2 bg-gray-100 border border-gray-300 text-blue-600 px-1 py-2 rounded-lg shadow hover:bg-indigo-100 hover:text-blue text-sm font-medium transition">
                          🚀 Share
                      </button>
                  </div>
              </div>
            @empty
              <div class="col-span-full flex flex-col items-center justify-center py-6 text-center bg-white rounded-xl shadow-md border">
                  <div class="text-5xl mb-3">📭</div>
                  <h3 class="text-lg font-semibold text-gray-700 mb-1">No Interviews Found</h3>
                  <p class="text-gray-500 mb-5">You haven't created any interviews yet.</p>
                  <a href="{{ route('interview.create') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                      ➕ Create Your First Interview
                  </a>
              </div>
            @endforelse
          
        </div>
      </main>
    </div>
  </div>


<!-- Share Modal -->
<div id="share-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-md flex items-center justify-center z-50">
    <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-2xl p-7 w-96 relative border border-gray-200">
        <button onclick="closeShareModal()" class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-2xl font-bold transition">&times;</button>
        <div class="flex flex-col items-center text-center mb-6">
            <div class="w-14 h-14 flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-full shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18V8H3v8z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mt-3">Share Interview via Email</h3>
            <p class="text-sm text-gray-500 mt-1">Send a secure interview link directly to the candidate</p>
        </div>

        <input id="share-email" type="email" placeholder="Enter candidate's email" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-gray-700 placeholder-gray-400 mb-4">

        <button onclick="sendEmail()" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white py-3 rounded-xl shadow-lg transition transform hover:scale-[1.02]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4l16 8-16 8V4z"/>
            </svg>
            <span class="font-medium">Send Invitation</span>
        </button>

        <div id="success-msg" class="hidden mt-4 flex items-center gap-2 justify-center bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded-lg shadow-md text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Link and details sent successfully!</span>
        </div>

        <div id="error-msg" class="hidden mt-4 flex items-center gap-2 justify-center bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded-lg shadow-md text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <span>Please enter a valid email address!</span>
        </div>
    </div>
</div>

<!-- Notyf -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script>
const notyf = new Notyf({ duration:2000, position:{x:'right',y:'top'} });
let currentInterviewLink = "";

function copyLink(link){
    navigator.clipboard.writeText(link)
        .then(()=>{ notyf.success("✅ Link copied!"); })
        .catch(()=>{ notyf.error("❌ Failed!"); });
}

function openShareModal(link){
    currentInterviewLink = link;
    document.getElementById("share-modal").classList.remove("hidden");
}

function closeShareModal(){
    document.getElementById("share-modal").classList.add("hidden");
}

function validateEmail(email){
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function sendEmail(){
    const emailInput = document.getElementById("share-email");
    const email = emailInput.value.trim();
    const successMsg = document.getElementById("success-msg");
    const errorMsg = document.getElementById("error-msg");

    successMsg.classList.add("hidden");
    errorMsg.classList.add("hidden");

    if(validateEmail(email)){
        successMsg.classList.remove("hidden");
        setTimeout(()=>{
            closeShareModal();
            emailInput.value="";
            successMsg.classList.add("hidden");
        },2000);

        fetch("/Send-Email",{
            method:"POST",
            headers:{
                "Content-Type":"application/json",
                "Accept":"application/json",
                "X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').content
            },
            body:JSON.stringify({email:email, link:currentInterviewLink})
        }).catch(e=>console.error(e));

    } else {
        errorMsg.classList.remove("hidden");
    }
}
</script>


</x-app-layout>
