<x-app-layout>

  <div class="flex bg-gradient-to-br from-blue-100 to-blue-50 pt-6 px-8 pb-18 min-h-[91vh] h-[91vh] overflow-hidden">
    <div class="flex-1 flex flex-col">
        
      <x-user-header />

      <main class="flex-1 flex flex-col overflow-hidden">
        <x-page-heading> Interview List with Candidate Feedback </x-page-heading>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6 mt-6 overflow-y-auto pr-4" style="max-height: calc(60vh - 62px);">

          @forelse($interviews as $interview)
            <div class="max-w-sm bg-white rounded-xl p-4 border shadow-xl transition-all duration-300 hover:shadow-2xl hover:scale-[1.02]  ">
              
              <!-- Job + Candidate -->
              <div class="flex justify-between mb-4">
              <div>
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-8 h-8 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.6"/> 
                        <circle cx="12" cy="10" r="3" fill="currentColor"/>
                        <path d="M6 18c1.5-3 10.5-3 12 0" stroke="currentColor" stroke-width="1.6" fill="none"/>
                    </svg>
                    {{ $interview->job_position }}
                </h2>
              </div>

                <div class="flex text-sm text-gray-500">
                  {{ \Carbon\Carbon::parse($interview->created_at)->format('d M Y') }}
                </div>
              </div>

              <!-- Name + Duration -->
              <div class=" flex justify-between mb-2">

                @if(isset($interview->conversations))
                <p class="text-gray-700 font-semibold">Candidate:
                   <span class="text-sm text-gray-500">{{ $interview->conversations->name }}</span>
                </p>
                @endif

              </div>

              <!-- email + question -->
              <div class=" flex justify-between mt-4  mb-4">
                  <p class="text-gray-700">🕒 {{ $interview->duration ?? '30' }} minutes</p>
              </div>


              <!-- View Details Button -->
              <div class="pt-2">
                  <a href="{{ route('interview.specific.card', $interview->id) }}" 
                    class="w-full flex items-center justify-center gap-2 bg-gray-200/60 text-gray-800 px-6 py-2 rounded-lg shadow hover:bg-gray-300 text-sm font-medium transition">
                      View Details ➜
                  </a>
              </div>


          </div>
            
            @empty
            <div class="col-span-full flex flex-col items-center justify-center py-12 text-center bg-white rounded-xl shadow-md border">
                <div class="text-5xl mb-3">📭</div>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">No Interviews Found</h3>
                <p class="text-gray-500 mb-5">It looks like you haven't created any interviews yet.</p>
                <a href=" {{ route('interview.create') }}" 
                class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                ➕ Create Your First Interview
                </a>
            </div>
            @endforelse

        </div>
      </main>
    </div>
  </div>

  
</x-app-layout>
