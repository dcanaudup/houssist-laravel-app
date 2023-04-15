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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->bigIncrements('support_ticket_id');
            $table->foreignId('task_id')->nullable()->constrained('tasks', 'task_id');
            $table->string('subject');
            $table->string('reference_number')->unique();
            $table->string('support_ticket_type');
            $table->string('status');
            $table->string('in_favor_of');
            $table->foreignId('closed_by')
                ->nullable()
                ->constrained('users', 'id');
            $table->timestamps();
        });

        Schema::table('support_tickets', function (Blueprint $table) {
            $table->unique('support_ticket_id');
            $table->dropPrimary();
        });

        Schema::table('support_tickets', function (Blueprint $table) {
            $table->primary(['user_id', 'support_ticket_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
