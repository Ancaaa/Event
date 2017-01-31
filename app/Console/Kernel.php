<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        Commands\Notification::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule->call(function() {
            $events = Event::where('startdate', Carbon::today()->format('Y-m-d'))->get();
            foreach ($events as $event) {
                $attendants = $event->users;
                foreach ($attendants as $attendant) {
                    Mail::send( 'emails.notification', array(), function($message) use ($attendant)
                    {
                        $message->from('events@eventU.com', 'Customer Support');
                        $message->to($attendant->email)->subject('Event is coming up!');
                    });
                }
            }
        })->daily();
    }
}
