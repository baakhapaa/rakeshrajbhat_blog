<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_quiz_results', function (Blueprint $table) {
            if (!Schema::hasColumn('user_quiz_results', 'answers')) {
                $table->json('answers')->nullable()->after('points_earned');
            }
            if (!Schema::hasColumn('user_quiz_results', 'details')) {
                $table->json('details')->nullable()->after('answers');
            }
            if (!Schema::hasColumn('user_quiz_results', 'wrong_questions')) {
                $table->json('wrong_questions')->nullable()->after('details');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_quiz_results', function (Blueprint $table) {
            $table->dropColumn(['answers', 'details', 'wrong_questions']);
        });
    }
};