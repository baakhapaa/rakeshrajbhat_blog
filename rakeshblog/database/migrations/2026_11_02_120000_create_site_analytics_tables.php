<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_visits', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_hash', 64)->index();
            $table->string('session_id', 255)->nullable()->index();
            $table->string('landing_path', 500);
            $table->string('referrer_host')->nullable();
            $table->string('source', 20)->index();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('country', 2)->nullable()->index();
            $table->string('city')->nullable();
            $table->string('device', 20)->nullable();
            $table->string('browser', 40)->nullable();
            $table->string('os', 40)->nullable();
            $table->timestamps();

            $table->index('created_at');
        });

        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_visit_id')->nullable()->constrained('site_visits')->nullOnDelete();
            $table->string('path', 500);
            $table->string('content_type', 20)->nullable();
            $table->unsignedBigInteger('content_id')->nullable();
            $table->timestamp('created_at')->nullable()->index();

            $table->index(['content_type', 'content_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
        Schema::dropIfExists('site_visits');
    }
};
