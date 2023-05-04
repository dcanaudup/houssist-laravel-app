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
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedSmallInteger('rating')
                ->after('status')
                ->default(0);
            $table->string('review_title')
                ->after('rating')
                ->default('');
            $table->string('review')
                ->after('review_title')
                ->default('');
            $table->dateTime('reviewed_at')
                ->after('review')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('rating');
            $table->dropColumn('review_title');
            $table->dropColumn('review');
            $table->dropColumn('reviewed_at');
        });
    }
};
