<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use League\CommonMark\CommonMarkConverter;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'brand',
        'price',
        'old_price',
        'image',
        'images',
        'badge',
        'rating',
        'reviews_count',
        'stock_quantity',
        'is_featured',
        'is_active',
        'is_ready',
        'specifications'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'rating' => 'integer',
        'reviews_count' => 'integer',
        'stock_quantity' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'is_ready' => 'boolean',
        'specifications' => 'array',
        'images' => 'array'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopeReady($query)
    {
        return $query->where('is_ready', true);
    }

    public function scopeOnOrder($query)
    {
        return $query->where('is_ready', false);
    }

    public function getFormattedPriceAttribute()
    {
        return 'KES ' . number_format($this->price, 2);
    }

    public function getFormattedOldPriceAttribute()
    {
        return $this->old_price ? 'KES ' . number_format($this->old_price, 2) : null;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->old_price && $this->old_price > $this->price) {
            return round((($this->old_price - $this->price) / $this->old_price) * 100);
        }
        return 0;
    }

    public function getAllImagesAttribute()
    {
        $allImages = [];
        
        // Add main image first if it exists
        if ($this->image) {
            $allImages[] = $this->image;
        }
        
        // Add additional images
        $validImages = $this->getValidImages();
        if (!empty($validImages)) {
            $allImages = array_merge($allImages, $validImages);
        }
        
        return $allImages;
    }

    public function getAllImagesUrlsAttribute()
    {
        $allImages = [];
        
        // Add main image first if it exists
        if ($this->image) {
            $allImages[] = $this->main_image_url;
        }
        
        // Add additional images
        $validImages = $this->getValidImages();
        if (!empty($validImages)) {
            foreach ($validImages as $image) {
                $allImages[] = $this->getImageUrlAttribute($image);
            }
        }
        
        return $allImages;
    }

    public function getMainImageAttribute()
    {
        return $this->image ?? ($this->images[0] ?? 'https://via.placeholder.com/300x200/cccccc/ffffff?text=Product');
    }

    public function getMainImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://via.placeholder.com/300x200/cccccc/ffffff?text=Product';
        }
        
        // Check if it's an external URL (http/https)
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image; // Return external URLs as-is
        }
        
        // Check if the image path starts with a slash (public assets)
        if (str_starts_with($this->image, '/')) {
            return $this->image; // Return as-is for public assets
        }
        
        // For storage images, use asset helper
        return asset('storage/' . $this->image);
    }

    public function getImageUrlAttribute($imagePath)
    {
        if (!$imagePath) {
            return 'https://via.placeholder.com/300x200/cccccc/ffffff?text=Product';
        }
        
        // Check if it's an external URL (http/https)
        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return $imagePath; // Return external URLs as-is
        }
        
        // Check if the image path starts with a slash (public assets)
        if (str_starts_with($imagePath, '/')) {
            return $imagePath; // Return as-is for public assets
        }
        
        // For storage images, use asset helper
        return asset('storage/' . $imagePath);
    }

    public function getImagesUrlsAttribute()
    {
        if (!$this->images || !is_array($this->images)) {
            return [];
        }
        
        return array_map(function($image) {
            return $this->getImageUrlAttribute($image);
        }, $this->getValidImages());
    }

    public function getValidImages()
    {
        if (!$this->images || !is_array($this->images)) {
            return [];
        }
        
        // Filter out empty arrays, null values, and non-string values
        return array_filter($this->images, function($image) {
            return is_string($image) && !empty(trim($image));
        });
    }

    /**
     * Get the parsed Markdown description as HTML
     */
    public function getParsedDescriptionAttribute()
    {
        if (!$this->description) {
            return '';
        }

        // Preprocess the description to convert hyphen-without-space to proper Markdown list format
        $processedDescription = $this->preprocessMarkdown($this->description);

        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return $converter->convert($processedDescription)->getContent();
    }

    /**
     * Preprocess description to convert various formats to proper Markdown
     */
    private function preprocessMarkdown($description)
    {
        // Convert lines starting with hyphen followed by non-space to proper Markdown list format
        // This handles cases like "-36 pages" -> "- 36 pages"
        $lines = explode("\n", $description);
        $processedLines = [];

        foreach ($lines as $line) {
            $trimmedLine = trim($line);
            
            // Check if line starts with hyphen followed by a non-space character
            if (preg_match('/^-(?![ ])/', $trimmedLine)) {
                // Convert "-text" to "- text"
                $processedLines[] = preg_replace('/^-(?![ ])/', '- ', $trimmedLine);
            } else {
                $processedLines[] = $trimmedLine;
            }
        }

        return implode("\n", $processedLines);
    }
}
