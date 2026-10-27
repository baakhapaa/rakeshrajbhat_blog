<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('research', function (Blueprint $table) {
            if (! Schema::hasColumn('research', 'show_on_home')) {
                $table->boolean('show_on_home')->default(false)->after('is_featured');
            }
        });

        if (Schema::hasColumn('research', 'show_on_home')) {
            DB::table('research')->where('is_featured', true)->update(['show_on_home' => true]);
        }
    }

    public function down(): void
    {
        Schema::table('research', function (Blueprint $table) {
            if (Schema::hasColumn('research', 'show_on_home')) {
                $table->dropColumn('show_on_home');
            }
        });
    }
};
