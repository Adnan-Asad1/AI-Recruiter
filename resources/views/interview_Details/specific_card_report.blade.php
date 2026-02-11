<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-indigo-100 via-white to-purple-100 py-12">
        <div class="max-w-5xl mx-auto px-6 space-y-6">

            <!-- Page Title -->
            <div class="text-center mb-6">
                <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-700 via-purple-600 to-pink-600 drop-shadow-lg">
                    Interview Feedback Report
                </h1>
                <p class="mt-3 text-lg text-gray-600">Detailed evaluation of performance, strengths & improvements</p>
            </div>

            <!-- Report Sections -->
            @foreach($sections as $index => $sec)

                <!-- Print Button for this section -->
                <div class="text-right mb-2">
                    <button onclick="printCard('card-{{ $index }}')" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Print Report
                    </button>
                </div>

                <div id="card-{{ $index }}" class="relative bg-white rounded-3xl shadow-2xl border border-gray-200 overflow-hidden hover:shadow-purple-300/50 transition-all duration-300 mb-8">

                    <!-- Gradient Header -->
                    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 px-6 py-4 rounded-t-3xl">
                        <h2 class="text-2xl font-bold text-white tracking-wide">
                            {!! str_replace('*', '', $sec['heading']) !!}
                        </h2>
                    </div>

                    <!-- Body -->
                    <div class="p-8 space-y-5 leading-relaxed text-gray-800">
                        @php
                            $lines = preg_split('/\r\n|\r|\n/', $sec['body']);
                            $inCandidateBlock = false;
                        @endphp

                        @foreach($lines as $line)
                            @php $lineTrim = trim($line); @endphp

                            {{-- Detect Candidate Information Block --}}
                            @if(Str::contains($lineTrim, 'Candidate Information'))
                                <h3 class="text-xl font-semibold text-indigo-700 border-l-4 border-indigo-500 pl-3 mt-6">
                                    Candidate Information
                                </h3>
                                @php $inCandidateBlock = true; @endphp
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    @continue
                                @endphp
                            @endif

                            {{-- Candidate Info fields (rendered as cards) --}}
                            @if($inCandidateBlock && Str::startsWith($lineTrim, '-'))
                                @php
                                    $parts = explode(':', ltrim($lineTrim, '- '), 2);
                                    $label = trim($parts[0] ?? '');
                                    $value = trim($parts[1] ?? '');
                                @endphp
                               <div class="p-2 bg-indigo-50 rounded-lg shadow-sm border border-indigo-200">
    <span class="text-xs text-gray-800">{{ $label }}</span>
    <div class="text-base font-semibold text-gray-800">{{ $value }}</div>
</div>

                                @continue
                            @endif

                            {{-- End of Candidate Info block --}}
                            @if($inCandidateBlock && $lineTrim === '')
                                </div> {{-- close grid --}}
                                @php $inCandidateBlock = false; @endphp
                                @continue
                            @endif

                            {{-- Subheadings --}}
                            @if(Str::startsWith($lineTrim, '*') && Str::endsWith($lineTrim, '*'))
                                <h3 class="text-xl font-semibold text-indigo-700 border-l-4 border-indigo-500 pl-3 mt-6">
                                    {{ trim($lineTrim, '*') }}
                                </h3>

                            {{-- Score bars --}}
                            @elseif(preg_match('/\d+\/10/', $lineTrim))
                                @php
                                    [$category, $scorePart] = explode(':', $lineTrim, 2);
                                    $scorePart = trim($scorePart);
                                    preg_match('/(\d+(\.\d+)?)\/10/', $scorePart, $matches);
                                    $score = floatval($matches[1] ?? 0);
                                    $percentage = ($score / 10) * 100;
                                    $width = $percentage . '%';
                                @endphp
                                <div class="mt-2">
                                    <div class="flex justify-between mb-1">
                                        <span class="text-gray-700 font-medium">{{ trim($category) }}</span>
                                        <span class="text-gray-600 font-medium">{{ $score }}/10</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-4 shadow-inner">
                                        @php
                                            echo '<div class="h-4 rounded-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 transition-all duration-500" style="width:' . $width . ';"></div>';
                                        @endphp
                                    </div>
                                </div>

                            {{-- Bullets --}}
                            @elseif(Str::startsWith($lineTrim, '-'))
                                <ul class="list-none pl-2 space-y-2">
                                    <li class="flex items-start bg-indigo-50 px-3 py-2 rounded-xl shadow-sm hover:bg-indigo-100 transition">
                                        <span class="text-indigo-600 mr-3 mt-1">🔹</span>
                                        <span class="text-gray-700">{{ ltrim($lineTrim, '- ') }}</span>
                                    </li>
                                </ul>

                            {{-- Normal text --}}
                            @elseif(!empty($lineTrim))
                                <p class="text-gray-700 text-lg leading-relaxed">
                                    {{ $lineTrim }}
                                </p>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <!-- JavaScript to print a specific card -->
    <script>
        function printCard(cardId) {
            var content = document.getElementById(cardId).innerHTML;
            var printWindow = window.open('', '', 'height=800,width=800');
            printWindow.document.write('<html><head><title>Print Section</title>');
            printWindow.document.write('<style>body{font-family:sans-serif; margin:20px;} .bg-gradient-to-r{background:none !important;} .rounded-3xl{border-radius:1.5rem;} .shadow-2xl{box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);} .rounded-full{border-radius:9999px;} .border-l-4{border-left-width:4px;}</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(content);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</x-app-layout>
