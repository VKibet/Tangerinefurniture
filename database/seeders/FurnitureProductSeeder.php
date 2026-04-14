<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class FurnitureProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $diningCategory = Category::where('slug', 'dining-sets')->first();
        $livingCategory = Category::where('slug', 'living-room')->first();
        $bedCategory = Category::where('slug', 'beds-bedroom')->first();
        $officeCategory = Category::where('slug', 'office-furniture')->first();
        $outdoorCategory = Category::where('slug', 'outdoor-furniture')->first();
        $storageCategory = Category::where('slug', 'storage-solutions')->first();
        $hotelCategory = Category::where('slug', 'hotel-restaurant')->first();
        $airbnbCategory = Category::where('slug', 'airbnb-furnishing')->first();
        $coffeeTableCategory = Category::where('slug', 'coffee-tables')->first();
        $sofaCategory = Category::where('slug', 'sofas-seating')->first();

        $products = [
            // Dining Sets
            [
                'category_id' => $diningCategory->id,
                'name' => 'Modern Oak Dining Set',
                'slug' => 'modern-oak-dining-set',
                'description' => 'Beautiful 6-seater dining set with solid oak table and upholstered chairs. Perfect for family gatherings.',
                'brand' => 'Tangerine Premium',
                'price' => 85000.00,
                'old_price' => 95000.00,
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80',
                    'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ],
                'badge' => 'SALE',
                'rating' => 5,
                'reviews_count' => 23,
                'stock_quantity' => 5,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => $diningCategory->id,
                'name' => 'Glass Top Dining Table',
                'slug' => 'glass-top-dining-table',
                'description' => 'Elegant glass top dining table with chrome legs. Seats 4-6 people comfortably.',
                'brand' => 'Modern Living',
                'price' => 45000.00,
                'old_price' => null,
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80'
                ],
                'badge' => 'NEW',
                'rating' => 4,
                'reviews_count' => 12,
                'stock_quantity' => 8,
                'is_featured' => false,
                'is_active' => true,
            ],

            // Living Room
            [
                'category_id' => $livingCategory->id,
                'name' => 'L-Shaped Sectional Sofa',
                'slug' => 'l-shaped-sectional-sofa',
                'description' => 'Comfortable L-shaped sectional sofa in premium fabric. Perfect for large living rooms.',
                'brand' => 'Comfort Plus',
                'price' => 120000.00,
                'old_price' => 140000.00,
                'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80'
                ],
                'badge' => 'HOT',
                'rating' => 5,
                'reviews_count' => 31,
                'stock_quantity' => 3,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => $livingCategory->id,
                'name' => 'Modern TV Stand',
                'slug' => 'modern-tv-stand',
                'description' => 'Sleek TV stand with storage compartments and cable management.',
                'brand' => 'TechDesk Pro',
                'price' => 35000.00,
                'old_price' => null,
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80'
                ],
                'badge' => null,
                'rating' => 4,
                'reviews_count' => 8,
                'stock_quantity' => 12,
                'is_featured' => false,
                'is_active' => true,
            ],

            // Beds & Bedroom
            [
                'category_id' => $bedCategory->id,
                'name' => 'King Size Bed Frame',
                'slug' => 'king-size-bed-frame',
                'description' => 'Solid wood king size bed frame with headboard and footboard.',
                'brand' => 'SleepWell',
                'price' => 75000.00,
                'old_price' => 85000.00,
                'image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ],
                'badge' => 'SALE',
                'rating' => 5,
                'reviews_count' => 19,
                'stock_quantity' => 6,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => $bedCategory->id,
                'name' => 'Wardrobe with Mirror',
                'slug' => 'wardrobe-with-mirror',
                'description' => 'Spacious wardrobe with sliding doors and full-length mirror.',
                'brand' => 'StorageMax',
                'price' => 65000.00,
                'old_price' => null,
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80'
                ],
                'badge' => 'NEW',
                'rating' => 4,
                'reviews_count' => 7,
                'stock_quantity' => 4,
                'is_featured' => false,
                'is_active' => true,
            ],

            // Office Furniture
            [
                'category_id' => $officeCategory->id,
                'name' => 'Executive Office Desk',
                'slug' => 'executive-office-desk',
                'description' => 'Large executive desk with drawers and cable management.',
                'brand' => 'OfficePro',
                'price' => 55000.00,
                'old_price' => null,
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80'
                ],
                'badge' => null,
                'rating' => 4,
                'reviews_count' => 15,
                'stock_quantity' => 9,
                'is_featured' => false,
                'is_active' => true,
            ],

            // Coffee Tables
            [
                'category_id' => $coffeeTableCategory->id,
                'name' => 'Glass Coffee Table',
                'slug' => 'glass-coffee-table',
                'description' => 'Modern glass coffee table with wooden legs.',
                'brand' => 'GlassCraft',
                'price' => 25000.00,
                'old_price' => 30000.00,
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80'
                ],
                'badge' => 'SALE',
                'rating' => 4,
                'reviews_count' => 11,
                'stock_quantity' => 7,
                'is_featured' => true,
                'is_active' => true,
            ],

            // Sofas & Seating
            [
                'category_id' => $sofaCategory->id,
                'name' => '3-Seater Fabric Sofa',
                'slug' => '3-seater-fabric-sofa',
                'description' => 'Comfortable 3-seater sofa in premium fabric.',
                'brand' => 'SofaKing',
                'price' => 65000.00,
                'old_price' => null,
                'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ],
                'badge' => 'NEW',
                'rating' => 5,
                'reviews_count' => 22,
                'stock_quantity' => 5,
                'is_featured' => true,
                'is_active' => true,
            ],

            // Hotel & Restaurant
            [
                'category_id' => $hotelCategory->id,
                'name' => 'Commercial Dining Set',
                'slug' => 'commercial-dining-set',
                'description' => 'Heavy-duty dining set designed for commercial use.',
                'brand' => 'CommercialPro',
                'price' => 150000.00,
                'old_price' => null,
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80'
                ],
                'badge' => null,
                'rating' => 4,
                'reviews_count' => 6,
                'stock_quantity' => 2,
                'is_featured' => false,
                'is_active' => true,
            ],

            // Airbnb Furnishing
            [
                'category_id' => $airbnbCategory->id,
                'name' => 'Complete Airbnb Package',
                'slug' => 'complete-airbnb-package',
                'description' => 'Complete furnishing package for Airbnb properties including all essential furniture.',
                'brand' => 'AirbnbPro',
                'price' => 300000.00,
                'old_price' => 350000.00,
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80'
                ],
                'badge' => 'HOT',
                'rating' => 5,
                'reviews_count' => 8,
                'stock_quantity' => 1,
                'is_featured' => true,
                'is_active' => true,
            ],

            // Outdoor Furniture
            [
                'category_id' => $outdoorCategory->id,
                'name' => 'Patio Dining Set',
                'slug' => 'patio-dining-set',
                'description' => 'Weather-resistant patio dining set for outdoor entertaining.',
                'brand' => 'OutdoorLiving',
                'price' => 45000.00,
                'old_price' => null,
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80'
                ],
                'badge' => null,
                'rating' => 4,
                'reviews_count' => 13,
                'stock_quantity' => 6,
                'is_featured' => false,
                'is_active' => true,
            ],

            // Storage Solutions
            [
                'category_id' => $storageCategory->id,
                'name' => 'Bookshelf Unit',
                'slug' => 'bookshelf-unit',
                'description' => '5-tier bookshelf unit for organizing books and display items.',
                'brand' => 'OrganizeMax',
                'price' => 18000.00,
                'old_price' => null,
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80'
                ],
                'badge' => null,
                'rating' => 4,
                'reviews_count' => 9,
                'stock_quantity' => 10,
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }
    }
}