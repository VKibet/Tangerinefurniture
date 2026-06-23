<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $categories = [
            ['name' => 'Living Room',     'slug' => 'living-room',     'icon' => 'fas fa-couch',     'description' => 'Sofas, coffee tables, TV stands, and living room accessories.', 'sort_order' => 11],
            ['name' => 'Dining Sets',     'slug' => 'dining-sets',     'icon' => 'fas fa-utensils',  'description' => 'Complete dining room furniture sets.',                         'sort_order' => 1],
            ['name' => 'Sofas & Seating', 'slug' => 'sofas-seating',   'icon' => 'fas fa-couch',     'description' => 'Sofas, armchairs, and seating furniture.',                     'sort_order' => 10],
            ['name' => 'Tv stand',        'slug' => 'tv-stand',        'icon' => 'fas fa-tv',        'description' => 'TV stands and media units.',                                   'sort_order' => 12],
            ['name' => 'LOUNGES',         'slug' => 'lounges',         'icon' => 'fas fa-chair',     'description' => 'Lounge furniture.',                                            'sort_order' => 13],
            ['name' => 'Bar Stools',      'slug' => 'bar-stools',      'icon' => 'fas fa-glass-martini', 'description' => 'Bar stools and counter seating.',                         'sort_order' => 14],
            ['name' => 'Accent chairs',   'slug' => 'accent-chairs',   'icon' => 'fas fa-chair',     'description' => 'Accent chairs and occasional seating.',                        'sort_order' => 15],
        ];

        $now = now();

        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $cat['slug']],
                array_merge($cat, ['is_active' => true, 'created_at' => $now, 'updated_at' => $now])
            );
        }
    }

    public function down(): void
    {
        DB::table('categories')->whereIn('slug', [
            'living-room', 'tv-stand', 'lounges', 'bar-stools', 'accent-chairs',
        ])->delete();
    }
};
