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
        Schema::create('advertisement_offers', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->bigIncrements('advertisement_offer_id');
            $table->foreignId('advertisement_id')->constrained('advertisements', 'advertisement_id');
            $table->unsignedInteger('payment_rate')
                ->nullable();
            $table->dateTime('offer_date')
                ->nullable();
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('advertisement_offers', function (Blueprint $table) {
            $table->unique('advertisement_offer_id');
            $table->dropPrimary();
        });

        Schema::table('advertisement_offers', function (Blueprint $table) {
            $table->primary(['user_id', 'advertisement_offer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisement_offers');
    }
};
