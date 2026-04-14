<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class FurnitureCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Dining Sets',
                'slug' => 'dining-sets',
                'icon' => 'fas fa-utensils',
                'description' => 'Complete dining room furniture sets including tables, chairs, and accessories.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Living Room',
                'slug' => 'living-room',
                'icon' => 'fas fa-couch',
                'description' => 'Sofas, coffee tables, TV stands, and living room accessories.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Beds & Bedroom',
                'slug' => 'beds-bedroom',
                'icon' => 'fas fa-bed',
                'description' => 'Bed frames, mattresses, wardrobes, and bedroom furniture.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Office Furniture',
                'slug' => 'office-furniture',
                'icon' => 'fas fa-desktop',
                'description' => 'Desks, office chairs, filing cabinets, and workspace furniture.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Outdoor Furniture',
                'slug' => 'outdoor-furniture',
                'icon' => 'fas fa-tree',
                'description' => 'Garden furniture, patio sets, and outdoor accessories.',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Storage Solutions',
                'slug' => 'storage-solutions',
                'icon' => 'fas fa-box',
                'description' => 'Shelving units, storage cabinets, and organization furniture.',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Hotel & Restaurant',
                'slug' => 'hotel-restaurant',
                'icon' => 'fas fa-building',
                'description' => 'Commercial furniture for hotels, restaurants, and hospitality.',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Airbnb Furnishing',
                'slug' => 'airbnb-furnishing',
                'icon' => 'fas fa-home',
                'description' => 'Complete furnishing packages for Airbnb properties.',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Coffee Tables',
                'slug' => 'coffee-tables',
                'icon' => 'fas fa-table',
                'description' => 'Coffee tables, side tables, and accent tables.',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Sofas & Seating',
                'slug' => 'sofas-seating',
                'icon' => 'fas fa-couch',
                'description' => 'Sofas, armchairs, and seating furniture.',
                'is_active' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}