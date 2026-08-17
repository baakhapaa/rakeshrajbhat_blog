<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('points')->default(0)->after('email');
            $table->integer('quiz_attempts')->default(0)->after('points');
            $table->integer('correct_answers')->default(0)->after('quiz_attempts');
            $table->integer('total_questions_answered')->default(0)->after('correct_answers');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['points', 'quiz_attempts', 'correct_answers', 'total_questions_answered']);
        });
    }
};