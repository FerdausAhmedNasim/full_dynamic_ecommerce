<?php

namespace App\Console\Commands;

use Throwable;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Database\Seeders\SystemData\PermissionSeeder;

/**
 * Class CleanCache
 *
 * Clear all caches of the application
 *
 * @package App\Console\Commands
 */
class UpdatePermissionSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update permission seeder';

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
        DB::beginTransaction();

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            $admin_role = Role::where('slug', 'super-admin')->first();
            //$admin_user = User::where('email', config('app.admin_email'))->first();

            $admin_role->permissions()->detach();
           // $admin_user->permissions()->detach();

            Permission::truncate();

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $seeder = new PermissionSeeder();
            $seeder->run();

            $this->info('All set! Permissions seeder updated :)');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            $this->error('Something went wrong! check log file. :(');
        }
    }
}
