<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarouselSlide;

class FurnitureCarouselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slides = [
            [
                'title' => 'Premium Furniture Collection',
                'description' => 'Discover our exclusive collection of premium furniture designed for modern living.',
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2016&q=80',
                'button_text' => 'Shop Now',
                'button_link' => '/products',
                'background_color' => 'gray',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Airbnb Furnishing Solutions',
                'description' => 'Complete furnishing packages for Airbnb properties. Professional setup included.',
                'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                'button_text' => 'Learn More',
                'button_link' => '/products?category=airbnb-furnishing',
                'background_color' => 'blue',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Commercial Furniture',
                'description' => 'Heavy-duty furniture solutions for hotels, restaurants, and commercial spaces.',
                'image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                'button_text' => 'View Collection',
                'button_link' => '/products?category=hotel-restaurant',
                'background_color' => 'green',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slide) {
            CarouselSlide::updateOrCreate(
                ['title' => $slide['title']],
                $slide
            );
        }
    }
}