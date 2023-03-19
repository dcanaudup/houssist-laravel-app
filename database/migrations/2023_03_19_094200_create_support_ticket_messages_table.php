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
        Schema::create('support_ticket_messages', function (Blueprint $table) {
            $table->foreignId('support_ticket_id')->constrained('support_tickets', 'support_ticket_id');
            $table->bigIncrements('support_ticket_message_id');
            $table->foreignId('user_id')->constrained('users');
            $table->text('message');
            $table->timestamps();
        });

        Schema::table('support_ticket_messages', function (Blueprint $table) {
            $table->unique('support_ticket_message_id');
            $table->dropPrimary();
        });

        Schema::table('support_ticket_messages', function (Blueprint $table) {
            $table->primary(['support_ticket_id', 'support_ticket_message_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_ticket_messages');
    }
};
