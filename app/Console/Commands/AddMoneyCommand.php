<?php

namespace App\Console\Commands;

use App\Aggregates\WalletAggregateRoot;
use App\Modules\Shared\Enums\WalletTransactionType;
use App\Modules\Shared\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AddMoneyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-money';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add money to a user\'s wallet';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $user = User::query()
            ->where('id', $this->ask('Enter user id'))
            ->with('wallet')
            ->firstOrFail();

        WalletAggregateRoot::retrieve($user->wallet->uuid)
            ->addMoney($this->ask('Amount'), WalletTransactionType::Deposit->value, Str::random(), 'Add money command')
            ->persist();
    }
}
