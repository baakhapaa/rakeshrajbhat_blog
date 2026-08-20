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
            if (!Schema::hasColumn('users', 'accuracy')) {
                $table->string('accuracy')->default('0%');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'total_points',
                'quiz_attempts',
                'accuracy',
                'is_active',
                'phone',
                'role'
            ]);
        });
    }
};