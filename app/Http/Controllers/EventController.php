<?php

namespace App\Http\Controllers;

use App\Event;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\User;
use Image;
use Storage;
use File;

class EventController extends Controller {

    public function __construct() {
        $this->middleware('auth', ['except' => 'show']);
    }

    /** Views Function **/

    // Show My Events
    public function index() {
        $events = Event::where('creator_id', Auth::id())->orderBy('startdate', 'desc')->paginate(20);

        return view('events.index')->with([
            'pageTitle' => 'My Events',
            'events' => $events
        ]);
    }

    // Show Event Detail
    public function show($id) {
        return view('events.show')->with([
            "hero" => "event-detail",
            "event" => Event::find($id)
        ]);
    }

    // Create Event Form
    public function create() {
        return view('events.create')->with([
            'categories' => Category::all(),
            'pageTitle' => 'Create Event'
        ]);
    }

    // Edit Event Form
    public function edit($id) {
        return view('events.edit')->with([
            'event' => Event::find($id),
            'categories' => Category::all(),
            'pageTitle' => 'Edit Event'
        ]);
    }

    /** Back End Functions **/

    // Create Event Function
    public function store(Request $request) {
        // Data Validation
        $this->validate($request, array(
            'title'       => 'required|max:255',
            'location'    => 'required',
            'location_lat'    => 'required',
            'location_lng'    => 'required',
            'startdate'   => 'required|date',
            'starttime'   => 'required',
            'enddate'     => 'required|date|after_or_equal:startdate',
            'endtime'     => 'required',
            'price'       => 'digits_between:0,9999',
            'currency'    => 'required',
            'category_id'    => 'required|integer',
            'description' => 'required',
            'image'       => 'sometimes|image',
        ));

        $event = new Event;
        $event->creator_id = Auth::user()->id;
        $event->title     = $request->title;
        $event->location  = $request->location;
        $event->location_lat  = $request->location_lat;
        $event->location_lng  = $request->location_lng;
        $event->startdate = $request->startdate;
        $event->starttime = $request->starttime;
        $event->enddate   = $request->enddate;
        $event->endtime   = $request->endtime;
        $event->price     = $request->price;
        $event->currency  = $request->currency;
        $event->category_id = $request->category_id;
        $event->description = $request->description;

        if ($request->hasFile('image')) {
            // Make Image
            $image    = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/events/' . $filename);

            // Create New Image
            $newImage = Image::make($image);

            // Resize Image to maintain its aspect ratio
            $thumbSize = 800;
            $aspectRatio = $newImage->width() / $newImage->height();
            if ($aspectRatio >= 1) {
                $newImage->resize($aspectRatio * $thumbSize, $thumbSize);
            }
            else {
                $newImage->resize($thumbSize, $thumbSize / $aspectRatio);
            }

            // Save Image
            $newImage->save($location);

            // Update Event Image
            $event->image = $filename;
        }

        $event->save();

        Session::flash('success', 'The event was successfully saved!');
        return redirect()->route('events.show', $event->id);
    }

    // Edit Event Function
    public function update(Request $request, $id) {
        $this->validate($request, array(
            'title'       => 'required|max:255',
            'location'    => 'required',
            'location_lat'    => 'required',
            'location_lng'    => 'required',
            'startdate'   => 'required|date',
            'starttime'   => 'required',
            'enddate'     => 'required|date|after_or_equal:startdate',
            'endtime'     => 'required',
            'price'       => 'digits_between:0,9999',
            'currency'    => 'required',
            'category_id' => 'required|integer',
            'description' => 'required',
            'image'       => 'sometimes|image',
        ));

        $event = Event::find($id);

        if (!$event) {
            return 'Event not found!';
        }

        $event->title = $request->input('title');
        $event->location = $request->input('location');
        $event->location_lat = $request->input('location_lat');
        $event->location_lng = $request->input('location_lng');
        $event->startdate = $request->input('startdate');
        $event->starttime = $request->input('starttime');
        $event->enddate = $request->input('enddate');
        $event->endtime = $request->input('endtime');
        $event->price = $request->input('price');
        $event->currency = $request->input('currency');
        $event->category_id = $request->input('category_id');
        $event->description = $request->input('description');

        if ($request->hasFile('image')) {
            // Make Image
            $image    = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/events/' . $filename);

            // Create New Image
            $newImage = Image::make($image);

            // Resize Image to maintain its aspect ratio
            $thumbSize = 800;
            $aspectRatio = $newImage->width() / $newImage->height();
            if ($aspectRatio >= 1) {
                $newImage->resize($aspectRatio * $thumbSize, $thumbSize);
            }
            else {
                $newImage->resize($thumbSize, $thumbSize / $aspectRatio);
            }

            // Get old image
            $oldFilename = $event->image;

            // Save Image
            $newImage->save($location);

            // Update Event Image
            $event->image = $filename;

            // Delete old image
            if ($oldFilename == 'cover.jpeg') {
                Storage::delete($oldFilename);
            }
        }

        // Save the event
        $event->save();

        Session::flash('success', 'This post was successfully saved.');
        return redirect()->route('events.show', $event->id);
    }

    // Delete Event
    public function destroy($id) {
        $event = Event::find($id);

        Storage::delete($event->image);
        $event->delete();

        Session::flash('success', 'The event was successfully deleted.');
        return redirect()->route('events.index');
    }

    /** API Functions **/

    // User is attending event
    public function isAttending($id) {
        $event = Event::find($id);
        $user_id = Auth::id();

        if (!$event) {
            return json_encode(array("status" => "error", 'message' => 'The event could not be found.'));
        }

        return json_encode(array("status" => "success", "attending" => $event->attending($user_id)));
    }

    // Toggle user attendance
    public function toggleAttend($id) {
        $event = Event::find($id);
        $user_id = Auth::id();

        $attending = $event->attending($user_id);
        if (!$attending) {
            $event->users()->attach($user_id);
        }
        else {
            $event->users()->detach($user_id);
        }

        return json_encode(array("status" => "success", "attending" => !$attending));
    }
}
