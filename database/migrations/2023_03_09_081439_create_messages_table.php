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
        Schema::create('messages', function (Blueprint $table) {
            $table->foreignId('chat_id')->constrained('chats', 'chat_id');
            $table->bigIncrements('message_id');
            $table->foreignId('user_id')->constrained('users');
            $table->text('message');
            $table->timestamps();
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->unique('message_id');
            $table->dropPrimary();
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->primary(['chat_id', 'message_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
