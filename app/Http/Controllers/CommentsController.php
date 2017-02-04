<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Event;
use App\User;
use App\Notification;
use Auth;
use Illuminate\Http\Request;
use Session;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $event_id) {
        $this->validate($request, array(
            'comment' => 'required|max:2000',
            //  'username'=> 'required|exists:users,name'
        ));

        $event    = Event::find($event_id);
        $username = Auth::user()->name;

        $comment           = new Comment();
        $comment->comment  = $request->comment;
        $comment->username = $username;
        $comment->event_id = $event_id;
        $comment->save();

        if (Auth::id() === $event->creator_id) {
            foreach ($event->users as $attendant) {
                if ($attendant->id != $event->creator_id) {
                    $notification = new Notification;
                    $notification->user_id = $attendant->id;
                    $notification->ref_id = $event->id;
                    $notification->type = 3;
                    $notification->save();
                }
            }
        }
        else {
            $notification = new Notification;
            $notification->user_id = $event->creator_id;
            $notification->ref_id = $event->id;
            $notification->alt_id = Auth::id();
            $notification->type = 7;
            $notification->save();
        }

        Session::flash('success', 'Your comment was posted!');

        return redirect()->route('events.show', $event_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
