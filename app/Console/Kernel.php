<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $mytime = Carbon::now()->format('y-m-d');
            DB::table('event')->where('start_datetime', '<=' , $mytime)->update(['status' => 'nonaktif']);
            DB::table('event')->where('start_datetime', '>=' , $mytime)->update(['status' => 'aktif']);
            DB::table('event')->where('end_datetime', '<=' , $mytime)->update(['status' => 'nonaktif']);
        })->daily();
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
