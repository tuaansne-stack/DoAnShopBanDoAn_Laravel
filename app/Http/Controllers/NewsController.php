<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of news.
     */
    public function index()
    {
        $news = News::published()
            ->latest('ngaydang')
            ->paginate(10);

        return view('news.index', compact('news'));
    }

    /**
     * Display the specified news.
     */
    public function show($id)
    {
        $news = News::published()->findOrFail($id);
        
        // Increment view count
        $news->incrementViews();

        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->latest('ngaydang')
            ->limit(4)
            ->get();

        return view('news.show', compact('news', 'relatedNews'));
    }
}

