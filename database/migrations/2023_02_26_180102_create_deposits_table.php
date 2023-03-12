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
        Schema::create('deposits', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained('users');
            $table->bigIncrements('deposit_id');
            $table->string('deposit_type');
            $table->bigInteger('amount');
            $table->string('status')->default('pending');
            $table->string('user_remarks')
                ->default('');
            $table->string('admin_remarks')
                ->default('');
            $table->dateTime('latest_transaction_date')
                ->nullable();
            $table->timestamps();
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->unique('deposit_id');
            $table->dropPrimary();
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->primary(['user_id', 'deposit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
