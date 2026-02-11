<x-app-layout>
 <div class="flex bg-gradient-to-br from-blue-100 to-blue-50 pt-6 px-8 min-h-[91vh]">
    <div class="flex-1 flex flex-col">
        
      <!-- User Header -->
      <x-user-header />

      <!-- Main Content -->
      <main class="flex-1 flex flex-col">
        <x-page-heading> 📄 Feed Resume </x-page-heading>

        @if($interviews->count() > 0)
          <div class="overflow-hidden rounded-3xl shadow-2xl bg-white/80 backdrop-blur-lg border border-gray-200">
            <div class="overflow-y-auto max-h-[400px] custom-scrollbar">
              <table class="w-full border-collapse">
                <thead class="bg-gradient-to-r from-indigo-700 to-blue-600 text-white sticky top-0 z-10 shadow-lg">
                  <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                      Job Title
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                      Description
                    </th>
                    <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">
                      Upload Resume PDF
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-800">
                  @foreach($interviews as $job)
                    <tr class="hover:bg-indigo-50 transition duration-300 ease-in-out transform " data-job="{{ $job->job_description }}">
                      <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                          {{ $job->job_position }}
                        </span>
                      </td>
                      <td class="px-6 py-4">
                        <p class="text-gray-600 leading-relaxed text-sm">{{ Str::limit($job->job_description, 120) }}</p>
                      </td>
                      <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                          <!-- File Input -->
                          <label class="cursor-pointer bg-gradient-to-r from-gray-100 to-gray-200 px-4 py-2 rounded-xl border border-gray-300 text-sm text-gray-700 hover:from-indigo-50 hover:to-indigo-100 hover:border-indigo-400 transition-all shadow-sm">
                            <input type="file" accept="image/*,.pdf" class="hidden resume-input" required>
                            📂 Choose File
                          </label>

                          <!-- Compare Button -->
                          <button type="button" class="send-btn hidden px-4 py-2 bg-gradient-to-r from-indigo-600 to-blue-600 text-white text-sm rounded-xl shadow-md hover:shadow-lg hover:from-indigo-700 hover:to-blue-700 transition-all">
                            ⚡ Compare
                          </button>
                        </div>

                        <!-- Status Text -->
                        <div class="status-text text-xs text-gray-500 mt-2"></div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        @else
          <p class="text-center text-gray-600 text-lg mt-8">⚠️ Currently, no job listings are available.</p>
        @endif

      </main>
    </div>
  </div>

  <!-- Hidden Form -->
  <form id="resumeForm" method="POST" action="{{ route('resume-result') }}">
    @csrf
    <input type="hidden" name="resumeText" id="resumeText">
    <input type="hidden" name="jobDescription" id="jobDescription">
  </form>

  <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
  <script>
  pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";


  window.addEventListener("pageshow", function() {
    document.querySelectorAll(".resume-input").forEach(input => {
      input.value = ""; // reset file input
    });
  });

  document.querySelectorAll(".resume-input").forEach(input => {
    input.addEventListener("change", async function(e) {
      const file = e.target.files[0];
      if (!file) return;

      const row = e.target.closest("tr");
      const sendBtn = row.querySelector(".send-btn");
      const statusText = row.querySelector(".status-text");

      sendBtn.classList.add("hidden"); // Hide button during extraction
      statusText.innerText = "⏳ Extracting text...";

      let extractedText = "";

      if (file.type === "application/pdf") {
        const reader = new FileReader();
        reader.onload = async function() {
          try {
            const typedarray = new Uint8Array(this.result);
            const pdf = await pdfjsLib.getDocument({ data: typedarray }).promise;
            for (let i = 1; i <= pdf.numPages; i++) {
              const page = await pdf.getPage(i);
              const text = await page.getTextContent();
              text.items.forEach(item => extractedText += item.str + ' ');
            }
            extractedText = extractedText.trim();
            if (extractedText) {
              sendBtn.dataset.resume = extractedText;
              sendBtn.classList.remove("hidden");
              statusText.innerText = ""; // Clear status
            } else {
              statusText.innerText = "⚠️ No text found in PDF.";
            }
          } catch(err) {
            console.error(err);
            statusText.innerText = "❌ Error reading PDF.";
          }
        };
        reader.readAsArrayBuffer(file);
      } else {
        try {
          const { data: { text } } = await Tesseract.recognize(file, 'eng');
          extractedText = text.trim();
          if (extractedText) {
            sendBtn.dataset.resume = extractedText;
            sendBtn.classList.remove("hidden");
            statusText.innerText = "";
          } else {
            statusText.innerText = "⚠️ No text detected in image.";
          }
        } catch(err) {
          console.error(err);
          statusText.innerText = "❌ Error extracting text from image.";
        }
      }
    });
  });

  
  document.querySelectorAll(".send-btn").forEach(btn => {
    btn.addEventListener("click", function() {
      const row = this.closest("tr");
      const jobDescription = row.dataset.job;
      const resumeText = this.dataset.resume;

      if (!resumeText) {
        alert("⚠️ Resume not extracted!");
        return;
      }

      // ⏳ Disable button + show loading text
      this.disabled = true;
      this.innerText = "Generating Report...";

      const form = document.getElementById("resumeForm");
      form.querySelector("#resumeText").value = resumeText;
      form.querySelector("#jobDescription").value = jobDescription;
      form.submit();
    });
  });
</script>

</x-app-layout>
