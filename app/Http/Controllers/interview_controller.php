<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Interviewer;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\DB;


class interview_controller extends Controller
{

    public function create(){

        return view('interview.create');
    }


    public function generateQuestions(Request $request)
    {
        // ✅ Validation step
        $validated = $request->validate([
            'job_position'   => 'required|string|max:100',
            'job_description'=> 'required|string',
            'duration'       => 'required|integer|min:1|max:15', 
            'interview_type' => 'required',
            'num_questions'  => 'required|integer|min:1|max:25',
        ]);

        $data = $request->only(['job_position', 'job_description', 'duration', 'interview_type', 'num_questions']);
        
        $user = auth()->user(); // get logged-in user
        //Check user credits
        if (($user->credit ?? 0) <= 0) {
            return redirect()->back()->with('error', 'Your credits have run out. Please purchase more credits to generate questions.');
        }

        // Step 1: Construct the prompt
        $interviewType = is_array($data['interview_type']) 
                        ? implode(', ', $data['interview_type']) 
                        : $data['interview_type'];

        $prompt = "
            You are an expert technical interviewer. Based on the inputs below, generate exactly {$data['num_questions']} complete, clear, and specific interview questions.

            Job Title: {$data['job_position']}
            Job Description: {$data['job_description']}
            Interview Duration: {$data['duration']} minutes
            Interview Type: {$interviewType}

            Instructions:
            - Analyze the job description for responsibilities, required skills, and experience.
            - Each question should be a full sentence.
            - Match the tone and structure of a real-life {$interviewType} interview.
            - Categorize each question (e.g., Backend, Database, Communication, etc.).
            - Use the exact formatting below for each question:

            ###START###
            Type: [Question Type]
            Question: [Full question here]?
            ###END###

            Only return the questions using this exact format. Do not include extra text or explanations.
        ";

        // Step 2: Send request to Groq API
        $apiKey = env('GROQ_API_KEY');
        $response = Http::withToken($apiKey)->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.7,
            'max_tokens' => 1024,
            'top_p' => 1,
            'stream' => false
        ]);

        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Groq API failed to respond');
        }

        $fullText = $response['choices'][0]['message']['content'] ?? '';
        $questions = [];

        // Step 3: Parse Groq AI output
        try {
            $blocks = explode("###START###", $fullText);
            foreach ($blocks as $block) {
                if (str_contains($block, '###END###')) {
                    $content = trim(explode("###END###", $block)[0]);

                    $q_type = '';
                    $q_text = '';

                    foreach (explode("\n", $content) as $line) {
                        $line = trim($line);
                        if (strtolower(substr($line, 0, 5)) === 'type:') {
                            $q_type = trim(substr($line, 5));
                        } elseif (strtolower(substr($line, 0, 9)) === 'question:') {
                            $q_text = trim(substr($line, 9));
                        }
                    }

                    if ($q_type && $q_text) {
                        $questions[] = [
                            'type' => $q_type,
                            'question' => $q_text
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            $questions = [['type' => 'Unknown', 'question' => $fullText]];
        }

        if (empty($questions)) {
            $questions = [['type' => 'Unknown', 'question' => $fullText]];
            return redirect()->back()->with('error', 'Failed to generate questions. Please try again.');
        }

        // Step 4: Save to session and redirect
        session([
            'jobData'   => $data,
            'questions' => $questions,
        ]);

        return redirect()->route('questions.show');

    }


    public function store(Request $request)
    {
        $request->validate([
            'job_position'     => 'required|string',
            'job_description'  => 'required|string',
            'duration'         => 'required|numeric',
            'interview_type'   => 'required',
            'num_questions'    => 'required|integer',
            'questions'        => 'required|array',
        ]);

        // ✅ Step 1: Store to DB
        $interviewer = Interviewer::create([
            'user_id'          => auth()->id(),
            'job_position'     => $request->job_position,
            'job_description'  => $request->job_description,
            'duration'         => $request->duration,
            'interview_type'   => is_array($request->interview_type)
                                    ? implode(',', $request->interview_type)
                                    : $request->interview_type,
            'num_questions'    => $request->num_questions,
            'question'         => json_encode($request->questions),
        ]);

        
        $interviewerData = Interviewer::find($interviewer->id);  // refreshed instance

        // ✅ Step 3: Clear previous session (if any)
        session()->forget(['jobData', 'questions']);

        // ✅ Step 4: Store in session
        session(['interviewer' => $interviewerData]);

        $user = auth()->user(); // get logged-in user
        $user->credit -= 1;
        $user->save();
  
        // ✅ Step 5: Redirect to new route
        return redirect()->route('interview.call-link');
    }


    public function join_call($id)
    {
        $interview = Interviewer::findOrFail($id); // Will throw 404 if not found

        // call link page forgets interviewer id from session
        session()->forget('interviewer');

        return view('interview.join_call', compact('interview'));
    }


    public function call(Request $request, $id)
    {
        // 1. Validate
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // 2. Find interview id
        $interview = Interviewer::findOrFail($id);

        // check agar conversation table mein record hai
        $hasConversation = DB::table('conversations')
            ->where('interviewer_id', $id)
            ->exists();

        if ($hasConversation) {
            // 🔹 Agar record mojood hai to redirect karo
            return view('interview.already_taken', [
                'interview' => $interview
            ]);
        }

        // ✅ User data ko session me permanently store karo
        session(['userData' => $data]);

        // ✅ Redirect to live interview page
        return redirect()->route('live.interview', [
            'interview' => $interview->id,
        ]);
    }

    public function showLive(Interviewer $interview)
    {
        // ✅ Session se data uthao (refresh pe bhi available rahega)
        $userData = session('userData', []);

        return view('interview.live_call', [
            'interview' => $interview,
            'userData'  => $userData
        ]);
    }


    // Helper function to load questions from DB as conversational array
    private function loadQuestionsFromDB($id)
    {
        $interview = Interviewer::findOrFail($id);
        $questions = json_decode($interview->question, true) ?? [];

        $formattedQuestions = array_map(function ($q) {
            if (is_array($q) && isset($q['question'])) {
                return $q['question'];
            }
            if (is_string($q) && ($decoded = json_decode($q, true)) && isset($decoded['question'])) {
                return $decoded['question'];
            }
            return (string) $q;
        }, $questions);

        return $formattedQuestions;
    }

        
    public function processTranscript(Request $request)
    {
        $validated = $request->validate([
            'transcript'   => 'required|string',
            'interview_id' => 'required|integer',
            'Time'         => 'required|string', 
            'name'          => 'required|string',
            'email'         => 'required|email',
        ]);

        $interview_id = $validated['interview_id'];
        $userAnswer = $validated['transcript'];
        $timeTaken    = $validated['Time']; 
        $candidateName  = $validated['name'];
        $candidateEmail = $validated['email'];

        // --- Find or Create Conversation Row ---
        $conversation = Conversation::firstOrCreate(
            [
                'interviewer_id' => $interview_id,
                'name'         => $candidateName,
                'email'        => $candidateEmail,
            ],
            [
                'conversation' => json_encode([]), // start empty array
            ]
        );

        // Try to get questions from session first
        $questions = session("questions_$interview_id");

        if (!$questions || !is_array($questions)) {
            $questions = $this->loadQuestionsFromDB($interview_id);
            session(["questions_$interview_id" => $questions]);
        }

        if (empty($questions)) {
            return response()->json([
                'question' => "No questions found for this interview.",
                'completed' => true
            ]);
        }

        // Get current question index from session (default 0)
        $currentIndex = session("current_question_$interview_id", 0);

        // If already finished
        if ($currentIndex >= count($questions)) {
            return response()->json([
                'question' => "✅ Thank you for your time. The interview is now complete. You can leave conversation now.",
                'completed' => true
            ]);
        }

        // Get current question
        $currentQuestion = $questions[$currentIndex];

        // Get next question or null
        $NextQuestion = ($currentIndex + 1 < count($questions))
            ? $questions[$currentIndex + 1]
            : null;

        // Format next question line
        $nextQuestionLine = $NextQuestion !== null
            ? '- Next Question: "' . $NextQuestion . '"'
            : '- Next Question: None (no more questions)';


        $prompt = <<<PROMPT
        You are an AI interviewer. Follow EXACTLY the instructions below. Do not improvise beyond them.

        INPUT:
        - Current Question: "$currentQuestion"
         $nextQuestionLine
        - Candidate Answer: "$userAnswer"

        RULES (each rule ends with fixed ACTION):
        1. Respond in a conversational tone, sometimes slightly rephrasing questions to sound more natural. Avoid repeating the question exactly word-for-word unless the candidate asked for it.
        2. If answer is a greeting (hi, hello, good morning, etc.), greet back warmly and rephrase the CURRENT QUESTION in a slightly longer or conversational way. ACTION: stay
        3. If answer is asking to repeat the question (repeat, say again, etc.), acknowledge politely and restate the CURRENT QUESTION with a natural rephrase. ACTION: stay
        4. If answer is "I don't know" or similar, respond encouragingly and ask if they’d like you to repeat the CURRENT QUESTION or move on to the next. ACTION: stay
        5. If answer means "move to next question", ask the NEXT QUESTION in a natural, slightly rephrased form. ACTION: next
        6. If answer is correct/valid, give positive feedback, then ask the NEXT QUESTION in a natural, slightly expanded way. ACTION: next
        7. If answer is wrong/invalid, respond encouragingly without being harsh, then ask the NEXT QUESTION in a natural, slightly rephrased way. ACTION: next
        8. For anything else, treat as irrelevant — respond politely and ask the CURRENT QUESTION again with a natural rephrase. ACTION: stay

        OUTPUT FORMAT:
        Your reply must have 2 parts:
        1. Natural language interviewer reply according to the rule.
        2. On a NEW LINE, JSON only: {"action": "<stay or next>"}

        EXAMPLES (enhanced for human-like flow):

        Example 1:
        User: hi
        AI: Hello! It's so nice to meet you. Let's get started with our conversation. Just to begin, could you share your thoughts on "$currentQuestion"? Feel free to take your time answering, no rush.
        {"action": "stay"}

        Example 2:
        User: please move on
        AI: Absolutely! Let's move forward. The next question I have for you is "$NextQuestion". Take your time and answer naturally, and remember there's no pressure—just speak your mind.
        {"action": "next"}

        Example 3:
        User: I don’t know
        AI: That's completely okay! It's fine if you're unsure. Would you like me to repeat the question "$currentQuestion" so you can have another try, or would you prefer to move on to the next one?
        {"action": "stay"}
         
        Example 4:
        User: my answer is Y (incorrect)
        AI: I appreciate your effort!. Let’s continue with the next question: "$NextQuestion". Take your time and answer thoughtfully.
        {"action": "next"}

        Example 5:
        User: my answer is X (correct)
        AI: Excellent! That’s a strong answer. Now, let’s proceed to the next question: "$NextQuestion". Keep going at your own pace.
        {"action": "next"}

        Example 6:
        User: some unrelated response
        AI: Thanks for sharing! I think we might have gone a bit off-topic. Let’s refocus and go back to the current question: "$currentQuestion". Take your time and answer as best you can.
        {"action": "stay"}

        Now reply for the given Candidate Answer.
        PROMPT;
        

        $apiKey = env('GROQ_API_KEY');
        $response = Http::withToken($apiKey)->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [['role' => 'user', 'content' => $prompt]],
            'temperature' => 0.7,
            'max_tokens' => 512,
            'top_p' => 1,
            'stream' => false
        ]);

        if (!$response->successful()) {
            return response()->json(['error' => 'AI API failed to respond'], 500);
        }

        $fullText = $response['choices'][0]['message']['content'] ?? '';

      // Extract JSON metadata
        preg_match('/\{.*\}/s', $fullText, $matches);

        $action = null;
        if (!empty($matches)) {
            $meta = json_decode($matches[0], true);
            $action = $meta['action'] ?? null;

            // Remove the JSON part from the question text
            $cleanQuestion = trim(str_replace($matches[0], '', $fullText));
        } else {
            $cleanQuestion = trim($fullText);
        }

        
        // --- STEP 6: Save Conversation in DB ---
        $oldConversation = json_decode($conversation->conversation, true) ?? [];

        $oldConversation[] = [
            'time' => $timeTaken,
            'user' => $userAnswer,
            'ai'   => $cleanQuestion,
        ];

        $conversation->conversation = json_encode($oldConversation, JSON_PRETTY_PRINT);
        $conversation->save();

        // Index increment only if action === "next"
        if ($action === "next") {
            session(["current_question_$interview_id" => $currentIndex + 1]);
        } else {
            session(["current_question_$interview_id" => $currentIndex]);
        }

        return response()->json([
            'question' => $cleanQuestion, //  Only natural reply, no action text
            'action' => $action,  
        ]);

    }

    public function end_call(){
        
       return view('interview.end_call');

    }


}






