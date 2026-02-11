<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\interview_controller;
use App\Http\Controllers\InterviewDetails_Controller;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Resume_Controller;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;




//landing page
Route::view('/', 'welcome')->name('/');

Route::middleware('auth')->group(function () {
    
  
    Route::get('/dashboard', [InterviewDetails_Controller::class, 'dashboard'])->name('dashboard')->middleware('prevent-back'); 


    Route::get('/questions/show', function () {
        if (!session()->has('jobData') || !session()->has('questions')) {
            return redirect()->back()->with('error', 'No questions to show.');
        }

        return view('interview.created_questions', [
            'jobData'   => session('jobData'),
            'questions' => session('questions'),
        ]); 

    })->name('questions.show')->middleware('prevent-back');

    //interview 
    Route::get('/interview/create', [interview_controller::class, 'create'])->name('interview.create');
    Route::post('/generate/questions', [interview_controller::class, 'generateQuestions'])->name('generate.questions');
    Route::post('/interview/store', [interview_controller::class, 'store'])->name('interview.store');

    Route::get('/interview/call-link', function () { 

        return view('interview.call_link' , [
            'interviewer' => session('interviewer'),
        ]);
        
    })->name('interview.call-link')->middleware('prevent-back'); 


    //interview Details and All interviews
    Route::get('/All-Interviews', [InterviewDetails_Controller::class, 'show_all'])->name('All-Interviews');
    Route::get('/Interviews-Details', [InterviewDetails_Controller::class, 'show_detail_cards'])->name('Interviews-Details');
    Route::get('/interview/specific/card/{id}', [InterviewDetails_Controller::class, 'show_specific_card'])->name('interview.specific.card');
    Route::post('/interview/card/report/{id}', [InterviewDetails_Controller::class, 'specific_card_report'])->name('interview.card.report');

    //feed resume
    Route::get('/feed-resume', [Resume_Controller::class, 'show_all'])->name('feed-resume');
    Route::post('/resume-result', [Resume_Controller::class, 'resume_result'])->name('resume-result');

    Route::get('/resume/report', function () {

        return view('resume.resume_report', [
            'result' => session('Resume_Result'),
        ]);
    
    })->name('resume.report');


    //billing
    Route::get('/billing', [StripeController::class, 'bill_form'])->name('billing');
    Route::post('/charge', [StripeController::class, 'charge'])->name('charge');


    //settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::patch('/settings/account', [SettingsController::class, 'updateAccount'])->name('settings.updateAccount');
    Route::patch('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.updatePassword');



    //profile recovey
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // for cutome mail
    Route::post('/Send-Email', [MailController::class, 'sendEmail'])->name('Send-Email');
  

});



// user interview routes
Route::get('/join-call/{id}', [interview_controller::class, 'join_call'])->name('join-call');
Route::post('/interview/call/{id}', [interview_controller::class, 'call'])->name('interview.call');
Route::get('/live-interview/{interview}', [interview_controller::class, 'showLive'])->name('live.interview');
Route::post('/process-transcript', [interview_controller::class, 'processTranscript'])->name('process.transcript');

Route::get('/end-call', [interview_controller::class, 'end_call'])->name('end-call')->middleware('prevent-back');
   

require __DIR__.'/auth.php';
