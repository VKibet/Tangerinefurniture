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
        // Keep the existing group/label/type so saving a setting doesn't move it to "general"
        $setting = static::firstOrNew(['key' => $key]);

        if (!$setting->exists) {
            $setting->label = ucwords(str_replace('_', ' ', $key));
            $setting->type = 'text';
            $setting->group = 'general';
        }

        $setting->value = $value;
        $setting->save();

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

    /**
     * Extra recipients copied on new order notifications.
     */
    public static function orderNotificationEmails(): array
    {
        $emails = preg_split('/[\s,;]+/', (string) static::get('order_notification_emails', ''), -1, PREG_SPLIT_NO_EMPTY);

        return array_values(array_unique(array_filter($emails, fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))));
    }
}
