<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'total_points')) {
                $table->integer('total_points')->default(0);
            }
            if (!Schema::hasColumn('users', 'quiz_attempts')) {
                $table->integer('quiz_attempts')->default(0);
            }
            if (!Schema::hasColumn('users', 'correct_answers')) {
                $table->integer('correct_answers')->default(0);
            }
            if (!Schema::hasColumn('users', 'total_questions_answered')) {
                $table->integer('total_questions_answered')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['total_points', 'quiz_attempts', 'correct_answers', 'total_questions_answered']);
        });
    }
};