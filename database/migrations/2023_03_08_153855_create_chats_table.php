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
        Schema::create('chats', function (Blueprint $table) {
            $table->foreignId('advertisement_id')
                ->constrained('advertisements', 'advertisement_id');
            $table->bigIncrements('chat_id');
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->unique('chat_id');
            $table->dropPrimary();
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->primary(['advertisement_id', 'chat_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
