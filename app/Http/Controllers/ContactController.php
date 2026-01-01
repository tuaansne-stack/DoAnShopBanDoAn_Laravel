<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index()
    {
        $settings = Settings::getMainSettings();

        return view('contact', compact('settings'));
    }

    /**
     * Handle contact form submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
        ]);

        // Here you can add email sending logic
        // Mail::to($settings->email)->send(new ContactMail($request->all()));

        return back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.');
    }
}

