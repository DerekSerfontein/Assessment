<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactForm;

class ContactFormController extends Controller
{
    public function submit(Request $request)
    {
        $messages = [
            'name.required' => 'We need to know your name.',
            'email.required' => 'Don\'t forget your email address.',
            'email.email' => 'Please provide a valid email address.',
            'message.required' => 'A message is required to submit the form.',
        ];

        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email',
            'message' => 'required|min:10',
        ], $messages);

        ContactForm::create($validatedData);

        return redirect()->back()->with('success', 'Thank you for your message!');
    }
}
