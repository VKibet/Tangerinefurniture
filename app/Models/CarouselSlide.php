<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarouselSlide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'button_text',
        'button_link',
        'background_color',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Scope a query to only include active slides.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order slides by their order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get the background color classes based on the color name.
     */
    public function getBackgroundClassesAttribute()
    {
        $colors = [
            'blue' => 'from-blue-100 to-blue-200',
            'green' => 'from-green-100 to-green-200',
            'purple' => 'from-purple-100 to-purple-200',
            'red' => 'from-red-100 to-red-200',
            'yellow' => 'from-yellow-100 to-yellow-200',
            'pink' => 'from-pink-100 to-pink-200',
            'indigo' => 'from-indigo-100 to-indigo-200',
            'gray' => 'from-gray-100 to-gray-200'
        ];

        return $colors[$this->background_color] ?? 'from-blue-100 to-blue-200';
    }

    /**
     * Get the text color class based on the background color.
     */
    public function getTextColorClassAttribute()
    {
        $colors = [
            'blue' => 'text-blue-600',
            'green' => 'text-green-600',
            'purple' => 'text-purple-600',
            'red' => 'text-red-600',
            'yellow' => 'text-yellow-600',
            'pink' => 'text-pink-600',
            'indigo' => 'text-indigo-600',
            'gray' => 'text-gray-600'
        ];

        return $colors[$this->background_color] ?? 'text-blue-600';
    }
}
