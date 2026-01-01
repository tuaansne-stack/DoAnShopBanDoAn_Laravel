<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Settings;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $settings = Settings::getMainSettings();
        
        // Get categories with their products (eager load all, then limit per category)
        $categoriesWithProducts = Category::with(['products' => function($query) {
            $query->with(['mainImage', 'toppings'])
                ->where('trangthai', 'Đang bán')
                ->latest();
        }])->get()->map(function($category) {
            // Take only the first 6 products per category
            $category->setRelation('products', $category->products->take(6));
            return $category;
        });
        
        return view('home', compact('settings', 'categoriesWithProducts'));
    }
}

