<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{    
    protected $commands = [        
        Commands\DeleteCustomer::class,
		Commands\DeleteOrphaned::class,
		Commands\DeleteUnused::class,
    ];
    
    protected function schedule(Schedule $schedule) {
		// Run the task every day at midnight
        $schedule->command('delete:customer')->daily();
		$schedule->command('delete:orphaned')->daily();	
		$schedule->command('delete:unused')->daily();	
    }
    
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
