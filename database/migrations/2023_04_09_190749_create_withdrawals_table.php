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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained('users');
            $table->bigIncrements('withdrawal_id');
            $table->uuid()->unique();
            $table->string('withdrawal_type');
            $table->string('withdrawal_details');
            $table->bigInteger('amount');
            $table->string('status')->default('pending');
            $table->string('user_remarks')
                ->default('');
            $table->string('admin_remarks')
                ->default('');
            $table->dateTime('latest_transaction_date')
                ->nullable();
            $table->string('reference_number')
                ->default('');
            $table->timestamps();
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->unique('withdrawal_id');
            $table->dropPrimary();
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->primary(['user_id', 'withdrawal_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
