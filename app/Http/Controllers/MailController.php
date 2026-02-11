<?php

namespace App\Http\Controllers;

use App\Mail\DataMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    function sendEmail(Request $request){

        $request->validate([
        'email' => 'required|email',
        'link'  => 'required|string',
        ]);

        $email = $request->email;
        $link = $request->link;

       $subject ="Smart Hire Interview";

       Mail::to($email)->send(new DataMail($link, $subject));

        // ✅ JSON response bhejo
        return response()->json([
            'success' => true,
            'message' => 'Email sent successfully!'
        ]);
        
    }

}
