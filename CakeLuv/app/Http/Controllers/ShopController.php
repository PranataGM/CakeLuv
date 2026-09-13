<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $cakesQuery = Product::where('is_available', true)
            ->whereHas('category', function ($q) {
                $q->where('slug', '!=', 'lilin-aksesoris');
            });
            
        $accessoriesQuery = Product::where('is_available', true)
            ->whereHas('category', function ($q) {
                $q->where('slug', 'lilin-aksesoris');
            });

        // Sort applied to both if necessary, or just latest
        $cakes = $cakesQuery->latest()->get();
        $accessories = $accessoriesQuery->latest()->get();
        
        $categories = Category::all();

        return view('shop.index', compact('cakes', 'accessories', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        
        // Get related products from same category
        $related_products = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_available', true)
            ->take(4)
            ->get();
            
        return view('shop.show', compact('product', 'related_products'));
    }
}
