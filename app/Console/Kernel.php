<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Event;
use App\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel {

    protected $commands = [
        // Commands\Inspire::class,
        Commands\Notification::class,
    ];

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

        $schedule->call(function() {
            $events = Event::where('startdate', Carbon::today()->format('Y-m-d'))->get();
            foreach ($events as $event) {
                $attendants = $event->users;
                foreach ($attendants as $attendant) {
                    $notification = new Notification;
                    $notification->user_id = $attendant->id;
                    $notification->ref_id = $event->id;
                    $notification->type = 2;
                    $notification->save();
                }
            }
        })->daily();
    }
}
