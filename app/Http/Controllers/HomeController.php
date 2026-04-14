<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\CarouselSlide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::active()->ordered()->get();
        
        $carouselSlides = CarouselSlide::active()->ordered()->get();
        
        // Furniture-specific categories for homepage sections
        $diningProducts = Product::with('category')
            ->active()
            ->inStock()
            ->whereHas('category', function($query) {
                $query->where('slug', 'like', '%dining%');
            })
            ->limit(1)
            ->get();

            // dd($diningProducts);
            
        $bedProducts = Product::with('category')
            ->active()
            ->inStock()
            ->whereHas('category', function($query) {
                $query->where('slug', 'like', '%bed%');
            })
            ->limit(1)
            ->get();
            
        $sofaProducts = Product::with('category')
            ->active()
            ->inStock()
            ->whereHas('category', function($query) {
                $query->where('slug', 'like', '%sofa%');
            })
            ->limit(1)
            ->get();
            
        $coffeeTableProducts = Product::with('category')
            ->active()
            ->inStock()
            ->whereHas('category', function($query) {
                $query->where('slug', 'like', '%coffee%');
            })
            ->limit(1)
            ->get();
            
        $livingRoomProducts = Product::with('category')
            ->active()
            ->inStock()
            ->whereHas('category', function($query) {
                $query->where('slug', 'like', '%living%');
            })
            ->limit(1)
            ->get();
            
        $wardrobeProducts = Product::with('category')
            ->active()
            ->inStock()
            ->whereHas('category', function($query) {
                $query->where('slug', 'like', '%wardrobe%');
            })
            ->limit(1)
            ->get();
            
        $airbnbProducts = Product::with('category')
            ->active()
            ->inStock()
            ->whereHas('category', function($query) {
                $query->where('slug', 'like', '%airbnb%');
            })
            ->limit(1)
            ->get();

        return view('home', compact(
            'categories',
            'carouselSlides',
            'diningProducts',
            'bedProducts',
            'sofaProducts',
            'coffeeTableProducts',
            'livingRoomProducts',
            'wardrobeProducts',
            'airbnbProducts'
        ));
    }
}
