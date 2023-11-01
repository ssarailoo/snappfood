<?php

namespace App\Console\Commands;

use App\Models\Food\FoodParty;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteExpiredFoodParties extends Command
{
    protected $signature = 'food-party:delete-expired';

    protected $description = 'Delete expired food parties based on end times from food_party_times';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $firstRecord = DB::table('food_party_times')->first();
        $currentTime = now()->format('H:i');

        if ($firstRecord && ($currentTime > $firstRecord->end_time || $currentTime < $firstRecord->start_time)) {

            FoodParty::query()->delete();
            $this->info('Expired food parties have been deleted.');
            Log::info('Expired food parties have been deleted.');
        } else {
            $this->info('No expired food parties found.');
            Log::info('No expired food parties found.');
        }
    }
}
