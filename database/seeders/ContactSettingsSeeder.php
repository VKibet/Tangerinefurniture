<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class ContactSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contactSettings = [
            [
                'key' => 'contact_phone',
                'value' => '+254 700 123 456',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Contact Phone',
                'description' => 'Main contact phone number'
            ],
            [
                'key' => 'contact_email',
                'value' => 'hello@tangerinefurniture.co.ke',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Contact Email',
                'description' => 'Main contact email address'
            ],
            [
                'key' => 'contact_address',
                'value' => 'Westlands, Nairobi',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Contact Address',
                'description' => 'Physical address'
            ],
            [
                'key' => 'contact_city',
                'value' => 'Kenya',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Contact City',
                'description' => 'City and country'
            ],
            [
                'key' => 'business_hours_weekdays',
                'value' => 'Monday - Friday: 8:00 AM - 6:00 PM',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Weekday Hours',
                'description' => 'Business hours for weekdays'
            ],
            [
                'key' => 'business_hours_saturday',
                'value' => 'Saturday: 9:00 AM - 4:00 PM',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Saturday Hours',
                'description' => 'Business hours for Saturday'
            ],
            [
                'key' => 'business_hours_sunday',
                'value' => 'Sunday: Closed',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Sunday Hours',
                'description' => 'Business hours for Sunday'
            ],
            [
                'key' => 'social_facebook',
                'value' => '#',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Facebook URL',
                'description' => 'Facebook page URL'
            ],
            [
                'key' => 'social_twitter',
                'value' => '#',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Twitter URL',
                'description' => 'Twitter profile URL'
            ],
            [
                'key' => 'social_instagram',
                'value' => '#',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Instagram profile URL'
            ],
            [
                'key' => 'social_linkedin',
                'value' => '#',
                'type' => 'text',
                'group' => 'social',
                'label' => 'LinkedIn URL',
                'description' => 'LinkedIn profile URL'
            ]
        ];

        foreach ($contactSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
