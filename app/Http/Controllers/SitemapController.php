<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $content = view('sitemap.index', [
            'products' => Product::active()->get(),
            'categories' => Category::active()->get(),
        ])->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function products()
    {
        $products = Product::active()->get();
        
        $content = view('sitemap.products', [
            'products' => $products
        ])->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
