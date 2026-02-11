<x-app-layout>
  <div class="flex bg-gradient-to-br from-blue-100 to-blue-50 pt-6 px-8 pb-18 min-h-[91vh]" id="billing-app">
    <div class="flex-1 flex flex-col">
      <x-user-header />

      <main class="flex-1 flex flex-col">
        <x-page-heading>Billing</x-page-heading>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

          <!-- Credits Card -->
          <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 flex flex-col justify-between h-80 transition duration-200">
            <div>
              <h3 class="text-lg font-semibold text-gray-800 mb-2">Your Credits</h3>
              <p class="text-sm text-gray-500">Current usage and remaining credits</p>
              <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-center">
                <div class="flex-shrink-0">
                  <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-600 text-xl">–</span>
                </div>
                <div class="ml-3">
                  <p class="text-blue-600 font-semibold text-lg">{{ $credits }} interviews left</p>
                </div>
              </div>
            </div>
            <button id="add-credits-btn" class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow">
                + Add More Credits
            </button>

            <!-- Info message -->
            <p id="add-credits-msg" class="text-sm text-gray-700 mt-2 hidden">
                Please select a plan from the available options to purchase credits.
            </p>
          </div>

          <!-- Purchase Credits Plans Wrapper -->
          <div class="md:col-span-3">
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
              <h2 class="text-xl font-semibold text-gray-800 mb-4">Purchase Credits</h2>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                @php
                    $plans = [
                        ['name'=>'Basic','price'=>7,'interviews'=>20,'details'=>['Basic interview templates','Email support']],
                        ['name'=>'Standard','price'=>15,'interviews'=>50,'details'=>['All interview templates','Priority support','Basic analytics']],
                        ['name'=>'Pro','price'=>25,'interviews'=>120,'details'=>['All interview templates','24/7 support','Advanced analytics']]
                    ];
                @endphp

                @foreach($plans as $plan)
                  <div class="bg-white rounded-xl p-6 flex flex-col h-80 border border-gray-400 transition duration-200 hover:bg-blue-50">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $plan['name'] }}</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">${{ $plan['price'] }}</p>
                    <p class="text-sm text-gray-500 mb-4">
                        <span class="font-semibold text-gray-500">{{ $plan['interviews'] }}</span> interviews
                    </p>
                    <ul class="space-y-2 text-sm text-gray-900 flex-1">
                      @foreach($plan['details'] as $item)
                        <li>• {{ $item }}</li>
                      @endforeach
                    </ul>
                    <button data-plan='@json($plan)' class="purchase-btn mt-6 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow">
                      Purchase Credits
                    </button>
                  </div>
                @endforeach

              </div>
            </div>
          </div>

        </div>
      </main>
    </div>

    <!-- Modal -->
    <div id="modal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
      <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative flex flex-col">
        <button id="modal-close" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900">✕</button>
        <h3 id="modal-name" class="text-xl font-semibold text-gray-800"></h3>
        <p class="text-2xl font-bold text-gray-900 mt-2">$<span id="modal-price"></span></p>
        <p class="text-sm text-gray-500 mt-1">
          <span id="modal-interviews" class="font-bold text-gray-900"></span> interviews
        </p>
        <ul id="modal-details" class="space-y-2 text-sm text-gray-900 mt-4"></ul>

        <form action="{{ route('charge') }}" method="POST" id="Stripe-Form" class="flex flex-col">
          @csrf
          <input type="hidden" name="stripeToken" id="stripe_token">
          <input type="hidden" name="price" id="modal-price-input">
          <input type="hidden" name="interviews" id="modal-interviews-input">
          <div class="mt-8 mb-4">Enter your card details</div>
          <div class="form-controll" id="card-element" style="height:50px;"></div>
          <button type="button" id="pay-btn" class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow">
            Pay Now
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Notyf -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

  <script src="https://js.stripe.com/v3/"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function(){

      const notyf = new Notyf({ duration:4000, position:{x:'right', y:'top'} });

      // Stripe setup
      const stripe = Stripe("{{ env('STRIPE_PUBLIC_KEY') }}");
      const elements = stripe.elements();
      const cardElement = elements.create('card');
      cardElement.mount('#card-element');

      // Modal
      const modal = document.getElementById("modal");
      const modalName = document.getElementById("modal-name");
      const modalPrice = document.getElementById("modal-price");
      const modalInterviews = document.getElementById("modal-interviews");
      const modalDetails = document.getElementById("modal-details");
      const modalClose = document.getElementById("modal-close");

      let selectedPlan = null;

      document.querySelectorAll(".purchase-btn").forEach(btn=>{
        btn.addEventListener("click", ()=>{
          selectedPlan = JSON.parse(btn.getAttribute("data-plan"));
          modalName.textContent = selectedPlan.name;
          modalPrice.textContent = selectedPlan.price;
          modalInterviews.textContent = selectedPlan.interviews;
          document.getElementById("modal-price-input").value = selectedPlan.price;
          document.getElementById("modal-interviews-input").value = selectedPlan.interviews;

          modalDetails.innerHTML = "";
          selectedPlan.details.forEach(item=>{
            const li = document.createElement("li");
            li.textContent = "• " + item;
            modalDetails.appendChild(li);
          });

          modal.classList.remove("hidden");
          document.body.style.overflow = "hidden";
        });
      });

      modalClose.addEventListener("click", ()=>{
        modal.classList.add("hidden");
        cardElement.clear();
        document.body.style.overflow = "auto";
      });

      // Pay Now button
      document.getElementById("pay-btn").addEventListener("click", function(){
        const payBtn = this;
        const originalText = payBtn.textContent;
        payBtn.disabled = true;
        payBtn.textContent = "Processing...";

        stripe.createToken(cardElement).then(function(result){
          if(result.error){
            payBtn.disabled = false;
            payBtn.textContent = originalText;
            notyf.error(result.error.message);
          } else {
            document.getElementById('stripe_token').value = result.token.id;
            document.getElementById('Stripe-Form').submit();
          }
        });
      });

      // Flash messages from backend
      @if(session('success'))
          notyf.success("{{ session('success') }}");
          modal.classList.add("hidden");
          cardElement.clear();
          document.body.style.overflow = "auto";
      @endif

      @if(session('error'))
          notyf.error("{{ session('error') }}");
      @endif

      // Show message when "Add More Credits" is clicked
      const addCreditsBtn = document.getElementById("add-credits-btn");
      const addCreditsMsg = document.getElementById("add-credits-msg");

      addCreditsBtn.addEventListener("click", () => {
          addCreditsMsg.classList.remove("hidden");

          setTimeout(() => {
              addCreditsMsg.classList.add("hidden");
          }, 5000);
      });

    });
  </script>
</x-app-layout>
