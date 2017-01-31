<?php

namespace App\Http\Controllers;   //interiorul folderului use e pentru exterior
use App\Event;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use Mail;
use Session;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class PagesController extends Controller {

    public $searchedItem="";


    public function getIndex() {
        return view('pages/welcome');
        #process variable data and params
        #talk to the model
        #receive data back from the model
        #compile or process data from the model if needed
        #pass that data to the correct view
    }

    public function postIndex(Request $request){
        $this->validate($request, ['email' =>'required|email',
                                    'message' => 'min:10',
                                    'subject' => 'min:3']);
        $data = array(
            'email' => $request->email,
            'subject' => $request->subject,
            'bodyMessage' => $request->message);

        Mail::send('emails.contact', $data, function($message) use ($data){
            $message->from($data['email']);
            $message->to('events@eventU.com');
            $message->subject($data['subject']);

        });

        Session::flash('success', 'Your email was sent!');

        return redirect(' ');

    }

    public function getAbout(){
        $first = "Anca";
        $last = "Boia";

        $fullname = $first . " ". $last;
        return view('pages/about') ->withFullname($fullname);
    }

    public function getAllEvents(){
        view::share('$sharedItem', "");

        $events = Event::orderBy('startdate', 'desc')->paginate(20);
        return view('pages/allevents')->with(['events' => $events]);
    }

    public function getSingle($id){

        $event = Event::find($id);

     //  $userid = Auth::id();
      // @if ($userid)
           # code...

       // @if(Auth::check())
      //  $event->users()->sync($userid, false);
      //  @endif
      //  @endif
        return view('site.single')->withEvent($event);

    }

    public function getProfile(){
        $user = Auth::user();
        return view('pages.profile')->with(['user' => $user]);

     //   return view('pages/profile');
    }




}