<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Settings;

class AboutController extends Controller
{
    /**
     * Display the about page.
     */
    public function index()
    {
        $settings = Settings::getMainSettings();
        $aboutSections = About::visible()->ordered()->get();

        return view('about', compact('settings', 'aboutSections'));
    }
}

