<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ad;

class ArchiveAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move expired ads to archive';

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
        
        // Get expired Ads
        $ads = Ad::where('is_archived', 0)->where('user_id', '!=', 1)->where('is_trashed', 0)->whereRaw('ends_at <= curdate()')->update([
            'is_archived' => 1,
            'is_featured' => 0,
        ]);

    }
}
