<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('projects')->where('slug', 'future-builders')->exists()) {
            return;
        }

        $nextOrder = ((int) DB::table('projects')->max('order')) + 1;

        DB::table('projects')->insert([
            'name' => 'Future Builders',
            'slug' => 'future-builders',
            'short_description' => 'Encouraging young people to learn, build, and lead.',
            'description' => 'Future Builders supports young people as they develop skills, confidence, and ideas for their communities.',
            'url' => null,
            'image' => null,
            'color' => '#D4AF37',
            'bg_color' => '#fff6e0',
            'is_active' => true,
            'order' => $nextOrder,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Keep the admin-created project and its edits when rolling back.
    }
};
