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
        Schema::create('tasks', function (Blueprint $table) {
            $table->foreignId('service_provider_id')
                ->constrained('users');
            $table->bigIncrements('task_id');
            $table->foreignId('home_owner_id')
                ->constrained('users');
            $table->foreignId('advertisement_id')
                ->constrained('advertisements', 'advertisement_id');
            $table->foreignId('advertisement_offer_id')
                ->constrained('advertisement_offers', 'advertisement_offer_id');
            $table->string('status');
            $table->timestamps();
            $table->unique(['service_provider_id', 'advertisement_id', 'advertisement_offer_id']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->unique('task_id');
            $table->dropPrimary();
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->primary(['service_provider_id', 'task_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
