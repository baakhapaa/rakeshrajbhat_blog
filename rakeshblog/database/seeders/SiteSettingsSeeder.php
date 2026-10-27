<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'Rakesh Rajbhat',
            'site_description' => 'Official website of Rakesh Rajbhat - Founder, Builder, Future Maker',
            'home_content' => Setting::encodeJson(Setting::defaultHomeContent()),
            'about_content' => Setting::encodeJson(Setting::defaultAboutContent()),
        ];

        foreach ($settings as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
