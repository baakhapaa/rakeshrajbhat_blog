<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('research', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('category', ['Vision', 'Research Papers', 'Media']);
            $table->text('description');
            $table->longText('content')->nullable();
            $table->string('image_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_file')->nullable();
            $table->string('link_url')->nullable();
            $table->text('category_icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false); // Moved after is_active
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('research');
    }
};