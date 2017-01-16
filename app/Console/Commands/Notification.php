<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Notification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails when events you are interested in starts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   

        foreach ($attendants as $attendant) {
             if(Carbon\Carbon::today()->format('Y-m-d') == $attendat->$event->startdate )
             {
            Mail::send('emails.notification', function($message){
            $message->from('events@eventU.com');
            $message->to($attendant->$user->email);
            $message->subject('Event is coming up!');

             }
        }

         
    }
}
