<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Resume_Controller extends Controller
{

    public function show_all()
    {
        $interviews = Auth::user()->interviewers->sortByDesc('created_at');
        return view('resume.feed_resume', compact('interviews'));
    }

    public function resume_result(Request $request)
    {
        $request->validate([
            'resumeText' => 'required|string',
            'jobDescription' => 'required|string',
        ]);

        $resumeText = $request->input('resumeText');
        $jobDescription = $request->input('jobDescription');

        try {
            // ✅ Build AI Prompt (same style as specific_card_report)
            $prompt = "
            Analyze the following resume and job description:

            Resume:
            $resumeText

            Job Description:
            $jobDescription

            Now perform the following:
            1. Extract the key skills from the resume.
            2. Compare them with the job description.
            3. Predict a score (out of 100) for how well the candidate will likely perform in an interview for this job.
            4. List 5 strong areas based on the resume.
            5. List 5 weak or missing areas.
            6. Suggest 1 specific improvement tip for the candidate to improve their chances.

            Respond in JSON format with:
            {
            \"score\": number (0–100),
            \"keySkills\": [string],
            \"strongAreas\": [string],
            \"weakAreas\": [string],
            \"improvementTip\": string
            }
            ";

            // ✅ Call Groq API (same as specific_card_report)
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.6,
                'max_tokens' => 1000,
            ]);

            $aiText = $response->json('choices.0.message.content', '');

            // ✅ Extract JSON safely
            $jsonStart = strpos($aiText, '{');
            $jsonEnd = strrpos($aiText, '}');

            if ($jsonStart === false || $jsonEnd === false) {
                return response()->json([
                    'success' => false,
                    'error' => 'AI response does not contain valid JSON',
                    'raw' => $aiText
                ], 500);
            }

            $jsonString = substr($aiText, $jsonStart, $jsonEnd - $jsonStart + 1);
            $result = json_decode($jsonString, true);
            
            
            if (!$result) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to parse JSON from AI',
                    'raw' => $jsonString
                ], 500);
            }

            // ✅ Store result in session
            session(['Resume_Result' => $result]);

            // ✅ Redirect to next page
            return redirect()->route('resume.report');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to analyze resume: ' . $e->getMessage()
            ], 500);
        }

        
}




}
