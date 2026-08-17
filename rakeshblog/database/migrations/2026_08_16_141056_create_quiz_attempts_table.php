<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('score')->default(0);
            $table->integer('total_points')->default(0);
            $table->boolean('passed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};