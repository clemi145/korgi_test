<?php

namespace App\Console;

use App\Models\Team;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $now = now();
            foreach (Team::all() as $team) {
                if($team->last_message != null) {
                    if ($team->last_message->diffInMonths($now) >= 3) {
                        $team->update([
                            "inactive" => true,
                            "inactive_since" => now()
                        ]);
                    }
                }
                if($team->inactive_since != null) {
                    if ($team->inactive_since->diffInWeeks($now) >= 1) {
                        $team->delete();
                    }
                }
            }
        })->weekly();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
