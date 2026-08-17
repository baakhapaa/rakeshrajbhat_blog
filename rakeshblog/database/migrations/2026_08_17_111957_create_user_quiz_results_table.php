<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_quiz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->integer('score')->default(0);
            $table->integer('correct_count')->default(0);
            $table->integer('total_questions')->default(0);
            $table->integer('percentage')->default(0);
            $table->boolean('passed')->default(false);
            $table->integer('points_earned')->default(0);
            $table->timestamps();
            
            // Add indexes for faster queries
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_quiz_results');
    }
};