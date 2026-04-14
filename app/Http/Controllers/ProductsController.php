<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->active();

        // Availability filter is optional.
        // When no availability is selected, show all active products.
        if ($request->filled('availability')) {
            if ($request->availability === 'ready') {
                $query->ready();
            } elseif ($request->availability === 'on_order') {
                $query->onOrder();
            }
        }
        
        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function($catQuery) use ($search) {
                      $catQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Price filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Rating filter
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }
        
        // Sort products
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc')->orderBy('reviews_count', 'desc');
                break;
            case 'popular':
                $query->orderBy('reviews_count', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
                break;
        }
        
        // Get all categories for filter sidebar
        $categories = Category::active()->ordered()->get();
        
        // Get featured products for sidebar
        $featuredProducts = Product::with('category')
            ->active()
            ->featured()
            ->inStock()
            ->limit(4)
            ->get();
        
        // Paginate products
        $products = $query->paginate(12)->withQueryString();
        
        // Get filter stats
        $totalProducts = $query->count();
        $minPrice = Product::active()->min('price');
        $maxPrice = Product::active()->max('price');
        
        return view('products.index', compact(
            'products',
            'categories',
            'featuredProducts',
            'totalProducts',
            'minPrice',
            'maxPrice'
        ));
    }
    
    public function show($slug)
    {
        $product = Product::with('category')
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();
            
        // Get related products
        $relatedProducts = Product::with('category')
            ->active()
            ->inStock()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
            
        return view('products.show', compact('product', 'relatedProducts'));
    }
} 