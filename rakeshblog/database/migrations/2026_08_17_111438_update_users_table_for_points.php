<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if columns exist before adding
            if (!Schema::hasColumn('users', 'total_points')) {
                $table->integer('total_points')->default(0)->after('phone');
            }
            if (!Schema::hasColumn('users', 'quiz_attempts')) {
                $table->integer('quiz_attempts')->default(0)->after('total_points');
            }
            if (!Schema::hasColumn('users', 'correct_answers')) {
                $table->integer('correct_answers')->default(0)->after('quiz_attempts');
            }
            if (!Schema::hasColumn('users', 'total_questions_answered')) {
                $table->integer('total_questions_answered')->default(0)->after('correct_answers');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['total_points', 'quiz_attempts', 'correct_answers', 'total_questions_answered'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};