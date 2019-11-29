<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Store;

class ExpiredStores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stores:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expired stores';

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
        // Get expired stores
        $stores = Store::where('status', 1)->where('is_admin', 0)->whereRaw('ends_at <= curdate()')->update([
            'status' => 0,
        ]);
    }
}
