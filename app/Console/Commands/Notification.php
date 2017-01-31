<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class Notification extends Command {

    protected $signature = 'mail:notification';
    protected $description = 'Send emails when events you are interested in starts';

    public function __construct() {
        parent::__construct();
    }

    public function handle() {
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
    }
}
