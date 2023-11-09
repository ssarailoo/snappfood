<?php

namespace App\Console\Commands;

use App\Models\Cart\Cart;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class DeleteExpiredCarts extends Command
{
    protected $signature = 'carts:delete-expired';
    protected $description = 'Delete expired carts';

    public function handle()
    {

        $expirationTime = Carbon::now()->subMinute();


        Cart::query()->where('is_paid', 0)
            ->where('created_at', '<', $expirationTime)
            ->delete();

        $this->info('Expired carts deleted successfully.');
        Log::info('Expired carts deleted successfully.');
    }
}
