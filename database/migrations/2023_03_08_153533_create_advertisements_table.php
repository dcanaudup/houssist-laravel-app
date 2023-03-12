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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->bigIncrements('advertisement_id');
            $table->string('title');
            $table->string('description');
            $table->string('address');
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
            $table->string('job_payment_type');
            $table->unsignedInteger('payment_rate');
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('advertisements', function (Blueprint $table) {
            $table->unique('advertisement_id');
            $table->dropPrimary();
        });

        Schema::table('advertisements', function (Blueprint $table) {
            $table->primary(['user_id', 'advertisement_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
