<?php

namespace App\Console;
use Backup;
use App\Restore;

use Storage;
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
        // $schedule->command('inspire')
        //          ->hourly();
        
       
        
        

        $schedule->call(function () {
            $disk = Storage::disk('backups');
            $files = $disk->files(config('laravel-backup.backup.name'));
            $token=str_random(24);
            $token=$token.time();
            $restore= new Restore;
            $restore->token=$token;
            $restore->description="Punto de restauración automatico.";
            Backup::export($token);
            $restore->size=$disk->size($token.".sql");
            $restore -> save();
        })->everyMinute();
      
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
