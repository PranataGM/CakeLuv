<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $best_sellers = Product::whereHas('category', function ($query) {
            $query->where('slug', 'best-sellers');
        })->where('is_available', true)->take(8)->get();
        
        $trending = Product::whereHas('category', function ($query) {
            $query->where('slug', 'trending-now');
        })->where('is_available', true)->take(4)->get();

        return view('home', compact('best_sellers', 'trending'));
    }
}
