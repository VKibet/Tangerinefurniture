<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description'
    ];

    /**
     * Retrieve a setting by key with caching support.
     */
    public static function get($key, $default = null)
    {
        return Cache::rememberForever("setting_{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set or update a setting and refresh cache.
     */
    public static function set($key, $value)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'label' => ucwords(str_replace('_', ' ', $key)),
                'type' => 'text',
                'group' => 'general'
            ]
        );

        // Refresh cache for that key
        Cache::forget("setting_{$key}");
        Cache::rememberForever("setting_{$key}", fn() => $value);

        return $setting;
    }

    /**
     * Retrieve all settings in a group.
     */
    public static function getGroup($group)
    {
        return static::where('group', $group)->get();
    }

    /**
     * Get all settings as an associative array.
     */
    public static function getAllAsArray()
    {
        return Cache::rememberForever('settings_all', function () {
            return static::pluck('value', 'key')->toArray();
        });
    }
}
