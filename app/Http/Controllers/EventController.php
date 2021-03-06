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
use App\Notification;
use Image;
use Storage;
use File;
use Illuminate\Support\Facades\View;
use DB;
use App\Utils;

class EventController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->middleware(['auth', 'blocked'], ['except' => 'show']);
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

    public function search(Request $request) {
        $query = $request->query();
        $events = Event::all();

        if (array_key_exists('filter-keyword', $query) && $query['filter-keyword'] != "") {
            $events = $events->filter(function($event) use ($query) {
                $keyword = strtolower($query['filter-keyword']);
                $inDesc = strpos(strtolower($event->description), $keyword);
                $inTitle = strpos(strtolower($event->title), $keyword);

                if ($inDesc === false && $inTitle === false) {
                    return false;
                }

                return true;
            });
        }

        if (array_key_exists('filter-price-from', $query) && $query['filter-price-from'] != "") {
            $events = $events->filter(function($event) use ($query) {
                $price = intval($query['filter-price-from']);

                if ($event->price >= $price) {
                    return true;
                }

                return false;
            });
        }

        if (array_key_exists('filter-price-to', $query) && $query['filter-price-to'] != "") {
            $events = $events->filter(function($event) use ($query) {
                $price = intval($query['filter-price-to']);

                if ($event->price <= $price) {
                    return true;
                }

                return false;
            });
        }

        if (array_key_exists('filter-listing-categories', $query) && $query['filter-listing-categories'] != "0") {
            $events = $events->filter(function($event) use ($query) {
                $category = intval($query['filter-listing-categories']);

                if ($event->category_id <= $category) {
                    return true;
                }

                return false;
            });
        }

        return view('events.search')->with([
            'events' => $events,
            'pageTitle' => 'Search Events'
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

        foreach ($event->users as $attendant) {
            if ($attendant->id != $event->creator_id) {
                $notification = new Notification;
                $notification->user_id = $attendant->id;
                $notification->ref_id = $event->id;
                $notification->type = 4;
                $notification->save();
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

        if (Auth::id() !== $event->creator_id && !Auth::user()->isAdmin()) {
            return redirect()->route('events.index');
        }

        Storage::delete($event->image);
        $event->delete();

        Session::flash('success', 'The event was successfully deleted.');
        return redirect()->route('events.index');
    }

    /** API Functions **/

    public function apiSearchEvents(Request $request) {
        $query = $request->query();
        // $events = Event::all();
        $events = Event::activeEvents()->get();

        if (array_key_exists('filter-keyword', $query) && $query['filter-keyword'] != "") {
            $events = $events->filter(function($event) use ($query) {
                $keyword = strtolower($query['filter-keyword']);
                $inDesc = strpos(strtolower($event->description), $keyword);
                $inTitle = strpos(strtolower($event->title), $keyword);

                if ($inDesc === false && $inTitle === false) {
                    return false;
                }

                return true;
            });
        }

        if (array_key_exists('filter-location', $query) && $query['filter-location'] != "") {
            $events = $events->filter(function($event) use ($query) {
                $location = strtolower($query['filter-location']);
                $inLocation = strpos(strtolower($event->location), $location);

                if ($inLocation === false) {
                    return false;
                }

                return true;
            });
        }

        if (array_key_exists('filter-price-from', $query) && $query['filter-price-from'] != "") {
            $events = $events->filter(function($event) use ($query) {
                $price = intval($query['filter-price-from']);

                if ($event->price >= $price) {
                    return true;
                }

                return false;
            });
        }

        if (array_key_exists('filter-price-to', $query) && $query['filter-price-to'] != "") {
            $events = $events->filter(function($event) use ($query) {
                $price = intval($query['filter-price-to']);

                if ($event->price <= $price) {
                    return true;
                }

                return false;
            });
        }

        if (array_key_exists('filter-listing-categories', $query) && $query['filter-listing-categories'] != "0") {
            $events = $events->filter(function($event) use ($query) {
                $category = intval($query['filter-listing-categories']);

                if ($event->category_id === $category) {
                    return true;
                }

                return false;
            });
        }

        if (array_key_exists('filter-event-date-from', $query) && $query['filter-event-date-from'] != "") {
            $events = $events->filter(function($event) use ($query) {
                $dateFrom = $query['filter-event-date-from'];
                $start_string = $event->enddate . " " . $event->endtime;

                if (Utils::dbBefore($dateFrom . ' 00:00:00', $start_string)) {
                    return true;
                }

                return false;
            });
        }

        if (array_key_exists('filter-event-date-to', $query) && $query['filter-event-date-to'] != "") {
            $events = $events->filter(function($event) use ($query) {
                $dateTo = $query['filter-event-date-to'];
                $start_string = $event->startdate . " " . $event->starttime;

                if (Utils::dbBefore($start_string, $dateTo . ' 00:00:00')) {
                    return true;
                }

                return false;
            });
        }

        $events = $events->map(function($event) {
            return $event->toAPIJson();
        });

        return json_encode(array(
            "status" => "success",
            "events" => $events
        ));
    }

    public function apiGetEvent($id) {
        $event = Event::find($id);

        if (!$event) {
            return json_encode(array("status" => "error", 'message' => 'The event could not be found.'));
        }

        return json_encode(array(
            "status" => "success",
            "event" => $event->toAPIJson()
        ));
    }

    public function apiGetEventInArea($area) {
        $directions = array(
            'lat_inf' => explode(',', $area)[0],
            'lat_sup' => explode(',', $area)[1],
            'lng_inf' => explode(',', $area)[2],
            'lng_sup' => explode(',', $area)[3]
        );

        $events = DB::table('events')
            ->whereBetween('location_lat', [$directions['lat_inf'], $directions['lat_sup']])
            ->whereBetween('location_lng', [$directions['lng_inf'], $directions['lng_sup']])
            ->where([
                ['enddate', ">", date('Y-m-d')]
            ])->orWhere(function ($query) {
                $query->where([
                    ['enddate', "=", date('Y-m-d')],
                    ['endtime', ">", date('H:i:s')]
                ]);
            })
            ->orderBy('startdate')
            ->get();

        $events = array_map(function($event) {
            return Event::find($event->id)->toAPIJson();
        }, $events);

        return json_encode(array("status" => "success", "events" => $events));
    }

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

            if ($user_id != $event->creator_id) {
                $notification = new Notification;
                $notification->user_id = $event->creator_id;
                $notification->ref_id = $event->id;
                $notification->alt_id = $user_id;
                $notification->type = 5;
                $notification->save();
            }
        }
        else {
            $event->users()->detach($user_id);

            if ($user_id != $event->creator_id) {
                $notification = new Notification;
                $notification->user_id = $event->creator_id;
                $notification->ref_id = $event->id;
                $notification->alt_id = $user_id;
                $notification->type = 6;
                $notification->save();
            }
        }

        return json_encode(array("status" => "success", "attending" => !$attending));
    }
}
