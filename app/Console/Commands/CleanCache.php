<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class CleanCache
 *
 * Clear all caches of the application
 *
 * @package App\Console\Commands
 */
class CleanCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all caches';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * return self
     */
    public function handle()
    {
        // $this->call('optimize:clear');
        $this->call('config:cache');
        $this->call('cache:clear');
        $this->call('route:cache');
        $this->call('view:clear');
        $this->call('optimize:clear');

        $this->info('All caches gone! fresh start :)');
    }
}
