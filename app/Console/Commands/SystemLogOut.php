<?php

namespace App\Console\Commands;

use Exception;
use App\Library\Enum;
use App\Models\Location;
use App\Models\Attendance;
use Illuminate\Console\Command;

class SystemLogOut extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Logout the user at 11:59 pm who forgot to logout today';
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $attendances = Attendance::whereNull('out_time')->whereDate('created_at', now()->today())->get();

        if (count($attendances)) {
            $location = Location::where('ip', request()->ip())->first();

            foreach ($attendances as $attendance) {
                try {
                    $attendance->update([
                        'out_time'          => now()->format('Y-m-d H:i'),
                        'out_time_ip'       => request()->ip(),
                        'out_time_location' => $location ? $location->name : 'Remote',
                        'out_time_note'     => 'Sign out by system'
                    ]);
                } catch (Exception $e) {
                    logger($e->getMessage());
                }
            }
        }

        $alerts = Attendance::where('sign_out_type', '!=', Enum::SIGN_OUT_TYPE_LEAVING)->whereIsAlert(1)->whereNull('delay_time')->get();

        if (count($alerts)) {
            foreach ($alerts as $alert) {
                try {
                    $alert->update([
                        'is_alert'   => 0,
                        'delay_time' => now()->diff($alert->expected_back_time)->format('%H:%I'),
                    ]);
                } catch (Exception $e) {
                    logger($e->getMessage());
                }
            }
        }
    }
}
