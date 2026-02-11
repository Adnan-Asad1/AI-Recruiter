<x-app-layout>
    <div class="min-h-screen bg-blue-100/80 flex items-center justify-center px-4 py-10">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl p-8">
            <h1 class="text-4xl font-bold text-center text-indigo-700 mb-8">
                📊 Resume Analysis Report
            </h1>

            @if(!empty($result))
                <div class="space-y-6">

                    <!-- Score Card -->
                    <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded-lg shadow-sm">
                        <h2 class="text-xl font-semibold text-indigo-800">⭐ Interview Score</h2>
                        <p class="text-3xl font-bold text-indigo-600 mt-2">
                            {{ $result['score'] ?? 'N/A' }}/100
                        </p>
                    </div>

                    <!-- Key Skills -->
                    <div class="bg-white border rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">✅ Key Skills</h2>
                        <ul class="list-disc list-inside text-gray-700 grid grid-cols-2 gap-1">
                            @foreach($result['keySkills'] ?? [] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Strong Areas -->
                    <div class="bg-green-50 border border-green-300 rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-green-800 mb-2">🟢 Strong Areas</h2>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            @foreach($result['strongAreas'] ?? [] as $area)
                                <li>{{ $area }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Weak Areas -->
                    <div class="bg-red-50 border border-red-300 rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-red-800 mb-2">🔴 Weak/Missing Areas</h2>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            @foreach($result['weakAreas'] ?? [] as $weak)
                                <li>{{ $weak }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Improvement Tips -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg shadow-sm">
                        <h2 class="text-xl font-semibold text-yellow-700 mb-2">💡 Improvement Tip</h2>
                        <p class="text-gray-800">
                            {{ $result['improvementTip'] ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            @else
                <p class="text-center text-gray-500">
                    No result found. Please upload your resume again.
                </p>
            @endif
        </div>
    </div>
</x-app-layout>
