<?php

namespace App\Helpers;

use App\Models\Setting;

class SocialMediaHelper
{
    public static function getSocialMediaUrls()
    {
        $socialUrls = [];
        
        $platforms = [
            'facebook' => 'social_facebook',
            'twitter' => 'social_twitter', 
            'instagram' => 'social_instagram',
            'linkedin' => 'social_linkedin'
        ];
        
        foreach ($platforms as $platform => $key) {
            $url = Setting::get($key);
            if ($url && $url !== '#' && !empty($url)) {
                $socialUrls[$platform] = $url;
            }
        }
        
        return $socialUrls;
    }
    
    public static function getSameAsArray()
    {
        $socialUrls = self::getSocialMediaUrls();
        return array_values($socialUrls);
    }
    
    public static function hasSocialMedia()
    {
        return !empty(self::getSocialMediaUrls());
    }
    
    public static function getUrl($platform)
    {
        $socialUrls = self::getSocialMediaUrls();
        return $socialUrls[$platform] ?? null;
    }
    
    public static function getPlatforms()
    {
        return [
            'facebook' => 'social_facebook',
            'twitter' => 'social_twitter', 
            'instagram' => 'social_instagram',
            'linkedin' => 'social_linkedin'
        ];
    }
}
