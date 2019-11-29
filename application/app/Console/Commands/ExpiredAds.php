<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\AdWillExpireSoon;
use App\User;
use App\Models\Ad;
use Carbon\Carbon;

class ExpiredAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if ads expired or not';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get Ads
        $date = new Carbon();
        $from = $date->now();
        $to   = $date->addDays(10);
        $ads  = Ad::where('is_archived', 0)->where('is_trashed', 0)->where('user_id', '!=', 0)->whereBetween('ends_at', [$from, $to])->get();

        foreach ($ads as $ad) {
            
            // Get user
            $user = User::where('id', $ad->user_id)->first();

            // Send User notification
            $user->notify(new AdWillExpireSoon($ad->ad_id));

        }
    }
}
