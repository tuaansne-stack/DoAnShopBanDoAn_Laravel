<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle search request.
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword', '');

        if (empty($keyword)) {
            return redirect()->route('home');
        }

        $products = Product::with(['category'])
            ->active()
            ->where(function($query) use ($keyword) {
                $query->where('tenmon', 'like', "%{$keyword}%")
                      ->orWhere('mota', 'like', "%{$keyword}%");
            })
            ->paginate(12);

        $news = News::published()
            ->where(function($query) use ($keyword) {
                $query->where('tieude', 'like', "%{$keyword}%")
                      ->orWhere('noidung', 'like', "%{$keyword}%")
                      ->orWhere('tomtat', 'like', "%{$keyword}%");
            })
            ->paginate(10);

        return view('search', compact('keyword', 'products', 'news'));
    }
}

