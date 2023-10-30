<?php

namespace App\Console\Commands;

use App\Models\FoodParty;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        // Get the first record from the food_party_times table
        $firstRecord = DB::table('food_party_times')->first();
        $currentTime = now()->format('H:i');

        if ($firstRecord && ($currentTime > $firstRecord->end_time || $currentTime < $firstRecord->start_time)) {
            // If the current time is greater than the end_time, delete records in the food_parties table
            FoodParty::query()->delete();
            $this->info('Expired food parties have been deleted.');
        } else {
            $this->info('No expired food parties found.');
        }
    }
}
