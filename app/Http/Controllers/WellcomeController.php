<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use App\Mail\ContactFormEmail;
use Illuminate\Support\Facades\Validator;

class WellcomeController extends Controller
{
    /**
     * Display welcome page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Handle contact form submission and send email
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendContactEmail(Request $request)
    {
        // Validate form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Collect form data
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        try {
            // Send email to admin
            Mail::to(env('MAIL_ADMIN_ADDRESS', 'raifanramadhanputra06@gmail.com'))
                ->send(new ContactFormEmail($data));

            // Send confirmation email to user
            Mail::to($request->email)
                ->send(new WelcomeEmail($data['name']));

            return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you shortly.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sorry, there was an error sending your message. Please try again later.');
        }
    }

    /**
     * Send welcome email to a specific user
     *
     * @param  string  $email
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function sendWelcomeEmail($email, $name)
    {
        try {
            Mail::to($email)->send(new WelcomeEmail($name));
            return response()->json(['message' => 'Welcome email sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send welcome email'], 500);
        }
    }
}