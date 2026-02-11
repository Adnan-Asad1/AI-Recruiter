<?php

namespace App\Http\Controllers;
use App\Models\Interviewer;
use App\Models\Conversation;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class InterviewDetails_controller extends Controller
{
    
    public function dashboard()
    {

       $interviews = Auth::user()->interviewers
                ->sortByDesc('created_at') // descending order by created_at
                ->take(3);                 // latest 3 interviews

        return view('dashboard', compact('interviews'));

    }

    public function show_all()
    {
        // Jo user login hai uske saare interviews nikal lo
        $interviews = Auth::user()->interviewers->sortByDesc('created_at');
        return view('interview_Details.All_Interviews', compact('interviews'));
    }

    public function show_detail_cards()
    {
        // Auth users, -> ALL interviewers, -> those whose conversations Exist
        $interviews = Auth::user()->interviewers
        ->filter(fn($interview) => $interview->conversations !== null)
        ->sortByDesc('created_at');

        return view('interview_Details.Interview_Details', compact('interviews'));
    }

    public function show_specific_card($id)
    {
        $interview = Interviewer::findOrFail($id);
        return view('interview_Details.show_specific_card', compact('interview'));
    }

    
   public function specific_card_report($id)
    {
        // Step 1: Find interview
        $interview = Interviewer::findOrFail($id);

        // Step 2: Check if report already exists (via conversation relation)
        $report = $interview->conversations?->report;

       if ($report) {
           // Report exists in DB (stored JSON)
            $sections = json_decode($report->report, true) ?? [];
            
            return view('interview_Details.specific_card_report', compact('interview', 'sections'));
        }

        else {
            // Step 3: Get conversation row
            $conversationRow = Conversation::where('interviewer_id', $id)->first();

            if (!$conversationRow) {
                abort(404, 'Conversation not found.');
            }

            // Step 4: Decode JSON
            $conversation = json_decode($conversationRow->conversation, true);

            // Step 5: Build prompt
            $prompt = $this->buildGroqPrompt($interview, $conversation);

            // Step 6: Call AI API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.6,
                'max_tokens' => 1200,
            ]);

            $reportText = $response->json('choices.0.message.content', 'No report generated.');

            // Step 7: Parse first to validate
            $sections = $this->parseReport($reportText);

            if (empty($sections)) {
                return back()->with('error', 'AI failed to generate a valid report.');
            }

            // Step 8: Save new report in DB linked to conversation_id
            $report = Report::create([
                'conversation_id' => $conversationRow->id,
                'report'          => json_encode($sections), // ✅ store JSON
            ]);

            return view('interview_Details.specific_card_report', compact('interview', 'sections'));
        }
    }



    private function buildGroqPrompt($interview, $conversation)
    {
        $questions = is_string($interview->question)
        ? json_decode($interview->question, true) ?? []
        : ($interview->question ?? []);

        $types = implode(', ', $interview->interview_types ?? []);

       $convText = collect($conversation)->map(function($c){
            return "AI: {$c['ai']}\nUser: {$c['user']}";
        })->implode("\n\n");



        return "
            You are an expert HR recruiter and interviewer. Generate a professional interview evaluation report.

            Interview Details:
            - Candidate Name: {$interview->conversations->name}
            - Position Applied: {$interview->job_position}
            - Job Description: {$interview->job_description}
            - Interview Duration: {$interview->duration} minutes
            - Interview Type(s): {$types}
            - Total Questions (Planned): ".count($questions)."

            Conversation Transcript (for your analysis only):
            {$convText}

            ⚠ Strict Analysis Rules:
            - Base the evaluation ONLY on the conversation transcript.
            - Use the Planned Questions list as the ground truth (".count($questions)." total).
            - Identify which planned questions were actually asked in the conversation (even if rephrased).
            - If a question was repeated casually, count it only once.
            - For each planned question:
            • If the user gave a valid, relevant answer → mark as Attempted  
            • If the user gave no answer or an irrelevant response → mark as Skipped/Not Attempted
            - In the \"Attempt Summary\", clearly show:
            • Total Planned Questions = ".count($questions)."
            • Actual Unique Questions Asked (from conversation)
            • Attempted (valid answers)
            • Skipped / Irrelevant / Not Attempted
            - DO NOT invent or assume answers beyond the transcript.
            - Generate evaluation and scoring only after analyzing this mapping.
            - Evaluate and score(1–10) across these categories: 
            • Technical Knowledge
            • Problem-Solving Ability
            • Communication Skills
            • Confidence  (deduce from tone/phrasing)
            • Teamwork & Adaptability
            • Cultural Fit
            Generate the report with the following fixed headings:
            *Interview Evaluation Report*
            *Candidate Information*
            *Attempt Summary*
            *Evaluation and Scoring*
            *Overall Performance Summary*
            *Strengths*
            *Areas for Improvement*
            *Final Recommendation*

            Details:
            Under the heading \"Interview Evaluation Report\", include 2–3 formal lines such as:
            \"This report provides a comprehensive evaluation of the candidate’s performance during the interview.
            It is based strictly on the actual conversation and the relevance of the candidate’s responses.
            The aim is to assess the candidate’s overall suitability for the applied role.\"
            - \"Candidate Information\" → candidate name, position, type, duration.
            - \"Attempt Summary\" → show Planned vs Actual Unique vs Attempted vs Skipped.
            - \"Evaluation and Scoring\" → rate 1–10 for: Technical Knowledge, Problem-Solving Ability, Communication Skills, Confidence / Body Language, Teamwork & Adaptability, Cultural Fit.
            - \"Overall Performance Summary\" → 1–2 short paragraphs.
            - \"Strengths\" / \"Areas for Improvement\" → bullet points.
            - \"Final Recommendation\" → Hire / Consider / Not Hire with reasoning.
            Keep the style formal, concise, professional.
        ";
    }



    private function parseReport($text)
    {
        $parts = preg_split('/\n\\\\/', $text);
        $sections = [];

        foreach ($parts as $p) {
            $content = trim(str_replace("\\", "", $p));
            if (!$content) continue;
            $lines = explode("\n", $content);
            $heading = array_shift($lines);
            $body = implode("\n", $lines);
            $sections[] = ['heading' => $heading, 'body' => $body];
        }

        // Add Questions & Responses section if missing
        preg_match_all('/^(Q\d+|Question\s*\d+|^\d+\.)/im', $text, $matches);
        if ($matches[0] && !collect($sections)->pluck('heading')->contains(fn($h) => str_contains(strtolower($h), 'question'))) {
            $sections = array_merge(
                [$sections[0]],
                [['heading' => 'Questions & Responses', 'body' => implode("\n", $matches[0])]],
                array_slice($sections, 1)
            );
        }

        return $sections;
    }


 }
