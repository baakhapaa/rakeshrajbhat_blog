<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('settings')) {
            return;
        }

        if (DB::table('settings')->where('key', 'news_content')->exists()) {
            return;
        }

        $now = now();

        DB::table('settings')->insert([
            'key' => 'news_content',
            'value' => Setting::encodeJson(Setting::defaultNewsContent()),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        if (!Schema::hasTable('settings')) {
            return;
        }

        DB::table('settings')->where('key', 'news_content')->delete();
    }
};
