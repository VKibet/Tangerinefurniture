<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\CarouselSlide;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::active()->ordered()->get();
        $carouselSlides = CarouselSlide::active()->ordered()->get();

        $homepageCategoryKeywords = [
            'diningProducts' => 'dining',
            'bedProducts' => 'bed',
            'sofaProducts' => 'sofa',
            'coffeeTableProducts' => 'coffee',
            'livingRoomProducts' => 'living',
            'wardrobeProducts' => 'wardrobe',
            'airbnbProducts' => 'airbnb',
        ];

        $categoryProducts = $this->getHomepageCategoryProducts($homepageCategoryKeywords);

        return view('home', compact(
            'categories',
            'carouselSlides',
            'categoryProducts'
        ));
    }

    private function getHomepageCategoryProducts(array $keywords): array
    {
        $products = Product::with('category')
            ->active()
            ->inStock()
            ->whereHas('category', function ($query) use ($keywords) {
                $query->where(function ($categoryQuery) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $categoryQuery->orWhere('slug', 'like', "%{$keyword}%");
                    }
                });
            })
            ->latest('id')
            ->get();

        $groupedProducts = [];

        foreach ($keywords as $key => $keyword) {
            $match = $products->first(function (Product $product) use ($keyword) {
                return str_contains($product->category?->slug ?? '', $keyword);
            });

            $groupedProducts[$key] = $match ? new Collection([$match]) : collect();
        }

        return $groupedProducts;
    }
}
