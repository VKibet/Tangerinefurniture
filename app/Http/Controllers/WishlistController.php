<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        // Get wishlist from cookies - try multiple approaches
        $wishlistCookie = $request->cookie('wishlist');
        $wishlist = [];
        
        $rawCookies = $request->header('Cookie');
        
        if ($wishlistCookie) {
            try {
                $wishlist = json_decode(urldecode($wishlistCookie), true) ?? [];
            } catch (Exception $e) {
                $wishlist = [];
            }
        } else {
            // Try to parse from raw cookie string
            if ($rawCookies) {
                $cookiePairs = explode(';', $rawCookies);
                foreach ($cookiePairs as $pair) {
                    $pair = trim($pair);
                    if (strpos($pair, 'wishlist=') === 0) {
                        $wishlistValue = substr($pair, 9); // Remove 'wishlist='
                        try {
                            $wishlist = json_decode(urldecode($wishlistValue), true) ?? [];
                        } catch (Exception $e) {
                            $wishlist = [];
                        }
                        break;
                    }
                }
            }
        }
        $productIds = collect($wishlist)->pluck('id')->map(function($id) {
            return (int) $id;
        })->toArray();

        $products = Product::whereIn('id', $productIds)
            ->with('category')
            ->get();
        return view('wishlist.index', compact('products', 'wishlist'));
    }


} 