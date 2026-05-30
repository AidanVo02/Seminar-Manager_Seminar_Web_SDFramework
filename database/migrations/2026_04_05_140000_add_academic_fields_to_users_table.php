<?php

// Adds academic profile fields used for demo realism and analytics.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('department')->nullable()->after('role');
            $table->string('student_code')->nullable()->after('department');
            $table->string('cohort')->nullable()->after('student_code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['department', 'student_code', 'cohort']);
        });
    }
};
