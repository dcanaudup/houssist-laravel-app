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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->foreignId('wallet_id')
                ->constrained('wallets');
            $table->bigIncrements('wallet_transaction_id');
            $table->bigInteger('amount');
            $table->string('transaction_type');
            $table->string('reference_number');
            $table->text('remarks')
                ->nullable();
            $table->timestamps();
        });

        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->unique('wallet_transaction_id');
            $table->dropPrimary();
        });

        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->primary(['wallet_id', 'wallet_transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
